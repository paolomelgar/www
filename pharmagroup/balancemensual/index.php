<!DOCTYPE html>
<?php 
session_start();
if($_SESSION['valida']=='pharmagroup' && $_SESSION['cargo']=='ADMIN' || $_SESSION['cargo']=='ASISTENTE' || $_SESSION['cargo']=='LOGISTICA'){
?>
<html>
<head>
  <title>BALANSE MENSUAL</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 
<link type="text/css" href="../bootstrap.min.css" rel="stylesheet" />
<link type="text/css" href="../jquery-ui-1.10.4.custom.min.css" rel="stylesheet" />
<script type="text/javascript" src="../jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="../jquery-ui-1.10.4.custom.min.js"></script>  
<script src="../Chart.min.js"></script>
<script type="text/javascript" src="balance.js"></script>
<style type="text/css">
  body{
  	text-transform: uppercase;
    cursor:pointer;
  }
  #dialogestadistica {
    background-color: #D1FCC2;
    position: absolute;
    display: none;
    margin: 25px auto auto 60px;
    border: solid 1px #2d4b7c;
    border-radius: .5em;
    width: 1200px;
    height: 400px;
    z-index: 4;
    cursor: move;
  }
  .ui-tooltip {
    padding: 10px 20px;
    border-radius: 20px;
    font: bold 12px Sans-Serif;
    box-shadow: 0 0 7px black;
  }
  input{
    margin-bottom: 0px !important;
    margin-left: -5px !important;
  }
</style>
</head>

<body>
<div>
<form id="form1" name="form1" method="post" action="">
  <h3 style='color:white;text-align:center;margin-top:0px;margin-bottom:0px;' class='btn-success'>BALANCE MENSUAL</h3>
  <table width="100%">
    <tr bgcolor='#dff0d8'>
      <td width='40%' style='padding:5px' align='center'>
        MES:
        <select id='month' class='span2' style='margin-bottom:0px'>
          <option value='01'>ENERO</option>
          <option value='02'>FEBRERO</option>
          <option value='03'>MARZO</option>
          <option value='04'>ABRIL</option>
          <option value='05'>MAYO</option>
          <option value='06'>JUNIO</option>
          <option value='07'>JULIO</option>
          <option value='08'>AGOSTO</option>
          <option value='09'>SETIEMBRE</option>
          <option value='10'>OCTUBRE</option>
          <option value='11'>NOVIEMBRE</option>
          <option value='12'>DICIEMBRE</option>
        </select>
      </td>
      <td width='40%' style='padding:5px' align='center'>
        AÑO:
          <select id='year' class='span1' style='margin-bottom:0px'>
            <option>2015</option>
            <option>2016</option>
            <option>2017</option>
            <option>2018</option>
            <option>2019</option>
            <option>2020</option>
          </select>
        </td>
      <td width='20%' style='padding:5px' align='center'><input type="button" name="buscar" value='BUSCAR' id="buscar" class='btn btn-success' style='margin-bottom:0px'></td>
    </tr>
  </table>
  <div id='body'></div>
</form>
</div>
</body>
</html>
<?php }else{
  header("Location: ../");
} ?>