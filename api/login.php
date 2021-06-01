<?php
    include("../../blogon/api/config.php");
    //Logout
    if(isset($_SESSION['id'])) {
        unset($_SESSION['id']);
        unset($_SESSION['username']);
        header("Location: http://localhost/blogon/index.php");
    }

    //Login
    $msg = "";
    if(isset($_POST['submit'])) {
        if(trim($_POST['username']) != "" && trim($_POST["password"]) != "") {
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);

            $sql = "SELECT * FROM users WHERE username=?";
            $stmt = mysqli_prepare($con, $sql);
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            $res = mysqli_stmt_get_result($stmt);
            if(!$stmt) {
                $msg = "Something went wrong.";
            }
            if(mysqli_num_rows($res) > 0) {
                $row = mysqli_fetch_assoc($res);
                $_SESSION['id'] = $row['ID'];
                $_SESSION['username'] = $row['username'];
                $msg = "Login Successful!".$_SESSION['id'];
            }
            else {
                $msg = "Incorrect username or password.";
            }
            header("Location: http://localhost/blogon/index.php?msg=$msg");
        }
    }
?>