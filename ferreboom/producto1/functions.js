$(function(){

    $('#upload').change(function(ev) {
    	var f = this.files[0]
        if (f.size > 102400 || f.fileSize > 102400)
        {
           alert("Limite Excedido (Max. 100 KB)")
           this.value = null;
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
                
            },
            success: function(data){   
                
            }
        });
	}
	total();
	$('#resultado').on('click','.tr',function(){
		$("#resultado tr").removeClass('selected');
		$(this).addClass('selected');
	});
	var caso;
	
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


	$('#catalogo').click(function(){
		window.open("../catalogo", '_blank');
	});

});