	var socket=io.connect('http://ferreboom.com:3500');
	$(function(){
		window.addEventListener('online',  function(){
			socket.emit('con','');
			$('#con').prop('readonly', false);
		});
		window.addEventListener('offline', function(){
			$('#users').empty().append("No es posible conectar con el Chat. Revisa tu Conexion a Internet");
			$('#con').prop('readonly', true);
		});
		$(document).tooltip({
			position: {
		        my: "right top",
		        at: "left+5 top",
		    }
		});
		var count=0;
		var j=0;
		var i=0;
		socket.emit('usuario',{ 
			usuario:$('#name').text(),
			cargo:$('#cargo').text(),
			local:"huanuco"
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
		
		socket.on('usuario',function(data){ 
			if($('#con').val().length == 0){
				var arr=array;
				$('#users').empty();
				for(var i=0;i<data.length;i++){
					if(data[i]!=$('#name').text()){
						var a;
						a = arr.filter(function(x) { return data[i].indexOf(x) < 0 });
						if(a.length==arr.length){
							$('#users').append('<tr style="color:white" class="fila"><td><div style="width: 8px;height: 8px;border-radius: 4px;background-color:#58FA58;"></div></td><td><div style="font-size:15px" class="user">'+data[i]+'</div></td><td></td></tr>');
						}else{
							$('#users').append('<tr style="color:white" class="fila"><td><div style="width: 8px;height: 8px;border-radius: 4px;background-color:#58FA58;"></div></td><td><div style="font-size:15px" class="user">'+data[i]+'</div></td><td><div style="padding: 0px 3px;border-radius: 3px 3px 3px 3px;background-color: rgb(240, 61, 37);font-size: 15px;font-weight: bold;color: #fff;cursor:pointer">new</div></td></tr>');
						}
						arr=a;
					}
				}
				for(var i=0;i<arr.length;i++){
					$('#users').append('<tr style="color:white" class="fila"><td><div style="width: 8px;height: 8px;border-radius: 4px;background-color:#2d4b7c;"></div></td><td><div style="font-size:15px" class="user">'+array[i]+'</div><div style="font-size:10px">DESCONECTADO</div></td><td><div style="padding: 0px 3px;border-radius: 3px 3px 3px 3px;background-color: rgb(240, 61, 37);font-size: 15px;font-weight: bold;color: #fff;cursor:pointer">new</div></td></tr>');
				}
			}
    	});
		var fecha;
	    $('#users').on('click','.fila',function(){
			j=0;
			if($('#receptor').text()!=$(this).find('.user').text()){
				fecha=$.datepicker.formatDate('dd/mm/yy', new Date());
				$('#areachat').empty();
				$('#input').prop('readonly', false);
                $('#visto').empty();
                $('#escr').empty();
				$('#receptor').text($(this).find('.user').text());
				if($(this).find('td:eq(2)').text()=='new'){
                	array = array.filter(function(x) { return $('#receptor').text().indexOf(x) < 0 });
                	document.title = 'FERREBOOM';
			    	clearInterval(interval);
    				socket.emit('user-message',{ 
						emisor:$('#name').text(),
						message:"visto",
						receptor:$('#receptor').text()
					});
		    		$(this).find('td:eq(2)').html('');
		    	}
            	chat(j);
	    	}
        });
		$('#chat').click(function(){
			if($("#area").hasClass("visible")){
				$('#chat').animate({right: '0px'},500);
				$('#area').animate({right: '-250px'},500);
	      		$("#area").removeClass("visible");
	      	}else{
	      		$('#chat').animate({right: '250px'},500);
	      		$('#area').animate({right: '0px'},500);
				$("#area").addClass("visible");
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
					$('#visto').empty();
					var d = new Date();
					datetext = d.toTimeString();
					datetext = datetext.split(' ')[0];
					$('#areachat').append("<div style='text-align:right;width:200px;margin-left:37px;margin-top:2px;cursor:pointer;'><div style='float:right;color:#6C6C6C;margin-top:5px;font-size:10px;width:5px' class='fin fin1'></div><div style='float:right;color:#6C6C6C;margin-top:5px;font-size:10px;width:5px' class='medio medio1'></div><div style='border:1px solid #B3CED9;font-size:12px;word-wrap:break-word;display:inline-block;background-color:#D9FDFF;padding: 5px 8px 4px;border-radius:5px;max-width:190px' title='"+datetext+"'>"+$('#input').val()+"</div></div>");
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
		var soundFx = $('#sound');
		var window_focus=false;
		var interval;
		$('#input').focus(function() {
			document.title = 'FERREBOOM';
		    clearInterval(interval);
		    window_focus = true;
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
			if(data.emisor==$('#receptor').text()){
				if(data.message=='visto'){
					$('#visto').empty().append("✔ Visto "+data.hora).show();
				}else if(data.message=='escribiendo'){
					$('#visto').empty();
					$('#escr').empty().append(data.emisor+" esta escribiendo...").show();
				}else if(data.message=='vacio'){
					$('#escr').empty(); 
				}else{
					socket.emit('user-message',{ 
						emisor:$('#name').text(),
						message:"fin",
						receptor:data.emisor
					});
					$('#visto').empty();
					$('#escr').empty(); 
					$('#areachat').append("<div style='margin-top:2px;width:200px;cursor:pointer;margin-left:5px'><div style='border:1px solid #B1B1B1;font-size:12px;word-wrap:break-word;display:inline-block;background-color:white;padding: 5px 8px 4px;border-radius: 5px;' title='"+data.hora+"'>"+data.message+"</div></div>"); 
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
						if(!$("#area").hasClass("visible")){
				      		$('#chat').animate({right: '250px'},500);
				      		$('#area').animate({right: '0px'},500);
							$("#area").addClass("visible");
				      	}
					}else{
						socket.emit('user-message',{ 
							emisor:$('#name').text(),
							message:"visto",
							receptor:$('#receptor').text()
						});
						count=0;
					}
					$('#scroll').scrollTop(1000000000000);
				}
			}else if(data.emisor==$('#name').text()){
				if(data.receptor==$('#receptor').text()){
					if(data.message=='medio'){
						$('.medio').html('&#10004');
						$('.medio1').removeClass('medio');
					}else{
						$('.fin').html('&#10004');
						$('.fin1').removeClass('fin');
					}
				}
			}else{
				if(data.message!='visto' && data.message!='vacio' && data.message!='escribiendo'){
					socket.emit('user-message',{ 
						emisor:$('#name').text(),
						message:"fin",
						receptor:data.emisor
					}); 
					$('#users tr td:contains("'+data.emisor+'")').next().html('<div style="padding: 0px 3px;border-radius: 3px 3px 3px 3px;background-color: rgb(240, 61, 37);font-size: 15px;font-weight: bold;color: #fff;cursor:pointer">new</div>');
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
					if(!$("#area").hasClass("visible")){
			      		$('#chat').animate({right: '250px'},500);
			      		$('#area').animate({right: '0px'},500);
						$("#area").addClass("visible");
			      	}
				}
			}
		});
		var topp;
		var loading=0;
		$('#scroll').scroll(function(){
		    if($('#scroll').scrollTop() <20){
		    	loading++;
		    	if(loading==1){
		            topp = $('#areachat').height();
			    	j++;
		            chat(j);
		        }
           }
		});
		$('#con').keyup(function(){
			if($('#con').val().length > 0){
				$('#users').empty().append($('<table>')); 
				$.ajax({
			      type: "POST",
			      url: "sistema/vendedor.php",
			      dataType: "json",
			      data:{b:$('#con').val()},
			      success: function(data){
			      	for(var i=0;i<data.length;i++){
						$('#users table').append('<tr style="color:white" class="fila"><td><div style="width: 8px;height: 8px;border-radius: 4px;background-color:#2d4b7c;"></div></td><td><div style="font-size:15px" class="user">'+data[i][0]+'</div><div style="font-size:10px">'+data[i][1]+'</div></td><td></td></tr>');
					}
			      }
			    });
			}else{
				socket.emit('con','');
			}
		});
		function chat(j){
			$.ajax({
              type: "POST",
              url: "sistema/chat.php",
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
		      				$('#areachat').prepend("<div style='text-align:right;width:200px;margin-left:37px;margin-top:2px;cursor:pointer;'><div style='float:right;color:#6C6C6C;margin-top:5px;font-size:10px;width:5px' class='fin fin1'></div><div style='float:right;color:#6C6C6C;margin-top:5px;font-size:10px;width:5px'>&#10004</div><div style='border:1px solid #B3CED9;font-size:12px;word-wrap:break-word;display:inline-block;background-color:#D9FDFF;padding: 5px 8px 4px;border-radius:5px;max-width:190px' title='"+data[i][4]+"'>"+data[i][2]+"</div></div>");
		      			}else{
		      				$('#areachat').prepend("<div style='text-align:right;width:200px;margin-left:37px;margin-top:2px;cursor:pointer;'><div style='float:right;color:#6C6C6C;margin-top:5px;font-size:10px;width:5px'>&#10004</div><div style='float:right;color:#6C6C6C;margin-top:5px;font-size:10px;width:5px'>&#10004</div><div style='border:1px solid #B3CED9;font-size:12px;word-wrap:break-word;display:inline-block;background-color:#D9FDFF;padding: 5px 8px 4px;border-radius:5px;max-width:190px' title='"+data[i][4]+"'>"+data[i][2]+"</div></div>");
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
		            $('#scroll').scrollTop(1000000000000);
              	}
              	if(data.length==30){
              		loading=0;
              	}
              }
        	});
		}
	});
