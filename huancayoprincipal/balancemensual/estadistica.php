<?php
require_once('../connection.php');
$query = "SELECT * FROM dinerodiario WHERE MONTH(fecha)=".$_POST['m']." AND YEAR(fecha)=".$_POST['y']." ORDER BY fecha";
$result=mysqli_query($con,$query);
$i=0;
$a=array();
$b=array();
$c=array();
while($row=mysqli_fetch_assoc($result)){
    $sql1=mysqli_query($con,"SELECT creditos,ingresos,contados,proveedor FROM cajamayor WHERE fecha='".$row['fecha']."'");
    $sql2=mysqli_query($con,"SELECT SUM(monto) FROM ingresos WHERE ingreso='EGRESO' AND fecha='".$row['fecha']."'");
    $ro=mysqli_fetch_row($sql1);
    $ro1=mysqli_fetch_row($sql2);
    if($row['cajareal']>0){
		$a[$i]=$row['cajareal']+$ro[0]+$ro[1]+$row['egresos'];
		$b[$i]=$row['fecha'];
		$c[$i]=$ro[2]+$ro[3]+$ro1[0];
		$i++;
    }
}
$d[0]=$a;
$d[1]=$b;
$d[2]=$c;
echo json_encode($d,JSON_NUMERIC_CHECK);
?>
