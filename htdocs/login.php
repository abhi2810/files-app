<?php
session_start();
require_once('connect.php');
if (isset($_SESSION) && !empty($_SESSION)){
  //$smsg =  "Already Exists" .$_SESSION['username'];
}

if (isset($_POST['username']) && !empty($_POST)) {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $sql = "SELECT * FROM `usermanagement` WHERE username = '$username'";
  $res = mysqli_query($connection,$sql);
  $count = mysqli_num_rows($res);
  $passp=md5($password);
  if ($passp==mysqli_fetch_array($res)['password']){
  $_SESSION['username'] = $username;
  header('location:home.php');
  }
  else {
    $fmsg =  "Please register first";
  }
}
?>

<html>
<head>
<title>Files App || Login</title>
    <!-- Material Design Lite -->
    <script src="https://code.getmdl.io/1.3.0/material.min.js"></script>
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
    <!-- Material Design icon font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <style>
      .demo{
        position: absolute;
        top: 50%;
        left: 50%;
        -moz-transform: translateX(-50%) translateY(-50%);
        -webkit-transform: translateX(-50%) translateY(-50%);
        transform: translateX(-50%) translateY(-50%);
      }
    </style>
</head>

<body>

<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
  <header class="mdl-layout__header">
    <div class="mdl-layout__header-row">
      <a href="home.php" style="color:#fff;" class="mdl-button mdl-js-button mdl-js-ripple-effect">
        <b>Files App</b>
      </a>
      <div class="mdl-layout-spacer"></div>
    </div>
  </header>
  <main class="mdl-layout__content">
    <div class="page-content">
        <div class="demo demo-card-square mdl-card mdl-shadow--2dp">
            <div class="mdl-card__title mdl-card--expand">
                <h2 class="mdl-card__title-text">Login</h2>
            </div>
            <div class="mdl-card__supporting-text">
              <?php if(isset($fmsg)) { ?>
                <span class="mdl-chip mdl-chip--contact">
                    <span class="mdl-chip__contact mdl-color--red mdl-color-text--white"><span class="material-icons">error_outline</span></span>
                    <span class="mdl-chip__text"><?php echo $fmsg?></span>
                </span>
              <?php } ?>
              <form method="POST">
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <input class="mdl-textfield__input" type="text" name="username" id="username" required>
                  <label class="mdl-textfield__label" for="username">Username</label>
                </div><br>
                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                  <input class="mdl-textfield__input" type="password" name="password" id="inputPassword" required>
                  <label class="mdl-textfield__label" for="password">Password</label>
                </div>
                <button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
                    Login
                </button>
              </form>
              <a style="float:right;" href="register.php">Create an account.</a>
            </div>
        </div>
    </div>
  </main>
</div>
</body>
</html>