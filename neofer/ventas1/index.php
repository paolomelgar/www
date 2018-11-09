<html>
<title>TIENDA</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script type="text/javascript" src="../jquery-1.11.1.min.js"></script>
<script type="text/javascript">
$(function(){
	var stock,compra,promotor,unit;
  function producto(consulta,e,result){
    if(e.which!=13 && e.which<37 || e.which>40){
      $.ajax({
        type: "POST",
        url: "producto.php",
        data: {b:consulta},
        cache: false,
        success: function(data){
          if(consulta!=''){
            $("#result").empty();
            $("#result").append(data);
            if($('#result >tr').length =="0"){
              $("#result").hide();
            }else{
              $('#result').show();
            }
          }else{
            $("#result").hide();
          }
          $('#result> tr:even').addClass('par');
          $('#result> tr:odd').addClass('impar');
          $("#result> tr").hover(
            function () {
              $('#result> tr').removeClass('selected');
              $(this).addClass('selected');
              x=$(this).index();
            }, 
            function () {
              $(this).removeClass('selected');
            }
          );
          $('#result tr').click(function(){
            var id=$('#result>tr:eq('+x+')').find('td:eq(1)').text();
            var producto=$('#result>tr:eq('+x+')').find('td:eq(2)').text()+" "+$('#result>tr:eq('+x+')').find('td:eq(3)').text();
            compra=parseFloat($('#result>tr:eq('+x+')').find('td:eq(4)').text());
            stock=parseFloat($('#result>tr:eq('+x+')').find('td:eq(6)').text());
            promotor=parseFloat($('#result>tr:eq('+x+')').find('td:eq(7)').text()).toFixed(2);
            unit=parseFloat($('#result>tr:eq('+x+')').find('td:eq(7)').text()).toFixed(2);
            $('#row'+result+' tr').each(function () {
              if(producto == $(this).find('td:eq(1)').text()){
                swal("","Este producto ya esta en la lista","error");
                $(this).addClass('mayorstock');
              }
              else{
                $(this).removeClass('mayorstock');
              }
            });
            if ($('#row'+result+' tr').hasClass('mayorstock')) {
              $('#busqueda'+result).val(consulta);
              $('#cantidad'+result).val("");
              $('#precio_u'+result).val("");
              $('#importe'+result).val("");
              $('#id'+result).val("");
              $('#stock'+result).text("");
              $('#compra'+result).val("");
              $('#promotor'+result).val("");
              $("#result"+result).hide();
              $("#busqueda"+result).focus();
            }
            else{
              anterior($('#razon_social').val(),id);
              $('#busqueda'+result).val(producto);
              $('#cantidad'+result).val("1");
              $('#precio_u'+result).val(promotor);
              $('#importe'+result).val(promotor);
              $('#id'+result).val(id);
              $('#stock'+result).text(stock);
              $('#compra'+result).val(compra);
              $('#promotor'+result).val(promotor);
              $("#result"+result).hide();
              $("#cantidad"+result).focus();
            }
          });
        }
      });
      x=-1;
    }else if (e.which==38) {
      if(x>=0){
        x=x-1;
        $('#result> tr').removeClass('selected');
        $('#result> tr:eq(' + x + ')').addClass('selected');
      }
      else {
        x=x+$('#result >tr').length;
        $('#result> tr').removeClass('selected');
        $('#result> tr:eq(' + x + ')').addClass('selected');
      }
    }else if (e.which==40) {
      if (x<$('#result >tr').length-1) {
        x++;
        $('#result> tr').removeClass('selected');
        $('#result> tr:eq(' + x + ')').addClass('selected');
      }
      else{
        x=x-$('#result >tr').length+1;
        $('#result> tr').removeClass('selected');
        $('#result> tr:eq(' + x + ')').addClass('selected');
      }
    }else if (e.which==13) {
      if ($("#busqueda"+result).val() !=0 && x>=0) {
        $('#result tr').click();
      }
      else{
        $("#busqueda"+result).focus();
        $("#result"+result).hide();
      }
    }
  }
  $("#producto").keyup(function(e){
    $("#result").appendTo("#form");
    var top=parseInt($(this).position().top)+30;
    var left=parseInt($(this).position().left);
    $("#result").css({"top":""+top+"px", "left":""+left+"px"});
    producto($('#producto').val(),e,"");
  }); 
});

</script>
<style>
</style>
<body>
	<form id="form" name="form" action="" method="post" autocomplete="off">
		<div id="result" style='position:absolute;width:100%;display:none;z-index:2'></div>
		<div class=''>
			<div class='w3-twothird w3-padding'>
		    	<div class='w3-border w3-padding'>
		    		<div class="w3-row w3-section">
		    			<div class='w3-col' style="width:100px">Producto</div>
					    <div class="w3-rest">
					      <input class="w3-input w3-border w3-round" name="first" type="text" id='producto'>
					    </div>
					</div>
			    	<div class="w3-row w3-blue w3-center">
					    <div class="w3-col">LISTA DE PRODUCTOS</div>
					</div>
					<div class="w3-row ">
					    <div class="w3-col " style="width:40px"><img src='https://raw.githubusercontent.com/paolomelgar/ferreboom/master/huanuco/producto/a5.jpg?' width='100%' class='img'></div>
					    <div class='w3-rest' style='margin-top:10px'>
						    <div class='w3-half'>ABRAZADERA SIN FIN 5/8"</div>
						    <div class='w3-half'>
							    <div class="w3-col" style="width:25%">NACIONAL</div>
							    <div class="w3-col w3-right-align" style="width:25%" contenteditable='true'>1</div>
							    <div class="w3-col w3-right-align" style="width:25%" contenteditable='true'>0.20</div>
							    <div class="w3-col w3-right-align" style="width:25%">0.20</div>
						    </div>
					    </div>
					</div>
					<div class="w3-row">
					    <div class="w3-col" style="width:40px"><img src='https://raw.githubusercontent.com/paolomelgar/ferreboom/master/huanuco/producto/a5.jpg?' width='100%' class='img'></div>
					    <div class='w3-rest' style='margin-top:10px'>
						    <div class='w3-half'>ABRAZADERA SIN FIN 5/8"</div>
						    <div class='w3-half'>
							    <div class="w3-col" style="width:25%">NACIONAL</div>
							    <div class="w3-col w3-right-align" style="width:25%" contenteditable='true'>1</div>
							    <div class="w3-col w3-right-align" style="width:25%" contenteditable='true'>0.20</div>
							    <div class="w3-col w3-right-align" style="width:25%">0.20</div>
						    </div>
					    </div>
					</div>
				</div>
			</div>
			<div class='w3-third w3-padding'>
				<div class='w3-border'>
					<div class="w3-center w3-blue">INFORMACION DEL CLIENTE</div>
					<div class='w3-padding'>
			        	<div class="w3-row w3-section">
						  <div class="w3-col" style="width:100px">RUC</div>
						    <div class="w3-rest">
						      <input class="w3-input w3-border w3-round" name="first" type="text">
						    </div>
						</div>
						<div class="w3-row w3-section">
						  <div class="w3-col" style="width:100px">CLIENTE</div>
						    <div class="w3-rest">
						      <input class="w3-input w3-border w3-round" name="first" type="text">
						    </div>
						</div>
						<div class="w3-row w3-section">
						  <div class="w3-col" style="width:100px">DIRECCION</div>
						    <div class="w3-rest">
						      <input class="w3-input w3-border w3-round" name="first" type="text">
						    </div>
						</div>
						<div class="w3-row w3-section">
						  <div class="w3-col" style="width:100px">TELEFONO</div>
						    <div class="w3-rest">
						      <input class="w3-input w3-border w3-round" name="first" type="text">
						    </div>
						</div>
						<div class="w3-row w3-section">
						  <div class="w3-col" style="width:100px">NOMBRE TIENDA</div>
						    <div class="w3-rest">
						      <input class="w3-input w3-border w3-round" name="first" type="text">
						    </div>
						</div>
						<div class="w3-row w3-section">
						    <div class="w3-rest" style='background-color:red'>
						      <canvas id="trChart" width="900" height="400" align='center'></canvas>
						    </div>
						</div>
					</div>
				</div>
		    </div>
	    
		<div>

		</div>
		</div>
	</form>
</body>
</html>