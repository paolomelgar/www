<?php 
require_once('../connection.php');
if(isset($_POST['accion']) && !empty($_POST['accion'])){
    switch ($_POST['accion']) {
        case 'add':
            $sql1= mysqli_query($con,"INSERT INTO usuario (nombre,usuario,password,cumple,celular,cargo,activo) 
            VALUES ('".$_POST['nombre']."','".$_POST['usuario']."','".$_POST['password']."','".$_POST['cumple']."','".$_POST['celular']."','".$_POST['cargo']."','".$_POST['activo1']."')");
        break;

        ///////////////////////////////////////////////////////////////////////////////////

        case 'edit':
            if($_POST['usuario']=="aaaaa" && $_POST['password']=="aaaaa"){
                $sql1= mysqli_query($con,"UPDATE usuario SET nombre='".$_POST['nombre']."', cumple='".$_POST['cumple']."', celular='".$_POST['celular']."', 
                            cargo='".$_POST['cargo']."', activo='".$_POST['activo1']."' WHERE id='".$_POST['id']."'");
            }else if($_POST['usuario']!="aaaaa" && $_POST['password']=="aaaaa"){
                $sql1= mysqli_query($con,"UPDATE usuario SET nombre='".$_POST['nombre']."', cumple='".$_POST['cumple']."', celular='".$_POST['celular']."', usuario='".$_POST['usuario']."', 
                            cargo='".$_POST['cargo']."', activo='".$_POST['activo1']."' WHERE id='".$_POST['id']."'");
            }else if ($_POST['usuario']=="aaaaa" && $_POST['password']!="aaaaa") {
                $sql1= mysqli_query($con,"UPDATE usuario SET nombre='".$_POST['nombre']."', cumple='".$_POST['cumple']."', celular='".$_POST['celular']."', password='".$_POST['password']."', 
                            cargo='".$_POST['cargo']."', activo='".$_POST['activo1']."' WHERE id='".$_POST['id']."'");
            }else{
                $sql1= mysqli_query($con,"UPDATE usuario SET nombre='".$_POST['nombre']."', cumple='".$_POST['cumple']."', celular='".$_POST['celular']."', usuario='".$_POST['usuario']."', password='".$_POST['password']."', 
                            cargo='".$_POST['cargo']."', activo='".$_POST['activo1']."' WHERE id='".$_POST['id']."'"); 
            }
        break;

        ///////////////////////////////////////////////////////////////////////////////////

        case 'del':
            $sql1= mysqli_query($con,"DELETE FROM usuario WHERE id='".$_POST['id']."'");
        break;
    }
}
?>