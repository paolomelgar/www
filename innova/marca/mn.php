<?php 
require_once('../connection.php');
$search = explode(" ", $_POST['b']);
$producto = "";
foreach($search AS $s){
    $producto .= "marca LIKE '%".mysqli_real_escape_string($con,$s)."%' AND ";
}
$producto = substr($producto, 0, -4);
$num=($_POST['numero']-1)*$_POST['pagina'];
if(isset($_POST['accion']) && !empty($_POST['accion'])){
    switch ($_POST['accion']) {
        case 'add':
            $sql1= mysqli_query($con,"INSERT INTO marca (marca,activo) VALUES ('".$_POST['marca']."','".$_POST['activo1']."')");
        break;

        ///////////////////////////////////////////////////////////////////////////////////

        case 'edit':
            $sql1= mysqli_query($con,"UPDATE marca SET marca='".$_POST['marca']."', activo='".$_POST['activo1']."' WHERE id='".$_POST['id']."'");
        break;

        ///////////////////////////////////////////////////////////////////////////////////

        case 'del':
            $sql1= mysqli_query($con,"DELETE FROM marca WHERE id='".$_POST['id']."'");
        break;
    }
}
$query = "SELECT * FROM marca WHERE $producto AND activo='".$_POST['activo']."' ORDER BY marca LIMIT $num,".$_POST['pagina'];
$result=mysqli_query($con,$query);
while($row=mysqli_fetch_assoc($result)){ ?>  
    <tr class="tr">
        <td style="display:none"><?php echo $row['id']; ?></td>
        <td><?php echo $row['marca']; ?></td>
        <td style="text-align:right"><?php echo $row['activo']; ?></td>
        <td style='display:none'><?php echo mysqli_num_rows(mysqli_query($con,"SELECT * FROM marca WHERE $producto AND activo='".$_POST['activo']."'"))?></td>
    <tr>
<?php } ?>

