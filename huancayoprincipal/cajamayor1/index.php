<?php 
session_start();
if($_SESSION['valida']=='huancayoprincipal' && $_SESSION['cargo']=='ADMIN' || $_SESSION['cargo']=='ENCARGADOTIENDA' || $_SESSION['cargo']=='ASISTENTE'){
?>
<html>
<head>
	<title>CAJA MAYOR</title>
</head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" /> 
<link type="text/css" href="../jquery-ui-1.10.4.custom.min.css" rel="stylesheet" />
<script type="text/javascript" src="../jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="../jquery-ui-1.10.4.custom.min.js"></script>  
<script type="text/javascript" src="cajamayor.js"></script>
<style type="text/css">
  .par{
    background-color: white;
  }
  .impar{
    background-color: #E0F8E0;
  }
  .selected {
    cursor: pointer;
    background: #FF3;
  }
  .select {
    background: #F63;
  }
</style>
<body>
	<table border='1' width='100%' height='100%'>
		<tr>
			<td width='30%' height='50%' valign='top'>
				<div>
					<table border='0' width='100%' height='100%' style="border-collapse: collapse;">
						<tr>
							<th colspan='2' align='center'>CAJA MAYOR</th>
						</tr>
						<tr>
							<td>FECHA:</td>
							<td><input type='text' name='fecha' id='fecha' style='cursor:pointer;text-align:right'></td>
						</tr>
						<tr>
							<td>CAJA TIENDA:</td>
							<td><input type='text' name='caja' id='caja' style='text-align:right'></td>
						</tr>
						<tr>
							<td>COBROS CREDITOS:</td>
							<td><input type='text' name='credito' id='credito' style='text-align:right'><input name='radio' type='radio' id='1'></td>
						</tr>
						<tr>
							<td>INGRESOS:</td>
							<td><input type='text' name='ingreso' id='ingreso' style='text-align:right'><input name='radio' type='radio' id='2'></td>
						</tr>
						<tr>
							<td>COMPRAS CONTADO:</td>
							<td><input type='text' name='contado' id='contado' style='text-align:right'><input name='radio' type='radio' id='3'></td>
						</tr>
						<tr>
							<td>PAGO PROVEEDORES:</td>
							<td><input type='text' name='proveedor' id='proveedor' style='text-align:right'><input name='radio' type='radio' id='4'></td>
						</tr>
						<tr>
							<td>EGRESOS:</td>
							<td><input type='text' name='egreso' id='egreso' style='text-align:right'><input name='radio' type='radio' id='5'></td>
						</tr>
						<tr style="background-color: #FF3">
							<td>TOTAL DIA:</td>
							<td><input type='text' name='totaldia' id='totaldia' style='text-align:right'></td>
						</tr>
						<tr style='background-color:#F63'>
							<td>TOTAL:</td>
							<td><input type='text' name='total' id='total' style='text-align:right'></td>
						</tr>
					</table>
				</div>
			</td>
			<td rowspan='2' width='70%' valign='top'>
				<div id='result'></div>
			</td>
		</tr>
		<tr>
			<td width='30%' valign='top'><div id='productos'></div></td>
		</tr>
	</table>
</body>
</html>
<?php }else{
  header("Location: ../");
} ?>