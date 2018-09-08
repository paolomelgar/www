var longit;
var latit;
var zoom;

function initialize(){
	var mapProp = {
	  center:new google.maps.LatLng(latit,longit),
	  zoom:zoom,
	  mapTypeId:google.maps.MapTypeId.ROADMAP
	  };
	var map=new google.maps.Map(document.getElementById("dialog")
	  ,mapProp);
	marker=new google.maps.Marker({
	  position:new google.maps.LatLng(latit,longit),
	  draggable:true
	  });
	google.maps.event.addListener(marker, 'dragend', function (event) {
	    latit = this.getPosition().lat();
	    longit = this.getPosition().lng();
	}); 
	google.maps.event.addListenerOnce(map, 'idle', function() {
	    google.maps.event.trigger(map, 'resize');
	    map.setCenter(new google.maps.LatLng(latit,longit));
	});
	google.maps.event.addDomListener(window, 'load', initialize);
	marker.setMap(map);
}

$(function(){
	$( "th" ).resizable({ grid: [1, 10000] });
	function total(){
    	$.ajax({
            type: "POST",
            url: "datos.php",
            data: {
            	b:$('#busqueda').val(),
            	activo:$('#selactivo').val(),
            	numero:$('#numero').val(),
            	pagina:$('#pagina').val()
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
                var cant=$('#resultado').find('td:eq(0)').text();
                $('#cantidad').text(cant);
		        $('#cant').text(Math.ceil(cant/$('#pagina').val()));
				if ($('#cant').text()==1) {
					$('#primero').find('input').prop('disabled', true);
					$('#anterior').find('input').prop('disabled', true);
					$('#siguiente').find('input').prop('disabled', true);
					$('#ultimo').find('input').prop('disabled', true);
		        }else if($('#cant').text()==0){
		        	$('#primero').find('input').prop('disabled', true);
					$('#anterior').find('input').prop('disabled', true);
					$('#siguiente').find('input').prop('disabled', true);
					$('#ultimo').find('input').prop('disabled', true);
		        	$("#resultado").append("<tr><td colspan='11' style='color:red;text-align:center;font-weight:bold'>NO HAY RESULTADOS QUE MOSTRAR</td></tr>");
		        }else{
		        	if($('#numero').val()==1){
		        		$('#primero').find('input').prop('disabled', true);
						$('#anterior').find('input').prop('disabled', true);
						$('#siguiente').find('input').prop('disabled', false);
						$('#ultimo').find('input').prop('disabled', false);
		        	}else if($('#numero').val()==$('#cant').text()){
		        		$('#primero').find('input').prop('disabled', false);
						$('#anterior').find('input').prop('disabled', false);
						$('#siguiente').find('input').prop('disabled', true);
						$('#ultimo').find('input').prop('disabled', true);
		        	}else{
		        		$('#primero').find('input').prop('disabled', false);
						$('#anterior').find('input').prop('disabled', false);
						$('#siguiente').find('input').prop('disabled', false);
						$('#ultimo').find('input').prop('disabled', false);
		        	}
		        }
            }
        });
	}
	total();
	$('#resultado').on('click','.tr',function(){
		$("#resultado tr").removeClass('selected');
		$(this).addClass('selected');
	});
	$('#resultado').on('click','.mapa',function(){
		latit=$(this).parent().find('td:eq(12)').text();
		longit=$(this).parent().find('td:eq(13)').text();
		zoom=15;
		var aa=$(this).parent().find('td:eq(1)').text();
		initialize();
		$('#dialog').dialog({
			title:$(this).parent().find('td:eq(4)').text(),
			height:600,
			width:900,
			modal:true,
			buttons: { 
	          "ELIMINAR" : function(){ 
	            $.ajax({
                    type: "POST",
                    url: "add.php",
                    data: {
                    	id:aa,
		            	accion:"delmaps"
	                },
                    success: function(data){  
                    	total();
                    }
	              });
	            $( this ).dialog( "close" );
	          },
	          "EDITAR" : function(){ 
	            $.ajax({
                    type: "POST",
                    url: "add.php",
                    data: {
                    	latitud:latit,
		            	longitud:longit,
		            	id:aa,
		            	accion:"maps"
	                },
                    success: function(data){  
                    	total();
                    }
	              });
	            $( this ).dialog( "close" );
	          },
			 },
		});
	});
	$('#resultado').on('click','.addmapa',function(){
		latit=-9.932211;
		longit=-76.241930;
		zoom=13;
		var aa=$(this).parent().find('td:eq(1)').text();
		initialize();
		$('#dialog').dialog({
			title:$(this).parent().find('td:eq(4)').text(),
			height:600,
			width:900,
			modal:true,
			buttons: [ { text: "GUARDAR", click: function() { 
			    $.ajax({
                    type: "POST",
                    url: "add.php",
                    data: {
                    	latitud:latit,
		            	longitud:longit,
		            	id:aa,
		            	accion:"maps"
	                },
                    success: function(data){  
                    	total();
                    }
	              });
	            $( this ).dialog( "close" ); 
			} } ],
		});
	});

	var caso;
	$("#agregardatos").dialog({
		height: 520,
		width: "30%",
		autoOpen: false,
		hide: { effect: "slideUp", duration: 100 },
		show: { effect: "slideDown", duration: 100 },
		modal: true,	
		buttons: [ { text: "Ok", click: function() { 
			str = new FormData($('#formagregar')[0]);
			str.append("accion",caso);
			$.ajax({
                type: "POST",
                url: "vercliente.php",
                data: { a:$('#cliente').val(),
                		b:caso},
                success: function(data){     
                    if(data>0){
                     	swal("","Este cliente ya existe, Cambiar nombre","error");
                    }else{
                     	$.ajax({
			                type: "POST",
			                url: "add.php",
			                data: str,
			                cache: false,
			                contentType: false,
					        processData: false,
			                success: function(data){                                                    
			                   total();
			                }
			            });
			            $("#agregardatos").dialog( "close" ); 
                    }
                }
	        });
		} } ]
	});
	
	$("#agregar").click(function(){
		$("#agregardatos").dialog({
			title: 'Agregar Cliente',
			open:function(){
				$('#formagregar input[type="text"]').val('');
				$('#formagregar select[id="tipo"]').val("FERRETERIA");
				$('#formagregar select[id="activo1"]').val("SI");
				caso="add";
			}
		});
		$('#agregardatos').dialog("open");
	});

	$("#editar").on('click',function(){
		$(".selected").each(function(){
			var dato=$(".selected").children( "td:eq(1)" ).text();
			var dato1=$(".selected").children( "td:eq(3)" ).text();
			var dato2=$(".selected").children( "td:eq(4)" ).text();
			var dato3=$(".selected").children( "td:eq(5)" ).text();
			var dato4=$(".selected").children( "td:eq(6)" ).text();
			var dato5=$(".selected").children( "td:eq(7)" ).text();
			var dato6=$(".selected").children( "td:eq(8)" ).text();
			var dato7=$(".selected").children( "td:eq(9)" ).text();
			var dato8=$(".selected").children( "td:eq(10)" ).text();
			var dato9=$(".selected").children( "td:eq(11)" ).text();
			$("#agregardatos").dialog({
				title: 'Editar Cliente',
				open:function(){
					$('#formagregar input[id="id"]').val(dato);
					$('#formagregar input[id="ruc"]').val(dato1);
					$('#formagregar input[id="cliente"]').val(dato2);
					$('#formagregar input[id="direccion"]').val(dato3);
					$('#formagregar select[id="tipo"]').val(dato4);
					$('#formagregar input[id="credito"]').val(dato5);
					$('#formagregar input[id="representante"]').val(dato6);
					$('#formagregar input[id="telefono"]').val(dato7);
					$('#formagregar input[id="mail"]').val(dato8);
					$('#formagregar select[id="activo1"]').val(dato9);
					caso="edit";
				}
			});
		});
		$('#agregardatos').dialog("open");
	});

    $("#eliminar").click(function(){
        $(".selected").each(function(){
	        $('#eliminardatos').dialog({
	        	title:'Eliminar datos',
	            modal:true,
	            width:350,
	            height:'auto',
	            buttons: {
		            Si: function() {
		                $.ajax({
			                type: "POST",
			                url: "add.php",
			                data:{
		                    	id:$(".selected").children( "td:eq(1)" ).text(),
			                	accion:"del"
		                    },
			                cache: false,
			                success: function(data){ 
			                   total();
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

    var typingTimer;                     
    $("#busqueda").focus();                                                                                                    
    $("#busqueda").keyup(function(e){    
    	clearTimeout(typingTimer);
	    if ($('#busqueda').val) {
	        typingTimer = setTimeout(function(){    
		        $("#numero").val(1);                                                                           
		        total();
		    }, 500);   
	    }
    });

    $('#selactivo').change(function(){
    	$('#numero').val(1);
	    total();
	});
	$('#siguiente').click(function(){
		$('#numero').val(parseInt($('#numero').val())+1);
		total();
	});
	$('#ultimo').click(function(){
		$('#numero').val(Math.ceil($('#resultado').find('td:eq(0)').text()/$('#pagina').val()));
		total();
	});
	$('#anterior').click(function(){
        $('#numero').val(parseInt($('#numero').val())-1);
		total();
	});
	$('#primero').click(function(){
		$('#numero').val(1);
		total();
	});
	$('#numero').on('keyup',function(e){
		if(e.which == 13){
			total();
		}
	});
	$('#pagina').change(function(){
		$('#numero').val(1);
		total();
	});
});