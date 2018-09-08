<!DOCTYPE html>
<?php 
session_start();
if($_SESSION['valida']=='huanucotienda' && $_SESSION['cargo']!='VENDEDOR') {
?>
<html>
<head>
	<title>CAJA DEL DIA</title>
</head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" /> 
<link type="text/css" href="../bootstrap.min.css" rel="stylesheet" />
<link type="text/css" href="../jquery-ui-1.10.4.custom.min.css" rel="stylesheet" />
<link type="text/css" href="../sweet-alert.css" rel="stylesheet" />
<script type="text/javascript" src="../jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="../jquery-ui-1.10.4.custom.min.js"></script>  
<script type='text/javascript' src='../picnet.table.filter.min.js'></script> 
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
  html,body{
    height:99%;
    padding: 1px;
  }
  .fila:hover{
    background: #FF3;
    cursor:pointer;
  }
  ::-webkit-scrollbar{
    width: 7px;  /* for vertical scrollbars */
  }
  ::-webkit-scrollbar-track{
    background: rgba(0, 0, 0, 0);
  }
  ::-webkit-scrollbar-thumb{
    background: rgba(0, 0, 0, 0.5);
  }
  input{
    margin-bottom: 0px !important;
  }
  .ui-widget-overlay{
    opacity: .50;filter:Alpha(Opacity=50);   
  }
</style>
<body>
	<table height='100%' width='100%' border='1' align="center">
		<tr>
			<td width='30%' height='50%' valign='top'>
				<div>
					<table width='100%' height='100%'>
						<tr>
							<th colspan='3' align='center'><span style='font-size:25px'>CAJA DEL DIA</span></th>
						</tr>
						<tr>
							<td>FECHA:</td>
							<td align='right'><input type='text' name='fecha' id='fecha' style='cursor:pointer;text-align:right' class='span2'></td>
						</tr>
						<tr>
							<td>COMPROBANTES:</td>
							<td align='right'><input type='text' name='com' id='com' style='text-align:right' class='span2' readonly='readonly'></td>
							<td><input name='radio' type='radio' id='1'></td>
						</tr>
						<tr>
							<td>CREDITOS:</td>
							<td align='right'><input type='text' name='credito' id='credito' style='text-align:right' class='span2' readonly='readonly'></td>
							<td><input name='radio' type='radio' id='2'></td>
						</tr>
						<tr>
							<td>INGRESOS:</td>
							<td align='right'><input type='text' name='ingreso' id='ingreso' style='text-align:right' class='span2' readonly='readonly'></td>
							<td><input name='radio' type='radio' id='3'></td>
						</tr>
						<tr>
							<td>EGRESOS:</td>
							<td align='right'><input type='text' name='egreso' id='egreso' style='text-align:right' class='span2' readonly='readonly'></td>
							<td><input name='radio' type='radio' id='4'></td>
						</tr>
						<tr>
							<td>CAJA TOTAL:</td>
							<td align='right'><input type='text' name='total' id='total' style='text-align:right' class='span2' readonly='readonly'></td>
							<td></td>
						</tr>
						<tr style='background-color:#F63'>
							<td>CAJA REAL:</td>
							<td align='right'><input type='text' name='real' id='real' style='text-align:right' class='span2'></td>
							<td></td>
						</tr>
						<tr style="background-color: #FF3">
							<td>DIFERENCIA:</td>
							<td align='right'><input type='text' name='diferencia' id='diferencia' style='text-align:right' class='span2' readonly='readonly'></td>
							<td></td>
						</tr>
						<tr>
							<td colspan='3' align='center'><input type='button' value='CERRAR CAJA' id='cerrar' class='btn btn-success'></td>
						</tr>
					</table>
				</div>
			</td>
			<td rowspan='2' width='70%' valign='top'>
				<div id='result1' style='display:none;overflow-y:overlay;overflow-x:hidden;height:100%;' class='result'>
				    <table width="100%" align="center" id='filter1'>
				       <thead>
				        <tr bgcolor="#428bca" style="color:#FFF; text-align:center;font-size:13px;font-weight:bold">
				          <th width="10%">SERIE</th>
				          <th width="15%">HORA</th>
				          <th width="20%">COMPROBANTE</th>
				          <th width="35%">CLIENTE</th>
				          <th width="10%">TOTAL</th>
				          <th width="10%">VER</th>
				        </tr>
				       </thead>
					   <tbody id="verbody1">
				       </tbody>
				       <tfoot>
				        <tr style="font-weight:bold">
				          <td width='80%' style="text-align:right;border:1px solid #B1B1B1" colspan='4'>TOTAL</td>
				          <td width='10%' style="text-align:right;border:1px solid #B1B1B1" id='total1'></td>
				          <td width='10%' style="text-align:right;border:1px solid #B1B1B1"></td>
				        </tr>
				       </tfoot>
				    </table>
				</div>
				<div id='result2' style='display:none;overflow-y:overlay;overflow-x:hidden;height:100%;' class='result'>
				    <table width="100%" align="center" id='filter2'>
				       <thead>
				        <tr bgcolor="#428bca" style="color:#FFF; text-align:center;font-size:13px;font-weight:bold">
				          <th width="15%">SERIE</th>
				          <th width="25%">ENCARGADO</th>
				          <th width="45%">CLIENTE</th>
				          <th width="15%">MONTO</th>
				        </tr>
				       </thead>
				       <tbody id="verbody2">
				       </tbody>
				       <tfoot>
				          <tr style="font-weight:bold;">
				            <td colspan="3" align='right' style='border:1px solid #B1B1B1'>TOTAL</td>
				            <td align="right" width='10%' id='total2' style='border:1px solid #B1B1B1'></td>
				          </tr>
				       </tfoot>
				    </table>
				</div>
				<div id='result3' style='display:none;overflow-y:overlay;overflow-x:hidden;height:100%;' class='result'>
				    <table width="100%" align="center" id='filter3'>
				       <thead>
				        <tr bgcolor="#428bca" style="color:white;text-align:center;font-size:13px;font-weight:bold">
				          <th width="15%">ENCARGADO</th>
				          <th width="20%">TIPO</th>
				          <th width="50%">DETALLE</th>
				          <th width="15%">MONTO</th>
				        </tr>
				       </thead>
				       <tbody id="verbody3">
				       </tbody>
				       <tfoot>
				          <tr style="font-weight:bold;">
				            <td colspan="3" align='right' style='border:1px solid #B1B1B1'>TOTAL</td>
				            <td align="right" width='15%' id='total3' style='border:1px solid #B1B1B1'></td>
				          </tr>
				       </tfoot>
				    </table>
				</div>
				<div id='result4' style='display:none;overflow-y:overlay;overflow-x:hidden;height:100%;' class='result'>
				    <table width="100%" align="center" id='filter4'>
				       <thead>
				        <tr bgcolor="#428bca" style="color:white;text-align:center;font-size:13px;font-weight:bold">
				          <th width="15%">ENCARGADO</th>
				          <th width="20%">TIPO</th>
				          <th width="50%">DETALLE</th>
				          <th width="15%">MONTO</th>
				        </tr>
				       </thead>
				       <tbody id="verbody4">
				       </tbody>
				       <tfoot>
				          <tr style="font-weight:bold;">
				            <td colspan="3" align='right' style='border:1px solid #B1B1B1'>TOTAL</td>
				            <td align="right" width='15%' id='total4' style='border:1px solid #B1B1B1'></td>
				          </tr>
				       </tfoot>
				    </table>
				</div>
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