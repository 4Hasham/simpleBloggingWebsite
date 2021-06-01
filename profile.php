<?php
    include("includes/head.php");
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
        <div class="col-sm-4 col-md-4 col-lg-4">
            <div id="personal">
                <img src="<?php echo $row['dp']; ?>" class="rounded-circle img-circle" style="width: 150px; height: 150px;" />
                <br />
                <h3><?php echo $row['name']; ?></h3>
                <p id="handle"><?php echo $row['username']; ?></p>
                <br>
                <p><?php echo $row['country']; ?><p>                
            </div>
        </div>
        <div class="col-sm-4 col-md-4 col-lg-4">
            <h4>About</h4>
            <p><?php echo $row['about']; ?></p><br>    
            <h4>E-mail</h4>
            <p><?php echo $row['email']; ?></p>    
        </div>
        <div class="col-sm-4 col-md-4 col-lg-4">
            <button onclick="window.location='./edit_profile.php'" class="btn btn-info">Edit</button>
        </div>
    </div>
</div>