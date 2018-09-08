<?php 
require_once('../connection.php');        
$search = explode(" ", $_POST['b']);
$producto = "";
foreach($search AS $s){
    $producto .= "familia LIKE '%".mysqli_real_escape_string($con,$s)."%' AND ";
}
$producto = substr($producto, 0, -4);
$num=($_POST['numero']-1)*$_POST['pagina'];
if(isset($_POST['accion']) && !empty($_POST['accion'])){
    switch ($_POST['accion']) {
        case 'add':
            $sql1= mysqli_query($con,"INSERT INTO familia (familia,activo) VALUES ('".$_POST['familia']."','".$_POST['activo1']."')");
        break;

        ///////////////////////////////////////////////////////////////////////////////////

        case 'edit':
            $sql1= mysqli_query($con,"UPDATE familia SET familia='".$_POST['familia']."', activo='".$_POST['activo1']."' WHERE id='".$_POST['id']."'");
        break;

        ///////////////////////////////////////////////////////////////////////////////////

        case 'del':
            $sql1= mysqli_query($con,"DELETE FROM familia WHERE id='".$_POST['id']."'");
        break;
    }
}
$query = "SELECT * FROM familia WHERE $producto AND activo='".$_POST['activo']."' ORDER BY familia LIMIT $num,".$_POST['pagina'];
$result=mysqli_query($con,$query);
while($row=mysqli_fetch_assoc($result)){ ?>  
    <tr class="tr">
        <td style="display:none"><?php echo $row['id']; ?></td>
        <td><?php echo $row['familia']; ?></td>
        <td style="text-align:right"><?php echo $row['activo']; ?></td>
        <td style='display:none'><?php echo mysqli_num_rows(mysqli_query($con,"SELECT * FROM familia WHERE $producto AND activo='".$_POST['activo']."'"))?></td>
    <tr>
<?php } ?>