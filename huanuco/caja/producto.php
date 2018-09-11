<?php
session_start();
require_once('../connection.php');
  if(isset($_POST) && !empty($_POST)){
    $search = explode(" ", $_POST['b']);
    $producto = "";
    foreach($search AS $s){
      $producto .= "concat(producto,' ',marca) LIKE '%".mysqli_real_escape_string($con,$s)."%' AND ";
    }
    $producto = substr($producto, 0, -4);
    if($_POST['doc']=='FACTURA'){
      $query = "SELECT * FROM producto WHERE $producto ORDER BY producto,marca LIMIT 12";
    }else{
      $query = "SELECT * FROM producto WHERE $producto AND activo!='NO' AND activo!='ANULADO' ORDER BY producto,marca LIMIT 12";
    }
    $result=mysqli_query($con,$query);
    ?>
    <?php
    while($row=mysqli_fetch_assoc($result)){
        $diff=date_diff(date_create(date('Y-m-d')),date_create($row['antiguedad']));?>  
    ?>
      <tr class="tr" <?php if($diff->format("%a")>=365){echo "bgcolor='#FF8B8B'";}else if($diff->format("%a")<365 && $diff->format("%a")>=182){echo "bgcolor='#FBFE33'";}else{echo "bgcolor='white'";}?> style='font-weight: bold'>
        <td style='padding:0px;' title='s'><?php echo '<img src="https://raw.githubusercontent.com/paolomelgar/www/master/huanuco/fotos/producto/a'.$row['id'].'.jpg?timestamp=23124" width="100%" height="100%">'; ?></td>
        <td style='display:none;'><?php echo $row['id']; ?></td>
        <td><?php echo $row['producto']; ?></td>
        <td><?php echo $row['marca']; ?></td>
        <?php if($_SESSION['cargo']=='ADMIN'){ ?>
        <td style='text-align:right;display:none'><?php echo $row['p_compra']; ?></td>
        <?php }else{ ?>
        <td style='text-align:right;display:none'><?php echo $row['p_compra']; ?></td>
        <?php } ?>
        <td style='text-align:right'><?php echo $row['cant_caja']; ?></td>
        <?php if($_POST['doc']=='FACTURA'){ ?>
        <td style='color:blue;text-align:right'><?php echo $row['stock_con']; ?></td>
        <?php }else{ ?>
        <td style='color:red;text-align:right'><?php echo $row['stock_real']; ?></td>
        <?php } ?>
        <td style='text-align:right;background-color:#f63'><?php echo $row['p_promotor']; ?></td>
        </tr>
    <?php
    }
  }
?>