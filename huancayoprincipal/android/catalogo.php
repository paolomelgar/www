<?php
require('../fpdf/fpdf.php');
set_time_limit(60);
require_once('../connection.php');
class PDF extends FPDF
{
   function Header()
    {
      	$this->Image('C:/wamp/www/producto/logo.jpg',10,2,40);
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
$pdf->AddPage();
$n=0;
$sls=mysqli_query($con,"SELECT * FROM producto WHERE foto='SI' AND activo='OFERTA' ORDER BY producto");
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
	$pdf->Image('../catalogo/oferta.jpg', $pdf->GetX()+15, $pdf->GetY()-20,70,14);
	$pdf->Cell(90,7,"S/. ".$s['p_especial'],20,'','C',true);
	$pdf->Ln(20);
	$pdf->SetFont('Arial','B',25);
	$pdf->Cell(90,7,"CANT MIN: ".$s['cant_caja'],20,'','C',true);
	$pdf->Image('C:/wamp/www/fotos/a'.$s['id'].'.jpg', $pdf->GetX()+10, $pdf->GetY()-55,75,75);
	$n++;
	$pdf->Ln(30);
	
}
$pdf->AliasNbPages();
$image=array();
$prod=array();
$stock=array();
$query=mysqli_query($con,"SELECT * FROM familia WHERE familia!='TUBERIAS Y ACCESORIOS' ORDER BY id");
while($r=mysqli_fetch_assoc($query)){
	$pdf->SetFont('Arial','B',35);
	$pdf->SetTextColor(0,80,180);
	$pdf->AddPage();
	$pdf->Cell(190,52, $r['familia'],'',1,'C');
	$pdf->Cell(190,200,$pdf->Image('C:/wamp/www/fotos/'.$r['familia'].'.jpg', $pdf->GetX()+45, $pdf->GetY()+20,100,100),'',1,'C');
	$pdf->AddPage();
	$i=0;
	$m=0;
	$sql=mysqli_query($con,"SELECT * FROM producto WHERE familia='".$r['familia']."' AND foto='SI' AND activo='SI' ORDER BY producto");
	while($row=mysqli_fetch_assoc($sql)){
		$pdf->SetFont('Arial','B',9);
		$pdf->SetTextColor(0,0,0);
		$pdf->SetFillColor(255,255,0);
		$ar[$i]=utf8_decode(substr($row['producto']." ".$row['marca'],0,35));
		$prod[$i]="Caja: ".$row['cant_caja'];
		$stock[$i]=$row['stock_real'];
		$r=$pdf->GetX();
		$pdf->SetX($r+7);
		$pdf->Cell(85,75,$pdf->Image('C:/wamp/www/fotos/a'.$row['id'].'.jpg', $pdf->GetX()+1, $pdf->GetY(),85,75),'','','C');
		$i++;
		$m++;
		if($i>1){
			$pdf->Ln();
			for($j=0;$j<2;$j++){
				$pdf->SetFillColor(255,255,255);
				$pdf->SetFont('Arial','B',13);
				$x = $pdf->GetX();
				$y = $pdf->GetY();
				$pdf->SetX($x+7);
				$pdf->SetTextColor(0,0,0);
				$pdf->MultiCell(85,4,$ar[$j],'','','C',true);
				$pdf->SetXY($x + 47, $y-12);
				$pdf->SetFont('Arial','B',27);
				if($stock[$j]<=0){
					$pdf->SetFillColor(255,20,20);
					$pdf->SetTextColor(255,255,255);
					$pdf->Cell(48,10,"AGOTADO",'','','C',true);
				}
				$pdf->SetXY($x+92, $y);
			}
			$pdf->Ln();
			$i=0;
		}
		if($m%6==0){
			$pdf->Line(17, 106, 210-15, 106);
			$pdf->Line(17, 191, 210-17, 191);
			$pdf->Line(106, 20, 106, 280);
			if((mysqli_num_rows($sql)-$m)>6){
				$pdf->AddPage();
			}else if((mysqli_num_rows($sql)-$m)>4 && (mysqli_num_rows($sql)-$m)<=6){
				$pdf->AddPage();
				$pdf->Line(17, 106, 210-15, 106);
				$pdf->Line(17, 191, 210-17, 191);
				$pdf->Line(106, 20, 106, 280);
			}else if((mysqli_num_rows($sql)-$m)>2 && (mysqli_num_rows($sql)-$m)<=4){
				$pdf->AddPage();
				$pdf->Line(17, 106, 210-15, 106);
				$pdf->Line(106, 20, 106, 190);
			}else if((mysqli_num_rows($sql)-$m)>0 && (mysqli_num_rows($sql)-$m)<=2){
				$pdf->AddPage();
				$pdf->Line(106, 20, 106, 110);
			}
		}
	}
	$pdf->Ln();
	for($j=0;$j<$i;$j++){
		$pdf->SetFillColor(255,225,255);
		$pdf->SetFont('Arial','B',13);
		$x = $pdf->GetX();
		$y = $pdf->GetY();
		$pdf->SetX($x+7);
		$pdf->SetTextColor(0,0,0);
		$pdf->MultiCell(85,4,$ar[$j],'','','C',true);
		$pdf->SetXY($x + 47, $y-12);
		$pdf->SetFont('Arial','B',27);
		if($stock[$j]>0){
			$pdf->SetFillColor(255,225,0);
			$pdf->Cell(42,10,$prod[$j],'','','C',true);
		}else{
			$pdf->SetFillColor(255,20,20);
			$pdf->SetTextColor(255,255,255);
			$pdf->Cell(48,10,"AGOTADO",'','','C',true);
		}
		$pdf->SetXY($x+92, $y);
	}
}
$pdf->Output();
?>