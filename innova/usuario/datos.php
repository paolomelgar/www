<?php 
require_once('../connection.php');
    $search = explode(" ", $_POST['b']);
    $producto = "";
    foreach($search AS $s){
        $producto .= "nombre LIKE '%".mysqli_real_escape_string($con,$s)."%' AND ";
    }
    $producto = substr($producto, 0, -4);
    $num=($_POST['numero']-1)*$_POST['pagina'];

    $query = "SELECT * FROM usuario WHERE $producto AND activo='".$_POST['activo']."' ORDER BY cargo,nombre LIMIT $num,".$_POST['pagina'];
    $result=mysqli_query($con,$query);
    while($row=mysqli_fetch_assoc($result)){ ?>  
        <tr class="tr">
            <td style='display:none'><?php echo mysqli_num_rows(mysqli_query($con,"SELECT * FROM usuario WHERE $producto AND activo='".$_POST['activo']."'"))?></td>
            <td style="display:none"><?php echo $row['id']; ?></td>
            <td><?php echo $row['nombre']; ?></td>
            <td><?php echo $row['cumple']; ?></td>
            <td><?php echo $row['celular']; ?></td>
            <td><?php echo $row['cargo']; ?></td>
            <td style="text-align:right"><?php echo $row['activo']; ?></td>
        <tr>
<?php } ?>
