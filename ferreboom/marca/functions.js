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
	$('input[type="file"]').change(function () {
	    var ext = this.value.match(/\.(.+)$/)[1];
	    switch (ext) {
	        case 'jpg':
	        break;   
	        default:
	            swal("","Debes escoger un archivo con extension .jpg 250x50","error");
	            this.value = '';
	    }
	});
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
	var caso;
	$("#agregardatos").dialog({
		height: 280,
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
                url: "add.php",
                data: str,
                cache: false,
                contentType: false,
		        processData: false,
                success: function(data){                                                    
                   total();
                }
            });
            $( this ).dialog( "close" ); 
		} } ]
	});
	
	$("#agregar").click(function(){
		$("#agregardatos").dialog({
			title: 'Agregar Marca',
			open:function(){
				$('#formagregar input[type="text"]').val('');
				$('#formagregar select[id="activo1"]').val("SI");
				$('#formagregar input[type="file"]').val('');
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
			$("#agregardatos").dialog({
				title: 'Editar Marca',
				open:function(){
					$('#formagregar input[id="id"]').val(dato);
					$('#formagregar input[id="marca"]').val(dato1);
					$('#formagregar select[id="activo1"]').val(dato2);
					$('#formagregar input[type="file"]').val('');
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

    $("input").keyup(function(){
    	var start = this.selectionStart,
	        end = this.selectionEnd;
	    $(this).val( $(this).val().toUpperCase() );
	    this.setSelectionRange(start, end);
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

