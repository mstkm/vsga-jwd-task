<?php
    session_start();
    if( isset($_SESSION["login"]) ) {
        header("Location: index.php");
        exit;
    }
    if (isset($_POST["login"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];
        if ($username === "Admin" && $password === '123') {
            $_SESSION["login"] = true;
            header("Location: index.php");
        } else {
            $error = true;
        };
    }
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
    <div class="position-absolute top-50 start-50 translate-middle">
        <h1 class="mb-5">Login to SalesApp</h1>
        <?php if( isset($error) ) : ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                    <div>Wrong username or password</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
        <?php endif; ?>
        <form action="" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username :</label>
                <input type="text" class="form-control" id="username" name="username">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password :</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <button type="submit" class="btn btn-primary" name="login">Login</button>
        </form>
    </div>

     <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  </body>
</html>