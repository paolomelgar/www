<?php
require('../fpdf/fpdf.php');
require_once('../connection.php');
class PDF extends FPDF{}
$pdf = new PDF();
$pdf->AddPage();
$sq=mysqli_query($con,"SELECT ruc,cliente,direccion,fecha,vendedor,subtotal,devolucion,total FROM total_ventas WHERE documento='NOTA DE PEDIDO' AND serieventas='".$_GET['id']."'");
$row1 = mysqli_fetch_row($sq);
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','B',13);
$pdf->Cell(190,8,"NOTA DE PEDIDO",'','','C',true);
$pdf->Ln();
$pdf->SetXY($pdf->GetX()+22,$pdf->GetY());
$pdf->SetFont('Arial','',9);
$pdf->Cell(100,5,"RUC: ".$row1[0],'','','L',true);
$pdf->Cell(60,5,"Fecha: ".$row1[3],'','','L',true);
$pdf->Ln();
$pdf->SetXY($pdf->GetX()+22,$pdf->GetY());
$pdf->Cell(100,5,"CLIENTE: ".$row1[1],'','','L',true);
$pdf->Cell(60,5,"Vendedor: ".$row1[4],'','','L',true);
$pdf->Ln();
$pdf->SetXY($pdf->GetX()+22,$pdf->GetY());
$pdf->Cell(145,5,"DIRECCION: ".$row1[2],'','','L',true);
$pdf->Ln();
$pdf->SetXY($pdf->GetX()+22,$pdf->GetY());
$pdf->SetFont('Arial','B',10);
//$pdf->Cell(12,6,"IMG",1,'','C');
$pdf->Cell(12,4,"CAN",1,'','C',true);
$pdf->Cell(100,4,"PRODUCTO",1,'','C',true);
$pdf->Cell(15,4,"UNID",1,'','C',true);
$pdf->Cell(20,4,"IMPORTE",1,'','C',true);
$pdf->Ln();
$pdf->SetFont('Arial','',9);
$sql=mysqli_query($con,"SELECT * FROM notapedido WHERE serienota='".$_GET['id']."' ORDER BY idnota");
while($row=mysqli_fetch_assoc($sql)){
	$pdf->SetXY($pdf->GetX()+22,$pdf->GetY());
	//$pdf->Cell(12,12,$pdf->Image('../fotos/producto/a'.$row['id'].'.jpg', $pdf->GetX(), $pdf->GetY(),12,12),'','','C');
	$pdf->Cell(12,4,$row["cantidad"],'','','R',true);
	$pdf->Cell(100,4,utf8_decode($row["producto"]),'','','L',true);
	$pdf->Cell(15,4,$row["unitario"],'','','R',true);
	$pdf->Cell(20,4,$row["importe"],'','','R',true);
	$pdf->Ln();
}
$sql2=mysqli_query($con,"SELECT * FROM devoluciones WHERE seriedevolucion='".$_GET['id']."' ORDER BY iddevolucion");
if(mysqli_num_rows($sql2)>0){
	$pdf->Cell(169,4,"SUBTOTAL      S/ ".$row1[5],'','','R',true);
	$pdf->Ln();
	$pdf->Line(22,$pdf->GetY()-3,185,$pdf->GetY()-3);
	while($row2=mysqli_fetch_assoc($sql2)){
		$pdf->SetXY($pdf->GetX()+22,$pdf->GetY());
		//$pdf->Cell(12,12,$pdf->Image('../fotos/producto/a'.$row2['id'].'.jpg', $pdf->GetX(), $pdf->GetY(),12,12),'','','C');
		$pdf->Cell(12,4,$row2["cantidad"],'','','R',true);
		$pdf->Cell(100,4,utf8_decode($row2["producto"]),'','','L',true);
		$pdf->Cell(15,4,$row2["unitario"],'','','R',true);
		$pdf->Cell(20,4,$row2["importe"],'','','R',true);
		$pdf->Ln();
	}
	$pdf->Cell(169,4,"DEVOLUCION      S/ ".$row1[6],'','','R',true);
	$pdf->Ln();
}
$pdf->Cell(169,4," TOTAL      S/ ".$row1[7],'','','R',true);
$pdf->Output($row1[1].' '.$row1[3].'.pdf','I');
?>