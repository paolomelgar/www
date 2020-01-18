<html>
<head>
  <title>PEDIDOS</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css"/>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link type="text/css" href="../bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link type="text/css" href="../jquery-ui-1.10.4.custom.min.css" rel="stylesheet" />
  <link type="text/css" href="../sweet-alert.css" rel="stylesheet" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script type="text/javascript" src="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js"></script>
  <script type="text/javascript" src="../jquery-ui-1.10.4.custom.min.js"></script>
  <script type='text/javascript' src='../picnet.table.filter.min.js'></script> 
  <script type="text/javascript" src="../sweet-alert.min.js"></script>
  <script type="text/javascript" src="../jquery.longpress.js"></script>
  <script type="text/javascript" src="../Chart.min.js"></script>
  <script src="../socket.io.js"></script>
  <script type="text/javascript" src="mobile.js"></script>
  <style type="text/css"> 
    .selected {
    cursor: pointer;
    background: #99FDFF !important;
  }
  </style>
  <script type="text/javascript">
  	$.ajax({
      type: "POST",
      url: "pendiente.php",
      data: "",
      beforeSend:function(){
        $('#verpendientes').empty();
        $('#verpendientes').append("<table width='100%'><tr><td align='center'><img src='../loading.gif' width='400px'></td></tr></table>");
      },
      success:function(data){
        $('#verpendientes').empty();
        $('#verpendientes').append(data);
        $('.buscar').click(function(){
    	var pendi=$(this).find('td:eq(0)').text();
    	$("#verpendientes tr").removeClass('selected');
		$(this).addClass('selected');
    	swal({
	      title: "Esta Seguro de Procesar el Pedido!",
	      text: "",
	      type: "warning",
	      showCancelButton: true,
	      confirmButtonColor: "#DD6B55",
	      confirmButtonText: "Aceptar",
	      cancelButtonText: "Cancelar"
	    },
	    function(isConfirm){
	      if (isConfirm) {
	        $.ajax({
		        type:"POST",
		        url:"procesar.php",
		        dataType:"json",
		        data:"ver="+pendi,
		        success:function(data){
		        	data[0].sort(function(a, b) {
		                return a[7] - b[7];
		            });
		        	var i=0;
		        	$('#verpendientes').empty();
		            	var next= "<table width='100%'>\n" +
		                      "<tr><td align='center' style='color:blue;font-size:15px'>" + data[0][i][5] +"</td></tr>\n" +
		                      "<tr><td style='padding:0px;' align='center'><img src='../fotos/producto/a"+data[0][i][2]+".jpg?timestamp=23124' width='300px' height='300px'></td></tr>\n"+
		                      "<tr><td align='center' style='color:gray;font-size:22px'>" + data[0][i][0] +"</td></tr>\n" +
		                      "<tr><td align='center' style='color:red;font-size:35px'>" + data[0][i][1] +"</td></tr>\n" +
		                      "<tr><td align='center' style='font-size:22px'>UBICACION: " + data[0][i][4] +"</td></tr>\n" +
		                      "<tr><td align='center'>STOCK: "+data[0][i][3]+"</td></tr>\n" +
		                      "<tr><td align='center'>CANT CAJA: "+data[0][i][6]+"</td></tr>\n" +
		                      "<tr><td align='center' height='120px'><button class='next btn btn-success'>NEXT</button></td></tr>\n" +
		                      "<tr><td align='center'>"+(i+1)+"/"+data[0].length+"</td></tr>\n" +
		                      "</table>";
		                      $('#verpendientes').append(next);
		            $('#verpendientes').on('click','.next',function(){
		            	i++;
		            	if(i<data[0].length){
			            	$('#verpendientes').empty();
			            	var next= "<table width='100%'>\n" +
			            		  "<tr><td align='center' style='color:blue;font-size:15px'>" + data[0][i][5] +"</td></tr>\n" +
			                      "<tr><td style='padding:0px;' align='center'><img src='../fotos/producto/a"+data[0][i][2]+".jpg?timestamp=23124' width='300px' height='300px'></td></tr>\n"+
			                      "<tr><td align='center' style='color:gray;font-size:22px'>" + data[0][i][0] +"</td></tr>\n" +
			                      "<tr><td align='center' style='color:red;font-size:35px'>" + data[0][i][1] +"</td></tr>\n" +
			                      "<tr><td align='center' style='font-size:22px'>UBICACION: " + data[0][i][4] +"</td></tr>\n" +
			                      "<tr><td align='center'>STOCK: "+data[0][i][3]+"</td></tr>\n" +
			                      "<tr><td align='center'>CANT CAJA: "+data[0][i][6]+"</td></tr>\n" +
			                      "<tr><td align='center' height='120px'><button class='next btn btn-success'>NEXT</button></td></tr>\n" +
			                      "<tr><td align='center'>"+(i+1)+"/"+data[0].length+"</td></tr>\n" +
			                      "</table>";
			            $('#verpendientes').append(next);
			        }else{
			        	$('#verpendientes').empty();
			            	var next= "<table width='100%'>\n" +
			                      "<tr><td align='center' style='color:red;font-size:40px' height='300px'>FIN DEL PEDIDO</td></tr>\n" +
			                      "<tr><td align='center'><button id='inicio' class='next btn btn-primary'>IR A INICIO</button></td></tr>\n" +
			                      "</table>";
			            $('#verpendientes').append(next);
			            $('#inicio').click(function(){
			            	location.reload();
			            });
			        }
		            });
		        }
		      });
	      } 
	    });
    });
      }
    });

  </script>
</head>
<body>
  <div id='verpendientes'>
  	
  </div>
</body>
</html>
