<?php
require('../fpdf/fpdf.php');
set_time_limit(60);
require_once('../connection.php');
class PDF extends FPDF
{
   function Header()
    {
      	$this->Image('../producto/logo.jpg',10,2,40);
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
$sls=mysqli_query($con,"SELECT * FROM producto WHERE foto!='NO' AND activo='OFERTA' ORDER BY producto");
while($s=mysqli_fetch_assoc($sls)){
	$pdf->SetFont('Arial','',13);
	$pdf->SetFillColor(255,255,255);
	$pdf->SetTextColor(0,0,0);
	$arr=utf8_decode(substr($s['producto'],0,32));
	$pdf->Cell(90,10,$arr,20,'','C',true);
	$pdf->Ln();
	$pdf->Cell(90,10,$s['marca'],20,'','C',true);
	$pdf->Ln(30);
	$pdf->SetFont('Arial','B',50);
	$pdf->Image('oferta.jpg', $pdf->GetX()+15, $pdf->GetY()-20,70,14);
	$pdf->Cell(90,7,"S/. ".$s['p_especial'],20,'','C',true);
	$pdf->Ln(10);
	$pdf->SetFont('Arial','B',20);
	$pdf->Cell(90,7,"S/. ".$s['p_promotor'],20,'','C',true);
	$pdf->SetDrawColor(255,0,0);
	$pdf->Line(40, 259, 70, 259);
	$pdf->Line(40, 167, 70, 167);
	$pdf->Line(40, 75, 70, 75);
	$pdf->Ln(12);
	$pdf->SetFont('Arial','B',25);
	$pdf->Cell(90,7,"CANT MIN: ".$s['cant_caja'],20,'','C',true);
	$pdf->Image('../fotos/producto/a'.$s['id'].'.jpg', $pdf->GetX()+10, $pdf->GetY()-55,75,75);
	$n++;
	$pdf->Ln(30);
	
}
$pdf->AliasNbPages();
$pdf->SetDrawColor(0,0,0);
$ar=array();
$prod=array();
$stock=array();
$query=mysqli_query($con,"SELECT * FROM familia ORDER BY id");
while($r=mysqli_fetch_assoc($query)){
	$pdf->SetFont('Arial','B',35);
	$pdf->SetTextColor(0,80,180);
	$pdf->AddPage();
	$pdf->Cell(210,297,$pdf->Image('../fotos/familia/a'.$r['id'].'.jpg', 0, 0,210,297),'','','C');
	//$pdf->AddPage();
	$pdf->Cell(0,0," ",'','','C');
	$pdf->Ln(0);
	$i=0;
	$m=0;
	$sql=mysqli_query($con,"SELECT * FROM producto WHERE familia='".$r['familia']."' AND foto!='NO' AND activo!='NO' AND activo!='ANULADO' ORDER BY producto");
	while($row=mysqli_fetch_assoc($sql)){
		$pdf->SetFont('Arial','B',8);
		$pdf->SetTextColor(0,0,0);
		$pdf->SetFillColor(255,255,0);
		$ar[$i]=utf8_decode(substr($row['producto'],0,30));
		$marca[$i]=$row['marca'];
		$prod[$i]="S/ ".$row['p_promotor'];
		$stock[$i]=$row['stock_real'];
		$nuevo[$i]=$row['fecha'];
		$r=$pdf->GetX();
		$pdf->SetX($r+8);
		$pdf->Cell(54,54,$pdf->Image('../fotos/producto/a'.$row['id'].'.jpg', $pdf->GetX()+2, $pdf->GetY()+2,54,54),'','','C');
		$i++;
		$m++;
		if($i>2){
			$pdf->Ln();
			for($j=0;$j<3;$j++){
				$sq=mysqli_query($con,"SELECT id FROM marca WHERE marca='".$marca[$j]."' AND foto='SI'");
				$row1 = mysqli_fetch_row($sq);
				$pdf->SetFillColor(255,255,255);
				$pdf->SetFont('Arial','B',8);
				$x = $pdf->GetX();
				$y = $pdf->GetY();
				$pdf->SetXY($x+4,$y+2);
				$pdf->SetTextColor(0,0,0);
				$pdf->MultiCell(37,3,$ar[$j],'','C',true);
				$pdf->SetXY($x+5,$y+2);
				if(mysqli_num_rows($sq)>0){
					$pdf->Cell(25,5,$pdf->Image('../fotos/marca/a'.$row1[0].'.jpg', $pdf->GetX()+35, $pdf->GetY(),25,5),'','','C');
				}else{
					$pdf->SetFont('Arial','B',13);
					$pdf->SetXY($x+40,$y+2);
					$pdf->Cell(25,5,$marca[$j],'','','C',true);
				}
				$pdf->SetXY($x + 40, $y-55);
				$pdf->SetFont('Arial','B',17);
				$pdf->SetFillColor(255,255,0);
				$pdf->Cell(26,10,$prod[$j],'','','C',true);
				if($stock[$j]<=0){
					$pdf->Cell(49,35,$pdf->Image('../ventasfuera/agotado.png', $pdf->GetX()-54, $pdf->GetY()+10,49,35),'','','C');
				}else{
					if(strtotime(date("Y-m-d"))-strtotime($nuevo[$j])<30*24*60*60){
						$pdf->Cell(54,54,$pdf->Image('../ventasfuera/nuevo.png', $pdf->GetX()-62, $pdf->GetY(),54,54),'','','C');
					}
				}
				$pdf->SetXY($x+62, $y);
			}
			$pdf->Ln(10);
			$i=0;
		}
		if($m%12==0){
			$pdf->Line(17, 85, 210-15, 85);
			$pdf->Line(17, 149, 210-17, 149);
			$pdf->Line(17, 213, 210-17, 213);
			$pdf->Line(76, 20, 76, 280);
			$pdf->Line(138, 20, 138, 280);
			if((mysqli_num_rows($sql)-$m)>12){
				$pdf->AddPage();
			}else if((mysqli_num_rows($sql)-$m)>9 && (mysqli_num_rows($sql)-$m)<=12){
				$pdf->AddPage();
				$pdf->Line(17, 85, 210-15, 85);
				$pdf->Line(17, 149, 210-17, 149);
				$pdf->Line(17, 213, 210-17, 213);
				$pdf->Line(76, 20, 76, 280);
				$pdf->Line(138, 20, 138, 280);
			}else if((mysqli_num_rows($sql)-$m)>6 && (mysqli_num_rows($sql)-$m)<=9){
				$pdf->AddPage();
				$pdf->Line(17, 85, 210-15, 85);
				$pdf->Line(17, 149, 210-17, 149);
				$pdf->Line(76, 20, 76, 213);
				$pdf->Line(138, 20, 138, 213);
			}else if((mysqli_num_rows($sql)-$m)>3 && (mysqli_num_rows($sql)-$m)<=6){
				$pdf->AddPage();
				$pdf->Line(17, 85, 210-15, 85);
				$pdf->Line(76, 20, 76, 150);
				$pdf->Line(138, 20, 138, 150);
			}else if((mysqli_num_rows($sql)-$m)>0 && (mysqli_num_rows($sql)-$m)<=3){
				$pdf->AddPage();
				$pdf->Line(76, 20, 76, 85);
				$pdf->Line(138, 20, 138, 85);
			}
		}
	}
	$pdf->Ln();
	for($j=0;$j<$i;$j++){
		$pdf->SetFillColor(255,255,255);
		$pdf->SetFont('Arial','B',8);
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->SetX($x+8);
		$pdf->SetTextColor(0,0,0);
		$pdf->MultiCell(54,4,$ar[$j],'','','C',true);
		$pdf->SetXY($x + 40, $y-55);
		$pdf->SetFont('Arial','B',17);
		$pdf->SetFillColor(255,255,0);
		$pdf->Cell(26,10,$prod[$j],'','','C',true);
		if($stock[$j]<=0){
			$pdf->Cell(49,35,$pdf->Image('../ventasfuera/agotado.png', $pdf->GetX()-54, $pdf->GetY()+10,49,35),'','','C');
		}
		$pdf->SetXY($x+62, $y);
	}
}
$pdf->Output('Catalogo.pdf','I');
?>