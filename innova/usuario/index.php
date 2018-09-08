<!DOCTYPE html>
<?php 
session_start();
if($_SESSION['valida']=='innova' && $_SESSION['cargo']=='ADMIN'){
?>
<html>
<head>
	<title>USUARIOS</title>
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
	    #table table {
	      table-layout: fixed;
	    }
	    #table td,th {
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
			<tr><td>NOMBRE:</td><td><input type="text" name="nombre" id="nombre" class="span3" style="text-transform:uppercase;float:left;"/></td></tr>
			<tr><td>USUARIO:</td><td><input type="password" name="usuario" id="usuario" class="span3" style="text-transform:uppercase;float:left;"/></td></tr>
			<tr><td>PASSWORD:</td><td><input type="password" name="password" id="password" class="span3" style="text-transform:uppercase;float:left;"/></td></tr>
			<tr><td>CUMPLEAÑOS:</td><td><input type="text" name="cumple" id="cumple" class="span3" style="text-transform:uppercase;float:left;"/></td></tr>
			<tr><td>CELULAR:</td><td><input type="text" name="celular" id="celular" class="span3" style="text-transform:uppercase;float:left;"/></td></tr>
			<tr><td>CARGO:</td><td><select id="cargo" name="cargo" class="span3">
				<option value="ADMIN">ADMIN</option>
				<option value="CAJERO">CAJERO</option>
				<option value="VENDEDOR">VENDEDOR</option>
				<option value="CLIENTE">CLIENTE</option>
			</select></td></tr>
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
		<h3 style="text-align: center;color:#428bca;margin-top:-2px;font-weight:bold">REGISTRO DE USUARIOS</h3>
		<div id="boton">
			NOMBRE:<input type="text" id="busqueda" name="busqueda" class="span6" placeholder="Realize su Busqueda..." style="text-transform:uppercase;margin-right:10px" autocomplete="off"/>
			ACTIVO:<select id='selactivo' class='span1'>
				<option value='SI'>SI</option>
				<option value='NO'>NO</option>
			</select>
			<button id="eliminar" class="btn btn-success" title="Seleccione una fila para Eliminar" style="float: right; margin: 0 7px 20px 0;">Eliminar</button>
			<button id="editar" class="btn btn-success" title="Seleccione una fila para Editar" style="float: right; margin: 0 7px 20px 0;">Editar</button>
			<button id="agregar" class="btn btn-success" title="Agregar Datos" style="float: right; margin: 0 7px 20px 0; ">Agregar</button>
		</div>
		<table class="table table-bordered" id='table'>
			<thead>
				<tr style='background-color:#428bca;color:white'>
					<th style="text-align: center;width:50%">NOMBRE</th>
					<th style="text-align: center;width:15%">CUMPLEAÑOS</th>
					<th style="text-align: center;width:15%">CELULAR</th>
					<th style="text-align: center;width:15%">CARGO</th>
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
		            <div style="float:right;margin-top:5px;">Total de Usuarios Registrados:   </div>
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