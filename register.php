<?php
require_once "config.php";
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
$success = false;
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (empty(trim($_POST["username"]))) {
        $username_err = "Username cannot be blank";
    } else {
        $sql = "SELECT id FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = trim($_POST['username']);
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "This username is already taken";
                } else {
                    $username = trim($_POST['username']);
                }
            } else {
                echo "Something went wrong";
            }
        }
    }

    mysqli_stmt_close($stmt);

    if (empty(trim($_POST['password']))) {
        $password_err = "Password cannot be blank";
    } elseif (strlen(trim($_POST['password'])) < 5) {
        $password_err = "Password cannot be less than 5 characters";
    } else {
        $password = trim($_POST['password']);
    }

    if (trim($_POST['password']) !=  trim($_POST['confirm_password'])) {
        $password_err = "Passwords do not match";
    }

    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT);

            if (mysqli_stmt_execute($stmt)) {
                $success = true;
            } else {
                echo "Something went wrong... cannot redirect!";
            }
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
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
    <title>A2Zbookshop</title>
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#" style="margin:auto"><img src="https://img.icons8.com/external-prettycons-flat-prettycons/45/000000/external-books-education-prettycons-flat-prettycons-1.png" /><strong> A2Zbookshop</strong></a>
        <ul class="navbar-nav">
            <li class="nav-item" style="padding: 10px;">
            <a class="nav-link btn-dark-blue w-auto" style="padding: 8px; color:white; margin:auto;" href="login.php">LOGIN</a>
            </li>
        </ul>
    </nav>
    <div class="container mt-4" name="register">
        <form action="" method="post">
            <h2>Sign Up</h2>
            <hr> <?php
                    if ($success == true) {
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        Account created <strong>Successfully!</strong> Login <a href=login.php>here.</a>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
                    } else if (!empty($password_err)) {
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        ' . $password_err . '<strong>, Try again</strong> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
                    } else if (!empty($username_err)) {
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        ' . $username_err . '<strong>, Try again</strong> 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
                    }
                    ?>
            <script>
                function validate(el) {
                    if ($(el).val() == '') {
                        $(el).parent('div').addClass('has-error');
                    } else {
                        $(el).parent('div').removeClass('has-error');
                    }
                }
            </script>
            <div class="mb-3">
                <label for="exampleInputUsername1" class="form-label">Username</label>
                <input type="text" class="form-control" id="exampleInputUsername1" name="username" placeholder="Username" required>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Set Password</label>
                <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="Password" required>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword2" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" name="confirm_password" id="exampleInputPassword2" placeholder=" Re-enter password" required>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary btn-dark-blue btn-rounded">Sign up</button>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>