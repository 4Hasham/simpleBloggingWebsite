<?php
    if(isset($_SESSION['id'])) {
        header("Location: http://localhost/blogon/index.php");
        exit();
    }
    $pid = 0;
    include("includes/head.php");
    include("includes/bar.php");
    $t = "";
    $c = "";
    if(isset($_GET['post_id'])) {
        $pid = intval($_GET['post_id']);
        $sql = mysqli_prepare($con, "SELECT * FROM `posts` WHERE `ID`=? AND `auth`=? AND parent=0");
        mysqli_stmt_bind_param($sql, "ss", $pid, $_SESSION['id']);
        if(!mysqli_stmt_execute($sql)) {
            die("Query error. " . mysqli_error($con));
        }
        $res = mysqli_stmt_get_result($sql);

        if(mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_array($res);
            $t = $row['title'];
            $c = $row['content'];
        }
        else {
            header("Location: http://localhost/blogon/post.php");
            exit();
        }
    }

    if(isset($_POST['submit'])) {
        $title = trim($_POST['title']);
        $content = $_POST['content'];
        if(isset($pid) && $pid > 0) {
            $sql1 = mysqli_prepare($con, "UPDATE `posts` SET `title`=?, `content`=? WHERE `ID`=?");
            mysqli_stmt_bind_param($sql1, "sss", $title, $content, $pid);
            if(!mysqli_stmt_execute($sql1)) {
                die("Update query error. " . mysqli_error($con));
            }
            header("Location: http://localhost/blogon/read.php?post_id=" . $pid);
        }
        else {
            $sql1 = mysqli_prepare($con, "INSERT INTO `posts`(`auth`, `title`, `content`, `parent`, `date`) VALUES(?, ?, ?, ?, ?)");
            $tdy = date('l jS \of F Y');
            $zero = 0;
            mysqli_stmt_bind_param($sql1, "sssss", $_SESSION['id'], $title, $content, $zero, $tdy);
            if(!mysqli_stmt_execute($sql1)) {
                die("Insert query error. " . mysqli_error($con));
            }
            $sql2 = mysqli_prepare($con, "SELECT * FROM `posts` WHERE `auth`=? AND parent=0 ORDER BY `ID` DESC");
            mysqli_stmt_bind_param($sql2, "s", $_SESSION['id']);
            if(!mysqli_stmt_execute($sql2)) {
                die("Query error. " . mysqli_error($con));
            }
            $res2 = mysqli_stmt_get_result($sql2);
            $row2 = mysqli_fetch_array($res2);
            header("Location: http://localhost/blogon/read.php?post_id=" . $row2['ID']);
        }
        exit();
    }
?>
        <div class="container">
            <form action="" method="POST">
                <div class="form-group">
                    <input type="text" class="form-control input-lg" placeholder="Title.." value="<?php echo $t; ?>" name="title" />
                </div>
                <div class="form-group">
                    <textarea id="editor" placeholder="Write your blog here.." name="content"><?php echo $c; ?></textarea>
                </div>
                <input type="submit" class="btn btn-primary" name="submit" value="Post" />
            </form>
        </div>
<?php
    include("includes/foot.php");
?>