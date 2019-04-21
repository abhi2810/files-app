<?php

session_start();
require_once('connect.php');
if(!isset($_SESSION['username']) & empty($_SESSION['username'])){
  header('location: login.php');
}

$username = $_SESSION['username'];
if (isset($_FILES) & !empty($_FILES)) {
  $target_dir = "files/".$username."/hosting//";
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
  if ($_FILES["file"]["size"] > 500000) {
      $fmsg = "Sorry, your file is too large.";
      $uploadOk = 0;
  }
  if ($uploadOk == 0) {
      $fmsg = "Sorry, your file was not uploaded.";
  } else {
      if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
          $smsg = "The file ". basename( $_FILES["file"]["name"]). " has been uploaded.";
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
<title>Files App || Home</title>
    <!-- Material Design Lite -->
    <script src="https://code.getmdl.io/1.3.0/material.min.js"></script>
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
    <!-- Material Design icon font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" >
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        a{
            text-decoration:none;
        }
        .page-content{
            height:100%;
        }
    </style>
</head>

<body>

<div class="mdl-layout mdl-js-layout mdl-layout--fixed-drawer
            mdl-layout--fixed-header">
  <header class="mdl-layout__header">
    <div class="mdl-layout__header-row">
      <div class="mdl-layout-spacer"></div>
        <span><?php echo $_SESSION['username'] ?></span>
        <button id="demo-menu-lower-right"
            class="mdl-button mdl-js-button mdl-button--icon">
        <i class="material-icons">more_vert</i>
        </button>
        <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect"
            for="demo-menu-lower-right">
            <li class="mdl-menu__item"><a href="edit-profile.php">Manage Profile</a></li>
            <li class="mdl-menu__item"><a href="update-password.php">Change Password</a></li>
            <li class="mdl-menu__item"><a href="logout.php">Logout</a></li>
        </ul>
    </div>
  </header>
  <div class="mdl-layout__drawer">
    <span class="mdl-layout-title">Files App</span>
    <nav class="mdl-navigation">
      <a class="mdl-navigation__link" href="home.php">Home</a>
      <a class="mdl-navigation__link" href="files.php">Storage</a>
      <a class="mdl-navigation__link" href="hosting.php">Hosting</a>
    </nav>
  </div>
  <main class="mdl-layout__content">
    <div class="page-content">
    <div style="margin:10px;" class="col-sm-9">
<?php if(isset($smsg)) { ?><div class="alert alert-success" role="alert"><?php echo $smsg;?></div><?php } ?>
<?php if(isset($fmsg)) { ?><div class="alert alert-danger" role="alert"><?php echo $fmsg;?></div><?php } ?>
<div class="panel panel-default">
<div class="panel-heading"><h4>Hosting Section</h4></div>
 <div class="panel-body">
  <div class="col-sm-12">
    <p>Hosted Link: <a target="_Blank" href="<?php echo 'files/'.$username.'/hosting/' ?>">
        <?php echo 'localhost/files-app/files/'.$username.'/hosting/' ?></a>
    </p>
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
      foreach(glob('files/'.$username.'/hosting/*.*') as $file) {
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
  </main>
</div>
</body>
</html>