<?php
    include("includes/head.php");
    include("api/misc.php");
    if(!isset($_SESSION['id'])) {
        if(!isset($_GET['id'])) {
            header("Location: http://localhost/blogon/index.php");
        }
        exit();
    }
    $sql = mysqli_prepare($con, "SELECT * FROM `users` WHERE `ID`=?");
    if(isset($_GET['id'])) {
        mysqli_stmt_bind_param($sql, "s", $_GET['id']);
    }
    else {
        mysqli_stmt_bind_param($sql, "s", $_SESSION['id']);
    }
    if(!mysqli_stmt_execute($sql)) {
        die("Oh no.");
    }
    $result = mysqli_stmt_get_result($sql);
    $row = mysqli_fetch_assoc($result);
    if($row['username'] == '') {
        header("Location: http://localhost/blogon/index.php");
        exit();
    }
?>
<div class="container">
    <div class="row">
        <div class="col-sm-3 col-md-3 col-lg-3">
            <div id="personal">
                <img src="<?php echo $row['dp']; ?>" class="rounded-circle img-circle" style="width: 150px; height: 150px;" />
                <br />
                <h3><?php echo $row['name']; ?></h3>
                <p id="handle"><?php echo $row['username']; ?></p>
                <br>
                <p><?php echo $row['country']; ?><p>                
            </div>
        </div>
        <div class="col-sm-7 col-md-7 col-lg-7">
            <h4>About</h4>
            <p><?php echo $row['about']; ?></p><br>    
            <h4>E-mail</h4>
            <p><?php echo $row['email']; ?></p>
            <br />
            <h3>Posts</h3>
            <br />
            <?php
            if(isset($_GET['id'])) {
                $res = getUserPosts($con, intval($_GET['id']));
            } else {
                $res = getUserPosts($con, $_SESSION['id']);
            }
            while($row = mysqli_fetch_array($res)) {
                ?>
                <table style="width: 100%;">
                    <tr>
                        <td>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title"><a href="read.php?post_id=<?php echo $row['ID']; ?>"><?php echo $row['title']; ?></a></h4>
                                </div>
                            </div>
                        </td>
                        <td style="text-align: right;">
                            <span><?php echo $row['date']; ?></span>
                        </td>
                    </tr>
                </table>
                <br />
                <?php
            }
            ?>
        </div>
        <div class="col-sm-2 col-md-2 col-lg-2">
        <?php
            if((isset($_SESSION['id']) && !isset($_GET['id'])) || $_SESSION['id'] == $_GET['id']) {
        ?>
            <button onclick="window.location='./edit_profile.php'" class="btn btn-info">Edit</button>
        <?php
            }
        ?>
        </div>
    </div>
</div>
<?php 
    include("includes/foot.php");
?>