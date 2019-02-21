<?php 
	if($_POST['doc']=='FACTURA BOOM'){
		$archivo3 = fopen("C:/Users/FERREBOOM/Dropbox/20600996968/20600996968-01-F001-".$_POST['serie'].".LEY", "w");
	            fwrite($archivo3, "1000|".$_POST['b']."|");
	            fclose($archivo3);
    }else{
    	$archivo3 = fopen("C:/Users/FERREBOOM/Dropbox/10433690058/10433690058-01-F001-".$_POST['serie'].".LEY", "w");
            fwrite($archivo3, "1000|".$_POST['b']."|");
            fclose($archivo3);
    }
 ?>