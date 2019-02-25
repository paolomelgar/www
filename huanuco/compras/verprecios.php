<?php
require_once('../connection.php');
  $data=array();
  if(isset($_POST) && !empty($_POST)){
    $sql=mysqli_query($con,"SELECT * FROM producto WHERE id='".$_POST['id']."'");
    $row=mysqli_fetch_assoc($sql);
    $data[0]=$row['p_compra'];
    $data[1]=$row['fran'];
    $data[2]=$row['p_promotor'];
    $data[3]=$row['p_especial'];
    echo json_encode($data);
  }
?>
   