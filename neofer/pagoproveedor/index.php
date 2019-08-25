<!DOCTYPE html>
<?php 
session_start();
if($_SESSION['valida']=='neofer' && $_SESSION['cargo']=='ADMIN' ){
?>
<html>
<head>
  <title>PAGO PROVEEDORES</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" /> 
<link type="text/css" href="../bootstrap.min.css" rel="stylesheet" />
<link type="text/css" href="../jquery-ui-1.10.4.custom.min.css" rel="stylesheet" />
<link type="text/css" href="../sweet-alert.css" rel="stylesheet" />
<script type="text/javascript" src="../jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="../jquery-ui-1.10.4.custom.min.js"></script>  
<script type='text/javascript' src='../picnet.table.filter.min.js'></script> 
<script type="text/javascript" src="../sweet-alert.min.js"></script>
<script type="text/javascript" src="cobranza.js"></script>
<style type="text/css">
  #cabecera{
    background-color: #58ACFA;
    margin-top :-7px;
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
    background: #FF3;
  }
  .fila:hover {
    background-color: #8BFFE0;
  }
  .select {
    background: #F63 !important;
  }
  .ui-widget{
    font-family: "Times New Roman";
   }
   .ui-dialog .ui-dialog-title {
    text-align: center;
    width: 100%;
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
  input{
    margin-bottom: 0px !important;
  }
</style>
</head>
<body id='body'>
  <form id="form" name="form" action="" method="post" autocomplete="off">
    <div id="informacion">
      <h3 style='color:white;text-align:center;margin-top:0px;margin-bottom:0px;background-color:#5F3505'>PAGO PROVEEDORES</h3>
      <table width="100%" style='border-collapse:collapse'>
        <tr bgcolor='#F7BC78'>
          <td width='33%' style='padding:5px'>PROVEEDOR:<input type="text" name="proveedor" id="proveedor" class='span3' style="text-transform:uppercase;"/></td>
          <td width='15%' style='padding:5px'>FECHA INICIO:<input type="text" name="fechaini" id="fechaini" style="cursor:pointer;text-align:right;width:80px;"></td>
          <td width='15%' style='padding:5px'>FECHA FIN:<input type="text" name="fechafin" id="fechafin" style="cursor:pointer;text-align:right;width:80px;"></td>
          <td width='15%' style='padding:5px'>
            <select id="estado" name='estado' class='span2' style='margin-bottom:0px'>
              <option value="PENDIENTE">PENDIENTES</option>
              <option value="CANCELADO">CANCELADOS</option>
            </select>
          </td>
          <td width='10%' style='padding:5px'><input type="button" name="buscar" value='BUSCAR' id="buscar" class='btn btn-success'></td>
          <td width='12%' style='padding:5px' align='center'><input style='display:none' type="button" value='PAGAR' id="pagar" class='btn btn-info'><input style='display:none' type='button' value='PAGAR LETRA' id='pagarletra' class='btn btn-danger'></td>
      </table>
    </div>
  </form>
  <div id="row" style='margin-top:-20px'>
      <table width='100%' align='center' style='border-collapse:collapse;'>
        <thead>
          <tr bgcolor="black" style="color:white;font-weight:bold;" >
            <th width="11%">SERIE</th>
            <th width="24%">PROVEEDOR</th>
            <th width="10%">TOTAL</th>
            <th width="10%">PENDIENTE</th>
            <th width="10%">ADELANTO</th>
            <th width="10%">F. EMISION</th>
            <th width="10%">F. VENCIM</th>
            <th width="5%">DIAS</th>
            <th width="10%">DETALLES</th>
          </tr>
        </thead>
      </table>
      <div style="overflow-y:overlay;overflow-x:hidden;height:275px;align:center">
        <table width='100%' id="venta" border='1' align='center'>
          <thead>
            <tr style='display:none'>
              <th width="12%">SERIE</th>
              <th width="23%">PROVEEDOR</th>
              <th width="10%">TOTAL</th>
              <th width="10%">PENDIENTE</th>
              <th width="10%">ADELANTO</th>
              <th width="10%">F. EMISION</th>
              <th width="10%">F. VENCIM</th>
              <th width="5%">DIAS</th>
              <th width="10%">DETALLES</th>
              <th style='display:none'>DETALLES</th>
            </tr>
          </thead>
          <tbody id="verbody" style='font-weight:bold'>
          </tbody>
        </table>
      </div>
      <table width='100%' align='center' border='1' style='font-size:15px;font-weight:bold'>
        <tr>
          <td width='35%'align='right'>TOTALES</td>
          <td width='10%' id='sumatotal' align='right'></td>
          <td width='10%' style="background-color:#f63;color:blue" id='sumapendiente' align='right'></td>
          <td width='10%' id='sumaacuenta' align='right'></td>
          <td width='35%' align='right'><input style='display:none' type='button' value=' DIVIDIR EN LETRAS' id='letras' class='btn btn-warning'></td>
        </tr>
      </table>
    </div>
    <div id='dialog' style='display:none'> 
      <table width='100%'>
        <tr>
          <td width='10%' align='right'>PROVEEDOR:</td>
          <td width='55%' colspan='3'><input type='text' id='name' class='span4' readonly='readonly'></td>
          <td width='15%' align='right'>TOTAL COMPRA:</td>
          <td width='20%' ><input type='text' id='total' class='span2' style='text-align:right' readonly='readonly'></td>
        </tr>
        <tr>
          <td width='10%' align='right'>Tipo-COBRO:</td>
          <td width='20%'>
            <select id='forma' class='span2' style='margin-bottom:0px'>
              <option value='EFECTIVO'>EFECTIVO</option>
              <option value='DEPOSITO'>DEPOSITO</option>
            </select>
          </td>
          <td width='15%' class='pago' align='right'>BANCO:</td>
          <td width='20%' class='pago' ><input type='text' id='banco' class='span2' style="text-transform:uppercase;border:1px solid red;text-align:right"></td>
          <td width='15%' class='pago' align='right'>Nro OP:</td>
          <td width='20%' class='pago' ><input type='text' id='nro' class='span2' style='border:1px solid red;text-align:right'></td>
        </tr>
        <tr>
          <td width='10%' align='right'>PENDIENTE:</td>
          <td width='20%'><input type='text' id='pendiente' class='span2' style='border:1px solid red;text-align:right'></td>
          <td width='15%' align='right'>A/CUENTA: </td>
          <td width='20%'><input type='text' id='monto' class='span2' style='text-align:right'></td>
          <td width='15%' align='right'><div class='cambio'>TIPO CAMBIO:</div></td>
          <td width='20%'><input type='text' id='tipocambio' class='span2 cambio' style='border:1px solid red;text-align:right'></td>
        </tr>
      </table>
    </div>
    <div id='dialogpagoletra' style='display:none'> 
      <table width='100%'>
        <tr>
          <td colspan='2' width='100%'>PROVEEDOR: <input type='text' id='name1' class='span4' readonly='readonly'></td>
        </tr>
        <tr>
          <td>TOTAL: <input type='text' id='total1' readonly='readonly' style='width:150px;text-align:right'></td>
          <td id='cambio1'>T.CAMBIO: <input type='text' id='cambio2' style='width:100px;text-align:right;border:1px solid red'></td>
        </tr>
      </table>
      <div id='letras1'></div>
    </div>
    <div id='dialogletra' style='display:none'>
      <span><input type='button' value='AGREGAR' id='addletra' class='btn btn-success'>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input align='right' style='text-align:right' type='text' id='mon' class='span2'></span>
      <span style='margin-top:8px'>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspMONTO&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspFECHA PAGO&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspN&deg UNICO</span>
    </div>
    <div style="float:left;width:60%" align='center'>
      <table width='99%'>
          <tr style="color:white;font-weight:bold;background-color:black">
            <th>LISTA PRODUCTOS</th>
          </tr>
      </table >
      <div style="overflow: auto; height: 200px;width:98%">
      <table id='productos' align='center' width='100%'></table>
      </div>
    </div>
    <div style="float:left;width:40%" align='center'>
      <table width="99%">
          <tr style="color:white;font-weight:bold;background-color:black" >
            <th>DETALLE COBROS</th>
          </tr>
      </table>
      <div style="overflow: auto; height: 200px;width:98%">
      <table id='adelantos' width='100%' align='center'></table>
      </div>
    </div>
</body>
</html>
<?php }else{
  header("Location: ../");
} ?>
