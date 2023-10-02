<?php
include "config.php";
include "template.php";
$start = 1;
$val = 10;
$current = $start;
$c = (isset($_GET['c'])) ? $_GET['c'] : ""; // categories mode 
$search = (isset($_GET['search'])) ? $_GET['search'] : "";
$active = 'active';
$per_page = isset($_POST["limit-records"]) ? $_POST["limit-records"] : (isset($_GET['val']) ? $_GET['val'] : $val);
$tempid = 0;
$id = 1;

?>
<link rel="stylesheet" href="style.css" type="text/css">
<style>
    body {
    margin: 0;
    padding: 0;
    width: 100%;
    height: 100%;
    background: white no-repeat center fixed;
    background-size: cover;
}

</style>
<?php
include "sidebar.php";
if (isset($_GET['start'])) {
  $start = $_GET['start'];
  $current = $start;
  $start--;
  $tempid = $start;
  $start *= $per_page;
}

if (isset($_GET['search'])) {
  $first = ($start == 0) ? 0 : $start - 1;
  $search =  mysqli_real_escape_string($conn, $_GET['search']);
  if (isset($_GET['c'])) {
    $sql1 = "SELECT * FROM $db WHERE categories like '%$search%' ORDER BY title LIKE '%$search%' DESC ";
    $sql2 = "SELECT * FROM $db WHERE categories like '%$search%' ORDER BY title LIKE '%$search%' DESC limit $first,$per_page";
  } else {
    $sql1 = "SELECT * FROM $db WHERE title like '%$search%' or authors like '%$search%' or categories like '%$search%'  or description like '%$search%'  ORDER BY title LIKE '%$search%' DESC ";
    $sql2 = "SELECT * FROM $db WHERE title like '%$search%' or authors like '%$search%' or categories like '%$search%' or description like '%$search%'  ORDER BY title LIKE '%$search%' DESC limit $first,$per_page";
    
  }
} else {
  $sql1 = "SELECT * FROM $db ";
  $sql2 = "SELECT * FROM $db LIMIT $start,$per_page " ;
}

$record = mysqli_num_rows(mysqli_query($conn, $sql1));
if(isset($_GET['search'])){
  echo '<div class="alert alert-success mt-2 text-center h3" role="alert">Showing '.$record .' results for <strong>"'. $search.'"</strong></div>';
}
$pages = ceil($record / $per_page);
$res = mysqli_query($conn, $sql2);
if ($current > $pages || $current < 1) {
  if (mysqli_fetch_assoc($res) != 0) {
    echo '<script> location.replace("?start=1&val=10"); </script>';
  } else {
    echo '<script> location.replace("\error.php"); </script>';
  }
}

$stmt = mysqli_prepare($conn, $sql2);
if ($stmt) {
  $id =  ($start == 1) ? 1 : (1 + $start);
?>

  <div class="container mb-5" id="table" name="Books-list">
    <div class=" col-auto my-1">
      <div class="alert alert-dark mt-2" role="alert">
        <form action="" method="POST">
          <label class="mr-sm-2" for="limit-records">Show </label>
          <select class="custom-select mr-sm-2" id="limit-records" name="limit-records">
            <?php
            for ($i = 10; $i <= 50; $i += 5) { ?>
              <option <?php echo (isset($_GET['val']) && ($i == $per_page) ? 'selected' : ''); ?> name="entry" value="<?= $i; ?>"><?= $i; ?></option>
            <?php }
            ?>
          </select>

          <label class="mr-sm-2" for="limit-records"> entries </label><br>
          <?php echo "<strong>Showing " . $current . " of " . $pages . " pages</strong>";
          ?>

      </div>
      </form>
    </div>
    <table class=" table mt-3 table-striped table-bordered table-hover table-light">
      <thead class="table-dark">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Cover</th>
          <th scope="col">Title</th>
          <th scope="col">Author-Name</th>
          <th scope="col">ISBN</th>
          <th scope="col">Genre</th>
        </tr>
      </thead>
      <?php
      while ($row = mysqli_fetch_assoc($res)) {
      ?>
        <tr>
          <td> <?php echo $id ?> </td>
          <td> <a href='BookDetails.php?no=<?php echo htmlspecialchars($row['isbn10']) ?>'><img src=" <?php
                                                                                                      if (filter_var(htmlspecialchars($row['thumbnail']), FILTER_VALIDATE_URL) == false) {
                                                                                                        echo 'image/';
                                                                                                      }
                                                                                                      echo htmlspecialchars($row['thumbnail']);
                                                                                                      ?>" width="128px" alt="Cover not available" onerror=" this.src='https://cdn-d8.nypl.org/s3fs-public/blogs/sJ3CT4V.gif';"></a> </td>
          <td> <?php echo htmlspecialchars($row['title']) ?></td>
          <td> <?php echo htmlspecialchars($row['authors']) ?></td>
          <td> <?php echo htmlspecialchars($row['isbn10']) ?></td>
          <td> <?php echo htmlspecialchars($row['categories']) ?></td>
        </tr>
      <?php $id++;
      }

      ?>
    </table>
    <nav aria-label="Page navigation example" style="width:fit-content; margin:0 auto;">
      <ul class="pagination justify-content-center pagination-2">
        <li class="page-item <?php echo ($current == 1) ? 'disabled' : ' '; ?>" data-bs-toggle="tooltip" data-bs-placement="left" title="Go to First page">
          <a class="page-link" href="<?php
                                      if ($search != "") {
                                        if($c != ""){
                                          echo '?c='.$c.'&search=' . $search . '&';
                                        }
                                        else {echo '?search=' . $search . '&';}
                                      } else {
                                        echo '?';
                                      }  ?>start=1&val=<?= $per_page; ?>" aria-label="Start">
            <span aria-hidden="true">&laquo;&laquo;</span>
          </a>
        </li>
        <li class="page-item <?php echo ($current == 1) ? 'disabled' : ' '; ?>">
          <a class="page-link " id="previous" href="<?php
                                                    if ($search != "") {
                                                      if($c != ""){
                                                        echo '?c='.$c.'&search=' . $search . '&';
                                                      }
                                                      else {echo '?search=' . $search . '&';}
                                                    } else {
                                                      echo '?';
                                                    }
                                                    ?>start=<?php
                                                              if ($current > 10) {
                                                                echo ($current - 10);
                                                              } else if ($current > 1) {
                                                                echo ($current - 1);
                                                              } else {
                                                                echo ($current);
                                                              }
                                                              ?>&val=<?= $per_page; ?>" tabindex="-1">Previous</a>
        </li>

        <?php
        $p1 = ($current <= 5) ? 1 : $current - 5;
        $p2 = ($current >= $pages - 5) ? $pages : $current + 5;
        for ($i = $p1; $i <= $p2; $i++) {
          echo '<li class="page-item';
          if ($i == $current) {
            echo ' active';
          }
          echo '"><a class="page-link " href="';
          if ($search != "") {
            if($c != ""){
              echo '?c='.$c.'&search=' . $search . '&';
            }
            else {echo '?search=' . $search . '&';}
          } else {
            echo '?';
          }
          echo 'start=' . $i . '&val=' . $per_page . '">' . $i . '</a></li>';
        }
        ?>
        <li class="page-item <?php echo ($current == $pages) ? 'disabled' : ' '; ?>">
          <a class="page-link" id="next" href="<?php
                                                if ($search != "") {
                                                  if($c != ""){
                                                    echo '?c='.$c.'&search=' . $search . '&';
                                                  }
                                                  else {echo '?search=' . $search . '&';}
                                                } else {
                                                  echo '?';
                                                } ?>start=<?php

                                                          if ($current < $pages - 10) {
                                                            echo ($current + 10);
                                                          } else if ($current < $pages) {
                                                            echo ($current + 1);
                                                          } else {
                                                            echo ($current);
                                                          }
                                                          ?>&val=<?= $per_page; ?>
      ">Next</a>
        <li class="page-item <?php echo ($current == $pages) ? 'disabled' : ' '; ?>" data-bs-toggle="tooltip" data-bs-placement="right" title="Go to Last page">
          <a class="page-link" href="<?php
                                      if ($search != "") {
                                        if($c != ""){
                                          echo '?c='.$c.'&search=' . $search . '&';
                                        }
                                        else {echo '?search=' . $search . '&';}
                                      } else {
                                        echo '?';
                                      } ?>start=<?php echo $pages ?>&val=<?= $per_page; ?>" aria-label="End">
            <span aria-hidden="true">&raquo;&raquo;</span>
          </a>
        </li>
        </li>
      </ul>
    </nav>
    <div class="col-auto my-1 text-center">
      <a class="btn btn-primary btn-dark-blue btn-rounded mb- justify-content-center" href="addbook.php" name="ADD" role="button">Add new book</a>
    </div>

  </div><?php
      }
      include "footer.php";
      mysqli_stmt_close($stmt);
        ?>
<script type="text/javascript">
  var booklist = document.getElementById("booklist");
  var home = document.getElementById("home");
  var breadcrumb = document.getElementById("b1");
  console.log(breadcrumb.style.display);
  breadcrumb.style.display = "flex";
  home.className = "nav-link not-active";
  booklist.className = "nav-link active";
  $(document).ready(function() {
    $("#limit-records").change(function() {
      $('form').submit();
    })
  })

</script>