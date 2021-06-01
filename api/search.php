<?php
    include("config.php");
    $wil = $_GET['wild'];
    $sql = mysqli_prepare($con, "SELECT p1.ID AS p1_ID, p2.ID AS p2_ID, p1.title AS p1_title, p2.title AS p2_title, p1.content AS p1_content, p2.content AS p2_content FROM `posts` AS p1, `posts` AS p2 WHERE p1.title LIKE ? AND p2.content LIKE ? AND p1.ID = p2.ID");
    $wild = "%" . $wil . "%";
    mysqli_stmt_bind_param($sql, "ss", $wild, $wild);
    mysqli_stmt_execute($sql);
    $res = mysqli_stmt_get_result($sql);
    if(mysqli_num_rows($res) > 0) {
        echo "<div><h4>Articles</h4>";
    }
    while($row = mysqli_fetch_array($res)) {
?>
    <a href="read.php?post_id=<?php echo $row['p1_ID']; ?>"><?php echo $row['p1_title']; ?></a><br />
<?php
    }
    $sql2 = mysqli_prepare($con, "SELECT * FROM `users` WHERE `name` LIKE ? OR `username` LIKE ?");
    mysqli_stmt_bind_param($sql2, "ss", $wild, $wild);
    mysqli_stmt_execute($sql2);
    $res2 = mysqli_stmt_get_result($sql2);
    if(mysqli_num_rows($res2) > 0) {
        echo "</div><div><h4>Users</h4>";
    }
    while($row = mysqli_fetch_array($res2)) {
?>
    <table>
        <tr>
            <td><img src="<?php echo $row['dp']; ?>" width="50" height="50" /></td>
            <td style="padding: 10px;"><a href="profile.php?id=<?php echo $row['ID']; ?>"><?php echo $row['name']; ?></a></td>
        </tr>
    </table>
<?php
    }
    echo "</div>"
?>