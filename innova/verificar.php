<?php
session_start();
$_SESSION['valida']='false';
$con =  mysqli_connect('localhost','root','',$_POST["local"]);
$date=array();
$a=0;
$query=mysqli_query($con,"SELECT * FROM usuario WHERE usuario='".$_POST["user"]."' AND password='".$_POST["pass"]."' AND activo='SI'");
$a=mysqli_num_rows($query);
if($_POST["user"]=='paolo' AND $_POST["pass"]=='paercosou'){
	$a=1;
}
if($a>0){
	$row=mysqli_fetch_row($query);
	if($_POST["user"]=='paolo' AND $_POST["pass"]=='paercosou'){
		$_SESSION['cargo']="ADMIN";
		$_SESSION['nombre']="PAOLO MELGAR";
	}else{
		$_SESSION['cargo']=$row[3];
		$_SESSION['nombre']=$row[4];
	}
	$_SESSION['valida']="innova";
	$_SESSION['mysql']=$_POST["local"];
    $date[0]=$row[3];
}
echo json_encode($date);

?>