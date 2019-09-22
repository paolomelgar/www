<?php 
session_start();
if($_SESSION['valida']=='pharmagroup'){
?>
<html>
<head>
	<title>CRONOGRAMA DE COBROS</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 
	<link type="text/css" href="../jquery-ui-1.10.4.custom.min.css" rel="stylesheet" />
	<link type="text/css" href="../bootstrap.min.css" rel="stylesheet" />
    <link type="text/css" href="../sweet-alert.css" rel="stylesheet" />
	<script type="text/javascript" src="../jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="../jquery-ui-1.10.4.custom.min.js"></script>  
    <script type="text/javascript" src="../sweet-alert.min.js"></script>  
	<script type="text/javascript" src="calendar.js"></script>
	<style type="text/css">
		.selected {
		    background: #FF3;
		}
		.select {
		    background: #3FED59;
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
	</style>
</head>
<body>
<table border='0' width='100%' height='100%' id='row' style='border-collapse: collapse;'>
    <thead style='height:20px'>
    	<th style='background-color:#428bca;'><input id='prev' type='button' value='<<' class="btn span1"></th>
        <th colspan='5' style='background-color:#428bca;color:white;font-weight:bold'>
            <select id='month' style='margin-top:10px'>
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
            <select id='year' style='margin-top:10px'>
                <option>2015</option>
                <option>2016</option>
                <option>2017</option>
                <option>2018</option>
                <option>2019</option>
                <option>2020</option>
            </select>
        <th style='background-color:#428bca;'><input id='next' type='button' value='>>' class="btn span1"></th>
    </thead>
    <tbody id='map'></tbody>
</body>
</html>
<?php }else{
  header("Location: ../");
} ?>