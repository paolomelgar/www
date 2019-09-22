<?php 
require_once('../connection.php');
$search = explode(" ", $_POST['b']);
$producto = "";
foreach($search AS $s){
    $producto .= "concat(ruc,' ',transportista) LIKE '%".mysqli_real_escape_string($con,$s)."%' AND ";
}
$producto = substr($producto, 0, -4);
$num=($_POST['numero']-1)*$_POST['pagina'];
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
$query = "SELECT * FROM transportista WHERE $producto AND activo='".$_POST['activo']."' ORDER BY transportista LIMIT $num,".$_POST['pagina'];
$result=mysqli_query($con,$query);
while($row=mysqli_fetch_assoc($result)){ ?>  
    <tr class="tr">
        <td style="display:none"><?php echo $row['id']; ?></td>
        <td><?php echo $row['ruc']; ?></td>
        <td><?php echo $row['transportista']; ?></td>
        <td><?php echo $row['direccion']; ?></td>
        <td><?php echo $row['representante']; ?></td>
        <td><?php echo $row['telefono']; ?></td>
        <td><?php echo $row['celular']; ?></td>
        <td><?php echo $row['mail']; ?></td>
        <td style="text-align:right"><?php echo $row['activo']; ?></td>
        <td style='display:none'><?php echo mysqli_num_rows(mysqli_query($con,"SELECT * FROM transportista WHERE $producto AND activo='".$_POST['activo']."'"))?></td>
    <tr>
<?php } ?>

