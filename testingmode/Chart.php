<?php
try {
    ob_start();
    session_start();
    include '../config.php';
    $currentYear = date('Y');

    if (!$conn) {
        throw new Exception("Database connection failed.");
    }

    $get_requester = mysqli_query($conn, "
        SELECT COUNT(*) AS requester_count, MONTH(created_at) AS month
        FROM requester
        WHERE YEAR(created_at) = '$currentYear'
        GROUP BY MONTH(created_at)
        ORDER BY MONTH(created_at)
    ");
    $requesterData = [];
    while ($row = mysqli_fetch_assoc($get_requester)) {
        $requesterData[] = $row;
    }

    $get_donor = mysqli_query($conn, "
        SELECT COUNT(*) AS donor_count, MONTH(created_at) AS month
        FROM eligibility
        WHERE YEAR(created_at) = '$currentYear'
        GROUP BY MONTH(created_at)
        ORDER BY MONTH(created_at)
    ");
    $donorData = [];
    while ($row = mysqli_fetch_assoc($get_donor)) {
        $donorData[] = $row;
    }

    $combinedData = [];
    foreach ($requesterData as $r) {
        $month = intval($r['month']);
        $combinedData[$month]['requester'] = intval($r['requester_count']);
    }
    foreach ($donorData as $d) {
        $month = intval($d['month']);
        $combinedData[$month]['donor'] = intval($d['donor_count']);
    }

    $dataPointsReceived = [];
    $dataPointsSent = [];
    for ($month = 1; $month <= 12; $month++) {
        $dataPointsReceived[] = ['x' => $month, 'y' => $combinedData[$month]['requester'] ?? 0];
        $dataPointsSent[] = ['x' => $month, 'y' => $combinedData[$month]['donor'] ?? 0];
    }
    $jsonReceived = json_encode($dataPointsReceived, JSON_NUMERIC_CHECK);
    $jsonSent = json_encode($dataPointsSent, JSON_NUMERIC_CHECK);
} catch (Exception $e) {
    $error = $e->getMessage();
    $_SESSION['error-message'] = $error;
    print_r($_SESSION);
}
?>

<!DOCTYPE HTML>
<html>

<head>
    <script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</head>

<body>
    <div id="chartContainer" style="height: 500px; width: 100%;"></div>
    <script>
        window.onload = function() {
            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                axisX: {
                    title: "Month",
                    interval: 1
                },
                axisY: {
                    title: "Count",
                },
                legend: {
                    verticalAlign: "top",
                    horizontalAlign: "right",
                    dockInsidePlotArea: true
                },
                toolTip: {
                    shared: true
                },
                data: [{
                        name: "Received",
                        showInLegend: true,
                        legendMarkerType: "square",
                        type: "area",
                        color: "rgba(40,175,101,0.6)",
                        markerSize: 0,
                        dataPoints: <?php echo $jsonReceived ?? '[]'; ?>
                    },
                    {
                        name: "Donors",
                        showInLegend: true,
                        legendMarkerType: "square",
                        type: "area",
                        color: "rgba(0,75,141,0.7)",
                        markerSize: 0,
                        dataPoints: <?php echo $jsonSent ?? '[]'; ?>
                    }
                ]
            });
            chart.render();
        }
    </script>
</body>

</html>