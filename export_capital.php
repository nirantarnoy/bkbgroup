<?php
ob_start();
session_start();
include 'common/dbcon.php';

$strExcelFileName = "capital_report.xls";
header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");

$full_date = '';
$from_data = '';
$to_date = '';




$sql = "SELECT * FROM capital";
$statement = $connect->prepare($sql);
$statement->execute();
$result = $statement->fetchAll();

$filtered_rows = $statement->rowCount();


?>
<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel"
      xmlns="http://www.w3.org/TR/REC-html40">

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"
>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
<strong>Reported <?php echo date("d/m/Y"); ?> total <?php echo number_format($filtered_rows); ?> items</strong><br>
<br>
<div id="SiXhEaD_Excel" align=center x:publishsource="Excel">
    <table x:str border=1 cellpadding=0 cellspacing=1 width=100% style="border-collapse:collapse">

        <tr>
            <td width="181" align="center" valign="middle"><strong>Date</strong></td>
            <td width="181" align="center" valign="middle"><strong>Expend Date</strong></td>
            <td width="181" align="center" valign="middle"><strong>List</strong></td>
            <td width="181" align="center" valign="middle"><strong>Amount</strong></td>
            <td width="181" align="center" valign="middle"><strong>Price</strong></td>
            <td width="181" align="center" valign="middle"><strong>Total</strong></td>
            <td width="181" align="center" valign="middle"><strong>Cashier Name</strong></td>

        </tr>
        <?php $total_all = 0;?>
        <?php foreach ($result as $rows): ?>
            <?php $total_all = $total_all + ($rows['total']);?>
            <tr>
                <td align="center" valign="middle"><?php echo $rows['trans_date']; ?></td>
                <td align="center" valign="middle"><?php echo $rows['expend_date']; ?></td>
                <td align="center" valign="middle"><?php echo $rows['list']; ?></td>
                <td align="center" valign="middle"><?php echo $rows['qty']; ?></td>
                <td align="center" valign="middle"><?php echo $rows['price']; ?></td>
                <td align="center" valign="middle"><?php echo $rows['total']; ?></td>
                <td align="center" valign="middle"><?php echo $rows['cashier_name']; ?></td>
            </tr>
        <?php
        endforeach;
        ?>
        <tr>
            <td align="center" valign="middle"></td>
            <td align="center" valign="middle"></td>
            <td align="center" valign="middle"></td>
            <td align="center" valign="middle"></td>
            <td align="center" valign="middle">Total</td>
            <td align="center" valign="middle"><?php echo number_format($total_all); ?></td>
            <td align="center" valign="middle"></td>
        </tr>
    </table>
</div>
<script>
    window.onbeforeunload = function () {
        return false;
    };
    setTimeout(function () {
        window.close();
    }, 10000);
</script>
</body>
</html>
