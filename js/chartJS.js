

// Initialize the chart as empty
let ctx = document.getElementById('sales_chart').getContext('2d');
let chart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: [],
        datasets: [
            { label: 'Sales', data: [], borderColor: '#34701d', borderWidth: 1, fill: false },
            { label: 'Collectibles', data: [], borderColor: '#C40C0C', borderWidth: 1, fill: false }
        ]
    },
    options: {
        scales: { y: { beginAtZero: true } },
        plugins: {
            legend: { display: true },
            tooltip: { enabled: true }
        }
    }
});

// Fetch and update chart data
function updateChart() {
    const selectedYear = document.getElementById('year_selection').value;
    const selectedPeriod = document.getElementById('sales_selection').value;

    fetch(`../php/chart_analytics.php?year=${selectedYear}&period=${selectedPeriod}`)
        .then(response => response.json())
        .then(data => {
            let labels = [];
            let salesData = [];
            let collectiblesData = [];

            if (selectedPeriod === 'annually') {
                labels.push(selectedYear);
                salesData.push(data[0]?.total_sales || 0);
                collectiblesData.push(data[0]?.total_collectibles || 0);
            } else if (selectedPeriod === 'monthly') {
                data.forEach(item => {
                    labels.push(item.month_name);  // Get month names directly from PHP data
                    salesData.push(item.total_sales || 0);
                    collectiblesData.push(item.total_collectibles || 0);
                });
            } else if (selectedPeriod === 'weekly') {
                data.forEach(item => {
                    labels.push(`Week ${item.week}`);
                    salesData.push(item.total_sales || 0);
                    collectiblesData.push(item.total_collectibles || 0);
                });
            }

            chart.data.labels = labels;
            chart.data.datasets[0].data = salesData;
            chart.data.datasets[1].data = collectiblesData;
            chart.update();
        })
        .catch(error => console.error("Error fetching data:", error));
}



// Event listeners
document.getElementById('sales_selection').addEventListener('change', updateChart);
document.getElementById('year_selection').addEventListener('change', updateChart);

// Initialize year dropdown
const yearDropdown = document.getElementById('year_selection');
const currentYear = new Date().getFullYear();
const startYear = 2020;
for (let year = currentYear; year >= startYear; year--) {
    const option = document.createElement('option');
    option.value = year;
    option.text = year;
    yearDropdown.appendChild(option);
}

// Set default year and update chart
document.getElementById('year_selection').value = currentYear;
updateChart();