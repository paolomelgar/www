<?php 
require_once('../connection.php');
    $search = explode(" ", $_POST['b']);
    $producto = "";
    foreach($search AS $s){
        $producto .= "concat(ruc,cliente) LIKE '%".mysqli_real_escape_string($con,$s)."%' AND ";
    }
    $producto = substr($producto, 0, -4);
    $num=($_POST['numero']-1)*$_POST['pagina'];

    $query = "SELECT * FROM cliente WHERE $producto AND activo='".$_POST['activo']."' ORDER BY cliente LIMIT $num,".$_POST['pagina'];
    $result=mysqli_query($con,$query);
    while($row=mysqli_fetch_assoc($result)){ ?>  
        <tr class="tr">
            <td style='display:none'><?php echo mysqli_num_rows(mysqli_query($con,"SELECT * FROM cliente WHERE $producto AND activo='".$_POST['activo']."'")); ?></td>
            <td style="display:none"><?php echo $row['id_cliente']; ?></td>
            <?php if ($row['latitud']!=0) { ?>
            <td style='padding:0px;cursor:pointer' class="mapa" align='center' title='Editar o Eliminar Ubicacion'><img src='maps.png' height="100%" width="100%"></td>
            <?php } else { ?>
            <td style='padding:0px;cursor:pointer' class="addmapa" align='center' title='Guardar Ubicacion'><img src='addmaps.png' height="100%" width="100%"></td>
            <?php } ?>
            <td><?php echo $row['ruc']; ?></td>
            <td><?php echo $row['cliente']; ?></td>
            <td><?php echo $row['direccion']; ?></td>
            <td><?php echo $row['tipo']; ?></td>
            <td><?php echo $row['credito']; ?></td>
            <td><?php echo $row['representante']; ?></td>
            <td><?php echo $row['clase']; ?></td>
            <td><?php echo $row['celular']; ?></td>
            <td><?php echo $row['correo']; ?></td>
            <td><?php echo $row['activo']; ?></td>
            <td style='display:none'><?php echo $row['latitud']; ?></td>
            <td style='display:none'><?php echo $row['longitud']; ?></td>
        <tr>
<?php } ?>