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

    $fileTransactions = "data/transactions.json";
    $dataJson = file_get_contents($fileTransactions);
    $dataTransactions = json_decode($dataJson, true);
    $key = $_GET["key"];
    $transaction = $dataTransactions[$key];

    if (isset($_POST["editTransaction"])) {
        unset($_POST["editTransaction"]);
        $_POST["quantity"] = (int)$_POST["quantity"];
        $_POST["price"] = (int)$_POST["price"];
        $_POST["total"] = (int)$_POST["price"] * $_POST["quantity"];
        $dataTransactions[$key] = $_POST;
        $dataJson = json_encode($dataTransactions, JSON_PRETTY_PRINT);
        file_put_contents($fileTransactions, $dataJson);
        $alertSuccessEdit = true;
        header("Refresh:2; url=transactions.php");
    };

    if (isset($_POST["deleteTransaction"])) {
        unset($dataTransactions[$key]);
        $dataJson = json_encode($dataTransactions, JSON_PRETTY_PRINT);
        file_put_contents($fileTransactions, $dataJson);
        $alertSuccessDelete = true;
        header("Refresh:2; url=transactions.php");
    };
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Transaction | SalesApp</title>

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
                    <a class="nav-link" href="products.php">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="transactions.php">Transactions</a>
                </li>
            </ul>
            <form action="" class="d-flex" role="search" method="post">
                <button class="btn btn-outline-primary" type="submit" name="logout">Logout</button>
            </form>
            </div>
        </div>
    </nav>

    <div class="container mt-3">
        <h1>Transaction</h1>
        <form action="" method="post" class="mt-3">
            <div class="mb-3">
                <label for="customerName" class="form-label">Product ID :</label>
                <input value="<?php echo !$_POST ? $transaction['customerName']  : $_POST['customerName'] ?>" type="text" class="form-control" id="customerName" name="customerName" required>
            </div>
            <div class="mb-3">
                <label for="productName" class="form-label">Product Name :</label>
                <input value="<?php echo !$_POST ? $transaction['productName']  : $_POST['productName'] ?>" type="text" class="form-control" id="productName" name="productName" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price :</label>
                <input value="<?php echo !$_POST ? $transaction['price']  : $_POST['price'] ?>" type="number" class="form-control" id="address" name="price" required>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity :</label>
                <input value="<?php echo !$_POST ? $transaction['quantity']  : $_POST['quantity'] ?>" type="number" class="form-control" id="address" name="quantity" required>
            </div>
            <button type="submit" class="btn btn-primary" name="editTransaction">Edit</button>
            <button type="submit" class="btn btn-danger" name="deleteTransaction" onclick="confirm('Are you sure?')">Delete</button>
            <a href="add-transaction.php" class="btn btn-secondary">Cancel</a>
            <?php if (isset($alertSuccessEdit)) {?>  
                <div class="alert alert-primary alert-dismissible mt-3" role="alert">
                    <div>Transaction Edited</div>
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> -->
                </div>
            <?php } ?>
            <?php if (isset($alertSuccessDelete)) {?>  
                <div class="alert alert-danger alert-dismissible mt-3" role="alert">
                    <div>Transaction Deleted</div>
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> -->
                </div>
            <?php } ?>
        </form>
    </div>

     <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  </body>
</html>