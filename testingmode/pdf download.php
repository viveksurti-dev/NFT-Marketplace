<li class="p-1"><button id="transpdf" class="dropdown-item pt-2 pb-2"><i class="bi bi-filetype-pdf me-2"></i>PDF</button></li>

<?php
require_once '../Navbar.php';

$data[] = array(
    'log user' => $loggedUser,
);

?>



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