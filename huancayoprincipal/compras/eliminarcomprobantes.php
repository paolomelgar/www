<?php
require_once('../connection.php');
  date_default_timezone_set("America/Lima");
  $hoy=date("Y-m-d");
  if(isset($_POST) && !empty($_POST)){
    $sql10=mysqli_query($con,"SELECT montototal,entregado,credito FROM total_compras WHERE value='".$_POST['value']."'");
    $ro=mysqli_fetch_row($sql10);
    if($ro[1]=='SI' && $ro[2]=='CONTADO'){
      $p=round($ro[0],1);
      $inser=mysqli_query($con,"UPDATE cajamayor SET contados=(contados-$p) WHERE fecha='$hoy'");
    }
    $sql1=mysqli_query($con,"UPDATE total_compras SET entregado='ANULADO' WHERE value='".$_POST['value']."'");
    $del = mysqli_query($con,"SELECT idproducto,cantidad,entregado FROM compras WHERE value='".$_POST['value']."'"); 
    while($row = mysqli_fetch_assoc($del)){
      if($row['entregado']=='SI'){
        if($_POST['doc']=='FACTURA PAUL'){
            $ins=mysqli_query($con,"UPDATE producto SET stock_real=(stock_real-".$row['cantidad']."),stock_con=(stock_con-".$row['cantidad'].") WHERE id='".$row['idproducto']."'");
        }else if($_POST['doc']=='FACTURA BOOM'){
            $ins=mysqli_query($con,"UPDATE producto SET stock_real=(stock_real-".$row['cantidad']."),stock_con1=(stock_con1-".$row['cantidad'].") WHERE id='".$row['idproducto']."'");
        }else{
            $ins=mysqli_query($con,"UPDATE producto SET stock_real=(stock_real-".$row['cantidad'].") WHERE id='".$row['idproducto']."'");
        }
      }
      else{
        if($_POST['doc']=='FACTURA PAUL'){
            $ins=mysqli_query($con,"UPDATE producto SET stock_con=(stock_con-".$row['cantidad'].") WHERE id='".$row['idproducto']."'");
        }else if($_POST['doc']=='FACTURA BOOM'){
            $ins=mysqli_query($con,"UPDATE producto SET stock_con1=(stock_con1-".$row['cantidad'].") WHERE id='".$row['idproducto']."'");
        }
      }
    }
    $sql2=mysqli_query($con,"UPDATE compras SET entregado='ANULADO' WHERE value='".$_POST['value']."'");
  }
?>