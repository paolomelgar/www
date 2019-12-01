<!DOCTYPE html>
<?php 
session_start();
if($_SESSION['valida']=='innova' && $_SESSION['cargo']=='ADMIN' || $_SESSION['cargo']=='ENCARGADOTIENDA' || $_SESSION['cargo']=='CAJERO' || $_SESSION['cargo']=='ASISTENTE'){
?>
<html>
<head>
	<title>CAJA MAYOR</title>
</head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" /> 
<link type="text/css" href="../bootstrap.min.css" rel="stylesheet" />
<link type="text/css" href="../jquery-ui-1.10.4.custom.min.css" rel="stylesheet" />
<link type="text/css" href="../sweet-alert.css" rel="stylesheet" />
<script type="text/javascript" src="../jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="../jquery-ui-1.10.4.custom.min.js"></script>  
<script type='text/javascript' src='../picnet.table.filter.min.js'></script> 
<script type="text/javascript" src="../sweet-alert.min.js"></script> 
<script type="text/javascript" src="cajamayor.js"></script>
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
							<th colspan='3' align='center'><span style='font-size:25px'>CAJA MAYOR</span></th>
						</tr>
						<tr style="background-color: #F63">
							<td>FECHA:</td>
							<td align='right'><input type='text' name='fecha' id='fecha' style='cursor:pointer;text-align:right' class='span2'></td>
						</tr>
						<tr>
							<td>CAJA TIENDA:</td>
							<td align='right'><input type='text' name='caja' id='caja' style='cursor:pointer;text-align:right' class='span2' readonly='readonly'></td>
						</tr>
						<tr>
							<td>COBROS CREDITOS:</td>
							<td align='right'><input type='text' name='credito' id='credito' style='text-align:right' class='span2' readonly='readonly'></td>
							<td><input name='radio' type='radio' id='1'></td>
						</tr>
						<tr>
							<td>INGRESOS:</td>
							<td align='right'><input type='text' name='ingreso' id='ingreso' style='text-align:right' class='span2' readonly='readonly'></td>
							<td><input name='radio' type='radio' id='2'></td>
						</tr>
						<tr>
							<td>COMPRAS CONTADO:</td>
							<td align='right'><input type='text' name='contado' id='contado' style='text-align:right' class='span2' readonly='readonly'></td>
							<td><input name='radio' type='radio' id='3'></td>
						</tr>
						<tr>
							<td>PAGO PROVEEDORES:</td>
							<td align='right'><input type='text' name='proveedor' id='proveedor' style='text-align:right' class='span2' readonly='readonly'></td>
							<td><input name='radio' type='radio' id='4'></td>
						</tr>
						<tr>
							<td>EGRESOS:</td>
							<td align='right'><input type='text' name='egreso' id='egreso' style='text-align:right' class='span2' readonly='readonly'></td>
							<td><input name='radio' type='radio' id='5'></td>
						</tr>
						<tr style="background-color: #FF3">
							<td>TOTAL DEL DIA:</td>
							<td align='right'><input type='text' name='totaldia' id='totaldia' style='text-align:right' class='span2' readonly='readonly'></td>
							<td></td>
						</tr>
					</table>
				</div>
			</td>
			<td rowspan='2' width='70%' valign='top'>
				<div id='result1' style='display:none;overflow-y:overlay;overflow-x:hidden;height:100%;' class='result'>
				    <table width="100%" align="center" id='filter1'>
				       <thead>
				        <tr bgcolor="#428bca" style="color:#FFF; text-align:center;font-size:13px;font-weight:bold">
				          <th width="8%">TIPO</th>
				          <th width="8%">SERIE</th>
				          <th width="6%">BANCO</th>
				          <th width="6%">N OPE.</th>
				          <th width="10%">FECHA PAGO</th>
				          <th width="14%">ENCARGADO</th>
				          <th width="36%">CLIENTE</th>
				          <th width="12%">MONTO</th>
				        </tr>
				       </thead>
					   <tbody id="verbody1">
				       </tbody>
				       <tfoot>
				        <tr style="font-weight:bold">
				            <td colspan="7" align='right' style='border:1px solid #B1B1B1'>TOTAL</td>
				            <td align="right" width='10%' id='total1' style='border:1px solid #B1B1B1'></td>
				        </tr>
				       </tfoot>
				    </table>
				</div>
				<div id='result2' style='display:none;overflow-y:overlay;overflow-x:hidden;height:100%;' class='result'>
				    <table width="100%" align="center" id='filter2'>
				       <thead>
				        <tr bgcolor="#428bca" style="color:white;text-align:center;font-size:13px;font-weight:bold">
				          <th width="15%">CARGO</th>
				          <th width="15%">USUARIO</th>
				          <th width="15%">TIPO</th>
				          <th width="45%">DETALLE</th>
				          <th width="10%">MONTO</th>
				        </tr>
				       </thead>
				       <tbody id="verbody2">
				       </tbody>
				       <tfoot>
				          <tr style="font-weight:bold;">
				            <td colspan="4" align='right' style='border:1px solid #B1B1B1'>TOTAL</td>
				            <td align="right" width='15%' id='total2' style='border:1px solid #B1B1B1'></td>
				          </tr>
				       </tfoot>
				    </table>
				</div>
				<div id='result3' style='display:none;overflow-y:overlay;overflow-x:hidden;height:100%;' class='result'>
				    <table width="100%" align="center" id='filter3'>
				       <thead>
				        <tr bgcolor="#428bca" style="color:white;text-align:center;font-size:13px;font-weight:bold">
				          <th width="15%">SERIE</th>
				          <th width="10%">HORA</th>
				          <th width="15%">DOCUMENTO</th>
				          <th width="50%">PROVEEDOR</th>
				          <th width="10%">MONTO</th>
				        </tr>
				       </thead>
				       <tbody id="verbody3">
				       </tbody>
				       <tfoot>
				          <tr style="font-weight:bold;">
				            <td colspan="4" align='right' style='border:1px solid #B1B1B1'>TOTAL</td>
				            <td align="right" width='10%' id='total3' style='border:1px solid #B1B1B1'></td>
				          </tr>
				       </tfoot>
				    </table>
				</div>
				<div id='result4' style='display:none;overflow-y:overlay;overflow-x:hidden;height:100%;' class='result'>
				    <table width="100%" align="center" id='filter4'>
				       <thead>
				        <tr bgcolor="#428bca" style="color:white;text-align:center;font-size:13px;font-weight:bold">
				          <th width="8%">TIPO</th>
				          <th width="8%">MEDIO PAGO</th>
				          <th width="8%">BANCO</th>
				          <th width="8%">N OPE.</th>
				          <th width="10%">FECHA PAGO</th>
				          <th width="10%">ENCARGADO</th>
				          <th width="36%">PROVEEDOR</th>
				          <th width="12%">MONTO</th>
				        </tr>
				       </thead>
				       <tbody id="verbody4">
				       </tbody>
				       <tfoot>
				          <tr style="font-weight:bold;">
				            <td colspan="7" align='right' style='border:1px solid #B1B1B1'>TOTAL</td>
				            <td align="right" width='10%' id='total4' style='border:1px solid #B1B1B1'></td>
				          </tr>
				       </tfoot>
				    </table>
				</div>
				<div id='result5' style='display:none;overflow-y:overlay;overflow-x:hidden;height:100%;' class='result'>
				    <table width="100%" align="center" id='filter5'>
				       <thead>
				        <tr bgcolor="#428bca" style="color:white;text-align:center;font-size:13px;font-weight:bold">
				          <th width="15%">CARGO</th>
				          <th width="15%">USUARIO</th>
				          <th width="15%">TIPO</th>
				          <th width="45%">DETALLE</th>
				          <th width="10%">MONTO</th>
				        </tr>
				       </thead>
				       <tbody id="verbody5">
				       </tbody>
				       <tfoot>
				          <tr style="font-weight:bold;">
				            <td colspan="4" align='right' style='border:1px solid #B1B1B1'>TOTAL</td>
				            <td align="right" width='15%' id='total5' style='border:1px solid #B1B1B1'></td>
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