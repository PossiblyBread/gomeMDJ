// Sidebar Toggle Functionality
const sideNav = document.querySelector('.side-nav');
const overlay = document.querySelector('#overlay');
const sideNavToggle = document.querySelector('.menu-toggle');
const topNavBtn = document.querySelector('.top-nav-btn');
const profileIcon = document.querySelector('.profile-icon'); // Top Nav Profile Icon
const sidebarProfileIcon = document.getElementById('sidebar-profile-icon'); // Sidebar Profile Icon
const loginModal = document.getElementById('login-modal');

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
    }

    // Check if the profile icon is already moved
    if (!document.querySelector('.side-nav #sidebar-profile-icon')) {
        // Move profile icon
        const profileClone = profileIcon.cloneNode(true);
        profileClone.id = 'sidebar-profile-icon'; // Set the id to maintain consistency
        sideNav.appendChild(profileClone);
    }
}

// Overlay click event to close the sidebar
overlay.addEventListener('click', function() {
    closeSidebar();
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
    openLoginModal();
});

// Profile icon click event to open login modal for sidebar
sidebarProfileIcon.addEventListener('click', function() {
    openLoginModal();
});

// Function to open the login modal
function openLoginModal() {
    loginModal.style.display = "block"; // Show modal
}

// Close the modal when clicking outside of it
window.addEventListener('click', function(event) {
    if (event.target === loginModal || event.target === overlay) {
        loginModal.style.display = "none"; // Close modal when clicking on overlay or modal itself
    }
});
// Toggle the visibility of the long description when "Show More" button is clicked
function toggleDetails(button) {
    const card = button.parentElement;
    const longDescription = card.querySelector('.long-description');
    
    if (longDescription.style.display === 'block') {
        longDescription.style.display = 'none';
        button.textContent = 'Show More';
    } else {
        longDescription.style.display = 'block';
        button.textContent = 'Show Less';
    }
}

