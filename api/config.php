<?php
    session_start();

    define('host', 'localhost');
    define('user', 'root');
    define('pass', '');
    define('db', 'blog_on');

    $con = mysqli_connect(host, user, pass, db);
    
    if(!$con) {
        die("Error: " . mysqli_error($con));
    }
?>