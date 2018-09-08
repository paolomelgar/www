<!DOCTYPE html>
<?php 
session_start();
if($_SESSION['valida']=='tarapaca' && $_SESSION['cargo']=='ADMIN' ){
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
          <td width='15%' style='padding:5px'>FECHA FIN:<input type="text" name="final" id="final" style="cursor:pointer;text-align:right;width:80px;"></td>
          <td width='20%' style='padding:5px'>ESTADO:
            <select id='change' name='change' class='span2' style='margin-bottom:0px'>
              <option value"TODOS">TODOS</option>
              <option value"INGRESO">INGRESO</option>
              <option value"EGRESO">EGRESO</option>
            </select>
          </td>
          <td width='20%' style='padding:5px'><input type="button" name="buscar" value='BUSCAR' id="buscar" class='btn btn-success'></td>
          <td width='5%'><img src='../estadistica.png' width='30px' data-toggle="modal" data-target="#myModal" id='estadistica' style='cursor:pointer'></td>
        </tr>
      </table>
    </div>
  </form>
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
                      <option id='DAVID'>DAVID</option>
                      <option id='KAREN'>KAREN</option>
                      <option id='DARWIN'>DARWIN</option>
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
                      <option id='RENTA'>RENTA</option>
                      <option id='IGV'>IGV</option>
                      <option id='ESSALUD'>ESSALUD</option>
                    </select>
                  </td>
                </tr>
                <tr><td>MONTO:</td><td><input type='number' id='monto' style='margin-bottom:10px !important' class='span2'></td></tr>
              </table>
            </div>
  <div id="row" style='margin-top:-20px'>
    <table width='100%' align='center' style='border-collapse:collapse;'>
      <thead>
        <tr align='center' bgcolor="black" style="color:white;font-weight:bold;">
          <th width='5%'>N°</th>
          <th width='10%'>FECHA</th>
          <th width='15%'>TIPO</th>
          <th width='15%'>TIPO MOV.</th>
          <th width='10%'>TOTAL</th>
          <th width='30%'>DETALLE</th>
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
            <th width='15%'>TIPO</th>
            <th width='15%'>TIPO MOV.</th>
            <th width='10%'>TOTAL</th>
            <th width='30%'>DETALLE</th>
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
        <td width='45%'align='right'>TOTALES</td>
        <td width='10%' id='total' align='right'></td>
        <td width='45%'></td>
      </tr>
    </table>
  </div>
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Estadisticas</h4>
        </div>
        <div class="modal-body">   
          <table width='100%' height='100%'>
        <tr>
          <td>
            <select id='forma' class='span2' style='margin-bottom:0px'>
              <option value='todo'>EGRESOS</option>
              <option value='flete'>FLETE</option>
              <option value='delivery'>DELIVERY</option>
              <option value='personal'>PERSONAL</option>
              <option value='servicios'>SERVICIOS</option>
              <option value='impuestos'>IMPUESTOS</option>
            </select>
          </td>
          <td>
            <select id='month' class='span2' style='margin-bottom:0px'>
              <option value='00'>ENERO</option>
              <option value='01'>FEBRERO</option>
              <option value='02'>MARZO</option>
              <option value='03'>ABRIL</option>
              <option value='04'>MAYO</option>
              <option value='05'>JUNIO</option>
              <option value='06'>JULIO</option>
              <option value='07'>AGOSTO</option>
              <option value='08'>SETIEMBRE</option>
              <option value='09'>OCTUBRE</option>
              <option value='10'>NOVIEMBRE</option>
              <option value='11'>DICIEMBRE</option>
            </select>
          </td>
          <td>
            <select id='year' class='span1' style='margin-bottom:0px'>
              <option>2015</option>
              <option>2016</option>
              <option>2017</option>
              <option>2018</option>
              <option>2019</option>
              <option>2020</option>
            </select>
          </td>
          <td align='right'><input type='button' id='busc' value='Buscar' style='cursor:pointer' class='btn btn-success'></td>
        </tr>
        <tr>
          <td colspan='4' style='height:350px;'>
            <canvas id="canvas" style='width:100%;height:350px;'></canvas>
          </td>
        </tr>
      </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>
      </div>
      
    </div>
  </div>
</body>
</html>
<?php }else{
  header("Location: ../");
} ?>