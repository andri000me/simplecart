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
            <li class="nav-item active">
                <a class="nav-link" href="index.php">Product</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="checkout.php">Checkout</a>
            </li>
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
<div class="container my-2 text-right">
    <button type="button" class="btn btn-success" data-target="#addproductmodal" data-toggle="modal">Add product</button>
</div>
<div class="container">
    <div class="row my-2">
        <?php
        $stmt = $db->prepare("SELECT * FROM product");
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) : ?>
            <div class="col-md-3 col-6 my-2" style="height: 400px;">
                <div class="card text-center h-100">
                    <img class="card-img-top h-50" src="asset/img/product/<?= $row['product_image'] ?>" alt="">
                    <div class="card-body">
                        <h2 class="card-title text-info h-50"><?= $row['product_name'] ?></h2>
                        <h4 class="card-text text-danger h-25">Rp. <?= number_format($row['product_price']) ?></h4>
                        <button type="button" class="btn btn-info tambah-cart " data-id="<?= $row['id_product'] ?>">Add Cart <i class="fas fa-shopping-cart"></i></button>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<!-- ALL Modal -->

<!-- Modal Add Product -->
<div class="modal fade" id="addproductmodal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="config/process.php" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title">Add Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="form-group">
                            <label for="productname">Product Name <span class=" text-danger">*</span></label>
                            <input type="text" name="productname" id="productname" class="form-control" placeholder="Product Name" required>
                        </div>
                        <div class="form-group">
                            <label for="productprice">Product Price <span class=" text-danger">*</span></label>
                            <input type="number" name="productprice" id="productprice" class="form-control" placeholder="Product Price" required>
                        </div>
                        <div class="form-group">
                            <label for="productiamge">Product Image <span class=" text-danger">*</span></label>
                            <input type="file" class="form-control-file" id="productimage" name="productimage">
                        </div>
                        <div class="form-group">
                            <label for="productcode">Product Code <span class=" text-danger">*</span></label>
                            <input type="text" name="productcode" id="productcode" class="form-control" placeholder="Product Code" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-left">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="addproduct" class="btn btn-primary">Add Product</button>
                </div>
            </form>
        </div>
    </div>
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