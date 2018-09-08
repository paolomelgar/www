<!DOCTYPE html>
<?php 
session_start();
if($_SESSION['valida']=='huancayoprincipal' && $_SESSION['cargo']=='ADMIN' || $_SESSION['cargo']=='ASISTENTE' || $_SESSION['cargo']=='LOGISTICA'){
?>
<html>
<head>
  <title>INGRESOS/EGRESOS</title>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 
  <link type="text/css" href="../bootstrap.min.css" rel="stylesheet" />
  <link type="text/css" href="../jquery-ui-1.10.4.custom.min.css" rel="stylesheet" />
  <link type="text/css" href="../sweet-alert.css" rel="stylesheet" />
  <script type="text/javascript" src="../jquery-1.11.1.min.js"></script>
  <script type="text/javascript" src="../bootstrap.min.js"></script>
  <script type="text/javascript" src="../jquery-ui-1.10.4.custom.min.js"></script>  
  <script type='text/javascript' src='../picnet.table.filter.min.js'></script> 
  <script type="text/javascript" src="../sweet-alert.min.js"></script>  
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
  </style>
</head>
<body>
  <form id="form" name="form" action="" method="post" autocomplete="off">
    <div id="informacion">
      <h3 style='color:white;text-align:center;margin-top:0px;margin-bottom:0px;' class='btn-info'>REGISTRO DE INGRESOS Y EGRESOS</h3>
      <table width="100%">
        <tr bgcolor='#E0ECF8'>
          <td width='25%' style='padding:5px'><input type='button' id='egreso' value='REGISTRO INGRESO/EGRESO' style='margin-left:30px' class='btn btn-primary'></td>
          <td width='15%' style='padding:5px'>FECHA INICIO:<input type="text" name="inicio" id="inicio" style="cursor:pointer;text-align:right;width:80px;"></td>
          <td width='15%' style='padding:5px'>FECHA FIN:<input type="text" name="final" id="final" style="cursor:pointer;text-align:right;width:80px;"><input type="hidden" id="prueba"></td>
          <td width='25%' style='padding:5px'>ESTADO:
            <select id='change' name='change' class='span2' style='margin-bottom:0px'>
              <option value"TODOS">TODOS</option>
              <option value"INGRESO">INGRESO</option>
              <option value"EGRESO">EGRESO</option>
            </select>
          </td>
          <td width='20%' style='padding:5px'><input type="button" name="buscar" value='BUSCAR' id="buscar" class='btn btn-success'></td>
        </tr>
      </table>
    </div>
  </form>
  <div id="dialogingresos" style="display:none">
    <table width="95%" align="center">
      <tr>
        <td>OPERACION:</td>
        <td>
          <select id='operacion' class='span2' style='margin-bottom: 0px;'>
            <option id='EGRESO'>EGRESO</option>
            <option id='INGRESO'>INGRESO</option>
          </select>
        </td>
        <td>TIPO MOV:</td>
        <td>
          <select id='tipomov' class='span2' style='margin-bottom: 0px;'>
            <option id='TRANSPORTES'>TRANSPORTES</option>
            <option id='FLETES'>FLETES</option>
            <option id='SERV. BASICOS'>SERV. BASICOS</option>
            <option id='MAQUINARIAS Y EQUIPOS'>MAQUINARIAS Y EQUIPOS</option>
            <option id='PERSONAL'>PERSONAL</option>
            <option id='PRESTAMOS'>PRESTAMOS</option>
            <option id='SALDOS EN CONTRA'>SALDOS EN CONTRA</option>
            <option id='GASTOS ADMINISTRATIVOS'>GASTOS ADMINISTRATIVOS</option>
          </select>
        </td>
      </tr>
      <tr>
        <td>MONTO:</td>
        <td><input type='text' id='monto' style='text-align:right' class='span2'></td>
        <td class='transporte' style='display:none'>TRANSPORTE:</td>
        <td class='transporte' style='display:none'><input type='text' id='transporte' class='span2'></td>
      </tr>
      <tr>
        <td>DETALLE:</td>
        <td colspan='3'><textarea id='detalle' class='span5'></textarea></td>
      </tr>
    </table>
  </div>
  <div id="row" style='margin-top:-20px'>
    <table width='100%' align='center' style='border-collapse:collapse;'>
      <thead>
        <tr align='center' bgcolor="black" style="color:white;font-weight:bold;">
          <th width='5%'>N°</th>
          <th width='10%'>FECHA</th>
          <th width='15%'>ORIGEN</th>
          <th width='10%'>TIPO</th>
          <th width='10%'>TIPO MOV.</th>
          <th width='10%'>TOTAL</th>
          <th width='25%'>DETALLE</th>
          <th width='15%'>ENCARGADO</th>
        </tr>
      </thead>
    </table>
    <div style="overflow-y:overlay;overflow-x:hidden;height:505px;align:center">
      <table width='100%' id="venta" border='1' align='center'>
        <thead style='background-color:#2E9AFE'>
          <tr style="display:none">
            <th width='5%'>N°</th>
            <th width='10%'>FECHA</th>
            <th width='15%'>ORIGEN</th>
            <th width='10%'>TIPO</th>
            <th width='10%'>TIPO MOV.</th>
            <th width='10%'>TOTAL</th>
            <th width='25%'>DETALLE</th>
            <th width='15%'>ENCARGADO</th>
            <th style='display:none'></th>
          </tr>
        </thead>
        <tbody id="verbody" style='font-weight:bold'>
        </tbody>
      </table>
    </div>
    <table width='100%' align='center' border='1' style='font-size:16px;font-weight:bold'>
      <tr>
        <td width='50%'align='right'>TOTALES</td>
        <td width='10%' id='total' align='right'></td>
        <td width='40%'></td>
      </tr>
    </table>
  </div>
</body>
</html>
<?php }else{
  header("Location: ../");
} ?>