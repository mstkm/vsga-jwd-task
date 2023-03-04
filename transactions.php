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
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Transactions | SalesApp</title>

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

    <!-- Table -->
    <div class="container mt-3">
        <h1>Transactions</h1>
        <table class="table my-5">
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
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <div class="container p-0">
            <a href="add-transaction.php" type="button" class="btn btn-primary">Add or Edit</a>
        </div>
    </div>

     <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  </body>
</html>