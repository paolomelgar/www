<?php 
session_start();
require_once('../connection.php');
$search = explode(" ", $_POST['b']);
$producto = "";
if(substr($_POST['b'],0,3)=='C/ '){
    $producto .= "codigo=".substr($_POST['b'],3)."";
}else{
    foreach($search AS $s){
        $producto .= "concat(producto,' ',marca) LIKE '%".mysqli_real_escape_string($con,$s)."%' AND ";
    }
    $producto = substr($producto, 0, -4);
}
$query = "SELECT * FROM producto WHERE $producto AND (activo='SI' OR activo='OFERTA') ORDER BY producto,marca LIMIT 12";
$result=mysqli_query($con,$query);
while($row=mysqli_fetch_assoc($result)){ 
        ?>  
        <tr>
            <td style='display:none' class="text"><?php echo $row['id']; ?></td>
            <td style='padding:0px' align='center' ><?php echo '<img src="../fotos/producto/a'.$row['codigo'].'.jpg?timestamp=41232" height="50px" width="50px">'; ?></td>
            <td class="text"><?php echo $row['producto']." ".$row['marca']; ?></td>
            <td contenteditable="true" class="text" style="text-align:right"><?php echo $row['porcentaje']; ?></td>
            <td contenteditable="true" class="text" style="text-align:right"><?php echo $row['cant_caja']; ?></td>
        <tr>
/<?php } ?>