<?php
  require_once('../connection.php');
  $hoy=date("Y-m-d");
  $aa="";
  $bb="001";
  if($_SESSION['mysql']=="innovaelectric"){
    $aa="20601765741";
  }else if($_SESSION['mysql']=="innovaprincipal"){
    $aa="20487211410";
  }else if($_SESSION['mysql']=="innovahuanuco"){
    $aa="20601765741";
    $bb="002";
  }else if($_SESSION['mysql']=="prolongacionhuanuco"){
    $aa="10433690058";
  }
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
      unlink("C:/Users/FERREBOOM/Dropbox/".$aa."/".$aa."-01-B".$bb."-".$_POST['serie'].".CAB");
      unlink("C:/Users/FERREBOOM/Dropbox/".$aa."/".$aa."-01-B".$bb."-".$_POST['serie'].".DET");
      unlink("C:/Users/FERREBOOM/Dropbox/".$aa."/".$aa."-01-B".$bb."-".$_POST['serie'].".TRI");
      unlink("C:/Users/FERREBOOM/Dropbox/".$aa."/".$aa."-01-B".$bb."-".$_POST['serie'].".LEY");
    }
    elseif($_POST['com']=='FACTURA'){
      $del = mysqli_query($con,"SELECT id,cantidad,entregado FROM factura WHERE seriefactura='".$_POST['serie']."'"); 
      while($row = mysqli_fetch_assoc($del)){
        $ins=mysqli_query($con,"UPDATE producto SET stock_con=(stock_con+".$row['cantidad'].") WHERE id='".$row['id']."'");
      }
      $sql12=mysqli_query($con,"UPDATE factura SET entregado='ANULADO' WHERE seriefactura='".$_POST['serie']."'");
      unlink("C:/Users/FERREBOOM/Dropbox/".$aa."/".$aa."-01-F".$bb."-".$_POST['serie'].".CAB");
      unlink("C:/Users/FERREBOOM/Dropbox/".$aa."/".$aa."-01-F".$bb."-".$_POST['serie'].".DET");
      unlink("C:/Users/FERREBOOM/Dropbox/".$aa."/".$aa."-01-F".$bb."-".$_POST['serie'].".TRI");
      unlink("C:/Users/FERREBOOM/Dropbox/".$aa."/".$aa."-01-F".$bb."-".$_POST['serie'].".LEY");
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