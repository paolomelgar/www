<!DOCTYPE html>
<?php 
session_start();
if($_SESSION['valida']=='tarapaca' && $_SESSION['cargo']=='ADMIN' || $_SESSION['cargo']=='CAJERO'){
?>
<html>
<head>
	<title>PROVEEDORES</title>
	<meta charset="utf-8" />
	<link type="text/css" href="../jquery-ui-1.10.4.custom.min.css" rel="stylesheet" />
	<link type="text/css" href="../bootstrap.min.css" rel="stylesheet" />
	<link type="text/css" href="../sweet-alert.css" rel="stylesheet" />
	<script type="text/javascript" src="../jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="../bootstrap.min.js"></script>
	<script type="text/javascript" src="../jquery-ui-1.10.4.custom.min.js"></script>
	<script type="text/javascript" src="../sweet-alert.min.js"></script> 
	<script type="text/javascript" src="functions.js"></script>
	<style>
	    .selected {
	      background-color:#F63 !important;
	      color:white;
	    }
	    #body{
	      margin:auto;
	      overflow:hidden;
	      width:98%;
	    }
	    table {
	      table-layout: fixed;
	    }
	    td,th {
	      white-space: nowrap;
	      overflow: hidden;
	      width:145px;
	    }
	    .tr:hover{
	      background-color: #FF3;
	    }
	</style>
</head>
<body>
	<div style='display:none' id="agregardatos">
	<form name="formagregar" id="formagregar">
		<table width='100%'>
			<tr><td><input type="hidden" name="id" id="id"/></td></tr>
			<tr><td>RUC:</td><td><input type="text" name="ruc" id="ruc" class="span3" maxlength='11' style="text-transform:uppercase;float:left;"/></td></tr>
			<tr><td>PROVEEDOR:</td><td><input type="text" name="proveedor" id="proveedor" class="span3" style="text-transform:uppercase;float:left;"/></td></tr>
			<tr><td>DIRECCION:</td><td><input type="text" name="direccion" id="direccion" class="span3" style="text-transform:uppercase;float:left;"/></td></tr>
			<tr><td>REPRESENT:</td><td><input type="text" name="representante" id="representante" class="span3" style="text-transform:uppercase;float:left;"/></td></tr>
			<tr><td>TELEFONO:</td><td><input type="text" name="telefono" id="telefono" maxlength='10' class="span3" style="text-transform:uppercase;float:left;"/></td></tr>
			<tr><td>CELULAR:</td><td><input type="text" name="celular" id="celular" maxlength='10' class="span3" style="text-transform:uppercase;float:left;"/></td></tr>
			<tr><td>CUENTA:</td><td><input type="text" name="mail" id="mail" class="span3" style="text-transform:uppercase;float:left;"/></td></tr>
			<tr><td>ACTIVO:</td><td><select id="activo1" name="activo1" class="span3">
				<option value="SI">SI</option>
				<option value="NO">NO</option>
			</select></td></tr>
		</table>
	</form>
	</div>
	<div class="hide" id="eliminardatos">
      	<p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>Este registro se borrará de forma permanente. ¿Esta seguro?</p>
  	</div>
	<div id="body">
		<h3 style="text-align: center;color:#428bca;margin-top:-2px;font-weight:bold">REGISTRO DE PROVEEDORES</h3>
		<div id="boton">
			RUC/PROVEEDOR:<input type="text" id="busqueda" name="busqueda" class="span6" placeholder="Realize su Busqueda..." style="text-transform:uppercase;margin-right:10px" autocomplete="off"/>
			ACTIVO:<select id='selactivo' class='span1'>
				<option value='SI'>SI</option>
				<option value='NO'>NO</option>
			</select>
			<button id="eliminar" class="btn btn-success" title="Seleccione una fila para Eliminar" style="float: right; margin: 0 7px 20px 0;">Eliminar</button>
			<button id="editar" class="btn btn-success" title="Seleccione una fila para Editar" style="float: right; margin: 0 7px 20px 0;">Editar</button>
			<button id="agregar" class="btn btn-success" title="Agregar Datos" style="float: right; margin: 0 7px 20px 0; ">Agregar</button>
		</div>
		<table class="table table-bordered">
			<thead>
				<tr style='background-color:#428bca;color:white'>
					<th style="text-align: center;width:10%">RUC</th>
					<th style="text-align: center;width:27%">PROVEEDOR</th>
					<th style="text-align: center;width:23%">DIRECCION</th>
					<th style="text-align: center;width:10%">REPRESENTANTE</th>
					<th style="text-align: center;width:7%">TELEFONO</th>
					<th style="text-align: center;width:7%">CELULAR</th>
					<th style="text-align: center;width:12%">CUENTA</th>
					<th style="text-align: center;width:5%">ACTIVO</th>
				</tr>
			</thead>
			<tbody id="resultado">  
	         
	      	</tbody>
	      	<tfoot id='foot'>
		        <tr>
		          <td colspan='14'>
		            <div style='float:left;margin-bottom:-10px'>
		              <select id='pagina' style='width:70px'>
		                <option>12</option>
		                <option>20</option>
		                <option>50</option>
		                <option>100</option>
		              </select> 
		            </div>
		            <div >
		              <div id='primero' style='position:absolute;margin-left:500px;'><input type='button' value='|<' class="btn btn-primary"></div>
		              <div id='anterior' style='position:absolute;margin-left:550px;'><input type='button' value='<' class="btn btn-primary"></div>
		              <div style='position:absolute;margin-left:600px;'>Página  <input id='numero' type='text' value='1' class="btn span1" style='cursor:text'> de <span id='cant'></span></div>
		              <div id='siguiente' style='position:absolute;margin-left:770px;'><input type='button' value='>' class="btn btn-primary"></div>
		              <div id='ultimo' style='position:absolute;margin-left:820px;'><input type='button' value='>|' class="btn btn-primary"></div>
		            </div>
		            <div style="float:right;color:red;font-weight:bold;margin-top:5px;font-size:20px" id='cantidad'></div>
		            <div style="float:right;margin-top:5px;">Total de Proveedores Registrados:   </div>
		          </td>
		        <tr>
		      </tfoot>
		</table> 
	</div>
</body>
</html>
<?php }else{
  header("Location: ../");
} ?>