<?php 
session_start();
date_default_timezone_set("America/Lima");
if($_SESSION['valida']=='huanuco'){
?>
<html>
<head>
	<title>FERREBOOM</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 
	<link rel="shortcut icon" href="../favicon.ico"/>
	<link type="text/css" href="../sweet-alert.css" rel="stylesheet" />
	<link type="text/css" href="../jquery-ui-1.10.4.custom.min.css" rel="stylesheet" />
	<link rel="stylesheet"  href="../lightslider.css"/>
	<script type="text/javascript" src="../jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="../jquery-ui-1.10.4.custom.min.js"></script>  
	<script type="text/javascript" src="../sweet-alert.min.js"></script>  
	<script type="text/javascript" src="../lightslider.js"></script> 
	<script src="../socket.io.js"></script>
	<script src="../jstorage.js"></script>
	<script type="text/javascript">
	  var socket=io.connect('http://ferreboom.ddns.net:3500');
	  $(function(){
	  	var sum=0;
	  	index = $.jStorage.index();
	  	$.ajax({
	      type: "POST",
	      url: "recuperar.php",
	      data:{data:JSON.stringify(index)},
	      dataType:"json",
	      success: function(data){
	      	for(var i=0; i<data.length; i++){
	            $('#row').append("<tr class='fila'><td width='2.5%' title='s' height='20px' style='padding:0px;cursor:pointer'><img src='https://raw.githubusercontent.com/paolomelgar/www/master/huanuco/fotos/producto/a"+index[i]+".jpg' width='100%'></td><td style='display:none'>"+index[i]+"</td><td align='right' width='7.5%' contenteditable='true' class='edit'>"+$.jStorage.get(index[i])+"</td><td width='60%'>"+data[i][0]+"</td><td align='right' width='10%'>"+data[i][1]+"</td><td align='right' width='15%'>"+parseFloat(data[i][1]*$.jStorage.get(index[i])).toFixed(2)+"</td><td width='5%' align='center'><span class='ui-icon ui-icon-circle-close del' style='cursor:pointer'></td></tr>")
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
            $('#mes').text($('#row tr').length);
        	if($('#row tr').length==0){
				$('#mes').hide();
            }else{
            	$('#mes').show();
            }
	      }
	    });
        
        var date = new Date();
		  $('#fechaini').datepicker({
		    firstDay:1,
		    dateFormat:'dd/mm/yy',
		    monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'],
		    changeMonth: true,
		    changeYear: true,
		    dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa']
		  }).datepicker("setDate", date);
		  $('#fechafin').datepicker({
		    firstDay:1,
		    dateFormat:'dd/mm/yy',
		    monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'],
		    changeMonth: true,
		    changeYear: true,
		    dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa']
		  }).datepicker("setDate", date);

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
	    socket.emit('usuario',{ 
			usuario:$('#name').text(),
			cargo:$('#cargo').text()
		}); 
		var array;
		$.ajax({
	      type: "POST",
	      url: "sistema/novisto.php",
	      data:{usuario:$('#name').text()},
	      dataType: "json",
	      async: false,
	      success: function(data){
	      	array=data;
	      	array = array.filter(function(x) { return $('#receptor').text().indexOf(x) < 0 });
	      	if(data.length>0 && !$("#area").hasClass("visible")){
	      		for(var i=0;i<array.length;i++){
					socket.emit('user-message',{ 
						emisor:$('#name').text(),
						message:"fin",
						receptor:array[i]
					}); 	
				}
	      	}
	      }
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
				if(data[i][0]=='PAOLO MELGAR' && mm==0){
					x=1;
					$('#users').append('<div style="width: 10px;height: 10px;border-radius: 5px;background-color:#58FA58;float:left;margin-top:3px;margin-right:5px;margin-left:3px"></div><div style="float:left;color:white;">ADMIN(Conectado)</div>');
				}
			}
			if(x==0){
				$('#users').append('<div style="width: 10px;height: 10px;border-radius: 5px;background-color:red;float:left;margin-top:3px;margin-right:5px;margin-left:3px"></div><div style="float:left;color:white;">ADMIN(Desconectado)</div>');
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
					if($('.tr1').is(":visible")){
						
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
	          					"<tr><td colspan='2' align='center' class='img' style='cursor:pointer'><img src='https://raw.githubusercontent.com/paolomelgar/www/master/huanuco/fotos/producto/a"+data[i][10]+".jpg' height='200' width='200'><img src='agotado.png' width='200px' style='position:absolute;margin-left:-200px;margin-top:26px;color:red;font-weight:bold;font-size:30px;'/></td></tr>\n";
	          					if(data[i][7]>0){
		          				d += "<tr><td width='100px'><img src='https://raw.githubusercontent.com/paolomelgar/www/master/huanuco/fotos/marca/a"+data[i][7]+".jpg' width='100px'></td><td width='100px' style='font-weight:bold;font-size:25px;color:#f63;' class='precio' align='center'>S/ "+data[i][1]+"</td></tr>\n";
		          			}else{
		          				d += "<tr><td width='100px' align='center' style='font-weight:bold'>"+data[i][7]+"</td><td width='100px' style='font-weight:bold;font-size:25px;color:#f63;' class='precio' align='center'>S/ "+data[i][1]+"</td></tr>\n";
		          			}
		          				d += "<tr><td colspan='2' style='font-weight:bold;font-size:13px;height:30px;color:#4061a7;text-align:center'>"+data[i][0]+"</td></tr>\n"+
		          					 "<tr style='display:none'><td><input type='hidden' class='idmarca' value='"+data[i][7]+"'><input type='text' class='ii' id='"+data[i][4]+"'></td></tr>\n"+
		          					 "<tr><td colspan='2' align='center' style='color:red;font-weight:bold;font-size:22px;padding:0px'>AGOTADO</td></tr></table>\n"+
		          				 "</td>";
	          		}else{
	          			if(data[i][6]=='OFERTA'){
	          				d += "<td width='15%' align='center' style='font-size:14px;border:4px solid #8E8E8E;border-radius:5px;background-color:white;padding:0px' class='aa'>\n"+
		          					"<table width='100%' style='border-collapse:collapse;'>\n"+
		          					"<tr><td colspan='2' align='center' class='imgoferta' style='cursor:pointer'><img src='https://raw.githubusercontent.com/paolomelgar/www/master/huanuco/fotos/producto/a"+data[i][10]+".jpg' height='200' width='200'><img src='oferta.png' width='200px' style='position:absolute;margin-left:-200px;margin-top:0px;color:red;font-weight:bold;font-size:30px;'/></td></tr>\n";
		          			if(data[i][7]>0){
		          				d += "<tr><td width='100px'><img src='https://raw.githubusercontent.com/paolomelgar/www/master/huanuco/fotos/marca/a"+data[i][7]+".jpg' width='100px'></td><td width='100px' style='font-weight:bold;font-size:25px;color:#f63;' class='precio' align='center'>S/ "+data[i][1]+"</td></tr>\n";
		          			}else{
		          				d += "<tr><td width='100px' align='center' style='font-weight:bold'>"+data[i][7]+"</td><td width='100px' style='font-weight:bold;font-size:25px;color:#f63;' class='precio' align='center'>S/ "+data[i][1]+"</td></tr>\n";
		          			}
		          				d += "<tr><td colspan='2' class='prod' style='font-weight:bold;font-size:13px;height:30px;color:#4061a7;text-align:center'>"+data[i][0]+"</td></tr>\n"+
		          					 "<tr style='display:none'><td><input type='hidden' class='idmarca' value='"+data[i][7]+"'><input type='hidden' class='marca' value='"+data[i][8]+"'><input type='text' class='ii' id='"+data[i][4]+"'><input type='hidden' class='especial' value='"+data[i][2]+"'><input type='hidden' class='caja' value='"+data[i][5]+"'></td></tr>\n"+
		          				 	 "<tr><td width='100px' align='center'><input type='hidden' value='"+data[i][3]+"' class='stock'>Cant:<input type='text' class='cant' size='3' style='border:2px solid red;border-radius:3px;text-align:center;font-weight:bold'></td><td width='100px'><div class='buscar'>AGREGAR</div></td></tr></table>\n"+
		          				 "</td>";
	          			}else{
	          				if(data[i][9]=="nuevo"){
		          				d += "<td width='15%' align='center' style='font-size:14px;border:4px solid #8E8E8E;border-radius:5px;background-color:white;padding:0px' class='aa'>\n"+
			          					"<table width='100%' height='300px' style='border-collapse:collapse;'>\n"+
			          					"<tr><td colspan='2' align='center' class='img' style='cursor:pointer'><img src='https://raw.githubusercontent.com/paolomelgar/www/master/huanuco/fotos/producto/a"+data[i][10]+".jpg' height='200' width='200'><img src='nuevo.png' width='200px' style='position:absolute;margin-left:-200px;margin-top:0px;color:red;font-weight:bold;font-size:30px;'/></td></tr>\n";
		          			}else{
		          				d += "<td width='15%' align='center' style='font-size:14px;border:4px solid #8E8E8E;border-radius:5px;background-color:white;padding:0px' class='aa'>\n"+
			          					"<table width='100%' height='300px' style='border-collapse:collapse;'>\n"+
			          					"<tr><td colspan='2' align='center' class='img' style='cursor:pointer'><img src='https://raw.githubusercontent.com/paolomelgar/www/master/huanuco/fotos/producto/a"+data[i][10]+".jpg' height='200' width='200'></td></tr>\n";
		          			}
		          			if(data[i][7]>0){
		          				d += "<tr><td width='100px'><img src='https://raw.githubusercontent.com/paolomelgar/www/master/huanuco/fotos/marca/a"+data[i][7]+".jpg' width='100px'></td><td width='100px' style='font-weight:bold;font-size:25px;color:#f63;' class='precio' align='center'>S/ "+data[i][1]+"</td></tr>\n";
		          			}else{
		          				d += "<tr><td width='100px' align='center' style='font-weight:bold'>"+data[i][7]+"</td><td width='100px' style='font-weight:bold;font-size:25px;color:#f63;' class='precio' align='center'>S/ "+data[i][1]+"</td></tr>\n";
		          			}
		          				d += "<tr><td colspan='2' class='prod' style='font-weight:bold;font-size:13px;height:30px;color:#4061a7;text-align:center'>"+data[i][0]+"</td></tr>\n"+
		          					 "<tr style='display:none'><td><input type='hidden' class='idmarca' value='"+data[i][7]+"'><input type='hidden' class='marca' value='"+data[i][8]+"'><input type='text' class='ii' id='"+data[i][4]+"'></td></tr>\n"+
		          					 "<tr><td width='100px' align='center'><input type='hidden' value='"+data[i][3]+"' class='stock'>Cant:<input type='text' class='cant' size='3' style='border:2px solid red;border-radius:3px;text-align:center;font-weight:bold'></td><td width='100px'><div class='buscar'>AGREGAR</div></td></tr></table>\n"+
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
	          	
	          },
	          error: function(xmlhttprequest, textstatus, message) {
	          	$('.load').hide();
		        $('#table').append("<tr class='cargar' style='height:50px'><td colspan='4' height='50px' align='center'>Buscar mas Productos</td></tr>");
		      }
	  		});
	  	}
	  	var typingTimer;
	  	$("#buscar").keyup(function(e){
	  		if (e.which==13) {
	  			clearTimeout(typingTimer);
		      $('#search').click();
		    }else{
			    var top=parseInt($(this).position().top)+34;
			    var left=parseInt($(this).position().left)+3;
			    $("#result").css({"top":""+top+"px", "left":""+left+"px"});
			    clearTimeout(typingTimer);
			      typingTimer = setTimeout(function(){  
			      $.ajax({
			        type: "POST",
			        url: "producto.php",
			        data: {b:$('#buscar').val()},
			        cache: false,
			        beforeSend:function(){
			            $('#result').empty();
			            $('#result').append("<table style='border-collapse:collapse;' width='100%'><tr bgcolor='white'><td align='center' width='100%'><img src='../gif.gif' width='100px'></td></tr></table>");
			            $('#result').show();
			        },
			        success: function(data){
			          	$("#result").empty();
			          	$("#result").append(data);
			          	$('.tr').on('click',function(){
				            $('#buscar').val($(this).find('td:eq(0)').text()+" "+$(this).find('td:eq(1)').text());
				            $('#search').click();
			          	});
			          	$('.all').on('click',function(){
				            $('#search').click();
			          	});
			        }
			      });
			}, 400);
		  }
		}); 
		$('#table').on('click','.cargar',function(){
			Buscar($('#buscar').val(),m,$('.select1').text());
		});
	  	$('.menu li.todas').addClass('select1');
	  	Buscar('',0,$('.select1').text(),1);
	  	$('#search').click(function(){
	  		$('.menu li').removeClass('select1');
        	$('.menu li.todas').addClass('select1');
        	m=0;
            $('#table').empty();
	  		Buscar($('#buscar').val(),0,$('.select1').text(),0);
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
	    	if(parseInt($(this).parent().parent().parent().find(".cant").val())>0 && parseInt($(this).parent().parent().parent().find(".cant").val())<=parseInt($(this).parent().parent().parent().find(".stock").val())){
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
		    		$('#row').append("<tr class='fila'><td width='2.5%' title='s' height='20px' style='padding:0px;cursor:pointer'><img src='https://raw.githubusercontent.com/paolomelgar/www/master/huanuco/fotos/producto/a"+id+".jpg' width='100%'></td><td style='display:none'>"+id+"</td><td align='right' width='7.5%' contenteditable='true' class='edit'>"+cant+"</td><td width='60%'>"+prod+" "+marca+"</td><td align='right' width='10%'>"+precio+"</td><td align='right' width='15%'>"+total+"</td><td width='5%' align='center'><span class='ui-icon ui-icon-circle-close del' style='cursor:pointer'></td></tr>");
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

	            $.jStorage.set(id, cant);
	        }else if(parseInt($(this).parent().parent().parent().find(".cant").val())>parseInt($(this).parent().parent().parent().find(".stock").val())){
	        	swal({
		            title: "Stock",
		            text: "<span style='color:#F63;font-weight:bold;font-size:60px'>"+$(this).parent().parent().parent().find(".stock").val()+"</span>",
		            html: true,
		            type: "warning",
		        });
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
					          	$.jStorage.flush();
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
    	$('#row').on('keyup','.edit',function(){
    		$.jStorage.set($(this).parent().find('td:eq(1)').text(), $(this).text());
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
			$('.fila').removeClass('select');
	    	$(this).parent().parent().addClass('select');
			$.jStorage.deleteKey($(this).parent().parent().find('td:eq(1)').text());
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
		});
		$('#table').on('click','.img',function(){
			var a;
			if(parseInt($(this).parent().parent().find('.idmarca').val())>0){
				a="<img src='https://raw.githubusercontent.com/paolomelgar/www/master/huanuco/fotos/marca/a"+$(this).parent().parent().find('.idmarca').val()+".jpg' height='50' width='250'>";
			}else{
				a=$(this).parent().parent().find('.idmarca').val();
			}
            swal({
              title: a,
              text: "<img src='https://raw.githubusercontent.com/paolomelgar/www/master/huanuco/fotos/producto/a"+$(this).parent().parent().find('.ii').attr('id')+".jpg' height='300' width='300'><br><div style='font-size:40px;color:blue;font-weight:bold'>"+$(this).parent().parent().find('.precio').text()+"</div>",   
              html: true,
              animation: "slide-from-top",
			  confirmButtonColor: "#DD6B55"
            });
		});
		$('#table').on('click','.imgoferta',function(){
			var a;
			if(parseInt($(this).parent().parent().find('.idmarca').val())>0){
				a="<img src='https://raw.githubusercontent.com/paolomelgar/www/master/huanuco/fotos/marca/a"+$(this).parent().parent().find('.idmarca').val()+".jpg' height='50' width='250'>";
			}else{
				a=$(this).parent().parent().find('.idmarca').val();
			}
            swal({
              title: a,   
              text: "<img src='https://raw.githubusercontent.com/paolomelgar/www/master/huanuco/fotos/producto/a"+$(this).parent().parent().find('.ii').attr('id')+".jpg' height='300' width='300'><br><div style='font-size:22px;color:black;font-weight:bold;text-decoration: line-through;'>"+$(this).parent().parent().find('.precio').text()+"</div><div style='font-size:40px;color:blue;font-weight:bold'>S/ "+$(this).parent().parent().find('.especial').val()+"</div><div style='font-size:16px;color:grey'>Cant Minima: "+$(this).parent().parent().find('.caja').val()+"</div>",   
              html: true,
              animation: "slide-from-top",
			  confirmButtonColor: "#DD6B55"
			});
		});
		$('#salir').click(function(){
			location.href="../salir.php";
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
				$('#area').css({"width":"220px"});
				$('.tr1').hide();
			}else{
				$('#area').css({"width":"255px"});
				$('.tr1').show();
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
        $('body').click(function(){
        	$('#result').hide();
        });
        $("#ver").click(function(){
		    $("#dialogver").show();
		    $('#buscar1').click();
		});
		$("#salir1").click(function(){
		    $("#dialogver").hide();
		    $("#observarpedido").dialog("close");
		});
		var serie1;
		$('#dialogver').on('click','.visualizar',function(){
		    $('#observarpedido').dialog("open");
		    serie1=$(this).parent().find('td:eq(0)').text();
		    $.ajax({
		      type: "POST",
		      url: "verlistaproductos.php",
		      data: 'serie='+serie1,
		      beforeSend:function(){
		        $('#observarpedido').empty();
		        $('#observarpedido').append("<table width='100%'><tr><td align='center'><img src='../loading.gif' width='450px'></td></tr></table>");
		      },
		      success: function(data){
		        $('#observarpedido').empty();
		        $('#observarpedido').append(data);
		      }
		    });
		});
		$('#buscar1').click(function(){
		    var fechaini=$('#fechaini').val();
		    var fechafin=$('#fechafin').val();
		    $.ajax({
		      type: "POST",
		      url: "verventas.php",
		      dataType:"json",
		      data: {ini:fechaini,
		             fin:fechafin},
		      beforeSend:function(){
		        $('#verbody').empty();
		        $('#verbody').append("<tr><td align='center' colspan='8'><img src='../loading.gif' width='420px'></td></tr>");
		      },       
		      success: function(data){
		        $("#verbody").empty();
		        for (var i = 0; i <= data.length-1; i++) {
		            $("#verbody").append("<tr><td align='right' width='10%' style='border:1px solid #B1B1B1'>"+data[i][0]+"</td><td align='center' width='15%' style='border:1px solid #B1B1B1'>"+data[i][1]+"<br>"+data[i][2]+"</td><td align='center' width='40%' style='border:1px solid #B1B1B1'>"+data[i][3]+"</td><td width='15%' align='center' style='border:1px solid #B1B1B1'>"+data[i][4]+"</td><td align='right' width='10%' style='border:1px solid #B1B1B1'>"+data[i][5]+"</td><td align='center' width='10%' class='visualizar' style='color:red;font-weight:bold;cursor:pointer;border:1px solid #B1B1B1;'>Ver</td></tr>");
		        }
		        $('#verbody> tr:odd').addClass('par');
		        $('#verbody> tr:even').addClass('impar');
		        $('#ventas').tableFilterRefresh();
		      }
		    });
		});
		$('#observarpedido').dialog({
		    title:"LISTA PEDIDOS",
		    position: "right top",
		    autoOpen:false,
		    height: 480,
		    width: 450,
		    show: {effect: "slide",duration: 100},
		    hide: {effect: "slide",duration: 100},
		    buttons: [
		      {
		          text: "IMPRIMIR",
		          icons: { primary: "ui-icon-print" },
		          click: function() { 
				    $('#dx').empty();
				    $.ajax({
				      type: "POST",
				      url: "../caja/vercomprobantes.php",
				      dataType: "json",
				      data: 'serie='+serie1+'&com=NOTA DE PEDIDO',
				      success: function(data){
				        $('#dx').append("<table width='80%' style='font:0.8em Verdana;' align='center'><tr><td><span style='margin-left:220px'><b>NOTA DE PEDIDO</b></span><span style='float:right;font-family:Calibri'>Tel:(062)503715 - Cel:#999050151</span></td></tr></table>\n"+
				          "<table width='80%' align='center' style='margin-top:-7px;font:0.9em Calibri;'><tr><td width='10%'>RUC:</td><td width='55%'>"+data[1][0]+"</td><td width='10%'>Fecha:</td><td width='25%'>"+data[1][12]+"</td></tr></table>\n"+
				          "<table width='80%' align='center' style='margin-top:-7px;font:0.9em Calibri;'><tr><td width='10%'>CLIENTE:</td><td width='55%'>"+data[1][1]+"</td><td width='10%'>Vendedor:</td><td width='25%'>"+data[1][6]+"</td></tr></table>\n"+
				          "<table width='80%' align='center' style='margin-top:-7px;font:0.9em Calibri;'><tr><td width='10%'>DIRECCION:</td><td width=100%' style='font-family:Agency FB'>"+data[1][2]+"</td></tr></table>\n"+
				          "<table width='80%' align='center' style='margin-bottom:5px;margin-top:0px;font:0.7em Verdana;font-weight:bold;border-collapse:collapse'><tr style='border:1px solid black'><td width='2%'></td><td width='5%' align='center'>CAN</td><td width='73%' align='center'>PRODUCTO</td><td width='10%' align='center'>P.UNITARIO</td><td width='10%' align='center'>IMPORTE</td></tr></table>\n"
				        );
				        for (var i=0;i<data[0].length;i++) {
				          $('#dx').append("<table width='80%' align='center' style='margin-top:-6px;font:0.8em Verdana;'><tr><td width='2%' align='center'><input style='width:10px;height:10px;border:1px solid black'></td><td width='5%' align='right'>"+data[0][i][1]+"</td><td width='1%'></td><td width='72%'>"+data[0][i][0]+"</td><td width='10%' align='right'>"+data[0][i][2]+"</td><td width='10%' align='right'>"+data[0][i][3]+"</td></tr></table>");
				        }
				        if(parseFloat(data[1][4])!=0){
				          $('#dx').append("<table width='80%' align='center' style='margin-top:-5px;margin-bottom:5px;font:0.8em Verdana;'><tr><td colspan='4' width='90%' align='right'>SUBTOTAL</td><td width='10%' align='right'>"+data[1][3]+"</td></tr></table><hr style='margin-top:-6px'>");
				          for (var i=0;i<data[2].length;i++) {
				            $('#dx').append("<table width='80%' align='center' style='margin-top:-6px;font:0.8em Verdana;'><tr><td width='5%' align='right'>"+data[2][i][1]+"&nbsp&nbsp</td><td width='75%'>"+data[2][i][0]+"</td><td width='10%' align='right'>"+data[2][i][2]+"</td><td width='10%' align='right'>"+data[2][i][3]+"</td></tr></table>");
				          }
				          $('#dx').append("<table width='80%' align='center' style='margin-top:-5px;font:0.8em Verdana;'><tr><td colspan='4' width='90%' align='right'>DEVOLUCION</td><td align='right'>"+data[1][4]+"</td></tr></table>");
				        }
				        $('#dx').append("<table width='80%' align='center' style='margin-top:-5px;font:0.8em Verdana;'><tr><td colspan='4' width='90%' align='right'>TOTAL</td><td align='right'>"+data[1][5]+"</td></tr></table>");
				        if(data[1][10]>0){
				          $('#dx').append("<table width='80%' align='center' style='margin-top:-5px;font:0.8em Verdana;' ><tr><td colspan='4' width='90%' align='right'>A/C.</td><td align='right'>"+data[1][10]+"</td></tr></table>");
				          var resta1=parseFloat(data[1][5]-data[1][10]).toFixed(2);
				          $('#dx').append("<table width='80%' align='center' style='margin-top:-5px;font:0.8em Verdana;'><tr><td colspan='4' width='90%' align='right'>RESTA</td><td align='right'>"+resta1+"</td></tr></table></div>");
				        }
				        var contenid = document.getElementById("dx");
				        var x1 = screen.width/2 - 1200/2;
				        var y1 = screen.height/2 - 700/2;
				        var w=window.open('','',"width=1200,height=600,left="+x1+",top="+y1);
				        w.document.write("<html><head><style type='text/css'>@page{size:A4 portrait;}</style></head><body>"+contenid.innerHTML+"</body></html>");
				        w.focus();
				        w.print();
				        setTimeout(function(){w.close();}, 200);
				      }
				    });
		          }
		      }
		    ],
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
		#dialogver {
		    position: absolute;
		    display: none;
		    border: solid 1px #2d4b7c;
		    border-radius: .5em;background-color:#f63;
		    top:0px;
		    width: 900px;
		    height: 480px;
		    z-index: 3;
		    box-shadow: 5px 5px 2px grey;
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
		.par{
		    background-color: white;
		}
		.impar{
		    background-color: #E0F8E0;
		}
		.select1 {
		    cursor: pointer;
		    background: linear-gradient(#00d2ff, #3a7bd5) !important;
		    font-weight: bold;
		    color:white !important;
		}
		.select{
			background-color: #f63 !important;
		}
		::-webkit-scrollbar{
		  width: 12px;  /* for vertical scrollbars */
		}
		::-webkit-scrollbar-track{
		  background: rgba(0, 0, 0, 0);
		}
		::-webkit-scrollbar-thumb{
		  background: rgba(0, 0, 0, 0.5);
		}
        #cotizacion1:hover{
        	background: linear-gradient(#4b6cb7, #182848);
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
		.tr:hover{
		    background: #FF3;
		    cursor:pointer;
		}
		.all:hover{
		    background: #FF3;
		    cursor:pointer;
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
		    0%   {background-image:url("https://c2.staticflickr.com/4/3860/14655869001_6a61c11a14_b.jpg")}
		    30%   {background-image:url("https://c2.staticflickr.com/4/3860/14655869001_6a61c11a14_b.jpg")}
		    35%   {background-image:url("https://d3e7x39d4i7wbe.cloudfront.net/uploads/post/image/8697/half_size_S_Cool_Tools__1_-1471460444.jpg")}
		    65%   {background-image:url("https://d3e7x39d4i7wbe.cloudfront.net/uploads/post/image/8697/half_size_S_Cool_Tools__1_-1471460444.jpg")}
		    70%   {background-image:url("http://www.jeffbullas.com/wp-content/uploads/2015/08/Tools-for-content-marketers-header-image.jpg")}
		    95%   {background-image:url("http://www.jeffbullas.com/wp-content/uploads/2015/08/Tools-for-content-marketers-header-image.jpg")}
		    100%   {background-image:url("https://c2.staticflickr.com/4/3860/14655869001_6a61c11a14_b.jpg")}
		}
		.ui-tooltip{
		    background: #262626;
		    color:white;
		    border:2px solid #262626;
		}
		#buscar:focus{
  			border: 1px solid #182848;
		}
		#buscar{
			border:1px solid white;
		    padding-left: 38px;
		    background: url('http://www.freeiconspng.com/uploads/search-icon-png-17.png') 7px center no-repeat #ffffff;
		    background-size: 25px 25px;
		    width:60%;
		    height:35px;
		    font-size:15px;
		    float:left;
		    padding-top:2px;
		    padding-bottom:2px;
		    border-radius:5px;
		}
	</style>
</head>
<body style='overflow-y:scroll;background-image:url("madera.jpg");background-attachment: fixed;'>
	<div id='dx' style='display:none'></div>
	<div id="myModal" class="modal"></div>
	<div id='result' style='position:fixed;display:none;width:30%;z-index:3;box-shadow: 5px 5px 2px grey;'></div>
	<audio id="sound"><source src="../sistema/notify.wav"></source></audio>
	<div id='name' style='display:none'><?php echo $_SESSION['nombre']; ?></div>
	<div id='cargo' style='display:none'><?php echo $_SESSION['cargo']; ?></div>
	<div id='receptor' style='display:none'>PAOLO MELGAR</div>
	<table width='100%' style='background: linear-gradient(#00d2ff, #3a7bd5);position:fixed;top:0;left:0;z-index:2;height:45px'>
		<tr>
			<td width='15%'><div id="mobile-nav"></div></td>
			<td width='15%'><input type="button" value="VER" id="ver" style="cursor:pointer;"></td>
			<td width='45%'>
				<input type='buscar' id='buscar' placeholder='Buscar Producto...' autocomplete="off">
				<input type="image" src="buscar.png" alt="Submit" style='height:30px;float:left;display:none' id='search'>
			</td>
			<td width='15%'>
				<div id='cotizacion1' style='cursor:pointer;border:1px solid #182848;height:30px;border-radius:5px;width:180px'>
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
		<img src="https://raw.githubusercontent.com/paolomelgar/ferreboom/master/huanuco/logo_ferreboom.png" style='width:12em;left:3em;position:absolute;top:1em'>
		<h3 align='center' style='margin-top:-4em;color:white;width:15em;background:red;' id='nombre'><?php echo $_SESSION['nombre']; ?></h3>
		<h5 align='center' style='margin-top:-1em'><a href="#" id='credencial'>Cambiar Contraseña</a></h6>
		<ul class='menu' style='margin-top:-5px'>
			<li class='todas'>TODAS LAS CATEGORIAS</li>
		    <?php 
		    require_once('../connection.php');
            $sql = mysqli_query($con,"SELECT * FROM familia WHERE activo='SI'");
            while($row=mysqli_fetch_assoc($sql)){ ?>
              	<li><?php echo $row['familia']?></li>
            <?php } ?> 
	    </ul>
	</nav>
	<div id="dialogver" style="display:none;position: fixed">
              <table width="100%" align="center">
                <tr>
                  <td>FECHA INICIO:<input type="text" id="fechaini" style="cursor:pointer;font-weight:bold;text-align:right;width:80px"></td>
                  <td>FECHA FIN:<input type="text" id="fechafin" style="cursor:pointer;font-weight:bold;text-align:right;width:80px"></td>
                  <td><input type="button" id="buscar1" value="Buscar"/></td>
                  <td><span class='ui-icon ui-icon-circle-close' id='salir1' style=';cursor:pointer'></td>
                </tr>
              </table>
              <div id="listapedido">
                <table width="98%" align="center">
                  <thead>
                    <tr bgcolor="black" style="color:#FFF; text-align:center;font-weight:bold">
                        <th width="10%">SERIE</th>
                        <th width="15%">FECHA</th>
                        <th width="40%">CLIENTE</th>
                        <th width="15%">PAGO</th>
                        <th width="10%">TOTAL</th>
                        <th width="10%"></th>
                    </tr>
                  </thead>
                </table>
                <div style="overflow-y:overlay;overflow-x:hidden;height:400px;align:center;color:black;width:98%;margin:auto;font-size:12px;font-family:Verdana;" class='par'>
                  <table width="100%" align="center" id='ventas' border='0' style='border-collapse: collapse;'>
                    <thead>
                      <tr style='display:none;'>
                        <th width="10%">SERIE</th>
                        <th width="15%">FECHA</th>
                        <th width="40%">CLIENTE</th>
                        <th width="15%">PAGO</th>
                        <th width="10%">TOTAL</th>
                        <th width="10%">VER</th>
                      </tr>
                    </thead>
                    <tbody id="verbody">
                    </tbody>
                  </table>
                </div>
              </div>
              <div id='observarpedido'></div>
            </div>
	<table width='100%' style='border-collapse:collapse;position:absolute;top:45px;left:0px'>
		<tr>
			<td align='center' style="max-width:400px;background-size: 100%;" id='back'>
                <ul id="image-gallery" class="gallery list-unstyled cS-hidden" style='margin-top:50px'>
                	<?php 
		            $sql = mysqli_query($con,"SELECT * FROM producto WHERE activo='OFERTA'");
		            while($row=mysqli_fetch_assoc($sql)){ ?>
		            	<li data-thumb="https://raw.githubusercontent.com/paolomelgar/www/master/huanuco/fotos/producto/a<?php echo $row['codigo']; ?>.jpg"> 
		            		<table style='margin-bottom:50px;border-collapse:collapse;border:5px solid black'>
		            			<tr>
		            				<td style='background-color:white;padding:0px'>
			                        	<img width='300px' height='300px' src="https://raw.githubusercontent.com/paolomelgar/www/master/huanuco/fotos/producto/a<?php echo $row['codigo']; ?>.jpg"/>
			            			</td>
			            			<td style='background-color:white;width:200px'>
			                        	<h1 align='center'><img src="../catalogo1/oferta.jpg" width='150px' height='40px'/></h1>
			                        	<h3 align='center' style='color:#4061a7'><?php echo $row['producto']." ".$row['marca']; ?></h4>
			                        	<?php if($_SESSION['cargo']=='CLIENTE'){ ?>
			                        	<h2 align='center' style='text-decoration: line-through;margin-top:-15px;color:red'><?php echo "S/ ".$row['p_promotor']; ?></h2>
			                        	<h1 align='center' style='font-size:45px;margin-top:-20px;color:#f63;font-family: "Lato", "sans-serif";'><?php echo "S/ ".$row['p_especial']; ?></h1>
			                        	<?php }else{ ?>
			                        	<h2 align='center' style='text-decoration: line-through;margin-top:-15px;color:red'><?php echo "S/ ".$row['p_unidad']; ?></h2>
			                        	<h1 align='center' style='font-size:45px;margin-top:-20px;color:#f63;font-family: "Lato", "sans-serif";'><?php echo "S/ ".$row['p_mayor']; ?></h1>
			                        	<?php } ?>
			                        	<h5 align='center' style='margin-top:-15px;margin-bottom:20px;color:#9E9E9E'><?php echo "Cant Minima: ".$row['cant_caja']; ?></h3>
		            				</td>
		            			</tr>
		            		</table>
                        </li>
		            <?php } ?> 
                </ul>
                <div style='position:absolute;left:70px;top:40px;'>
                	<img src="https://raw.githubusercontent.com/paolomelgar/ferreboom/master/huanuco/logo_ferreboom.png" width='300px'>
					<table width="300px" style='margin-top:100px'>
						<tr>
							<td style='font-size: 14px;color: white;letter-spacing: 1.2px;' align='center'>Atencion al Cliente</td>
						</tr>
						<tr>
							<td style='color: white;font-size: 28px;' align='center'>Tel: (062) 503715</td>
						</tr>
						<tr>
							<td style='color: white;font-size: 28px;' align='center'>RPM: #999050151</td>
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
			<tr><td id='users' style='height:25px;cursor:pointer;background: linear-gradient(#00d2ff, #3a7bd5);'></td></tr>
			<tr class='tr1'>
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
			<tr class='tr1'>
				<td width='100%' style='height:12px;'>
					<div id='escr' style='color:#6C6C6C;float:left;font-size:11px;height:12px;'></div>
					<div id='visto' style='color:#6C6C6C;text-align:right;float:right;font-size:11px;display:none;margin-right:10px;height:12px;'>&#10004 Visto</div>
				</td>
			</tr>
			<tr class='tr1'>
				<td width='100%' style='padding:2px;height:30px;'><input style='width:100%;height:26px' type='text' id='input' placeholder='Escribe un Mensaje...'>
				</td>
			</tr>
		</table>
	</div>	
	<div id='dialog' style='display:none;'>
		<div align='center'><img id='theImg' src='https://raw.githubusercontent.com/paolomelgar/ferreboom/master/huanuco/logo_ferreboom.png' style='width:25%;height:80px;'></div>
		<table width='100%' style='margin-top:-8px'><tr><td width='10%'>CLIENTE:</td><td width='65%'><?php echo $_SESSION['nombre']; ?></td><td width='25%'> <?php echo "FECHA: ".date("d/m/Y") ?> </td></tr></table>
		<table width='100%' style='margin-bottom:5px;margin-top:-5px'><tr bgcolor='black' style='color:white;font-weight:bold;font-size:12px;'><td width='2%' align='center'></td><td width='8%' align='center'>CAN</td><td width='60%' align='center'>PRODUCTO</td><td width='10%' align='center'>P.UNITARIO</td><td width='15%' align='center'>IMPORTE</td><td width='5%'></td></tr></table>
		<div style='margin-top:-5px;'><table id='row' width='100%'></table></div>
		<table width='100%'><tr><td width='80%'></td><td width='15%' id='total' align='right' style='font-weight:bold'>S/ 0.00</td width='5%'><td></td></tr></table>
		<table><tr><td width='10%'>OBSERVACIONES:</td><td width='90%'><textarea id="comentario" style="text-transform:uppercase;width:90%" rows="3"></textarea></td></tr></table>
	</div>
	<div id='agregado' align='center' style='display:none;background-color:#ff3;border:1px solid yellow;position:fixed;bottom:3;width:60%;font-size:25px;left: 50%;transform: translate(-50%, 0);border-radius:10px'>Producto Agregado Correctamente</div>
	<div id='existe' align='center' style='display:none;background-color:#f63;border:1px solid red;position:fixed;bottom:3;width:60%;font-size:25px;left: 50%;transform: translate(-50%, 0);border-radius:10px'>Este Producto ya Esta en la Lista</div>
</body>
</html>
<?php }else{
	header("Location: ../index.php");
} ?>
