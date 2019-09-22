<?php
  require_once('../connection.php');
  $m=$_POST['i']*50;
	$sql=mysqli_query($con,"SELECT * FROM (SELECT * FROM chat WHERE (emisor='".$_POST['emisor']."' AND receptor='".$_POST['receptor']."') OR (emisor='".$_POST['receptor']."' AND receptor='".$_POST['emisor']."') ORDER BY fecha DESC LIMIT ".$m.",50) g ORDER BY id");
	$a=date("Y-m-d");
  $z=date("Y-m-d");
	while($row=mysqli_fetch_assoc($sql)){
    if($a!=date("Y-m-d",strtotime($row['fecha']))){
      ?> <div style='text-align:center;color:#6C6C6C;font-size:13px;margin-top:10px;margin-bottom:10px'> <?php echo date("d/m/Y",strtotime($row['fecha'])); ?> </div> <?php
    }
    $a=date("Y-m-d",strtotime($row['fecha']));
    if($row['receptor']!=$_POST['receptor']){?>
      <div style='margin-top:2px;width:200px;cursor:pointer;'><div style='border:1px solid #B1B1B1;font-size:14px;word-wrap:break-word;display:inline-block;padding: 5px 8px 4px;border-radius: 5px ;' title='<?php echo $row['fecha']; ?>'><?php echo $row['mensaje']; ?></div></div>
    <?php }else{ ?>
      <div style='text-align:right;width:200px;margin-left:50px;margin-top:2px;cursor:pointer'><div style='border:1px solid #B3CED9;font-size:14px;word-wrap:break-word;display:inline-block;background-color:#D9FDFF;padding: 5px 8px 4px;border-radius: 5px ;' title='<?php echo $row['fecha']; ?>'><?php echo $row['mensaje']; ?></div></div>
    <?php }
    $z=$row['fecha'];
  }
  if(date("Y-m-d")!=date("Y-m-d",strtotime($z))){
    ?> <div style='text-align:center;color:#6C6C6C;font-size:13px;margin-top:5px;margin-bottom:10px'> <?php echo date("d/m/Y"); ?> </div> <?php
  }
?>