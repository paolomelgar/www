<?php 
session_start();
require_once('../connection.php');
if(isset($_POST) && !empty($_POST)){
	$search = explode(" ", $_POST['b']);
    $producto = "";
    foreach($search AS $s){
      $producto .= "concat(producto,' ',marca) LIKE '%".mysqli_real_escape_string($con,$s)."%' AND ";
    }
    $producto = substr($producto, 0, -4);
    $a=24*$_POST['m'];
    if(isset($_POST['f']) && !empty($_POST['f'])){
    	if($_POST['f']!='TODAS LAS CATEGORIAS')
      $producto.=" AND familia='".$_POST['f']."'";
    }
    $query = "SELECT * FROM producto WHERE $producto AND foto='SI' AND activo!='NO' ORDER BY producto,marca LIMIT $a,24";
    $sql=mysqli_query($con,$query);
	$i=0;
	$dat=array();
	while($row=mysqli_fetch_assoc($sql)){
		$q = mysqli_query($con,"SELECT id FROM marca WHERE marca='".$row['marca']."' AND foto='SI'");
		$d = mysqli_fetch_row($q);
		$dat[$i][0]=$row['producto'];
		if($_SESSION['nombre']!='GRUPO FERRETERO INNOVA S.R.L.'){
			$dat[$i][1]=$row['p_promotor'];
			$dat[$i][2]=$row['p_especial'];
		}else{
			$dat[$i][1]=round($row['p_compra']*1.05,2);
			$dat[$i][2]=round($row['p_compra']*1.05,2);
		}
		$dat[$i][3]=$row['stock_real'];
		$dat[$i][4]=$row['id'];
		$dat[$i][5]=$row['cant_caja'];
		$dat[$i][6]=$row['activo'];
		if(mysqli_num_rows($q)>0){
			$dat[$i][7]=$d[0];
		}else{
			$dat[$i][7]=$row['marca'];
		}
		$dat[$i][8]=$row['marca'];
		if(strtotime(date("Y-m-d"))-strtotime($row['fecha'])<30*24*60*60){
			$dat[$i][9]="nuevo";
		}else{
			$dat[$i][9]="";

		}
		$i++;
	}
	echo json_encode($dat);
}
?>