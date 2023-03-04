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

    $fileCustomers = "data/customers.json";
    $dataJson = file_get_contents($fileCustomers);
    $dataCustomers = json_decode($dataJson, true);
    $key = $_GET["key"];
    $customer = $dataCustomers[$key];

    if (isset($_POST["editCustomer"])) {
        unset($_POST["editCustomer"]);
        $_POST["name"] = htmlspecialchars($_POST["name"]);
        $_POST["phoneNumber"] = htmlspecialchars($_POST["phoneNumber"]);
        $_POST["address"] = htmlspecialchars($_POST["address"]);
        $dataCustomers[$key] = $_POST;
        $dataJson = json_encode($dataCustomers, JSON_PRETTY_PRINT);
        file_put_contents($fileCustomers, $dataJson);
        $alertSuccessEdit = true;
        header("Refresh:2; url=customers.php");
    };

    if (isset($_POST["deleteCustomer"])) {
        unset($dataCustomers[$key]);
        $dataJson = json_encode($dataCustomers, JSON_PRETTY_PRINT);
        file_put_contents($fileCustomers, $dataJson);
        $alertSuccessDelete = true;
        header("Refresh:2; url=customers.php");
    };
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sales Application</title>

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
                    <a class="nav-link active" href="customers.php">Customer</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="products.php">Products</a>
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

    <div class="container mt-3">
        <h1>Customer</h1>
        <form action="" method="post" class="mt-3">
            <div class="mb-3">
                <label for="name" class="form-label">Name :</label>
                <input value="<?php echo !$_POST ? $customer['name']  : $_POST['name'] ?>" type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="phoneNumber" class="form-label">Phone Number :</label>
                <input value="<?php echo !$_POST ? $customer['phoneNumber']  : $_POST['phoneNumber'] ?>" type="text" class="form-control" id="phoneNumber" name="phoneNumber" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address :</label>
                <input value="<?php echo !$_POST ? $customer['address']  : $_POST['address'] ?>" type="text" class="form-control" id="address" name="address" required>
            </div>
            <button type="submit" class="btn btn-primary" name="editCustomer">Edit</button>
            <button type="submit" class="btn btn-danger" name="deleteCustomer" onclick="confirm('Are you sure?')">Delete</button>
            <a href="add-customer.php" class="btn btn-secondary">Cancel</a>
            <?php if (isset($alertSuccessEdit)) {?>  
                <div class="alert alert-primary alert-dismissible mt-3" role="alert">
                    <div>Customer Edited</div>
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> -->
                </div>
            <?php } ?>
            <?php if (isset($alertSuccessDelete)) {?>  
                <div class="alert alert-danger alert-dismissible mt-3" role="alert">
                    <div>Customer Deleted</div>
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> -->
                </div>
            <?php } ?>
        </form>
    </div>

     <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  </body>
</html>