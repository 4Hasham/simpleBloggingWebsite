<nav class="navbar" style="z-index: 999!important;">
  <div class="container">
    <ul class="nav navbar-nav">
      <li>
          <table>
            <tr>
              <td><input type="text" placeholder="Search.." class="form-control" id="search_input" name="search" onkeyup="javascript:searchD();"></td>
              <td><button class="btn btn-info" name="submit" id="search_submit" type="submit" onclick="javascript:event.preventDefault()"><i class="fa fa-search"></i></button></td> 
            </tr>
          </table>
          <div id="sug"></div>
      </li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
    <?php 
    if(isset($_SESSION['id'])) {
    ?>
      <li><a href="./profile.php"><?php echo $_SESSION['username']; ?></a></li>
      <li><a href="./api/login.php"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></li>
    <?php
    } else {
    ?>
      <li><a href="./signup.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
      <li><a href="#" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
    <?php
    }
    ?>
    </ul>
  </div>
</nav>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Login</h4>
        </div>
        <div class="modal-body">
            <form action="../../blogon/api/login.php" method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input class="form-control" type="text" name="username" />
                </div>
                <div class="form-group">
                    <label for="username">Password</label>
                    <input class="form-control" type="password" name="password" />
                </div>
                <input type="submit" name="submit" class="btn btn-default" value="Login" />
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>  
    </div>
</div>