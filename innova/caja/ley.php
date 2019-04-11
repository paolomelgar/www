<?php 
	session_start();
	$aa="";
    $bb="001";
    if($_SESSION['mysql']=="innovaelectric"){
      $aa="20601765641";
    }else if($_SESSION['mysql']=="innovaprincipal"){
      $aa="20487211410";
    }else if($_SESSION['mysql']=="prolongacionhuanuco"){
      $aa="10433690058";
    }else if($_SESSION['mysql']=="jauja"){
      $aa="20603695055";
    }
    if($aa!=""){
	    if($_POST['doc']=='FACTURA ELECTRONICA'){
		    $archivo3 = fopen("C:/Users/FERREBOOM/Dropbox/".$aa."/".$aa."-01-F".$bb."-".$_POST['serie'].".LEY", "w");
	            fwrite($archivo3, "1000|".$_POST['b']."|");
	            fclose($archivo3);
      }else{
    	  $archivo3 = fopen("C:/Users/FERREBOOM/Dropbox/".$aa."/".$aa."-03-B".$bb."-".$_POST['serie'].".LEY", "w");
            fwrite($archivo3, "1000|".$_POST['b']."|");
            fclose($archivo3);
      }
    }
 ?>