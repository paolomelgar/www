<?php
    require_once('../connection.php');
    $sql=mysqli_query($con,"SELECT * FROM letraclientes WHERE pendiente='SI' AND value='".$_POST['value']."' ORDER BY fechapago");
    $i=0;
    $data=array();
    while($row=mysqli_fetch_assoc($sql)){
    	$data[$i][0]=$row['total'];
    	$data[$i][1]=date('d/m/Y', strtotime(str_replace('-', '/', $row['fechapago'])));
        $data[$i][2]=$row['id'];
    	$i++;
    }
    echo json_encode($data);
?>