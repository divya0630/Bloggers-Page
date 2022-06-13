<?php
session_start();

$_SESSION['username']="";
$_SESSION['user_firstname']="";
$_SESSION['user_lastname']="";
$_SESSION['user_id']="";
$_SESSION['user_password']="";
$_SESSION['user_status']="";

header("Location:../index.php");

?>