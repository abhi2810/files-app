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
<title>Files App || Home</title>
    <!-- Material Design Lite -->
    <script src="https://code.getmdl.io/1.3.0/material.min.js"></script>
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
    <!-- Material Design icon font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <style>
        a{
            text-decoration:none;
        }
        .page-content{
            height:100%;
        }
        .demo{
            margin:50;
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
        <?php
            $sql = "SELECT * FROM `usermanagement` WHERE username='$username'";
            $res = mysqli_query($connection, $sql);
            $r = mysqli_fetch_assoc($res);
        ?>
        <div class="demo demo-card-square mdl-card mdl-shadow--2dp">
            <div class="mdl-card__title mdl-card--expand">
                <h2 class="mdl-card__title-text"><?php echo $r['username'] ?></h2>
            </div>
            <div class="mdl-card__supporting-text">
                Name: <?php echo $r['ne']; ?><br>
                Email: <?php echo $r['email']; ?>
            </div>
            <div class="mdl-card__actions mdl-card--border">
                <a href="edit-profile.php" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect">
                    Edit Profile
                </a>
            </div>
        </div>
    </div>
  </main>
</div>
</body>
</html>