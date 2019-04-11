<?php 
require_once('../connection.php');
if($_SESSION['valida']=='huancayoprincipal' && $_SESSION['cargo']!='VENDEDOR') {
?>
<html>
<head>
  <title>COBRO CLIENTES</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 
<link type="text/css" href="../jquery-ui-1.10.4.custom.min.css" rel="stylesheet" />
<link type="text/css" href="../sweet-alert.css" rel="stylesheet" />
<script type="text/javascript" src="../jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="../jquery-ui-1.10.4.custom.min.js"></script>  
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
    background: #8BFFE0 !important;
  }
  .select {
    background: #F63 !important;
  }
  .selectc {
    background: #4AD074;
  }
  .ui-widget{
    font-family: "Times New Roman";
   }
   .ui-dialog .ui-dialog-title {
    text-align: center;
    width: 100%;
  }
  h3{
    border:1px solid red;
  }
  #mes{
    padding: 0px 3px;
    border-radius: 3px 3px 3px 3px;
    background-color: rgb(240, 61, 37);
    font-size: 15px;
    font-weight: bold;
    color: #fff;
    position: absolute;
    top: 0px;
    left: 33px;
  }
</style>
</head>
<body id='body'>
    <div id="informacion">
      <table width="100%" style='border-collapse:collapse'>
        <tr bgcolor="#BF00FF">
          <th colspan="6" style="align:center;font-weight:bold;color:white;font-size:22px">
            COBRO CREDITOS CLIENTES
            <a style="position:absolute;left:1050;top:8px;cursor:pointer;" id="mostrarpendientes">
              <img src="../caja/boom.png" style="width:30px;margin-top:5px;margin-left:5px"/>
              <span id="mes"></span>
            </a>
          </th>
        </tr>
        <tr bgcolor='#F2E0F7'>
          <th align="right" width='10%' rowspan='2'>CLIENTE:</th>
          <td width='30%' rowspan='2'>
            <input type="text" name="cliente" id="cliente" title="Llenar Cliente" size="40" style="text-transform:uppercase;float:left"/>
          </td>
          <td width='10%' align='right' style='font-weight:bold'>FECHA INICIO:</td>
          <td><input type="text" name="fechaini" id="fechaini" style="cursor:pointer;text-align:right" size='9'></td>
          <td>
            <select id="estado">
              <option value="CANCELADO">CANCELADOS</option>
              <option value="PENDIENTE">PENDIENTES</option>
            </select>
          </td>
          <td width='15%' rowspan='2'>
            <input type="button" id="juntar" value='GENERAR LETRA' style="cursor:pointer;display:none"/>
          </td>
        </tr>
        <tr bgcolor='#F2E0F7'>
          <td width='10%'align='right' style='font-weight:bold'>FECHA FIN:</td>
          <td><input type="text" name="fechafin" id="fechafin" style="cursor:pointer;text-align:right" size='9'></td>
          <td><input type="button" name="buscar" value='BUSCAR' id="buscar"></td>
        </tr>
      </table>
    </div>
    <div id='pendientes' style='display:none'>
      <select id='vend'>
      </select>
      <div id='acuenta'></div>
    </div>
    <div id="row" style='margin-top:5px'></div>
    <div id='dialog' style='display:none'> 
      <table width='100%'>
        
        <tr>
          <td colspan='2' style='width:65%'>CLIENTE: <input type='text' id='name' size='47' readonly='readonly'></td>
          <td style='width:35%'>TOTAL VENTA: <input type='text' id='total' readonly='readonly' size='10' style='text-align:right'></td>
        </tr>
        <tr>
          <td style='width:35%'>FORMA-COBRO:
            <select id='forma'>
              <option value='EFECTIVO'>EFECTIVO</option>
              <option value='DEPOSITO'>DEPOSITO</option>
              <option value='LETRA'>LETRA</option>
            </select>
          </td>
          <td style='width:30%'><div id='banco1' style='display:none'>BANCO: <input type='text' id='banco' size='13' style="text-transform:uppercase;border:2px solid red;text-align:right"></div></td>
          <td style='width:35%'><div id='nro1' style='display:none'>Nro OP. <input type='text' id='nro' size='17' style='border:2px solid red;text-align:right'></div></td>
        </tr>
        <tr>
          <td style='width:35%'>PENDIENTE: <input type='text' id='pendiente' size='13' style='border:2px solid red;text-align:right'></td>
          <td style='width:30%'>A/CUENTA:  <input type='text' id='monto' size='10' style='text-align:right'></td>
        </tr>
      </table>
    </div>
    <div style="float:left;width:60%">
      <table width='100%'>
          <tr style="color:white;font-weight:bold;background-color:black">
            <th>LISTA PRODUCTOS</th>
          </tr>
      </table >
      <div style="overflow: auto; height: 200px;">
      <table id='productos' width='98%' align='center'></table>
      </div>
    </div>
    <div style="float:left;width:40%">
      <table width="100%">
          <tr style="color:white;font-weight:bold;background-color:black" >
            <th>DETALLE COBROS</th>
          </tr>
      </table>
      <div style="overflow: auto; height: 200px;">
      <table id='adelantos' width='98%' align='center'></table>
      </div>
    </div>
    <div id='dialogletra' style='display:none'>
      <span><input type='button' value='AGREGAR' id='addletra'>&nbsp&nbsp<input style='text-align:right' type='text' id='mon' size='8'>&nbsp&nbsp&nbsp<input type='text' id='ruc' size='11'></span>
      <span style='margin-bottom:-10px;margin-top:5px'>&nbsp&nbsp&nbsp&nbsp&nbspMONTO&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspFECHA PAGO&nbsp&nbsp&nbsp&nbsp&nbsp&nbspFACTURA</span>
    </div>
    <div id='dialogpagoletra' style='display:none'> 
      <table width='100%'>
        <tr>
          <td colspan='2' width='100%'>CLIENTE: <input type='text' id='name1' size='25' readonly='readonly'></td>
        </tr>
        <tr>
          <td>TOTAL: <input type='text' id='total1' readonly='readonly' size='10' style='text-align:right'></td>
        </tr>
      </table>
      <div id='letras1'></div>
    </div>
    <div id='xd' style='display:none'></div>
</body>
</html>
<?php }else{
  header("Location: ../");
} ?>
