<?php 	
require_once('../connection.php');
date_default_timezone_set('America/Los_Angeles');
$a=array();
$b=array();
$m=date('m');
$y=date('Y');
for($j=0;$j<12;$j++){
			$quer = mysqli_query($con,"SELECT SUM(total) FROM total_ventas WHERE entregado='SI' AND MONTH(fecha)='".$m."' AND YEAR(fecha)='".$y."' AND HOUR(hora) between '".($j+9).":00:00' and '".($j+9).":59:59'");
			$rr=mysqli_fetch_row($quer);
			$a[$j]=$rr[0];
			switch ($j) {
				case '0':
					$b[$j]="09:00-10:00";
				break;
				case '1':
					$b[$j]="10:00-11:00";
				break;
				case '2':
					$b[$j]="11:00-12:00";
				break;
				case '3':
					$b[$j]="12:00-13:00";
				break;
				case '4':
					$b[$j]="13:00-14:00";
				break;
				case '5':
					$b[$j]="14:00-15:00";
				break;
				case '6':
					$b[$j]="15:00-16:00";
				break;
				case '7':
					$b[$j]="16:00-17:00";
				break;
				case '8':
					$b[$j]="17:00-18:00";
				break;
				case '9':
					$b[$j]="18:00-19:00";
				break;
				case '10':
					$b[$j]="19:00-20:00";
				break;
				case '11':
					$b[$j]="20:00-21:00";
				break;
				default:
				break;
			}
		}
$c[0]=$a;
$c[1]=$b;
echo json_encode($c,JSON_NUMERIC_CHECK);
?>