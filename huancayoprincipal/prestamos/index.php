<?php 
session_start();
if($_SESSION['valida']=='huancayoprincipal' && $_SESSION['cargo']=='ADMIN' || $_SESSION['cargo']=='ENCARGADOTIENDA') {
?>
<html>
<head>
  <title>PRESTAMOS</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" /> 
<link type="text/css" href="../jquery-ui-1.10.4.custom.min.css" rel="stylesheet" />
<link type="text/css" href="../sweet-alert.css" rel="stylesheet" />
<script type="text/javascript" src="../jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="../jquery-ui-1.10.4.custom.min.js"></script> 
<script type="text/javascript" src="../sweet-alert.min.js"></script>   
<script type="text/javascript" src="prestamos.js"></script>
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
        <tr bgcolor="#FD3434">
          <th colspan="7" style="align:center;font-weight:bold;color:white;font-size:22px">PAGOS DE PRESTAMOS</th>
        </tr>
        <tr bgcolor='#FDBABA'>
          <td  width='10%' rowspan='2'><input type="button" name="buscar" value='AGREGAR NUEVO PRESTAMO' id="registro"></th>
          <td width='10%' align='right' style='font-weight:bold'>FECHA INICIO:</td>
          <td><input type="text" name="fechaini" id="fechaini" style="cursor:pointer;text-align:right" size='9'></td>
          <td width='10%'align='right' style='font-weight:bold'>FECHA FIN:</td>
          <td><input type="text" name="fechafin" id="fechafin" style="cursor:pointer;text-align:right" size='9'></td>
          <td>
            <select id="estado">
              <option value="CANCELADO">CANCELADOS</option>
              <option value="PENDIENTE">PENDIENTES</option>
            </select>
          </td>
          <td><input type="button" name="buscar" value='BUSCAR' id="buscar"></td>
        </tr>
      </table>
    </div>
    <div id="row" style='margin-top:5px'></div>
    <div id='dialog' style='display:none'> 
      <span>TOTAL: <input style='text-align:right' type='text' id='mon' size='12'>&nbsp&nbsp&nbspBANCO: <input type='text' id='banco' size='11'></span></br>
      <span><input type='button' value='AGREGAR' id='add'>&nbsp&nbsp&nbspDOCUMENTO:&nbsp<input type='text' id='doc' size='11'></span></br>
    </div>
</body>
</html>
<?php }else{
  header("Location: ../");
} ?>
