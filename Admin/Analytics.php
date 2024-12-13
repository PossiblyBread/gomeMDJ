<?php
session_start();
if (!isset($_SESSION['id'])) {
    http_response_code(403); // Forbidden
    exit("Access denied");
}

include_once "../db_conn.php";

// Fetch user details from session
$userFirstName = $_SESSION['first_name'] ?? '';
$userLastName = $_SESSION['last_name'] ?? '';
$userId = $_SESSION['id'] ?? '';

// Function to fetch ticket data for a specific date or all tickets
function fetchTicketData($dateFilter = null)
{
    global $conn;
    // If a date filter is provided, adjust the query to select tickets for that date.
    $query = "SELECT t_status, type, serial_num, date_time_created FROM tickets";
    if ($dateFilter) {
        $query .= " WHERE DATE(date_time_created) = '$dateFilter'"; // Filter by specific date
    }
    $result = $conn->query($query);

    $data = [
        'status_serials' => [
            'new' => [],
            'Open' => [],
            'Pending' => [],
            'Active' => [],
            'Closed' => [],
            'Failed' => []
        ],
        'type_counts' => [
            'new' => ['Technical' => 0, 'Mechanical' => 0, 'Billing' => 0, 'Assistance Request' => 0],
            'Open' => ['Technical' => 0, 'Mechanical' => 0, 'Billing' => 0, 'Assistance Request' => 0],
            'Pending' => ['Technical' => 0, 'Mechanical' => 0, 'Billing' => 0, 'Assistance Request' => 0],
            'Active' => ['Technical' => 0, 'Mechanical' => 0, 'Billing' => 0, 'Assistance Request' => 0],
            'Closed' => ['Technical' => 0, 'Mechanical' => 0, 'Billing' => 0, 'Assistance Request' => 0],
            'Failed' => ['Technical' => 0, 'Mechanical' => 0, 'Billing' => 0, 'Assistance Request' => 0],
        ]
    ];

    // Process the results and aggregate data
    while ($row = $result->fetch_assoc()) {
        $status = $row['t_status'];
        $type = $row['type'];
        $serial_num = $row['serial_num'];

        if (array_key_exists($status, $data['status_serials'])) {
            $data['status_serials'][$status][] = $serial_num;
            if (isset($data['type_counts'][$status][$type])) {
                $data['type_counts'][$status][$type]++;
            }
        }
    }

    return $data;
}

// If a date filter is passed via AJAX request, fetch and return the filtered ticket data
if (isset($_GET['dateFilter'])) {
    $dateFilter = $_GET['dateFilter'];
    echo json_encode(fetchTicketData($dateFilter)); // Return the data as JSON
    exit;
}

// Fetch ticket data for the default view
$ticketData = fetchTicketData();
$status_serials = $ticketData['status_serials'];
$type_counts = $ticketData['type_counts'];
$totalTickets = array_sum(array_map('count', $status_serials));

// Close the database connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Analytics Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
</head>

<body>
    <?php include 'side-nav.php'; ?>

    <div class="container">
        <h1>Ticket Analytics Dashboard</h1>

        <!-- Calendar Section -->
        <div class="calendar-container">
            <div class="calendar-header">
                <button id="prev-month">Prev</button>
                <span id="current-month"></span>
                <button id="next-month">Next</button>
            </div>
            <div class="calendar-body">
                <div class="calendar-days-header">
                    <div>Sun</div>
                    <div>Mon</div>
                    <div>Tue</div>
                    <div>Wed</div>
                    <div>Thu</div>
                    <div>Fri</div>
                    <div>Sat</div>
                </div>
                <div class="calendar-days" id="calendar-days"></div>
            </div>
        </div>

        <!-- Filtered Tickets Section -->
        <div class="dashboard" id="dashboard">
            <?php
            $statuses = ['new', 'Open', 'Pending', 'Active', 'Closed', 'Failed'];
            foreach ($statuses as $status) :
            ?>
                <div class="status-card <?= strtolower($status) ?>" id="card-<?= strtolower($status) ?>">
                    <h2><?= count($status_serials[$status]) ?></h2>
                    <strong><?= $status ?> Tickets</strong>
                    <hr>
                    <ul id="list-<?= strtolower($status) ?>">
                        <?php foreach ($status_serials[$status] as $serial) : ?>
                            <li><?= $serial ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="ticket-types">
            <h3>Ticket Types Summary</h3>
            <table class="ticket-summary-table">
                <thead>
                    <tr>
                        <th>Departments</th>
                        <th>New</th>
                        <th>Open</th>
                        <th>Pending</th>
                        <th>Active</th>
                        <th>Closed</th>
                        <th>Failed</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $departments = ['Technical', 'Mechanical', 'Billing', 'Assistance Request'];
                    foreach ($departments as $department) :
                    ?>
                        <tr>
                            <td><strong><?= $department ?></strong></td>
                            <?php
                            $total = 0;
                            foreach ($statuses as $status) :
                                $count = $type_counts[$status][$department] ?? 0;
                                $total += $count;
                            ?>
                                <td><?= $count ?></td>
                            <?php endforeach; ?>
                            <td><?= $total ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <p>Total Number of Tickets: <strong><?= $totalTickets ?></strong></p>
        </div>

        <div class="chart-container">
            <canvas id="ticketChart"></canvas>
        </div>
    </div>

    <script>
        // Initialize moment.js with the current month
        let currentMonth = moment();
        const calendarDays = document.getElementById('calendar-days');
        const currentMonthElement = document.getElementById('current-month');

        // Function to render the calendar based on the current month
        function renderCalendar() {
            // Get the start and end of the month
            const startOfMonth = currentMonth.startOf('month');
            const endOfMonth = currentMonth.endOf('month');
            const daysInMonth = currentMonth.daysInMonth();
            const startDayOfWeek = startOfMonth.day();

            // Clear the previous days
            calendarDays.innerHTML = '';
            currentMonthElement.innerText = currentMonth.format('MMMM YYYY');

            // Add blank cells before the first day of the month
            for (let i = 0; i < startDayOfWeek; i++) {
                const blankCell = document.createElement('div');
                calendarDays.appendChild(blankCell);
            }

            // Render the actual days of the month
            for (let day = 1; day <= daysInMonth; day++) {
                const dayElement = document.createElement('div');
                dayElement.classList.add('calendar-day');
                dayElement.innerText = day;
                dayElement.setAttribute('data-date', currentMonth.format('YYYY-MM-') + (day < 10 ? '0' : '') + day);

                // Add an event listener to each day to filter tickets by that date
                dayElement.addEventListener('click', function() {
                    filterTicketsByDate(dayElement.getAttribute('data-date'));
                });

                calendarDays.appendChild(dayElement);
            }
        }

        // Function to move to the next month
        function nextMonth() {
            currentMonth.add(1, 'month'); // Increase month by 1
            renderCalendar(); // Re-render the calendar for the new month
        }

        // Function to move to the previous month
        function prevMonth() {
            currentMonth.subtract(1, 'month'); // Decrease month by 1
            renderCalendar(); // Re-render the calendar for the new month
        }

        // Function to filter tickets by date (using AJAX)
        function filterTicketsByDate(date) {
            fetch(`?dateFilter=${date}`)
                .then(response => response.json())
                .then(data => {
                    updateDashboard(data); // Update the dashboard with filtered ticket data
                });
        }

        // Function to update the dashboard with filtered tickets
        function updateDashboard(data) {
            Object.keys(data.status_serials).forEach(status => {
                const card = document.getElementById(`card-${status.toLowerCase()}`);
                const list = document.getElementById(`list-${status.toLowerCase()}`);
                const count = data.status_serials[status].length;
                card.querySelector('h2').innerText = count;

                // Clear the current list and populate with filtered serial numbers
                list.innerHTML = '';
                data.status_serials[status].forEach(serial => {
                    const listItem = document.createElement('li');
                    listItem.innerText = serial;
                    list.appendChild(listItem);
                });
            });
        }

        // Add event listeners to the Previous and Next buttons
        document.getElementById('prev-month').addEventListener('click', prevMonth);
        document.getElementById('next-month').addEventListener('click', nextMonth);

        // Render the calendar initially
        renderCalendar();
    </script>
    <script>
        // Data for the pie chart
        var ctx = document.getElementById('ticketChart').getContext('2d');

        // Calculate total tickets for percentages
        var totalTickets = <?php echo count($status_serials['new']) + count($status_serials['Open']) + count($status_serials['Pending']) + count($status_serials['Active']) + count($status_serials['Closed']) + count($status_serials['Failed']); ?>;

        var ticketChart = new Chart(ctx, {
            type: 'pie', // Changed to 'pie' type
            data: {
                labels: ['New', 'Open', 'Pending', 'Active', 'Closed', 'Failed'], // Added 'Failed' to labels
                datasets: [{
                    label: 'Ticket Counts by Status',
                    data: [
                        <?php echo count($status_serials['new']); ?>, // New Tickets count
                        <?php echo count($status_serials['Open']); ?>, // Open Tickets count
                        <?php echo count($status_serials['Pending']); ?>, // Pending Tickets count
                        <?php echo count($status_serials['Active']); ?>, // Active Tickets count
                        <?php echo count($status_serials['Closed']); ?>, // Closed Tickets count
                        <?php echo count($status_serials['Failed']); ?> // Failed Tickets count
                    ],
                    backgroundColor: [
                        'rgba(52, 152, 219, 0.7)', // New
                        'rgba(46, 204, 113, 0.7)', // Open
                        'rgba(241, 196, 15, 0.7)', // Pending
                        'rgba(231, 76, 60, 0.7)', // Active
                        'rgba(155, 89, 182, 0.7)', // Closed
                        'rgba(52, 73, 94, 0.7)' // Failed (New color for failed)
                    ],
                    borderColor: [
                        'rgba(52, 152, 219, 1)',
                        'rgba(46, 204, 113, 1)',
                        'rgba(241, 196, 15, 1)',
                        'rgba(231, 76, 60, 1)',
                        'rgba(155, 89, 182, 1)',
                        'rgba(52, 73, 94, 1)' // Failed border color
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                var label = tooltipItem.label;
                                var value = tooltipItem.raw;
                                var percentage = ((value / totalTickets) * 100).toFixed(2); // Calculate percentage
                                return label + ': ' + value + ' tickets (' + percentage + '%)'; // Show ticket count with percentage
                            }
                        }
                    },
                    datalabels: {
                        formatter: function(value, ctx) {
                            var percentage = ((value / totalTickets) * 100).toFixed(2); // Calculate percentage
                            return percentage + '%'; // Display percentage
                        },
                        color: '#fff',
                        font: {
                            weight: 'bold',
                            size: 16
                        },
                        anchor: 'center',
                        align: 'center'
                    },
                    legend: {
                        position: 'top',
                    }
                }
            }
        });
    </script>
</body>

</html>


<style>
    /* General Reset */
    * {
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f4f7fa;
        padding: 20px;
        margin-left: 200px;
        /* Adjusted left margin to account for sidebar */
        color: #333;
    }

    h1 {
        text-align: center;
        color: #333;
        font-size: 2rem;
        margin-bottom: 30px;
    }

    .container {
        width: 65%;
        margin: 0 auto;
        padding-top: 20px;
    }

    /* Dashboard Section */
    .dashboard {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        /* 3 cards per row */
        gap: 20px;
        margin-top: 30px;
    }

    .status-card {
        background-color: #fff;
        border-radius: 12px;
        padding: 25px;
        text-align: center;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease-in-out;
        height: auto;
    }

    .status-card:hover {
        transform: translateY(-10px);
        /* Slight hover effect */
    }

    .status-card h2 {
        font-size: 3rem;
        color: #333;
        margin-bottom: 10px;
    }

    .status-card strong {
        font-size: 1.2rem;
        color: #555;
    }

    .status-card hr {
        border: 0;
        height: 2px;
        background-color: #ddd;
        margin: 10px 0;
    }

    .status-card ul {
        list-style-type: none;
        padding: 0;
        margin-top: 10px;
        font-size: 14px;
        text-align: left;
        max-height: 150px;
        overflow-y: auto;
    }

    .status-card ul li {
        margin-bottom: 5px;
        color: #333;
    }

    /* Color Coding for Different Statuses */
    .new {
        background-color: #9fb7db;
    }

    .open {
        background-color: #a5d6a7;
    }

    .pending {
        background-color: #f1c40fb3;
    }

    .active {
        background-color: #e57373;
    }

    .closed {
        background-color: #ab77cc;
    }

    .failed {
        background-color: #95a5a6;
    }

    /* Chart Container */
    .chart-container {
        width: 80%;
        margin: 30px auto;
        padding: 30px;
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    }

    canvas {
        width: 100% !important;
        height: 400px;
    }

    /* Ticket Types Section */
    .ticket-types {
        margin-top: 40px;
        padding: 30px;
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        width: 100%;
    }

    .ticket-types h3 {
        margin-top: 0;
        font-size: 1.8rem;
        text-align: center;
        color: #333;
    }

    .ticket-summary-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .ticket-summary-table th,
    .ticket-summary-table td {
        padding: 12px;
        text-align: center;
        border: 1px solid #ddd;
    }

    .ticket-summary-table th {
        background-color: #f1f1f1;
        font-weight: bold;
        color: #555;
    }

    .ticket-summary-table td {
        background-color: #fff;
        color: #555;
    }

    .ticket-summary-table tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .ticket-summary-table tr:hover {
        background-color: #f1f1f1;
    }

    .ticket-summary-table td strong {
        font-weight: bold;
    }

    /* Small screen and responsiveness */
    @media (max-width: 768px) {
        .dashboard {
            grid-template-columns: 1fr;
            /* Stack cards on smaller screens */
        }

        .status-card {
            width: 80%;
            /* Ensures cards are stacked on smaller screens */
            margin-bottom: 20px;
        }

        .ticket-types {
            padding: 20px;
        }

        .ticket-summary-table th,
        .ticket-summary-table td {
            font-size: 14px;
        }
    }

    /* Calendar Styling */
    .calendar-container {
        max-width: 800px;
        margin: 20px auto;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 8px;
        background-color: #f9f9f9;
    }

    .calendar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 18px;
        margin-bottom: 10px;
    }

    .calendar-body {
        display: flex;
        flex-direction: column;
    }

    .calendar-days-header {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        text-align: center;
        font-weight: bold;
        background-color: #ececec;
        padding: 5px 0;
    }

    .calendar-days {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 5px;
        padding: 10px 0;
    }

    .calendar-day {
        padding: 10px;
        text-align: center;
        cursor: pointer;
        background-color: #fff;
        border-radius: 4px;
        transition: background-color 0.2s ease;
    }

    .calendar-day:hover {
        background-color: #e0e0e0;
    }
</style>