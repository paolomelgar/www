<?php 
require_once('../connection.php');
    $q=mysqli_query($con,"SELECT latitud,longitud,hora FROM position WHERE vendedor='".$_POST['vendedor']."' AND fecha='".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fecha'])))."' AND ('9:00:00' <= hora AND hora <= '19:00:00') ORDER BY hora");
    $i=0;
    while ($row=mysqli_fetch_assoc($q)){
    $a[$i] =$row['latitud'];
    $b[$i] =$row['longitud'];
    $c[$i] =$row['hora'];
    $i++;
    } 
    $d=array();
    $d[0]=$a;
    $d[1]=$b;
    $d[2]=$c;
    echo json_encode($d);
?>