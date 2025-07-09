<?php
include './config.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data grouped by month
$sql = "SELECT COUNT(*) as total_users, MONTH(joindate) as month FROM auth GROUP BY MONTH(joindate)";
$result = $conn->query($sql);

// Organize data for Chart.js
$data = array();
while ($row = $result->fetch_assoc()) {
    $data['labels'][] = date('F', mktime(0, 0, 0, $row['month'], 1));
    $data['data'][] = $row['total_users'];
}

// Close connection
$conn->close();

// Encode data as JSON for Chart.js
$json_data = json_encode($data);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>User Registration Chart</title>
    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div style="width:80%; margin:auto;">
        <canvas id="userChart"></canvas>
    </div>

    <script>
        // Use PHP-generated JSON data
        var jsonData = <?php echo $json_data; ?>;

        // Create Chart.js chart
        var ctx = document.getElementById('userChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: jsonData.labels,
                datasets: [{
                    label: 'Total Users',
                    data: jsonData.data,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>

</html>