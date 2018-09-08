<?php 
    require_once('../connection.php');
    $date=strtotime("01-".$_POST['m']."-".$_POST['y']);
    $day=date('d',$date);
    $month=date('m',$date);
    $year=date('Y',$date);
    $first_day=mktime(0,0,0,$month, 1,$year);
    $title=date('F',$first_day);
    $day_of_week=date('D',$first_day); 
    $blankCount=array("Mon","Tue","Wed","Thu","Fri","Sat","Sun");
    $blank=array_search($day_of_week,$blankCount);
    $days_in_month=cal_days_in_month(0,$month,$year);
    $day_count=1;
    $hoy=date('Y-m-d');
    $CalenderTable="<tr style='color:white;font-weight:bold;'>
        <td align='center' width='14.2%' height='25px' style='background-color:#585858;border:1px solid black'>LUNES</td>
        <td align='center' width='14.3%' height='25px' style='background-color:#585858;border:1px solid black'>MARTES</td>
        <td align='center' width='14.3%' height='25px' style='background-color:#585858;border:1px solid black'>MIERCOLES</td>
        <td align='center' width='14.3%' height='25px' style='background-color:#585858;border:1px solid black'>JUEVES</td>
        <td align='center' width='14.3%' height='25px' style='background-color:#585858;border:1px solid black'>VIERNES</td>
        <td align='center' width='14.3%' height='25px' style='background-color:#585858;border:1px solid black'>SABADO</td>
        <td align='center' width='14.3%' height='25px' style='background-color:#585858;border:1px solid black'>DOMINGO</td>
    </tr>";
    $CalenderTable.="<tr style='height:20%'>";
    while ( $blank > 0 ) { 
        $CalenderTable.="<td style='background-color:white'></td>"; 
        $blank--; 
        $day_count++;
    }
    $day_num=1;
    while ( $day_num <= $days_in_month ) {
        $montos="";
        $fech=$year."-".$month."-".$day_num;
        $sql = mysqli_query($con,"SELECT * FROM letraclientes WHERE pendiente='SI' AND fechapago='$fech'");
        if(mysqli_num_rows($sql)>0){
            while($row = mysqli_fetch_assoc($sql)){
                if(strtotime($hoy)-(60*60*24*8) < strtotime($fech)){
                    $montos.="<div class='letra' style='color:blue;text-decoration: underline overline blink;font-size:12px;margin-bottom:-17px;cursor:pointer;' id='".$row['id']."' title='".$row['cliente']."<br/>N° Unico: ".$row['unico']."<br/>S/. ".$row['total']."'>".substr($row['cliente'],0,14)."..".": S/. ".$row['total']."</div><br>";
                }else{
                    $montos.="<div class='letra' style='color:red;text-decoration: underline overline blink;font-size:12px;margin-bottom:-17px;cursor:pointer;' id='".$row['id']."' title='".$row['cliente']."<br/>N° Unico: ".$row['unico']."<br/>S/. ".$row['total']."'>".substr($row['cliente'],0,14)."..".": S/. ".$row['total']."</div><br>";
                }
            }
        }
        if($day_count==7){
            $CalenderTable.="<td id='$day_num$month$year' style='font-weight:bold;font-size:20px;background-color:#FDDA8F;border: 1px solid black;' valign='top'>$day_num<br>$montos</td>";
        }else{
            $CalenderTable.="<td id='$day_num$month$year' style='font-weight:bold;font-size:20px;border: 1px solid #8C8A86;' valign='top'>$day_num <br>$montos</td>";
        }
        $day_num++; 
        $day_count++;
        if ($day_count > 7) {
            $CalenderTable.="</tr><tr>";
            $day_count=1;
        }
    } 
    while ( $day_count >1 && $day_count <=7 ) { 
        $CalenderTable.="<td style='background-color:white'></td>"; 
        $day_count++; 
    } 
    $CalenderTable.="</tr>";
	echo $CalenderTable; 
?>