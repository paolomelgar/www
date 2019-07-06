<?php 
	if($_POST['doc']=='FACTURA ELECTRONICA BOOM'){
		$archivo3 = fopen("C:/Users/FERREBOOM/Dropbox/20600996968/20600996968-01-F001-".$_POST['serie'].".LEY", "w");
	            fwrite($archivo3, "1000|".$_POST['b']."|");
	            fclose($archivo3);
    }else{
    	$archivo3 = fopen("C:/Users/FERREBOOM/Dropbox/20601765641/20601765641-01-F002-".$_POST['serie'].".LEY", "w");
            fwrite($archivo3, "1000|".$_POST['b']."|");
            fclose($archivo3);
    }
 ?>