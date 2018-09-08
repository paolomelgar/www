<?php
  require_once('../connection.php');
  $hoy=date("Y-m-d");
  if(isset($_POST) && !empty($_POST)){
    $sql2=mysqli_query($con,"SELECT total,entregado,credito FROM total_ventas WHERE serieventas='".$_POST['serie']."' AND documento='".$_POST['com']."'");
    $ro=mysqli_fetch_row($sql2);
    $sql1=mysqli_query($con,"UPDATE total_ventas SET entregado='ANULADO' WHERE serieventas='".$_POST['serie']."' AND documento='".$_POST['com']."'");
    if($_POST['com']=='BOLETA DE VENTA'){
      $del = mysqli_query($con,"SELECT id,cantidad,entregado FROM boleta WHERE serieboleta='".$_POST['serie']."'"); 
      while($row = mysqli_fetch_assoc($del)){
        if($row['entregado']=='SI'){
          $ins=mysqli_query($con,"UPDATE producto SET stock_real=(stock_real+".$row['cantidad'].") WHERE id='".$row['id']."'");
        }
      }
      $sql12=mysqli_query($con,"UPDATE boleta SET entregado='ANULADO' WHERE serieboleta='".$_POST['serie']."'");
      if($ro[1]=='SI'){
        $inser=mysqli_query($con,"UPDATE dinerodiario SET boleta=(boleta-".$ro[0].") WHERE fecha='$hoy'");
      }
    }
    elseif($_POST['com']=='FACTURA'){
      $del = mysqli_query($con,"SELECT id,cantidad,entregado FROM facturapaola WHERE seriefactura='".$_POST['serie']."'"); 
      while($row = mysqli_fetch_assoc($del)){
        $ins=mysqli_query($con,"UPDATE producto SET stock_con=(stock_con+".$row['cantidad'].") WHERE id='".$row['id']."'");
      }
      $sql12=mysqli_query($con,"UPDATE facturapaola SET entregado='ANULADO' WHERE seriefactura='".$_POST['serie']."'");
    }
    elseif($_POST['com']=='PROFORMA'){
      $del = mysqli_query($con,"SELECT id,cantidad,entregado FROM proforma WHERE serieproforma='".$_POST['serie']."'"); 
      while($row = mysqli_fetch_assoc($del)){
        if($row['entregado']=='SI'){
          $ins=mysqli_query($con,"UPDATE producto SET stock_real=(stock_real+".$row['cantidad'].") WHERE id='".$row['id']."'");
        }
      }
      $sql12=mysqli_query($con,"UPDATE proforma SET entregado='ANULADO' WHERE serieproforma='".$_POST['serie']."'");
      if($ro[1]=='SI'){
        $inser=mysqli_query($con,"UPDATE dinerodiario SET proforma=(proforma-".$ro[0].") WHERE fecha='$hoy'");
      }
    }
    elseif($_POST['com']=='NOTA DE PEDIDO'){
      $del = mysqli_query($con,"SELECT id,cantidad FROM notapedido WHERE serienota='".$_POST['serie']."'"); 
      while($row = mysqli_fetch_assoc($del)){
        $ins=mysqli_query($con,"UPDATE producto SET stock_real=(stock_real+".$row['cantidad'].") WHERE id='".$row['id']."'");
      }
      $del1 = mysqli_query($con,"SELECT id,cantidad,estado FROM devoluciones WHERE seriedevolucion='".$_POST['serie']."'"); 
      while($row1 = mysqli_fetch_assoc($del1)){
        if($row1['estado']=='BUENO'){
          $ins1=mysqli_query($con,"UPDATE producto SET stock_real=(stock_real-".$row1['cantidad'].") WHERE id='".$row1['id']."'");
        }
      }
      $sql12=mysqli_query($con,"UPDATE notapedido SET entregado='ANULADO' WHERE serienota='".$_POST['serie']."'");
      $sql13=mysqli_query($con,"UPDATE devoluciones SET entregado='ANULADO' WHERE seriedevolucion='".$_POST['serie']."'");
      if($ro[2]=='CONTADO'){
        $inser=mysqli_query($con,"UPDATE dinerodiario SET nota=(nota-".$ro[0].") WHERE fecha='$hoy'");
      }
    }
  }
?>