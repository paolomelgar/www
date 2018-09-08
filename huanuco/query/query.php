<?php 
require_once('../connection.php');
 echo "<div style='color:blue;font-weight:bold' class='q'>".$_POST['query']."</div>";
 echo "<table border='0' style='border-collapse:collapse;width:100%;margin-top:10px;table-layout: fixed;'>";
 $result = mysqli_query($con,$_POST['query']);
 $a=mysqli_fetch_object($result);
 echo "<tr style='background-color:#428bca;color:white;text-transform:uppercase'>";
 foreach($a as $cname => $cvalue){
    	echo "<th style='border:1px solid black;overflow:hidden;white-space: nowrap;width:100px;'>$cname</th>";
    }
    echo "</tr>";
    echo "<tr>";
 foreach($a as $cname => $cvalue){
    	echo "<td style='border:1px solid black;overflow:hidden;white-space: nowrap;width:100px;'>$cvalue</td>";
    }
    echo "</tr>";
while($row = mysqli_fetch_assoc($result)){
	echo "<tr>";
    foreach($row as $cname => $cvalue){
    	echo "<td style='border:1px solid black;overflow:hidden;white-space: nowrap;width:100px;'>$cvalue</td>";
    }
    echo "</tr>";
}
echo "</table><br>";
 ?>