<?php

session_start();
require_once('connect.php');
if(!isset($_SESSION['username']) & empty($_SESSION['username'])){
  header('location: login.php');
}

$username = $_SESSION['username'];
if (isset($_FILES) & !empty($_FILES)) {
  $target_dir = "files/".$username."/";
  if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
  }
  $target_file = $target_dir . basename($_FILES["file"]["name"]);
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  $uploadOk = 1;
  if (file_exists($target_file)) {
      $fmsg = "Sorry, file already exists.";
      $uploadOk = 0;
  }
  if ($_FILES["fileToUpload"]["size"] > 500000) {
      $fmsg = "Sorry, your file is too large.";
      $uploadOk = 0;
  }
  if ($uploadOk == 0) {
      $fmsg = "Sorry, your file was not uploaded.";
  } else {
      if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
          $smsg = "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
      } else {
          $fmsg = "Sorry, there was an error uploading your file.";
      }
  }
}
if (isset($_POST) & !empty($_POST)) {
  $file = $_POST['filename'];
  if(unlink($file)) {
    $smsg = "File Deleted Successfully!";
  } else {
    $fmsg = "Couldn't delete file.";
  }
}

?>
<html>
<head>
<title>Upload Or Download</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" >
<link rel="stylesheet" href="../styles.css" >
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
 <li class="active"><a href="index.php">Home</a></li>
 <li class="active"><a href="files.php">Upload/Download</a></li>
</ul>

</div>
<div class="col-sm-9">
<?php if(isset($smsg)) { ?><div class="alert alert-success" role="alert"><?php echo $smsg;?></div><?php } ?>
<?php if(isset($fmsg)) { ?><div class="alert alert-danger" role="alert"><?php echo $fmsg;?></div><?php } ?>
<div class="panel panel-default">
<div class="panel-heading"><h4>Storage Section</h4></div>
 <div class="panel-body">
  <div class="col-sm-12">
    <form method="post" class="form-horizontal" enctype="multipart/form-data">
          <input type="file" name="file" class="col-sm-6 col-xs-12" id="upload">
          <input type="submit" class="btn btn-primary col-sm-6 col-xs-12" value="Upload" >
    </form>
  </div>
</div>
<div class="col-sm-12" style="margin-top:10px">
    <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>File</th>
        <th>Download</th>
        <th>Delete</th>
      </tr>
    </thead>
    <?php
      $count = 0;
      foreach(glob('files/'.$username.'/*.*') as $file) {
        $count++;
        echo "<tr>";
        echo "<td>".substr($file,strrpos($file,'/')+1)."</td>".
              "<td><a class='btn btn-success' href='".$file."' download>
                <i class='fa fa-download'></i></a></td>
              <td><form method='post'>
                <input type='hidden' name='filename' value='".$file."'>
              <button type='submit' class='btn btn-danger'>
                <i class='fa fa-trash'></i></button></form></td>";
        echo "</tr>";
      }
      if ($count == 0) {
        echo "<tr><td colspan='3' style='text-align: center;'>
                <h3>The storage is empty.</h3>
              </td></tr>";
      }
    ?>
    </table>
  </div>
</div>
</div>
</body>
</html>
