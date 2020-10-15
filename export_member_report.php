<?php
ob_start();
session_start();
include 'common/dbcon.php';
include 'models/PromotionModel.php';
include 'models/MemberModel.php';
include 'models/BankModel.php';


$strExcelFileName = "member_total_report.xls";
header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
header("Pragma:no-cache");

$promotion_id = 0;
$from_date = null;
$to_date = null;
$rows_cnt = 0;
$result = null;

if (isset($_POST['promotion_id'])) {
    $promotion_id = $_POST['promotion_id'];
}

if (isset($_POST['from_date'])) {
    $from_date = $_POST['from_date'];
}
if (isset($_POST['to_date'])) {
    $to_date = $_POST['to_date'];
}

if ($promotion_id > 0) {
    $f_date = date('Y-m-d H:m:i', strtotime($from_date));
    $t_date = date('Y-m-d H:m:i', strtotime($to_date));

    $query = "SELECT member_id,SUM(cash_in) as cash_in,SUM(cash_out) as cash_out, SUM(net_win) as net_win FROM member_account WHERE promotion_id='$promotion_id' ";
    if ($f_date != null && $t_date != null) {
        $query .= " AND (trans_date >= '$f_date' AND trans_date <='$t_date')";
    }
    $query .= " GROUP BY member_id";


    $statement = $connect->prepare($query);
    $statement->execute();
    $rows_cnt = $statement->rowCount();
    $result = $statement->fetchAll();
} else {

        $f_date = date('Y-m-d H:m:i', strtotime($from_date));
        $t_date = date('Y-m-d H:m:i', strtotime($to_date));

        $query = "SELECT member_id,SUM(cash_in) as cash_in,SUM(cash_out) as cash_out, SUM(net_win) as net_win FROM member_account WHERE id > 0 ";
        if ($f_date != null && $t_date != null) {
            $query .= " AND (trans_date >= '$f_date' AND trans_date <='$t_date')";
        }
        $query.= " GROUP BY member_id";

//        $query = "SELECT SUM(cash_in) as cash_in,SUM(cash_out) as cash_out, SUM(net_win) as net_win FROM member_account WHERE id > 0 ";
//        if ($f_date != null && $t_date != null) {
//            $query .= " AND (trans_date >= '$f_date' AND trans_date <='$t_date')";
//        }


        $statement = $connect->prepare($query);
        $statement->execute();
        $rows_cnt = $statement->rowCount();
        $result = $statement->fetchAll();

}

//$sql = "SELECT * FROM member";
//$statement = $connect->prepare($sql);
//$statement->execute();
//$result = $statement->fetchAll();
//
//$filtered_rows = $statement->rowCount();


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
<strong>Reports <?php echo date("d/m/Y"); ?> total <?php echo number_format($rows_cnt); ?> items</strong>
<br/>
<strong>Promotion <?php echo getPromotionname($connect, $promotion_id); ?> From <?= $from_date ?>
    To <?= $to_date ?></strong>
<br/>
<div id="SiXhEaD_Excel" align=center x:publishsource="Excel">
    <table x:str border=1 cellpadding=0 cellspacing=1 width=100% style="border-collapse:collapse">
        <tr>
            <td width="200" align="center" valign="middle"><strong>AccountId</strong></td>
            <td width="200" align="center" valign="middle"><strong>Name</strong></td>
            <td width="200" align="center" valign="middle"><strong>Phone</strong></td>
            <td width="200" align="center" valign="middle"><strong>BankName</strong></td>
            <td width="200" align="center" valign="middle"><strong>Bank Account</strong></td>
            <td width="200" align="center" valign="middle"><strong>ID Number</strong></td>
            <td width="200" align="center" valign="middle" style="text-align: right"><strong>Cash In</strong></td>
            <td width="181" align="center" valign="middle" style="text-align: right"><strong>Cash Out</strong></td>
            <td width="181" align="center" valign="middle" style="text-align: right"><strong>Net Win</strong></td>

        </tr>
        <?php if ($result != null && $rows_cnt > 0): ?>
            <?php
            $in_total = 0;
            $out_total = 0;
            $net_total = 0;
            ?>
            <?php foreach ($result as $rows): ?>
                <?php
                $in_total = $in_total + ($rows['cash_in']);
                $out_total = $out_total + ($rows['cash_out']);
                $net_total = $net_total + ($rows['net_win']);

                $member_data = getMemberDatamodel($connect,$rows['member_id']);

                ?>
                <tr>
                    <td align="center" valign="middle"><?php echo getMemberaccount($connect,$rows['member_id']); ?></td>
                    <td align="center" valign="middle"><?php echo getMembername($connect,$rows['member_id']); ?></td>
                    <td align="center" valign="middle"><?php echo $member_data[0]['phone']; ?></td>
                    <td align="center" valign="middle"><?php echo getBankname($connect,$member_data[0]['bank_id']); ?></td>
                    <td align="center" valign="middle"><?php echo $member_data[0]['bank_account']; ?></td>
                    <td align="center" valign="middle"><?php echo $member_data[0]['id_number']; ?></td>
                    <td align="center" valign="middle" style="text-align: right"><?php echo $rows['cash_in']; ?></td>
                    <td align="center" valign="middle" style="text-align: right"><?php echo $rows['cash_out']; ?></td>
                    <td align="center" valign="middle" style="text-align: right"><?php echo $rows['net_win']; ?></td>
                </tr>
                <?php
                   endforeach;
                ?>
            <tr>
                <td align="center" colspan="6" valign="middle" style="text-align: right"> Total</td>
                <td align="center" valign="middle" style="text-align: right"><?php echo number_format($in_total); ?></td>
                <td align="center" valign="middle" style="text-align: right"><?php echo number_format($out_total); ?></td>
                <td align="center" valign="middle" style="text-align: right"><?php echo number_format($net_total); ?></td>
            </tr>
        <?php endif; ?>
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
