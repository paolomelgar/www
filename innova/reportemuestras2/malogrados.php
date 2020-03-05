<?php
    require_once('../connection.php');
    if(isset($_POST['producto1']) && !empty($_POST['producto1'])){
        for ($i=0; $i<sizeof($_POST['producto1']) ; $i++) {
            $sql1= mysqli_query($con,"INSERT INTO reportemuestras2 (id,compra,producto,cantidad,estado,fecha,hora,usuario) 
                VALUES ('".$_POST['id1'][$i]."',
                        '".$_POST['unitario1'][$i]."',
                        '".$_POST['producto1'][$i]."',
                        '".$_POST['cantidad1'][$i]."',
                        '".$_POST['estado1'][$i]."',
                        NOW(),
                        NOW(),
                        '".$_SESSION['nombre']."'
                        )");
            $inse=mysqli_query($con,"UPDATE producto SET stock_muestra2=(stock_muestra2+".$_POST['cantidad1'][$i].") WHERE id='".$_POST['id1'][$i]."'");
        }
    }
?>