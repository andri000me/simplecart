<?php require_once 'config/main.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Cart</title>
    <link rel="stylesheet" href="asset/css/bootstrap.min.css">
    <link rel="stylesheet" href="asset/css/all.min.css">
    <link rel="stylesheet" href="asset/css/sweetalert2.min.css">
    <script src="asset/js/jquery-3.5.1.min.js"></script>
    <style>
        button:focus {
            outline: none;
        }
    </style>
</head>
<?php
flashdata();
?>
<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Simple Cart</a>
    <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavId">
        <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Product</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="checkout.php">Checkout</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="orders.php">Orders</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="cart.php"><i class="fas fa-shopping-cart fa-fw"></i><span class="badge badge-success mx-2 label-item-cart">1</span></a>
            </li>
        </ul>
    </div>
</nav>
<div class="container-fluid text-center bg-success text-white">
    <h2>List Orders</h2>
</div>
<div class="container-fluid">
    <table class="table table-hover table-dark table-responsive">
        <thead class="thead-default">
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Email</th>
                <th>No telp.</th>
                <th>Alamat</th>
                <th>Metode Pembayaran</th>
                <th>Produk</th>
                <th>Harga Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $stmt  = $db->prepare("SELECT * FROM orders");
            $stmt->execute();
            $r = $stmt->get_result();
            $no = 1;
            while ($row = $r->fetch_assoc()) : ?>
                <tr>
                    <td scope="row"><?= $no ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['email'] ?></td>
                    <td><?= $row['phone'] ?></td>
                    <td><?= $row['address'] ?></td>
                    <td><?= $row['pmode'] ?></td>
                    <td><?= $row['product'] ?></td>
                    <td><?= $row['amount_paid'] ?></td>
                </tr>
            <?php $no++;
            endwhile; ?>
        </tbody>
    </table>
</div>
<div class="message">

</div>

<body>
    <script src="asset/js/bootstrap.min.js"></script>
    <script src="asset/js/all.min.js"></script>
    <script src="asset/js/sweetalert2.min.js"></script>
    <script src="asset/js/script.js"></script>
</body>

</html>