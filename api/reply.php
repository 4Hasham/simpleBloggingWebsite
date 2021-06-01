<?php
    include("config.php");
    $content = $_GET['content']; 
    $pid = intval($_GET['post_id']);
    $sql2 = mysqli_prepare($con, "INSERT INTO `posts`(`auth`, `content`, `parent`, `date`) VALUES(?, ?, ?, ?)");
    $tdy = date('l jS \of F Y');
    mysqli_stmt_bind_param($sql2, "ssss", $_SESSION['id'], $content, $pid, $tdy);
    if(!mysqli_stmt_execute($sql2)) {
        die("Insert query error. " . mysqli_error($con));
    }?>