<?php
    include("../../blogon/api/config.php");
    if(isset($_SESSION['id'])) {
        header("Location: http://localhost/blogon/index.php");
    }
    $msg = "";
    if(isset($_POST['submit'])) {
        if(trim($_POST['name']) !== '' && trim($_POST['username']) !== '' && trim($_POST['password']) !== '' && trim($_POST['cpassword']) !== '' && trim($_POST['email']) !== '' && trim($_POST['country']) !== '') {
            $name = trim($_POST['name']);
            $username = trim($_POST['username']);
            $pass = trim($_POST['password']);
            $cpass = trim($_POST['cpassword']);
            $email = trim($_POST['email']);
            $country = trim($_POST['country']);
            
            $stmt = mysqli_prepare($con, "SELECT * FROM users WHERE username=?");
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            if(mysqli_stmt_num_rows($stmt) == 0) {
                $email = filter_var($email, FILTER_SANITIZE_EMAIL);
                if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $stmt1 = mysqli_prepare($con, "SELECT * FROM users WHERE email=?");
                    mysqli_stmt_bind_param($stmt1, "s", $email);
                    mysqli_stmt_execute($stmt1);
                    mysqli_stmt_store_result($stmt1);
                    if(mysqli_stmt_num_rows($stmt1) == 0) {
                        if(strlen($name) >= 3 && strlen($name) <= 14) {
                            if(strlen($username) >= 5 && strlen($username) <= 14) {
                                if(strlen($country) >= 3 && strlen($country) <= 20) {
                                    $s = "INSERT INTO users(`name`, `email`, `username`, `password`, `country`, `about`, `dp`) VALUES(?, ?, ?, ?, ?, ?, ?)";
                                    $st = mysqli_prepare($con, $s);
                                    if(!$st) {
                                        die(mysqli_error($con));
                                    }
                                    $about = "Write a bit about yourself..";
                                    $dp = "../blogon/assets/dp/default.jpg";
                                    mysqli_stmt_bind_param($st, "sssssss", $name, $email, $username, $pass, $country, $about, $dp);
                                    if(mysqli_stmt_execute($st)) {
                                        $sel = mysqli_prepare($con, "SELECT ID FROM users WHERE username=?");
                                        mysqli_stmt_bind_param($sel, "s", $username);
                                        mysqli_stmt_execute($sel);
                                        mysqli_stmt_bind_result($sel, $i);
                                        $_SESSION['id'] = $i;
                                        header("Location: http://localhost/blogon/edit_profile.php?s=1");
                                        exit();                                   
                                    }
                                    else {
                                        die(mysqli_stmt_error($st));
                                        $msg = "Something went wrong.";
                                    }
                                }
                                else {
                                    $msg = "Enter a valid country name.";
                                }
                            }
                            else {
                                $msg = "Username must lie in the range of 5 - 14 characters.";
                            }
                        }
                        else {
                            $msg = "Name must lie in the range of 3 - 14 characters.";
                        }
                    }
                    else {
                        $msg = "An account is already registered with this email address.";
                    }
                }
                else {
                    $msg = "Invalid email address.";
                } 
            }
            else {
                $msg = "Username already exists.";
            }
        }
        else {
            $msg = "Fill all fields";
        }
        header("Location: http://localhost/blogon/signup.php?msg=$msg");
    }
?>