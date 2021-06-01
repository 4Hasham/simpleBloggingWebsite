<?php
    include("includes/head.php");
    include("api/misc.php");
    include("includes/bar.php");

    $pid = intval($_GET['post_id']);

    if(isset($_POST['submit'])) {
        $content = $_POST['com'];
        if($content != '') {
            $sql2 = mysqli_prepare($con, "INSERT INTO `posts`(`auth`, `content`, `parent`, `date`) VALUES(?, ?, ?, ?)");
            $tdy = date('l jS \of F Y');
            mysqli_stmt_bind_param($sql2, "ssss", $_SESSION['id'], $content, $pid, $tdy);
            if(!mysqli_stmt_execute($sql2)) {
                die("Insert query error. " . mysqli_error($con));
            }
        }
    }

    $sql = mysqli_prepare($con, "SELECT * FROM `posts` WHERE `ID`=?");
    mysqli_stmt_bind_param($sql, "s", $pid);
    if(!mysqli_stmt_execute($sql)) {
        die("Query error. " . mysqli_error($con));
    }
    $res = mysqli_stmt_get_result($sql);
    $row = mysqli_fetch_array($res);

    $sql1 = mysqli_prepare($con, "SELECT * FROM `users` WHERE `ID`=?");
    mysqli_stmt_bind_param($sql1, "s", $row['auth']);
    if(!mysqli_stmt_execute($sql1)) {
        die("Query error. " . mysqli_error($con));
    }
    $res1 = mysqli_stmt_get_result($sql1);
    $row1 = mysqli_fetch_array($res1);
    ?>
    <div class="modal fade" id="coms" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Reply to <?php echo $row1['name'] ?>'s Post</h4>
                </div>
                <div class="modal-body">
                    <form action="" method="POST">
                        <div class="form-group">
                            <textarea id="editor" placeholder="Write comment.." name="com"></textarea>
                        </div>
                        <input type="submit" name="submit" class="btn btn-default" value="Post" />
                    </form>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>  
        </div>
    </div>
    <script type="text/javascript">
        loadComments(<?php echo $pid; ?>);

        function reply(content, pid) {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    loadComments(<?php echo $pid; ?>);
                }
            };
            xhttp.open("GET", "../../blogon/api/reply.php?content="+ content +"&post_id=" + pid, true);
            xhttp.send();
        }

        setInterval(function() {
            isLiked(<?php echo $pid; ?>);
        }, 500);
    </script>
    <div class="container">
        <div class="row">
            <div class="col-sm-10 col-lg-10 col-lg-10">
                <h2>
                <?php
                    echo $row['title'] . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; 
                    if(isset($_SESSION['id']) && $_SESSION['id'] == $row['auth']) {
                ?>
                    <button onclick="window.location='./post.php?post_id=<?php echo $row['ID']; ?>'" class="btn"><span class="glyphicon glyphicon-edit"></span> </button>
                <?php
                }
                ?>
                </h2>
                <p>By <b><?php echo $row1['name']; ?></b> (<a href="./profile.php?id=<?php echo $row['auth']; ?>"><?php echo $row1['username']; ?></a>)</p>
                <p><i><?php echo $row['date']; ?></i></p>

                <br><br>
                <div id="blog_content"><?php echo $row['content']; ?></div>
                <br />
                <div id="actions">
                    <span id="liked"></span>&nbsp;&nbsp;&nbsp;
                    <a href="#" data-toggle="modal" data-target="#coms">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-reply" viewBox="0 0 16 16">
                            <path d="M6.598 5.013a.144.144 0 0 1 .202.134V6.3a.5.5 0 0 0 .5.5c.667 0 2.013.005 3.3.822.984.624 1.99 1.76 2.595 3.876-1.02-.983-2.185-1.516-3.205-1.799a8.74 8.74 0 0 0-1.921-.306 7.404 7.404 0 0 0-.798.008h-.013l-.005.001h-.001L7.3 9.9l-.05-.498a.5.5 0 0 0-.45.498v1.153c0 .108-.11.176-.202.134L2.614 8.254a.503.503 0 0 0-.042-.028.147.147 0 0 1 0-.252.499.499 0 0 0 .042-.028l3.984-2.933zM7.8 10.386c.068 0 .143.003.223.006.434.02 1.034.086 1.7.271 1.326.368 2.896 1.202 3.94 3.08a.5.5 0 0 0 .933-.305c-.464-3.71-1.886-5.662-3.46-6.66-1.245-.79-2.527-.942-3.336-.971v-.66a1.144 1.144 0 0 0-1.767-.96l-3.994 2.94a1.147 1.147 0 0 0 0 1.946l3.994 2.94a1.144 1.144 0 0 0 1.767-.96v-.667z"/>
                        </svg>
                         Reply
                    </a>
                </div>
                <br />
                <p><?php echo getNLikes($con, $pid); ?> people like this blog.</p>
                <br />
                <h3>Comments (<?php echo getNComments($con, $pid); ?>)</h3>
                <br>
                <div id="comms">

                </div>
            </div>
        </div>
    </div>
<?php
    include("includes/foot.php");
?>