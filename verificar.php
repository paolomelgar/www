<?php
session_start();
$_SESSION['valida']='false';
$con =  mysqli_connect('localhost','root','',$_POST["local"]);
$date=array();
$query=mysqli_query($con,"SELECT * FROM usuario WHERE usuario='".$_POST["user"]."' AND password='".$_POST["pass"]."' AND activo='SI'");
if(mysqli_num_rows($query)>0){
	$row=mysqli_fetch_row($query);
	$_SESSION['cargo']=$row[3];
	$_SESSION['nombre']=$row[4];
	$_SESSION['valida']=$_POST["local"];
	//$_SESSION['mysql']=$_POST["local"];
    $date[0]=$_POST["local"];
    $date[1]=$row[3];
}
echo json_encode($date);

?>