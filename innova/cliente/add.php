<?php 
session_start();
require_once('../connection.php');
if(isset($_POST['accion']) && !empty($_POST['accion'])){
    switch ($_POST['accion']) {
        case 'add':
            $sql1= mysqli_query($con,"INSERT INTO cliente (ruc,cliente,direccion,tipo,representante,celular,correo,credito,activo,latitud,longitud,clase,nombrecliente,fnacimiento) 
            VALUES ('".$_POST['ruc']."','".$_POST['cliente']."','".$_POST['direccion']."','".$_POST['tipo']."','".$_POST['representante']."','".$_POST['celular']."','".$_POST['correo']."','".$_POST['credito']."','".$_POST['activo1']."','','','".$_POST['clase']."','".$_POST['nombrecliente']."', '".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fnacimiento'])))."')");
        break;

        case 'edit':
            $sql1= mysqli_query($con,"UPDATE cliente SET ruc='".$_POST['ruc']."', cliente='".$_POST['cliente']."', direccion='".$_POST['direccion']."', tipo='".$_POST['tipo']."', representante='".$_POST['representante']."', clase='".$_POST['clase']."', celular='".$_POST['celular']."', correo='".$_POST['correo']."', credito='".$_POST['credito']."', activo='".$_POST['activo1']."', nombrecliente='".$_POST['nombrecliente']."', fnacimiento='".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fnacimiento'])))."' WHERE id_cliente='".$_POST['id']."'");
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