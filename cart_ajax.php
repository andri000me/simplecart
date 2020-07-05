<?php
require_once 'config/main.php';
require_once  'vendor/autoload.php';
if (isset($_POST["id"])) {
    $faker = faker\Factory::create('id_ID');
    $id = $_POST["id"];
    $stmt = $db->prepare("SELECT * FROM product WHERE id_product =?");
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $uuid = $faker->uuid;
    $productname = $row['product_name'];
    $productprice = $row['product_price'];
    $productimage = $row['product_image'];
    $productcode = $row['product_code'];
    $queryExist = $db->prepare("SELECT product_code FROM cart WHERE product_code =?");
    $queryExist->bind_param('s', $productcode);
    $queryExist->execute();
    $res = $queryExist->get_result();
    $r = $res->fetch_assoc();
    $code = $r['product_code'];
    if (!$code) {
        $qty = 1;
        $totalprice = $productprice;
        $query = $db->prepare("INSERT INTO cart VALUES (?,?,?,?,?,?,?)");
        $query->bind_param('ssisiis', $uuid, $productname, $productprice, $productimage, $qty, $totalprice, $productcode);
        $query->execute();
        echo swNotif('success', 'Berhasil!', 'Berhasil Tertambah di cart');
    } else {
        echo swNotif('warning', 'Perhatian!', 'Sudah Tertambah di cart');
    }
} else if (isset($_GET["getcart"])) {
    echo getNumCart();
} else if (isset($_GET["getTotal"])) {
    $query = $db->prepare('SELECT total_price FROM cart');
    $query->execute();
    $result = $query->get_result();
    $grandTotal = 0;
    while ($row = $result->fetch_assoc()) {
        $grandTotal += $row['total_price'];
    }
    echo number_format($grandTotal);
} else if (isset($_GET['delAll'])) {
    $query = $db->prepare('DELETE FROM cart');
    $query->execute();
    if (!$db->affected_rows == 0) {
        echo swNotif('success', 'Berhasil!', 'Berhasil Menghapus semua data cart');
    } else {
        echo swNotif('warning', 'Perhatian!', 'Tidak ada data yang di hapus pada cart');
    }
} else if (isset($_GET['delSingle'])) {
    $id = $_GET["id"];
    $query = $db->prepare('DELETE FROM cart WHERE id_cart=?');
    $query->bind_param('s', $id);
    $query->execute();
    $r = $query->get_result();
    if (!$db->affected_rows == 0) {
        setFlashdata(swNotif('success', 'Berhasil!', 'Berhasil Menghapus data cart'));
        header('Location: cart.php');
    } else {
        setFlashdata(swNotif('warning', 'Perhatian!', 'Tidak ada data yang di hapus pada cart'));
        header('Location: cart.php');
    }
} else if (isset($_POST["action"]) == 'order') {
    $faker = faker\Factory::create('id_ID');
    $uuid = $faker->uuid;
    $listorder = $_POST["listorder"];
    $nama = $_POST["nama"];
    $grandtotal = $_POST["grandtotal"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $payment = $_POST["payment"];
    $address = $_POST["address"];
    $stmt = $db->prepare("INSERT INTO orders (`id_orders`, `name`, `email`, `phone`, `address`, `pmode`, `product`, `amount_paid`) VALUES (?,?,?,?,?,?,?,?)");
    $stmt->bind_param('sssssssi', $uuid, $nama, $email, $phone, $address, $payment, $listorder, $grandtotal);
    $stmt->execute();
    $r = $stmt->get_result();
    if ($db->affected_rows > 0) {
        $query = $db->prepare('DELETE FROM cart');
        $query->execute();
        $data = '<div class="card text-center">';
        $data .= '<h1 class="text-success">Order Anda Berhasil!</h1>';
        $data .= '<div class="card-body bg-danger text-white">';
        $data .= '<h4 class="card-title">Product yang di order :  ';
        $data .= $listorder;
        $data .= '</h4>';
        $data .= '</div>';
        $data .= '<h4>Nama Kamu : ' . $nama . '</h4>';
        $data .= '<h4>Email Kamu : ' . $email . '</h4>';
        $data .= '<h4>Phone Kamu : ' . $phone . '</h4>';
        $data .= '<h4>Alamat Kamu : ' . $address . '</h4>';
        $data .= '<h4>Total Pembayaran Kamu : ' . $grandtotal . '</h4>';
        $data .= '<h4>Metode Pembayaran Kamu : ' . $payment . '</h4>';
        $data .= '</div>';
        echo $data;
    } else {
        swNotif('error', 'Gagal', 'Ceckout Coba kembali!');
    }
} else if (isset($_GET["changeqty"])) {
    $id = $_GET["id"];
    $qty = $_GET["qty"];
    $price = $_GET["price"] * $_GET["qty"];
    $stmt = $db->prepare("UPDATE cart SET qty=?,total_price=? WHERE id_cart=?");
    $stmt->bind_param('iis', $qty, $price, $id);
    $stmt->execute();
    $query = $db->prepare("SELECT total_price FROM cart WHERE id_cart=?");
    $query->bind_param('s', $id);
    $query->execute();
    $result = $query->get_result();
    $row = $result->fetch_assoc();
    echo json_encode($row);
} else if (isset($_GET["loadData"]) && $_GET["loadData"] == 'cart') {
    $query = $db->prepare('SELECT * FROM cart');
    $query->execute();
    $result = $query->get_result();
    $i = 1;
    $grandTotal = 0;
    while ($row = $result->fetch_assoc()) : ?>
        <tr>
            <td scope="row"><?= $i ?></td>
            <td class="text-info d-inline"><img src="asset/img/product/<?= $row['product_image'] ?>" style="width:100px;height:100px;" alt="image.jpg">
                <h4 class=" d-inline"><?= $row['product_name'] ?></h4>
            </td>
            <td><?= $row['product_price'] ?></td>
            <td><input class="form-control form-qty" type="number" name="qty" value="<?= $row['qty'] ?>"></td>
            <td><?= $row['total_price'] ?> IDR </i></td>
            <td class="text-center"> <button type="button" class="btn btn-danger delete-single" data-id="<?= $row['id_cart'] ?>">Delete</button></td>
        </tr>
    <?php $i++;
        $grandTotal += $row['product_price'];
    endwhile; ?>
    <tr>
        <td colspan="3" class="text-center"><a href="index.php" class="btn btn-success">Lanjutkan untuk Berbelanja! <i class="fas fa-shopping-cart"></i></a></td>
        <td>
            <h3>GRAND TOTAL</h3>
        </td>
        <td>
            <h4><?= number_format($grandTotal) ?> IDR</h4>
        </td>
        <td><button type="button" class="btn btn-info"> <i class="fas fa-credit-card"></i> Checkout</button></td>
    </tr><?php
        } ?>