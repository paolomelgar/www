<?php
session_start();
$con =  mysqli_connect('localhost','root','','neofer');
  mysqli_query ($con,"SET NAMES 'utf8'");
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
        ?>  
      <tr class="tr" style='font-weight: bold;color:black' bgcolor='#F63'>
        <td style='padding:0px;' title='s'><?php echo '<img src="https://raw.githubusercontent.com/paolomelgar/www/master/neofer/fotos/producto/a'.$row['codigo'].'.jpg?timestamp=23124" width="100%" height="100%">'; ?></td>
        <td style='display:none;'><?php echo $row['id']; ?></td>
        <td><?php echo $row['producto']; ?></td>
        <td><?php echo $row['marca']; ?></td>
        <?php if($_SESSION['cargo']=='ADMIN'){ ?>
        <td style='text-align:right'><?php echo $row['p_promotor']; ?></td>
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