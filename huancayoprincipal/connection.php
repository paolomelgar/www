<?php 
session_start();
$con =  mysqli_connect('localhost','root','','huancayoprincipal');
  mysqli_query ($con,"SET NAMES 'utf8'");
  date_default_timezone_set("America/Lima");
?>