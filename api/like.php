<?php
    include("../../blogon/api/config.php");
    $pid = intval($_GET['post_id']);
    $sql = mysqli_query($con, "INSERT INTO `favorites`(`user_id`, `post_id`) VALUES(" . $_SESSION['id'] .",  " . $pid .")");
    if(!$sql) {
        die("Could not like.");
    }
?>