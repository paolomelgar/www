<?php 
require_once('../connection.php');
    $search = explode(" ", $_POST['b']);
    $producto = "";
    foreach($search AS $s){
        $producto .= "concat(ruc,proveedor) LIKE '%".mysqli_real_escape_string($con,$s)."%' AND ";
    }
    $producto = substr($producto, 0, -4);
    $num=($_POST['numero']-1)*$_POST['pagina'];

    $query = "SELECT * FROM proveedor WHERE $producto AND activo='".$_POST['activo']."' ORDER BY proveedor LIMIT $num,".$_POST['pagina'];
    $result=mysqli_query($con,$query);
    while($row=mysqli_fetch_assoc($result)){ ?>  
        <tr class="tr">
            <td style='display:none'><?php echo mysqli_num_rows(mysqli_query($con,"SELECT * FROM proveedor WHERE $producto AND activo='".$_POST['activo']."'"))?></td>
            <td style="display:none"><?php echo $row['id']; ?></td>
            <td><?php echo $row['ruc']; ?></td>
            <td><?php echo $row['proveedor']; ?></td>
            <td><?php echo $row['direccion']; ?></td>
            <td><?php echo $row['representante']; ?></td>
            <td><?php echo $row['telefono']; ?></td>
            <td><?php echo $row['celular']; ?></td>
            <td><?php echo $row['mail']; ?></td>
            <td style="text-align:right"><?php echo $row['activo']; ?></td>
        <tr>
<?php } ?>
