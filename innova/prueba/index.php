<?php 
$con =  mysqli_connect('localhost','root','','paolo');
  mysqli_query ($con,"SET NAMES 'utf8'");
    $sql=mysqli_query($con,"SELECT * FROM marca");
    $array=array();
    while($row=mysqli_fetch_assoc($sql)){
        $b=strlen($row['marca'])+1;
        $query="RIGHT(producto,".$b.") = ' ".$row['marca']."' and entregado='si' AND MONTH(fecha)=12";
        $sql1=mysqli_query($con,"SELECT sum(importe) FROM notapedido WHERE $query");
        $sql2=mysqli_query($con,"SELECT sum(importe) FROM proforma WHERE $query");
        $sql3=mysqli_query($con,"SELECT sum(importe) FROM boleta WHERE $query");
        $sql4=mysqli_query($con,"SELECT sum(importe) FROM devoluciones WHERE $query");
        $r1=mysqli_fetch_row($sql1);
        $r2=mysqli_fetch_row($sql2);
        $r3=mysqli_fetch_row($sql3);
        $r4=mysqli_fetch_row($sql4);
        array_push($array,array($r1[0]+$r2[0]+$r3[0]-$r4[0],$row['marca']));
    }
    rsort($array);

$arrlength = count($array);
for($x = 0; $x <  $arrlength; $x++) {
     echo $array[$x][1]." ".$array[$x][0];
     echo "<br>";
}
 ?>