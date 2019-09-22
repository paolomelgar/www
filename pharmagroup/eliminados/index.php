<!DOCTYPE html>
<?php 
session_start();
if($_SESSION['valida']=='pharmagroup'){
?>
<html>
<head>
  <title>REPORTE ELIMINADOS</title>
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
  <div id='cargo' style='display:none'><?php echo $_SESSION['cargo']; ?></div>
<form id="form" action="" method="post">
  <h3 style='color:white;text-align:center;margin-top:0px;margin-bottom:0px;background-color:#3FED59;font-weight:bold;'>COMPROBANTES ELIMINADOS</h3>
  <table width='100%'>
    <tr bgcolor='#E0F8E6'>
      <td style='text-align:right'>FECHA INICIO:</td>
      <td><input type='text' id='inicio' name='inicio' style="cursor:pointer;font-weight:bold;text-align:right;width:80px;"></td>
      <td style='text-align:right'>FECHA FINAL:</td>
      <td><input type='text' id='final' name='final' style="cursor:pointer;font-weight:bold;text-align:right;width:80px;"><input type="hidden" id="prueba"></td>
      <td><input type='button' id='buscar' value='BUSCAR' class='btn btn-success'></td>
    </tr>
  </table>
</form>
  <div id="row" style='margin-top:-10px'>
    <table width='98%' align='center'>
      <thead>
        <tr align='center' bgcolor="black" style="color:white;font-weight:bold;font-size:15px">
          <th width='3%'>N°</th>
          <th width='4%'>FECHA</th>
          <th width='15%'>COMPROBANTE</th>
          <th width='8%'>SERIE</th>
          <th width='40%'>PRODUCTO</th>
          <th width='6%'>CAN</th>
          <th width='8%'>P.COMPRA</th>
          <th width='8%'>IMPORTE</th>
          <th width='8%'>MOTIVO</th>
        </tr>
      </thead>
    </table>
    <div style="overflow-y:overlay;overflow-x:hidden;height:480px;align:center">
      <table width='98%' id="venta" align='center'>
        <thead style='background-color:#2E9AFE'>
          <tr style="display:none">
            <th width='3%'>N°</th>
            <th width='4%'>FECHA</th>
            <th width='15%'>COMPROBANTE</th>
            <th width='8%'>SERIE</th>
            <th width='40%'>PRODUCTO</th>
            <th width='6%'>CAN</th>
            <th width='8%'>P.COMPRA</th>
            <th width='8%'>IMPORTE</th>
            <th width='8%'>MOTIVO</th>
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