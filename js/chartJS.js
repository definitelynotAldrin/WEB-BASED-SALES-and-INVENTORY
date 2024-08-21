// const ctx = document.getElementById('sales_chart').getContext('2d');

// new Chart(ctx, {
//     type: 'line',
//     data: {
//         labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'],
//         datasets: [
//             {
//                 label: 'Sales',
//                 data: [12000, 19000, 35000, 55000, 20000, 30000, 50000, 40000, 45000, 55000, 10000, 14000],
//                 borderColor: '#34701d',
//                 borderWidth: 1,
//                 fill: false
//             },
//             {
//                 label: 'Collectibles',
//                 data: [5000, 1000, 15000, 20000, 25000, 3000, 35000, 20000, 45000, 2000, 55000, 30000],
//                 borderColor: '#C40C0C',
//                 borderWidth: 1,
//                 fill: false
//             }
//         ]
//     },
//     options: {
//         scales: {
//             y: {
//                 beginAtZero: true
//             }
//         }
//     }
// });


// const ctx = document.getElementById('sales_chart').getContext('2d');
        
// // Initial data
// const annualData = {
//     labels: ['2020', '2021', '2022', '2023'],
//     datasets: [
//         {
//             label: 'Sales',
//             data: [120000, 190000, 350000, 550000],
//             borderColor: '#34701d',
//             borderWidth: 1,
//             fill: false
//         },
//         {
//             label: 'Collectibles',
//             data: [50000, 100000, 150000, 200000],
//             borderColor: '#C40C0C',
//             borderWidth: 1,
//             fill: false
//         }
//     ]
// };

// const monthlyData = {
//     labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'],
//     datasets: [
//         {
//             label: 'Sales',
//             data: [12000, 19000, 35000, 55000, 20000, 30000, 50000, 40000, 45000, 55000, 10000, 14000],
//             borderColor: '#34701d',
//             borderWidth: 1,
//             fill: false
//         },
//         {
//             label: 'Collectibles',
//             data: [5000, 10000, 15000, 20000, 25000, 30000, 35000, 40000, 45000, 50000, 55000, 60000],
//             borderColor: '#C40C0C',
//             borderWidth: 1,
//             fill: false
//         }
//     ]
// };

// const weeklyData = {
//     labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
//     datasets: [
//         {
//             label: 'Sales',
//             data: [3000, 5000, 7000, 9000],
//             borderColor: '#34701d',
//             borderWidth: 1,
//             fill: false
//         },
//         {
//             label: 'Collectibles',
//             data: [1000, 2000, 3000, 4000],
//             borderColor: '#C40C0C',
//             borderWidth: 1,
//             fill: false
//         }
//     ]
// };

// let chart = new Chart(ctx, {
//     type: 'line',
//     data: annualData,
//     options: {
//         scales: {
//             y: {
//                 beginAtZero: true
//             }
//         }
//     }
// });

// document.getElementById('sales_selection').addEventListener('change', function() {
//     const selectedValue = this.value;
//     let newData;

//     if (selectedValue === 'annually') {
//         newData = annualData;
//     } else if (selectedValue === 'monthly') {
//         newData = monthlyData;
//     } else if (selectedValue === 'weekly') {
//         newData = weeklyData;
//     }

//     // Update chart data
//     chart.data = newData;
//     chart.update();
// });


const ctx = document.getElementById('sales_chart').getContext('2d');

// Example data
const data = {
    '2024': {
        annually: { // Use "annually" for consistency
            labels: ['2024'],
            datasets: [
                {
                    label: 'Sales',
                    data: [120000],
                    borderColor: '#34701d',
                    borderWidth: 1,
                    fill: false
                },
                {
                    label: 'Collectibles',
                    data: [50000],
                    borderColor: '#C40C0C',
                    borderWidth: 1,
                    fill: false
                }
            ]
        },
        monthly: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'],
            datasets: [
                {
                    label: 'Sales',
                    data: [40000, 38000, 55000, 29000, 35000, 38000, 25000, 58000, 39000, 30000, 29000, 28000],
                    borderColor: '#34701d',
                    borderWidth: 1,
                    fill: false
                },
                {
                    label: 'Collectibles',
                    data: [2000, 3000, 4000, 3000, 6000, 7000, 5000, 3000, 7000, 8000, 1000, 3000],
                    borderColor: '#C40C0C',
                    borderWidth: 1,
                    fill: false
                }
            ]
        },
        weekly: {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            datasets: [
                {
                    label: 'Sales',
                    data: [15000, 20000, 18000, 23000],
                    borderColor: '#34701d',
                    borderWidth: 1,
                    fill: false
                },
                {
                    label: 'Collectibles',
                    data: [2000, 1500, 5000, 3500],
                    borderColor: '#C40C0C',
                    borderWidth: 1,
                    fill: false
                }
            ]
        }
    },
    '2023': {
        annually: {
            labels: ['2023'],
            datasets: [
                {
                    label: 'Sales',
                    data: [190000],
                    borderColor: '#34701d',
                    borderWidth: 1,
                    fill: false
                },
                {
                    label: 'Collectibles',
                    data: [100000],
                    borderColor: '#C40C0C',
                    borderWidth: 1,
                    fill: false
                }
            ]
        },
        monthly: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'],
            datasets: [
                {
                    label: 'Sales',
                    data: [15000, 16000, 17000, 18000, 19000, 20000, 21000, 22000, 23000, 24000, 25000, 26000],
                    borderColor: '#34701d',
                    borderWidth: 1,
                    fill: false
                },
                {
                    label: 'Collectibles',
                    data: [3000, 4000, 5000, 6000, 7000, 8000, 9000, 10000, 11000, 12000, 13000, 14000],
                    borderColor: '#C40C0C',
                    borderWidth: 1,
                    fill: false
                }
            ]
        },
        weekly: {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            datasets: [
                {
                    label: 'Sales',
                    data: [4000, 5000, 6000, 7000],
                    borderColor: '#34701d',
                    borderWidth: 1,
                    fill: false
                },
                {
                    label: 'Collectibles',
                    data: [1500, 2000, 2500, 3000],
                    borderColor: '#C40C0C',
                    borderWidth: 1,
                    fill: false
                }
            ]
        }
    }
    // Add more years as needed
};

// Initialize chart
let chart = new Chart(ctx, {
    type: 'line',
    data: data['2024'].annually, // Set initial data to 2024 annually
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Function to update chart based on user selection
function updateChart() {
    const selectedYear = document.getElementById('year_selection').value;
    const selectedPeriod = document.getElementById('sales_selection').value;

    chart.data = data[selectedYear][selectedPeriod];
    chart.update();
}

// Event listeners for dropdowns
document.getElementById('sales_selection').addEventListener('change', updateChart);
document.getElementById('year_selection').addEventListener('change', updateChart);

// Generate year dropdown options
const yearDropdown = document.getElementById('year_selection');
const currentYear = new Date().getFullYear();
const startYear = 2020; // Change this to whatever year you want to start from

for (let year = currentYear; year >= startYear; year--) {
    const option = document.createElement('option');
    option.value = year;
    option.text = year;
    yearDropdown.appendChild(option);
}
