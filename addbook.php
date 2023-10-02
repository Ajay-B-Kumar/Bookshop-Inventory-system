<?php include "template.php";
include "sidebar.php";
include "config.php";
$title = "";
$authors = "";
$date;
$isbn = "";
$desc = "";
$cover = "";
$images = "";
$genre = "";
$dbname = "booksdb";
$username = "user";
$password = "password";
$server = "localhost";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  $isbn = $_POST['isbn10'];
  $sql3 = "SELECT * FROM $dbname WHERE isbn10 = '%$isbn%'";
  $res = mysqli_query($conn, $sql3);
  $stmt = mysqli_prepare($conn, $sql3);
  if ($stmt) {
    $row = mysqli_fetch_assoc($res);
    if ($row > 0) {
      echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> Book is already in the database.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    } else {
      if (!empty(trim($_POST['title'])) && !empty(trim($_POST['authors'])) && !empty(trim($_POST['isbn10']))) {
        $param_title = trim($_POST['title']);
        $param_authors = trim($_POST['authors']);
        $param_date = trim($_POST['date']);
        $param_desc = trim($_POST['description']);
        $param_isbn10 = trim($_POST['isbn10']);
        $param_isbn13 = trim($_POST['isbn13']);
        $param_genre = trim($_POST['cat']);
        $filename = $_FILES["cover"]["name"];
        $tempname = $_FILES["cover"]["tmp_name"];
        $folder = "image/" . $filename;
        $sql2 = "INSERT INTO $dbname (`isbn13`, `isbn10`, `title`, `subtitle`, `authors`, `categories`, `description`, `published_year`, `thumbnail`) VALUES (?,?,?,?,?,?,?,?,'$filename')";
        $stmt = mysqli_prepare($conn, $sql2);
        if ($stmt) {
          mysqli_stmt_bind_param($stmt, "isssssss", $param_isbn13, $param_isbn10, $param_title, $param_subtitle, $param_authors, $param_genre, $param_desc, $param_date);
          if (mysqli_stmt_execute($stmt)) {
            if (!empty($filename)) {
              move_uploaded_file($tempname, $folder);
            }
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                  Book Added <strong>Successfully!</strong> 
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
          } else {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <strong>Error!</strong> Try again later
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
          }
        }
      } else {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
              Please Enter a title and authors name
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
      }
    }
    mysqli_stmt_close($stmt);
  }
}
?>

<link rel="stylesheet" href="style.css">
<div class="bookform">
  <h1>Add New Book</h1>
  <hr />
  <div class="form">
    <form action="" method="Post" enctype="multipart/form-data">
      <div class="book-container">
        <div class="row">
          <div class="col-sm">
            <label for="addname">Book Title</label>
            <input type="text" class="form-control" id="addname" name="title" required>
          </div>
        </div>
        <div class="row">
          <div class="col-sm">
            <label for="subtitle">Subtitle (If any)</label>
            <input type="text" class="form-control" id="subtitle" name="subtitle">
          </div>
          <div class="col-sm">
            <label for="authors">Author(s) Name</label>
            <input type="text" class="form-control" id="authors" name="authors" required>
          </div>
        </div>
        <div class="row">

          <div class="col-sm">
            <label for="isbn10">ISBN No. (10)</label>
            <input type="int" class="form-control" id="isbn10" name="isbn10" required>
          </div>
          <div class="col-sm">
            <label for="isbn13">ISBN No. (13)</label>
            <input type="int" class="form-control" id="isbn13" name="isbn13">
          </div>

        </div>
        <div class="row">
          <div class="col-sm">
            <label for="cover">Cover Image</label>
            <input type="file" class="form-control" id="isbn" name="cover" accept="image/*">
          </div>
          <div class="col-sm">
            <label for="date">Date of Publication</label>
            <input type="date" class="form-control" id="date" name="date">
          </div>
          <div class="col-sm-auto ">
            <label for="cat" style="margin-top: 10px;">Choose Categories</label><br>
            <select name="cat" id="cat">
              <?php for ($i = 0; $i < sizeof($cat); $i++) {
                $val = $cat[$i]; ?>
                <option value="<?php echo $val ?>" name="<?php echo $val ?>"><?php echo $val ?></option>
              <?php } ?>

            </select>
          </div>
        </div>
        <div class="row">
          <div class="col-sm">
            <label for="desc">Add Description</label>
            <textarea type="text" class="form-control" id="description" name="description" placeholder="Add description about the book (Max 800 words)"></textarea>
          </div>
        </div>
        <div class="btn-add text-center">
          <button type="submit" class="btn btn-primary btn-dark-blue btn-rounded">ADD</button>
        </div>
    </form>
  </div>

</div>

</div>
<?php include "footer.php"; ?>
<script type="text/javascript">
  var booklist = document.getElementById("booklist");
  var home = document.getElementById("home");
  var breadcrumb = document.getElementById("b1");
  var ol = document.createElement('li');
  let pre = document.getElementById("2");
  let a = document.createElement('a');
  const button = document.getElementByClass('btn-check');
  const paragraph = document.querySelector('p');
  console.log(breadcrumb.style.display);
  breadcrumb.style.display = "flex";
  pre.className = "breadcrumb-item";
  pre.innerHTML = "";
  a.href = "bookstore.php";
  a.textContent = "Books List";
  pre.appendChild(a);
  ol.className = "breadcrumb-item active";
  ol.textContent = "Add new book";
  breadcrumb.appendChild(ol);


  button.addEventListener('click', updateButton);

  function updateButton() {
    if (button.value === 'Start machine') {
      button.value = 'Stop machine';
      paragraph.textContent = 'The machine has started!';
    } else {
      button.value = 'Start machine';
      paragraph.textContent = 'The machine is stopped.';
    }
  }

  home.className = "nav-link not-active";
  booklist.className = "nav-link active";
</script>