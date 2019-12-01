<?php 
  require_once('../connection.php');
  if(isset($_POST) && !empty($_POST)){
    $q=$_POST['value'];
    $sql1=mysqli_query($con,"SELECT * FROM adelantosletra WHERE value='$q' ORDER BY id");
    ?><table width="100%" cellpadding="0" cellspacing="0" border="1" align="center"><?php
    if (mysqli_num_rows($sql1)>0){
    ?>
      <tr bgcolor="#428bca" style="color:#FFF; text-align:center;font-size:12px">
            <th width="10%">FECHA</th>
            <th width="10%">MONTO PAGO</th>
            <th width="10%">TIPO CAMBIO</th>
            <th width="15%">FECHA LETRA</th>
            <th width="15%">FECHA PAGO</th>
            <th width="20%">MONTO LETRA</th>
            <th width="20%">ENCARGADO</th>
        </tr>
    <?php
    while($row=mysqli_fetch_assoc($sql1)){
      ?>
      <tr class="tr" style='font-size:12px;'>
          <td width="10%" align="center"><?php echo date('d/m/Y', strtotime(str_replace('-', '/', $row['fechapago']))); ?></td>
          <td width="10%" align="right"><?php echo $row['adelanto'] ?></td>
          <td width="10%" align="center"><?php echo $row['cambio'] ?></td>
          <td width="15%" align="center"><?php echo date('d/m/Y', strtotime(str_replace('-', '/', $row['fechaletra']))); ?></td>
          <td width="15%" align="center"><?php echo date('d/m/Y', strtotime(str_replace('-', '/', $row['fechapagoletra']))); ?></td>
          <td width="20%" align="center"><?php echo $row['monto']; ?></td>
          <td width="20%" align="center"><?php echo $row['encargadocompra']; ?></td>
      </tr>
      <?php
      }
    }
    ?></table><?php
  }