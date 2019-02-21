<?php
  require_once('../connection.php');
  $hoy=date("Y-m-d");
  if(isset($_POST) && !empty($_POST)){
    $sql2=mysqli_query($con,"SELECT total,entregado,credito FROM total_ventas WHERE serieventas='".$_POST['serie']."' AND documento='".$_POST['com']."'");
    $ro=mysqli_fetch_row($sql2);
    $sql1=mysqli_query($con,"UPDATE total_ventas SET entregado='ANULADO' WHERE serieventas='".$_POST['serie']."' AND documento='".$_POST['com']."'");
    if($_POST['com']=='FACTURA PAUL'){
      $del = mysqli_query($con,"SELECT id,cantidad,entregado FROM facturapaul WHERE seriefactura='".$_POST['serie']."'"); 
      while($row = mysqli_fetch_assoc($del)){
        $ins=mysqli_query($con,"UPDATE producto SET stock_con=(stock_con+".$row['cantidad'].") WHERE id='".$row['id']."'");
      }
      $sql12=mysqli_query($con,"UPDATE facturapaola SET entregado='ANULADO' WHERE seriefactura='".$_POST['serie']."'");
      unlink("C:/Users/FERREBOOM/Dropbox/10433690058/10433690058-01-F001-".$_POST['serie'].".CAB");
      unlink("C:/Users/FERREBOOM/Dropbox/10433690058/10433690058-01-F001-".$_POST['serie'].".DET");
      unlink("C:/Users/FERREBOOM/Dropbox/10433690058/10433690058-01-F001-".$_POST['serie'].".TRI");
      unlink("C:/Users/FERREBOOM/Dropbox/10433690058/10433690058-01-F001-".$_POST['serie'].".LEY");
    }
    elseif($_POST['com']=='FACTURA BOOM'){
      $del = mysqli_query($con,"SELECT id,cantidad,entregado FROM facturaboom WHERE seriefactura='".$_POST['serie']."'"); 
      while($row = mysqli_fetch_assoc($del)){
        $ins=mysqli_query($con,"UPDATE producto SET stock_con1=(stock_con1+".$row['cantidad'].") WHERE id='".$row['id']."'");
      }
      $sql12=mysqli_query($con,"UPDATE facturaboom SET entregado='ANULADO' WHERE seriefactura='".$_POST['serie']."'");
      unlink("C:/Users/FERREBOOM/Dropbox/20600996968/20600996968-01-F001-".$_POST['serie'].".CAB");
      unlink("C:/Users/FERREBOOM/Dropbox/20600996968/20600996968-01-F001-".$_POST['serie'].".DET");
      unlink("C:/Users/FERREBOOM/Dropbox/20600996968/20600996968-01-F001-".$_POST['serie'].".TRI");
      unlink("C:/Users/FERREBOOM/Dropbox/20600996968/20600996968-01-F001-".$_POST['serie'].".LEY");
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
    }
  }
?>