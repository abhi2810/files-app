<?php

session_start();
require_once('connect.php');
if(!isset($_SESSION['username']) & empty($_SESSION['username'])){
  header('location: login.php');
}
$username = $_SESSION['username'];
?>


<html>
<head>
<title>Members Area</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" >
<link rel="stylesheet" href="../styles.css" >
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>

<body>
<nav class="navbar navbar-default">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="home.php">Files App</a>
    </div>

  <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $username; ?> <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="edit-profile.php">Manage Profile</a></li>
            <li><a href="update-password.php">Change Password</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="logout.php">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container">
<div class="col-sm-3">
<ul class="nav nav-pills nav-stacked">
 <li class="active"><a href="#">Home</a></li>
 <li class="active"><a href="files.php">Upload/Download</a></li>
</ul>


</div>
<div class="col-sm-9">
  <?php
    $sql = "SELECT * FROM `usermanagement` WHERE username='$username'";
    $res = mysqli_query($connection, $sql);
    $r = mysqli_fetch_assoc($res);
  ?>
<div class="panel panel-default">
<div class="panel-heading"><h4>User Profile</h4></div>
 <div class="panel-body">
      <div class="box box-info">
            <div class="box-body">
                    <div class="col-sm-6">
                      <h4 style="color:#00b1b1;"><?php echo $r['username'] ?> </h4></span>
                      <span><p><?php echo $r['ne']; ?></p></span>
                      <span><p><?php echo $r['email']; ?></p></span>
                    </div>
            <div class="col-sm-6" style="padding-top: 5%;">
              <span><button type='button' class='btn btn-success'>Active</button>
              <a href="edit-profile.php" class="btn btn-primary col-md-offset-3">Edit</a></span>
            </div>
            <div class="clearfix"></div>
            <hr style="margin:5px 0 5px 0;">
            <div class="col-sm-5 col-xs-6 tital " ></div><div class="col-sm-7 col-xs-6 "></div>
            <div class="clearfix"></div>
            <div class="bot-border"></div>
            <!-- /.box-body -->
            </div>
      </div>
  </div>
</div>
</div>
</div>
</body>
</html>