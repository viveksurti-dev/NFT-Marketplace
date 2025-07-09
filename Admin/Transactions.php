<div class="col-md-12 mt-1">
    <!-- Transactions Download -->
    <?php
    $select = "SELECT transactions.*, auth.username FROM transactions LEFT JOIN auth ON transactions.transactuser = auth.id ORDER BY transactions.transactionid DESC";
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
    <div class="z-2" style="position:fixed; top:90px; right:30px;">
        <div class="dropdown">
            <button class="btn btn-outline-danger" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-cloud-download me-2"></i> Download
            </button>
            <ul class="dropdown-menu">
                <li class="p-1"><button id="transpdf" class="dropdown-item pt-2 pb-2"><i
                            class="bi bi-filetype-pdf me-2"></i>PDF</button></li>
                <li class="p-1"><button id="transexcel" class="dropdown-item pt-2 pb-2"><i
                            class="bi bi-filetype-xlsx me-2"></i>Excel</button></li>
            </ul>
        </div>
    </div>
</div>
<?php
$transactionQuery = "SELECT * FROM transactions 
        ORDER BY transactionid DESC";

$transactionDetail = $conn->query($transactionQuery);


if ($transactionDetail && $transactionDetail->num_rows > 0) { ?>
    <div class=" d-flex flex-wrap">
        <?php
        while ($row = $transactionDetail->fetch_assoc()) {
            // convert Date Format
            $originalDate = $row['transactiondate'];
            $TransactionDate = date('d M Y', strtotime($originalDate));
        ?>
            <div class="col-md-12">
                <div class="card container-transactions d-flex flex-row flex-wrap mt-1">
                    <!-- transaction Date -->
                    <div class="col-md-2 transaction-date"><?php echo $TransactionDate; ?>
                        <br /><?php echo "$row[transactiontime]"; ?>
                    </div>
                    <!-- transaction details -->
                    <div class="col-md-7 d-flex flex-wrap flex-column mt-1">
                        <p class="card-heading transaction-person"><span>|</span>
                            <?php if ($row['creditamount']) { ?>
                                <small> To ></small>
                            <?php } else { ?>
                                <small>From ></small>
                            <?php } ?>
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

                            <small class="caption" style="font-size: 10px;">
                                [ Transaction Id : #trans<?php echo $row['transactionid'] ?>]
                            </small>
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
        echo "No transaction details found.";
    }
    ?>




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

            var headingText = "NFT MARKETPLACE";
            var textWidth = doc.getStringUnitWidth(headingText) * doc.internal.getFontSize() / doc.internal
                .scaleFactor;
            var centerX = (doc.internal.pageSize.width - textWidth) / 2;

            doc.setFontSize(18);
            doc.text(headingText, centerX, 10);

            var headingText = "Transaction History";
            var textWidth = doc.getStringUnitWidth(headingText) * doc.internal.getFontSize() / doc.internal
                .scaleFactor;
            var centerX = (doc.internal.pageSize.width - textWidth) / 2;

            doc.setFontSize(18);
            doc.text(headingText, centerX, 20);

            // Add logged user's name
            doc.setFontSize(12);
            doc.text("Name: <?php echo $USER['username']; ?>", 10, 25);

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
            var yPos = 40; // Adjusted starting y-coordinate for the table
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
                },
                didDrawPage: function(data) {
                    var pageCount = doc.internal.getNumberOfPages();
                    doc.setFontSize(10);
                    doc.setTextColor(40);
                    doc.text("Page " + data.pageNumber + " of " + pageCount +
                        " - Please review it carefully for accuracy and keep it for your records.",
                        data.settings.margin.left, doc.internal.pageSize.height - 10);

                }
            });

            // Save the PDF
            doc.save("Transactions.pdf");
        });
    </script>