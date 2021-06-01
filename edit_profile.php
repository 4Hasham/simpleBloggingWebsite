<?php
    include("includes/head.php");
    if(!isset($_SESSION['id'])) {
        header("Location: http://localhost/index.php");
        exit();
    }

    if(isset($_POST['submit'])) {
        if(isset($_FILES['img'])) {
            $target_dir = "../blogon/assets/dp/";
            $target_file = $target_dir . basename($_FILES['img']['name']);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $check = getimagesize($_FILES['img']['tmp_name']);
            if($check !== false) {
                move_uploaded_file($_FILES['img']['tmp_name'], $target_file);
                $about = mysqli_escape_string($con, trim($_POST['about']));
                if($about != '') {
                    $sql = mysqli_prepare($con, "UPDATE `users` SET `about`=?, `dp`=? WHERE `ID`=?");
                    mysqli_stmt_bind_param($sql, "sss", $about, $target_file, $_SESSION['id']);
                    if(mysqli_stmt_execute($sql)) {
                        $msg = "Profile Updated!";
                    }
                    else {
                        $msg = "Something went wrong.";
                    }
                }
            } else {
                $msg = "File is not an image.";
            }
        }
    }
?>
<div class="container">
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4">
        <?php
            if(isset($_GET['s'])) {
        ?>
            <div class="alert alert-success alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Success:</strong> Account created.
            </div>
            <h3>Final Step</h3><br>
        <?php
            }
            else if(isset($msg)) {
        ?>
            <div class="alert alert-info alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Info:</strong> <?php echo $msg; ?>
            </div>
        <?php
            }
            else {
        ?>
            <h3>Edit Profile</h3><br>
        <?php
            }
            $sql1 = mysqli_prepare($con, "SELECT * FROM `users` WHERE `ID`=?");
            mysqli_stmt_bind_param($sql1, "s", $_SESSION['id']);
            mysqli_stmt_execute($sql1);
            $res = mysqli_stmt_get_result($sql1);
            $row1 = mysqli_fetch_array($res);
        ?>
            <table class="table">
                <tr>
                    <td>
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
                            <div id="img-btn-div" class="form-group">
                                <!-- <button onclick="javascript:document.getElementsByName('img').forEach(function(value) {value.click();});">Profile Photo</button> -->
                                <input class="form-control" type="file" name="img" id="dp">
                            </div>
                            <div class="form-group">
                                <label for="about">About</label>
                                <textarea name="about" class="form-control" cols="15" rows="8"><?php echo $row1['about']; ?></textarea>
                            </div>
                            <input type="submit" class="btn btn-success" name="submit" value="Save" />
                        </form>
                    </td>
                    <td>
                        <img src="<?php echo $row1['dp']; ?>" width="120" height="150" />
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
<?php
    include("includes/foot.php");
?>