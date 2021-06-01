<?php
    include("includes/head.php");
    include("includes/bar.php");
    include("api/misc.php");
?>

        <div class="container" style="position: relative;">
            <div class="jumbotron">
                <h1>Welcome to Blog On</h1>
            </div>
            <h3>Featured Articles</h3>
            <div class="row" #sec>
                <?php
                $rows1 = getBestArticles($con);
                while($row = mysqli_fetch_array($rows1)) {
                ?>
                <div class="col-sm-4 col-md-4 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title"><a href="read.php?post_id=<?php echo $row['ID']; ?>"><?php echo $row['title']; ?></a></h4>
                        </div>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
            <h3>New Articles</h3>
            <div class="row">
            <?php
                $rows = getArticles($con);
                while($row = mysqli_fetch_array($rows)) {
                ?>
                <div class="col-sm-4 col-lg-4 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title"><a href="read.php?post_id=<?php echo $row['ID']; ?>"><?php echo $row['title']; ?></a></h4>
                        </div>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
<?php
    include("includes/foot.php");
?>