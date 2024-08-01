document.addEventListener('DOMContentLoaded', function() {
    const menuCategory = document.getElementById('menu_insert_category');
    const dishForm = document.querySelector('.inserting-dish-form');
    const dessertForm = document.querySelector('.inserting-dessert-form');
    const beveragesForm = document.querySelector('.inserting-beverages-form');


    menuCategory.addEventListener('change', function() {
        const selectedCategory = menuCategory.value;

        // Display the selected form
        if (selectedCategory === 'main-course') {
            dishForm.style.display = 'flex';
            dessertForm.style.display = 'none';
            beveragesForm.style.display = 'none';
        } else if (selectedCategory === 'dessert') {
            dessertForm.style.display = 'flex';
            dishForm.style.display = 'none';
            beveragesForm.style.display = 'none';
        } else if (selectedCategory === 'beverages') {
            beveragesForm.style.display = 'flex';
            dishForm.style.display = 'none';
            dessertForm.style.display = 'none';
        }
    });
});