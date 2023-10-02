<nav class="navbar navbar-light " id="sidebar">

    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb" id="b1" style="display:none;">
                <li class="breadcrumb-item" id="1"><a href="welcome.php">Home</a></li>
                <li class="breadcrumb-item active " id="2" aria-current="page">Books List</li>
            </ol>
        </nav>

        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasNavbarLabel"> <strong> A2Z Bookshop  </strong></h5>

                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                
            </div>
            
            <div class="offcanvas-body justify-content-left">
            <hr>
                <ul class="navbar-nav flex-grow-1 pe-3">
                    <li class="nav-item">
                        <a class="nav-link active" id="home" aria-current="page" href="welcome.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="booklist" href="bookstore.php?start=1&val=10">Books List</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="offcanvasNavbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Categories
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="offcanvasNavbarDropdown" id="drop-menu">
                            <?php for ($i = 0; $i < sizeof($cat); $i++) {
                                $val = $cat[$i]; ?>
                                <li><a class="dropdown-item" href="bookstore.php?c=1&search=<?php echo $val; ?>"><?php echo $val; ?></a></li>
                            <?php } ?>
                        </ul>
                    </li>
                    <li class=" nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="offcanvasNavbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Authors
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="offcanvasNavbarDropdown" id="drop-menu">
                            <?php for ($i = 0; $i < sizeof($aut); $i++) {
                                $val = $aut[$i]; ?>
                                <li><a class="dropdown-item" href="bookstore.php?a=1&search=<?php echo $val; ?>"><?php echo $val; ?></a></li>
                            <?php } ?>
                        </ul>
                    </li>
                </ul>
                <hr>
                <!-- <form class="d-flex" action="bookstore.php?search=" method="GET" style="margin-top: 10px;">
                    <input class="form-control me-2" type="search" placeholder="Search for books" aria-label="Search" name="search" id="search">
                    <button class="btn btn-dark-green " type="submit" style="margin-top: 10px;">Search</button>
                </form> -->
            </div>
        </div>
    </div>
</nav>
