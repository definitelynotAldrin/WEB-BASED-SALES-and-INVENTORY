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


const ctx = document.getElementById('sales_chart').getContext('2d');
        
// Initial data
const annualData = {
    labels: ['2020', '2021', '2022', '2023'],
    datasets: [
        {
            label: 'Sales',
            data: [120000, 190000, 350000, 550000],
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1,
            fill: false
        },
        {
            label: 'Collectibles',
            data: [50000, 100000, 150000, 200000],
            borderColor: 'rgba(153, 102, 255, 1)',
            borderWidth: 1,
            fill: false
        }
    ]
};

const monthlyData = {
    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'],
    datasets: [
        {
            label: 'Sales',
            data: [12000, 19000, 35000, 55000, 20000, 30000, 50000, 40000, 45000, 55000, 10000, 14000],
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1,
            fill: false
        },
        {
            label: 'Collectibles',
            data: [5000, 10000, 15000, 20000, 25000, 30000, 35000, 40000, 45000, 50000, 55000, 60000],
            borderColor: 'rgba(153, 102, 255, 1)',
            borderWidth: 1,
            fill: false
        }
    ]
};

const weeklyData = {
    labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
    datasets: [
        {
            label: 'Sales',
            data: [3000, 5000, 7000, 9000],
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1,
            fill: false
        },
        {
            label: 'Collectibles',
            data: [1000, 2000, 3000, 4000],
            borderColor: 'rgba(153, 102, 255, 1)',
            borderWidth: 1,
            fill: false
        }
    ]
};

let chart = new Chart(ctx, {
    type: 'line',
    data: annualData,
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

document.getElementById('sales_selection').addEventListener('change', function() {
    const selectedValue = this.value;
    let newData;

    if (selectedValue === 'annually') {
        newData = annualData;
    } else if (selectedValue === 'monthly') {
        newData = monthlyData;
    } else if (selectedValue === 'weekly') {
        newData = weeklyData;
    }

    // Update chart data
    chart.data = newData;
    chart.update();
});