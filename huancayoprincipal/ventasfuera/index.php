<?php 
session_start();
date_default_timezone_set("America/Lima");
if($_SESSION['valida']=='huancayoprincipal'){
?>
<html>
<head>
	<title>FERREBOOM</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 
	<link type="text/css" href="../sweet-alert.css" rel="stylesheet" />
	<link type="text/css" href="../jquery-ui-1.10.4.custom.min.css" rel="stylesheet" />
	<link rel="stylesheet"  href="../lightslider.css"/>
	<script type="text/javascript" src="../jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="../jquery-ui-1.10.4.custom.min.js"></script>  
	<script type="text/javascript" src="../sweet-alert.min.js"></script>  
	<script type="text/javascript" src="../lightslider.js"></script> 
	<script src="../socket.io.js"></script>
	<script type="text/javascript">
	  var socket=io.connect('http://ferreboomhuancayo.sytes.net:3500');
	  $(function(){
	  	$( document ).tooltip({
			position: {
				        my: "left top",
				        at: "right+2 ",
				    },
	      	content: function() {
	        	return $(this).html();
	        }
	    });
	    $('#areachat').tooltip({
			position: {
		        my: "right top",
		        at: "left+5 top",
		    }
		});
		var array;
		var count=0;
	    socket.on('id',function(data){ 
			socket.emit('usuario',{ 
				usuario:$('#name').text(),
				cargo:$('#cargo').text(),
				idd:data
			}); 
			$.ajax({
		      type: "POST",
		      url: "../sistema/novisto.php",
		      data:{usuario:$('#name').text()},
		      dataType: "json",
		      async: false,
		      success: function(data){
		      	array=data;
		      	if(data.length>0){
		      		for(var i=0;i<array.length;i++){
						socket.emit('user-message',{ 
							emisor:$('#name').text(),
							message:"fin",
							receptor:array[i]
						}); 	
					}
		      		if($('.tr').is(":visible")){
					}else{
						$('#users').click();
						count=1;
					}
		      	}
		      }
		    });
		}); 
	  	var j=0;
	  	socket.on('usuario',function(data){ 
	  		$('#users').empty(); 
	  		var x=0;
			for(var i=0;i<data.length;i++){
				var mm=0;
				for(var j=i+1; j<data.length;j++){
					if(data[i][0]==data[j][0]){
						mm++;
					}
				}
				if(data[i][0]=='PAUL MELGAR' && mm==0){
					x=1;
					$('#users').append('<div style="width: 8px;height: 8px;border-radius: 4px;background-color:#58FA58;float:left;margin-top:7px;margin-right:7px"></div><div style="float:left;color:white;">ADMIN(Conectado)</div>');
				}
			}
			if(x==0){
				$('#users').append('<div style="width: 8px;height: 8px;border-radius: 4px;float:left;margin-top:7px;margin-right:7px"></div><div style="float:left;color:white;">ADMIN(Desconectado)</div>');
			}
	    });
	    var write=0;
	    $('#input').keyup(function(e){ 
			if($('#input').val().length == 0){
				if(write>0){
					socket.emit('user-message',{ 
						emisor:$('#name').text(),
						message:"vacio",
						receptor:$('#receptor').text()
					}); 
				}
				write=0;
			}else{
				write++;
				if(write==1){
					socket.emit('user-message',{ 
						emisor:$('#name').text(),
						message:"escribiendo",
						receptor:$('#receptor').text()
					}); 
				}
			}
			if(e.which==13){
				if($('#input').val().length>0){
					$('#visto').hide();
					var d = new Date();
					datetext = d.toTimeString();
					datetext = datetext.split(' ')[0];
					$('#areachat').append("<div style='text-align:right;width:200px;margin-left:37px;margin-top:2px;cursor:pointer;'><div style='float:right;color:#6C6C6C;margin-top:5px;font-size:10px;width:5px' class='fin fin1'></div><div style='float:right;color:#6C6C6C;margin-top:5px;font-size:10px;width:5px' class='medio medio1'></div><div style='border:1px solid #B3CED9;font-size:12px;word-wrap:break-word;display:inline-block;background-color:#D9FDFF;padding: 5px 8px 4px;border-radius:5px;max-width:170px' title='"+datetext+"'>"+$('#input').val()+"</div></div>");
					$('#scroll').scrollTop(10000000000000000);
					socket.emit('user-message',{ 
						emisor:$('#name').text(),
						message:$('#input').val(),
						receptor:$('#receptor').text()
					}); 
					$('#input').val('');
					write=0;
				}
			}
		}); 

		chat(j);

		var soundFx = $('#sound');
		var window_focus=false;
		var interval;

		$('#input').focus(function() {
			document.title = 'FERREBOOM';
		    window_focus = true;
		    clearInterval(interval);
		    if(count>0){
			    socket.emit('user-message',{ 
					emisor:$('#name').text(),
					message:"visto",
					receptor:$('#receptor').text()
				});
		    }
			count=0; 
		}).blur(function() {
		    window_focus = false;
		});


		socket.on($('#name').text(),function(data){ 
			if(data.message=='visto'){
				$('#visto').empty().append("✔ Visto "+data.hora).show();
			}else if(data.message=='escribiendo'){
				$('#visto').empty();
				$('#escr').empty().append(data.emisor+" esta escribiendo...").show();
			}else if(data.message=='vacio'){
				$('#escr').empty(); 
			}else if(data.message=='medio'){
				$('.medio').html('&#10004');
				$('.medio1').removeClass('medio');
			}else if(data.message=='fin'){
				$('.fin').html('&#10004');
				$('.fin1').removeClass('fin');
			}else{
				socket.emit('user-message',{ 
					emisor:$('#name').text(),
					message:"fin",
					receptor:data.emisor
				});
				$('#visto').empty();
				$('#escr').empty(); 
				var d = new Date();
				datetext = d.toTimeString();
				datetext = datetext.split(' ')[0];
				$('#areachat').append("<div style='margin-top:2px;width:200px;cursor:pointer;margin-left:5px'><div style='border:1px solid #B1B1B1;font-size:12px;word-wrap:break-word;display:inline-block;background-color:white;padding: 5px 8px 4px;border-radius: 5px;' title='"+datetext+"'>"+data.message+"</div></div>"); 
				if(window_focus==false){
					soundFx[0].play();
					count++;
					if(count==1){
						var z=0;
						interval=setInterval(function(){
							if(z%2==1){
								document.title = "FERREBOOM";
							}else{
								document.title = data.emisor.split(' ')[0]+" te envio un mensaje...";
							}z++;
						},1000);
					}
					if($('.tr').is(":visible")){
						
					}else{
						$('#users').click();
					}
				}else{
					socket.emit('user-message',{ 
						emisor:$('#name').text(),
						message:"visto",
						receptor:$('#receptor').text()
					});
					count=0;
				}
				$('#scroll').scrollTop(10000000000000000);
			}
		});
		var topp;
		var load=0;
		$('#scroll').scroll(function(){
		    if($('#scroll').scrollTop() <20){
		    	load++;
		    	if(load==1){
		            topp = $('#areachat').height();
			    	j++;
		            chat(j);
		        }
           }
		});
		var fecha=$.datepicker.formatDate('yy-mm-dd', new Date());
		function chat(j){
			$.ajax({
              type: "POST",
              url: "../sistema/chat.php",
              dataType: "json",
              data:{emisor:$('#name').text(),
		      		receptor:$('#receptor').text(),
					i:j},
			  beforeSend:function(){
			  	$('#areachat').append("<div class='load' style='position:absolute;bottom:315px;right:110px;height:30px;'><img src='../loading.gif' height='30px'></div>");
        	  },
              success: function(data){
              	$('.load').hide();
              	for(var i=0;i<data.length;i++){
              		if(fecha!=data[i][3]){
		      			$('#areachat').prepend("<div style='text-align:center;margin-top:2px;'>"+fecha+"</div>");
	          		}
		      		if(data[i][0]==$('#name').text()){
		      			if(data[i][5]=='MEDIO'){
		      			$('#areachat').prepend("<div style='text-align:right;width:200px;margin-left:37px;margin-top:2px;cursor:pointer;'><div style='float:right;color:#6C6C6C;margin-top:5px;font-size:10px;width:5px' class='fin fin1'></div><div style='float:right;color:#6C6C6C;margin-top:5px;font-size:10px;width:5px'>&#10004</div><div style='border:1px solid #B3CED9;font-size:12px;word-wrap:break-word;display:inline-block;background-color:#D9FDFF;padding: 5px 8px 4px;border-radius:5px;max-width:170px' title='"+data[i][4]+"'>"+data[i][2]+"</div></div>");
		      			}else{
		      			$('#areachat').prepend("<div style='text-align:right;width:200px;margin-left:37px;margin-top:2px;cursor:pointer;'><div style='float:right;color:#6C6C6C;margin-top:5px;font-size:10px;width:5px'>&#10004</div><div style='float:right;color:#6C6C6C;margin-top:5px;font-size:10px;width:5px'>&#10004</div><div style='border:1px solid #B3CED9;font-size:12px;word-wrap:break-word;display:inline-block;background-color:#D9FDFF;padding: 5px 8px 4px;border-radius:5px;max-width:170px' title='"+data[i][4]+"'>"+data[i][2]+"</div></div>");
		      			}
		      		}else{
		      			$('#areachat').prepend("<div style='margin-top:2px;width:200px;cursor:pointer;margin-left:5px'><div style='border:1px solid #B1B1B1;font-size:12px;word-wrap:break-word;display:inline-block;background-color:white;padding: 5px 8px 4px;border-radius: 5px;' title='"+data[i][4]+"'>"+data[i][2]+"</div></div>"); 
		      		}
		      		fecha=data[i][3];
				}
				$('#scroll').scrollTop($('#areachat').height()-topp);
              	if(j==0){
              		if(data[0][0]==$('#name').text() && data[0][5]!='MEDIO' && data[0][5]!='FIN'){
              			$('#visto').empty().append("✔ Visto "+data[0][5]).show();
		            }
              	}
              	if(data.length==30){
              		load=0;
              	}
              }
        	});
		}
	  	$("textarea").keyup(function(){
		    var start = this.selectionStart,
		        end = this.selectionEnd;
		    $(this).val( $(this).val().toUpperCase() );
		    this.setSelectionRange(start, end);
		});
		
	  	$('#buscar').focus();
	  	var b='';
	  	var m=0;
	  	var loading=0;
	  	function Buscar(b,m,f,a){
	  		$.ajax({
	          type: "POST",
	          url: "cotizar.php",
	          dataType:"json",
	          data: {b:b,
	          		 m:m,
	          		 f:f},
	          beforeSend:function(){
                $('#table').append("<tr class='load' style='height:270px'><td colspan='4' height='60px' align='center'><img src='../loading.gif' height='200px'></td></tr>");
              },
	          success: function(data){
	          	$('.load').hide();
	          	var d="<tr>";
	          	for (var i = 0; i <= data.length-1; i++) {
	          		if(data[i][3]<=0){
	          			d += "<td width='15%' align='center' style='font-size:14px;border:4px solid #FF5566;border-radius:5px;background-color:white;padding:0px' class='aa'>\n"+
	          					"<table width='100%' style='border-collapse:collapse;'>\n"+
	          					"<tr><td colspan='2' align='center' class='img' style='cursor:pointer'><img src='https://dl.dropboxusercontent.com/u/104755692/huancayo/producto/a"+data[i][4]+".jpg' height='200' width='200'><img src='agotado.png' width='200px' style='position:absolute;margin-left:-200px;margin-top:26px;color:red;font-weight:bold;font-size:30px;'/></td></tr>\n";
	          					if(data[i][7]>0){
		          				d += "<tr><td width='100px'><img src='https://dl.dropboxusercontent.com/u/104755692/huancayo/marca/a"+data[i][7]+".jpg' width='100px'></td><td width='100px' style='font-weight:bold;font-size:25px;color:#f63;' class='precio' align='center'>S/ "+data[i][1]+"</td></tr>\n";
		          			}else{
		          				d += "<tr><td width='100px' align='center' style='font-weight:bold'>"+data[i][7]+"</td><td width='100px' style='font-weight:bold;font-size:25px;color:#f63;' class='precio' align='center'>S/ "+data[i][1]+"</td></tr>\n";
		          			}
		          				d += "<tr><td colspan='2' style='font-weight:bold;font-size:13px;height:30px;color:#4061a7;text-align:center'>"+data[i][0]+"</td></tr>\n"+
		          					 "<tr style='display:none'><td><input type='text' class='ii' id='"+data[i][4]+"'></td></tr>\n"+
		          					 "<tr><td colspan='2' align='center' style='color:red;font-weight:bold;font-size:22px;padding:0px'>AGOTADO</td></tr></table>\n"+
		          				 "</td>";
	          		}else{
	          			if(data[i][6]=='OFERTA'){
	          				d += "<td width='15%' align='center' style='font-size:14px;border:4px solid #8E8E8E;border-radius:5px;background-color:white;padding:0px' class='aa'>\n"+
		          					"<table width='100%' style='border-collapse:collapse;'>\n"+
		          					"<tr><td colspan='2' align='center' class='imgoferta' style='cursor:pointer'><img src='https://dl.dropboxusercontent.com/u/104755692/huancayo/producto/a"+data[i][4]+".jpg' height='200' width='200'><img src='oferta.png' width='200px' style='position:absolute;margin-left:-200px;margin-top:0px;color:red;font-weight:bold;font-size:30px;'/></td></tr>\n";
		          			if(data[i][7]>0){
		          				d += "<tr><td width='100px'><img src='https://dl.dropboxusercontent.com/u/104755692/huancayo/marca/a"+data[i][7]+".jpg' width='100px'></td><td width='100px' style='font-weight:bold;font-size:25px;color:#f63;' class='precio' align='center'>S/ "+data[i][1]+"</td></tr>\n";
		          			}else{
		          				d += "<tr><td width='100px' align='center' style='font-weight:bold'>"+data[i][7]+"</td><td width='100px' style='font-weight:bold;font-size:25px;color:#f63;' class='precio' align='center'>S/ "+data[i][1]+"</td></tr>\n";
		          			}
		          				d += "<tr><td colspan='2' class='prod' style='font-weight:bold;font-size:13px;height:30px;color:#4061a7;text-align:center'>"+data[i][0]+"</td></tr>\n"+
		          					 "<tr style='display:none'><td><input type='hidden' class='marca' value='"+data[i][8]+"'><input type='text' class='ii' id='"+data[i][4]+"'><input type='hidden' class='especial' value='"+data[i][2]+"'><input type='hidden' class='caja' value='"+data[i][5]+"'></td></tr>\n"+
		          				 	 "<tr><td width='100px' align='center'>Cant:<input type='text' class='cant' size='3' style='border:2px solid red;border-radius:3px;text-align:center;font-weight:bold'></td><td width='100px'><div class='buscar'>AGREGAR</div></td></tr></table>\n"+
		          				 "</td>";
	          			}else{
	          				d += "<td width='15%' align='center' style='font-size:14px;border:4px solid #8E8E8E;border-radius:5px;background-color:white;padding:0px' class='aa'>\n"+
		          					"<table width='100%' height='300px' style='border-collapse:collapse;'>\n"+
		          					"<tr><td colspan='2' align='center' class='img' style='cursor:pointer'><img src='https://dl.dropboxusercontent.com/u/104755692/huancayo/producto/a"+data[i][4]+".jpg' height='200' width='200'></td></tr>\n";
		          			if(data[i][7]>0){
		          				d += "<tr><td width='100px'><img src='https://dl.dropboxusercontent.com/u/104755692/huancayo/marca/a"+data[i][7]+".jpg' width='100px'></td><td width='100px' style='font-weight:bold;font-size:25px;color:#f63;' class='precio' align='center'>S/ "+data[i][1]+"</td></tr>\n";
		          			}else{
		          				d += "<tr><td width='100px' align='center' style='font-weight:bold'>"+data[i][7]+"</td><td width='100px' style='font-weight:bold;font-size:25px;color:#f63;' class='precio' align='center'>S/ "+data[i][1]+"</td></tr>\n";
		          			}
		          				d += "<tr><td colspan='2' class='prod' style='font-weight:bold;font-size:13px;height:30px;color:#4061a7;text-align:center'>"+data[i][0]+"</td></tr>\n"+
		          					 "<tr style='display:none'><td><input type='hidden' class='marca' value='"+data[i][8]+"'><input type='text' class='ii' id='"+data[i][4]+"'></td></tr>\n"+
		          					 "<tr><td width='100px' align='center'>Cant:<input type='text' class='cant' size='3' style='border:2px solid red;border-radius:3px;text-align:center;font-weight:bold'></td><td width='100px'><div class='buscar'>AGREGAR</div></td></tr></table>\n"+
		          				 "</td>";
	          			}
	          		}
	          		if((i+1)%4==0 && i<23){
	          			d+="</tr><tr>";
					}else if(i==19){
						d+="</tr>";
					}
	          	}
	          	$('#table').append(d);
	          	if(data.length==24){
		          	loading=0;
		        }else if(data.length==0 && m==0){
            	    $('#table').append("<tr style='height:270px'><td colspan='4' align='center' style='color:red;font-weight:bold;font-size:40px'>NO SE ENCONTRARON RESULTADOS</td></tr>");
		        }
		        if(m==0 && a==0){
	          		$(window).scrollTop(400);
	          	}else if(a>0){
		          	$(window).scrollTop(0);
	          	}
	          }
	  		});
	  	}
	  	$('.menu li.todas').addClass('select1');
	  	Buscar('',0,$('.select1').text(),1);
  		var typingTimer;
	  	$('#buscar').keyup(function(){
	  		clearTimeout(typingTimer);
		    if ($('#buscar').val) {
		        typingTimer = setTimeout(function(){
		        	$('.menu li').removeClass('select1');
		        	$('.menu li.todas').addClass('select1');
		        	m=0;
		            $('#table').empty();
			  		Buscar($('#buscar').val(),0,$('.select1').text(),0);
		            //$(window).scrollTop(400);
		        }, 500);
		    }
	  	});
	  	$('.menu li').click(function(){
	  		$('.menu li').removeClass('select1');
	  		$(this).addClass('select1');
	  		$('nav').toggleClass('active');
	  		if(modal.style.display == "block"){
			  	modal.style.display = "none";
			}else{
			  	modal.style.display = "block";
			}
	  		m=0;
	  		$('#table').empty();
            //$(window).scrollTop(0);
            $('#buscar').val('');
            Buscar($('#buscar').val(),0,$('.select1').text(),0);
	  	});
		$(window).scroll(function() {
		    if($(window).scrollTop() > $(document).height() - screen.height-400 && $(window).scrollTop()>200){	
		    	loading++;
		    	//alert(loading+" "+m);
		    	if(loading==1){
		            m++;
		            Buscar($('#buscar').val(),m,$('.select1').text());
		        }
           } 
		});
	    $('#table').on('click','.buscar',function(){
	    	if($(this).parent().parent().parent().find(".cant").val()!=''){
		    	var id=$(this).parent().parent().parent().find(".ii").attr('id');
		    	var cant=$(this).parent().parent().parent().find(".cant").val();
		    	var prod=$(this).parent().parent().parent().find(".prod").text();
		    	var marca=$(this).parent().parent().parent().find(".marca").val();
		    	var precio;
		    	if(parseInt(cant)>=parseInt($(this).parent().parent().parent().find(".caja").val())){
		    		precio=$(this).parent().parent().parent().find(".especial").val();
		    	}else{
			    	precio=$(this).parent().parent().parent().find(".precio").text().slice(3);
		    	}
		    	var total=parseFloat(parseFloat(precio)*parseFloat(cant)).toFixed(2);
		    	var m;
		    	var i=0;
		    	$('#row tr').each(function () {
	                 m=$(this).find('td:eq(1)').text();
	                if(id == m){i++;}
	            });
	            if(i==0){
		    		$('#row').append("<tr class='fila'><td width='2.5%' title='s' height='20px' style='padding:0px;cursor:pointer'><img src='https://dl.dropboxusercontent.com/u/104755692/huancayo/producto/a"+id+".jpg' width='100%'></td><td style='display:none'>"+id+"</td><td align='right' width='7.5%' contenteditable='true' class='edit'>"+cant+"</td><td width='60%'>"+prod+" "+marca+"</td><td align='right' width='10%'>"+precio+"</td><td align='right' width='15%'>"+total+"</td><td width='5%' align='center'><span class='ui-icon ui-icon-circle-close del' style='cursor:pointer'></td></tr>")
	            	$('#agregado').fadeIn().delay(1000).fadeOut();
	            	$('#mes').text($('#row tr').length);
	            	$('#mes').show();
	            }
	            else{
	            	$('#existe').fadeIn().delay(1000).fadeOut();
	            }
		    	sum=0;
	    		$('#row tr').each(function(){
	    			var value = $(this).find('td:eq(5)').text();
				    if(!isNaN(value) && value.length != 0) {
				        sum += parseFloat(value);
				    }
	    		});
	            $('#total').empty();
	            $('#total').append("S/ "+sum.toFixed(2));
	            $('#cotizacion').text("S/ "+sum.toFixed(2));
	        }else{
	        	swal("","Tiene que escribir una cantidad para Agregar","error");
	        }
	    });
	    $('#cotizacion1').click(function(){
	    	$('#dialog').dialog({
	    		create: function(event, ui) {
			        $(event.target).parent().css('position', 'fixed');
			    },
			    resizeStop: function(event, ui) {
			        var position = [(Math.floor(ui.position.left) - $(window).scrollLeft()),
			                         (Math.floor(ui.position.top) - $(window).scrollTop())];
			        $(event.target).parent().css('position', 'fixed');
			        $(dlg).dialog('option','position',position);
			    },
	    		title:'COTIZACION',
          		autoOpen:true,
          		height:650,
          		width: "70%",
          		modal:true,
          		position:[200,10],
          		buttons: { 
		            "Enviar cotizacion" : function(){
				      var id=new Array();
		              var producto=new Array();
				      var cantidad=new Array();
				      var precio=new Array();
				      var importe=new Array();
				      var cliente=	"<?php echo $_SESSION['nombre']; ?>" ;
				      var total= $('#total').text();
				      var comentario= $('#comentario').val();
				      var i=0;
				      $('#row tr').each(function(){
				        id[i]=$(this).find('td:eq(1)').text();
				        cantidad[i]=$(this).find('td:eq(2)').text();
				        producto[i]=$(this).find('td:eq(3)').text();
				        precio[i]=$(this).find('td:eq(4)').text();
				        importe[i]=$(this).find('td:eq(5)').text();
				        i++;
				      });
				      $.ajax({
		                type: "POST",
		                url: "procesarpedido.php",
		                data: {cliente:cliente,
		                      id:id,
		                      producto:producto,
		                      cantidad:cantidad,
		                      unitario:precio,
		                      importe:importe,
		                  	  total:total,
		                  	  comentario:comentario},
		                cache: false,
		                beforeSend:function(){
		                  swal({
		                    title: "Procesando Pedido..",
		                    text: "",
		                    imageUrl: "../loading.gif",
		                    showConfirmButton: false
		                  });
		                },
		                success: function(data){
		                	socket.emit('notificacion',"");
		                    swal({
					          title: "Pedido Enviado Correctamente",
					          text: "Su Pedido será procesado en breves momentos",
					          type: "success"
					        },
					        function(isConfirm){
					          if (isConfirm) {
					            location.reload();
					          } 
					        });
		                }
		              });
		              $( this ).dialog( "close" ); 
		            }
		        }
	    	});
	    });
	    $('#row').on('click','.edit',function(){
	    	document.execCommand('selectAll', false, null);
	    });
	    $('#row').on('click','.fila',function(){
	    	$('.fila').removeClass('select');
	    	$(this).addClass('select');
	    });
    	var sum;
    	$('#row').on('keyup','.edit',function(){
            $(this).parent().find('td:eq(5)').text(parseFloat(parseFloat($(this).parent().find('td:eq(4)').text())*parseFloat($(this).text())).toFixed(2));
    	    sum=0;
    		$('#row tr').each(function(){
    			var value = $(this).find('td:eq(5)').text();
			    if(!isNaN(value) && value.length != 0) {
			        sum += parseFloat(value);
			    }
    		});
            $('#total').empty();
            $('#total').append("S/ "+sum.toFixed(2));
            $('#cotizacion').text("S/ "+sum.toFixed(2));
        });
		$('#row').on('click','.del',function(){
			swal({
              title: "Esta Seguro de Eliminar!",
              text: "",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Aceptar",
              cancelButtonText: "Cancelar"
            },
            function(isConfirm){
              if (isConfirm) {
                $('.select').remove();
	                sum=0;
		    		$('#row tr').each(function(){
		    			var value = $(this).find('td:eq(5)').text();
					    if(!isNaN(value) && value.length != 0) {
					        sum += parseFloat(value);
					    }
		    		});
		            $('#total').empty();
		            $('#total').append("S/ "+sum.toFixed(2));
		            $('#cotizacion').text("S/ "+sum.toFixed(2));
		            $('#mes').text($('#row tr').length);
		            if($('#row tr').length==0){
        				$('#mes').hide();
		            }
                } 
            });
		});
		$('#table').on('click','.img',function(){
            swal({
              title: "",   
              text: "<img src='https://dl.dropboxusercontent.com/u/104755692/huancayo/producto/a"+$(this).parent().parent().find('.ii').attr('id')+".jpg' height='450' width='450'><br><div style='font-size:40px;color:blue;font-weight:bold'>"+$(this).parent().parent().find('.precio').text()+"</div>",   
              html: true,
              showConfirmButton: false
            });
		});
		$('#table').on('click','.imgoferta',function(){
            swal({
              title: "",   
              text: "<img src='https://dl.dropboxusercontent.com/u/104755692/huancayo/producto/a"+$(this).parent().parent().find('.ii').attr('id')+".jpg' height='450' width='450'><br><div style='font-size:22px;color:blue;font-weight:bold'>Precio Normal: "+$(this).parent().parent().find('.precio').text()+"</div><div style='font-size:30px;color:blue;font-weight:bold'>Precio Especial: S/ "+$(this).parent().parent().find('.especial').val()+"</div><div style='font-size:20px;color:grey'>Cant Minima: "+$(this).parent().parent().find('.caja').val()+"</div>",   
              html: true,
              showConfirmButton: false
            });
		});
		$('#salir').click(function(){
			location.href="../sistema/salir.php";
		});
		var modal = document.getElementById('myModal');
		$('#mobile-nav').click(function(event) {
		  if(modal.style.display == "block"){
		  	modal.style.display = "none";
		  }else{
		  	modal.style.display = "block";
		  }
		  $('nav').toggleClass('active');
		});
		$('#myModal').click(function(){
			modal.style.display = "none";
			$('nav').toggleClass('active');
		});
		var p=0;
		$('#users').click(function(){
			if(p%2==0){
				$('#area').css({"width":"200px"});
				$('.tr').hide();
			}else{
				$('#area').css({"width":"255px"});
				$('.tr').show();
				$('#scroll').scrollTop(1000000000000);
			}
			p++;
		});
		$('#users').click();
		$('#credencial').click(function(){
			swal({   
				title: "Cambiar Contraseña",   
				type: "input",   
				showCancelButton: true,   
				closeOnConfirm: false,   
				confirmButtonColor: "#DD6B55",
				animation: "slide-from-top",   
			}, 
			function(inputValue){   
				if (inputValue === false) 
					return false;      
				if (inputValue === "") {     
					swal.showInputError("Debes Escribir una Contraseña");     
					return false   
				}      
				$.ajax({
	                type: "POST",
	                url: "password.php",
	                data: {nombre:$('#nombre').text(),
	                	   pass:inputValue},
	                success: function(data){
						swal({
				            title: "La Contraseña fue cambiada Correctamente",
				            imageUrl: "../correcto.jpg"
				          },
				          function(isConfirm){
				            if (isConfirm) {
				            } 
				        });
	                }
	            });
			});
		});

        var slider=$('#image-gallery').lightSlider({
            gallery:true,
            item:1,
            thumbItem:12,
            slideMargin: 0,
            speed:500,
            pauseOnHover: true,
            galleryMargin: 1,
            controls:true,
            auto:true,
            loop:true,
            onSliderLoad: function() {
                $('#image-gallery').removeClass('cS-hidden');
            }  
        });
        $('#image-gallery').click(function(){
        	slider.pause();
        });
	});
	</script>
	<style type="text/css">
		.ui-dialog .ui-dialog-title {
		    text-align: center;
		    width: 100%;
		}
		.edit:focus {
		    background-color: white;
		}
		#mes{
		    padding: 0px 3px;
		    border-radius: 5px;
		    background-color: rgb(240, 61, 37);
		    font-size: 13px;
		    font-weight: bold;
		    margin-left: -8px;
		    color: #fff;
		    display: none;
		}
		.select1 {
		    cursor: pointer;
		    background: rgba(52,152,219,.9) !important;
		    font-weight: bold;
		    color:white !important;
		}
		.select{
			background-color: #f63 !important;
		}
		::-webkit-scrollbar{
		  width: 8px;  /* for vertical scrollbars */
		}
		::-webkit-scrollbar-track{
		  background: rgba(0, 0, 0, 0);
		}
		::-webkit-scrollbar-thumb{
		  background: rgba(0, 0, 0, 0.5);
		}
        #cotizacion1:hover{
        	background: #2d4b7c;
        }
        #salir:hover{
        	font-size: 20px;
        }

        .fila:hover{
		    background: #FF3;
		}


        .menu {
		  list-style: none;
		  line-height: 42px;
		  margin-top:3em;
		  padding-right: 2em;
		  /*outline: 1px solid red;*/
		  padding-left: 0;
		  width: 15em;
		}

		.menu li:hover {
			color: black;
			background: yellow;
			cursor: pointer;
		    -webkit-transition: all .3s;
		    -o-transition: all .3s;
		    transition: all .3s;
		}

		.menu li {
			color: black;
		  	display: block;
		  	margin-left: 10px;
		  	width: 100%;
		  	box-shadow: 4px 0 rgba(52,152,219,.5) inset;
		  	margin-bottom: 5px;
		  	padding-left: .5em;
		  	-webkit-transition: all .3s;
		  	-o-transition: all .3s;
		 	 transition: all .3s;/*outline: 1px solid green*/
		}

		nav {
			position: fixed;
		  	background: #ffffff;
		  
		  	left: -18em;
		  	top: 0px;
		  	box-sizing: border-box;
		  	z-index: 5;
		  	height: 100%;
		 	-webkit-transition: all .5s;
		 	-o-transition: all .5s;
		  	transition: all .5s;
		}
		 
		nav.active { left: 0;}

		#mobile-nav {
		  background: url(menu-icon.png);
		  cursor: pointer;
		  left: 2em;
		  height: 35px;
		  position: fixed;
		  top: 7px;
		  width: 30px;
		  z-index: 8;
		}

		.modal {
		    display: none; /* Hidden by default */
		    position: fixed; /* Stay in place */
		    z-index: 3; /* Sit on top */
		    left: 0;
		    top: 0;
		    width: 100%; /* Full width */
		    height: 100%; /* Full height */
		    overflow: auto; /* Enable scroll if needed */
		    background-color: rgb(0,0,0); /* Fallback color */
		    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
		}

		.buscar{
			background-color:#337ab7;
			border-radius:3px;
			border:1px solid blue;
			text-align:center;
			color:white;
			font-weight:bold;
			cursor:pointer;
		}
		.buscar:active{
			background-color:#2d4b7c;
			border-radius:3px;
			border:1px solid blue;
			text-align:center;
			color:white;
			font-weight:bold;
			cursor:pointer;
		}

		#back {
		  animation-name: changeColor;
		  animation-duration: 30s;
		  animation-iteration-count: infinite;
		}
		@keyframes changeColor {
		    0%   {background-image:url("http://previews.123rf.com/images/Kurhan/Kurhan1503/Kurhan150300412/37531433-Builder-handyman-with-construction-tools--Stock-Photo.jpg")}
		    30%   {background-image:url("http://previews.123rf.com/images/Kurhan/Kurhan1503/Kurhan150300412/37531433-Builder-handyman-with-construction-tools--Stock-Photo.jpg")}
		    35%   {background-image:url("http://tht.co.nz/wp-content/uploads/2015/07/bigstock-Worker-with-construction-tools-82576331.jpg")}
		    65%   {background-image:url("http://tht.co.nz/wp-content/uploads/2015/07/bigstock-Worker-with-construction-tools-82576331.jpg")}
		    70%   {background-image:url("http://www.nwpropertysafe.co.uk/wp-content/uploads/2015/10/handyman.jpg")}
		    95%   {background-image:url("http://www.nwpropertysafe.co.uk/wp-content/uploads/2015/10/handyman.jpg")}
		    100%   {background-image:url("http://previews.123rf.com/images/Kurhan/Kurhan1503/Kurhan150300412/37531433-Builder-handyman-with-construction-tools--Stock-Photo.jpg")}
		}
		.ui-tooltip{
		    background: #262626;
		    color:white;
		    border:2px solid #262626;
		}
	</style>
</head>
<body style='overflow-y:scroll;background-image:url("http://www.zastavki.com/pictures/originals/2014/Backgrounds_Wooden_floor_082130_.jpg");background-attachment: fixed;'>
	<div id="myModal" class="modal"></div>
	<audio id="sound"><source src="../sistema/notify.wav"></source></audio>
	<div id='name' style='display:none'><?php echo $_SESSION['nombre']; ?></div>
	<div id='cargo' style='display:none'><?php echo $_SESSION['cargo']; ?></div>
	<div id='receptor' style='display:none'>PAUL MELGAR</div>
	<table width='100%' style='background-color:#49afcd;position:fixed;top:0;left:0;z-index:2;height:45px'>
		<tr>
			<td width='20%'><div id="mobile-nav"></div></td>
			<td width='55%'><input type='buscar' id='buscar' placeholder='Buscar Producto...' size='60' style='height:30px;border-radius: 3px;font-size:15px;'></td>
			<td width='15%'>
				<div id='cotizacion1' style='cursor:pointer;border:1px solid #5679EB;height:30px;border-radius:5px;'>
					<div><img src='carrito.png' height='30px' style='float:left;margin-left:10px'></div>
					<div id="mes" style='float:left;'></div>
					<div id='cotizacion' style='font-size:25px;color:white;font-weight:bold;float:right;margin-right:10px'>S/ 0.00</div></td>
				</div>
			</td>
			<td width='10%' id='salir' style='color:white;cursor:pointer;text-align:right'>SALIR</td>
		</tr>
	</table>
	<nav>
		<img src="header.png" style='width:18em;'>
		<img src="https://dl.dropboxusercontent.com/u/104755692/huancayo/logo_ferreboom.png" style='width:12em;left:3em;position:absolute;top:1em'>
		<h1 align='center' style='margin-top:-3em;color:white;' id='nombre'><?php echo substr($_SESSION['nombre'],0,15); ?></h1>
		<h3 align='center' style='margin-top:-1em;color:white'><?php echo $_SESSION['cargo']; ?></h3>
		<h5 align='center' style='margin-top:-1em'><a href="#" id='credencial'>Cambiar Contraseña</a></h6>
		<ul class='menu'>
			<li class='todas'>TODAS LAS CATEGORIAS</li>
		    <?php 
		    $con = mysqli_connect('localhost','root','','paolo');
       			   mysqli_query ($con,"SET NAMES 'utf8'");
            $sql = mysqli_query($con,"SELECT * FROM familia WHERE activo='SI'");
            while($row=mysqli_fetch_assoc($sql)){ ?>
              	<li><?php echo $row['familia']?></li>
            <?php } ?> 
	    </ul>
	</nav>
	<table width='100%' style='border-collapse:collapse;position:absolute;top:45px;left:0px'>
		<tr>
			<td align='center' style="max-width:400px;background-size: 100%;" id='back'>
                <ul id="image-gallery" class="gallery list-unstyled cS-hidden" style='margin-top:50px'>
                	<?php 
		            $sql = mysqli_query($con,"SELECT * FROM producto WHERE activo='OFERTA'");
		            while($row=mysqli_fetch_assoc($sql)){ ?>
		            	<li data-thumb="https://dl.dropboxusercontent.com/u/104755692/huancayo/producto/a<?php echo $row['id']; ?>.jpg"> 
		            		<table style='margin-bottom:50px;border-collapse:collapse;border:5px solid black'>
		            			<tr>
		            				<td style='background-color:white;padding:0px'>
			                        	<img width='300px' height='300px' src="https://dl.dropboxusercontent.com/u/104755692/huancayo/producto/a<?php echo $row['id']; ?>.jpg"/>
			            			</td>
			            			<td style='background-color:white;width:200px'>
			                        	<h1 align='center'><img src="../catalogo/oferta.jpg" width='150px' height='40px'/></h1>
			                        	<h3 align='center' style='color:#4061a7'><?php echo $row['producto']." ".$row['marca']; ?></h4>
			                        	<h2 align='center' style='text-decoration: line-through;margin-top:-15px;color:red'><?php echo "S/ ".$row['p_promotor']; ?></h2>
			                        	<h1 align='center' style='font-size:45px;margin-top:-20px;color:#f63;font-family: "Lato", "sans-serif";'><?php echo "S/ ".$row['p_especial']; ?></h1>
			                        	<h5 align='center' style='margin-top:-15px;margin-bottom:20px;color:#9E9E9E'><?php echo "Cant Minima: ".$row['cant_caja']; ?></h3>
		            				</td>
		            			</tr>
		            		</table>
                        </li>
		            <?php } ?> 
                </ul>
                <div style='position:absolute;left:70px;top:40px;'>
                	<img src="https://dl.dropboxusercontent.com/u/104755692/huancayo/logo_ferreboom.png" width='300px'>
					<table width="300px" style='margin-top:100px'>
						<tr>
							<td style='font-size: 14px;color: white;letter-spacing: 1.2px;' align='center'>Atencion al Cliente</td>
						</tr>
						<tr>
							<td style='color: white;font-size: 28px;' align='center'>Tel: (064) 235152</td>
						</tr>
						<tr>
							<td style='color: white;font-size: 28px;' align='center'>RPM: *376999 - CEL: 973989569</td>
						</tr>
					</table>
				</div>
			</td>
		</tr>
	</table>
	<table width="60%" border='0' style='font-size:12px;margin-top:570px' id='table' cellspacing="10" align='center'>
		
	</table>
	<div style='position:fixed;bottom:0px;right:0px;' id='area'>
		<table width='100%' style='border-collapse:collapse;border:1px solid #49afcd;background-image: url("http://img3.todoiphone.net/wp-content/uploads/2014/03/WhatsApp-Wallpaper-39.jpg");font-family:Arial, Helvetica, sans-serif;'>
			<tr><td id='users' style='height:15px;cursor:pointer;background-color:#49afcd'></td></tr>
			<tr class='tr'>
				<td width='100%' style='height:300px;'>
					<div style='overflow-y:scroll;overflow-x:hidden;height:300px;padding:0px;' id='scroll'>
						<table style='border-collapse:collapse'>
							<tr>
								<td id='areachat' valign='bottom' width='250px' height='300px'>
								</td>
							</tr>
						</table>
					</div>
				</td>
			</tr>
			<tr class='tr'>
				<td width='100%' style='height:12px;'>
					<div id='escr' style='color:#6C6C6C;float:left;font-size:11px;height:12px;'></div>
					<div id='visto' style='color:#6C6C6C;text-align:right;float:right;font-size:11px;display:none;margin-right:10px;height:12px;'>&#10004 Visto</div>
				</td>
			</tr>
			<tr class='tr'>
				<td width='100%' style='padding:2px;height:30px;'><input style='width:100%;height:26px' type='text' id='input' placeholder='Escribe un Mensaje...'>
				</td>
			</tr>
		</table>
	</div>	
	<div id='dialog' style='display:none;'>
		<div align='center'><img id='theImg' src='https://dl.dropboxusercontent.com/u/104755692/huancayo/logo_ferreboom.png' style='width:25%;height:80px;'></div>
		<table width='100%' style='margin-top:-8px'><tr><td width='10%'>CLIENTE:</td><td width='65%'><?php echo $_SESSION['nombre']; ?></td><td width='25%'> <?php echo "FECHA: ".date("d/m/Y") ?> </td></tr></table>
		<table width='100%' style='margin-bottom:5px;margin-top:-5px'><tr bgcolor='black' style='color:white;font-weight:bold;font-size:12px;'><td width='2%' align='center'></td><td width='8%' align='center'>CAN</td><td width='60%' align='center'>PRODUCTO</td><td width='10%' align='center'>P.UNITARIO</td><td width='15%' align='center'>IMPORTE</td><td width='5%'></td></tr></table>
		<div style='margin-top:-5px;'><table id='row' width='100%'></table></div>
		<table width='100%'><tr><td width='80%'></td><td width='15%' id='total' align='right' style='font-weight:bold'>S/ 0.00</td width='5%'><td></td></tr></table>
		<table><tr><td width='10%'>COMENTARIOS:</td><td width='90%'><textarea id="comentario" style="text-transform:uppercase;" rows="3" cols="80"></textarea></td></tr></table>
	</div>
	<div id='agregado' align='center' style='display:none;background-color:#ff3;border:1px solid yellow;position:fixed;bottom:3;width:60%;font-size:25px;left: 50%;transform: translate(-50%, 0);border-radius:10px'>Producto Agregado Correctamente</div>
	<div id='existe' align='center' style='display:none;background-color:#f63;border:1px solid red;position:fixed;bottom:3;width:60%;font-size:25px;left: 50%;transform: translate(-50%, 0);border-radius:10px'>Este Producto ya Esta en la Lista</div>
</body>
</html>
<?php }else{
	header("Location: ../index.php");
} ?>
