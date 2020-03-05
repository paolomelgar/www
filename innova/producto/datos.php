<?php 
require_once('../connection.php');
$search = explode(" ", $_POST['b']);
$producto = "";
if(substr($_POST['b'],0,3)=='/P '){
    $producto .= "proveedor LIKE '%".substr($_POST['b'],3)."%'";
}else if(substr($_POST['b'],0,3)=='/M '){
    $producto .= "marca LIKE '%".substr($_POST['b'],3)."%'";
}else if(substr($_POST['b'],0,3)=='/F '){
    $producto .= "familia LIKE '%".substr($_POST['b'],3)."%'";
}else if(substr($_POST['b'],0,4)=='/U1 '){
    $producto .= "ubicacion='".substr($_POST['b'],4)."'";
}else if(substr($_POST['b'],0,4)=='/U2 '){
    $producto .= "ubicacion2='".substr($_POST['b'],4)."'";
}else{
    foreach($search AS $s){
        $producto .= "concat(producto,' ',marca) LIKE '%".mysqli_real_escape_string($con,$s)."%' AND ";
    }
    $producto = substr($producto, 0, -4);
}
$num=($_POST['numero']-1)*$_POST['pagina'];
if($_POST['cont']=="CONT"){
    $producto.=" AND stock_con>0";
}
if($_POST['prov']!=""){
    $producto.=" AND proveedor LIKE '%".$_POST['prov']."%'";
}
$query = "SELECT * FROM producto WHERE $producto AND activo='".$_POST['activo']."' ORDER BY producto,marca LIMIT $num,".$_POST['pagina'];
$result=mysqli_query($con,$query);
while($row=mysqli_fetch_assoc($result)){
        $diff=date_diff(date_create(date('Y-m-d')),date_create($row['antiguedad']));?>
        <tr class="tr" <?php if($diff->format("%a")>=365){echo "bgcolor='#FF8B8B'";}else if($diff->format("%a")<365 && $diff->format("%a")>=182){echo "bgcolor='#FBFE33'";}else{echo "";} ?>>
        <td style='display:none'><?php echo mysqli_num_rows(mysqli_query($con,"SELECT * FROM producto WHERE $producto AND activo='".$_POST['activo']."'"))?></td>
        <td style="display:none"><?php echo $row['id']; ?></td>
        <td style='padding:0px' align='center' title='a'><?php echo '<img src="https://raw.githubusercontent.com/paolomelgar/www/master/huancayoprincipal/fotos/producto/a'.$row['codigo'].'.jpg?timestamp=41232" height="100%" width="100%">'; ?></td>
        
        <?php if($_SESSION['cargo']!='VENDEDOR'){ ?>
        <td style='text-align: center;'><?php echo $row['codigo']; ?></td>
        <td><?php echo $row['producto']; ?></td>
        <td><?php echo $row['marca']; ?></td>
        <td><?php echo $row['familia']; ?></td>
        <td contenteditable="true" class="text" title=""><?php echo $row['proveedor']; ?></td>
        <td contenteditable="true" class="text"><?php echo $row['ubicacion']; ?></td>
        <td contenteditable="true" class="text"><?php echo $row['ubicacion2']; ?></td>
        <?php if($_SESSION['cargo']=='ADMIN' || $_SESSION['cargo']=='ENCARGADOTIENDA' ){ ?>
        <td contenteditable="true" class="text" style="text-align:right"><?php echo $row['cant_caja']; ?></td>
        <?php if($_SESSION['mysql']=="innovaprincipalL" || $_SESSION['mysql']=="dorispovez"){ ?>
            <td style="text-align:right;color:red;font-weight:bold"><?php echo $row['stock_real']; ?></td>
            <td style="text-align:right;color:green;font-weight:bold"><?php echo $row['stock_almacen']; ?></td>
            <td contenteditable="true" class="text" style="text-align:right;color:grey;font-weight:bold"><?php echo $row['stock_muestra']; ?></td>
            <td style="text-align:right;color:grey;font-weight:bold"><?php echo $row['stock_muestra2']; ?></td>
            <td style="text-align:right;color:brown;font-weight:bold"><?php echo $row['stock_inventario']; ?></td>
        <?php }else{ ?>
            <td style="text-align:right;color:red;font-weight:bold"><?php echo $row['stock_real']; ?></td>
            <td style="text-align:right;color:green;font-weight:bold"><?php echo $row['stock_almacen']; ?></td>
            <td style="text-align:right;color:grey;font-weight:bold"><?php echo $row['stock_muestra']; ?></td>
            <td style="text-align:right;color:grey;font-weight:bold"><?php echo $row['stock_muestra2']; ?></td>
            <td style="text-align:right;color:brown;font-weight:bold"><?php echo $row['stock_inventario']; ?></td>
        <?php } ?>
        <td contenteditable="true" class="text" style="text-align:right"><?php echo $row['stock_con']; ?></td>
        <td contenteditable="true" class="text" style="text-align:right;color:blue;font-weight:bold"><?php echo $row['p_unidad']; ?></td>
        <td contenteditable="true" class="text" style="text-align:right;color:blue;font-weight:bold"><?php echo $row['p_promotor']; ?></td>
        <td contenteditable="true" class="text" style="text-align:right;color:blue;font-weight:bold"><?php echo $row['p_especial']; ?></td>
        <td contenteditable="true" class="text" style="text-align:right;color:blue;font-weight:bold"><?php echo $row['p_fran']; ?></td>
        <td contenteditable="true" class="text" style="text-align:right;color:green;font-weight:bold"><?php echo $row['p_compra']; ?></td>
        <td style="text-align:right;color:blue;font-weight:bold"><?php echo $diff->format("%a Dias"); ?></td>
        

        <?php }else{ ?>
        <td style="text-align:right"><?php echo $row['cant_caja']; ?></td>
        <td style="text-align:right;color:red;font-weight:bold"><?php echo $row['stock_real']; ?></td>
        <td style="text-align:right;color:green;font-weight:bold"><?php echo $row['stock_almacen']; ?></td>
        <td style="text-align:right"><?php echo $row['stock_con']; ?></td>
        <td style="text-align:right;color:blue;font-weight:bold"><?php echo $row['p_unidad']; ?></td>
        <td style="text-align:right;color:blue;font-weight:bold"><?php echo $row['p_promotor']; ?></td>
        <td style="text-align:right;color:blue;font-weight:bold"><?php echo $row['p_especial']; ?></td>
        <!-- <td style="text-align:right;color:blue;font-weight:bold"><?php echo $row['p_franquicia']; ?></td> -->
        <td style="text-align:right;color:green;font-weight:bold"><?php echo $row['p_compra']; ?></td>
        <?php } ?>
        <td style="text-align:right"><?php echo $row['activo']; ?></td>

        <?php } else {?>

        <td style='text-align: center;'><?php echo $row['codigo']; ?></td>
        <td><?php echo $row['producto']; ?></td>
        <td><?php echo $row['marca']; ?></td>
        <td><?php echo $row['familia']; ?></td>
        <td contenteditable="true" class="text"><?php echo $row['ubicacion2']; ?></td>
        <td style="text-align:right"><?php echo $row['cant_caja']; ?></td>
        <td style="text-align:right;color:red;font-weight:bold"><?php echo $row['stock_real']; ?></td>
        <td style="text-align:right;color:grey;font-weight:bold"><?php echo $row['stock_muestra']; ?></td>
        <td style="text-align:right;color:grey;font-weight:bold"><?php echo $row['stock_muestra2']; ?></td>
        <td style="text-align:right;color:green;font-weight:bold"><?php echo $row['stock_almacen']; ?></td>
        <td style="text-align:right;color:blue;font-weight:bold"><?php echo $row['p_unidad']; ?></td>
        <td style="text-align:right;color:blue;font-weight:bold"><?php echo $row['p_promotor']; ?></td>
        <td style="text-align:right;color:blue;font-weight:bold"><?php echo $row['p_especial']; ?></td>
        <td style="text-align:right"><?php echo $row['activo']; ?></td>D
        <?php } ?>
    <tr>
<?php } ?>