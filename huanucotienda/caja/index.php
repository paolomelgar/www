<!DOCTYPE html>
<?php 
session_start();
if($_SESSION['valida']=='huanucotienda' && $_SESSION['cargo']!='VENDEDOR' ){
?>
<html>
<head>
  <title>CAJA</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 
<link type="text/css" href="../bootstrap.min.css" rel="stylesheet" />
<link type="text/css" href="../jquery-ui-1.10.4.custom.min.css" rel="stylesheet" />
<link type="text/css" href="../sweet-alert.css" rel="stylesheet" />
<script type="text/javascript" src="../jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="../bootstrap.min.js"></script>
<script type="text/javascript" src="../jquery-ui-1.10.4.custom.min.js"></script>  
<script type='text/javascript' src='../picnet.table.filter.min.js'></script> 
<script type="text/javascript" src="../sweet-alert.min.js"></script>  
<script src="../Chart.min.js"></script>
<script src="../socket.io.js"></script>
<script type="text/javascript" src="caja.js"></script>
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
  #limitecredito {
    position: absolute;
    display: none;
    margin: -28px auto auto 500px;
    border-radius: .5em;
    width: 150px;
    height: 60px;
    z-index: 1;
  }
  #datoscliente {
    background-color: #2E9AFE;
    position: absolute;
    display: none;
    margin:24px auto auto -100px;
    border: solid 1px #2d4b7c;
    border-radius: .5em;
    width: 260px;
    height: 140px;
    z-index: 2;
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
  #pendientes {
    position: absolute;
    display: none;
    margin: 0px auto auto 300px;
    border-radius: .5em;
    width: 700px;
    height: 400px;
    z-index: 5;
    box-shadow: 5px 5px 2px grey;
  } 
  .ui-widget{
    font-family: "Times New Roman";
    font-size: 14px;
  }  
  a.external:link{text-decoration:none;font-weight:bold;color:blue;font-size: 18px;}
  a.external:visited{text-decoration:none;font-weight:bold;color:blue;font-size: 18px;}
  a.button:link{text-decoration:none;font-weight:bold;color:blue;font-size: 16px;}
  a.button:visited{text-decoration:none;font-weight:bold;color:blue;font-size: 16px;}
  #mes{
    padding: 0px 5px;
    border-radius: 10px;
    background-color: rgb(240, 61, 37);
    font-size: 14px;
    font-weight: bold;
    color: #fff;
    position: absolute;
    top: 0px;
    left: 33px;
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
  .editme4:focus {
    background-color: white;
  }
  .ui-dialog .ui-dialog-title {
    text-align: center;
    width: 100%;
  }
  .ui-widget-overlay{
    opacity: .50;filter:Alpha(Opacity=50);   
  }
  .gray{
    -webkit-filter: grayscale(100%);
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
  .ui-icon-circle-close {
    -ms-transform: scale(1.3); /* IE 9 */
    -webkit-transform: scale(1.3); /* Chrome, Safari, Opera */
    transform: scale(1.3);
  }
  input{
    margin-bottom: 0px !important;
  }
  </style>
</head>
<body>
  <form id="form" name="form" action="" method="post" autocomplete="off">
    <input type='hidden' value='<?php echo $_SESSION['cargo']?>' id='cargo'>
    <input type='text' name='vendedor' id='vendedor' value="<?php echo $_SESSION['nombre']?>" readonly='readonly' style='position:absolute;top:5px;right:2px;text-align:center' class='span2'>
    <h3 style='color:white;text-align:center;margin-top:0px;margin-bottom:0px;' class='btn-primary'>CAJA</h3>
    <a style="position:absolute;left:800px;top:3px;cursor:pointer;" id="mostrarpendientes">
      <img src="boom.png" style="width:30px;margin-top:5px;margin-left:10px"/>
      <span id="mes"></span>
    </a>
    <div id="pendientes" class='btn-warning'>
      <div id="verpendientes" style='margin:10px;color:black;position:absolute;width:97%'></div>
      <span class='ui-icon ui-icon-circle-close' id='salirpendientes' style='position:absolute;cursor:pointer;right:0px;top:0px'>
    </div>
    <div id='dialogsunat' class='btn btn-info'></div>
    <div id="resultruc" style='position:absolute;display:none;width:70%'>
      <table id='listcliente' class='table table-bordered table-condensed'>
        <thead>
          <tr bgcolor="#428bca" style="color:#FFF; text-align:center;">
            <th width='12%' style="text-align:center">RUC</th>
            <th width='33%' style="text-align:center">CLIENTE</th>
            <th width='45%' style="text-align:center">DIRECCION</th>
            <th width='10%' style="text-align:center">CREDITO</th>
          </tr>
        </thead>
        <tbody id="tb">
        </tbody>
      </table>
    </div>
    <div id='dx' style='display:none'></div>
    <div id="informacion">
      <table width="99%" border="0" align='center' cellpadding="1">
        <tr>
          <td align="right" width='10%'>
            Documento:
          </td>
          <td width='15%'>
            <select name="documento" id="documento" class='span2' style='margin-bottom: 0px;'>
              <option value="0">---------------</option>
              <option value="BOLETA DE VENTA">BOLETA DE VENTA</option>
              <option value="FACTURA">FACTURA</option>
              <option value="NOTA DE PEDIDO">NOTA DE PEDIDO</option>
              <option value="COTIZACION">COTIZACION</option>
            </select>
          </td>
          <td width='20%'>
            Cond Pago:
            <select class='span2' id="forma-pago" name="forma-pago" style='margin-bottom: 0px;'>
              <option value="CONTADO" style="display:none">CONTADO</option>
              <option value="CREDITO" style="display:none">CREDITO</option>
              <option value="NO AFECTA" selected="selected">NO AFECTA</option>
            </select>
          </td>
          <td width='15%'>  
            <span style="display:none" >F. Pago:<input type="text" name="fechapago" id="fechapago" style="cursor:pointer;font-weight:bold;text-align:right;width:80px;"></span>
            <span style="display:none" class="pago">A/C:<input class='span1' type="text" name="acuenta" value="0" id="acuenta" style="text-align:right"></span>
          </td>
          <td width='15%'>
          </td>
          <td width='25%'></td>
        </tr>
        <tr bgcolor="#FFFF00">
          <td align="left" colspan="5"><strong style="color:#000; font-size:18px; text-align:left">DATOS DEL CLIENTE</strong></td>
          <td>
            FECHA:<input type="text" name="fecha" id="fecha" style="cursor:pointer;font-weight:bold;text-align:right;width:80px">
          </td>
        </tr>
        <tr>
          <td scope="row" align="right">RUC:</td>
          <td colspan="4">
            <input type="text" name="ruc" id="ruc" class='span2 ruc' maxlength="11"/>
            <img src="sunat.jpg" style="width:60px;display:none;cursor:pointer" id='sunat'/>
            <div id="limitecredito" class='btn-warning'></div>
          </td>
          <td>
            <a href="../caja" class="external">Nueva Ventana</a>
          </td>
        </tr>
        <tr>
          <td align="right">RAZON SOCIAL:</td>
          <td colspan="4">
            <input type="text" name="razon_social" id="razon_social" class='span5 ruc'/>
          </td>
          <td width="20%">
            <input type="button" value="VER" id="ver" style="cursor:pointer;" class='btn btn-info'>
            <img src='../estad.png' width='30px' style='margin-left:20px;cursor:pointer;' id='estadistica'>
            <div id="dialogingresos" style="display:none">
              <table width="100%" align="center">
                <tr>
                  <td>OPERACION:</td>
                  <td>
                    <select id='operacion' class='span2'>
                      <option style='display:none'></option>
                      <option id='EGRESO'>EGRESO</option>
                      <option id='INGRESO'>INGRESO</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td>TIPO MOV:</td>
                  <td>
                    <select id='tipomov' class='span2'>
                      <option style='display:none'></option>
                      <option id='FLETE'>FLETE</option>
                      <option id='DELIVERY'>DELIVERY</option>
                      <option id='PERSONAL'>PERSONAL</option>
                      <option id='SERVICIOS'>SERVICIOS</option>
                      <option id='IMPUESTOS'>IMPUESTOS</option>
                      <option id='OTROS'>OTROS</option>
                    </select>
                  </td>
                </tr>
                <tr class='concepto' style='display:none'><td>CONCEPTO:</td><td><textarea id='concepto' class='span2' style='height:80px;'></textarea></td></tr>
                <tr class='personal' style='display:none'>
                  <td>TRABAJADOR:</td>
                  <td>
                    <select id='personal' class='span2'>
                      <option style='display:none'></option>
                      <option id='PAOLO'>PAOLO</option>
                      <option id='LINCOL'>LINCOL</option>
                      <option id='KAREN'>KAREN</option>
                      <option id='DARWIN'>DARWIN</option>
                      <option id='JHILMER'>JHILMER</option>
                    </select>
                  </td>
                </tr>
                <tr class='servicios' style='display:none'>
                  <td>SERVICIO:</td>
                  <td>
                    <select id='servicios' class='span2'>
                      <option style='display:none'></option>
                      <option id='LOCAL'>LOCAL</option>
                      <option id='INTERNET'>INTERNET</option>
                      <option id='LUZ'>LUZ</option>
                      <option id='AGUA'>AGUA</option>
                      <option id='CELULAR'>CELULAR</option>
                      <option id='CONTADOR'>CONTADOR</option>
                    </select>
                  </td>
                </tr>
                <tr class='impuestos' style='display:none'>
                  <td>CLASE:</td>
                  <td>
                    <select id='impuestos' class='span2'>
                      <option style='display:none'></option>
                      <option id='RENTA PAOLA'>RENTA PAOLA</option>
                      <option id='IGV PAOLA'>IGV PAOLA</option>
                      <option id='ESSALUD PAOLA'>ESSALUD PAOLA</option>
                      <option id='RENTA DORIS'>RENTA DORIS</option>
                      <option id='IGV DORIS'>IGV DORIS</option>
                      <option id='ESSALUD DORIS'>ESSALUD DORIS</option>
                    </select>
                  </td>
                </tr>
                <tr><td>MONTO:</td><td><input type='number' id='monto' style='margin-bottom:10px !important' class='span2'></td></tr>
              </table>
            </div>
            <div id="dialogver" style="display:none" class='btn-info'>
              <table width="100%" align="center">
                <tr>
                  <td>CLIENTE:<input type='text' class='span3' id='clie'></td>
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
                        <th width="12%">VENDEDOR</th>
                        <th width="10%">FECHA</th>
                        <th width="10%">DOCUMENTO</th>
                        <th width="27%">CLIENTE</th>
                        <th width="10%">PAGO</th>
                        <th width="8%">ENTREG</th>
                        <th width="10%">TOTAL</th>
                    </tr>
                  </thead>
                </table>
                <div style="overflow-y:overlay;overflow-x:hidden;height:400px;align:center;color:black;width:98%;margin:auto;font-size:12px;font-family:Verdana;" class='par'>
                  <table width="100%" align="center" id='ventas'>
                    <thead>
                      <tr style='display:none;'>
                        <th width="5%">VER</th>
                        <th width="8%">SERIE</th>
                        <th width="12%">VENDEDOR</th>
                        <th width="10%">FECHA</th>
                        <th width="10%">DOCUMENTO</th>
                        <th width="27%">CLIENTE</th>
                        <th width="10%">PAGO</th>
                        <th width="8%">ENTREG</th>
                        <th width="10%">TOTAL</th>
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
                  <td width='12%' style="text-align:right;font-size:15px;padding-right:10px;border:1px solid #B1B1B1" id='sumatotal'></td>
                </tr>
             </table>
              <div id='observarpedido'></div>
            </div>
            <div id="dialogestadistica" style='background-color:#ff3'>
              <table width='100%'>
                <tr>
                  <td>CLIENTE:<input type="text" class='span6' id="clienteestadistica"></td>
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
        <tr>
          <td scope="row" align="right">DIRECCION:</td>
          <td colspan="4">
            <input type="text" name="direccion" id="direccion" class='span8' title="Ingresar la Direccion" style="text-transform:uppercase;"/>
          </td>
          <td>
            <input type="button" value="INGRESO/EGRESO" id="ingreso" class='btn btn-success'>
          </td>
        </tr>
      </table>
    </div>
    <div id="result" style='position:absolute;width:60%;display:none;z-index:2'>
      <table id='listcliente' class='table table-bordered table-condensed'>
        <thead>
          <tr bgcolor="#428bca" style="color:#FFF;text-align:center;font-size:13px">
            <th width="3.5%">IMG</th>
            <th width="47.5%">PRODUCTO</th>
            <th width="23%">MARCA</th>
            <?php if($_SESSION['cargo']=='ADMIN'){ ?>
            <th width="7%">P. COMPRA</th>
            <th width="10%">X/CAJA</th>
            <th width="8%">STOCK</th>
            <?php }else{ ?>
            <th width="7%">P. COMPRA</th>
            <th width="10%">X/CAJA</th>
            <th width="8%">STOCK</th>
            <?php } ?>
            <th width="7%">P. UND</th>
            <th width="7%">P. MAYOR</th>
          </tr>
        </thead>
        <tbody id="tb1">
        </tbody>
      </table>
    </div>
    <div>
      <table align="center" width="98%" >
        <thead>
          <tr style="background-color:#006dcc;color:white;font-weight:bold;" >
            <th width="70%" style="text-align:center" colspan='3'>PRODUCTO</th>
            <th width="10%" style="text-align:center">CANTIDAD</th>
            <th width="10%" style="text-align:center">P. UNITARIO</th>
            <th width="10%" style="text-align:center">IMPORTE</th>
          </tr>
          <tr>
            <td colspan='3'><input type="text" id="busqueda" style="background-color: #F8FD8D;" class='span8'/><input type='hidden' id='id'></td>
            <td align='right'><span id='stock' style='color:red;font-weight:bold;margin-right:10px;display:none'></span><input type="text" id="cantidad" style="text-align:right;background-color: #F8FD8D" class='span1'/></td>
            <td align='right'><input type="text" id="precio_u" style="text-align:right;background-color: #F8FD8D" class='span1'/><input type='hidden' id='promotor'></td>
            <td align='right'><input type="text" id="importe" style="text-align:right;background-color: #F8FD8D" class='span1'/><input type='hidden' id='compra'></td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td style="height:280px;padding:0px" colspan='6' valign='top'>
              <div style="height:280px;overflow:overlay;" id='roww'> 
                <table id="row" width="100%" class='table table-condensed'>
                </table> 
                </div>
            </td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <td><input type="button" id="devol" value="DEVOLUCION" class='btn btn-info' disabled='disabled'></td>
            <td>ENTREGADO <select name="entregar" id='entregar' style='border:2px solid red' class='span1'><option value="SI">SI</option><option value="NO">NO</option></td>
            <td id="cantprod" style='color:red;font-weight:bold'></td>
            <td align="center">SUBTOTAL<br><input class='span1' type="text" id="subtotal" name="subtotal" value="0.00" readonly="readonly" style='font-weight:bold;text-align:right'></td>
            <td align="center">DEVOLUCION<br><input class='span1' type="text" name="devolucion" id="devolucion" value="0.00" readonly="readonly" style='font-weight:bold;text-align:right'></td>
            <td align="center">TOTAL<br><input class='span1' type="text" name="total" id="total" value="0.00" readonly="readonly" style='font-weight:bold;text-align:right'></td>
          </tr>
        </tfoot>
      </table>
    </div>
    <div id="anterior" style='position:absolute;bottom:5px;margin: auto;width:900px;height:90px;left:0;right:0;display:none;background-color:#FBEFEF;border:1px solid black;box-shadow: 5px 5px 2px grey;'>
      <div id='ant' style='width:900px'></div>
      <span class='ui-icon ui-icon-circle-close' id='saliranterior' style='position:absolute;cursor:pointer;right:0px;top:0px'>
    </div>
    <div>
      <table width="98%" id="areacoment" align='center'>
        <tr>
          <td width="70%">
            COMENTARIOS:<textarea name="comentarios" id="comentario" style="text-transform:uppercase;" class='span8'></textarea>
          </td>
          <td width='15%'>EFECTIV:<input type='text' id='efectivo' style='text-align:right;font-weight:bold' class='span1'><br>VUELTO: <input type='text' id='vuelto' style='text-align:right;font-weight:bold' class='span1'></td>
          <td width="15%"><input type="button" id="guardarform" value="ENVIAR" style="cursor:pointer;" class='btn btn-success'/></td>
            <div id="procesarenvio" style="display:none">
          </div>
        </tr>
      </table>
    </div>
    <div id="dialog" style="display:none">
      <div id="result1"></div>
      <table width="100%">
        <thead>
          <tr style="background-color:#006dcc;color:white;font-weight:bold;">
            <th width="55%" style="text-align:center">PRODUCTO</th>
            <th width="10%" style="text-align:center">CANTIDAD</th>
            <th width="10%" style="text-align:center">P. UNITARIO</th>
            <th width="10%" style="text-align:center">IMPORTE</th>
            <th width="15%" style="text-align:center">ESTADO</th>
          </tr>
          <tr>
            <td ><input type="text" id="busqueda1" style="background-color: #F8FD8D" class='span6'/></td>
            <td align='right'><input type="text" id="cantidad1" style="text-align:right;background-color: #F8FD8D" class='span1'/></td>
            <td align='right'><input type="text" id="precio_u1" style="text-align:right;background-color: #F8FD8D" class='span1'/><input type='hidden' id='compra1'></td>
            <td align='right'><input type="text" id="importe1" style="text-align:right;background-color: #F8FD8D" class='span1'/><input type='hidden' id='id1'></td>
            <td align='right'>
              <select id="estado" class='span2' style="background-color: #F8FD8D;margin-bottom:0px">
                <option value="">-------------</option>
                <option value="BUENO">BUENO</option>
                <option value="MALOGRADO TIENDA">MALOGRADO TIENDA</option>
                <option value="MALOGRADO FABRICA">MALOGRADO FABRICA</option>
            </select>
            </td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td style="height:280px;padding:0px" colspan='6' valign='top'>
              <div style="height:280px;overflow:overlay;"> 
                <table id="row1" width="100%" class='table table-condensed'>
                </table> 
                </div>
            </td>
          </tr>
        </tbody>
        <tfoot>
          <tr>
            <td align='right' colspan='4'><input type="text" id="subtotal_devol" value="0.00" style='text-align:right;' readonly="readonly" class='span1'></td>
          </tr> 
        </tfoot>
      </table>
    </div>
  </form>
</body>
</html>
<?php }else{
  header("Location: ../");
} ?>

