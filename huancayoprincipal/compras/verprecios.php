<?php
require_once('../connection.php');
  $data=array();
  if(isset($_POST) && !empty($_POST)){
    $sql=mysqli_query($con,"SELECT * FROM producto WHERE id='".$_POST['id']."'");
    $row=mysqli_fetch_row($sql);
    $data[0]=$row[5];
    $data[1]=$row[6];
    $data[2]=$row[7];
    $data[3]=$row[8];
    $data[4]=$row[9];
    echo json_encode($data);
  }
?>
   