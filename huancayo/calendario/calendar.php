<?php 
    require_once('../connection.php');
            date_default_timezone_set("America/Lima");
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
        $sql = mysqli_query($con,"SELECT * FROM pagoletras WHERE pendiente='SI' AND fecha='$fech'");
        $sql1 = mysqli_query($con,"SELECT * FROM total_compras WHERE credito='CREDITO' AND letra='NO' AND entregado='SI' AND fechapago='$fech'");
        if($day_num==1){
            $montos.="<div style='color:#A504FC;'>ALQUILER LOCAL S/ 2000.00</div>";
        }
        if(mysqli_num_rows($sql)>0 || mysqli_num_rows($sql1)>0){
            while($row = mysqli_fetch_assoc($sql)){
                if($row['billete']=='S/.'){
                    $montos.="<div style='color:blue;text-decoration: underline overline blink;margin-bottom:-12px;cursor:pointer;' title='".$row['proveedor']."<br/>N° Unico: ".$row['unico']."<br/>S/ ".$row['monto']."' class='letra' id='".$row['id']."'>".substr($row['proveedor'],0,14)."..".": S/ ".$row['monto']."</div><br>";
                }else{
                    $montos.="<div style='color:green;text-decoration: underline overline blink;margin-bottom:-12px;cursor:pointer;' title='".$row['proveedor']."<br/>N° Unico: ".$row['unico']."<br/>$ ".$row['monto']."' class='letra' id='".$row['id']."'>".substr($row['proveedor'],0,14)."..".": $ ".$row['monto']."</div><br>";
                }
            }
            while($row = mysqli_fetch_assoc($sql1)){
                if($row['billete']=='SOLES'){
                    $montos.="<div style='color:blue;margin-bottom:-12px;cursor:pointer;' title='".$row['proveedor']."<br/>S/ ".$row['pendiente']."' class='total' id='".$row['id']."'>".substr($row['proveedor'],0,14)."..".": S/ ".$row['pendiente']."</div><br>";
                }else{
                    $montos.="<div style='color:green;margin-bottom:-12px;cursor:pointer;' title='".$row['proveedor']."<br/>$ ".$row['pendiente']."' class='total' id='".$row['id']."'>".substr($row['proveedor'],0,14)."..".": $ ".$row['pendiente']."</div><br>";
                }
            }
        }
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