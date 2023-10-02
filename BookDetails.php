<?php
include "config.php";
include "template.php";
include "sidebar.php";
$isbn = "";
if (isset($_GET['no'])) {
    $isbn =  $_GET['no'];
}
$sql1 = "SELECT * FROM $db where isbn10 LIKE '%$isbn%'";
$res = mysqli_query($conn, $sql1);
$stmt = mysqli_prepare($conn, $sql1);
$row = mysqli_fetch_assoc($res);
if ($stmt) {
    $image =  htmlspecialchars($row['thumbnail']);
    $isbn10 =  htmlspecialchars($row['isbn10']);
    $isbn13 =  htmlspecialchars($row['isbn13']);
    $title = htmlspecialchars($row['title']);
    $subtitle =  htmlspecialchars($row['subtitle']);
    $year =  htmlspecialchars($row['published_year']);
    $ratings =  htmlspecialchars($row['average_rating']);
    $ratingsCount =  (htmlspecialchars($row['ratings_count']) == null) ? 0 : htmlspecialchars($row['ratings_count']);
    $description =  (htmlspecialchars($row['description']) == null) ? "No information available" : htmlspecialchars($row['description']);
    $author = htmlspecialchars($row['authors']);
    $categories = htmlspecialchars($row['categories']);
    $num_page = htmlspecialchars($row['num_pages']);
}
?>
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
<div class="container" name="details">
    <div class="row ">
        <div class="img col-6 mx-2 ">
            <img src="<?php
                        if (filter_var(htmlspecialchars($row['thumbnail']), FILTER_VALIDATE_URL) == false) {
                            echo 'image/';
                        }
                        echo htmlspecialchars($row['thumbnail']);
                        ?>" class="img-thumbnail rounded my-1 mx-1" onerror=" this.src='https://cdn-d8.nypl.org/s3fs-public/blogs/sJ3CT4V.gif';">
        </div>
        <div class="container-fluid col">
            <div class="info">
                <div class="title ">
                    <h1><strong><?php echo $title; ?></strong></h1>
                </div>
                <div class="subtitle mt-2 ">
                    <h5><?php echo $subtitle; ?></h5>
                </div>
                <div class="author">
                    <p> By <?php echo $author ?></p>
                </div>
                <div class="ratings">
                    <p> <?php echo $ratings . "\n";
                        $i = $ratings;

                        for ($j = 5; $j > 0; $j--) {
                            if ($i >= 1) {
                                echo '<img src="https://img.icons8.com/fluency/16/000000/star.png"/>';
                            } else if ($i >= 0.4) {
                                echo '<img src="icons8-star-half-empty-16.png"/>';
                            } else {
                                echo '<img src="https://img.icons8.com/plumpy/16/000000/star--v1.png"/>';
                            }
                            $i--;
                        }
                        echo ' (' . $ratingsCount . ')'; ?>
                    </p>
                </div>
                <hr>
                <div class="desc">
                    <p>
                        <?php
                        echo $description;
                        ?>
                    </p>
                    <?php if (strlen($description) > 200) { ?>
                        <a href="javascript:void();" class="read-more">Read more</a>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="container details-acc">
    <div class="accordion" id="accordionPanelsStayOpenExample">
        <div class="accordion-item">
            <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                    <strong>Product details</strong>
                </button>
            </h2>
            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                <div class="accordion-body">
                    <hr>
                    <h1 style="text-align: center; font-size:40px; margin-top:20px" id="Best-books">Book Information</h1>
                    <hr>

                    <table class="table mt-3 table-striped table-bordered table-hover table-light text-center desc-table">

                        <tr>
                            <td> <strong> Title</strong></td>
                            <td><?php echo $title ?></td>
                        </tr>
                        <tr>
                            <td> <strong> Subtitle</strong></td>
                            <td><?php echo !empty($subtitle) ? $subtitle : "NA"; ?></td>
                        </tr>
                        <tr>
                            <td> <strong> Author(s) Name</strong></td>
                            <td> <?php echo $author ?></td>
                        </tr>
                        <tr>
                            <td> <strong> ISBN-10 </strong></td>
                            <td> <?php echo $isbn10 ?></td>
                        </tr>
                        <tr>
                            <td> <strong> ISBN-13</strong></td>
                            <td> <?php echo $isbn13 ?></td>
                        </tr>

                        <tr>
                            <td> <strong> Published Year</strong></td>
                            <td> <?php echo $year ?></td>
                        </tr>
                        <tr>
                            <td> <strong> Rating </strong></td>
                            <td> <?php echo $ratings ?> / 5</td>
                        </tr>
                        <tr>
                            <td> <strong> Ratings count</strong></td>
                            <td> <?php echo $ratingsCount ?></td>
                        </tr>
                        <tr>
                            <td> <strong> Number of pages</strong></td>
                            <td> <?php echo $num_page ?></td>
                        </tr>
                        <tr>
                            <td> <strong> Categories</strong></td>
                            <td> <?php echo $categories ?></td>
                        </tr>
                    </table>
                </div>
            </div>
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
    console.log(breadcrumb.style.display);
    breadcrumb.style.display = "flex";
    pre.className = "breadcrumb-item";
    pre.innerHTML = "";
    a.href = "bookstore.php";
    a.textContent = "Books List";
    pre.appendChild(a);
    ol.className = "breadcrumb-item active";
    ol.textContent = "BookDetails";
    breadcrumb.appendChild(ol);
    home.className = "nav-link not-active";
    booklist.className = "nav-link active";
    $(".read-more").on('click', function() {
        $(this).parent().toggleClass("showContent");
        var replaceText = $(this).parent().hasClass("showContent") ? "Read Less" : "Read more";
        $(this).text(replaceText);
    });
</script>