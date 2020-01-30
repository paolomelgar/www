<!DOCTYPE html>
<?php 
session_start();
if($_SESSION['valida']=='innova' && $_SESSION['cargo']=='ADMIN' || $_SESSION['cargo']=='ASISTENTE' || $_SESSION['cargo']=='ENCARGADOTIENDA'){
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
      <h3 style='color:white;text-align:center;margin-top:0px;margin-bottom:0px;' class='btn-info'>REGISTRO DE INGRESOS Y EGRESOS</h3>
      <table width="100%">
        <tr bgcolor='#E0ECF8'>
          <td width='25%' style='padding:5px'><input type='button' id='egreso' value='REGISTRO INGRESO/EGRESO' style='margin-left:30px' class='btn btn-primary'></td>
          <td width='15%' style='padding:5px'>FECHA INICIO:<input type="text" name="inicio" id="inicio" style="cursor:pointer;text-align:right;width:80px;"></td>
          <td width='15%' style='padding:5px'>FECHA FIN:<input type="text" name="final" id="final" style="cursor:pointer;text-align:right;width:80px;"><input type="hidden" id="prueba"></td>
          <td width='20%' style='padding:5px'>ESTADO:
            <select id='change' name='change' class='span2' style='margin-bottom:0px'>
              <option value="TODOS">TODOS</option>
              <option value="INGRESO">INGRESO</option>
              <option value="EGRESO">EGRESO</option>
            </select>
          </td>
          <td width='20%' style='padding:5px'><input type="button" name="buscar" value='BUSCAR' id="buscar" class='btn btn-success'></td>
          <td width='5%'><img src='../estadistica.png' width='30px' data-toggle="modal" data-target="#myModal" id='estadistica' style='cursor:pointer'></td>
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
                      <option id='PERSONAL'>PERSONAL</option>
                      <option id='TRANSPORTE INGRESO'>TRANSPORTE INGRESO</option>
                      <option id='SERVICIOS'>SERVICIOS</option>
                      <option id='TRANSPORTE SALIDA'>TRANSPORTE SALIDA</option>
                      <option id='GASTOS TRIBUTARIOS'>GASTOS TRIBUTARIOS</option>
                      <option id='CONSTRUCCION'>CONSTRUCCION</option>
                      <option id='GASTOS FINANCIEROS'>GASTOS FINANCIEROS</option>
                      <option id='GASTOS ADMINISTRATIVOS'>GASTOS ADMINISTRATIVOS</option>
                      <option id='GASTOS TIENDA'>GASTOS TIENDA</option>
                      <option id='UTILES ESCRITORIO'>UTILES ESCRITORIO</option>
                      <option id='MARKETING'>MARKETING</option>
                      <option id='FRANQUICIAS'>FRANQUICIAS</option>
                      <option id='INTERES'>INTERES</option>
                      <option id='CAPACITACION'>CAPACITACION</option>
                      <option id='COMPARTIR PERSONAL'>COMPARTIR PERSONAL</option>
                      <option id='DESCUENTOS CLIENTES'>DESCUENTOS CLIENTES</option>
                      <option id='SOFTWARE'>SOFTWARE</option>
                      <option id='HERRAMIENTAS TRABAJO'>HERRAMIENTAS TRABAJO</option>
                      <option id='LIMPIEZA'>LIMPIEZA</option>
                      <option id='COLABORACION'>COLABORACION</option>
                      <option id='OTROS'>OTROS</option>
                    </select>
                  </td>
                </tr>
                <tr class='personal' style='display:none'>
                  <td>COLABORADOR:</td>
                  <td>
                    <select id='personal' class='span2'>
                      <option style='display:none'></option>
                      <option id='PAULO'>PAULO MELGAR</option>
                      <option id='DADDY'>DADDY SERVA</option>
                      <option id='ROCIO'>ROCIO TITO</option>
                      <option id='PAOLA'>PAOLA MELGAR</option>
                      <option id='SAYURI'>SAYURI ARMAS</option>
                      <option id='MIGUEL'>MIGUEL ARIZACA</option>
                      <option id='RAUL'>RAUL GALARZA</option>
                      <option id='ANGEL'>ANGEL SOLANO</option>
                      <option id='YAJAYRA'>YAJAYRA QUEVEDO</option>
                      <option id='MARCO'>MARCO PEÑA</option>
                      <option id='PEDRO'>PEDRO ROJAS</option>
                      <option id='JACINTO'>JACINTO RODRIGUEZ</option>
                      <option id='JOSE MIGUEL'>MIGUEL MURIA</option>
                      <option id='PAUL'>PAUL ALEXIS MELGAR</option>
                      <option id='OTROS'>OTROS</option>
                    </select>
                  </td>
                </tr>
                <tr class='servicios' style='display:none'>
                  <td>SERVICIOS:</td>
                  <td>
                    <select id='servicios' class='span2'>
                      <option style='display:none'></option>
                      <option id='SERVICIO LUZ'>SERVICIO LUZ</option>
                      <option id='SERVICIO AGUA'>SERVICIO AGUA</option>
                      <option id='SERVICIO INTERNET'>SERVICIO INTERNET</option>
                      <option id='SERVICIO VIGILANCIA'>SERVICIO VIGILANCIA</option>
                      <option id='ALQUILER INNOVA PRINCIPAL'>ALQUILER INNOVA PRINCIPAL</option>
                      <option id='ALQUILER INNOVA ELECTRIC'>ALQUILER INNOVA ELECTRIC</option>
                      <option id='ALQUILER ALMACEN PACHITEA'>ALQUILER ALMACEN PACHITEA</option>
                      <option id='OTROS'>OTROS</option>
                    </select>
                  </td>
                </tr>
                <tr class='tributarios' style='display:none'>
                  <td>CONCEPTO:</td>
                  <td>
                    <select id='tributarios' class='span2'>
                      <option style='display:none'></option>
                      <option id='AFP PRIMA'>AFP PRIMA</option>
                      <option id='AFP INTEGRA'>AFP INTEGRA</option>
                      <option id='AFP PROFUTURO'>AFP PROFUTURO</option>
                      <option id='PAGO ONP'>PAGO ONP</option>
                      <option id='PAGO ESSALUD'>PAGO ESSALUD</option>
                      <option id='PAGO RENTA'>PAGO RENTA</option>
                      <option id='PAGO IGV'>PAGO IGV</option>
                      <option id='OTROS'>OTROS</option>
                    </select>
                  </td>
                </tr>
      <tr>
        <td>MONTO:</td>
        <td><input type='text' id='monto' style='text-align:right' class='span2'></td>
        <td class='transporte ingreso' style='display:none'>TRANSPORTE:</td>
        <td class='transporte ingreso' style='display:none'><input type='text' id='transporte' class='span2'></td>
        <td>MEDIO DE PAGO:</td>
        <td>
          <select id='mediopago' class='span2' style='margin-bottom: 0px;'>
            <option id='EFECTIVO'>EFECTIVO</option>
            <option id='TARJETA'>TARJETA</option>
          </select>
        </td>
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
          <th width='3%'>N°</th>
          <th width='8%'>FECHA</th>
          <th width='8%'>TIPO</th>
          <th width='8%'>MEDIOPAGO</th>
          <th width='10%'>TIPO MOV.</th>
          <th width='5%'>TOTAL</th>
          <th width='39%'>DETALLE</th>
          <th width='8%'>USUARIO</th>
          <th width='11%'>ENCARGADO</th>
        </tr>
      </thead>
    </table>
    <div style="overflow-y:overlay;overflow-x:hidden;height:505px;align:center">
      <table width='100%' id="venta" border='1' align='center'>
        <thead style='background-color:#2E9AFE'>
          <tr style="display:none">
            <th width='3%'>N°</th>
            <th width='8%'>FECHA</th>
            <th width='8%'>TIPO</th>
            <th width='8%'>MEDIOPAGO</th>
            <th width='10%'>TIPO MOV.</th>
            <th width='5%'>TOTAL</th>
            <th width='39%'>DETALLE</th>
            <th width='8%'>USUARIO</th>
            <th width='11%'>ENCARGADO</th>
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
              <option value='balance'>BALANCE</option>
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
            <div id='canvas' width='100%' height='350px'></div>
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