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

    if (isset($_POST["addCustomer"])) {
        unset($_POST["addCustomer"]);
        $_POST["name"] = htmlspecialchars($_POST["name"]);
        $_POST["phoneNumber"] = htmlspecialchars($_POST["phoneNumber"]);
        $_POST["address"] = htmlspecialchars($_POST["address"]);

        array_push($dataCustomers, $_POST);
        $dataJson = json_encode($dataCustomers, JSON_PRETTY_PRINT);
        file_put_contents($fileCustomers, $dataJson);
        $alertSuccess = true;
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
        <h1>Add Customer</h1>
        <form action="" method="post" class="mt-3">
        <div class="mb-3">
                <label for="name" class="form-label">Name :</label>
                <input value="<?php echo !$_POST ? '' : $_POST['name'] ?>" placeholder="Input Name"  type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="phoneNumber" class="form-label">Phone Number :</label>
                <input value="<?php echo !$_POST ? '' : $_POST['phoneNumber'] ?>" placeholder="Input Phone Number" type="number" class="form-control" id="phoneNumber" name="phoneNumber" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address :</label>
                <input value="<?php echo !$_POST ? '' : $_POST['address'] ?>" placeholder="Input Address"  type="address" class="form-control" id="address" name="address" required>
            </div>
            <button type="submit" class="btn btn-primary mb-2 d-block" name="addCustomer">Add Customer</button>
            <?php if (isset($alertSuccess)) {?>  
                <div class="alert alert-primary alert-dismissible" role="alert">
                    <div>Successfully added customer</div>
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> -->
                </div>
            <?php } ?>
        </form>
    </div>

    <div class="container mt-5">
        <h1>Edit Customers</h1>
        <table class="table">
            <tbody>
                <tr>
                    <th>No.</th>
                    <th>Name</th>
                    <th>Phone Number</th>
                    <th>Address</th>
                    <th></th>
                </tr>
                <?php foreach($dataCustomers as $key=>$customer) : ?>
                <tr>
                    <td><?php echo $key+1; ?></td>
                    <td><?php echo $customer["name"]; ?></td>
                    <td><?php echo $customer["phoneNumber"]; ?></td>
                    <td><?php echo $customer["address"]; ?></td>
                    <td>
                        <a href="edit-customer.php?key=<?php echo $key ?>" class="btn btn-primary">Edit</a>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <a href="customers.php" class="btn btn-secondary mt-3 mb-5">Back</a>
    </div>

     <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  </body>
</html>