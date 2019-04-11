<!DOCTYPE html>
<html>
<head>
	<title>QUERY</title>
	<meta charset="utf-8" />
	<link type="text/css" href="../bootstrap.min.css" rel="stylesheet" />
	<link type="text/css" href="../jquery-ui-1.10.4.custom.min.css" rel="stylesheet" />
	<script type="text/javascript" src="../jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="../bootstrap.min.js"></script>
	<script type="text/javascript" src="../jquery-ui-1.10.4.custom.min.js"></script>
	<script type="text/javascript">
		$(function(){
			$('#query').focus();
			$('#buscar').click(function(){
				$('#result').empty();
				$.ajax({
			      type: "POST",
			      url: "query.php",
			      data: 'query='+$('#query').val(),
			      cache: false,
			      success: function(data){
			        $('#result').append(data);
			        $( "th" ).resizable({ grid: [1, 10000] });
			      }
			    });
			});
			$('#query').keyup(function(e){
				if(e.which==13){
					$('#result').empty();
					$.ajax({
				      type: "POST",
				      url: "query.php",
				      data: 'query='+$('#query').val(),
				      cache: false,
				      success: function(data){
				        $('#result').append(data);
				        $( "th" ).resizable({ grid: [1, 10000] });
				      }
				    });
				}
			});
			$('#sel').change(function(){
				if($(this).val()=='negativos'){
					$.ajax({
				      type: "POST",
				      url: "query.php",
				      data: 'query=SELECT * FROM producto WHERE stock_real<0',
				      cache: false,
				      success: function(data){
				        $('#result').append(data);
				        $( "th" ).resizable({ grid: [1, 10000] });
				        $('#result').scrollTo(0,1000000000);
				      }
				    });
				}
			});
			$('#clear').click(function(){
				$('#result').empty();
			})
		});
	</script>
</head>
<body>
QUERY:<input type='text' class='span5' id='query' style='margin-top:4px'>
<input type='button' id='buscar' value='Buscar' class="btn btn-success" style='margin-top:-4px'>
<select id='sel'>
	<option value='0'>----------</option>
	<option value='negativos'>STOCK NEGATIVO</option>
</select>
<input type='button' id='clear' value='Clear' class="btn btn-danger" style='margin-right:50px;float:right;margin-top:4px'><br>
<div style='float:left'>RESUL:</div><div id='result' style='height:500px;float:left;margin-left:2px;overflow:auto;width:90%;padding: 9px 14px;margin-bottom: 14px;background-color: #ffffff;border: 1px solid #ccc;border-radius:4px;'></div>
</body>
</html>