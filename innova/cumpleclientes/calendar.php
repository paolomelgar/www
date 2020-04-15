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
    $CalenderTable="<tr style='height:20%'>";
    while ( $blank > 0 ) { 
        $CalenderTable.="<td></td>"; 
        $blank--; 
        $day_count++;
    }
    $day_num=1;
    while ( $day_num <= $days_in_month ) {
        $montos="";
        $fech=$year."-".$month."-".$day_num;
        
        $sql = mysqli_query($con,"SELECT * FROM cliente WHERE fnacimiento='$fech'");
        /*if($day_num==31){
            $montos.="<div style='color:#A504FC;font-weight:bold;font-size:12px'>ALQUILER LOCAL S/. 1420.00</div><br>";
        }else if($day_num==13){
            $montos.="<div style='color:#A504FC;font-weight:bold;font-size:12px'>ALQUILER LOCAL S/. 1580.00</div><br>";
        }else if($day_num==2){
            $montos.="<div style='color:#A504FC;font-weight:bold;font-size:12px'>ALQUILER MEZANINE S/. 450.00</div><br>";
        }*/
        if(mysqli_num_rows($sql)>0){
            
            while($row = mysqli_fetch_assoc($sql)){
                
                    $montos.="<div style='color:blue;text-decoration: underline overline blink;margin-bottom:-12px;cursor:pointer;' title='".$row['cliente']."' class='cliente' id='".$row['id_cliente']."'>".substr($row['cliente'],0,28)." </div><br>";
            
        }}
        if($day_count==7){
            $color="#FDDA8F";
        }else{
            $color="#FFFFFF";
        }
        if(date("Y-m-d")==$year."-".$month."-".substr("0".$day_num,-2)){
            $color="#F63 !important";
        }
        $CalenderTable.="<td class='cuad' style='font-weight:bold;background-color:".$color.";border: 1px solid black;font-size:12px;' valign='top'><div style='font-size:20px' class='daynum'>$day_num</div>$montos</td>";
        $day_count++;
        if ($day_count > 7 && $day_num != $days_in_month ) {
            $CalenderTable.="</tr><tr>";
            $day_count=1;
        }
        $day_num++; 
    } 
    $CalenderTable.="</tr>";
    echo $CalenderTable; 
?>