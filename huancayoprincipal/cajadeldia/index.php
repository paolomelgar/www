<?php 
session_start();
if($_SESSION['valida']=='huancayoprincipal' && $_SESSION['cargo']!='VENDEDOR') {
?>
<html>
<head>
	<title>CAJA DEL DIA</title>
</head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" /> 
<link type="text/css" href="../jquery-ui-1.10.4.custom.min.css" rel="stylesheet" />
<link type="text/css" href="../sweet-alert.css" rel="stylesheet" />
<script type="text/javascript" src="../jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="../jquery-ui-1.10.4.custom.min.js"></script>  
<script type="text/javascript" src="cajadia.js"></script>
<script type="text/javascript" src="../sweet-alert.min.js"></script>  
<style type="text/css">
.par{
    background-color: white;
  }
  .impar{
    background-color: #E0F8E0;
  }
  .con{
    color: red;
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
	<table border='1' width='100%' height='100%' cellpadding="0" cellspacing="0" align="center">
		<tr>
			<td width='30%' height='50%' valign='top'>
				<div>
					<table border='0' width='100%' height='100%' style="border-collapse: collapse;">
						<tr>
							<th colspan='2' align='center'>CAJA</th>
						</tr>
						<tr>
							<td>FECHA:</td>
							<td><input type='text' name='fecha' id='fecha' style='cursor:pointer;text-align:right'></td>
						</tr>
						<tr>
							<td>COMPROBANTES:</td>
							<td><input type='text' name='com' id='com' style='text-align:right'><input name='radio' type='radio' id='1'></td>
						</tr>
						<tr>
							<td>CREDITOS:</td>
							<td><input type='text' name='credito' id='credito' style='text-align:right'><input name='radio' type='radio' id='2'></td>
						</tr>
						<tr>
							<td>INGRESOS:</td>
							<td><input type='text' name='ingreso' id='ingreso' style='text-align:right'><input name='radio' type='radio' id='3'></td>
						</tr>
						<tr>
							<td>EGRESOS:</td>
							<td><input type='text' name='egreso' id='egreso' style='text-align:right'><input name='radio' type='radio' id='4'></td>
						</tr>
						<tr>
							<td>CAJA TOTAL:</td>
							<td><input type='text' name='total' id='total' style='text-align:right'></td>
						</tr>
						<tr style='background-color:#F63'>
							<td>CAJA REAL:</td>
							<td><input type='text' name='real' id='real' style='text-align:right'></td>
						</tr>
						<tr style="background-color: #FF3">
							<td>DIFERENCIA:</td>
							<td><input type='text' name='diferencia' id='diferencia' style='text-align:right'></td>
						</tr>
						<tr>
							<td colspan='2' align='center'><input type='button' value='CERRAR CAJA' id='cerrar'></td>
						</tr>
					</table>
				</div>
			</td>
			<td rowspan='2' width='70%' valign='top'>
				<div id='result' style='height:98%;'></div>
			</td>
		</tr>
		<tr>
			<td width='30%' valign='top'><div id='productos' style='overflow:auto;height:100%;'></div></td>
		</tr>
	</table>
</body>
</html>
<?php }else{
  header("Location: ../");
} ?>