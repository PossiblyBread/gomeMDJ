document.addEventListener('DOMContentLoaded', function () {
    const toggleButtons = document.querySelectorAll('.show-button');

    toggleButtons.forEach(button => {
        button.addEventListener('click', function () {
            const expandableContent = this.closest('tr').nextElementSibling;
            if (expandableContent.style.display === 'none') {
                expandableContent.style.display = 'table-row';
                this.textContent = 'Hide';
            } else {
                expandableContent.style.display = 'none';
                this.textContent = 'Show';
            }
        });
    });
});
