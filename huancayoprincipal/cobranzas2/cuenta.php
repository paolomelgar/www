<?php
require('../fpdf/fpdf.php');
require_once('../connection.php');
class PDF extends FPDF{}
$pdf = new PDF();
$pdf->AddPage();
$sq=mysqli_query($con,"SELECT ruc,cliente,direccion FROM total_ventas WHERE documento='NOTA DE PEDIDO' AND ruc='".$_GET['ruc']."' AND credito='CREDITO' AND entregado='SI'");
$sql=mysqli_query($con,"SELECT serieventas,vendedor,total,pendiente,acuenta,fecha FROM total_ventas WHERE documento='NOTA DE PEDIDO' AND ruc='".$_GET['ruc']."' AND credito='CREDITO' AND entregado='SI'");
$row1 = mysqli_fetch_row($sq);
$pdf->SetFillColor(255,255,255);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','B',13);
$pdf->Cell(190,8,"ESTADO DE CUENTA",'','','C',true);
$pdf->Ln();
$pdf->SetXY($pdf->GetX()+10,$pdf->GetY());
$pdf->SetFont('Arial','',9);
$pdf->Cell(100,5,"RUC: ".$row1[0],'','','L',true);
$pdf->Ln();
$pdf->SetXY($pdf->GetX()+10,$pdf->GetY());
$pdf->Cell(100,5,"CLIENTE: ".$row1[1],'','','L',true);
$pdf->Ln();
$pdf->SetXY($pdf->GetX()+10,$pdf->GetY());
$pdf->MultiCell(145,5,"DIRECCION: ".$row1[2],'','','L',true);
$pdf->Ln();
$pdf->SetXY($pdf->GetX()+10,$pdf->GetY()-4);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(20,6,"SERIE",1,'','C');
$pdf->Cell(40,6,"VENDEDOR",1,'','C',true);
$pdf->Cell(20,6,"TOTAL",1,'','C',true);
$pdf->Cell(20,6,"PENDIENTE",1,'','C',true);
$pdf->Cell(20,6,"ACUENTA",1,'','C',true);
$pdf->Cell(30,6,"FECHA",1,'','C',true);
$pdf->Cell(15,6,"DIAS",1,'','C',true);
$pdf->Ln();
$pdf->SetFont('Arial','',9);
$a=0;$b=0;$c=0;
while($row=mysqli_fetch_assoc($sql)){
	$dif=intval((strtotime(date("Y-m-d"))-strtotime($row['fecha']))/60/60/24);
	$pdf->SetXY($pdf->GetX()+10,$pdf->GetY());
	$pdf->Cell(20,6,$row["serieventas"],1,'','C',true);
	$pdf->Cell(40,6,$row["vendedor"],1,'','C',true);
	$pdf->Cell(20,6,$row["total"],1,'','R',true);
	$pdf->Cell(20,6,$row["pendiente"],1,'','R',true);
	$pdf->Cell(20,6,$row["acuenta"],1,'','R',true);
	$pdf->Cell(30,6,$row["fecha"],1,'','C',true);
	$pdf->Cell(15,6,$dif,1,'','C',true);
	$a=$a+$row["total"];
	$b=$b+$row["pendiente"];
	$c=$c+$row["acuenta"];
	$pdf->Ln();
}
$pdf->SetXY($pdf->GetX()+10,$pdf->GetY());
$pdf->Cell(60,6," TOTAL   S/ ",1,'','R',true);
$pdf->Cell(20,6,number_format($a,2,".",""),1,'','R',true);
$pdf->Cell(20,6,number_format($b,2,".",""),1,'','R',true);
$pdf->Cell(20,6,number_format($c,2,".",""),1,'','R',true);
$pdf->Cell(45,6,"",1,'','R',true);
$pdf->Output("ESTADO DE CUENTA".'.pdf','I');
?>
