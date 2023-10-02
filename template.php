<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
  header("Location: login.php");
}

$cat = array("Fiction", "Adventure", "Fantasy",  "Juvenile Fiction", "Detective", "History", "Science", "Biography & Autobiography", "Philosophy");
$aut = array("J. K. Rowling", "Agatha Christie", "J. R. R. Tolkien", "Terry Pratchett", "Paulo Coelho", "Mark Twain", "C. S. Lewis", "Mary Stewart");
?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->

  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

  <link rel="stylesheet" href="style.css" type="text/css">
  <title>A2Z Bookshop</title>
</head>

<body>
  <script>
    $(document).ready(function(){
    $('[data-toggle="popover"]').popover();   
});


  </script>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="navbar">

    <a class="navbar-brand" href="welcome.php" style="margin-left: 20px;"><img src="https://img.icons8.com/external-prettycons-flat-prettycons/45/000000/external-books-education-prettycons-flat-prettycons-1.png" /><strong> A2Z Bookshop</strong></a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <div class="navbar-collapse collapse">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item ms-auto">
            <div class="container-fluid">
              <form action="bookstore.php" class="d-flex" method="GET">
                <input class="form-control" type="search" placeholder="Search for Books" aria-label="Search" name="search">
                <button class="btn btn-dark-green " type="submit">Search</button>
              </form>
            </div>

          </li>
          <li class="nav-item active" id="username">
            <a href="#" class="nav-link"> <img class="icon" src="https://img.icons8.com/metro/26/fffff8/guest-male.png"> <?php echo "Welcome " . $_SESSION['username'] ?></a>
          </li>

          <li class="nav-item ms-auto" id="logout-btn">
          <a class="nav-link" href="logout.php"> <img class="icon" src="https://img.icons8.com/material/26/fffff8/exit.png"/>  Logout</a>
          </li>

        </ul>

      </div>
    </div>
  </nav>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>