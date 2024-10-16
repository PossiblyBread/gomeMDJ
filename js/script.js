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

// Overlay click event to close the sidebar and modals
overlay.addEventListener('click', function() {
    closeSidebar();
    loginModal.style.display = "none"; // Close login modal
    registerModal.style.display = "none"; // Close registration modal
});

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

// Close modals when clicking on them
window.addEventListener('click', function(event) {
    if (event.target === loginModal) {
        loginModal.style.display = "none"; // Close login modal
    }
    if (event.target === registerModal) {
        registerModal.style.display = "none"; // Close registration modal
    }
});


// Function to handle name tag click
function handleNameTagClick() {
    if (window.innerWidth <= 768) { // Check if the screen is narrow
        openSidebar();
    }
}
