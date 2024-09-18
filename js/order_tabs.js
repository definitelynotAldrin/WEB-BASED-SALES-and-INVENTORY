document.addEventListener('DOMContentLoaded', function() {
    const orderTabs = document.querySelectorAll('.tabs-category');
    const firstPanel = document.querySelector('.first-panel-section');
    const secondPanel = document.querySelector('.second-panel-section');
    const thirdPanel = document.querySelector('.third-panel-section');
    const btnPrepare = document.querySelectorAll('.buttonPrepare');
    const btnProcess = document.querySelectorAll('.buttonProcess');
    const btnServed = document.querySelectorAll('.buttonServed');

    btnPrepare.forEach(function(prepare) {
        prepare.addEventListener('click', function() {
            firstPanel.style.display = 'block';
            secondPanel.style.display = 'none';
            thirdPanel.style.display = 'none';
            // prepare.classList.add('activeBtn');
            // btnProcess.classList.remove('activeBtn');
            // btnServed.classList.remove('activeBtn');
        });

    });

    btnProcess.forEach(function(process) {
        process.addEventListener('click', function() {
            secondPanel.style.display = 'block';
            firstPanel.style.display = 'none';
            thirdPanel.style.display = 'none';
            // process.classList.add('activeBtn');
            // btnPrepare.classList.remove('activeBtn');
            // btnServed.classList.remove('activeBtn');
        });
       
    });

    btnServed.forEach(function(served) {
        served.addEventListener('click', function() {
            thirdPanel.style.display = 'block';
            firstPanel.style.display = 'none';
            secondPanel.style.display = 'none';
            // served.classList.add('activeBtn');
            // btnPrepare.classList.remove('activeBtn');
            // btnProcess.classList.remove('activeBtn');
        });
    });
});


// document.addEventListener('DOMContentLoaded', function() {
//     const tabSelectors = document.querySelectorAll('.tabs-category'); // Select all the dropdowns
//     const firstPanel = document.querySelector('.first-panel-section');
//     const secondPanel = document.querySelector('.second-panel-section');
//     const thirdPanel = document.querySelector('.third-panel-section');

//     // Function to update the visibility of the panels based on the selected option
//     function updatePanel(selectedCategory) {
//         // Hide all panels initially

//         // Display the corresponding panel based on the selected category
//         if (selectedCategory === 'prepare') {
//             firstPanel.style.display = 'block';
//             secondPanel.style.display = 'none';
//             thirdPanel.style.display = 'none';
//         } else if (selectedCategory === 'process') {
//             secondPanel.style.display = 'block';
//             firstPanel.style.display = 'none';
//             thirdPanel.style.display = 'none';
//         } else if (selectedCategory === 'served') {
//             thirdPanel.style.display = 'block';
//             firstPanel.style.display = 'none';
//             secondPanel.style.display = 'none';
//         }
//     }

//     // Add event listeners to each dropdown
//     tabSelectors.forEach(function(selector) {
//         selector.addEventListener('change', function() {
//             const selectedCategory = this.value; // Get the selected value
//             updatePanel(selectedCategory); // Update the panel visibility
//         });
//     });

//     // Initial load: Set the correct panel based on the first dropdown's value
//     const initialCategory = tabSelectors[0].value;
//     updatePanel(initialCategory);
// });
