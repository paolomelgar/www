<?php
require_once('../connection.php');
  if(isset($_POST) && !empty($_POST)){
    $search = explode(" ", $_POST['b']);
    $producto = "";
    foreach($search AS $s){
      $producto .= "concat(producto,' ',marca) LIKE '%".mysqli_real_escape_string($con,$s)."%' AND ";
    }
    $producto = substr($producto, 0, -4);
    $query = "SELECT * FROM producto WHERE $producto AND activo!='NO' ORDER BY producto,marca LIMIT 12";
    $result=mysqli_query($con,$query);
    ?>
    <?php
    while($row=mysqli_fetch_assoc($result)){
    ?>
    <div class="w3-row">
        <div class="w3-col" style="width:40px"><img src='https://raw.githubusercontent.com/paolomelgar/ferreboom/master/huanuco/producto/a5.jpg?' width='100%' class='img'></div>
        <div class='w3-rest' style='margin-top:10px'>
            <div class='w3-half'>ABRAZADERA SIN FIN 5/8"</div>
            <div class='w3-half'>
                <div class="w3-col" style="width:25%">NACIONAL</div>
                <div class="w3-col w3-right-align" style="width:25%" contenteditable='true'>1</div>
                <div class="w3-col w3-right-align" style="width:25%" contenteditable='true'>0.20</div>
                <div class="w3-col w3-right-align" style="width:25%">0.20</div>
            </div>
        </div>
    </div>
      <tr class="tr" bgcolor='white' style='font-weight:bold;'>
        <td style='padding:0px;' title='s'><?php echo '<img src="https://raw.githubusercontent.com/paolomelgar/ferreboom/master/huanuco/producto/a'.$row['id'].'.jpg?timestamp=23124" width="100%" height="100%">'; ?></td>
        <td style='display:none;'><?php echo $row['id']; ?></td>
        <td><?php echo $row['producto']; ?></td>
        <td><?php echo $row['marca']; ?></td>
        <td style='display:none'><?php echo $row['p_compra']; ?></td>
        <td style='text-align:right'><?php echo $row['cant_caja']; ?></td>
        <td style='color:red;text-align:right'><?php echo $row['stock_real']; ?></td>
        <td style='text-align:right;background-color:#f63'><?php echo $row['p_promotor']; ?></td>
      </tr>
    <?php
    }
  }
?>