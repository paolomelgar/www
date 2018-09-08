<?php 
require_once('../connection.php');
if(isset($_POST['accion']) && !empty($_POST['accion'])){
    switch ($_POST['accion']) {
        case 'add':
            $sql1= mysqli_query($con,"INSERT INTO transportista (ruc,transportista,direccion,representante,telefono,celular,mail,activo) 
            VALUES ('".$_POST['ruc']."','".$_POST['transportista']."','".$_POST['direccion']."','".$_POST['representante']."','".$_POST['telefono']."','".$_POST['celular']."','".$_POST['mail']."','".$_POST['activo1']."')");
        break;

        ///////////////////////////////////////////////////////////////////////////////////

        case 'edit':
            $sql1= mysqli_query($con,"UPDATE transportista SET ruc='".$_POST['ruc']."', transportista='".$_POST['transportista']."', direccion='".$_POST['direccion']."', 
                            representante='".$_POST['representante']."', telefono='".$_POST['telefono']."', celular='".$_POST['celular']."', 
                            mail='".$_POST['mail']."', activo='".$_POST['activo1']."' WHERE id='".$_POST['id']."'");
        break;

        ///////////////////////////////////////////////////////////////////////////////////

        case 'del':
            $sql1= mysqli_query($con,"DELETE FROM transportista WHERE id='".$_POST['id']."'");
        break;
    }
}
?>