<?php
date_default_timezone_set('Asia/Bangkok');
include("common/dbcon.php");
include("models/MemberModel.php");
include("models/BankModel.php");

$promotion_id = 0;
$from_date = null;
$to_date = null;
$data = [];
$member_type = 0;

if (isset($_POST['promotion_id'])) {
    $promotion_id = $_POST['promotion_id'];
}

if (isset($_POST['from_date'])) {
    $from_date = $_POST['from_date'];
}
if (isset($_POST['to_date'])) {
    $to_date = $_POST['to_date'];
}
if (isset($_POST['member_group_id'])) {
    $member_type = $_POST['member_group_id'];
}

if ($promotion_id > 0) {
    $f_date = date('Y-m-d H:i:s', strtotime($from_date));
    $t_date = date('Y-m-d H:i:s', strtotime($to_date));

    $query = '';

    if ($member_type == 0) {
        $query = "SELECT member_id,SUM(cash_in) as cash_in,SUM(cash_out) as cash_out, SUM(net_win) as net_win FROM member_account WHERE id > 0";
        if ($promotion_id != '' || $promotion_id > 0) {
            $query .= " AND promotion_id='$promotion_id'";
        }
        if ($f_date != '' && $t_date != '') {
            $query .= " AND (trans_date >= '$f_date' AND trans_date <='$t_date')";
        }
        $query .= " GROUP BY member_id";
    }
    if ($member_type == 1) {
        $query = "SELECT SUM(member_account.cash_in) as cash_in,SUM(member_account.cash_out) as cash_out, SUM(member_account.net_win) as net_win,member_account.member_id FROM member_account INNER JOIN member ON member_account.member_id=member.id WHERE member_account.id > 0 AND member.member_type is null";
        if ($promotion_id > 0) {
            $query .= " AND member_account.promotion_id='$promotion_id'";
        }
        if ($f_date != '' && $t_date != '') {
            $query .= " AND (member_account.trans_date >= '$f_date' AND member_account.trans_date <='$t_date')";
        }
        $query.= " GROUP BY member_account.member_id";
    }
    if ($member_type == 2) {
        $query = "SELECT SUM(member_account.cash_in) as cash_in,SUM(member_account.cash_out) as cash_out, SUM(member_account.net_win) as net_win,member_account.member_id FROM member_account INNER JOIN member ON member_account.member_id=member.id WHERE member_account.id > 0 AND member.member_type = 'SKM'";
        if ($promotion_id > 0) {
            $query .= " AND member_account.promotion_id='$promotion_id'";
        }
        if ($f_date != '' && $t_date != '') {
            $query .= " AND (member_account.trans_date >= '$f_date' AND member_account.trans_date <='$t_date')";
        }
        $query.= " GROUP BY member_account.member_id";
    }


    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    //$filtered_rows = $statement->rowCount();
    $html = '';
    $in_total = 0;
    $out_total = 0;
    $net_total = 0;
    foreach ($result as $row) {
        $in_total = $in_total + ($row['cash_in']);
        $out_total = $out_total + ($row['cash_out']);
        $net_total = $net_total + ($row['net_win']);

        $member_data = getMemberDatamodel($connect, $row['member_id']);

        $html .= '<tr>';
        $html .= '<td>' . date('Y-m-d H:i:s', strtotime($member_data[0]['active_date'])) . '</td>';
        $html .= '<td>' . getMemberaccount($connect, $row['member_id']) . '</td>';
        $html .= '<td>' . getMembername($connect, $row['member_id']) . '</td>';
        $html .= '<td>' . $member_data[0]['phone'] . '</td>';
        $html .= '<td>' . getBankname($connect, $member_data[0]['bank_id']) . '</td>';
        $html .= '<td>' . $member_data[0]['bank_account'] . '</td>';
        $html .= '<td>' . $member_data[0]['id_number'] . '</td>';
        $html .= '<td style="text-align: right">' . number_format($row['cash_in']). '</td>';
        $html .= '<td style="text-align: right">' . number_format($row['cash_out']) . '</td>';
        $html .= '<td style="text-align: right">' . number_format($row['net_win']) . '</td>';
        $html .= '</tr>';
    }
    $html .= '<tr>';
    $html .= '<td colspan="7" style="text-align: right"><b>Total</b></td>';
    $html .= '<td style="text-align: right"><b>' . number_format($in_total) . '</b></td>';
    $html .= '<td style="text-align: right"><b>' . number_format($out_total) . '</b></td>';
    $html .= '<td style="text-align: right"><b>' . number_format($net_total) . '</b></td>';
    $html .= '</tr>';

    echo $html;
} else {
    $f_date = date('Y-m-d H:i:s', strtotime($from_date));
    $t_date = date('Y-m-d H:i:s', strtotime($to_date));

//    $query = "SELECT member_id,SUM(cash_in) as cash_in,SUM(cash_out) as cash_out, SUM(net_win) as net_win FROM member_account WHERE id > 0 ";
//    if ($f_date != '' && $t_date != '') {
//        $query .= " AND (trans_date >= '$f_date' AND trans_date <='$t_date')";
//    }
//    $query .= " GROUP BY member_id";
    $query  = '';
    if ($member_type == 0) {
        $query = "SELECT member_id,SUM(cash_in) as cash_in,SUM(cash_out) as cash_out, SUM(net_win) as net_win FROM member_account WHERE id > 0";

        if ($f_date != '' && $t_date != '') {
            $query .= " AND (trans_date >= '$f_date' AND trans_date <='$t_date')";
        }
        $query .= " GROUP BY member_id";
    }
    if ($member_type == 1) {
        $query = "SELECT SUM(member_account.cash_in) as cash_in,SUM(member_account.cash_out) as cash_out, SUM(member_account.net_win) as net_win,member_account.member_id FROM member_account INNER JOIN member ON member_account.member_id=member.id WHERE member_account.id > 0 AND member.member_type is null";

        if ($f_date != '' && $t_date != '') {
            $query .= " AND (member_account.trans_date >= '$f_date' AND member_account.trans_date <='$t_date')";
        }
        $query.= " GROUP BY member_account.member_id";
    }
    if ($member_type == 2) {
        $query = "SELECT SUM(member_account.cash_in) as cash_in,SUM(member_account.cash_out) as cash_out, SUM(member_account.net_win) as net_win,member_account.member_id FROM member_account INNER JOIN member ON member_account.member_id=member.id WHERE member_account.id > 0 AND member.member_type = 'SKM'";

        if ($f_date != '' && $t_date != '') {
            $query .= " AND (member_account.trans_date >= '$f_date' AND member_account.trans_date <='$t_date')";
        }
        $query.= " GROUP BY member_account.member_id";
    }

    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    //$filtered_rows = $statement->rowCount();
    $html = '';
    $in_total = 0;
    $out_total = 0;
    $net_total = 0;
    foreach ($result as $row) {
        $in_total = $in_total + ($row['cash_in']);
        $out_total = $out_total + ($row['cash_out']);
        $net_total = $net_total + ($row['net_win']);

        $member_data = getMemberDatamodel($connect, $row['member_id']);

        $html .= '<tr>';
        $html .= '<td>' . date('Y-m-d H:i:s', strtotime($member_data[0]['active_date'])) . '</td>';
        $html .= '<td>' . getMemberaccount($connect, $row['member_id']) . '</td>';
        $html .= '<td>' . getMembername($connect, $row['member_id']) . '</td>';
        $html .= '<td>' . $member_data[0]['phone'] . '</td>';
        $html .= '<td>' . getBankname($connect, $member_data[0]['bank_id']) . '</td>';
        $html .= '<td>' . $member_data[0]['bank_account'] . '</td>';
        $html .= '<td>' . $member_data[0]['id_number'] . '</td>';
        $html .= '<td style="text-align: right">' . number_format($row['cash_in']) . '</td>';
        $html .= '<td style="text-align: right">' . number_format($row['cash_out']) . '</td>';
        $html .= '<td style="text-align: right">' . number_format($row['net_win']) . '</td>';
        $html .= '</tr>';
    }
    $html .= '<tr>';
    $html .= '<td colspan="7" style="text-align: right"><b>Total</b></td>';
    $html .= '<td style="text-align: right"><b>' . number_format($in_total) . '</b></td>';
    $html .= '<td style="text-align: right"><b>' . number_format($out_total) . '</b></td>';
    $html .= '<td style="text-align: right"><b>' . number_format($net_total) . '</b></td>';
    $html .= '</tr>';

    echo $html;
}


?>
