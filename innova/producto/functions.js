$(function(){
	$( "th" ).resizable({ grid: [1, 10000] });
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
	            swal("","Debes escoger un archivo con extension .jpg 300x300","error");
	            this.value = '';
	    }
	});

	$("input").keyup(function(){
    	var start = this.selectionStart,
	        end = this.selectionEnd;
	    $(this).val( $(this).val().toUpperCase() );
	    this.setSelectionRange(start, end);
    });    

	$('#resultado').on('click','.text',function () {
        document.execCommand('selectAll', false, null);
    });

	$('#resultado').on('focusout','td[contenteditable=true]',function(){
		$("#busqueda").focus();
		$.ajax({
            type: "POST",
            url: "precios.php",
            data: "val="+$(this).text()+"&pos="+$(this).index()+"&id="+$(this).parent().find('td:eq(1)').text(),
            success: function(data){   
                $('.error').fadeIn(400).delay(2000).fadeOut(400);
            }
        });
	});

    function total(){
    	$.ajax({
            type: "POST",
            url: "datos.php",
            data: {
            	b:$('#busqueda').val(),
            	activo:$('#selactivo').val(),
            	numero:$('#numero').val(),
            	pagina:$('#pagina').val(),
            	prov:$('#prov').val(),
            	cont:$('#contable').val()
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
		height: 370,
		width: "30%",
		autoOpen: false,
		hide: { effect: "slideUp", duration: 100 },
		show: { effect: "slideDown", duration: 100 },
		modal: true,	
		buttons: [ { text: "Ok", click: function() { 
			if($('#formagregar select[name="familia"]').val()!=null){
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
	                   if(data==''){
		                   total();
		                }else{
		                	swal("","El codigo "+$('#codigo').val()+" le pertenece al producto "+data,"error");
		                	//total();
		                } 
	                }
	            });
	            $( this ).dialog( "close" ); 
	        }else{
	        	swal("","Escoger Categoria","error");
	        }
		} } ]
	});

	$("#formagregar input[name='marca']").autocomplete({
	    source:"marca.php",
	    minLength:1
	});
	$("#formagregar input[name='producto']").autocomplete({
	    source:"producto.php",
	    minLength:1
	});
	function split( val ) {
      return val.split( /,\s*/ );
    }
    function extractLast( term ) {
      return split( term ).pop();
    }
	$("#formagregar input[name='proveedor']").on( "keydown", function( event ) {
        if ( event.keyCode === $.ui.keyCode.TAB &&
            $( this ).autocomplete( "instance" ).menu.active ) {
          event.preventDefault();
        }
      }).autocomplete({
	    source: function( request, response ) {
          $.getJSON( "proveedor.php", {
            term: extractLast( request.term )
          }, response );
        },
        focus: function() {
          return false;
        },
        select: function( event, ui ) {
          var terms = split( this.value );
          terms.pop();
          terms.push( ui.item.value );
          terms.push( "" );
          this.value = terms.join( ", " );
          return false;
        }
	});
	
	$("#agregar").click(function(){
		$("#agregardatos").dialog({
			title: 'Agregar Producto',
			open:function(){
				$('#formagregar input[type="file"]').val('');
				$('#formagregar input[type="text"]').val('');
				$('#formagregar select[name="familia"]').val("");
				$('#formagregar select[name="activo1"]').val("SI");
				caso="add";
			}
		});
		$('#agregardatos').dialog("open");
	});
	
	$("#editar").on('click',function(){
		$(".selected").each(function(){
			var dato=$(".selected").children( "td:eq(1)" ).text();
			var dato1=$(".selected").children( "td:eq(4)" ).text();
			var dato2=$(".selected").children( "td:eq(5)" ).text();
			var dato3=$(".selected").children( "td:eq(6)" ).text();
			var dato4=$(".selected").children( "td:eq(19)" ).text();
			var dato5=$(".selected").children( "td:eq(7)" ).text();
			var dato6=$(".selected").children( "td:eq(3)" ).text();
			$("#agregardatos").dialog({
				title: 'Editar Producto',
				open:function(){
					$('#formagregar input[name="id"]').val(dato);
					$('#formagregar input[name="codigo"]').val(dato6);
					$('#formagregar input[name="producto"]').val(dato1);
					$('#formagregar input[name="marca"]').val(dato2);
					$('#formagregar select[name="familia"]').val(dato3);
					$('#formagregar select[name="activo1"]').val(dato4);
					$('#formagregar input[name="proveedor"]').val(dato5);
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
    $("#prov").keyup(function(e){    
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
	$('#contable').change(function(){
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

	$('#add').click(function(){
		swal({
          title: "Esta Seguro de Guardar esta marca",
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
	            type: "POST",
	            url: "addmarca.php",
	            data: "b="+$('#marca').val(),
	            success: function(data){
	            }
	    	});
          } 
        });
    });  

	$('#catalogo').click(function(){
		window.open("../catalogo", '_blank');
	});
});