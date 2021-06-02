<?php
    function getNLikes($con, $pid) {
        $sql = mysqli_prepare($con, "SELECT * FROm `favorites` WHERE `post_id`=?");
        mysqli_stmt_bind_param($sql, "s", $pid);
        if(mysqli_stmt_execute($sql)) {
            $res = mysqli_stmt_get_result($sql);
            return mysqli_num_rows($res);
        }
        else {
            return "Could not get likes.";
        }
    }

    function getNComments($con, $pid) {
        $count = 0;
        $sql = mysqli_query($con, "SELECT ID FROM posts WHERE `parent`=". $pid);
        if(mysqli_num_rows($sql) > 0) {
            $count++;
        }
        while($row = mysqli_fetch_array($sql)) {
            $count += getNComments($con, $row['ID']);
        }
        return $count;
    }

    function getArticles($con) {
        $sql = mysqli_prepare($con, "SELECT * FROM `posts` WHERE `parent`=0 ORDER BY `ID` DESC LIMIT 3");
        if(mysqli_stmt_execute($sql)) {
            $res = mysqli_stmt_get_result($sql);
            return $res;
        }
        else {
            return "Could not get posts.";
        }
    }

    function getBestArticles($con) {
        $sql = mysqli_prepare($con, "SELECT `post_id`, count(`post_id`) AS `occurrence` FROM `favorites` GROUP BY `post_id` ORDER BY `occurrence` DESC LIMIT 3");
        if(mysqli_stmt_execute($sql)) {
            $res = mysqli_stmt_get_result($sql);
            $ids = [];
            while($row = mysqli_fetch_array($res)) {
                array_push($ids, $row["post_id"]);
            }
            $sql1 = mysqli_prepare($con, "SELECT * FROM `posts` WHERE (`ID`=? OR `ID`=? OR `ID`=?) AND `parent`=0");
            mysqli_stmt_bind_param($sql1, "iii", $ids[0], $ids[1], $ids[2]);
            mysqli_stmt_execute($sql1); 
            $res1 = mysqli_stmt_get_result($sql1);
            return $res1;
        }
        else {
            return "Could not get best posts.";
        }
    }

    function getUserPosts($con, $id) {
        $sql = mysqli_prepare($con, "SELECT * FROM `posts` WHERE `auth`=? AND `parent`=0");
        mysqli_stmt_bind_param($sql, "i", $id);
        mysqli_stmt_execute($sql);
        return mysqli_stmt_get_result($sql);
    }
?>