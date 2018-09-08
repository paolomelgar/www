
<html>
<head>
  <title>KARDEX CLIENTES</title>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 
  <link type="text/css" href="../jquery-ui-1.10.4.custom.min.css" rel="stylesheet" />
  <script type="text/javascript" src="../jquery-1.11.1.min.js"></script>
  <script type="text/javascript" src="../jquery-ui-1.10.4.custom.min.js"></script>  
  <script type="text/javascript" src="cliente.js"></script>
  <style type="text/css">
    .con{
      color: red;
    }
    .selected {
      cursor: pointer;
      background: #FF3;
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
  </style>
</head>
<body>
<form id="form" action="" method="post">
  <table width='100%' style='border-collapse:collapse'>
    <tr><td colspan='9' align='center' style='font-size:22px;font-weight:bold;background-color:#28ABDD;color:white'>KARDEX DE CLIENTES</td></tr>
    <tr style='height:35px;background-color:#E0ECF8'>
      <td style='text-align:right'>CLIENTE:</td>
      <td><input type='text' id='cliente' name='cliente' size='40'></td>
      <td style='text-align:right'>FECHA INICIO:</td>
      <td><input type='text' id='inicio' name='inicio' size='9' style='text-align:right'></td>
      <td style='text-align:right'>FECHA FINAL:</td>
      <td><input type='text' id='final' name='final' size='9' style='text-align:right'></td>
      <td style='text-align:right'>VENTA:</td>
      <td>
        <select id='change' name='change'>
          <option value"REAL">REAL</option>
          <option value"CONTABLE">CONTABLE</option>
        </select>
      </td>
      <td><input type='button' id='buscar' value='BUSCAR'></td>
    </tr>
  </table>
</form>
<div id="row" style='margin-top:-15px'></div>
</body>
</html>