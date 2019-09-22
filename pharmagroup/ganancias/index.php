<!DOCTYPE html>
<?php 
require_once('../connection.php');
if($_SESSION['valida']=='pharmagroup' && $_SESSION['cargo']=='ADMIN' || $_SESSION['cargo']=='ENCARGADOTIENDA'  || $_SESSION['cargo']=='LOGISTICA'){
    $q=mysqli_query($con,"SELECT * FROM usuario WHERE cargo!='CLIENTE'");
?>
<html>
<head>
	<title>GANANCIAS</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 
	<link type="text/css" href="../bootstrap.min.css" rel="stylesheet" />
	<link type="text/css" href="../sweet-alert.css" rel="stylesheet" />
	<link type="text/css" href="../jquery-ui-1.10.4.custom.min.css" rel="stylesheet" />
	<script type="text/javascript" src="../jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="../jquery-ui-1.10.4.custom.min.js"></script> 
	<script type="text/javascript" src="../bootstrap.min.js"></script>
	<script type='text/javascript' src='../picnet.table.filter.min.js'></script> 
	<script type="text/javascript" src="../sweet-alert.min.js"></script>  
	<script src="../Chart.min.js"></script> 
	<script type="text/javascript" src="ganancia.js"></script>
	<style type="text/css">
	    .impar{
	    	background-color: #E0F8E0;
	    }
	    .selected {
		    cursor: pointer;
	    	background: #FF3;
	    }
		#foot td{
			border:1px solid #B1B1B1;
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
			margin-left: -5px !important;
			margin-bottom: -2px !important;
			margin-top: -4px !important;
		}
		#myModal{
			width: 1000px;
			height: 550px;
			margin-left:-500px;
		}
		.modal-header, h4, .close {
	      background-color: #5cb85c;
	      color:white !important;
	      text-align: center;
	      font-size: 30px;
	  	}
	</style>
</head>
<body>
<img src='excel.png' style='position:absolute;width:35px;right:30px;top:2px;cursor:pointer' id='excel'>
<form id="form" action="" method="post">
	<table width='100%' style='border-collapse:collapse'>
		<tr>
			<td style='text-align:right;'>PROVEEDOR:</td>
			<td><input type='text' id='proveedorsistema' name='proveedorsistema' style="margin-bottom:0px" class='span3'></td>			
			<td colspan='7' align='center' style='padding:0'><h3 style='margin-top:0px;margin-bottom:0px;' class='btn-warning'>GANANCIAS</h3></td></tr>
		<tr bgcolor='#FADE9C'>
			<td style='text-align:right;'>CLIENTE:</td>
			<td><input type='text' id='cliente' name='cliente' style="margin-bottom:0px" class='span3'></td>
			<td style='text-align:right'>VENDEDOR:</td>
			<td>
	            <select name="vendedor" id="vendedor" class='span2' style='margin-bottom:0px;margin-left:-5px'>
	                <option value=""></option>
	                <?php while ($row=mysqli_fetch_assoc($q)){?>
	                <option value="<?php echo $row['nombre']; ?>"><?php echo $row['nombre']; ?></option>
	                <?php } ?>
	            </select>
	        </td>
			<td style='text-align:right'>FECHA INICIO:</td>
			<td><input type='text' id='inicio' name='inicio' size='9' style='cursor:pointer;font-weight:bold;text-align:right;margin-bottom: 0px;width:80px;'></td>
			<td><input type='button' id='buscar' value='BUSCAR' style='margin-bottom:0px' class='btn btn-success'></td>
		</tr>
		<tr bgcolor='#FADE9C'>
			<td style='text-align:right'>PRODUCTO:</td>
			<td><input type='text' id='producto' name='producto' style="margin-bottom:0px" class='span3'></td>
			<td style='text-align:right;'>MARCA:</td>
			<td><input type='text' id='marca' name='marca' style="margin-bottom:0px;" class='span2'></td>
			<td style='text-align:right'>FECHA FINAL:</td>
			<td><input type='text' id='final' name='final' size='9' style='cursor:pointer;font-weight:bold;text-align:right;margin-bottom: 0px;width:80px;'></td>
			<td><img src='../estadistica.png' width='30px' data-toggle="modal" data-target="#myModal" id='estadistica' style='cursor:pointer'></td>
		</tr>
	</table>
</form>
<div id="row" style='margin-top:-20px'>
	<table width='100%'>
      <thead>
        <tr align='center' bgcolor="black" style="color:white;font-weight:bold;font-size:12px">
          <th width='2%'>N°</th>
          <th width='8%'>VENDEDOR</th>
          <th width='5%'>FECHA</th>
          <th width='8%'>COMPROBANTE</th>
          <th width='5%'>SERIE</th>
          <th width='15%'>CLIENTE</th>
          <th width='26%'>PRODUCTO</th>
          <th width='3%'>CANT</th>
          <th width='7%'>P.COMPRA</th>
          <th width='7%'>P.VENTA</th>
          <th width='7%'>GAN(UND)</th>
          <th width='7%'>GAN(TOTAL)</th>
        </tr>
      </thead>
    </table>
    <div style="overflow-y:overlay;overflow-x:hidden;height:480px;margin:auto;">
    <table width='100%' id="venta" style="font-weight:bold;font-size:13px" class='table table-bordered table-condensed'>
      <thead>
        <tr style="display:none">
          <th width='2%'>N°</th>
          <th width='8%'>VENDEDOR</th>
          <th width='5%'>FECHA</th>
          <th width='8%'>COMPROBANTE</th>
          <th width='5%'>SERIE</th>
          <th width='15%'>CLIENTE</th>
          <th width='26%'>PRODUCTO</th>
          <th width='3%'>CANTIDAD</th>
          <th width='7%'>P.COMPRA</th>
          <th width='7%'>P.VENTA</th>
          <th width='7%'>GAN(UND)</th>
          <th width='7%'>GAN(TOTAL)</th>
        </tr>
      </thead>
      <tbody id="verbody">
      </tbody>
    </table>
  </div>
  <table width='100%' style="font-weight:bold;font-size:17px" id='foot'>
    <tr align='right'>
      <td width='69%' colspan='6' >TOTALES</td>
      <td width='3%' id='sumacantidad'></td>
      <td width='7%' id='sumacompra'></td>
      <td width='7%' id='sumaventa'></td>
      <td width='7%' id='porcentaje'></td>
      <td width='7%' id='sumatotal' style='padding-right:10px;'></td>
    </tr>
  </table>
</div>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Estadisticas</h4>
        </div>
        <div class="modal-body">   
	        <table width='100%' height='100%'>
				<tr>
					<td>
		              <select id='forma' class='span2' style='margin-bottom:0px'>
		                <option value='mensual'>MENSUAL</option>
		                <option value='vendedor'>VENDEDOR</option>
		                <option value='marca'>MARCA</option>
		                <option value='cliente'>CLIENTE</option>
		              </select>
		            </td>
					<td>
		              <select id='month' class='span2' style='margin-bottom:0px'>
		                <option value='00'>ENERO</option>
		                <option value='01'>FEBRERO</option>
		                <option value='02'>MARZO</option>
		                <option value='03'>ABRIL</option>
		                <option value='04'>MAYO</option>
		                <option value='05'>JUNIO</option>
		                <option value='06'>JULIO</option>
		                <option value='07'>AGOSTO</option>
		                <option value='08'>SETIEMBRE</option>
		                <option value='09'>OCTUBRE</option>
		                <option value='10'>NOVIEMBRE</option>
		                <option value='11'>DICIEMBRE</option>
		              </select>
		            </td>
		            <td>
		              <select id='year' class='span1' style='margin-bottom:0px'>
		                <option>2015</option>
		                <option>2016</option>
		                <option>2017</option>
		                <option>2018</option>
		                <option>2019</option>
		                <option>2020</option>
		              </select>
		            </td>
					<td align='right'><input type='button' id='busc' value='Buscar' style='cursor:pointer' class='btn btn-success'></td>
				</tr>
				<tr>
					<td colspan='4' style='height:350px;'>
						<canvas id="canvas" style='width:100%;height:350px;'></canvas>
					</td>
				</tr>
			</table>
      	</div>
      	<div class="modal-footer">
	        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
	    </div>
      </div>
      
    </div>
  </div>

</body>
</html>
<?php }else{
  header("Location: ../");
} ?>