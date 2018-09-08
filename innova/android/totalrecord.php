<?php 
require_once('../connectionandroid.php');
$arr = array('total' => '');
  $sql=mysqli_query($con,"SELECT SUM(total) AS total FROM total_ventas WHERE vendedor='".$_REQUEST['vendedor']."' AND entregado='SI' AND MONTH(fecha)=".($_REQUEST['month']+1)." AND YEAR(fecha)=".$_REQUEST['year']);
   $rs=mysqli_fetch_array($sql);
   $arr= array('total' => $rs["total"]==null?'':$rs["total"]);
   echo json_encode($arr);
?>