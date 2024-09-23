<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales & Purchases Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

    <div style="width: 80%; margin: 50px auto;">
        <canvas id="myChart"></canvas>
    </div>

    <?php
    // Generate random data for sales and purchases for each day
    $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
    $sales = [];
    $purchases = [];

    // Fill arrays with random data (between 20 and 100)
    foreach ($days as $day) {
        $sales[] = rand(20, 100);
        $purchases[] = rand(30, 120);
    }

    // Convert PHP arrays to JavaScript arrays
    $salesData = json_encode($sales);
    $purchaseData = json_encode($purchases);
    $labels = json_encode($days);
    ?>

    <script>
        var ctx = document.getElementById('myChart').getContext('2d');

        // PHP-generated data
        var salesData = <?php echo $salesData; ?>;
        var purchaseData = <?php echo $purchaseData; ?>;
        var labels = <?php echo $labels; ?>;

        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Sales',
                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        data: salesData
                    },
                    {
                        label: 'Purchase',
                        backgroundColor: 'rgba(153, 102, 255, 0.7)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        data: purchaseData
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: '$ (thousands)',
                            font: {
                                size: 14
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            color: 'rgb(0, 0, 0)',
                            font: {
                                size: 14
                            }
                        }
                    }
                }
            }
        });
    </script>

</body>
</html>
