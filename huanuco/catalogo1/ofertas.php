<?php
require('../fpdf/fpdf.php');
set_time_limit(60);
require_once('../connection.php');
class PDF extends FPDF
{
   function Header()
    {
      	$this->Image('../logo_ferreboom.png',10,2,40);
      	$this->SetFont('Arial','B',25);
      	$this->SetDrawColor(0,80,180);
      	$this->Line(10,18,200,18);
      	$this->SetTextColor(0,80,180);
      	$this->Cell(200,2,'LISTA DE PRODUCTOS',0,0,'C');
      	$this->Ln(12);
    }
   function Footer()
	{
		$this->SetY(-15);
		$this->SetFont('Arial','I',8);
		$this->SetTextColor(0,80,180);
		$this->Cell(0,10,utf8_decode('JR. HUANUCO N° 959 - HUANUCO'),0,0,'C');
		$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'R');
    }
}
$pdf = new PDF();
$pdf->SetTitle('CATALOGO');
$pdf->AddPage();
$n=0;
$sls=mysqli_query($con,"SELECT * FROM producto WHERE foto!='NO' AND porcentaje>0 ORDER BY producto");
while($s=mysqli_fetch_assoc($sls)){
	$pdf->SetFont('Arial','B',14);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetTextColor(0,80,180);
	$arr=utf8_decode(substr($s['producto'],0,32));
	$pdf->Cell(90,10,$arr,20,'','C',true);
	$pdf->Ln();
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','B',25);
	$pdf->Cell(90,10,$s['marca'],20,'','C',true);
	$pdf->Ln(30);
	$pdf->SetFont('Arial','B',55);
	$pdf->Image('oferta.jpg', $pdf->GetX()+15, $pdf->GetY()-15,70,14);
	$pdf->Ln(6);
	$pdf->Cell(90,7,"S/ ".$s['porcentaje'],20,'','C',true);
	$pdf->Ln(12);
	$pdf->SetFont('Arial','B',20);
	$pdf->Cell(90,7,"S/ ".$s['p_promotor'],22,'','C',true);
	$pdf->SetDrawColor(255,0,0);
	$pdf->Line(40, 265, 70, 265);
	$pdf->Line(40, 174, 70, 174);
	$pdf->Line(40, 83, 70, 83);
	$pdf->Ln(9);
	$pdf->SetFont('Arial','B',22);
	$pdf->Cell(90,7,"Caja: ".$s["cant_caja"],20,'','C',true);
	$pdf->Image('../fotos/producto/a'.$s['codigo'].'.jpg', $pdf->GetX()+10, $pdf->GetY()-60,75,75);
	$n++;
	$pdf->Ln(23);
	
}
$pdf->Output('Catalogo.pdf','I');
?>