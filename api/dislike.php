<?php
    include("../../blogon/api/config.php");
    $pid = intval($_GET['post_id']);
    $sql = mysqli_query($con, "DELETE FROM `favorites` WHERE `user_id`=" . $_SESSION['id'] ." AND `post_id`=" . $pid);
    if(!$sql) {
        die("Could not dislike.");
    }
?>