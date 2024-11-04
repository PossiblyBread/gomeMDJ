<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Information Form</title>
</head>
<body>

<h2>Personal Information Form</h2>

<form action="process.php" method="post">
    <label for="id">ID:</label><br>
    <input type="text" id="id" name="id" required><br><br>

    <label for="serial_num">Serial Number:</label><br>
    <input type="text" id="serial_num" name="serial_num" required><br><br>

    <label for="given_name">Given Name:</label><br>
    <input type="text" id="given_name" name="given_name" required><br><br>

    <label for="middle_name">Middle Name:</label><br>
    <input type="text" id="middle_name" name="middle_name"><br><br>

    <label for="last_name">Last Name:</label><br>
    <input type="text" id="last_name" name="last_name" required><br><br>

    <label for="present_address">Present Address:</label><br>
    <textarea id="present_address" name="present_address" rows="4" required></textarea><br><br>

    <label for="permanent_address">Permanent Address:</label><br>
    <textarea id="permanent_address" name="permanent_address" rows="4" required></textarea><br><br>

    <label for="valid_id">Valid ID:</label><br>
    <input type="text" id="valid_id" name="valid_id" required><br><br>

    <input type="submit" value="Submit">
</form>

</body>
</html>
