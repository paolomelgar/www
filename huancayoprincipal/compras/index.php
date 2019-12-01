<!DOCTYPE html>
<?php 
session_start();
if($_SESSION['valida']=='huancayoprincipal' && $_SESSION['cargo']=='ADMIN' || $_SESSION['cargo']=='ENCARGADOTIENDA' || $_SESSION['cargo']=='LOGISTICA' || $_SESSION['cargo']=='FRANQUICIA' || $_SESSION['cargo']=='ASISTENTE'){
?>
<html>
<head>
  <title>COMPRAS</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" /> 
<link type="text/css" href="../bootstrap.min.css" rel="stylesheet" />
<link type="text/css" href="../jquery-ui-1.10.4.custom.min.css" rel="stylesheet" />
<link type="text/css" href="../sweet-alert.css" rel="stylesheet" />
<script type="text/javascript" src="../jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="../jquery-ui-1.10.4.custom.min.js"></script>  
<script type="text/javascript" src="../sweet-alert.min.js"></script> 
<script type='text/javascript' src='../picnet.table.filter.min.js'></script> 
<script src="../Chart.min.js"></script>
<script type="text/javascript" src="compras.js"></script>
<style>
  body{
    width:100%;
    margin-left: auto;
    margin-right: auto;
  }
  input,textarea{
    text-transform: uppercase;
  }
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
    background: #FF3 !important;
  }
  .select {
    background: #F63 !important;
  }
  .mayorstock {
    background-color: #d9534f !important;
    border-color: #d43f3a !important;
    color:white !important;
    font-weight: bold;
  }
  #datoscliente {
    background-color: #2E9AFE;
    position: absolute;
    display: none;
    margin:4px auto auto -110px;
    border: solid 1px #2d4b7c;
    border-radius: .5em;
    width: 260px;
    height: 140px;
    z-index: 2;
  }
  #datosproductos {
    background-color: #2E9AFE;
    position: absolute;
    display: none;
    margin:4px auto auto -150px;
    border: solid 1px #2d4b7c;
    border-radius: .5em;
    width: 260px;
    height: 140px;
    z-index: 2;
    cursor: move;
  }
  #dialogver {
    position: absolute;
    display: none;
    border: solid 1px #2d4b7c;
    border-radius: .5em;
    right:0px;
    width: 900px;
    height: 480px;
    z-index: 3;
    box-shadow: 5px 5px 2px grey;
  }
  #dialogestadistica {
    background-color: #D1FCC2;
    position: absolute;
    display: none;
    margin: 0px auto auto -800px;
    border: solid 1px #2d4b7c;
    border-radius: .5em;
    width: 900px;
    height: 450px;
    z-index: 4;
    cursor: move;
    box-shadow: 5px 5px 2px grey;
  }
  #dialogsunat {
    position: absolute;
    display: none;
    margin: 160px auto auto 140px;
    width: 900px;
    height: 440px;
    z-index: 3;
    cursor: move;
    box-shadow: 5px 5px 2px grey;
  }
  .ui-widget{
  font-family: "Times New Roman";
  }  
  .ui-dialog .ui-dialog-title {
    text-align: center;
    width: 100%;
  }
  a.external:link{text-decoration:none;font-weight:bold;color:blue;font-size: 18px;}
  a.external:visited{text-decoration:none;font-weight:bold;color:blue;font-size: 18px;}
  a.button:link{text-decoration:none;font-weight:bold;color:black;font-size: 17px;}
  a.button:visited{text-decoration:none;font-weight:bold;color:black;font-size: 17px;}
  ::-webkit-scrollbar{
    width: 7px;  /* for vertical scrollbars */
  }
  ::-webkit-scrollbar-track{
    background: rgba(0, 0, 0, 0);
  }
  ::-webkit-scrollbar-thumb{
    background: rgba(0, 0, 0, 0.5);
  }
  .editme1:focus {
    background-color: white;
  }
  .editme2:focus {
    background-color: white;
  }
  .editme3:focus {
    background-color: white;
  }
  .text:focus {
    background-color: white;
  }
  input{
    margin-bottom: 0px !important;
  }
  #listcliente {
    table-layout: fixed;
    box-shadow: 5px 5px 2px grey;
  }
  #listcliente td,th {
  white-space: nowrap;overflow: hidden;
  }
  #listanterior {
    table-layout: fixed;
  }
  #listanterior td,th {
    white-space: nowrap;overflow: hidden;
  }
  .fila:hover{
    background: #FF3;
    cursor:pointer;
  }
  .error {
      width:300px;
      height:20px;
      height:auto;
      position:absolute;
      left:50%;
      margin-left:-100px;
      bottom:10px;
      background-color: #383838;
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
  <input type='hidden' value='<?php echo $_SESSION['cargo']?>' id='cargo'>
  <div class='error' style='display:none'>Guardado Correctamente</div>
  <form id="form" name="form" action="" method="post" autocomplete="off">
    <input type='text' id='vendedor' value="<?php echo $_SESSION['nombre']?>" readonly='readonly' style='position:absolute;top:5px;right:2px;text-align:center' class='span2'>
    <h3 style='color:white;text-align:center;margin-top:0px;margin-bottom:0px;' class='btn-success'>COMPRAS</h3>
    <div id='dialogsunat' class='btn btn-info'></div>
    <div id="resultruc" style='position:absolute;display:none;width:70%'>
      <table id='listcliente' class='table table-bordered table-condensed'>
        <thead>
          <tr bgcolor="#428bca" style="color:#FFF; text-align:center;">
            <th width='12%' style="text-align:center">RUC</th>
            <th width='33%' style="text-align:center">CLIENTE</th>
            <th width='45%' style="text-align:center">DIRECCION</th>
          </tr>
        </thead>
        <tbody id="tb">
        </tbody>
      </table>
    </div>
    <div id="informacion">
      <table width="99%" border="0" align='center' cellspacing="1">
        <tr>
          <td align="right" width='10%'>
            Documento:
          </td>
          <td width='30%'>
            <select name="documento" id="documento" class='span2' style='margin-bottom: 0px;'>
              <option value="0">---------------</option>
              <option value="FACTURA INNOVA">FACTURA INNOVA</option>
              <option value="FACTURA BOOM">FACTURA BOOM</option>              
              <option value="NOTA DE PEDIDO">NOTA DE PEDIDO</option>              
            </select>
            <input type='text' id='serie' name='serie' style='text-align:right;display:none;width:27px'>
            <input type='text' id='numero' name='numero' class='span1' style='text-align:right;display:none'>
          </td>
          <td width='20%'>
            Cond Pago:
            <select class='span2' id="forma-pago" name="forma-pago" style='margin-bottom: 0px;'>
              <option value="CREDITO" style="display:none">CREDITO</option>
            </select>
          </td>
          <td width='15%'>  
            <span style="display:none" class="pago">F. Pago:<input type="text" name="fechapago" id="fechapago" style="cursor:pointer;font-weight:bold;text-align:right;width:80px;"></span>
          </td>
          <td width='25%'></td>
        </tr>
        <tr bgcolor="#FFFF00">
          <td align="left" colspan="4"><strong style="color:#000; font-size:18px; text-align:left">DATOS DEL PROVEEDOR</strong></td>
          <td>
            FECHA:<input type="text" name="fecha" id="fecha" style="cursor:pointer;font-weight:bold;text-align:right;width:80px">
          </td>
        </tr>
        <tr>
          <td align="right">RUC:</td>
          <td>
            <input type="text" name="ruc" id="ruc" class='span2 ruc' maxlength="11"/>
            <img src="../caja/sunat.jpg" style="width:60px;display:none;cursor:pointer" id='sunat'/>
          </td>
          <td colspan='2'>Billete:
            <select id='billete' name='billete' style='border: solid 2px red;margin-bottom: 0px;width:110px'>
              <option value='SOLES'>SOLES</option>
              <option value='DOLARES'>DOLARES</option>
            </select>
            <input type='text' id='cambio' name='cambio' style='display:none;border:solid 1px red;text-align:right' class='span1'>
          </td>
          <td>
            <a href="../compras" class="external">Nueva Ventana</a>
          </td>
        </tr>
        <tr>
          <td align="right">RAZON SOCIAL:</td>
          <td colspan='3'>
            <input type="text" name="razon_social" id="razon_social" class='span5 ruc'/>
          </td>
          <td>
            <input type="button" value="VER" id="ver" style="cursor:pointer;" class='btn btn-info'>
            <div id="dialogver" style="display:none" class='btn-info'>
              <table width="100%" align="center">
                <tr>
                  <td>PROVEEDOR:<input type='text' class='span3' id='prov'></td>
                  <td>FECHA INICIO:<input type="text" id="fechaini" style="cursor:pointer;font-weight:bold;text-align:right;width:80px"></td>
                  <td>FECHA FIN:<input type="text" id="fechafin" style="cursor:pointer;font-weight:bold;text-align:right;width:80px"></td>
                  <td><input type="button" id="buscar" value="Buscar" class='btn btn-primary'/></td>
                  <td><span class='ui-icon ui-icon-circle-close' id='salir' style=';cursor:pointer'></td>
                </tr>
              </table>
              <div id="listapedido">
                <table width="98%" align="center">
                  <thead>
                    <tr bgcolor="black" style="color:#FFF; text-align:center;font-weight:bold">
                      <th width="5%"></th>
                      <th width="8%">SERIE</th>
                      <th width="12%">FECHA</th>
                      <th width="15%">DOCUMENTO</th>
                      <th width="30%">PROVEEDOR</th>
                      <th width="10%">PAGO</th>
                      <th width="10%">ENTREG</th>
                      <th width="10%">TOTAL</th>
                      <th style='display:none'></th>
                    </tr>
                  </thead>
                </table>
                <div style="overflow-y:overlay;overflow-x:hidden;height:380px;align:center;color:black;width:98%;margin:auto;font-size:11px;font-family:Verdana;" class='par'>
                  <table width="100%" align="center" id='ventas'>
                    <thead>
                      <tr style='display:none;'>
                        <th width="5%">VER</th>
                        <th width="8%">SERIE</th>
                        <th width="12%">FECHA</th>
                        <th width="15%">DOCUMENTO</th>
                        <th width="30%">PROVEEDOR</th>
                        <th width="10%">PAGO</th>
                        <th width="10%">ENTREG</th>
                        <th width="10%">TOTAL</th>
                        <th style='display:none'></th>
                      </tr>
                    </thead>
                    <tbody id="verbody">
                    </tbody>
                  </table>
                </div>
              </div>
              <table width='98%' align='center' style='color:black' class='impar'>
                <tr style="font-size:12px;font-weight:bold">
                  <td width='88%' align='right'>TOTAL:</td>
                  <td width='12%' style="text-align:right;font-size:14px;padding-right:10px;border:1px solid #B1B1B1" id='sumatotal'></td>
                </tr>
             </table>
              <div id='observarpedido'></div>
            </div>
          </td>
        </tr>
        <tr>
          <td scope="row" align="right">DIRECCION:</td>
          <td colspan="3">
            <input type="text" name="direccion" id="direccion" class='span8'/>
          </td>
          <td>
            <img src='../estad.png' width='30px' style='margin-left:20px;cursor:pointer;' id='estadistica'>
            <div id="dialogestadistica" style='background-color:#ff3'>
              <table width='100%'>
                <tr>
                  <td>PROVEEDOR:<input type="text" class='span6' id="clienteestadistica"></td>
                  <td><span class='ui-icon ui-icon-circle-close' id='salir2' style='cursor:pointer'></td>
                </tr>
                <tr>
                  <td colspan='2'>
                    <canvas id="trChart" width="900" height="400" align='center'></canvas>
                  </td>
                </tr>
              </table>
            </div>
          </td>
        </tr>
      </table>
    </div>
    <div id="loading" style='display:none;text-align:center'>
      <p>Procesando Compra...</p>
      <p><img src="../loading.gif" height='100px'></p>
    </div>
    <div id='precios' style='display:none'>
      <table class='table table-bordered'>
        <tr style='background-color:#2E9AFE;font-weight:bold;color:white'>
          <td style='text-align:center'>P.ANTERIOR</td>
          <td style='text-align:center'>P.ACTUAL</td>
          <td style='text-align:center;background-color:#FE3F33'>P.FRAN</td>
          <td style='text-align:center;background-color:#F7EC0F'>P.MAY</td>
          <td style='text-align:center;background-color:#F7EC0F'>P.PROM</td>
          <td style='text-align:center;background-color:#0FC6F7'>P.T.MAY</td>
          <td style='text-align:center;background-color:#0FC6F7'>P.T.PUB1</td>
        </tr>
        <tr>
          <td id='iden' style='display:none'></td>
          <td id='1' style='text-align:right'></td>
          <td id='2' style='text-align:right'></td>
          <td id='3' contenteditable='true' class='text' style='text-align:right'></td>
          <td id='4' contenteditable='true' class='text' style='text-align:right'></td>
          <td id='5' contenteditable='true' class='text' style='text-align:right'></td>
          <td id='6' contenteditable='true' class='text' style='text-align:right'></td>
          <td id='7' contenteditable='true' class='text' style='text-align:right'></td>
        </tr>
        <tr>
          <td colspan='2' style='text-align:right'>PORCENTAJE:</td>
          <td id='11' style='text-align:right'></td>
          <td id='12' style='text-align:right'></td>
          <td id='13' style='text-align:right'></td>
          <td id='14' style='text-align:right'></td>
          <td id='15' style='text-align:right'></td>
        </tr>
      </table>
    </div>
    <div id="result" style='position:absolute;width:50%;display:none;z-index:2'>
      <table id='listcliente' class='table table-bordered table-condensed'>
        <thead>
          <tr bgcolor="#428bca" style="color:#FFF;text-align:center;font-size:13px">
            <th width="4%">IMG</th>
            <th width="50%">PRODUCTO</th>
            <th width="20%">MARCA</th>
            <th width="10%">P. COM</th>
            <th width="8%">X/CAJA</th>
            <th width="8%">S. REAL</th>
          </tr>
        </thead>
        <tbody id="tb1">
        </tbody>
      </table>
    </div>
    <div>
      <table align="center" width="98%" >
        <thead>
          <tr style="background-color:#5cb85c;color:white;font-weight:bold;" >
            <th width="68%" style="text-align:center" colspan='3'>PRODUCTO</th>
            <th width="10%" style="text-align:center">CANTIDAD</th>
            <th width="10%" style="text-align:center">P. UNITARIO</th>
            <th width="10%" style="text-align:center">IMPORTE</th>
            <th width="2%" style="text-align:center"></th>
          </tr>
          <tr>
            <td colspan='2'>
              <input type="text" id="busqueda" style="background-color: #F8FD8D;" class='span7'/>
            </td>
            <td></td>
            <td align='right'><input type="text" id="cantidad" style="text-align:right;background-color: #F8FD8D" class='span1'/></td>
            <td align='right'><input type="text" id="precio_u" style="text-align:right;background-color: #F8FD8D" class='span1'/></td>
            <td align='right'><input type="text" id="importe" style="text-align:right;background-color: #F8FD8D" class='span1'/><input type='hidden' id='id'></td>
            <td></td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td style="height:280px;padding:0px" colspan='7' valign='top'>
              <div style="height:280px;overflow:overlay;" id='roww'> 
                <table id="row" width="100%" class='table table-condensed'>
                </table> 
                </div>
            </td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <td>PORCENTAJE:<input type='text' id='porcentaje' class='span1'></td>
            <td>ENTREGADO <select id='entregado' name="entregado" style='border: solid 2px red;' class='span1'>
              <?php if($_SESSION['cargo']=='ADMIN' || $_SESSION['cargo']=='ENCARGADOTIENDA' || $_SESSION['cargo']=='LOGISTICA'){ ?>
              <option value="SI">SI</option>
              <?php } ?>
              <option value="NO">NO</option>
            </td>
            <td id="cantprod" style='color:red;font-weight:bold'></td>
            <td align="right">SUBTOTAL<br><input type="text" id="subtotal" name="subtotal" value="0.00" readonly="readonly" style='font-weight:bold;text-align:right;width:70px'></td>
            <td align="right">FLETE<br><input class='span1' type="text" name="flete" id="flete" value="0.00" style='font-weight:bold;text-align:right'></td>
            <td align="right">TOTAL<br><input type="text" name="total" id="total" value="0.00" readonly="readonly" style='font-weight:bold;text-align:right;width:70px'></td>
          </tr>
        </tfoot>
      </table>
    </div>
    <div id="anterior" style='position:absolute;bottom:5px;margin: auto;width:900px;height:90px;left:0;right:0;display:none;background-color:#FBEFEF;border:1px solid black;box-shadow: 5px 5px 2px grey;'>
      <div id='ant' style='width:900px;height:90px;overflow:overlay;'></div>
      <span class='ui-icon ui-icon-circle-close' id='saliranterior' style='position:absolute;cursor:pointer;right:0px;top:0px'></span>
    </div>
    <div>
      <table width="98%" id="areacoment" align='center'>
        <tr>
          <td width="85%">
            COMENTARIOS:<textarea name="comentarios" id="comentario" style="text-transform:uppercase;" class='span8'></textarea>
          </td>
          <td width="15%"><input type="button" id="guardarform" value="ENVIAR" style="cursor:pointer;" class='btn btn-success'/></td>
          </div>
        </tr>
      </table>
    </div>
  </form>
  <div style='display:none' id="agregardatos">
    <form name="formagregar" id="formagregar">
      <table width='100%'>
        <tr><td><input type="hidden" name="id"/></td></tr>
        <tr><td>PRODUCTO:</td><td><input type="text" id='producto' name="producto" class="span3" style="float:left;"/></td></tr>
        <tr><td>MARCA:</td><td><input type="text" id='marca' name="marca" class="span3" style="float:left;"/></td></tr>
        <tr><td>CATEGORIA:</td><td><select name="familia" class="span3" style='margin-bottom:0px'>
              <?php 
                  require_once('../connection.php');
                  $sql=mysqli_query($con,"SELECT * FROM familia WHERE activo='SI'");
                  while($row=mysqli_fetch_assoc($sql)){ ?>
                    <option value="<?php echo $row['familia']?>"><?php echo $row['familia']?></option>
                  <?php } ?> 
        </select></td></tr>
        <tr><td>ACTIVO:</td><td><select name="activo1" class="span3" style='margin-bottom:0px'>
          <option value="SI">SI</option>
          <option value="NO">NO</option>
          <option value="OFERTA">OFERTA</option>
        </select></td></tr>
        <tr><td>IMAGEN:</td><td><input type="file" name="imagen" class="span3" accept="image/jpeg"/></td></tr>
      </table>
    </form>
  </div>
</body>
</html>
<?php }else{
  header("Location: ../");
} ?>


