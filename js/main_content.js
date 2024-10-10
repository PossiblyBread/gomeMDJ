document.addEventListener('DOMContentLoaded', () => {
    const items = document.querySelectorAll('.carousel-item');
    const prevButton = document.querySelector('.carousel-prev');
    const nextButton = document.querySelector('.carousel-next');
    const grid = document.querySelector('.carousel-grid');
    const totalItems = items.length;
    let currentIndex = 0;

    // Show the initial items
    function showItems(index) {
        // Calculate the translateX value based on the current index
        const offset = -index * 100; // Each item takes full width
        grid.style.transform = `translateX(${offset}%)`;

        items.forEach(item => item.classList.remove('active'));
        items[index].classList.add('active'); // Only show the current item
    }

    nextButton.addEventListener('click', () => {
        currentIndex = (currentIndex + 1) % totalItems; // Loop back to the start
        showItems(currentIndex);
    });

    prevButton.addEventListener('click', () => {
        currentIndex = (currentIndex - 1 + totalItems) % totalItems; // Loop to the end
        showItems(currentIndex);
    });

    // Initialize the display
    showItems(currentIndex);
});
