<?php include "template.php";
include "config.php";
$start = 1;
$val = 20;
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
        $sql1 = "SELECT * FROM $db WHERE categories like '%$search%' ORDER BY title LIKE '%$search%' DESC";
        $sql2 = "SELECT * FROM $db WHERE categories like '%$search%' ORDER BY title LIKE '%$search%' DESC limit $first,$per_page";
    } else {
        $sql1 = "SELECT * FROM $db WHERE title like '%$search%' or authors like '%$search%' or categories like '%$search%'  or description like '%$search%'  ORDER BY title LIKE '%$search%' DESC ";
        $sql2 = "SELECT * FROM $db WHERE title like '%$search%' or authors like '%$search%' or categories like '%$search%' or description like '%$search%'  ORDER BY title LIKE '%$search%' DESC limit $first,$per_page";
    }
} else {
    $sql1 = "SELECT * FROM $db ";
    $sql2 = "SELECT * FROM $db LIMIT $start,$per_page";
}

$record = mysqli_num_rows(mysqli_query($conn, $sql1));
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
    <div class="sidebar">
        <?php include "sidebar.php"; ?>
    </div>
    <div class="image">

        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="background first">
                        <div class="box-main">
                            <div class="firsthalf">

                                <p class="text-big"> <img src="https://img.icons8.com/color/36/000000/quote-left.png" /> A good bookshop is not just about selling books from shelves, but reaching out into the world and making a difference. <img src="https://img.icons8.com/color/36/000000/quote-right.png" /> </p>

                                <p class="text-small text-center">~David Almond</p>
                            </div>
                        </div>
                        <br>
                        <br>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="background second">
                        <div class="box-main">
                            <div class="firsthalf">

                                <p class="text-big"> <img src="https://img.icons8.com/color/36/000000/quote-left.png" /> What I say is, a town isn’t a town without a bookstore. It may call itself a town, but unless it’s got a bookstore, it knows it’s not fooling a soul. <img src="https://img.icons8.com/color/36/000000/quote-right.png" /> </p>

                                <p class="text-small text-center">~Neil Gaiman</p>
                            </div>
                        </div>
                        <br>
                        <br>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="background third">
                        <div class="box-main">
                            <div class="firsthalf">

                                <p class="text-big"> <img src="https://img.icons8.com/color/36/000000/quote-left.png" /> I love walking into a bookstore.  It’s like all my <br> friends are sitting on shelves, waving their pages at me. <img src="https://img.icons8.com/color/36/000000/quote-right.png" /> </p>

                                <p class="text-small text-center">~Tahereh Mafi</p>
                            </div>
                        </div>
                        <br>
                        <br>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

    </div>
    <div class="heading">
        <h1 style="text-align: center; font-family: 'Lobster Two', cursive; font-size:50px; margin-top:20px" id="Best-books">Best Selling Books</h1>
        <hr>
    </div>
    <div class="container">
        <hr>
        <div class="row">
            <?php

            while ($row = mysqli_fetch_assoc($res)) {
            ?>

                <div class="col-sm-3">
                    <div class="card" style="width: 225px; height:515px; margin-top:5px;">
                        <a href='BookDetails.php?no=<?php echo htmlspecialchars($row['isbn10']) ?>'><img class="card-img-top" src=" <?php
                                                                                                                                    if (filter_var(htmlspecialchars($row['thumbnail']), FILTER_VALIDATE_URL) == false) {
                                                                                                                                        echo 'image/';
                                                                                                                                    }
                                                                                                                                    echo htmlspecialchars($row['thumbnail']);
                                                                                                                                    ?>" width="128px" height="300
                                                                                                                                px" alt="Cover not available" onerror=" this.src='https://cdn-d8.nypl.org/s3fs-public/blogs/sJ3CT4V.gif';"></a>
                        <div class="card-body ">
                            <h5 class="card-title" style="height:25px; overflow:hidden; text-overflow:ellipsis;"> <?php echo htmlspecialchars($row['title']) ?></h5>
                            <p class="card-text" style="height:100px; overflow:hidden; text-overflow:ellipsis;
                            "><?php echo htmlspecialchars($row['description']) ?></p>
                            <div class="text-center">
                            <a href="BookDetails.php?no=<?php echo htmlspecialchars($row['isbn10']) ?>" class="btn btn-primary">Read More >></a>
                            </div>
                        </div>
                    </div>
                </div>

            <?php $id++;
            }
            ?>
            <nav aria-label="Page navigation example" style="width:fit-content; margin:0 auto;">
                <ul class="pagination justify-content-center pagination-lg">
                    <li class="page-item <?php echo ($current == 1) ? 'disabled' : ' '; ?>" data-bs-toggle="tooltip" data-bs-placement="left" title="Go to First page">
                        <a class="page-link" href="<?php
                                                    if ($search != "") {
                                                        if ($c != "") {
                                                            echo '?c=' . $c . '&search=' . $search . '&';
                                                        } else {
                                                            echo '?search=' . $search . '&';
                                                        }
                                                    } else {
                                                        echo '?';
                                                    }  ?>start=1&val=<?= $per_page; ?>" aria-label="Start">
                            <span aria-hidden="true">&laquo;&laquo;</span>
                        </a>
                    </li>
                    <li class="page-item <?php echo ($current == 1) ? 'disabled' : ' '; ?>">
                        <a class="page-link " id="previous" href="<?php
                                                                    if ($search != "") {
                                                                        if ($c != "") {
                                                                            echo '?c=' . $c . '&search=' . $search . '&';
                                                                        } else {
                                                                            echo '?search=' . $search . '&';
                                                                        }
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
                            if ($c != "") {
                                echo '?c=' . $c . '&search=' . $search . '&';
                            } else {
                                echo '?search=' . $search . '&';
                            }
                        } else {
                            echo '?';
                        }
                        echo 'start=' . $i . '&val=' . $per_page . '">' . $i . '</a></li>';
                    }
                    ?>
                    <li class="page-item <?php echo ($current == $pages) ? 'disabled' : ' '; ?>">
                        <a class="page-link" id="next" href="<?php
                                                                if ($search != "") {
                                                                    if ($c != "") {
                                                                        echo '?c=' . $c . '&search=' . $search . '&';
                                                                    } else {
                                                                        echo '?search=' . $search . '&';
                                                                    }
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
                                                        if ($c != "") {
                                                            echo '?c=' . $c . '&search=' . $search . '&';
                                                        } else {
                                                            echo '?search=' . $search . '&';
                                                        }
                                                    } else {
                                                        echo '?';
                                                    } ?>start=<?php echo $pages ?>&val=<?= $per_page; ?>" aria-label="End">
                            <span aria-hidden="true">&raquo;&raquo;</span>
                        </a>
                    </li>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
<?php
}
include "footer.php";
mysqli_stmt_close($stmt);
?>
<script type="text/javascript">
    var booklist = document.getElementById("booklist");
    var home = document.getElementById("home");
    var breadcrumb = document.getElementById("b1");
    console.log(breadcrumb.style.display);
    breadcrumb.style.display = "none";
    $(document).ready(function() {
        $("#limit-records").change(function() {
            $('form').submit();
        })
    })
</script>