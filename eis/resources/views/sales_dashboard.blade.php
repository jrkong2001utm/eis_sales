@extends('template')
@section('sales_dashboard')

<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Container-->
    <div class="container-xxl" style="width: 1100px" id="kt_content_container">

  <div class="row">
    <div class="col-md-6 grid-margin transparent">
        <div class="row">
            <div class="col-md-6 mb-4 stretch-card transparent">
                <div class="card card-tale">
                    <div class="card-body">
                        <p class="mb-4">Total Bookings</p>
                        <p class="fs-30 mb-2 mdi mdi-hotel">  </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4 stretch-card transparent">
                <div class="card card-dark-blue">
                    <div class="card-body">
                        <p class="mb-4">Total Rooms Available</p>
                        <p class="fs-30 mb-2 mdi mdi-home-map-marker">  </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 grid-margin transparent">
        <div class="row">
            <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                <div class="card card-light-blue">
                    <div class="card-body">
                        <p class="mb-4">Total Inflow</p>
                        <p class="fs-30 mb-2">  RM </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 stretch-card transparent">
                <div class="card card-light-danger">
                    <div class="card-body">
                        <p class="mb-3">Total Active Investor</p>
                        <p class="fs-30 mb-2 mdi mdi-account-multiple-outline">  </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div class="div"></div>


        <canvas id="lineChart"></canvas>
        <canvas id="lineChart2"></canvas>

        <script>
    document.addEventListener('DOMContentLoaded', function() {
        var orders = @json($orders);

        // Prepare data for the chart
        var datasets = [];
        var labels = [];
        var colors = ['red', 'blue', 'green']; // Add more colors for different product types

        orders.forEach(function(order, index) {
            var dataset = datasets.find(function(d) {
                return d.label === order.product;
            });

            if (!dataset) {
                dataset = {
                    label: order.product,
                    data: [],
                    borderColor: colors[index % colors.length],
                    fill: false
                };
                datasets.push(dataset);
            }

            dataset.data.push(order.total_sales);
            labels.push(order.month);
        });

        // Create the line chart
        var ctx = document.getElementById('lineChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: datasets
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Month'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Total Sales'
                        }
                    }
                }
            }
        });
    });

var orders = {!! json_encode($orders) !!};

// Extract the unique products
var products = Array.from(new Set(orders.map(order => order.product)));

// Initialize datasets array
var datasets = [];

// Generate a random color for each product
var colors = generateRandomColors(products.length);

// Prepare the data for each product
products.forEach((product, index) => {
    var data = orders.filter(order => order.product === product)
                     .map(order => order.total_profit);

    // Create a dataset for each product
    datasets.push({
        label: product,
        data: data,
        borderColor: colors[index],
        backgroundColor: 'transparent',
        pointBackgroundColor: colors[index],
        pointBorderColor: '#fff',
        pointHoverBackgroundColor: colors[index],
        pointHoverBorderColor: colors[index],
    });
});

// Create the line chart
var ctx = document.getElementById('lineChart').getContext('2d');
var lineChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: orders.map(order => order.month),
        datasets: datasets,
    },
    options: {
        responsive: true,
        scales: {
            x: {
                display: true,
                title: {
                    display: true,
                    text: 'Month',
                },
            },
            y: {
                display: true,
                title: {
                    display: true,
                    text: 'Total Profit',
                },
            },
        },
    },
});

// Function to generate random colors
function generateRandomColors(count) {
    var colors = [];
    for (var i = 0; i < count; i++) {
        var color = '#' + Math.floor(Math.random() * 16777215).toString(16);
        colors.push(color);
    }
    return colors;
}
</script>


    </div>
  @endsection
