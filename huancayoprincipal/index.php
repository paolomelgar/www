<?php 
session_start();
if($_SESSION['valida']=='huancayoprincipal'){
?>
<html>
<head>
  <title>FERREBOOM</title>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <link rel="stylesheet" type="text/css" href="sistema/style/principal.css">
  <link type="text/css" href="jquery-ui-1.10.4.custom.min.css" rel="stylesheet" />
  <script type="text/javascript" src="jquery-1.11.1.min.js"></script>
  <script type="text/javascript" src="jquery-ui-1.10.4.custom.min.js"></script>  
  <script src="socket.io.js"></script>
  <script type="text/javascript">
    var socket=io.connect('http://ferreboomhuancayo.sytes.net:3500');
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
      var array;
      socket.on('id',function(data){ 
        socket.emit('usuario',{ 
          usuario:$('#name').text(),
          cargo:$('#cargo').text(),
          idd:data
        }); 
        $.ajax({
            type: "POST",
            url: "novisto.php",
            data:{usuario:$('#name').text()},
            dataType: "json",
            async: false,
            success: function(data){
              array=data;
              array = array.filter(function(x) { return $('#receptor').text().indexOf(x) < 0 });
              if(data.length>0 && $("#area").css('display')=='none'){
                for(var i=0;i<array.length;i++){
              socket.emit('user-message',{ 
                emisor:$('#name').text(),
                message:"fin",
                receptor:array[i]
              });   
            }
                $('#chat').animate({right: '250px'},500);
            $('#area').toggle("slide", { direction: "right" }, 500);
              }
            }
          });
      }); 
      
      socket.on('usuario',function(data){ 
        if($('#con').val().length == 0){
          var arr=array;
          $('#users').empty().append($('<table>')); 
          for(var i=0;i<data.length;i++){
            var mm=0;
            for(var j=i+1; j<data.length;j++){
              if(data[i][0]==data[j][0]){
                mm++;
              }
            }
            if(data[i][0]!=$('#name').text() && mm==0){
              var a;
              a = arr.filter(function(x) { return data[i][0].indexOf(x) < 0 });
              if(a.length==arr.length){
                $('#users table').append('<tr style="color:white" class="fila"><td><div style="width: 8px;height: 8px;border-radius: 4px;background-color:#58FA58;"></div></td><td><div style="font-size:15px" class="user">'+data[i][0]+'</div><div style="font-size:10px">'+data[i][1]+'</div></td><td></td></tr>');
              }else{
                $('#users table').append('<tr style="color:white" class="fila"><td><div style="width: 8px;height: 8px;border-radius: 4px;background-color:#58FA58;"></div></td><td><div style="font-size:15px" class="user">'+data[i][0]+'</div><div style="font-size:10px">'+data[i][1]+'</div></td><td><div style="padding: 0px 3px;border-radius: 3px 3px 3px 3px;background-color: rgb(240, 61, 37);font-size: 15px;font-weight: bold;color: #fff;cursor:pointer">new</div></td></tr>');
              }
              arr=a;
            }
          }
          for(var i=0;i<arr.length;i++){
            $('#users table').append('<tr style="color:white" class="fila"><td><div style="width: 8px;height: 8px;border-radius: 4px;background-color:#2d4b7c;"></div></td><td><div style="font-size:15px" class="user">'+array[i]+'</div><div style="font-size:10px">DESCONECTADO</div></td><td><div style="padding: 0px 3px;border-radius: 3px 3px 3px 3px;background-color: rgb(240, 61, 37);font-size: 15px;font-weight: bold;color: #fff;cursor:pointer">new</div></td></tr>');
          }
        }
        });
      var fecha;
        $('#users').on('click','.fila',function(){
        j=0;
        if($('#receptor').text()!=$(this).find('.user').text()){
          fecha=$.datepicker.formatDate('yy-mm-dd', new Date());
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
        if($("#area").is(":visible")){
          $('#chat').animate({right: '0px'},500);
            }else{
              $('#chat').animate({right: '250px'},500);
            }
        $('#area').toggle("slide", { direction: "right" }, 500);
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
              if($("#area").css('display')=='none'){
                $('#chat').animate({right: '250px'},500);
                $('#area').toggle("slide", { direction: "right" }, 500);
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
            $('#users table tr td:contains("'+data.emisor+'")').next().html('<div style="padding: 0px 3px;border-radius: 3px 3px 3px 3px;background-color: rgb(240, 61, 37);font-size: 15px;font-weight: bold;color: #fff;cursor:pointer">new</div>');
            array.push(data.emisor);
            count++;
            soundFx[0].play();
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
            if($("#area").css('display')=='none'){
              $('#chat').animate({right: '250px'},500);
              $('#area').toggle("slide", { direction: "right" }, 500);
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
              url: "vendedor.php",
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
                url: "chat.php",
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
  </script>
  <style type="text/css">
    .ui-tooltip{
        background: #262626;
        color:white;
        border:2px solid #262626;
    }
    .selected {
        cursor: pointer;
        background: #09F;
    }
    .select {
        color: #F63 !important;
        font-weight: bold;
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
    .fila:hover{
        color:yellow !important;
        cursor: pointer;
        font-weight: bold;
    }
  </style>
</head>
<body>
  <audio id="sound"><source src="notify.wav"></source></audio>
  <div id='name' style='display:none'><?php echo $_SESSION['nombre']; ?></div>
  <div id='cargo' style='display:none'><?php echo $_SESSION['cargo']; ?></div>
  <div style='position:absolute;bottom:0px;right:0px;cursor:pointer' id='chat'>
    <img src='chat.png' width='30px'>
  </div>
  <div style='position:absolute;bottom:0px;right:0px;width:250px;height:600px;display:none;' id='area'>
    <table width='100%' style='border-collapse:collapse;border:1px solid black;background-image: url("http://img3.todoiphone.net/wp-content/uploads/2014/03/WhatsApp-Wallpaper-39.jpg");'>
      <tr><td style='height:200px;background-color:#2d4b7c;'><div id='users' style='height:200px;overflow-y:scroll;color:white'></div></td></tr>
      <tr><td width='100%' style='padding:2px;height:30px;background-color:#2d4b7c;'><input style='width:100%;height:26px' type='text' id='con' placeholder='Buscar...'></td></tr>
      <tr><td width='100%' style='background-color:black;color:white;height:23px;'><div id='receptor'>Selecciona a alguien para Chatear</div></td></tr>
      <tr><td width='100%' style='height:300px;'>
        <div style='overflow-y:scroll;height:300px;padding:0px' id='scroll'>
          <table style='border-collapse:collapse'>
            <tr>
              <td id='areachat' valign='bottom' width='250px' height='300px'>
              </td>
            </tr>
          </table>
        </div>
      </td></tr>
      <tr>
        <td width='100%' style='height:15px;'>
          <div id='escr' style='margin-top:0px;color:#6C6C6C;float:left;font-size:11px'></div>
          <div id='visto' style='color:#6C6C6C;text-align:right;float:right;font-size:11px;display:none;margin-right:10px'></div>
        </td>
      </tr>
      <tr><td width='100%' style='padding:2px;height:30px;'><input style='width:100%;height:26px' type='text' id='input' readonly='readonly' placeholder='Escribe un Mensaje...'></td></tr>
    </table>
  </div>
  <table width="100%" height="100%" border="0" style='border-collapse: collapse;'>
    <tr>
        <th style='background-color: #2d4b7c;' height='25px'>
          <input type='checkbox' id='btn-menu'>
          <label for='btn-menu' align='left'><img src='ventasfuera/menu-icon.png'></label>
          <nav class="menu">
        <?php
        switch ($_SESSION['cargo']) {
          case 'ADMIN':
            ?>
            <ul>
              <li style="background-color: #FFF105;"><a href="" >ADMINISTRACION</a>
                  <ul>
                  <li><a href="proveedor/" target="contenedor">PROVEEDORES</a></li>
                  <li><a href="cliente/" target="contenedor">CLIENTES</a></li>
                  <li><a href="transportista/" target="contenedor">TRANSPORTISTAS</a></li>
                  <li><a href="usuario/" target="contenedor">USUARIOS</a></li>
                  <li><a href="producto/" target="contenedor">PRODUCTOS</a></li>
                  <li><a href="marca/" target="contenedor">MARCAS</a></li>
                  <li><a href="familia/" target="contenedor">FAMILIAS</a></li>
                  <li><a href="ubicacion/" target="contenedor">UBICACION</a></li>
                  <li><a href="query/" target="contenedor">CONSULTAS</a></li>
                  <li><a href="http://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/frameCriterioBusqueda.jsp" target="_blank">RUC</a></li>
                </ul>
              </li>
            </ul>
            <ul>
              <li><a href="" >COMPRAS</a>
                  <ul>
                  <li><a href="compras/" target="_blank">COMPRAS</a></li>
                  <li><a href="calendario/" target="contenedor">CRONOGRAMA PAGOS</a></li>
                  <li><a href="maps/" target="contenedor">GOOGLE MAPS</a></li>
                </ul>
              </li>
            </ul>
            <ul>
              <li><a href="" >VENTAS</a>
                  <ul>
                  <li><a href="caja/" target="_blank">CAJA TIENDA</a></li>
                  <li><a href="ventas/" target="_blank">VENTA TIENDA</a></li>
                  <li><a href="calendariocliente/" target="contenedor">CRONOGRAMA COBROS</a></li>
                  <li><a href="ganancias/" target="contenedor">GANANCIA POR VENTA</a></li>
                  <li><a href="malogrados/" target="contenedor">REPORTE MALOGRADOS</a></li>
                </ul>
              </li>
            </ul>
            <ul>
              <li><a href="" >TESORERIA</a>
                  <ul>
                  <li><a href="cajadeldia/" target="contenedor">CAJA DEL DIA</a></li>
                  <li><a href="cajamayor/" target="contenedor">CAJA MAYOR</a></li>
                  <li><a href="cobranzas/" target="contenedor">COBRO CLIENTES</a></li>
                  <li><a href="pagoproveedor/" target="contenedor">PAGO PROVEEDORES</a></li>
                  <li><a href="prestamos/" target="contenedor">PAGO PRESTAMOS</a></li>
                  <li><a href="egresos/" target="contenedor">INGRESO/EGRESO</a></li>
                  <li><a href="balancemensual/" target="contenedor">BALANCE MENSUAL</a></li>
                </ul>
              </li>
            </ul>
            <ul>
              <li><a href="" >ESTADISTICAS</a>
                  <ul>
                  <li><a href="kardex_cliente/" target="contenedor">REPORTE CLIENTES</a></li>
                  <li><a href="kardex_proveedor/" target="contenedor">REPORTE PROVEEDORES</a></li>
                </ul>
              </li>
            </ul>
            <ul>
              <li><a href="sistema/salir.php" >SALIR</a></li>
            </ul>
            <?php
          break;
          case 'ASISTENTE':
            ?>
            <ul>
              <li style="background-color: #FFF105;"><a href="" >ADMINISTRACION</a>
                  <ul>
                  <li><a href="cliente/" target="contenedor">CLIENTES</a></li>
                  <li><a href="transportista/" target="contenedor">TRANSPORTISTAS</a></li>
                  <li><a href="producto/" target="contenedor">PRODUCTOS</a></li>
                  <li><a href="ubicacion/" target="contenedor">UBICACION</a></li>
                  <li><a href="http://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/frameCriterioBusqueda.jsp" target="_blank">RUC</a></li>
                </ul>
              </li>
            </ul>
            <ul>
              <li><a href="" >COMPRAS</a>
                  <ul>
                  <li><a href="calendario/" target="contenedor">CRONOGRAMA PAGOS</a></li>
                </ul>
              </li>
            </ul>
            <ul>
              <li><a href="" >VENTAS</a>
                  <ul>
                  <li><a href="caja/" target="_blank">CAJA TIENDA</a></li>
                  <li><a href="calendariocliente/" target="contenedor">CRONOGRAMA COBROS</a></li>
                </ul>
              </li>
            </ul>
            <ul>
              <li><a href="" >TESORERIA</a>
                  <ul>
                  <li><a href="cajamayor/" target="contenedor">CAJA MAYOR</a></li>
                  <li><a href="cobranzas/" target="contenedor">COBRO CLIENTES</a></li>
                  <li><a href="egresos/" target="contenedor">INGRESO/EGRESO</a></li>
                  <li><a href="balancemensual/" target="contenedor">BALANCE MENSUAL</a></li>
                </ul>
              </li>
            </ul>
            <ul>
              <li><a href="" >ESTADISTICAS</a>
                  <ul>
                  <li><a href="kardex_cliente/" target="contenedor">REPORTE CLIENTES</a></li>
                  <li><a href="kardex_proveedor/" target="contenedor">REPORTE PROVEEDORES</a></li>
                </ul>
              </li>
            </ul>
            <ul>
              <li><a href="sistema/salir.php" >SALIR</a></li>
            </ul>
            <?php
          break;
          case 'LOGISTICA':
            ?>
            <ul>
              <li style="background-color: #FFF105;"><a href="" >ADMINISTRACION</a>
                  <ul>
                  <li><a href="proveedor/" target="contenedor">PROVEEDORES</a></li>
                  <li><a href="cliente/" target="contenedor">CLIENTES</a></li>
                  <li><a href="transportista/" target="contenedor">TRANSPORTISTAS</a></li>
                  <li><a href="producto/" target="contenedor">PRODUCTOS</a></li>
                  <li><a href="marca/" target="contenedor">MARCAS</a></li>
                  <li><a href="familia/" target="contenedor">FAMILIAS</a></li>
                  <li><a href="ubicacion/" target="contenedor">UBICACION</a></li>
                  <li><a href="http://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/frameCriterioBusqueda.jsp" target="_blank">RUC</a></li>
                </ul>
              </li>
            </ul>
            <ul>
              <li><a href="" >COMPRAS</a>
                  <ul>
                  <li><a href="compras/" target="_blank">COMPRAS</a></li>
                  <li><a href="calendario/" target="contenedor">CRONOGRAMA PAGOS</a></li>
                  <li><a href="maps/" target="contenedor">GOOGLE MAPS</a></li>
                </ul>
              </li>
            </ul>
            <ul>
              <li><a href="" >VENTAS</a>
                  <ul>
                  <li><a href="caja/" target="_blank">CAJA TIENDA</a></li>
                  <li><a href="calendariocliente/" target="contenedor">CRONOGRAMA COBROS</a></li>
                  <li><a href="malogrados/" target="contenedor">REPORTE MALOGRADOS</a></li>
                </ul>
              </li>
            </ul>
            <ul>
              <li><a href="" >TESORERIA</a>
                  <ul>
                  <li><a href="cobranzas/" target="contenedor">COBRO CLIENTES</a></li>
                  <li><a href="pagoproveedor/" target="contenedor">PAGO PROVEEDORES</a></li>
                  <li><a href="egresos/" target="contenedor">INGRESO/EGRESO</a></li>
                  <li><a href="balancemensual/" target="contenedor">BALANCE MENSUAL</a></li>
                </ul>
              </li>
            </ul>
            <ul>
              <li><a href="" >ESTADISTICAS</a>
                  <ul>
                  <li><a href="kardex_cliente/" target="contenedor">REPORTE CLIENTES</a></li>
                  <li><a href="kardex_proveedor/" target="contenedor">REPORTE PROVEEDORES</a></li>
                </ul>
              </li>
            </ul>
            <ul>
              <li><a href="sistema/salir.php" >SALIR</a></li>
            </ul>
            <?php
          break;
          case 'PROMOTOR':
            ?>
            <ul>
              <li><a href="maps/" target="contenedor">GOOGLE MAPS</a></li>
            </ul>
            <ul>
              <li><a href="#" target="contenedor"></a></li>
            </ul>
            <ul>
              <li><a href="ventas/" target="contenedor">VENTAS</a></li>
            </ul>
            <ul>
              <li><a href="cobranzas/" target="contenedor">DEUDA CLIENTES</a></li>
            </ul>
            <ul>
              <li><a href="recordpromotor/" target="contenedor">RECORD MENSUAL</a></li>
            </ul>
            <ul>
              <li><a href="sistema/salir.php" >SALIR</a></li>
            </ul>
            <?php
          break;
        }
        ?>
        </nav>
      </th>
      </tr>
      <tr height='100%'>
        <th align="center">
            <iframe name="contenedor" src="inicio.html" style='border: none;top: 0; right: 0;bottom: 0; left: 0;width: 100%;height: 100%;'>
        </th>
    </tr>
  </table>
  
</body>
<html>
<?php }else{
  header("Location: ../");
} ?>