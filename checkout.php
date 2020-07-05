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
            <li class="nav-item active">
                <a class="nav-link" href="checkout.php">Checkout</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="orders.php">Orders</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="cart.php"><i class="fas fa-shopping-cart fa-fw"></i><span class="badge badge-success mx-2 label-item-cart">1</span></a>
            </li>
        </ul>
    </div>
</nav>
<?php if (getNumCart() > 0) : ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 mt-4" id="order">
                <div class="card">
                    <div class="alert alert-success text-center" role="alert">
                        List Order : <?= listorder(1) ?>
                        <h5>Ongkos Kirim = <strong>FREE</strong></h5>
                        <h6>Total Biaya Order : Rp. <?= number_format(listorder(0)) ?></h6>
                    </div>
                    <form action="">
                        <div class="card-body">
                            <input type="hidden" name="listorder" value="<?= listorder(1) ?>">
                            <input type="hidden" name="grandtotal" value="<?= listorder(0) ?>">
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="text" name="email" id="email" class="form-control" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <label for="phone">Telephone</label>
                                <input type="text" name="phone" id="phone" class="form-control" placeholder="Telephone">
                            </div>
                            <div class="form-group">
                                <label for="address">Alamat</label>
                                <textarea class="form-control" name="address" id="address" rows="3"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="payment">Pembayaran</label>
                                <select class="form-control" name="payment" id="payment">
                                    <option>Cash On Delivery</option>
                                </select>
                            </div>
                            <button type="submit" id="placeorder" class="btn btn-danger w-100">Place Order</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php else : setFlashdata(swNotif('warning', 'Pemberitahuan', 'Mohon untuk memasukan barang ke cart terlebih dahulu'));
    header('Location: index.php');
endif; ?>
<div class="message">

</div>

<body>
    <script src="asset/js/bootstrap.min.js"></script>
    <script src="asset/js/all.min.js"></script>
    <script src="asset/js/sweetalert2.min.js"></script>
    <script src="asset/js/script.js"></script>
</body>

</html>