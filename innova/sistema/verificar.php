<?php
session_start();
$_SESSION['valida']='false';
$con =  mysqli_connect('localhost','root','','paolo');
  		mysqli_query ($con,"SET NAMES 'utf8'");
date_default_timezone_set("America/Lima");
$hoy=date("Y-m-d");
$envio=mysqli_query($con,"SELECT fecha FROM cajamayor WHERE id=(SELECT max(id) FROM cajamayor)");
$ro = mysqli_fetch_row($envio);
if($hoy!=$ro[0]){
	$ins=mysqli_query($con,"INSERT INTO cajamayor (cajatienda,creditos,ingresos,contados,proveedor,egresos,totaldia,total,fecha) VALUES ('0','0','0','0','0','0','0','0','$hoy')");
    $ins1=mysqli_query($con,"INSERT INTO dinerodiario (nota,boleta,proforma,factura,creditos,ingresos,egresos,fecha) VALUES ('0','0','0','0','0','0','0','$hoy')");
}
if(isset($_POST) && !empty($_POST)){
	$query=mysqli_query($con,"SELECT * FROM usuario WHERE usuario='".$_POST["user"]."' AND password='".$_POST["pass"]."' AND activo='SI'");
	$contar=mysqli_num_rows($query);
	if($contar>0){
		$row=mysqli_fetch_row($query);
		$_SESSION['cargo']=$row[3];
		$_SESSION['nombre']=$row[4];
		$_SESSION['valida']='true';
		echo $_SESSION['cargo'];
	}else{
		echo $contar;
	}
}
?>