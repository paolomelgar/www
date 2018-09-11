<?php
require_once('../connection.php');
  if(isset($_POST) && !empty($_POST)){
    $search = explode(" ", $_POST['b']);
    $producto = "";
    foreach($search AS $s){
      $producto .= "concat(producto,' ',marca) LIKE '%".mysqli_real_escape_string($con,$s)."%' AND ";
    }
    $producto = substr($producto, 0, -4);
    $query = "SELECT * FROM producto WHERE $producto AND activo!='NO' AND activo!='ANULADO' ORDER BY producto,marca LIMIT 12";
    $result=mysqli_query($con,$query);
    ?>
    <?php
    while($row=mysqli_fetch_assoc($result)){
        $as='';
        if($row['p_compra']>0){
            $x=($row['p_especial']-$row['p_compra'])/$row['p_compra'];
            if($x>=0.35){
                $as= "bgcolor='#74FF64'";
            }else if($x<0.35 && $x>=0.25){
                $as= "bgcolor='#EFFF82'";
            }else{
                $as= "bgcolor='#FF8B8B'";
            }
        }
    ?>
      <tr class="tr" <?php echo $as; ?> style='font-weight:bold;'>
        <td style='padding:0px;' title='s'><?php echo '<img src="https://raw.githubusercontent.com/paolomelgar/www/master/huancayoprincipal/fotos/producto/a'.$row['id'].'.jpg?timestamp=23124" width="100%" height="100%">'; ?></td>
        <td style='display:none;'><?php echo $row['id']; ?></td>
        <td><?php echo $row['producto']; ?></td>
        <td><?php echo $row['marca']; ?></td>
        <td style='display:none'><?php echo $row['p_compra']; ?></td>
        <td style='text-align:right'><?php echo $row['cant_caja']; ?></td>
        <td style='color:red;text-align:right'><?php echo $row['stock_real']; ?></td>
        <td style='text-align:right'><?php echo $row['p_mayor']; ?></td>
        <td style='text-align:right'><?php echo $row['p_promotor']; ?></td>
        <td style='text-align:right'><?php echo $row['p_especial']; ?></td>
        <td style='text-align:right;display:none'><?php echo $row['ubicacion']; ?></td>
      </tr>
    <?php
    }
  }
?>