<?php
    session_start();
    if( !isset($_SESSION["login"]) ) {
        header("Location: login.php");
        exit;
    }

    if (isset($_POST["logout"])) {
        $_SESSION = [];
        session_unset();
        session_destroy();
        header("Location: login.php");
        exit;
    }

    require_once('./vendor/autoload.php');
    $factory = new RandomLib\Factory;
    $generator = $factory->getGenerator(new SecurityLib\Strength(SecurityLib\Strength::MEDIUM));

    $fileProducts = "data/products.json";
    $dataJson = file_get_contents($fileProducts);
    $dataProducts = json_decode($dataJson, true);

    if (isset($_POST["addProduct"])) {
        unset($_POST["addProduct"]);
        $_POST["productId"] = $generator->generateString(5, 'abcdefg12345');
        $_POST["productId"] = htmlspecialchars($_POST["productId"]);
        $_POST["productName"] = htmlspecialchars($_POST["productName"]);
        $_POST["price"] = htmlspecialchars((int)$_POST["price"]);

        array_push($dataProducts, $_POST);
        $dataJson = json_encode($dataProducts, JSON_PRETTY_PRINT);
        file_put_contents($fileProducts, $dataJson);
        $alertSuccess = true;
        header("Refresh:2; url=products.php");
    };
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Product | SalesApp</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  </head>
  <body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary px-5">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">SalesApp</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="customers.php">Customer</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="products.php">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="transactions.php">Transactions</a>
                </li>
            </ul>
            <form action="" class="d-flex" role="search" method="post">
                <button class="btn btn-outline-primary" type="submit" name="logout">Logout</button>
            </form>
            </div>
        </div>
    </nav>

    <!-- Form -->
    <div class="container mt-3">
        <h1>Add Product</h1>
        <form action="" method="post" class="mt-3">
        <div class="mb-3">
                <label for="productId" class="form-label">Product ID :</label>
                <input value="<?php echo !$_POST ? '' : $_POST['productId'] ?>" placeholder="Input Product ID" type="text" class="form-control" id="productId" name="productId" required>
            </div>
            <div class="mb-3">
                <label for="productName" class="form-label">Product Name :</label>
                <input value="<?php echo !$_POST ? '' : $_POST['productName'] ?>" placeholder="Input Product Name" type="text" class="form-control" id="productName" name="productName" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price :</label>
                <input value="<?php echo !$_POST ? '' : $_POST['price'] ?>" placeholder="Input Price" type="number" class="form-control" id="price" name="price" required>
            </div>
            <button type="submit" class="btn btn-primary mb-2 d-block" name="addProduct">Add Product</button>
            <?php if (isset($alertSuccess)) {?>  
                <div class="alert alert-primary alert-dismissible" role="alert">
                    <div>Successfully added product</div>
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> -->
                </div>
            <?php } ?>
        </form>
    </div>

    <!-- Table -->
    <div class="container mt-5">
        <h1>Edit Product</h1>
        <table class="table">
            <tbody>
                <tr>
                    <th>No.</th>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th></th>
                </tr>
                <?php foreach($dataProducts as $key=>$product) : ?>
                <tr>
                    <td><?php echo $key+1; ?></td>
                    <td><?php echo $product["productId"]; ?></td>
                    <td><?php echo $product["productName"]; ?></td>
                    <td><?php echo $product["price"]; ?></td>
                    <td>
                        <a href="edit-product.php?key=<?php echo $key ?>" class="btn btn-primary">Edit</a>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <a href="products.php" class="btn btn-secondary mt-3 mb-5">Back</a>
    </div>

     <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  </body>
</html>