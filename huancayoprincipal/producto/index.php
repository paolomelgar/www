<!DOCTYPE html>
<?php 
require_once('../connection.php');
if($_SESSION['valida']=='huancayoprincipal' && $_SESSION['cargo']=='ADMIN' || $_SESSION['cargo']=='ENCARGADOTIENDA' || $_SESSION['cargo']=='LOGISTICA' || $_SESSION['cargo']=='FRANQUICIA'){
?>
<html lang="es">
<head>
	<title>PRODUCTOS</title>
	<meta charset="utf-8" />
  <link rel="shortcut icon" href="../favicon.ico"/>
	<link type="text/css" href="../bootstrap.min.css" rel="stylesheet" />
	<link type="text/css" href="../jquery-ui-1.10.4.custom.min.css" rel="stylesheet" />
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
    .text:focus {
      background-color: white;
      color:black;
    }
    input{
      text-transform:uppercase;
    }
    .tr:hover{
      background-color: #FF3;
    }
    a#add:link{
      text-decoration:none;font-weight:bold;color:red;font-size: 18px;
    }
    a#add:visited{
      text-decoration:none;font-weight:bold;color:red;font-size: 18px;
    }
    .error {
      width:300px;
      height:20px;
      height:auto;
      position:absolute;
      left:50%;
      margin-left:-100px;
      bottom:10px;
      background-color: black;
      color: #F0F0F0;
      font-family: Calibri;
      font-size: 20px;
      padding:10px;
      text-align:center;
      border-radius: 2px;
      z-index:1000;
      -webkit-box-shadow: 0px 0px 24px -1px rgba(56, 56, 56, 1);
      -moz-box-shadow: 0px 0px 24px -1px rgba(56, 56, 56, 1);
      box-shadow: 0px 0px 24px -1px rgba(56, 56, 56, 1);
      pointer-events:none;
      opacity:0.5;
    }
    .error1 {
      width:300px;
      height:50px;
      height:auto;
      position:absolute;
      left:50%;
      margin-left:-100px;
      bottom:10px;
      background-color: red;
      color: #F0F0F0;
      font-family: Calibri;
      font-size: 20px;
      padding:10px;
      text-align:center;
      border-radius: 2px;
      z-index:1000;
      -webkit-box-shadow: 0px 0px 24px -1px rgba(56, 56, 56, 1);
      -moz-box-shadow: 0px 0px 24px -1px rgba(56, 56, 56, 1);
      box-shadow: 0px 0px 24px -1px rgba(56, 56, 56, 1);
    }
  </style>
</head>
<body>
	<div class='error' style='display:none'>Guardado Correctamente</div>
  <div class='error1' style='display:none'>El Precio del Producto no puede Estar debajo del Precio de Compra</div>
  <div style='display:none' id="agregardatos">
  <form name="formagregar" id="formagregar">
    <table width='100%'>
      <tr><td width='25%'><input type="hidden" name="codigo"/></td></tr>
      <tr><td width='25%'>PRODUCTO:</td><td width='75%'><input type="text" name="producto" class="span3" style="float:left;"/></td></tr>
      <tr><td width='25%'>MARCA:</td><td width='75%'><input type="text" name="marca" id='marca' class="span3" style="float:left;"/><a id='add' href='#'>ADD</a></td></tr>
      <tr><td width='25%'>CATEGORIA:</td><td width='75%'><select name="familia" class="span3">
            <?php 
                $sql=mysqli_query($con,"SELECT * FROM familia WHERE activo='SI'");
                while($row=mysqli_fetch_assoc($sql)){ ?>
                  <option value="<?php echo $row['familia']?>"><?php echo $row['familia']?></option>
                <?php } ?> 
      </select></td></tr>
      <tr><td width='25%'>ACTIVO:</td><td width='75%'><select name="activo1" class="span3">
        <option value="SI">SI</option>
        <option value="NO">NO</option>
        <option value='UNIDAD'>UNIDAD</option>
        <option value="OFERTA">OFERTA</option>
      </select></td></tr>
      <tr><td width='25%'>IMAGEN:</td><td width='75%'><input type="file" name="imagen" class="span3" accept="image/jpeg"/></td></tr>
    </table>
  </form>
  </div>
  <div class="hide" id="eliminardatos">
    <p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>Este registro se borrará de forma permanente. ¿Esta seguro?</p>
  </div>
	<div id="body">
		<h3 style="text-align: center;color:#428bca;margin-top:-2px;font-weight:bold">REGISTRO DE PRODUCTOS</h3>
    <div id="boton">
      PRODUCTO:<input type="text" id="busqueda" name="busqueda" class="span5" placeholder="Buscar..." style="margin-right:10px" autocomplete="off"/>
      PROVEEDOR:<input type="text" id="prov" name="prov" class="span3" placeholder="Buscar..." style="margin-right:10px" autocomplete="off"/>
      ACTIVO:<select id='selactivo' class='span1'>
        <option value='SI'>SI</option>
        <option value='NO'>NO</option>
        <option value='UNIDAD'>UNIDAD</option>
        <option value='OFERTA'>OFERTA</option>
      </select>
      <?php if($_SESSION['nombre']=='PAULO ANTONY MELGAR POVEZ' || $_SESSION['nombre']=='PAUL MELGAR'){ ?>
      <button id="eliminar" class="btn btn-success" style="float: right; margin: 0 7px 20px 0;">Eliminar</button>
      <button id="editar" class="btn btn-success" style="float: right; margin: 0 7px 20px 0;">Editar</button>
      <button id="agregar" class="btn btn-success" style="float: right; margin: 0 7px 20px 0; ">Agregar</button>
      <?php } else{ ?>
      <?php if($_SESSION['cargo']=='ADMIN'){ ?>
      <button id="eliminar" class="btn btn-success" disabled="disabled" style="float: right; margin: 0 7px 20px 0;">Eliminar</button>
      <button id="editar" class="btn btn-success" style="float: right; margin: 0 7px 20px 0;">Editar</button>
      <button id="agregar" class="btn btn-success" style="float: right; margin: 0 7px 20px 0; ">Agregar</button>
      <?php }else if ($_SESSION['cargo']=='FRANQUICIA'){ ?>
      <button id="eliminar" class="btn btn-success disabled" disabled="disabled" style="float: right; margin: 0 7px 20px 0;">Eliminar</button>
      <button id="editar" class="btn btn-success disabled"  disabled="disabled" style="float: right; margin: 0 7px 20px 0;">Editar</button>
      <button id="editar" class="btn btn-success disabled"  disabled="disabled"style="float: right; margin: 0 7px 20px 0;">Agregar</button>
      <?php }else { ?>
      <button id="eliminar" class="btn btn-success disabled"  disabled="disabled" style="float: right; margin: 0 7px 20px 0;">Eliminar</button>
      <button id="editar" class="btn btn-success" style="float: right; margin: 0 7px 20px 0;">Editar</button>
      <button id="agregar" class="btn btn-success" style="float: right; margin: 0 7px 20px 0; ">Agregar</button>
      <?php }} ?>      
      <!--<button id="catalogo" class="btn btn-warning" style="float: right; margin: 0 7px 20px 0;">Catalogo</button>-->
    </div>

    <?php if($_SESSION['cargo']!='FRANQUICIA'){ ?>

  	<table class="table table-bordered">
      <thead>
          <tr style='background-color:#428bca;color:white'>
              <th style="text-align: center;width:1.5%"></th>
              <th style="text-align: center;width:4%">CODIGO</th>
              <th style="text-align: center;width:20%">PRODUCTO</th>
              <th style="text-align: center;width:8%">MARCA</th>
              <th style="text-align: center;width:5%">FAMILIA</th>
              <th style="text-align: center;width:8%">PROVEEDOR</th>
              <th style="text-align: center;width:4%">UBICACION</th>
              <th style="text-align: center;width:3%">CAJA</th>
              <th style="text-align: center;width:4%">MASTER</th>
              <th style="text-align: center;width:4%">S.REAL</th>
              <th style="text-align: center;width:2%">S.INNOVA</th>
              <th style="text-align: center;width:4%">S.BOOM</th>
              <th style="text-align: center;width:5%">P.COMPRA</th>
              <th style="text-align: center;width:4%;background-color:#FE3F33">P.FRAN</th>
              <th style="text-align: center;width:4%;background-color:#F7EC0F">P.MAY</th>
              <th style="text-align: center;width:4%;background-color:#F7EC0F">P.PROV</th>
              <th style="text-align: center;width:4%;background-color:#0FC6F7">P.T.MAY</th>
              <th style="text-align: center;width:4%;background-color:#0FC6F7">P.T.PUB1</th>
              <th style="text-align: center;width:4%">U.COMPRA</th>
              <th style="text-align: center;width:3%">ACTIVO</th>
          </tr>
      </thead>
      <tbody id="resultado">  
         
      </tbody>
      <tfoot id='foot'>
        <tr>
          <td colspan='30'>
            <div style='float:left;margin-bottom:-10px'>
              <select id='pagina' style='width:70px'>
                <option>12</option>
                <option>20</option>
                <option>50</option>
                <option>100</option>
              </select> 
            </div>
            <?php if($_SESSION['nombre']=='PAUL MELGAR' || $_SESSION['nombre']=='PAULO ANTONY MELGAR POVEZ' || $_SESSION['nombre']=='PAOLA MELGAR' || $_SESSION['nombre']=='DAVID PRESENTACION' || $_SESSION['nombre']=='WILMER MARQUEZ'){ ?>
            <div style='float:left;margin-top:5px;margin-left:100px;font-size:25px;font-weight:bold;color:blue'>
              <?php 
                $sql=mysqli_query($con,"SELECT SUM(p_compra*stock_real) FROM producto");
                $row=mysqli_fetch_row($sql);
                echo "S/ ".$row[0];
              ?>
            </div>
            <?php } ?>
            <div >
              <div id='primero' style='position:absolute;margin-left:500px;'><input type='button' value='|<' class="btn btn-primary"></div>
              <div id='anterior' style='position:absolute;margin-left:550px;'><input type='button' value='<' class="btn btn-primary"></div>
              <div style='position:absolute;margin-left:600px;'>Página  <input id='numero' type='text' value='1' class="btn span1" style='cursor:text'> de <span id='cant'></span></div>
              <div id='siguiente' style='position:absolute;margin-left:770px;'><input type='button' value='>' class="btn btn-primary"></div>
              <div id='ultimo' style='position:absolute;margin-left:820px;'><input type='button' value='>|' class="btn btn-primary"></div>
            </div>
            <div style="float:right;color:red;font-weight:bold;margin-top:5px;font-size:20px" id='cantidad'></div>
            <div style="float:right;margin-top:5px;">Total de Productos Registrados:   </div>
          </td>
        <tr>
      </tfoot>
    </table>

    <?php }else{?>
    
    <table class="table table-bordered">
      <thead>
          <tr style='background-color:#428bca;color:white'>
              <th style="text-align: center;width:1.5%"></th>
              <th style="text-align: center;width:4%">CODIGO</th>
              <th style="text-align: center;width:25%">PRODUCTO</th>
              <th style="text-align: center;width:12%">MARCA</th>
              <th style="text-align: center;width:8%">FAMILIA</th>
              <th style="text-align: center;width:5%">CAJA</th>
              <th style="text-align: center;width:5%">MASTER</th>
              <th style="text-align: center;width:7%">S.REAL</th>
              <th style="text-align: center;width:5%;background-color:#FE3F33">P.FRAN</th>
              <th style="text-align: center;width:6%;background-color:#F7EC0F">P.MAY</th>
              <th style="text-align: center;width:6%;background-color:#F7EC0F">P.PROV</th>
              <th style="text-align: center;width:5%;background-color:#0FC6F7">P.T.MAY</th>
              <th style="text-align: center;width:5%;background-color:#0FC6F7">P.T.PUB1</th>
              <th style="text-align: center;width:3%">ACTIVO</th>
          </tr>
      </thead>
      <tbody id="resultado">  
         
      </tbody>
      <tfoot id='foot'>
        <tr>
          <td colspan='30'>
            <div style='float:left;margin-bottom:-10px'>
              <select id='pagina' style='width:70px'>
                <option>12</option>
                <option>20</option>
                <option>50</option>
                <option>100</option>
              </select> 
            </div>
            <?php if($_SESSION['nombre']=='PAUL MELGAR' || $_SESSION['nombre']=='PAULO ANTONY MELGAR POVEZ' || $_SESSION['nombre']=='PAOLA MELGAR'){ ?>
            <div style='float:left;margin-top:5px;margin-left:100px;font-size:25px;font-weight:bold;color:blue'>
              <?php 
                $sql=mysqli_query($con,"SELECT SUM(p_compra*stock_real) FROM producto");
                $row=mysqli_fetch_row($sql);
                echo "S/ ".$row[0];
              ?>
            </div>
            <?php } ?>
            <div >
              <div id='primero' style='position:absolute;margin-left:500px;'><input type='button' value='|<' class="btn btn-primary"></div>
              <div id='anterior' style='position:absolute;margin-left:550px;'><input type='button' value='<' class="btn btn-primary"></div>
              <div style='position:absolute;margin-left:600px;'>Página  <input id='numero' type='text' value='1' class="btn span1" style='cursor:text'> de <span id='cant'></span></div>
              <div id='siguiente' style='position:absolute;margin-left:770px;'><input type='button' value='>' class="btn btn-primary"></div>
              <div id='ultimo' style='position:absolute;margin-left:820px;'><input type='button' value='>|' class="btn btn-primary"></div>
            </div>
            <div style="float:right;color:red;font-weight:bold;margin-top:5px;font-size:20px" id='cantidad'></div>
            <div style="float:right;margin-top:5px;">Total de Productos Registrados:   </div>
          </td>
        <tr>
      </tfoot>
    </table>

  <?php } ?>
  </div>
</body>
</html>
<?php }else{
  header("Location: ../");
} ?>