<?php 
require_once('../connection.php');
$producto = "";
if(substr($_POST['b'],0,3)=='/P '){
    $producto .= "proveedor LIKE '%".substr($_POST['b'],3)."%'";
}else if(substr($_POST['b'],0,3)=='/M '){
    $producto .= "marca LIKE '%".substr($_POST['b'],3)."%'";
}else if(substr($_POST['b'],0,3)=='/F '){
    $producto .= "familia LIKE '%".substr($_POST['b'],3)."%'";
}else{
    $search = explode(" ", $_POST['b']);
    foreach($search AS $s){
        $producto .= "concat(producto,' ',marca) LIKE '%".mysqli_real_escape_string($con,$s)."%' AND ";
    }
    $producto = substr($producto, 0, -4);
}
$num=($_POST['numero']-1)*$_POST['pagina'];
$query = "SELECT * FROM producto WHERE $producto AND activo='".$_POST['activo']."' ORDER BY producto,marca LIMIT $num,".$_POST['pagina'];
$result=mysqli_query($con,$query);
while($row=mysqli_fetch_assoc($result)){ ?>  
    <tr class="tr">
        <td style='display:none'><?php echo mysqli_num_rows(mysqli_query($con,"SELECT * FROM producto WHERE $producto AND activo='".$_POST['activo']."'"))?></td>
        <td style="display:none"><?php echo $row['id']; ?></td>
        <td style='padding:0px' align='center' title='a'><?php echo '<img src="../fotos/producto/a'.$row['codigo'].'.jpg?timestamp=41232" height="100%" width="100%">'; ?></td>
        <td style="text-align:right"><?php echo $row['codigo']; ?></td>
        <td><?php echo $row['producto']; ?></td>
        <td><?php echo $row['marca']; ?></td>
        <td><?php echo $row['familia']; ?></td>
        <td contenteditable="true" class="text"><?php echo $row['proveedor']; ?></td>
        <td contenteditable="true" class="text"><?php echo $row['ubicacion']; ?></td>
        <td contenteditable="true" class="text" style="text-align:right"><?php echo $row['cant_caja']; ?></td>
        <td contenteditable="true" class="text" style="text-align:right"><?php echo $row['caja_master']; ?></td>
        <td style="text-align:right;color:red;font-weight:bold"><?php echo $row['stock_real']; ?></td>
        <?php if($_SESSION['cargo']=='ADMIN'){ ?>
        <td contenteditable="true" class="text" style="text-align:right"><?php echo $row['stock_con']; ?></td>
        <td contenteditable="true" class="text" style="text-align:right"><?php echo $row['stock_con1']; ?></td>
        <?php }else{ ?>
        <td style="text-align:right"><?php echo $row['stock_con']; ?></td>
        <td style="text-align:right"><?php echo $row['stock_con1']; ?></td>
        <?php } ?>
        <td contenteditable="true" class="text" style="text-align:right;color:blue;font-weight:bold"><?php echo $row['p_mayor']; ?></td>
        <td contenteditable="true" class="text" style="text-align:right;color:blue;font-weight:bold"><?php echo $row['p_promotor']; ?></td>
        <td contenteditable="true" class="text" style="text-align:right;color:blue;font-weight:bold"><?php echo $row['p_especial']; ?></td>
        <td contenteditable="true" class="text" style="text-align:right;color:blue;font-weight:bold"><?php echo $row['p_franquicia']; ?></td>
        <?php if($_SESSION['nombre']=='PAUL MELGAR'){ ?>
        <td contenteditable="true" class="text" style="text-align:right;color:green;font-weight:bold"><?php echo $row['p_compra']; ?></td>
        <?php }else{ ?>
        <td contenteditable="true" class="text" style="text-align:right;color:green;font-weight:bold"><?php echo $row['p_compra']; ?></td>
        <?php } ?>
        <td style="text-align:right"><?php echo $row['activo']; ?></td>
    <tr>
<?php } ?>