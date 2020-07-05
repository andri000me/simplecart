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

        .img-product {
            height: 100%;
            width: 100%;
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
            <li class="nav-item">
                <a class="nav-link" href="orders.php">Orders</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="cart.php"><i class="fas fa-shopping-cart fa-fw"></i><span class="badge badge-success mx-2 label-item-cart">1</span></a>
            </li>
        </ul>
    </div>
</nav>
<div class="container my-2 text-center">
    <h3>Product in your Cart!</h3>
</div>
<div class="container">
    <table class="table table-hover table-responsive-xs table-responsive-sm">
        <thead>
            <tr>
                <th>#</th>
                <th>Product</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Total</th>
                <th class="text-center"><button type="button" class="btn btn-danger" id="delete-all">Delete All</button></th>
            </tr>
        </thead>
        <tbody class="data-cart">
            <?php
            $query = $db->prepare('SELECT * FROM cart');
            $query->execute();
            $result = $query->get_result();
            $i = 1;
            while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td scope="row"><?= $i ?></td>
                    <td class="text-info d-inline"><img src="asset/img/product/<?= $row['product_image'] ?>" style="width:100px;height:100px;" alt="image.jpg">
                        <h4 class=" d-inline"><?= $row['product_name'] ?></h4>
                    </td>
                    <td class="price"><?= $row['product_price'] ?></td>
                    <td><input class=" form-control form-qty" type="number" name="qty" value="<?= $row['qty'] ?>"></td>
                    <td class="total-price"><?= $row['total_price'] ?> IDR </i></td>
                    <td class="text-center"> <a href="cart_ajax.php?delSingle=deletesingle&id=<?= $row['id_cart'] ?>" class="btn btn-danger delete-single" data-id="<?= $row['id_cart'] ?>">Delete</a></td>
                </tr>
            <?php $i++;
            endwhile; ?>
            <tr>
                <td colspan="3" class="text-center"><a href="index.php" class="btn btn-success">Lanjutkan untuk Berbelanja! <i class="fas fa-shopping-cart"></i></a></td>
                <td>
                    <h3>GRAND TOTAL</h3>
                </td>
                <td>
                    <h4 class="total"><?= number_format($grandTotal) ?> IDR</h4>
                </td>
                <td><a href="checkout.php" class="btn btn-info"> <i class="fas fa-credit-card"></i> Checkout</a></td>
            </tr>
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