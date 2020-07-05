<?php
require_once 'main.php';
require_once  '../vendor/autoload.php';
var_dump($_POST);
var_dump($_FILES['productimage']);
$data = $_POST;
$dataImage = $_FILES['productimage'];
$faker = faker\Factory::create();
if (isset($data['addproduct'])) {
    $productname = htmlspecialchars(trim($data['productname']));
    $productprice = htmlspecialchars(trim($data['productprice']));
    $productcode = htmlspecialchars(trim($data['productcode']));

    // check file upload
    $imagename = $dataImage['name'];
    $imagetmp = $dataImage['tmp_name'];
    $error = $dataImage['error'];
    $imagesize = $dataImage['size'];
    $extension = explode('.', $imagename);
    $extension = end($extension);
    $extensionvalid = ['jpg', 'jpeg', 'png'];
    $namefile = uniqid();
    $namefile .= '.';
    $namefile .= $extension;
    $uuid = $faker->uuid;
    $datecreated = date('Y-m-d');
    $dateupdated = date('Y-m-d');
    if ($error == 4) {
        setFlashdata(swNotif('warning', 'Perhatian', 'Tolong Masukan Gambar!'));
        header('Location: ../index.php');
    } else if ($imagesize > 1000000) {
        setFlashdata(swNotif('warning', 'Perhatian', 'File Gambar tidak boleh lebih dari 1MB!'));
        header('Location: ../index.php');
    } else if (!in_array($extension, $extensionvalid)) {
        setFlashdata(swNotif('warning', 'Perhatian!', 'File gambar yang diupload format tidak valid'));
        header('Location: ../index.php');
    } else {
        move_uploaded_file($imagetmp, '../asset/img/product/' . $namefile);
        $image = $namefile;
    }
    $query = $db->prepare("INSERT INTO product VALUES (?,?,?,?,?,?,?)");
    $query->bind_param("ssissss", $uuid, $productname, $productprice, $image, $productcode, $dateupdated, $datecreated);
    $query->execute();
    if ($db->affected_rows > 0) {
        setFlashdata(swNotif('success', 'Berhasil!', 'Product berhasil di masukan!'));
        header('Location: ../index.php');
    } else {
        $errormysqli = "$db->error";
        setFlashdata(swNotif('error', 'Gagal!', 'Error!' . $db->error));
        header('Location: ../index.php');
    }
}
