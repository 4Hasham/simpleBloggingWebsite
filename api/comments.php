<div>
<?php
    include("config.php");
    include("misc.php");
    function printComment($con, $id, $indent) {
        $sql = mysqli_query($con, "SELECT * FROM posts WHERE id=". $id);
        $row = mysqli_fetch_array($sql);
        $row1 = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM users WHERE ID=". $row['auth']));
        echo ("
        <table style=\"margin-left: ".$indent."px; display: inline-block;\">
            <tr>
                <td><img src=\"".$row1['dp']."\" width=\"40\" height=\"40\" /></td>
                <td style=\"padding: 15px;\"><a href=\"profile.php?id=".$row1['ID']."\">".$row1['name']."</a></td>
                <td colspan=\"2\" style=\"text-align:right;\">".$row['date']."</td>
            </tr>
            <tr>
                <td style=\"padding-top: 16px;\" colspan=\"2\">".$row['content']."</td>
            </tr>
            <tr>
                <td><textarea id=\"edit".$row['ID']."\" placeholder=\"Reply\"></textarea></td>
                <td>
                <button class=\"btn btn-default\" onclick=\"javascript:reply(document.getElementById('edit".$row['ID']."').value, ".$row['ID'].")\">
                    <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-reply\" viewBox=\"0 0 16 16\">
                        <path d=\"M6.598 5.013a.144.144 0 0 1 .202.134V6.3a.5.5 0 0 0 .5.5c.667 0 2.013.005 3.3.822.984.624 1.99 1.76 2.595 3.876-1.02-.983-2.185-1.516-3.205-1.799a8.74 8.74 0 0 0-1.921-.306 7.404 7.404 0 0 0-.798.008h-.013l-.005.001h-.001L7.3 9.9l-.05-.498a.5.5 0 0 0-.45.498v1.153c0 .108-.11.176-.202.134L2.614 8.254a.503.503 0 0 0-.042-.028.147.147 0 0 1 0-.252.499.499 0 0 0 .042-.028l3.984-2.933zM7.8 10.386c.068 0 .143.003.223.006.434.02 1.034.086 1.7.271 1.326.368 2.896 1.202 3.94 3.08a.5.5 0 0 0 .933-.305c-.464-3.71-1.886-5.662-3.46-6.66-1.245-.79-2.527-.942-3.336-.971v-.66a1.144 1.144 0 0 0-1.767-.96l-3.994 2.94a1.147 1.147 0 0 0 0 1.946l3.994 2.94a1.144 1.144 0 0 0 1.767-.96v-.667z\"/>
                    </svg>
                     Reply
                </button>
                </td>
            </tr>
        </table>
        <br />
        ");
    }

    function collectIDs($con, $oid, $indent) {
        $ret = [];
        $sql = mysqli_query($con, "SELECT ID FROM posts WHERE `parent`=". $oid);
        if(mysqli_num_rows($sql) > 0) {
            while($row = mysqli_fetch_array($sql)) {
                array_push($ret, intval($row['ID']));
                printComment($con, intval($row['ID']), $indent);
                $ret = collectIDs($con, $row['ID'], $indent + 3);
            }
        }
        return $ret;
    }

    $pid = intval($_GET['pid']);
    $all = collectIDs($con, $pid, 0);
?>
</div>