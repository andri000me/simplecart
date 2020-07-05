<?php
function setFlashdata($data)
{
    $_SESSION["flashdata"]['data'] = $data;
}
function flashdata()
{
    if (isset($_SESSION["flashdata"])) {
        echo $_SESSION["flashdata"]["data"];
        unset($_SESSION["flashdata"]);
    }
}
function swNotif($type, $title, $message, $confirm = false, $messageconfirm = null)
{
    if ($confirm == false) {
        $str = "<script>";
        $str .= "$(document).ready(function() {";
        $str .= " let pesan = \"" . $message . "\";";
        $str .= "Swal.fire({";
        $str .= "icon: '$type',";
        $str .= "title: '$title',";
        $str .= "text: pesan,";
        $str .= "});";
        $str .= "});";
        $str .= "</script>";
        return $str;
    }
}
function listorder($show)
{
    global $db;
    $grandtotal = 0;
    $item = [];
    $query = $db->prepare("SELECT CONCAT(product_name, '(',qty,')') AS itemqty, total_price FROM cart");
    $query->execute();
    $result = $query->get_result();
    while ($row = $result->fetch_assoc()) {
        $grandtotal += $row['total_price'];
        $item[] = $row['itemqty'];
    }
    $item = implode(' , ', $item);
    if ($show == 1) {
        return $item;
    } else if ($show == 0) {
        return $grandtotal;
    }
}
function getNumCart()
{
    global $db;
    $dataCart = $db->prepare("SELECT * FROM cart");
    $dataCart->execute();
    $dataCart->store_result();
    $num = $dataCart->num_rows();
    return $num;
}
