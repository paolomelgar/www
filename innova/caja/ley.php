<?php 
	session_start();
	$aa="";
    $bb="001";
    if($_SESSION['mysql']=="innovaelectric"){
      $aa="20601765741";
    }else if($_SESSION['mysql']=="innovaprincipal"){
      $aa="20487211410";
    }else if($_SESSION['mysql']=="innovahuanuco"){
      $aa="20601765741";
      $bb="002";
    }else if($_SESSION['mysql']=="prolongacionhuanuco"){
      $aa="10433690058";
    }
	if($_POST['doc']=='FACTURA'){
		$archivo3 = fopen("C:/Users/FERREBOOM/Dropbox/".$aa."/".$aa."-01-F".$bb."-".$_POST['serie'].".LEY", "w");
	            fwrite($archivo3, "1000|".$_POST['b']."|");
	            fclose($archivo3);
    }else{
    	$archivo3 = fopen("C:/Users/FERREBOOM/Dropbox/".$aa."/".$aa."-01-B".$bb."-".$_POST['serie'].".LEY", "w");
            fwrite($archivo3, "1000|".$_POST['b']."|");
            fclose($archivo3);
    }
 ?>