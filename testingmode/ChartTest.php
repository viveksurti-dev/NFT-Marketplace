<div class="col-md-12 mt-1">

    <?php

    $startDate = date('Y-m-d', strtotime('-29 days'));
    $sql = "SELECT 
                    DATE(transactiondate) as date, 
                    SUM(creditamount) as earnings, 
                    SUM(debitamount) as expenditure 
                    FROM transactions 
                    JOIN auth ON transactions.userid = auth.id 
                    WHERE auth.username = '$username' 
                    AND transactiondate >= '$startDate'
                    GROUP BY DATE(transactiondate)";
    $result = $conn->query($sql);

    $last30DaysData = array_fill(0, 30, 0);
    $last30DaysExpenditure = array_fill(0, 30, 0);

    while ($row = $result->fetch_assoc()) {
        $dayNumber = (int)date_diff(date_create($startDate), date_create($row['date']))->format('%a');
        $last30DaysData[$dayNumber] = $row['earnings'];
        $last30DaysExpenditure[$dayNumber] = $row['expenditure'];
    }

    $data = array(
        'labels' => array_map(function ($dayNumber) use ($startDate) {
            return date('M d', strtotime("$startDate +$dayNumber days"));
        }, array_keys($last30DaysData)),
        'data' => array_values($last30DaysData),
        'expenditure' => array_values($last30DaysExpenditure),
    );

    $json_data = json_encode($data);
    ?>

    <div style="width:100%; height: 290px; max-height:500px; margin:auto;">
        <canvas class="card" style="width:100%;" id="lineChart"></canvas>
    </div>
    <script>
        var jsonData = <?php echo $json_data; ?>;

        var ctx = document.getElementById('lineChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: jsonData.labels,
                datasets: [{
                        label: 'Total Earnings (Last 30 Days)',
                        data: jsonData.data,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                        hoverBackgroundColor: 'rgba(75, 192, 192, 0.5)',
                        hoverBorderColor: 'rgba(75, 192, 192, 1)',
                        shadowOffsetX: 0,
                        shadowOffsetY: 100,
                        shadowBlur: 10,
                        shadowColor: 'rgba(75, 192, 192)'
                    },
                    {
                        label: 'Total Expenditure (Last 30 Days)',
                        data: jsonData.expenditure,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1,
                        hoverBackgroundColor: 'rgba(255, 99, 132, 0.5)',
                        hoverBorderColor: 'rgba(255, 99, 132, 1)',
                        shadowOffsetX: 0,
                        shadowOffsetY: 100,
                        shadowBlur: 10,
                        shadowColor: 'rgba(255, 99, 132, 0.3)'
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        position: 'top'
                    }
                },
                elements: {
                    line: {
                        tension: 0.4
                    }
                }
            }
        });
    </script>



</div>