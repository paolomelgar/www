<?php 
require_once('../connection.php');
    $search = explode(" ", $_POST['b']);
    $producto = "";
    foreach($search AS $s){
        $producto .= "familia LIKE '%".mysqli_real_escape_string($con,$s)."%' AND ";
    }
    $producto = substr($producto, 0, -4);
    $num=($_POST['numero']-1)*$_POST['pagina'];

    $query = "SELECT * FROM familia WHERE $producto AND activo='".$_POST['activo']."' ORDER BY familia LIMIT $num,".$_POST['pagina'];
    $result=mysqli_query($con,$query);
    while($row=mysqli_fetch_assoc($result)){ ?>  
        <tr class="tr">
            <td style='display:none'><?php echo mysqli_num_rows(mysqli_query($con,"SELECT * FROM familia WHERE $producto AND activo='".$_POST['activo']."'"))?></td>
            <td style="display:none"><?php echo $row['id']; ?></td>
            <td style='padding:0px' align='center' title='a'><?php echo '<img src="https://raw.githubusercontent.com/paolomelgar/www/master/huanuco/fotos/familia/a'.$row['id'].'.jpg?timestamp=41232" height="100%" width="100%">'; ?></td>
            <td><?php echo $row['familia']; ?></td>
            <td style="text-align:right"><?php echo $row['activo']; ?></td>
        <tr>
<?php } ?>