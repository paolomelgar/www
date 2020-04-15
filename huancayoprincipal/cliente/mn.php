<?php 
require_once('../connection.php');
$search = explode(" ", $_POST['b']);
$producto = "";
if($_POST['promotor']!=""){
    $producto="representante='".$_POST['promotor']."' AND ";
}
if($_POST['ubicacion']!=""){
    $producto="zona='".$_POST['ubicacion']."' AND ";
}
foreach($search AS $s){
    $producto .= "concat(ruc,' ',cliente) LIKE '%".mysqli_real_escape_string($con,$s)."%' AND ";
}
$producto = substr($producto, 0, -4);
$num=($_POST['numero']-1)*$_POST['pagina'];
if(isset($_POST['accion']) && !empty($_POST['accion'])){
    switch ($_POST['accion']) {
        case 'add':
            $sql1= mysqli_query($con,"INSERT INTO cliente (ruc,cliente,direccion,tipo,representante,celular,nomcomercial,credito,activo,latitud,longitud,clase,zona,correo,nombrecliente,fnacimiento) 
            VALUES ('".$_POST['ruc']."','".$_POST['cliente']."','".$_POST['direccion']."','".$_POST['tipo']."','".$_POST['representante']."','".$_POST['celular']."','".$_POST['nomcomercial']."','".$_POST['credito']."','".$_POST['activo1']."','','','".$_POST['clase']."','".$_POST['zona']."','".$_POST['correo']."','".$_POST['nombrecliente']."', '".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fnacimiento'])))."')");
        break;

        case 'edit':
            $sql1= mysqli_query($con,"UPDATE cliente SET ruc='".$_POST['ruc']."', cliente='".$_POST['cliente']."', direccion='".$_POST['direccion']."', tipo='".$_POST['tipo']."', representante='".$_POST['representante']."', celular='".$_POST['celular']."', correo='".$_POST['correo']."', clase='".$_POST['clase']."', zona='".$_POST['zona']."', nomcomercial='".$_POST['nomcomercial']."', credito='".$_POST['credito']."', activo='".$_POST['activo1']."', nombrecliente='".$_POST['nombrecliente']."', fnacimiento='".date('Y-m-d', strtotime(str_replace('/', '-', $_POST['fnacimiento'])))."' WHERE id_cliente='".$_POST['id']."'");
        break;

        case 'del':
            $sql1= mysqli_query($con,"DELETE FROM cliente WHERE id_cliente='".$_POST['id']."'");
        break;

        case 'maps':
            $sql1= mysqli_query($con,"UPDATE cliente SET latitud='".$_POST['latitud']."', longitud='".$_POST['longitud']."' WHERE id_cliente='".$_POST['id']."'");
        break;

        case 'delmaps':
            $sql1= mysqli_query($con,"UPDATE cliente SET latitud='', longitud='' WHERE id_cliente='".$_POST['id']."'");
        break;
    }
}
$query = "SELECT * FROM cliente WHERE $producto AND activo='".$_POST['activo']."'ORDER BY cliente LIMIT $num,".$_POST['pagina'];
$result=mysqli_query($con,$query);
while($row=mysqli_fetch_assoc($result)){ ?>  
    <tr class="tr">
        <td style="display:none"><?php echo $row['id_cliente']; ?></td>
        <?php if ($row['latitud']!=0) { ?>
        <td class="mapa" style="text-align:center;cursor:pointer"><img src='maps.png' style='height:18px'></td>
        <?php } else { ?>
        <td class="addmapa" style="text-align:center;cursor:pointer"><img src='addmaps.png' style='height:18px'></td>
        <?php } ?>
        <td><?php echo $row['ruc']; ?></td>
        <td><?php echo $row['cliente']; ?></td>
        <td><?php echo $row['direccion']; ?></td>
        <td><?php echo $row['tipo']; ?></td>
        <td><?php echo $row['credito']; ?></td>
        <td><?php echo $row['clase']; ?></td>
        <td><?php echo $row['zona']; ?></td>
        <td><?php echo $row['correo']; ?></td>
        <td><?php echo $row['representante']; ?></td>
        <td><?php echo $row['celular']; ?></td>
        <td><?php echo $row['nomcomercial']; ?></td>
        <td><?php echo $row['nombrecliente']; ?></td>
        <td><?php echo date('Y-m-d', strtotime(str_replace('-', '/', $row['fnacimiento']))); ?></td>
        <td><?php echo $row['activo']; ?></td>
        <td style='display:none'><?php echo $row['latitud']; ?></td>
        <td style='display:none'><?php echo $row['longitud']; ?></td>
        <td style='display:none'><?php echo mysqli_num_rows(mysqli_query($con,"SELECT * FROM cliente WHERE $producto AND activo='".$_POST['activo']."'")); ?></td>
    <tr>
<?php } ?>

