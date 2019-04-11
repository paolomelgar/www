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
$pdf->SetXY($pdf->GetX()+25,$pdf->GetY());
$pdf->SetFont('Arial','',9);
$pdf->Cell(100,5,"RUC: ".$row1[0],'','','L',true);
$pdf->Cell(60,5,"Fecha: ".$row1[3],'','','L',true);
$pdf->Ln();
$pdf->SetXY($pdf->GetX()+25,$pdf->GetY());
$pdf->Cell(100,5,"CLIENTE: ".$row1[1],'','','L',true);
$pdf->Cell(60,5,"Vendedor: ".$row1[4],'','','L',true);
$pdf->Ln();
$pdf->SetXY($pdf->GetX()+25,$pdf->GetY());
$pdf->MultiCell(145,5,"DIRECCION: ".$row1[2],'','','L',true);
$pdf->Ln();
$pdf->SetXY($pdf->GetX()+25,$pdf->GetY()-4);
$pdf->SetFont('Arial','B',10);
//$pdf->Cell(12,6,"IMG",1,'','C');
$pdf->Cell(12,6,"CAN",1,'','C',true);
$pdf->Cell(92,6,"PRODUCTO",1,'','C',true);
$pdf->Cell(15,6,"UNID",1,'','C',true);
$pdf->Cell(20,6,"IMPORTE",1,'','C',true);
$pdf->Ln();
$pdf->SetFont('Arial','',9);
$sql=mysqli_query($con,"SELECT * FROM notapedido WHERE serienota='".$_GET['id']."' ORDER BY idnota");
while($row=mysqli_fetch_assoc($sql)){
	$pdf->SetXY($pdf->GetX()+25,$pdf->GetY());
	//$pdf->Cell(12,12,$pdf->Image('../fotos/producto/a'.$row['codigo'].'.jpg', $pdf->GetX(), $pdf->GetY(),12,12),'','','C');
	$pdf->Cell(12,6,$row["cantidad"],'','','R',true);
	$pdf->Cell(92,6,utf8_decode($row["producto"]),'','','L',true);
	$pdf->Cell(15,6,$row["unitario"],'','','R',true);
	$pdf->Cell(20,6,$row["importe"],'','','R',true);
	$pdf->Ln();
}
$sql2=mysqli_query($con,"SELECT * FROM devoluciones WHERE seriedevolucion='".$_GET['id']."' ORDER BY iddevolucion");
if(mysqli_num_rows($sql2)>0){
	$pdf->Cell(164,6,"SUBTOTAL      S/ ".$row1[5],'','','R',true);
	$pdf->Ln();
	$pdf->Line(25,$pdf->GetY()-3,185,$pdf->GetY()-3);
	while($row2=mysqli_fetch_assoc($sql2)){
		$pdf->SetXY($pdf->GetX()+25,$pdf->GetY());
		//$pdf->Cell(12,12,$pdf->Image('../fotos/producto/a'.$row2['codigo'].'.jpg', $pdf->GetX(), $pdf->GetY(),12,12),'','','C');
		$pdf->Cell(12,6,$row2["cantidad"],'','','R',true);
		$pdf->Cell(92,6,utf8_decode($row2["producto"]),'','','L',true);
		$pdf->Cell(15,6,$row2["unitario"],'','','R',true);
		$pdf->Cell(20,6,$row2["importe"],'','','R',true);
		$pdf->Ln();
	}
	$pdf->Cell(164,6,"DEVOLUCION      S/ ".$row1[6],'','','R',true);
	$pdf->Ln();
}
$pdf->Cell(164,6," TOTAL      S/ ".$row1[7],'','','R',true);
$pdf->Output('Ferreboom.pdf','I');
?>