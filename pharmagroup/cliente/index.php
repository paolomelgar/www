<!DOCTYPE html>
<?php 
require_once('../connection.php');
?>
<html>
<head>
	<title>CLIENTES</title>
	<meta charset="utf-8" />
	<link type="text/css" href="../jquery-ui-1.10.4.custom.min.css" rel="stylesheet" />
	<link type="text/css" href="../bootstrap.min.css" rel="stylesheet" />
	<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyA2i8NDRSI90Nk1FGt9aN0Nu5m7HE2c1t8&sensor=false"></script>
	<script type="text/javascript" src="../jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="../bootstrap.min.js"></script>
	<script type="text/javascript" src="../jquery-ui-1.10.4.custom.min.js"></script>
	<script type="text/javascript" src="functions.js"></script>
<style>
  .hov {
    background-color: #FF3;
  }
  .selected {
    background-color:#F63;color:white;
  }
  #boton{
  	margin-top:10px;
  }
  #body{
  	margin-top:10px;
  	margin:0 auto;
	overflow:hidden;
	width:98%;
	min-height:300px;
  }
  table {
    table-layout: fixed;
	}
  td,th {
	white-space: nowrap;
	overflow: hidden;
	width:145px;
  }
  #dialog img {
	max-width: none;
  }
  </style>
</head>
<body>
	<div style='display:none' id="agregardatos">
	<form name="formagregar" id="formagregar">
		<table width='100%'>
			<tr><td><input type="hidden" name="id" id="id"/><input type="hidden" id="lat"><input type="hidden" id="lon"></td></tr>
			<tr><td>RUC:</td><td><input type="text" name="ruc" id="ruc" class="span3" maxlength="11" style="text-transform:uppercase;float:left;"/></td></tr>
			<tr><td>CLIENTE:</td><td><input type="text" name="cliente" id="cliente" class="span3" style="text-transform:uppercase;float:left;"/></td></tr>
			<tr><td>DIRECCION:</td><td><input type="text" name="direccion" id="direccion" class="span3" style="text-transform:uppercase;float:left;"/></td></tr>
			<tr><td>TIPO:</td><td><select id="tipo" name="tipo" class="span3">
				<option value="FERIA">FERIA</option>
				<option value="FERRETERIA">FERRETERIA</option>
			</select></td></tr>
			<tr><td>PROMOTOR:</td><td><select id="representante" name="representante" class="span3">
				<option value=""></option>
				<?php 
                $sql=mysqli_query($con,"SELECT * FROM usuario WHERE cargo='VENDEDOR' AND activo='SI'");
                while($row=mysqli_fetch_assoc($sql)){ ?>
                  <option value="<?php echo $row['nombre']?>"><?php echo $row['nombre']?></option>
                <?php } ?>
			</select></td></tr>
			<tr><td>TELEFONO:</td><td><input type="text" name="telefono" id="telefono" class="span3" maxlength="100"/></td></tr>
			<tr><td>NOM TIENDA:</td><td><input type="text" name="mail" id="mail" class="span3"/></td></tr>
			<tr><td>LIMITE CREDITO:</td><td><input type="text" name="credito" id="credito" class="span3"/></td></tr>
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
		<h3 style="text-align: center;margin-bottom:-10px;margin-top:-2px">REGISTRO DE CLIENTES</h3>
	<div id="boton">
		RUC/CLIENTE:<input type="text" id="busqueda" name="busqueda" class="span3" placeholder="Realize su Busqueda..." style="text-transform:uppercase;margin-right:10px"/>
		ACTIVO:<select id='selactivo' class='span1'>
			<option value='SI'>SI</option>
			<option value='NO'>NO</option>
		</select>
		PROMOTOR:<select id="promotor" name="promotor" class="span2">
				<option value=""></option>
				<?php 
                $sql=mysqli_query($con,"SELECT * FROM usuario WHERE cargo='VENDEDOR' AND activo='SI'");
                while($row=mysqli_fetch_assoc($sql)){ ?>
                  <option value="<?php echo $row['nombre']?>"><?php echo $row['nombre']?></option>
                <?php } ?>
			</select>
		UBICACION:<select id="ubicacion" name="ubicacion" class="span2">
				<option value=""></option>
				<?php 
                $sql=mysqli_query($con,"SELECT * FROM ubicacion WHERE activo='SI'");
                while($row=mysqli_fetch_assoc($sql)){ ?>
                  <option value="<?php echo $row['ubicacion']?>"><?php echo $row['ubicacion']?></option>
                <?php } ?>
			</select>
			<?php if($_SESSION['cargo']=='ADMIN'){ ?>
		<button id="eliminar" class="btn btn-success" title="Seleccione una fila para Eliminar" style="float: right; margin: 0 7px 20px 0;">Eliminar</button>
		<button id="editar" class="btn btn-success" title="Seleccione una fila para Editar" style="float: right; margin: 0 7px 20px 0;">Editar</button>
		<?php }else{ ?>
		<button id="eliminar" class="btn btn-success disabled" title="Seleccione una fila para Eliminar" style="float: right; margin: 0 7px 20px 0;">Eliminar</button>
		<button id="editar" class="btn btn-success disabled" title="Seleccione una fila para Editar" style="float: right; margin: 0 7px 20px 0;">Editar</button>
		<?php } ?>
		<button id="agregar" class="btn btn-success" title="Agregar Datos" style="float: right; margin: 0 7px 20px 0; ">Agregar</button>
	</div>
	<table class="table table-bordered">
		<thead>
			<tr style='background-color:#428bca;color:white'>
				<th style="text-align: center;width:3%">MAPA</th>
				<th style="text-align: center;width:10%">RUC</th>
				<th style="text-align: center;width:20%">CLIENTE</th>
				<th style="text-align: center;width:20%">DIRECCION</th>
				<th style="text-align: center;width:7%">TIPO</th>
				<th style="text-align: center;width:5%">CREDITO</th>
				<th style="text-align: center;width:10%">REPRESENTANTE</th>
				<th style="text-align: center;width:10%">TELEFONO</th>
				<th style="text-align: center;width:10%">NOM TIENDA</th>
				<th style="text-align: center;width:5%">ACTIVO</th>
			</tr>
		</thead>
		<tbody id="resultado">  
         
      	</tbody>
      	<tfoot id='foot'>
	        <tr>
	          <td colspan='13'>
	            <div style='float:left;margin-bottom:-10px'>
	              <select id='pagina' style='width:70px'>
	                <option>12</option>
	                <option>20</option>
	                <option>50</option>
	                <option>100</option>
	              </select> 
	            </div>
	            <div >
	              <div id='primero' style='position:absolute;display:none;margin-left:500px;'><input type='button' value='|<' class="btn btn-primary"></div>
	              <div id='anterior' style='position:absolute;display:none;margin-left:550px;'><input type='button' value='<' class="btn btn-primary"></div>
	              <div style='position:absolute;margin-left:600px;'>Página  <input id='numero' type='text' value='1' class="btn span1" style='cursor:text'> de <span id='cant'></span></div>
	              <div id='siguiente' style='position:absolute;margin-left:770px;'><input type='button' value='>' class="btn btn-primary"></div>
	              <div id='ultimo' style='position:absolute;margin-left:820px;'><input type='button' value='>|' class="btn btn-primary"></div>
	            </div>
	            <div style="float:right;color:red;font-weight:bold;" id='cantidad'></div>
	            <div style="float:right;">Total de Clientes Registrados:   </div>
	          </td>
	        <tr>
	    </tfoot>
	</table> 
	<div id='dialog'></div>
	</div>
</body>
</html>