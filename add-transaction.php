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

    $fileCustomers = "data/customers.json";
    $dataJsonCustomer = file_get_contents($fileCustomers);
    $dataCustomers = json_decode($dataJsonCustomer, true);

    $fileProduct = "data/products.json";
    $dataJsonProducts = file_get_contents($fileProduct);
    $dataProducts = json_decode($dataJsonProducts, true);

    if (isset($_POST["addTransaction"])) {
        unset($_POST["addTransaction"]);
        if (isset($_POST["customerName"]) && isset($_POST["productName"]) && $_POST["quantity"]) {
            $productSelected = $dataProducts[$_POST["productName"]];
            $_POST["productName"] = $productSelected["productName"];
            $_POST["quantity"] = (int)$_POST["quantity"];
            $_POST["price"] = (int)$productSelected["price"];
            $_POST["total"] = (int)$productSelected["price"] * $_POST["quantity"];
            array_push($dataTransactions, $_POST);
            $dataJson = json_encode($dataTransactions, JSON_PRETTY_PRINT);
            file_put_contents($fileTransactions, $dataJson);
            $alertSuccess = true;
            header("Refresh:2; url=transactions.php");
        }
    };
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Transaction | SalesApp</title>

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

    <!-- Form -->
    <div class="container mt-3">
        <h1>Add Transaction</h1>
        <form action="" method="post" class="mt-3">
            <div class="mb-3">
                <label for="customerName" class="form-label">Customer Name :</label>
                <select class="form-select" aria-label="Default select example" name="customerName" id="customerName" required>
                    <option selected disabled hidden>-- Select Customer --</option>
                    <?php foreach($dataCustomers as $customer) : ?>
                        <option value="<?php echo $customer["name"] ?>"><?php echo $customer["name"] ?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="productName" class="form-label">Product Name and Price :</label>
                <select class="form-select" aria-label="Default select example" name="productName" id="productName" required>
                    <option selected disabled hidden>-- Select Product --</option>
                    <?php foreach($dataProducts as $key=>$product) : ?>
                        <option value="<?php echo $key ?>"><?php echo $product["productName"].' &nbsp;'.'Rp'. number_format($product["price"],0,",",".").'/unit'?></option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity :</label>
                <input value="<?php echo !$_POST ? '' : $_POST['quantity'] ?>" type="number" class="form-control" id="quantity" name="quantity">
            </div>
            <button type="submit" class="btn btn-primary mb-2 d-block" name="addTransaction">Add Transaction</button>
            <?php if (isset($alertSuccess)) {?>  
                <div class="alert alert-primary alert-dismissible" role="alert">
                    <div>Successfully added transaction</div>
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
                    <th>Customer Name</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th></th>
                </tr>
                <?php foreach($dataTransactions as $key=>$transaction) : ?>
                <tr>
                    <td><?php echo $key+1; ?></td>
                    <td><?php echo $transaction["customerName"]; ?></td>
                    <td><?php echo $transaction["productName"]; ?></td>
                    <td><?php echo 'Rp'.number_format($transaction["price"], 0, ",", "."); ?></td>
                    <td><?php echo $transaction["quantity"]; ?></td>
                    <td><?php echo 'Rp'.number_format($transaction["total"], 0, ",", "."); ?></td>
                    <td>
                        <a href="edit-transaction.php?key=<?php echo $key ?>" class="btn btn-primary">Edit</a>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <a href="transactions.php" class="btn btn-secondary mt-3 mb-5">Back</a>
    </div>

     <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  </body>
</html>