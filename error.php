<?php include "template.php";
include "sidebar.php"; ?>
<div class="container mb-5" id="table" name="Books-list">
    <table class=" table mt-3 table-striped table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Cover</th>
                <th scope="col">Title</th>
                <th scope="col">Author-Name</th>
                <th scope="col">Genre</th>
            </tr>
        </thead>
    </table>
    <?php
    echo '<div class="alert alert-danger text-center " role="alert"><h1>0 results found  </div></div>';
    ?>
</div>
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
    ol.textContent = "...";
    breadcrumb.appendChild(ol);


    home.className = "nav-link not-active";
    booklist.className = "nav-link active";
</script>