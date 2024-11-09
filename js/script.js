// Sidebar Toggle Functionality
const sideNav = document.querySelector('.side-nav');
const overlay = document.querySelector('#overlay');
const sideNavToggle = document.querySelector('.menu-toggle');
const topNavBtn = document.querySelector('.top-nav-btn');
const profileIcon = document.querySelector('.profile-icon'); // Top Nav Profile Icon
const sidebarProfileIcon = document.getElementById('sidebar-profile-icon'); // Sidebar Profile Icon
const loginModal = document.getElementById('login-modal');
const registerModal = document.getElementById('register-modal');

// Open the sidebar and move top-nav items inside the sidebar
sideNavToggle.addEventListener('click', function() {
    openSidebar();
    moveTopNavItemsToSidebar();
});

// Function to move top-nav items to the sidebar
function moveTopNavItemsToSidebar() {
    // Check if the top-nav buttons are already moved
    if (!document.querySelector('.side-nav .top-nav-btn')) {
        // Move top-nav buttons
        const topNavClone = topNavBtn.cloneNode(true);
        sideNav.appendChild(topNavClone);
        topNavBtn.remove(); // Remove original from top nav
    }

    // Check if the profile icon is already moved
    if (!document.querySelector('.side-nav #sidebar-profile-icon')) {
        // Move profile icon
        const profileClone = profileIcon.cloneNode(true);
        profileClone.id = 'sidebar-profile-icon'; // Set the id to maintain consistency
        sideNav.appendChild(profileClone);
        profileIcon.remove(); // Remove original from top nav
    }
}

// Function to open the sidebar
function openSidebar() {
    sideNav.style.width = "250px";
    overlay.style.display = "block"; // Show overlay when sidebar opens
}

// Function to close the sidebar
function closeSidebar() {
    sideNav.style.width = "0";
    overlay.style.display = "none"; // Hide overlay when sidebar closes
}

// Profile icon click event to open login modal for top nav
profileIcon.addEventListener('click', function() {
    showLoginModal(); // Call the function to show login modal
});

// Profile icon click event to open login modal for sidebar
if (sidebarProfileIcon) {
    sidebarProfileIcon.addEventListener('click', function() {
        showLoginModal(); // Call the function to show login modal
    });
}

// Function to open the login modal and close the sidebar
function showLoginModal() {
    // Close the sidebar if it's open
    if (sideNav.style.width === '250px') { // Adjust width as per your sidebar's open width
        closeSidebar(); // Close the sidebar
    }
    
    // Show the login modal
    loginModal.style.display = 'block';
}

// Function to open the register modal
function showRegisterModal() {
    loginModal.style.display = 'none'; // Hide login modal
    registerModal.style.display = 'block'; // Show registration modal
}

// Function to close the login modal
function closeLoginModal() {
    loginModal.style.display = "none"; // Hide the login modal
}

// Function to handle name tag click
function handleNameTagClick() {
    if (window.innerWidth <= 768) { // Check if the screen is narrow
        openSidebar();
    }
}

// Login form handling
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('login-form');
    if (loginForm) {
        loginForm.addEventListener('submit', handleLoginSubmission);
    }

    // Close button handlers
    const loginClose = document.querySelector('.login-close');
    if (loginClose) {
        loginClose.onclick = hideLoginModal;
    }
});

function handleLoginSubmission(e) {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    
    fetch('Login.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log('Login response:', data); // Debug log
        if (data.status === 'success') {
            // Hide login form content
            document.getElementById('login-form-content').style.display = 'none';
            // Show OTP form
            document.getElementById('otp-form').style.display = 'block';
            // Request OTP
            requestOtp();
        } else {
            alert(data.message || 'Login failed');
        }
    })
    .catch(error => {
        console.error('Login error:', error);
        alert('An error occurred during login. Please try again.');
    });
}

// Modal handling functions
function showLoginModal() {
    const loginModal = document.getElementById('login-modal');
    loginModal.style.display = 'block';
    // Reset form display states
    document.getElementById('login-form-content').style.display = 'block';
    document.getElementById('otp-form').style.display = 'none';
}

function hideLoginModal() {
    document.getElementById('login-modal').style.display = 'none';
}

function backToLoginForm() {
    document.getElementById('login-form-content').style.display = 'block';
    document.getElementById('otp-form').style.display = 'none';
}
