<?php 
session_start();
require_once('../connection.php');
$search = explode(" ", $_POST['b']);
$producto = "";
foreach($search AS $s){
    $producto .= "concat(producto,' ',marca) LIKE '%".mysqli_real_escape_string($con,$s)."%' AND ";
}
$producto = substr($producto, 0, -4);
$num=($_POST['numero']-1)*$_POST['pagina'];

if($_POST['cont']=="CONT"){
    $producto.=" AND stock_con>0";
}
if($_POST['prov']!=""){
    $producto.=" AND proveedor LIKE '%".$_POST['prov']."%'";
}
$query = "SELECT * FROM producto WHERE $producto AND activo='".$_POST['activo']."' ORDER BY producto,marca LIMIT $num,".$_POST['pagina'];
$result=mysqli_query($con,$query);
while($row=mysqli_fetch_assoc($result)){ ?>  
    <tr class="tr">
        <td style='display:none'><?php echo mysqli_num_rows(mysqli_query($con,"SELECT * FROM producto WHERE $producto AND activo='".$_POST['activo']."'"))?></td>
        <td style="display:none"><?php echo $row['id']; ?></td>
        <td style='padding:0px' align='center' title='a'><?php echo '<img src="https://raw.githubusercontent.com/paolomelgar/www/master/huanucotienda/fotos/producto/a'.$row['id'].'.jpg?timestamp=41232" height="100%" width="100%">'; ?></td>
        <td><?php echo $row['producto']; ?></td>
        <td><?php echo $row['marca']; ?></td>
        <td><?php echo $row['familia']; ?></td>
        <td title=""><?php echo $row['proveedor']; ?></td>
        <td contenteditable="true" class="text" style="text-align:right"><?php echo $row['cant_caja']; ?></td>
        <?php if($_SESSION['nombre']=='PAOLO MELGAR'){ ?>
        <td contenteditable="true" class="text" style="text-align:right;color:red;font-weight:bold"><?php echo $row['stock_real']; ?></td>
        <td contenteditable="true" class="text" style="text-align:right"><?php echo $row['stock_con']; ?></td>
        <td contenteditable="true" class="text" style="text-align:right;color:blue;font-weight:bold"><?php echo $row['p_promotor']; ?></td>
        <td contenteditable="true" class="text" style="text-align:right;color:blue;font-weight:bold"><?php echo $row['p_especial']; ?></td>
        <td contenteditable="true" class="text" style="text-align:right;color:green;font-weight:bold"><?php echo $row['p_compra']; ?></td>
        <td contenteditable="true" class="text" style="text-align:right;color:blue;font-weight:bold"><?php echo $row['porcentaje']; ?></td>
        <?php }else{ ?>
        <td style="text-align:right;color:red;font-weight:bold"><?php echo $row['stock_real']; ?></td>
        <td style="text-align:right"><?php echo $row['stock_con']; ?></td>
        <td contenteditable="true" class="text" style="text-align:right;color:blue;font-weight:bold"><?php echo $row['p_promotor']; ?></td>
        <td contenteditable="true" class="text" style="text-align:right;color:blue;font-weight:bold"><?php echo $row['p_especial']; ?></td>
        <td style="text-align:right;color:green;font-weight:bold"><?php echo $row['p_compra']; ?></td>
        <td contenteditable="true" class="text" style="text-align:right;color:blue;font-weight:bold"><?php echo $row['porcentaje']; ?></td>
        <?php } ?>
        <td style="text-align:right"><?php echo $row['activo']; ?></td>
    <tr>
<?php } ?>