<?php 
session_start();
require_once('../connection.php');
if(isset($_POST['accion']) && !empty($_POST['accion'])){
    switch ($_POST['accion']) {
        case 'add':
            $sql1= mysqli_query($con,"INSERT INTO cliente (ruc,cliente,direccion,tipo,representante,telefono,mail,credito,activo,latitud,longitud) 
            VALUES ('".$_POST['ruc']."','".$_POST['cliente']."','".$_POST['direccion']."','".$_POST['tipo']."','".$_POST['representante']."','".$_POST['telefono']."','".$_POST['mail']."','".$_POST['credito']."','".$_POST['activo1']."','','')");
        break;

        case 'edit':
            $sql1= mysqli_query($con,"UPDATE cliente SET ruc='".$_POST['ruc']."', cliente='".$_POST['cliente']."', direccion='".$_POST['direccion']."', 
                            tipo='".$_POST['tipo']."', representante='".$_POST['representante']."', telefono='".$_POST['telefono']."', 
                            mail='".$_POST['mail']."', credito='".$_POST['credito']."', activo='".$_POST['activo1']."' WHERE id_cliente='".$_POST['id']."'");
        break;

        case 'del':
            $sql1= mysqli_query($con,"UPDATE cliente SET activo='ANULADO' WHERE id_cliente='".$_POST['id']."'");
            $b=mysqli_query($con,"SELECT cliente FROM cliente WHERE id_cliente='".$_POST['id']."'");
            $row = mysqli_fetch_row($b);
            $a=mysqli_query($con,"INSERT INTO alerta (tipo,concepto,usuario,fecha,hora,estado) VALUES ('CLIENTE','SE ANULO AL CLIENTE ".$row[0]."','".$_SESSION['nombre']."',NOW(),NOW(),'SI')");
        break;

        case 'maps':
            $sql1= mysqli_query($con,"UPDATE cliente SET latitud='".$_POST['latitud']."', longitud='".$_POST['longitud']."' WHERE id_cliente='".$_POST['id']."'");
        break;

        case 'delmaps':
            $sql1= mysqli_query($con,"UPDATE cliente SET latitud='', longitud='' WHERE id_cliente='".$_POST['id']."'");
        break;
    }
}
?>