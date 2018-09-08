<?php 
session_start();
if($_SESSION['valida']=='huancayoprincipal' && $_SESSION['cargo']=='ADMIN' || $_SESSION['cargo']=='ASISTENTE' || $_SESSION['cargo']=='LOGISTICA'){
?>
<html>
<head>
  <title>PAGO PROVEEDORES</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" /> 
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
    background: #FF3;
  }
  .select {
    background: #F63;
  }
  .ui-widget{
    font-family: "Times New Roman";
   }
   .ui-dialog .ui-dialog-title {
    text-align: center;
    width: 100%;
  }
</style>
</head>
<body id='body'>
    <div id="informacion">
      <table width="100%" style='border-collapse:collapse'>
        <tr bgcolor="#FFFF00">
          <th colspan="6" style="align:center;font-weight:bold;font-size:22px;color:white;background-color:#5F3505">PAGO CREDITOS PROVEEDORES</th>
        </tr>
        <tr bgcolor='#F7BC78'>
          <th width='10%' rowspan='2' align="right">PROVEEDOR:</th>
          <td width='30%' rowspan='2'>
            <input type="text" name="proveedor" id="proveedor" title="Llenar Proveedor" size="40" style="text-transform:uppercase;float:left"/>
            <div id='resultproveedor'></div>
          </td>
          <td width='10%' >FECHA INICIO:</td>
          <td width='20%'><input type="text" name="fechaini" id="fechaini" style="cursor:pointer;text-align:right" size='9'></td>
          <td width='20%'>
            <select id="estado">
              <option value="CANCELADO">CANCELADOS</option>
              <option value="PENDIENTE">PENDIENTES</option>
            </select>
          </td>
          <td width='10%'><input style='display:none' type='button' value='PAGAR' class='cobrar'><input style='display:none' type='button' value='PAGAR LETRA' class='pagar'></td>
        </tr>
        <tr bgcolor='#F7BC78'>
          <td>FECHA FIN:</td>
          <td><input type="text" name="fechafin" id="fechafin" style="cursor:pointer;text-align:right" size='9'></td>
          <td><input type="button" name="buscar" value='BUSCAR' id="buscar"></td>
          <td><input style='display:none' type='button' value=' DIVIDIR EN LETRAS' id='letras'></td>
        </tr>
      </table>
    </div>
    <div id="row" style='margin-top:5px'></div>
    <div id='dialog' style='display:none'> 
      <table width='100%'>
        <tr>
          <td colspan='2' style='width:65%'>PROVEEDOR: <input type='text' id='name' size='47' readonly='readonly'></td>
          <td style='width:35%'>TOTAL COMPRA: <input type='text' id='total' readonly='readonly' size='10' style='text-align:right'></td>
        </tr>
        <tr>
          <td style='width:35%'>FORMA-COBRO:
            <select id='forma'>
              <option value='DEPOSITO'>DEPOSITO</option>
              <option value='EFECTIVO'>EFECTIVO</option>
            </select>
          </td>
          <td style='width:30%'><div id='banco1' style='display:none'>BANCO: <input type='text' id='banco' size='13' style="text-transform:uppercase;border:2px solid red;text-align:right"></div></td>
          <td style='width:35%'><div id='nro1' style='display:none'>Nro OP. <input type='text' id='nro' size='17' style='border:2px solid red;text-align:right'></div></td>
        </tr>
        <tr>
          <td style='width:35%'>PENDIENTE: <input type='text' id='pendiente' size='13' style='border:2px solid red;text-align:right'></td>
          <td style='width:30%'>A/CUENTA:  <input type='text' id='monto' size='10' style='text-align:right'></td>
          <td id='tipocambio' style='width:30%;display:none'>TIPO CAMBIO:  <input type='text' id='cambio' size='10' style='text-align:right;border:2px solid red'></td>
        </tr>
      </table>
    </div>
    <div id='dialogpagoletra' style='display:none'> 
      <table width='100%'>
        <tr>
          <td colspan='2' width='100%'>PROVEEDOR: <input type='text' id='name1' size='25' readonly='readonly'></td>
        </tr>
        <tr>
          <td>TOTAL: <input type='text' id='total1' readonly='readonly' size='10' style='text-align:right'></td>
          <td id='cambio1'>T.CAMBIO: <input type='text' id='cambio2' size='5' style='text-align:right;border:2px solid red'></td>
        </tr>
      </table>
      <div id='letras1'></div>
    </div>
    <div id='dialogletra' style='display:none'>
      <span><input type='button' value='AGREGAR' id='addletra'>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<input style='text-align:right' type='text' id='mon' size='13'></span>
      <span style='margin-bottom:-10px;margin-top:5px'>&nbsp&nbsp&nbspMONTO&nbsp&nbspFECHA PAGO&nbsp&nbspN&deg UNICO</span>
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
</body>
</html>
<?php }else{
  header("Location: ../");
} ?>
