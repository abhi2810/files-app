<?php
session_start();
require_once('connect.php');
if (isset($_SESSION) && !empty($_SESSION)){
    header('location: home.php');
} else {
    header('location: login.php');
}
?>