<?php 
require_once('../connection.php');
  $datos=array();
  for($j=0;$j<12;$j++){
      $quer = mysqli_query($con,"SELECT SUM(total) AS total FROM total_ventas WHERE vendedor='".$_REQUEST['vendedor']."' AND entregado='SI' AND MONTH(fecha)='".($j+1)."' AND YEAR(fecha)='".$_REQUEST['year']."'");
      $rr=mysqli_fetch_row($quer);
      if($rr[0]==null){
      	$rr[0]=0;
      }
      $datos[$j]["total"]=$rr[0];
    }
   echo json_encode($datos);

 ?>