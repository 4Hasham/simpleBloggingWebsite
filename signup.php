<?php
    include("includes/head.php");
    if(isset($_SESSION['id'])) {
        header("Location: http://localhost/index.php");
    }
?>
<div class="container">
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 center">
            <h3>Sign Up for Blog On!</h3><br>
            <?php
                if(isset($_GET['msg'])) {
            ?>
            <div class="alert alert-danger alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Error:</strong> <?php echo $_GET['msg']; ?>
            </div>    
            <?php
                }
            ?>
            <form action="./api/register.php" method="POST">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input class="form-control" type="text" name="name" />
                </div>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input class="form-control" type="text" name="username" />
                </div>
                <div class="form-group">
                    <label for="username">Password</label>
                    <input class="form-control" type="password" name="password" />
                </div>
                <div class="form-group">
                    <label for="cpassword">Confirm Password</label>
                    <input class="form-control" type="password" name="cpassword" />
                </div>
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input class="form-control" type="text" name="email" />
                </div>
                <div class="form-group">
                    <label for="country">Country</label>
                    <input class="form-control" type="text" name="country" />
                </div>
                <div class="alert alert-info">
                    <strong>Notice:</strong> The information provided herein is safe and passwords are encrypted.
                </div>
                <input type="submit" name="submit" class="btn btn-default btn-success" value="Sign Up" />
            </form>
        </div>
    </div>
</div>
<?php
    include("includes/foot.php");
?>