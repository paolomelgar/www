<!DOCTYPE html>
<?php 
session_start();
if($_SESSION['valida']=='huancayo' && $_SESSION['cargo']!='VENDEDOR') {
?>
<html>
<head>
  <title>COBRO CLIENTES</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 
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
  .fila:hover {
    background-color: #8BFFE0;
  }
  .select {
    background-color: #F63 !important;
  }
  .ui-widget{
    font-family: "Times New Roman";
   }
   .ui-dialog .ui-dialog-title {
    text-align: center;
    width: 100%;
  }
  #mes{
    padding: 0px 3px;
    border-radius: 10px;
    background-color: red;
    font-size: 15px;
    font-weight: bold;
    color: #fff;
    position: absolute;
    top: 0px;
    left: 33px;
  }
  input{
    margin-bottom: 0px !important;
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
  .pago{
    display: none;
  }
</style>
</head>
<body id='body'>
  <form id="form" name="form" action="" method="post" autocomplete="off">
    <div id="informacion">
      <h3 style='color:white;text-align:center;margin-top:0px;margin-bottom:0px;' class='btn-danger'>COBRO CLIENTES</h3>
      <a style="position:absolute;left:800px;top:3px;cursor:pointer;" id="mostrarpendientes">
        <img src="../caja/boom.png" style="width:30px;margin-top:5px;margin-left:20px"/>
        <span id="mes"></span>
      </a>
      <table width="100%">
        <tr bgcolor='#f2dede'>
          <td width='35%' style='padding:5px'>CLIENTE:<input type="text" name="cliente" id="cliente" class='span4' style="text-transform:uppercase;"/></td>
          <td width='15%' style='padding:5px'>FECHA INICIO:<input type="text" name="fechaini" id="fechaini" style="cursor:pointer;text-align:right;width:80px;"></td>
          <td width='15%' style='padding:5px'>FECHA FIN:<input type="text" name="fechafin" id="fechafin" style="cursor:pointer;text-align:right;width:80px;"></td>
          <td width='15%' style='padding:5px'>
            <select id="estado" name='estado' class='span2' style='margin-bottom:0px'>
              <option value="PENDIENTE">PENDIENTES</option>
              <option value="CANCELADO">CANCELADOS</option>
            </select>
          </td>
          <td width='10%' style='padding:5px'><input type="button" name="buscar" value='BUSCAR' id="buscar" class='btn btn-success'></td>
          <td width='10%' style='padding:5px'><input type="button" value='COBRAR' id="cobrar" class='btn btn-info' style='display:none'></td>
        </tr>
      </table>
    </div>
  </form>
    <div id='pendientes' style='display:none'>
      <select id='vend'>
      </select>
      <div id='acuenta'></div>
    </div>
    <div id="row" style='margin-top:-20px'>
      <table width='100%' align='center' style='border-collapse:collapse;'>
        <thead>
          <tr bgcolor="black" style="color:white;font-weight:bold;" >
            <th width="2%"></th>
            <th width="13%">VENDEDOR</th>
            <th width="5%">SERIE</th>
            <th width="20%">CLIENTE</th>
            <th width="10%">TOTAL</th>
            <th width="10%">PENDIENTE</th>
            <th width="10%">ADELANTO</th>
            <th width="10%">F. EMISION</th>
            <th width="10%">DIAS</th>
            <th width="10%">DETALLES</th>
          </tr>
        </thead>
      </table>
      <div style="overflow-y:overlay;overflow-x:hidden;height:295px;align:center">
        <table width='100%' id="venta" border='1' align='center'>
          <thead>
            <tr style='display:none'>
              <th width="2%">a</th>
              <th width="13%">VENDEDOR</th>
              <th width="5%">SERIE</th>
              <th width="20%">CLIENTE</th>
              <th width="10%">TOTAL</th>
              <th width="10%">PENDIENTE</th>
              <th width="10%">ADELANTO</th>
              <th width="10%">F. EMISION</th>
              <th width="10%">F. VENCIM</th>
              <th width="10%">DETALLES</th>
            </tr>
          </thead>
          <tbody id="verbody" style='font-weight:bold'>
          </tbody>
        </table>
      </div>
      <table width='100%' align='center' border='1' style='font-size:16px;font-weight:bold'>
        <tr>
          <td width='40%'align='right'>TOTALES</td>
          <td width='10%' id='sumatotal' align='right'></td>
          <td width='10%' style="background-color:#f63;color:blue" id='sumapendiente' align='right'></td>
          <td width='10%' id='sumaacuenta' align='right'></td>
          <td width='30%'></td>
        </tr>
      </table>
    </div>
    <div id='dialog' style='display:none'> 
      <table width='100%'>
        <tr>
          <td width='10%' align='right'>CLIENTE:</td>
          <td width='55%' colspan='3'><input type='text' id='name' class='span4' readonly='readonly'></td>
          <td width='15%' align='right'>TOTAL VENTA:</td>
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
          <td width='15%' align='right'>ENCAR:</td>
          <td width='20%'>
            <?php 
              require_once('../connection.php');
              $q=mysqli_query($con,"SELECT * FROM usuario WHERE activo='SI' AND cargo!='CLIENTE' AND cargo!='CLIENTE ESPECIAL'");
                      ?>
            <select id="vendedor" class='span2' style='margin-bottom:0px'>
              <?php while ($row=mysqli_fetch_assoc($q)){?>
              <option value="<?php echo $row['nombre']?>"><?php echo $row['nombre']?></option>
              <?php } ?>
            </select>
          </td>
        </tr>
      </table>
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
    <div id='dx' style='display:none'></div>
</body>
</html>
<?php }else{
  header("Location: ../");
} ?>
