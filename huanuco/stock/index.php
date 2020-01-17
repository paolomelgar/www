<html>
<head>
  <title>CORRECCION UBICACION</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link type="text/css" href="../bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css"/>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link type="text/css" href="../jquery-ui-1.10.4.custom.min.css" rel="stylesheet" />
  <link type="text/css" href="../sweet-alert.css" rel="stylesheet" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script type="text/javascript" src="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js"></script>
  <script type="text/javascript" src="../bootstrap.min.js"></script>
  <script type="text/javascript" src="../jquery-ui-1.10.4.custom.min.js"></script>
  <script type='text/javascript' src='../picnet.table.filter.min.js'></script> 
  <script type="text/javascript" src="../sweet-alert.min.js"></script>
  <script type="text/javascript" src="../jquery.longpress.js"></script>
  <script type="text/javascript" src="../Chart.min.js"></script>
  <script src="../socket.io.js"></script>
  <script type="text/javascript" src="mobile.js"></script>
  <style type="text/css"> 
    .error {
      width:300px;
      height:20px;
      height:auto;
      position:absolute;
      left:50%;
      margin-left:-100px;
      bottom:10px;
      background-color: black;
      color: #F0F0F0;
      font-family: Calibri;
      font-size: 20px;
      padding:10px;
      text-align:center;
      border-radius: 2px;
      z-index:1000;
      -webkit-box-shadow: 0px 0px 24px -1px rgba(56, 56, 56, 1);
      -moz-box-shadow: 0px 0px 24px -1px rgba(56, 56, 56, 1);
      box-shadow: 0px 0px 24px -1px rgba(56, 56, 56, 1);
      pointer-events:none;
      opacity:0.5;
  }
  </style>
  <script type="text/javascript">
  	$(function(){
  		$(document).tooltip({
		position: {
        	my: "left top",
        	at: "right top",
        },
      	content: function() {
        	return $(this).html();
        }
    });
  		var typingTimer;                     
    $("#producto").focus();  
    $("#producto").keyup(function(e){    
      clearTimeout(typingTimer);
      if ($('#producto').val) {
          typingTimer = setTimeout(function(){    
          $.ajax({
            type: "POST",
            url: "datos.php",
            data: {
              b:$('#producto').val()
            },
            beforeSend:function(){
                swal({
                  title: "Cargando..",
                  text: "",
                  imageUrl: "../loading.gif",
                  showConfirmButton: false,
                  allowOutsideClick:false
                });
            },
            success: function(data){   
              swal.close();
                $("#resultado").empty();
                $("#resultado").append(data);
            }
        });
        }, 500);   
      }
    });
    
	$('#resultado').on('click','.text',function () {
        document.execCommand('selectAll', false, null);
    });
    $('#resultado').on('focusout','td[contenteditable=true]',function(){
		$("#busqueda").focus();
		$.ajax({
            type: "POST",
            url: "corregir.php",
            data: "val="+$(this).text()+"&pos="+$(this).index()+"&id="+$(this).parent().find('td:eq(0)').text(),
            success: function(data){   
                $('.error').fadeIn(400).delay(2000).fadeOut(400);
            }
        });
	});
    });

  </script>
</head>
<body>
	<div class='error' style='display:none'>Guardado Correctamente</div>
	<input type="text" id="producto" class='span8' title="Buscar Producto" style="text-transform:uppercase;"/>
  <table width='100%' class="table table-bordered">
  	<thead>
          <tr style='background-color:#428bca;color:white'>
              <th style="text-align: center;width:10%;max-width:36px">IMG</th>
              <th style="text-align: center;width:70%">PRODUCTO</th>
              <th style="text-align: center;width:10%">UBICACION</th>
              <th style="text-align: center;width:10%">X/CAJA</th>
          </tr>
      </thead>
  	<tbody id="resultado">  
         
      </tbody>
  </table>
</body>
</html>
