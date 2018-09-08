<!DOCTYPE html>
<?php 
session_start();
if($_SESSION['valida']=='innova'){
?>
<html>
<head>
  <title>MALOGRADOS</title>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 
  <link type="text/css" href="../bootstrap.min.css" rel="stylesheet" />
  <link type="text/css" href="../jquery-ui-1.10.4.custom.min.css" rel="stylesheet" />
  <link type="text/css" href="../sweet-alert.css" rel="stylesheet" />
  <script type="text/javascript" src="../jquery-1.11.1.min.js"></script>
  <script type="text/javascript" src="../bootstrap.min.js"></script>
  <script type="text/javascript" src="../jquery-ui-1.10.4.custom.min.js"></script> 
  <script type='text/javascript' src='../picnet.table.filter.min.js'></script> 
  <script type="text/javascript" src="../sweet-alert.min.js"></script> 
  <script type="text/javascript" src="devolucion.js"></script>
  <style type="text/css">
    .par{
      background-color: white;
    }
    .impar{
      background-color: #E0F8E6;
    }
    .con{
      color: red;
    }
    .selected {
      cursor: pointer;
      background: #FF3 !important;
    }
    .selected1 {
      background: #F63 !important;
    }
    input{
      margin-bottom: 0px !important;
      text-transform: uppercase;
    }
    .ui-widget{
      font-family: "Times New Roman";
      font-size: 14px;
    } 
    #listcliente {
      table-layout: fixed;
      box-shadow: 5px 5px 2px grey;
    }
    #listcliente td,th {
    white-space: nowrap;overflow: hidden;
    }
    .ui-widget-overlay{
      opacity: .50;filter:Alpha(Opacity=50);   
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
    .fila:hover{
      background: #FF3;
      cursor:pointer;
    }
  </style>
</head>
<body>
<form id="form" action="" method="post">
  <h3 style='color:white;text-align:center;margin-top:0px;margin-bottom:0px;background-color:#3FED59;font-weight:bold;'>PRODUCTOS MALOGRADOS</h3>
  <table width='100%'>
    <tr bgcolor='#E0F8E6'>
      <td align='center'><input type='button' value='AGREGAR' id='agregar' class='btn btn-info'></td>
      <td style='text-align:right'>FECHA INICIO:</td>
      <td><input type='text' id='inicio' name='inicio' style="cursor:pointer;font-weight:bold;text-align:right;width:80px;"></td>
      <td style='text-align:right'>FECHA FINAL:</td>
      <td><input type='text' id='final' name='final' style="cursor:pointer;font-weight:bold;text-align:right;width:80px;"></td>
      <td style='text-align:right'>ESTADO:</td>
      <td>
        <select id='estado' name='estado' style='margin-bottom: 0px;' class='span2'>
          <option value"TODOS">TODOS</option>
          <option value"MALOGRADO TIENDA">MALOGRADO TIENDA</option>
          <option value"MALOGRADO FABRICA">MALOGRADO FABRICA</option>
          <option value"CORRECCION INVENTARIO">CORRECCION INVENTARIO</option>
        </select>
      </td>
      <td><input type='button' id='buscar' value='BUSCAR' class='btn btn-success'></td>
    </tr>
  </table>
</form>
<div id="dialog" style="display:none">
      <div id="result" style='position:absolute;width:60%;display:none'>
      <table id='listcliente' class='table table-bordered table-condensed'>
        <thead>
          <tr bgcolor="#428bca" style="color:#FFF;text-align:center;font-size:13px">
            <th width="3.5%">IMG</th>
            <th width="50.5%">PRODUCTO</th>
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
              <select id="estado1" class='span2' style="background-color: #F8FD8D;margin-bottom:0px">
                <option value="">-------------</option>
                <option value="MALOGRADO TIENDA">MALOGRADO TIENDA</option>
                <option value="MALOGRADO FABRICA">MALOGRADO FABRICA</option>
                <option value"CORRECCION INVENTARIO">CORRECCION INVENTARIO</option>
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
  <div id="row" style='margin-top:-10px'>
    <table width='98%' align='center'>
      <thead>
        <tr align='center' bgcolor="black" style="color:white;font-weight:bold;font-size:15px">
          <th width='3%'>N°</th>
          <th width='12%'>FECHA</th>
          <th width='8%'>SERIE</th>
          <th width='40%'>PRODUCTO</th>
          <th width='6%'>CAN</th>
          <th width='8%'>P.COMPRA</th>
          <th width='8%'>IMPORTE</th>
          <th width='15%'>ESTADO</th>
        </tr>
      </thead>
    </table>
    <div style="overflow-y:overlay;overflow-x:hidden;height:480px;align:center">
      <table width='98%' id="venta" align='center'>
        <thead style='background-color:#2E9AFE'>
          <tr style="display:none">
            <th width='3%'>N°</th>
            <th width='12%'>FECHA</th>
            <th width='8%'>SERIE</th>
            <th width='40%'>PRODUCTO</th>
            <th width='6%'>CANTIDAD</th>
            <th width='8%'>P.COMPRA</th>
            <th width='8%'>IMPORTE</th>
            <th width='15%'>ESTADO</th>
            <th style='display:none'></th>
          </tr>
        </thead>
        <tbody id="verbody">
        </tbody>
      </table>
    </div>
    <table width='98%' align='center' style="border-collapse: collapse;">
      <tr>
        <td width='63%' style="border: 1px solid #B1B1B1;text-align:right">TOTALES</td>
        <td width='6%' style="border: 1px solid #B1B1B1;text-align:right" id='sumacantidad'></td>
        <td width='8%' style="border: 1px solid #B1B1B1;text-align:right"></td>
        <td width='8%' style="border: 1px solid #B1B1B1;text-align:right" id='sumatotal'></td>
        <td width='15%' style="border: 1px solid #B1B1B1;text-align:right"></td>
      </tr>
    </table>
  </div>
</body>
</html>
<?php }else{
  header("Location: ../");
} ?>