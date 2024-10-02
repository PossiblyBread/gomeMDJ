document.getElementById('confirm-logout').addEventListener('click', () => {
    document.getElementById('logout-form').submit();
});
document.addEventListener('DOMContentLoaded', () => {
    const modals = document.querySelectorAll('.modal');
    const links = document.querySelectorAll('.right-navbar a');
    const closeButtons = document.querySelectorAll('.close-btn');

    function openModal(modalId, contentUrl) {
        const modal = document.getElementById(modalId);
        const modalContent = modal.querySelector('#tickets-content');

        if (contentUrl) {
            fetch(contentUrl)
                .then(response => response.text())
                .then(data => {
                    modalContent.innerHTML = data;
                    modal.style.display = 'block';
                })
                .catch(error => {
                    console.error('Error loading content:', error);
                });
        } else {
            modal.style.display = 'block';
        }
    }

    function closeAllModals() {
        modals.forEach(modal => {
            modal.style.display = 'none';
        });
    }

    links.forEach(link => {
        link.addEventListener('click', (event) => {
            event.preventDefault();
            const modalId = link.getAttribute('data-modal');
            const contentUrl = link.getAttribute('data-url');
            if (modalId) {
                openModal(modalId, contentUrl);
            } else {
                window.location.href = link.href; // Navigate to the href if no modal ID
            }
        });
    });

    closeButtons.forEach(button => {
        button.addEventListener('click', () => {
            closeAllModals();
        });
    });

    window.addEventListener('click', (event) => {
        if (event.target.classList.contains('modal')) {
            closeAllModals();
        }
    });

    document.getElementById('confirm-logout').addEventListener('click', () => {
        document.getElementById('logout-form').submit();
    });

    document.getElementById('cancel-logout').addEventListener('click', () => {
        closeAllModals();
    });
});
