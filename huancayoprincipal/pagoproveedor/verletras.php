<?php
require_once('../connection.php');
    $sql=mysqli_query($con,"SELECT * FROM pagoletras WHERE pendiente='SI' AND value='".$_POST['value']."' ORDER BY fecha");
    $i=0;
    $data=array();
    while($row=mysqli_fetch_assoc($sql)){
    	$data[$i][0]=$row['monto'];
    	$data[$i][1]=date('d/m/Y', strtotime(str_replace('-', '/', $row['fecha'])));
        $data[$i][2]=$row['estado'];
    	$data[$i][3]=$row['id'];
    	$i++;
    }
    echo json_encode($data);
?>