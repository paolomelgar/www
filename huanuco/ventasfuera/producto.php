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
    
    $query = "SELECT * FROM producto WHERE $producto AND activo!='NO' AND activo!='ANULADO' AND foto!='NO' ORDER BY producto,marca LIMIT 6";
    $result=mysqli_query($con,$query);
    ?>
    <table style='border-collapse:collapse;' width='100%'>
    <?php
    while($row=mysqli_fetch_assoc($result)){
    ?>
      <tr bgcolor='white' style='border:1px solid grey'>
        <td style='padding:0px;'><?php echo '<img src="https://raw.githubusercontent.com/paolomelgar/www/master/huanuco/fotos/producto/a'.$row['codigo'].'.jpg?timestamp=23124" width="60px" height="60px">'; ?></td>
        <td style='display:none;'><?php echo $row['id']; ?></td>
        <td stye='padding:0px'>
          <table width='100%' class="tr">
            <tr>
              <td colspan='2' style='color:#4061a7;font-weight:bold' width='100%'><?php echo $row['producto']; ?></td>
            </tr>
            <tr>
              <td width='50%'><?php echo $row['marca']; ?></td>
              <?php if($_SESSION['cargo']=='CLIENTE ESPECIAL'){ ?>
              <td style='text-align:center;color:#f63;font-weight:bold' width='50%'><?php echo "S/ ".number_format($row['p_compra']*1.05,2, '.', ''); ?></td>
              <?php }else{ ?>
              <td style='text-align:center;color:#f63;font-weight:bold' width='50%'><?php echo "S/ ".$row['p_promotor']; ?></td>
              <?php } ?>
            </tr>
          </table>
        </td>
      </tr>
      <?php } ?>
      <tr bgcolor='#C0C0C0' style='cursor:pointer;color:#f63;border:1px solid grey;font-weight:bold' class='all'>
        <td  colspan='2' align='center'>VER TODOS LOS RESULTADOS</td>
      </tr>
    </table>
    <?php
  }
?>