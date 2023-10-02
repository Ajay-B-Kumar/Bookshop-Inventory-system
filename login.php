<?php
session_start();
if (isset($_SESSION['username'])) {
  header("Location: welcome.php");
  exit;
}
require_once "config.php";

$username = $password = "";
$err = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  if (empty(trim($_POST['username'])) || empty(trim($_POST['password']))) {
    $err = "Please enter username and password";
  } else {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
  }
  if (empty($err)) {
    $sql = "SELECT id, username, password FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $param_username);
    $param_username = $username;

    if (mysqli_stmt_execute($stmt)) {
      mysqli_stmt_store_result($stmt);
      if (mysqli_stmt_num_rows($stmt) == 1) {
        mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
        if (mysqli_stmt_fetch($stmt)) {
          if (password_verify($password, $hashed_password)) {
            session_start();
            $_SESSION["username"] = $username;
            $_SESSION["id"] = $id;
            $_SESSION["loggedin"] = true;

            header('location: welcome.php');
          } else {
            $err = "Wrong username or password ";
          }
        }
      }
    }
  }
}
?>
<!doctype html>

<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
  <title>A2Z bookshop</title>
</head>


<body>
  <!-- Navigation Bar -->

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#" id="brand" style="margin:auto"> <img src="https://img.icons8.com/external-prettycons-flat-prettycons/45/000000/external-books-education-prettycons-flat-prettycons-1.png" /><strong> A2Z bookshop</strong> </a>
    <ul class="navbar-nav">
      <li class="nav-item" style="padding-right: 10px;">
        <a class="nav-link btn-dark-blue w-auto" style="padding: 8px; color:white; margin:auto;" href="register.php">SIGN UP</a>
      </li>
    </ul>
  </nav>

  <div class="login">

    <div class="container mt-4" name="login">
      <form action="" method="post">
        <h2>Login</h2>
        <hr>
        <?php
        if (!empty($err)) {
          echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        ' . $err . '<strong>, Try again</strong> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
        }
        ?>
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Username</label>
          <input type="text" class="form-control" id="exampleInputEmail1" name="username" placeholder="username">
        </div>
        <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label">Password</label>
          <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="password">
        </div>
        <h6>Not a member yet? <a href="register.php">Sign up here</a></h6>
        <div class="text-center">
          <button type="submit" class="btn btn-primary btn-dark-blue btn-rounded">Login</button>
        </div>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>

