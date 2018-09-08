<?php 
$con =  mysqli_connect('localhost','root','','paolo');
        mysqli_query ($con,"SET NAMES 'utf8'");
if(isset($_POST['accion']) && !empty($_POST['accion'])){
    switch ($_POST['accion']) {
        case 'add':
            if($_FILES['imagen']['tmp_name']!=''){
                $sql1= mysqli_query($con,"INSERT INTO familia (familia,activo,foto) VALUES ('".$_POST['familia']."','".$_POST['activo1']."','SI')");
            }
            else{
                $sql1= mysqli_query($con,"INSERT INTO familia (familia,activo,foto) VALUES ('".$_POST['familia']."','".$_POST['activo1']."','NO')");
            }
            $q=mysqli_query($con,"SELECT MAX(id) FROM familia");
            $ro=mysqli_fetch_row($q);
            move_uploaded_file($_FILES['imagen']['tmp_name'], realpath("../foto".$_SESSION['mysql']."/familia ")."/a".$ro[0].".jpg");
        break;
        ///////////////////////////////////////////////////////////////////////////////////
        case 'edit':
            if($_FILES['imagen']['tmp_name']!=''){
                $sql1= mysqli_query($con,"UPDATE familia SET familia='".$_POST['familia']."', activo='".$_POST['activo1']."', foto='SI' WHERE id='".$_POST['id']."'");
            }
            else{
                $sql1= mysqli_query($con,"UPDATE familia SET familia='".$_POST['familia']."', activo='".$_POST['activo1']."' WHERE id='".$_POST['id']."'");
            }
            move_uploaded_file($_FILES['imagen']['tmp_name'], realpath("../foto".$_SESSION['mysql']."/familia ")."/a".$_POST['id'].".jpg");
        break;
        ///////////////////////////////////////////////////////////////////////////////////
        case 'del':
            $sqll = mysqli_query($con,"SELECT * FROM familia WHERE foto='SI' AND id='".$_POST['id']."'");
            if(mysqli_num_rows($sqll)>0){
                unlink("../fotos/familia"."/a".$_POST['id'].".jpg");
            }
            $sql12= mysqli_query($con,"DELETE FROM familia WHERE id='".$_POST['id']."'");
        break;
    }
}
?>