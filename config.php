<?php
define('DB_SERVER', 'localhost:3308');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'Bookstore');
$db = 'BooksDB';
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);
mysqli_select_db($conn, DB_NAME);
if($conn == false){
    dir('Error : Cannot connect');
}
