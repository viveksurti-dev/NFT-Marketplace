<?php
require_once 'Navbar.php';
require_once 'config.php';

$selectHistory = "SELECT * FROM loginhistory WHERE userid = '{$USER['id']}' ORDER BY loginid DESC";
$historydata = mysqli_query($conn, $selectHistory);

if ($historydata && mysqli_num_rows($historydata)) { ?>
    <div class="container-fluid">
        <div class="card">
            <table class="w-100">
                <thead class="sticky-top z-0" style="background:#252525">
                    <tr>
                        <td class="text-center p-2">
                            <small> Activity Id </small>
                        </td>
                        <td class="text-center p-2">
                            <small>
                                Date
                            </small>
                        </td>
                        <td class="text-center p-2">
                            <small>
                                Time
                            </small>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($history = mysqli_fetch_assoc($historydata)) { ?>
                        <tr style="border-top: 2px solid #252525;">
                            <td class="text-center p-2">
                                <small> <?php echo $enHistoryid = md5($history['loginid']) ?></small>
                            </td>
                            <td class="text-center p-2">
                                <small>
                                    <?php echo  $LoginDate = date('D, d F Y', strtotime($history['logindate'])); ?>
                                </small>
                            </td>
                            <td class="text-center p-2">
                                <small>
                                    <?php echo $loginTime = date('H : i', strtotime($history['logintime'])); ?>
                                </small>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
<?php } ?>