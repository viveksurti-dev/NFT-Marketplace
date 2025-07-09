<div class="w-info">
    <h4>Wallet Overview</h4>
    <p>Welcome! <span><?php echo $username ?></span></p>
</div>
<!-- Wallet Head -->
<div class="card transaction-info col-md-12 d-flex flex-wrap flex-row">
    <div class="col-md-2">
        <?php if (!empty($userDetails)) { ?>
            <?php if (!empty($userimage)) { ?>
                <img src="<?php echo BASE_URL . $userimage; ?>" alt="User Image" class="img-fluid user-image object-fit-cover">

            <?php } ?>
            <?php if (empty($userimage)) { ?>
                <img src="<?php echo BASE_URL; ?>Assets/auth/unkown.png" alt="User Image" class="img-fluid rounded-2">
            <?php } ?>

        <?php }  ?>
    </div>
    <div class="col-md-6 mt-2">
        <h4 class="card-heading"><span>|</span> Wallet Details</h4>
        <p><i class="bi bi-person-check"></i> <span class="caption"><?php echo $username ?></span></p>
        <p><i class="bi bi-telephone"></i> <span class="caption"><?php echo $phonenumber ?></p>
        <p><i class="bi bi-envelope-at"></i> <span class="caption"><?php echo $email ?></p>
        <div class="w-info">
            <p><span><i class="bi bi-patch-check "></i></span> KYC Verified</p>
        </div>
    </div>
    <div class="col-md-4 mt-2">
        <h3 class="card-heading"><span>|</span> Total Balance</h3>
        <h3 class="mt-3">₹ <?php echo $balance ?></h3>
        <div class="buttons mt-3 d-flex flex-wrap">
            <button class="btn btn-wallet col-md-5 m-1" onclick="showContent('wc3', 'wm3')">Send Money</button>
            <button class="btn btn-wallet col-md-5 m-1" onclick="openfaq()">Add Money</button>
            <div id="Add-Funds" class="modal card">
                <div class="modal-content col-md-4">
                    <span class="close" onclick="closefaq()">&times;</span>
                    <h4>Add Funds</h4>


                    <?php require_once './addMoney.php'; ?>

                </div>
            </div>
            <script>
                function openfaq() {
                    document.getElementById("Add-Funds").style.display = "block";
                    document.body.classList.add('modal-open');
                }

                function closefaq() {
                    document.getElementById("Add-Funds").style.display = "none";
                    document.body.classList.remove('modal-open');
                }
            </script>
        </div>
    </div>

</div>
<div class="transaction-info d-flex flex-wrap justify-content-center">
    <div class="card col-md-5 m-2">
        <?php
        // Count Total Earnings
        $sql = "SELECT  SUM(creditamount) AS creditamount FROM transactions INNER JOIN auth ON transactions.userid = auth.id
                        WHERE auth.username = '$username'";
        $totalEarning = $conn->query($sql);
        if ($result) {
            $row = $totalEarning->fetch_assoc();
            $TotalEarning = $row['creditamount'];
        } else {
            echo "Error fetching users: " . $conn->error;
        }
        ?>
        <p class="card-heading"><span>|</span> Total Earnings</p>
        <h3><span class="profit-price">₹</span>
            <?php if ($TotalEarning) {
                echo $TotalEarning;
            } else {
                echo '000.00';
            } ?>
        </h3>
    </div>
    <div class="card col-md-5 m-2">
        <?php
        // Count Total Wallet Expendure
        $sql = "SELECT  SUM(debitamount) AS debitamount FROM transactions INNER JOIN auth ON transactions.userid = auth.id
                        WHERE auth.username = '$username'";
        $totalExpendure = $conn->query($sql);
        if ($result) {
            $row = $totalExpendure->fetch_assoc();
            $TotalExpendure = $row['debitamount'];
        } else {
            echo "Error fetching users: " . $conn->error;
        }
        ?>
        <p class="card-heading"><span>|</span> Total Expendure</p>
        <h3><span class="loss-price">₹</span>
            <?php
            if ($TotalExpendure) {
                echo $TotalExpendure;
            } else {
                echo '000.00';
            }

            ?>
        </h3>
    </div>

</div>

<div class="container-fluid d-flex flex-wrap justify-content-center col-md-12 mt-5 mb-3">
    <div class="col-md-12">
        <h3 class="text-center mb-3">Transactions Reports</h3>
    </div>
    <!-- last 1 year chart -->
    <div class=" col-md-6">
        <?php
        $username = mysqli_real_escape_string($conn, $username);

        $sql = "SELECT 
            YEAR(transactiondate) as year, 
            MONTH(transactiondate) as month, 
            SUM(creditamount) as credits, 
            SUM(debitamount) as debits 
        FROM transactions 
        JOIN auth ON transactions.userid = auth.id 
        WHERE auth.username = '$username' AND transactiondate >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
        GROUP BY YEAR(transactiondate), MONTH(transactiondate)";

        $result = $conn->query($sql);

        // Initialize arrays with zero earnings and expenditures for each month
        $lastYearData = array_fill(0, 12, 0);
        $lastYearExpenditure = array_fill(0, 12, 0);

        // Fill the arrays with actual data where available
        while ($row = $result->fetch_assoc()) {
            $monthIndex = ($row['year'] - date('Y')) * 12 + $row['month'] - (date('d') >= 30 ? 0 : 1);
            $lastYearData[$monthIndex] = $row['credits'];
            $lastYearExpenditure[$monthIndex] = $row['debits'];
        }

        // Organize data for Chart.js
        $data = array(
            'labels' => array_map(function ($monthIndex) {
                $date = date_create()->modify("-$monthIndex months");
                return date_format($date, 'M y');
            }, array_keys($lastYearData)),
            'data' => array_values($lastYearData),
            'expenditure' => array_values($lastYearExpenditure),
        );

        // Encode data as JSON for Chart.js
        $json_data = json_encode($data);
        ?>

        <div class="chart-container" style="position: relative; width:100%; height:350px; max-height:500px; margin:auto;">
            <canvas id="12monthChart" class="card"></canvas>
        </div>

        <script>
            // Use PHP-generated JSON data
            var jsonData = <?php echo $json_data; ?>;

            // Create Chart.js chart
            var ctx = document.getElementById('12monthChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: jsonData.labels,
                    datasets: [{
                            label: 'Total Earnings (Last 12 Months)',
                            data: jsonData.data,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1,
                            hoverBackgroundColor: 'rgba(75, 192, 192, 0.5)',
                            hoverBorderColor: 'rgba(75, 192, 192, 1)'
                        },
                        {
                            label: 'Total Expenditure (Last 12 Months)',
                            data: jsonData.expenditure,
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1,
                            hoverBackgroundColor: 'rgba(255, 99, 132, 0.5)',
                            hoverBorderColor: 'rgba(255, 99, 132, 1)'
                        }
                    ]
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
    </div>
    <!-- last 30 days chart -->
    <div class="col-md-6 ">
        <?php
        // Fetch data for the last 30 days
        $startDate = date('Y-m-d', strtotime('-29 days'));
        $sql = "SELECT 
                    DATE(transactiondate) as date, 
                    SUM(creditamount) as earnings, 
                    SUM(debitamount) as expenditure 
                    FROM transactions   JOIN auth ON transactions.userid = auth.id 
        WHERE auth.username = '$username' AND
                    transactiondate >= '$startDate'
                    GROUP BY DATE(transactiondate)";
        $result = $conn->query($sql);

        // Initialize arrays with zero earnings and expenditures for each day
        $last30DaysData = array_fill(0, 30, 0);
        $last30DaysExpenditure = array_fill(0, 30, 0);

        // Fill the arrays with actual data where available
        while ($row = $result->fetch_assoc()) {
            // Calculate the index based on the difference in days
            $dayNumber = (int)date_diff(date_create($startDate), date_create($row['date']))->format('%a');
            $last30DaysData[$dayNumber] = $row['earnings'];
            $last30DaysExpenditure[$dayNumber] = $row['expenditure'];
        }

        // Organize data for Chart.js
        $data = array(
            'labels' => array_map(function ($dayNumber) use ($startDate) {
                return date('M d', strtotime("$startDate +$dayNumber days"));
            }, array_keys($last30DaysData)),
            'data' => array_values($last30DaysData),
            'expenditure' => array_values($last30DaysExpenditure),
        );

        // Encode data as JSON for Chart.js
        $json_data = json_encode($data);
        ?>

        <div style="width:100%; height: 350px; max-height:500px; margin:auto;">
            <canvas class="card" style="width:100%;" id="30daysChart"></canvas>
        </div>
        <script>
            // Use PHP-generated JSON data
            var jsonData = <?php echo $json_data; ?>;

            // Create Chart.js chart with drop shadows
            var ctx = document.getElementById('30daysChart').getContext('2d');
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
                            shadowOffsetX: 0, // Add shadow offset X
                            shadowOffsetY: 100, // Add shadow offset Y
                            shadowBlur: 10, // Add shadow blur
                            shadowColor: 'rgba(75, 192, 192)' // Add shadow color
                        },
                        {
                            label: 'Total Expenditure (Last 30 Days)',
                            data: jsonData.expenditure,
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1,
                            hoverBackgroundColor: 'rgba(255, 99, 132, 0.5)',
                            hoverBorderColor: 'rgba(255, 99, 132, 1)',
                            shadowOffsetX: 0, // Add shadow offset X
                            shadowOffsetY: 100, // Add shadow offset Y
                            shadowBlur: 10, // Add shadow blur
                            shadowColor: 'rgba(255, 99, 132, 0.3)' // Add shadow color
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
                            tension: 0.4 // Adjust line tension for curves
                        }
                    }
                }
            });
        </script>
    </div>


    <div class="col-md-12 mt-5">
        <h3 class="text-center mb-2">Last Transactions</h3>
        <?php
        $userId = $USER['id'];
        $transactionQuerys = "SELECT * FROM transactions WHERE userid = $userId ORDER BY transactionid DESC LIMIT 5";
        $transactionDetails = $conn->query($transactionQuerys);
        if ($transactionDetails && $transactionDetails->num_rows > 0) { ?>
            <div class=" d-flex flex-wrap">

                <?php
                while ($row = $transactionDetails->fetch_assoc()) {
                    // convert Date Format
                    $originalDate = $row['transactiondate'];
                    $TransactionDate = date('d M Y', strtotime($originalDate));
                ?>
                    <div class="col-md-12">
                        <div class="card container-transactions d-flex flex-row flex-wrap mt-1">
                            <!-- transaction Date -->
                            <div class="col-md-2 transaction-date"><?php echo $TransactionDate; ?> <br /><?php echo "$row[transactiontime]"; ?></div>
                            <!-- transaction details -->
                            <div class="col-md-7 d-flex flex-wrap flex-column mt-1">
                                <p class="card-heading transaction-person text-capitalize"><span>|</span>
                                    <?php
                                    $select = "SELECT username FROM auth WHERE id = '{$row['transactuser']}'";
                                    $userResult = mysqli_query($conn, $select);

                                    if ($userResult) {

                                        $userData = mysqli_fetch_assoc($userResult);
                                        if ($userData) {
                                            $username = $userData['username'];
                                            echo $username;
                                        } else {
                                            echo $row['transactuser'];
                                        }
                                    } else {
                                        echo "Error fetching user";
                                    }
                                    ?>
                                </p>
                                <small class="caption transaction-reason">- <?php echo $row['transactionreason'] ?></small>
                            </div>
                            <!-- Transaction Amount -->
                            <div class="col-md-3 transaction-amount">
                                <?php
                                if ($row['creditamount']) { ?>
                                    <p class="profit-price">₹ <?php echo $row['creditamount']; ?></p>
                                <?php } else { ?>
                                    <p class="loss-price">₹ <?php echo $row['debitamount']; ?></p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
            <?php }
            } else {
                echo "No transaction details found. " . $conn->error;
            }
            ?>

            </div>
            <div class="d-flex justify-content-center mt-2">
                <button id="wm2" onclick="showContent('wc2', 'wm2')" class="btn col-md-3 btn-wallet mt-1"> Show All</button>
            </div>
    </div>
</div>