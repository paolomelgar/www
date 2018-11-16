<!DOCTYPE html>
<?php 
session_start();
if($_SESSION['valida']=='huanuco' && $_SESSION['cargo']=='ADMIN' || $_SESSION['cargo']=='CAJERO'){
?>
<html lang="es">
<head>
  <title>PRODUCTOS</title>
  <meta charset="utf-8" />
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
    a#add:link{text-decoration:none;font-weight:bold;color:red;font-size: 18px;}
    a#add:visited{text-decoration:none;font-weight:bold;color:red;font-size: 18px;}
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
  </style>
</head>
<body>
  <div class='error' style='display:none'>Guardado Correctamente</div>
  <div style='display:none' id="agregardatos">
  <form name="formagregar" id="formagregar" autocomplete="off">
    <table width='100%'>
      <tr><td width='25%'><input type="hidden" name="codigo"/></td></tr>
      <tr><td width='25%'>PRODUCTO:</td><td width='75%'><input type="text" name="producto" class="span3" style="float:left;"/></td></tr>
      <tr><td width='25%'>MARCA:</td><td width='75%'><input type="text" name="marca" id='marca' class="span3" style="float:left;"/><a id='add' href='#'>ADD</a></td></tr>
      <tr><td width='25%'>CATEGORIA:</td><td width='75%'><select name="familia" class="span3">
            <?php 
                require_once('../connection.php');
                $sql=mysqli_query($con,"SELECT * FROM familia WHERE activo='SI'");
                while($row=mysqli_fetch_assoc($sql)){ ?>
                  <option value="<?php echo $row['familia']?>"><?php echo $row['familia']?></option>
                <?php } ?> 
      </select></td></tr>
      <tr><td width='25%'>PROVEEDOR:</td><td width='75%'><input type="text" name="proveedor" id='proveedor' class="span3" style="float:left;"/></td></tr>
      <tr><td width='25%'>ACTIVO:</td><td width='75%'><select name="activo1" class="span3">
        <option value="SI">SI</option>
        <option value="NO">NO</option>
        <option value="OFERTA">OFERTA</option>
      </select></td></tr>
      <tr><td width='25%'>IMAGEN:</td><td width='75%'><input type="file" name="imagen" class="span3" accept=".jpg" id='upload'/></td></tr>
    </table>
  </form>
  </div>
  <div class="hide" id="eliminardatos">
    <p><span class="ui-icon ui-icon-alert" style="float: left; margin: 0 7px 20px 0;"></span>Este registro se borrará de forma permanente. ¿Esta seguro?</p>
  </div>
  <div id="body">
    <h3 style="text-align: center;color:#428bca;margin-top:-2px;font-weight:bold">REGISTRO DE PRODUCTOS</h3>
    <div id="boton">
      PRODUCTO:<input type="text" id="busqueda" name="busqueda" class="span3" placeholder="Buscar..." style="margin-right:10px" autocomplete="off"/>
      PROVEEDOR:<input type="text" id="prov" name="prov" class="span3" placeholder="Buscar..." style="margin-right:10px" autocomplete="off"/>
      ACTIVO:<select id='selactivo' class='span1'>
        <option value='SI'>SI</option>
        <option value='NO'>NO</option>
        <option value='OFERTA'>OFERTA</option>
      </select>
      CONTABLE:<select id='contable' class='span1' style='width:90px'>
        <option value='NADA'></option>
        <option value='CONT'>CONT</option>
      </select>
      <?php if($_SESSION['cargo']=='ADMIN'){ ?>
      <button id="eliminar" class="btn btn-success" style="float: right; margin: 0 7px 20px 0;">Eliminar</button>
      <button id="editar" class="btn btn-success" style="float: right; margin: 0 7px 20px 0;">Editar</button>
      <button id="agregar" class="btn btn-success" style="float: right; margin: 0 7px 20px 0; ">Agregar</button>
      <?php }else{ ?>
      <button id="eliminar" class="btn btn-success" disabled="disabled" style="float: right; margin: 0 7px 20px 0;">Eliminar</button>
      <button id="editar" class="btn btn-success" disabled="disabled" style="float: right; margin: 0 7px 20px 0;">Editar</button>
      <button id="agregar" class="btn btn-success" disabled="disabled" style="float: right; margin: 0 7px 20px 0; ">Agregar</button>
      <?php } ?>
      <!--<button id="catalogo" class="btn btn-warning" style="float: right; margin: 0 7px 20px 0;">Catalogo</button>-->
    </div>
    <table class="table table-bordered">
      <thead>
          <tr style='background-color:#428bca;color:white'>
              <th style="text-align: center;width:2.7%;max-width:36px">IMG</th>
              <th style="text-align: center;width:5%">CODIGO</th>
              <th style="text-align: center;width:17.3%">PRODUCTO</th>
              <th style="text-align: center;width:7%">MARCA</th>
              <th style="text-align: center;width:9%">CATEGORIA</th>
              <th style="text-align: center;width:10%">PROVEEDOR</th>
              <th style="text-align: center;width:5%">X/CAJA</th>
              <th style="text-align: center;width:5%">S.REAL</th>
              <th style="text-align: center;width:5%">S.CONT</th>
              <th style="text-align: center;width:5%">P.MAYOR</th>
              <th style="text-align: center;width:5%">P.ESP</th>
              <th style="text-align: center;width:5%">P.OFERTA</th>
              <th style="text-align: center;width:5%">P.COMPRA</th>
              <th style="text-align: center;width:6%">U.COMPRA</th>
              <th style="text-align: center;width:5%">FRAN</th>
              <th style="text-align: center;width:4%">ACTIVO</th>
          </tr>
      </thead>
      <tbody id="resultado">  
         
      </tbody>
      <tfoot id='foot'>
        <tr>
          <td colspan='100'>
            <div style='float:left;margin-bottom:-10px'>
              <select id='pagina' style='width:70px'>
                <option>12</option>
                <option>20</option>
                <option>50</option>
                <option>100</option>
              </select> 
            </div>
            <?php if($_SESSION['cargo']=='ADMIN'){ ?>
            <div style='float:left;margin-top:5px;margin-left:100px;font-size:25px;font-weight:bold;color:blue'>
              <?php 
                $sql=mysqli_query($con,"SELECT SUM(p_compra*stock_real) FROM producto");
                $row=mysqli_fetch_row($sql);
                echo "S/ ".$row[0];
              ?>
            </div>
            <?php } ?>
            <div>
              <div id='primero' style='position:absolute;margin-left:500px;'><input type='button' value='|<' class="btn btn-primary"></div>
              <div id='anterior' style='position:absolute;margin-left:550px;'><input type='button' value='<' class="btn btn-primary"></div>
              <div style='position:absolute;margin-left:600px;'>Página  <input id='numero' type='text' value='1' class="btn span1" style='cursor:text' autocomplete="off"> de <span id='cant'></span></div>
              <div id='siguiente' style='position:absolute;margin-left:770px;'><input type='button' value='>' class="btn btn-primary"></div>
              <div id='ultimo' style='position:absolute;margin-left:820px;'><input type='button' value='>|' class="btn btn-primary"></div>
            </div>
            <div style="float:right;color:red;font-weight:bold;margin-top:5px;font-size:20px" id='cantidad'></div>
            <div style="float:right;margin-top:5px;">Total de Productos Registrados:   </div>
          </td>
        <tr>
      </tfoot>
    </table>
  </div>
  <div id='dx'></div>
</body>
</html>
<?php }else{
  header("Location: ../");
} ?>