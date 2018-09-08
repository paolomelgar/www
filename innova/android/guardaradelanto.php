<?php 
require_once('../connectionandroid.php');
date_default_timezone_set("America/Lima");
    $hoy=date("Y-m-d");
    for ($i=0; $i<$_REQUEST['size'] ; $i++) {
        $sql= mysqli_query($con,"INSERT INTO acuenta (serie,vendedor,cliente,monto,fecha,pendiente) 
                VALUES ('".$_REQUEST['serie'.$i]."',
                        '".$_REQUEST['vendedor']."',
                        '".$_REQUEST['cliente'.$i]."',
                		'".$_REQUEST['acuenta'.$i]."',
                		'".$hoy."',
                        'SI'
                		)");
    }

 ?>