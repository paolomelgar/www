<?php 
session_start();
if($_SESSION['valida']=='innova' && $_SESSION['cargo']=='ADMIN' ){
?>
<html>
<head>
    <title>CRONOGRAMA DE PAGOS</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 
    <link type="text/css" href="../jquery-ui-1.10.4.custom.min.css" rel="stylesheet" />
    <link type="text/css" href="../bootstrap.min.css" rel="stylesheet" />
    <link type="text/css" href="../sweet-alert.css" rel="stylesheet" />
    <script type="text/javascript" src="../jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="../bootstrap.min.js"></script>
    <script type="text/javascript" src="../jquery-ui-1.10.4.custom.min.js"></script>  
    <script type="text/javascript" src="../sweet-alert.min.js"></script>  
    <script type="text/javascript" src="calendar.js"></script>
    <style type="text/css">
        .cuad:hover {
            background: #FF3 !important;
        }
        .ui-tooltip {
            padding: 10px 20px;
            border-radius: 20px;
            font: bold 15px Sans-Serif;
            box-shadow: 0 0 7px black;
        }
        body{
            overflow: hidden;
        }
        .modal-header, h4, .close {
          background-color: #5cb85c;
          color:white !important;
          text-align: center;
          font-size: 30px;
        }
    </style>
</head>
<body>
<table width='100%' height='100%'>
    <thead style='height:20px' class='btn-primary'>
        <tr>
            <th><input id='prev' type='button' value='<<' class="btn span1"></th>
            <th colspan='5' style='font-weight:bold'>
                <select id='month' style='margin-top:10px' class='span2'>
                    <option value='1'>ENERO</option>
                    <option value='2'>FEBRERO</option>
                    <option value='3'>MARZO</option>
                    <option value='4'>ABRIL</option>
                    <option value='5'>MAYO</option>
                    <option value='6'>JUNIO</option>
                    <option value='7'>JULIO</option>
                    <option value='8'>AGOSTO</option>
                    <option value='9'>SETIEMBRE</option>
                    <option value='10'>OCTUBRE</option>
                    <option value='11'>NOVIEMBRE</option>
                    <option value='12'>DICIEMBRE</option>
                </select>
                <select id='year' style='margin-top:10px' class='span2'>
                    <option>2015</option>
                    <option>2016</option>
                    <option>2017</option>
                    <option>2018</option>
                    <option>2019</option>
                    <option>2020</option>
                </select>
            <th><input id='next' type='button' value='>>' class="btn span1"></th>
        </tr>
        <tr style='color:white;font-weight:bold;background-color:#585858;' align='center' height='25px'>
            <td width='14.3%'>LUNES</td>
            <td width='14.3%'>MARTES</td>
            <td width='14.3%'>MIERCOLES</td>
            <td width='14.3%'>JUEVES</td>
            <td width='14.3%'>VIERNES</td>
            <td width='14.3%'>SABADO</td>
            <td width='14.2%'>DOMINGO</td>
        </tr>
    </thead>
    <tbody id='map'>
    </tbody>
</table>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Editar</h4>
        </div>
        <div class="modal-body" style="padding:40px 50px;">   
              <div class='un'><input type="text" class="span3" id="unico" placeholder="Editar N° Unico" style='height:30px;margin-bottom:0px;margin-right:20px'><input type="submit" id='realunico' class="btn btn-success span2" value='Editar N° Unico'><hr></div>
              <div><input type="text" class="span3" id="fecha" placeholder="Editar Fecha de Pago" style='height:30px;margin-bottom:0px;margin-right:20px'><input type="submit" id='realfecha' class="btn btn-success span2" value='Editar Fecha de Pago'></div>
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