<?php
require_once '../Navbar.php';
include '../config.php';

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    echo "<script>window.location.href='error-001.php?allowRedirect=true';</script>";
    exit();
}

// Retrieve username from the session
$username = $_SESSION['username'];

$transactionQuery = "SELECT * FROM transactions INNER JOIN auth ON transactions.userid = auth.id WHERE auth.username = '$username' ORDER BY transactionid DESC";

$transactionDetail = $conn->query($transactionQuery);



if ($transactionDetail && $transactionDetail->num_rows > 0) {

?>
    <!-- Transaction Page -->
    <div class="transactions">
        <div class="d-flex flex-wrap">
            <div class="container-fluid d-flex flex-wrap justify-content-center col-md-6">
                <div class=" col-md-12 ">
                    <?php
                    // Fetch data for the last 12 months from the current date
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
                        $monthIndex = ($row['year'] - date('Y')) * 12 + $row['month'] - (date('d') >= 24 ? 0 : 1);
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

                    <div class="chart-container" style="position: relative; width:100%; height:290px; max-height:500px; margin:auto;">
                        <canvas id="userChart" class="card"></canvas>
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

                <div class="col-md-12 mt-1">

                    <?php
                    // Fetch data for the last 30 days
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

                    <div style="width:100%; height: 290px; max-height:500px; margin:auto;">
                        <canvas class="card" style="width:100%;" id="lineChart"></canvas>
                    </div>
                    <script>
                        // Use PHP-generated JSON data
                        var jsonData = <?php echo $json_data; ?>;

                        // Create Chart.js chart with drop shadows
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
            </div>

            <style>
                .container-transaction {
                    overflow-y: scroll;
                    height: 80vh;
                }

                .container-transaction h3 {
                    background-color: #151515;
                    padding: 10px;
                }
            </style>

            <!-- Transactions Download -->
            <?php
            $select = "SELECT transactions.*, auth.username FROM transactions LEFT JOIN auth ON transactions.transactuser = auth.id WHERE transactions.userid = {$USER['id']} ORDER BY transactions.transactionid DESC";
            $result = mysqli_query($conn, $select);

            $data = [];

            if ($result && mysqli_num_rows($result) > 0) {
                while ($transaction = mysqli_fetch_assoc($result)) {
                    // If username is available in auth table, use it, else use transactuser from transactions table
                    $username = $transaction['username'] ? $transaction['username'] : $transaction['transactuser'];

                    // Fetch other transaction details
                    $loggedUser = $USER['username'];
                    $transactionDate = $transaction['transactiondate'];
                    $description = $transaction['transactionreason'];
                    $creditAmount = $transaction['creditamount'];
                    $debitAmount = $transaction['debitamount'];

                    // Push the data into the $data array
                    $data[] = array(
                        'log user' => $loggedUser,
                        'Transaction Date' => $transactionDate,
                        'Transact User' => $username,
                        'Description' => $description,
                        'Credit Amount' => $creditAmount,
                        'Debit Amount' => $debitAmount
                    );
                }
            }
            ?>
            <div class="col-md-6 container-transaction" style="position:relative;">
                <!-- download Transactions -->
                <div class="z-2" style="position:fixed; top:90px; right:30px;">
                    <div class="dropdown">
                        <button class="btn btn-outline-danger" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-cloud-download me-2"></i> Download
                        </button>
                        <ul class="dropdown-menu">
                            <li class="p-1"><button id="transpdf" class="dropdown-item pt-2 pb-2"><i class="bi bi-filetype-pdf me-2"></i>PDF</button></li>
                            <li class="p-1"><button id="transexcel" class="dropdown-item pt-2 pb-2"><i class="bi bi-filetype-xlsx me-2"></i>Excel</button></li>
                        </ul>
                    </div>
                </div>
                <h3 class="text-center sticky-top z-1">Transactions</h3>
                <?php
                while ($row = $transactionDetail->fetch_assoc()) {
                    // convert Date Format
                    $originalDate = $row['transactiondate'];
                    $TransactionDate = date('d M Y', strtotime($originalDate));
                ?>
                    <div class="">
                        <div class="card container-transactions d-flex flex-row flex-wrap mt-1">
                            <!-- transaction Date -->
                            <div class="col-md-3 transaction-date"><?php echo $TransactionDate; ?> <br /><?php echo "$row[transactiontime]"; ?></div>
                            <!-- transaction details -->
                            <div class="col-md-6 d-flex flex-wrap flex-column mt-1">
                                <p class="card-heading transaction-person"><span>|</span>
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
                                    ?></p>
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
                echo "No transaction details found.";
            }
            ?>
            </div>
        </div>
    </div>


    <!-- download in excel -->
    <script>
        document.getElementById("transexcel").addEventListener("click", function() {
            var transactionsData = <?php echo json_encode($data); ?>;
            var wb = XLSX.utils.book_new();
            var ws = XLSX.utils.json_to_sheet(transactionsData);

            // Add logged user's name as metadata
            XLSX.utils.book_append_sheet(wb, ws, "Transactions");
            wb.Props = {
                Title: "Transaction History",
                Author: "<?php echo $USER['username']; ?>",
                CreatedDate: new Date()
            };

            // Generate and download the Excel file
            var wbout = XLSX.write(wb, {
                bookType: 'xlsx',
                type: 'binary'
            });

            function s2ab(s) {
                var buf = new ArrayBuffer(s.length);
                var view = new Uint8Array(buf);
                for (var i = 0; i != s.length; ++i) view[i] = s.charCodeAt(i) & 0xFF;
                return buf;
            }
            saveAs(new Blob([s2ab(wbout)], {
                type: "application/octet-stream"
            }), "Transactions.xlsx");
        });
    </script>


    <!-- IN PDF -->
    <script>
        document.getElementById("transpdf").addEventListener("click", function() {
            var transactionsData = <?php echo json_encode($data); ?>;
            var doc = new window.jspdf.jsPDF();
            var columns = ["Transaction Date", "Transact User", "Description", "Credit Amount", "Debit Amount"];
            var rows = [];

            // Add heading "TRANSACTION HISTORY"
            doc.setFontSize(16);
            doc.text("TRANSACTION HISTORY", 10, 10);

            // Add logged user's name
            doc.setFontSize(12);
            doc.text("Name: <?php echo $USER['username']; ?>", 10, 20);

            transactionsData.forEach(function(transaction) {
                rows.push([
                    transaction['Transaction Date'],
                    transaction['Transact User'],
                    transaction['Description'],
                    transaction['Credit Amount'],
                    transaction['Debit Amount']
                ]);
            });

            var xPos = 10;
            var yPos = 30; // Adjusted the y position to leave space for the heading and logged user's name
            var availableWidth = doc.internal.pageSize.width - 20;
            var columnWidths = availableWidth / columns.length;

            // Add table to the PDF
            doc.autoTable({
                startY: yPos,
                head: [columns],
                body: rows,
                theme: 'plain',
                columnStyles: {
                    0: {
                        cellWidth: columnWidths
                    },
                    1: {
                        cellWidth: columnWidths
                    },
                    2: {
                        cellWidth: columnWidths
                    },
                    3: {
                        cellWidth: columnWidths
                    },
                    4: {
                        cellWidth: columnWidths
                    }
                },
                headStyles: {
                    lineWidth: 0.5,
                    lineColor: [0, 0, 0]
                },
                bodyStyles: {
                    lineWidth: 0.2,
                    lineColor: [0, 0, 0]
                }
            });

            // Save the PDF
            doc.save("Transactions.pdf");
        });
    </script>