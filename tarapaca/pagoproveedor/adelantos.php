<?php 
require_once('../connection.php');
  if(isset($_POST) && !empty($_POST)){
    $q=$_POST['value'];
    $sql1=mysqli_query($con,"SELECT * FROM adelantoscompras WHERE value='$q' ORDER BY id");
    ?><table width="100%" cellpadding="0" cellspacing="0" border="1" align="center"><?php
    if (mysqli_num_rows($sql1)>0){
    ?>
      <tr bgcolor="#428bca" style="color:#FFF; text-align:center;font-size:12px">
            <th width="20%">FECHA</th>
            <th width="20%">MONTO</th>
            <th width="20%">FORMA-PAGO</th>
            <th width="20%">BANCO</th>
            <th width="20%">N° OP.</th>
        </tr>
    <?php
    while($row=mysqli_fetch_assoc($sql1)){
      ?>
      <tr class="tr" style='font-size:12px;'>
          <td width="20%" align="center"><?php echo date('d/m/Y', strtotime(str_replace('-', '/', $row['fecha']))); ?></td>
          <td width="20%" align="right"><?php echo $row['adelanto'] ?></td>
          <td width="20%" align="center"><?php echo $row['forma'] ?></td>
          <td width="20%" align="center"><?php echo $row['banco']; ?></td>
          <td width="20%" align="center"><?php echo $row['nro']; ?></td>
      </tr>
      <?php
      }
    }
    ?></table><?php
  }