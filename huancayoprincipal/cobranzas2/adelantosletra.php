<?php 
  require_once('../connection.php');
  if(isset($_POST) && !empty($_POST)){
    $q=$_POST['serie'];
    $sql1=mysqli_query($con,"SELECT * FROM cobroletras WHERE value='$q' ORDER BY id");
    ?><table width="100%" cellpadding="0" cellspacing="0" border="1" align="center"><?php
    if (mysqli_num_rows($sql1)>0){
    ?>
      <tr bgcolor="#428bca" style="color:#FFF; text-align:center;font-size:12px">
            <th width="20%">FECHA PAGO</th>
            <th width="20%">MONTO PAGO</th>
            <th width="20%">FECHA LETRA</th>
            <th width="20%">MONTO LETRA</th>
        </tr>
    <?php
    while($row=mysqli_fetch_assoc($sql1)){
      ?>
      <tr class="tr" style='font-size:12px;'>
          <td width="20%" align="center"><?php echo date('d/m/Y', strtotime(str_replace('-', '/', $row['fechapago']))); ?></td>
          <td width="20%" align="right"><?php echo $row['adelanto'] ?></td>
          <td width="20%" align="center"><?php echo date('d/m/Y', strtotime(str_replace('-', '/', $row['fechaletra']))); ?></td>
          <td width="20%" align="center"><?php echo $row['monto']; ?></td>
      </tr>
      <?php
      }
    }
    ?></table><div style='margin-top:10px;text-align:center'><a id='imprimir' style='cursor:pointer'><img src='../caja/print.png'></a></div><?php
  }