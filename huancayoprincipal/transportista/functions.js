$(function(){
	$('#ruc').keydown(function(e) {
	    if ((e.keyCode < 48 || e.keyCode > 57) && (e.keyCode < 96 || e.keyCode > 105) && e.keyCode != 8 && e.keyCode != 9)
	      e.preventDefault();
	});
	$('#telefono').keydown(function(e) {
	    if ((e.keyCode < 48 || e.keyCode > 57) && (e.keyCode < 96 || e.keyCode > 105) && e.keyCode != 8 && e.keyCode != 9)
	      e.preventDefault();
	});
	$('#celular').keydown(function(e) {
	    if ((e.keyCode < 48 || e.keyCode > 57) && (e.keyCode < 96 || e.keyCode > 105) && e.keyCode != 8 && e.keyCode != 9)
	      e.preventDefault();
	});
	$.ajax({
        type: "POST",
        url: "mn.php",
        data: {
        	b:$('#busqueda').val(),
        	activo:$('#selactivo').val(),
        	numero:$('#numero').val(),
        	pagina:$('#pagina').val()
        },
        cache: false,
        success: function(data){                                                    
              $("#resultado").empty();
              $("#resultado").append(data);
              $('#cantidad').text($('#resultado').find('td:eq(9)').text());
              $('#cant').text(Math.ceil($('#resultado').find('td:eq(9)').text()/$('#pagina').val()));
              if (Math.ceil($('#resultado').find('td:eq(9)').text()/$('#pagina').val())==1) {
					$('#siguiente').hide();
					$('#ultimo').hide();
		        }else{
		        	$('#siguiente').show();
					$('#ultimo').show();
		        }
        }
    });
	$( "th" ).resizable({ grid: [1, 10000] });
	$("#resultado").mouseover(function(){
	    $('#resultado tr').each(function () {
	      $(this).hover(
	        function () {
	          $('#resultado> tr').removeClass('hov');
	          $(this).addClass('hov');
	        }, 
	        function () {
	          $(this).removeClass('hov');
	        }
	      );
	      $(this).click(function(){
	        $("#resultado tr").removeClass('selected');
	        $(this).addClass('selected');
	      });
	    });
    });

    $("#agregar").click(function(){
		$("#agregardatos").dialog({
			title: 'Agregar Transportista',
			height: 480,
			width: "35%",
			hide: { effect: "slideUp", duration: 100 },
			show: { effect: "slideDown", duration: 100 },
			modal: true,	
			buttons: [ { text: "Ok", click: function() { 
			    var str = new FormData($('#formagregar')[0]);
			    var a=$('#busqueda').val();
			    var b=$('#selactivo').val();
			    var c=$('#numero').val();
			    var d=$('#pagina').val();
			    str.append("b",a);
			    str.append("accion","add");
			    str.append("activo",b);
			    str.append("numero",c);
			    str.append("pagina",d);
				$.ajax({
	                    type: "POST",
	                    url: "mn.php",
	                    data: str,
	                    cache: false,
	                    contentType: false,
				        processData: false,
	                    success: function(data){                                                    
	                          $("#resultado").empty();
	                          $("#resultado").append(data);
	                          $('#cantidad').text($('#resultado').find('td:eq(9)').text());
                          	  $('#cant').text(Math.ceil($('#resultado').find('td:eq(9)').text()/$('#pagina').val()));
	                    }
	              });
	            $( this ).dialog( "close" ); 
		} } ],
			open:function(){
					$('#formagregar input[type="text"]').val('');
					$('#formagregar select[id="activo1"]').val("SI");},
			close:function(){
					$('#formagregar input[type="text"]').val('');
					$('#formagregar select > option').removeAttr('selected');}
		});
	});

	$("#editar").on('click',function(){
		$(".selected").each(function(){
			var dato=$(".selected").children( "td:eq(0)" ).text();
			var dato1=$(".selected").children( "td:eq(1)" ).text();
			var dato2=$(".selected").children( "td:eq(2)" ).text();
			var dato3=$(".selected").children( "td:eq(3)" ).text();
			var dato4=$(".selected").children( "td:eq(4)" ).text();
			var dato5=$(".selected").children( "td:eq(5)" ).text();
			var dato6=$(".selected").children( "td:eq(6)" ).text();
			var dato7=$(".selected").children( "td:eq(7)" ).text();
			var dato8=$(".selected").children( "td:eq(8)" ).text();
			$("#agregardatos").dialog({
				title: 'Editar Transportista',
				height: 480,
				width: "35%",
				hide: { effect: "slideUp", duration: 100 },
				show: { effect: "slideDown", duration: 100 },
				modal: true,	
				buttons: [ { text: "Ok", click: function() { 
				    var str = new FormData($('#formagregar')[0]);
				    var a=$('#busqueda').val();
				    var b=$('#selactivo').val();
				    var c=$('#numero').val();
				    var d=$('#pagina').val();
				    str.append("b",a);
				    str.append("accion","edit");
				    str.append("activo",b);
				    str.append("numero",c);
				    str.append("pagina",d);
					$.ajax({
	                    type: "POST",
	                    url: "mn.php",
	                    data: str,
	                    cache: false,
	                    contentType: false,
				        processData: false,
	                    success: function(data){                                                    
	                          $("#resultado").empty();
	                          $("#resultado").append(data);
	                          $('#cantidad').text($('#resultado').find('td:eq(9)').text());
                          	  $('#cant').text(Math.ceil($('#resultado').find('td:eq(9)').text()/$('#pagina').val()));
	                    }
	              	});
		            $( this ).dialog( "close" ); 
					} } ],
				open:function(){
						$('#formagregar input[id="id"]').val(dato);
						$('#formagregar input[id="ruc"]').val(dato1);
						$('#formagregar input[id="transportista"]').val(dato2);
						$('#formagregar input[id="direccion"]').val(dato3);
						$('#formagregar input[id="representante"]').val(dato4);
						$('#formagregar input[id="telefono"]').val(dato5);
						$('#formagregar input[id="celular"]').val(dato6);
						$('#formagregar input[id="mail"]').val(dato7);
						$('#formagregar select[id="activo1"]').val(dato8);
					},
				close:function(){
						$('#formagregar input[type="text"]').val('');
						$('#formagregar select > option').removeAttr('selected');}
			});
		});
	});

    $("#eliminar").click(function(){
        $(".selected").each(function(){
	      	var result=$(".selected").children( "td:eq(0)" ).text();
	        $('#eliminardatos').dialog({
	            autoOpen:true,
	            modal:true,
	            width:350,
	            height:'auto',
	            resizable: false,
	            buttons: {
	            Si: function() {
	                $.ajax({
	                    cache: false,
	                    type: "POST",
	                    dataType: "",
	                    url:"mn.php",
	                    data:{
	                    	b:$('#busqueda').val(),
	                    	accion:"del",
	                    	activo:$('#selactivo').val(),
	                    	numero:$('#numero').val(),
	                    	id:$(".selected").children( "td:eq(0)" ).text(),
	                    	pagina:$('#pagina').val()
	                    },
	                    success: function(data){
	                      $("#resultado").empty();
	                      $("#resultado").append(data);
	                      $('#cantidad').text($('#resultado').find('td:eq(9)').text());
	                      $('#cant').text(Math.ceil($('#resultado').find('td:eq(9)').text()/$('#pagina').val()));
	                    }
	                }); 
	           		$( this ).dialog( "close" );
	            },
	            No: function() {
	                $(this).dialog( "close" );
	            }
          }
        });
      });
    });
    $("input").keyup(function(){
    	var start = this.selectionStart,
	        end = this.selectionEnd;
	    $(this).val( $(this).val().toUpperCase() );
	    this.setSelectionRange(start, end);
    });   
    $("input[id='mail']").keyup(function(){
    	var start = this.selectionStart,
	        end = this.selectionEnd;
	    $(this).val( $(this).val().toLowerCase() );
	    this.setSelectionRange(start, end);
    });                                                                    
    $("#busqueda").focus();                                                                                                    
    $("#busqueda").keyup(function(e){        
    	$("#numero").val(1);                                                                                           
        $.ajax({
            type: "POST",
            url: "mn.php",
            data: {
            	b:$('#busqueda').val(),
            	activo:$('#selactivo').val(),
            	numero:$('#numero').val(),
            	pagina:$('#pagina').val()
            },
            success: function(data){   
                $("#resultado").empty();
                $("#resultado").append(data);
                $('#cantidad').text($('#resultado').find('td:eq(9)').text());
                $('#cant').text(Math.ceil($('#resultado').find('td:eq(9)').text()/$('#pagina').val()));
                $('#primero').hide();
				$('#anterior').hide();
				if (Math.ceil($('#resultado').find('td:eq(9)').text()/$('#pagina').val())==1) {
					$('#siguiente').hide();
					$('#ultimo').hide();
		        }else if(Math.ceil($('#resultado').find('td:eq(9)').text()/$('#pagina').val())<1){
		        	$("#resultado").append("<tr><td colspan='13' style='color:red;text-align:center;font-weight:bold'>NO HAY RESULTADOS QUE MOSTRAR</td></tr>");
		        	$('#siguiente').hide();
					$('#ultimo').hide();
		        }
		        else{
		        	$('#siguiente').show();
					$('#ultimo').show();
		        }
            }
        });
    });
    $('#selactivo').change(function(){
    	$("#numero").val(1);  
	    $.ajax({
            type: "POST",
            url: "mn.php",
            data: {
            	b:$('#busqueda').val(),
            	activo:$('#selactivo').val(),
            	numero:$('#numero').val(),
            	pagina:$('#pagina').val()
            },
            success: function(data){                                                    
                $("#resultado").empty();
                $("#resultado").append(data);
                $('#primero').hide();
				$('#anterior').hide();
				$('#cantidad').text($('#resultado').find('td:eq(9)').text());
				$('#cant').text(Math.ceil($('#resultado').find('td:eq(9)').text()/$('#pagina').val()));
				if (Math.ceil($('#resultado').find('td:eq(9)').text()/$('#pagina').val())==1) {
					$('#siguiente').hide();
					$('#ultimo').hide();
		        }else if(Math.ceil($('#resultado').find('td:eq(9)').text()/$('#pagina').val())<1){
		        	$("#resultado").append("<tr><td colspan='13' style='color:red;text-align:center;font-weight:bold'>NO HAY RESULTADOS QUE MOSTRAR</td></tr>");
		        	$('#siguiente').hide();
					$('#ultimo').hide();
		        }else{
		        	$('#siguiente').show();
					$('#ultimo').show();
		        }
            }
        });
	});
	$('#siguiente').click(function(){
		$('#numero').val(parseInt($('#numero').val())+1);
		if($('#numero').val()>=Math.ceil($('#resultado').find('td:eq(9)').text()/$('#pagina').val())){
			$('#siguiente').hide();
			$('#ultimo').hide();
		}
		$.ajax({
            type: "POST",
            url: "mn.php",
            data: {
            	b:$('#busqueda').val(),
            	activo:$('#selactivo').val(),
            	numero:$('#numero').val(),
            	pagina:$('#pagina').val()
            },
            success: function(data){                                                    
                  $("#resultado").empty();
                  $("#resultado").append(data);
                  $('#primero').show();
				  $('#anterior').show();
            }
        });
	});
	$('#ultimo').click(function(){
		$('#numero').val(Math.ceil($('#resultado').find('td:eq(9)').text()/$('#pagina').val()));
		$.ajax({
            type: "POST",
            url: "mn.php",
            data: {
            	b:$('#busqueda').val(),
            	activo:$('#selactivo').val(),
            	numero:$('#numero').val(),
            	pagina:$('#pagina').val()
            },
            success: function(data){                                                    
                  $("#resultado").empty();
                  $("#resultado").append(data);
                  $('#primero').show();
				  $('#anterior').show();
				  $('#siguiente').hide();
				  $('#ultimo').hide();
            }
        });
	});
	$('#anterior').click(function(){
        $('#numero').val(parseInt($('#numero').val())-1);
        if($('#numero').val()==1){
			$('#primero').hide();
			$('#anterior').hide();
		}
		$.ajax({
            type: "POST",
            url: "mn.php",
            data: {
            	b:$('#busqueda').val(),
            	activo:$('#selactivo').val(),
            	numero:$('#numero').val(),
            	pagina:$('#pagina').val()
            },
            success: function(data){                                                    
                  $("#resultado").empty();
                  $("#resultado").append(data);
                  $('#siguiente').show();
				  $('#ultimo').show();
            }
        });
	});
	$('#primero').click(function(){
		$('#numero').val(1);
		$.ajax({
            type: "POST",
            url: "mn.php",
            data: {
            	b:$('#busqueda').val(),
            	activo:$('#selactivo').val(),
            	numero:$('#numero').val(),
            	pagina:$('#pagina').val()
            },
            success: function(data){                                                    
                  $("#resultado").empty();
                  $("#resultado").append(data);
                  $('#primero').hide();
				  $('#anterior').hide();
				  $('#siguiente').show();
				  $('#ultimo').show();
            }
        });
	});
	$('#numero').on('keyup',function(e){
		if(e.which == 13){
			if($('#numero').val()>=Math.ceil($('#resultado').find('td:eq(9)').text()/$('#pagina').val())){
				$('#numero').val(Math.ceil($('#resultado').find('td:eq(9)').text()/$('#pagina').val()));
				$('#siguiente').hide();
				$('#ultimo').hide();
				$('#primero').show();
				$('#anterior').show();
			}else if($('#numero').val()<=1){
				$('#numero').val(1);
				$('#siguiente').show();
				$('#ultimo').show();
				$('#primero').hide();
				$('#anterior').hide();
			}else{
				$('#siguiente').show();
				$('#ultimo').show();
				$('#primero').show();
				$('#anterior').show();
			}
			$.ajax({
	            type: "POST",
	            url: "mn.php",
	            data: {
	            	b:$('#busqueda').val(),
	            	activo:$('#selactivo').val(),
	            	numero:$('#numero').val(),
	            	pagina:$('#pagina').val()
	            },
	            success: function(data){                                                    
	                $("#resultado").empty();
	                $("#resultado").append(data);
	            }
	        });
		}
	});

	$('#pagina').change(function(){
		$('#numero').val(1);
		$.ajax({
            type: "POST",
            url: "mn.php",
            data: {
            	b:$('#busqueda').val(),
            	activo:$('#selactivo').val(),
            	numero:$('#numero').val(),
            	pagina:$('#pagina').val()
            },
            success: function(data){                                                    
                  $("#resultado").empty();
                  $("#resultado").append(data);
                  $('#primero').hide();
				  $('#anterior').hide();
				  if (Math.ceil($('#resultado').find('td:eq(9)').text()/$('#pagina').val())==1) {
					$('#siguiente').hide();
					$('#ultimo').hide();
		          }else{
		        	$('#siguiente').show();
					$('#ultimo').show();
		          }
            }
        });
		$('#cant').text(Math.ceil($('#resultado').find('td:eq(9)').text()/$('#pagina').val()));
	});
});

