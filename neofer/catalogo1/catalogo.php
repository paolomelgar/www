<?php
require('../fpdf/fpdf.php');
set_time_limit(60);
require_once('../connection.php');
class PDF extends FPDF
{
   function Header()
    {
      	$this->Image('C:/wamp/www/huanuco/logo_ferreboom.png',10,2,40);
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
$n=0;
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
	$pdf->Cell(210,297,$pdf->Image('C:/wamp/www/huanuco/fotos/familia/a'.$r['id'].'.jpg', 0, 0,210,297),'','','C');
	$pdf->AddPage();
	$pdf->Cell(0,0," ",'','','C');
	$pdf->Ln(0);
	$i=0;
	$m=0;
	$sql=mysqli_query($con,"SELECT * FROM producto WHERE familia='".$r['familia']."' AND foto='SI' AND activo!='NO' ORDER BY producto");
	while($row=mysqli_fetch_assoc($sql)){
		$pdf->SetFont('Arial','B',8);
		$pdf->SetTextColor(0,0,0);
		$pdf->SetFillColor(255,255,0);
		$ar[$i]=utf8_decode(substr($row['producto'],0,30));
		$marca[$i]=$row['marca'];
		$prod[$i]="S/ ".$row['p_promotor'];
		$stock[$i]=$row['stock_real'];
		$r=$pdf->GetX();
		$pdf->SetX($r+8);
		$pdf->Cell(54,54,$pdf->Image('C:/wamp/www/huanuco/fotos/producto/a'.$row['id'].'.jpg', $pdf->GetX()+2, $pdf->GetY()+2,54,54),'','','C');
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
					$pdf->Cell(25,5,$pdf->Image('C:/wamp/www/huanuco/fotos/marca/a'.$row1[0].'.jpg', $pdf->GetX()+35, $pdf->GetY(),25,5),'','','C');
				}else{
					$pdf->SetFont('Arial','B',13);
					$pdf->SetXY($x+40,$y+2);
					$pdf->Cell(25,5,$marca[$j],'','','C',true);
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
		//$pdf->Cell(26,10,$prod[$j],'','','C',true);
		$pdf->SetXY($x+62, $y);
	}
}
$pdf->Output('Catalogo.pdf','I');
?>