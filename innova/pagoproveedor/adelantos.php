<?php 
  require_once('../connection.php');
  if(isset($_POST) && !empty($_POST)){
    $q=$_POST['value'];
    $sql1=mysqli_query($con,"SELECT * FROM adelantoscompras WHERE value='$q' ORDER BY id");
    ?><table width="100%" cellpadding="0" cellspacing="0" border="1" align="center"><?php
    if (mysqli_num_rows($sql1)>0){
    ?>
      <tr bgcolor="#428bca" style="color:#FFF; text-align:center;font-size:12px">
            <th width="10%">FECHA</th>
            <th width="10%">MONTO</th>
            <th width="10%">FECHA PAGO</th>
            <th width="10%">FORMA PAGO</th>
            <th width="10%">MEDIO PAGO</th>
            <th width="15%">BANCO</th>
            <th width="15%">N° OP.</th>
            <th width="20%">ENCARGADO</th>
        </tr>
    <?php
    while($row=mysqli_fetch_assoc($sql1)){
      ?>
      <tr class="tr" style='font-size:12px;'>
          <td width="10%" align="center"><?php echo date('d/m/Y', strtotime(str_replace('-', '/', $row['fecha']))); ?></td>
          <td width="10%" align="right"><?php echo $row['adelanto'] ?></td>
          <td width="10%" align="center"><?php echo date('d/m/Y', strtotime(str_replace('-', '/', $row['fechapago']))); ?></td>
          <td width="10%" align="center"><?php echo $row['forma'] ?></td>
          <td width="10%" align="center"><?php echo $row['mediopago'] ?></td>
          <td width="15%" align="center"><?php echo $row['banco']; ?></td>
          <td width="15%" align="center"><?php echo $row['nro']; ?></td>
          <td width="20%" align="center"><?php echo $row['encargadocompra']; ?></td>
      </tr>
      <?php
      }
    }
    ?></table><?php
  }