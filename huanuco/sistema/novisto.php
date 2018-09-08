<?php 
require_once('../connection.php');
    $sql=mysqli_query($con,'SELECT DISTINCT(emisor) FROM chat WHERE (visto="MEDIO" OR visto="FIN") AND receptor="'.$_POST['usuario'].'"');
    $array=array();
    $i=0;
    while($row=mysqli_fetch_assoc($sql)){
    	$array[$i]=$row['emisor'];
    	$i++;
    }
    echo json_encode($array);

?>