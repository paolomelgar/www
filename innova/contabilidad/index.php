<!DOCTYPE html>
<?php 
session_start();
if($_SESSION['valida']=='innova' && $_SESSION['cargo']=='ADMIN' || $_SESSION['cargo']=='ASISTENTE' || $_SESSION['cargo']=='ENCARGADOTIENDA'){
?>
<html>
<head>
  <title>CONTABILIDAD</title>
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
  <script type="text/javascript" src="egresos.js"></script>
  <style type="text/css">
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
      background: #FF3;
    }
    .selected1 {
      background: #F63;
    }
    .ui-autocomplete {
      font-size: 12px;
      max-height: 200px;
      overflow-y: auto;
      overflow-x: hidden;
    }
    .ui-dialog .ui-dialog-title {
      text-align: center;
      width: 100%;
    }
    input{
      margin-bottom: 0px !important;
    }
    .fila:hover{
      background: #FF3;
      cursor:pointer;
    }
    #myModal{
      width: 1000px;
      height: 550px;
      margin-left:-500px;
    }
    .modal-header, h4, .close {
        background-color: #49afcd;
        color:white !important;
        text-align: center;
        font-size: 30px;
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
  </style>
</head>
<body>
  <div class='error' style='display:none'>Guardado Correctamente</div>
  <form id="form" name="form" action="" method="post" autocomplete="off">
    <input type='hidden' value='<?php echo $_SESSION['nombre']?>' id='nombre'>
    <div id="informacion">
      <h3 style='color:white;text-align:center;margin-top:0px;margin-bottom:0px;' class='btn-info'>REGISTRO CONTABLE</h3>
      <table width="100%">
        <tr bgcolor='#E0ECF8'>
          <td width='15%' style='padding:5px'>FECHA INICIO:<input type="text" name="inicio" id="inicio" style="cursor:pointer;text-align:right;width:80px;"></td>
          <td width='15%' style='padding:5px'>FECHA FIN:<input type="text" name="final" id="final" style="cursor:pointer;text-align:right;width:80px;"><input type="hidden" id="prueba"></td>
          <td width='20%' style='padding:5px'><input type="button" name="buscar" value='BUSCAR' id="buscar" class='btn btn-success'></td>
        </tr>
      </table>
    </div>
  </form>
  <div id="row" style='margin-top:-20px'>
    <table width='100%' align='center' style='border-collapse:collapse;'>
      <thead>
        <tr align='center' bgcolor="black" style="color:white;font-weight:bold;">
          <th width='5%'>N°</th>
          <th width='10%'>FECHA FACTURA</th>
          <th width='10%'>NUMERO FACTURA</th>
          <th width='15%'>TIPO</th>
          <th width='5%'>TOTAL</th>
          <th width='45%'>DETALLE</th>
          <th width='10%'>FECHA</th>
        </tr>
      </thead>
    </table>
    <div style="overflow-y:overlay;overflow-x:hidden;height:505px;align:center">
      <table width='100%' id="venta" border='1' align='center'>
        <thead style='background-color:#2E9AFE'>
          <tr style="display:none">
            <th width='5%'>N°</th>
            <th width='10%'>FECHA FACTURA</th>
            <th width='10%'>NUMERO FACTURA</th>
            <th width='15%'>TIPO</th>
            <th width='5%'>TOTAL</th>
            <th width='45%'>DETALLE</th>
            <th width='10%'>FECHA</th>
            <th style='display:none'></th>
          </tr>
        </thead>
        <tbody id="verbody" style='font-weight:bold'>
        </tbody>
      </table>
    </div>
    <table width='100%' align='center' border='1' style='font-size:16px;font-weight:bold'>
      <tr>
        <td width='45%'align='right'>TOTALES</td>
        <td width='10%' id='total' align='right'></td>
        <td width='45%'></td>
      </tr>
    </table>
  </div>
</body>
</html>
<?php }else{
  header("Location: ../");
} ?>