var socket=io.connect('http://ferreboomhuancayo.sytes.net:3500');
$(function(){
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
  $('#fecha').datepicker({
    firstDay:1,
    dateFormat:'dd/mm/yy',
    monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'],
    changeMonth: true,
    changeYear: true,
    dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa']
  }).datepicker("setDate", date);
  $('#fechapago').datepicker({
    firstDay:1,
    dateFormat:'dd/mm/yy',
    monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'],
    changeMonth: true,
    changeYear: true,
    dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa']
  });
  $("#busqueda").focus();
  var fech=$('#fecha').val();
  $('#fechapago').change(function(){
    $('#fechapago').removeClass('mayorstock');
  });
  $("input:text").focus(function(){
    $(this).select(); 
  }).click(function(){ 
    $(this).select(); 
  });
  $("input").keyup(function(){
    var start = this.selectionStart,
        end = this.selectionEnd;
    $(this).val( $(this).val().toUpperCase() );
    this.setSelectionRange(start, end);
  });
  $("textarea").keyup(function(){
    var start = this.selectionStart,
        end = this.selectionEnd;
    $(this).val( $(this).val().toUpperCase() );
    this.setSelectionRange(start, end);
  });
  $(document).tooltip({
    position: {
            my: "left top",
            at: "right+2 ",
        },
      content: function() {
        return $(this).html();
      }
  });
  $('body').click(function(){
    $('#resultruc').hide();
    $('#result').hide();
  });
  var fech=$('#fecha').val();
  $('#ventas').tableFilter({
    filteredRows: function(filterStates) {
      var sumatotal  = 0;
      $('#verbody tr').filter(":visible").each(function(){
        sumatotal =  parseFloat(sumatotal) +  parseFloat($(this).find("td:eq(8)").text().slice(3));        
      });
      $('#sumatotal').text("S/ "+sumatotal.toFixed(2)); 
    },
    enableCookies: false
  });
  var serieventa=0;
  var seriepedido=0;
  var credito;
  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  var typingTimer;
  function ruc(consulta,e){
    if(e.which!=13 && e.which<37 || e.which>40){
      clearTimeout(typingTimer);
      typingTimer = setTimeout(function(){  
      $.ajax({
        type: "POST",
        url: "cliente.php",
        data: {b:consulta},
        cache: false,
        success: function(data){
          if(consulta!=''){
            $("#tb").empty();
            $("#tb").append(data);
            if($('#tb >tr').length =="0"){
              $("#sunat").show();
              $("#resultruc").hide();
            }else{
              $('#resultruc').show();
            }
          }else{
            $("#resultruc").hide();
          }
          $('#tb> tr:even').addClass('par');
          $('#tb> tr:odd').addClass('impar');
          $("#tb> tr").hover(
            function () {
              $('#tb> tr').removeClass('selected');
              $(this).addClass('selected');
              x=$(this).index();
            }, 
            function () {
              $(this).removeClass('selected');
            }
          );
          $('#tb tr').click(function(){
            $('#ruc').val($('#tb>tr:eq('+x+')').find('td:eq(0)').text());
            $('#razon_social').val($('#tb>tr:eq('+x+')').find('td:eq(1)').text());
            $('#direccion').val($('#tb>tr:eq('+x+')').find('td:eq(2)').text());
            credito=$('#tb>tr:eq('+x+')').find('td:eq(3)').text();
            $("#busqueda").focus();
            $('#limitecredito').empty();
            $('#limitecredito').append("<p align='center'>LIMITE DE CREDITO:</p><p align='center'>S/ "+credito+"</p>");
            $('#limitecredito').show();
          });
        }
      });
  }, 400);
      x=-1;
    }else if (e.which==38) {
      if(x>=0){
        x=x-1;
        $('#tb> tr').removeClass('selected');
        $('#tb> tr:eq(' + x + ')').addClass('selected');
      }
      else {
        x=x+$('#tb >tr').length;
        $('#tb> tr').removeClass('selected');
        $('#tb> tr:eq(' + x + ')').addClass('selected');
      }
    }else if (e.which==40) {
      if (x<$('#tb >tr').length-1) {
        x++;
        $('#tb> tr').removeClass('selected');
        $('#tb> tr:eq(' + x + ')').addClass('selected');
      }
      else{
        x=x-$('#tb >tr').length+1;
        $('#tb> tr').removeClass('selected');
        $('#tb> tr:eq(' + x + ')').addClass('selected');
      }
    }else if (e.which==13) {
      $('#tb tr').click();
    }
  }
  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  
  $("#ruc").keyup(function(e){
    ruc($('#ruc').val(),e);
  }); 
  $("#razon_social").keyup(function(e){
    ruc($('#razon_social').val(),e);
  }); 
  $('.ruc').click(function(){
    var top=parseInt($(this).position().top)+30;
    var left=parseInt($(this).position().left);
    $("#resultruc").css({"top":""+top+"px", "left":""+left+"px"});
  });

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
var stock,compra,promotor,unit;
  function producto(consulta,e,result){
    if(e.which!=13 && e.which<37 || e.which>40){
      clearTimeout(typingTimer);
      typingTimer = setTimeout(function(){  
      $.ajax({
        type: "POST",
        url: "producto.php",
        data: {b:consulta,
               doc:$('#documento').val()},
        cache: false,
        success: function(data){
          if(consulta!=''){
            $("#tb1").empty();
            $("#tb1").append(data);
            if($('#tb1 >tr').length =="0"){
              $("#result").hide();
            }else{
              $('#result').show();
            }
          }else{
            $("#result").hide();
          }
          $('#tb1> tr:even').addClass('par');
          $('#tb1> tr:odd').addClass('impar');
          $("#tb1> tr").hover(
            function () {
              $('#tb1> tr').removeClass('selected');
              $(this).addClass('selected');
              x=$(this).index();
            }, 
            function () {
              $(this).removeClass('selected');
            }
          );
          $('#tb1 tr').click(function(){
            var id=$('#tb1>tr:eq('+x+')').find('td:eq(1)').text();
            var producto=$('#tb1>tr:eq('+x+')').find('td:eq(2)').text()+" "+$('#tb1>tr:eq('+x+')').find('td:eq(3)').text();
            compra=parseFloat($('#tb1>tr:eq('+x+')').find('td:eq(4)').text());
            stock=parseFloat($('#tb1>tr:eq('+x+')').find('td:eq(6)').text());
            promotor=parseFloat($('#tb1>tr:eq('+x+')').find('td:eq(8)').text()).toFixed(2);
            unit=parseFloat($('#tb1>tr:eq('+x+')').find('td:eq(8)').text()).toFixed(2);
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
}, 400);
      x=-1;
    }else if (e.which==38) {
      if(x>=0){
        x=x-1;
        $('#tb1> tr').removeClass('selected');
        $('#tb1> tr:eq(' + x + ')').addClass('selected');
      }
      else {
        x=x+$('#tb1 >tr').length;
        $('#tb1> tr').removeClass('selected');
        $('#tb1> tr:eq(' + x + ')').addClass('selected');
      }
    }else if (e.which==40) {
      if (x<$('#tb1 >tr').length-1) {
        x++;
        $('#tb1> tr').removeClass('selected');
        $('#tb1> tr:eq(' + x + ')').addClass('selected');
      }
      else{
        x=x-$('#tb1 >tr').length+1;
        $('#tb1> tr').removeClass('selected');
        $('#tb1> tr:eq(' + x + ')').addClass('selected');
      }
    }else if (e.which==13) {
      if ($("#busqueda"+result).val() !=0 && x>=0) {
        $('#tb1 tr').click();
      }
      else{
        $("#busqueda"+result).focus();
        $("#result"+result).hide();
      }
    }
  }
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  $("#busqueda").keyup(function(e){
    $("#result").appendTo("#form");
    var top=parseInt($(this).position().top)+30;
    var left=parseInt($(this).position().left);
    $("#result").css({"top":""+top+"px", "left":""+left+"px"});
    producto($('#busqueda').val(),e,"");
  }); 

  $('#cantidad').keyup(function(e){
    var v=parseFloat($('#cantidad').val());
    if(v>stock){
      $('#stock').show();
      $('#cantidad').addClass('mayorstock');
    }
    else{
      $('#stock').hide();
      $('#cantidad').removeClass('mayorstock');
    }
    $('#importe').val(parseFloat($("#precio_u").val()*$("#cantidad").val()).toFixed(2));
    if(e.which == 13) {
      $("#precio_u").focus();
    }
  });
  $('#precio_u').keyup(function(e){
    unit=parseFloat($('#precio_u').val());
    $("#importe").val(parseFloat($("#precio_u").val()*$("#cantidad").val()).toFixed(2));
    $(this).blur(function(){
      if(unit>=promotor && unit>=compra){
        $('#precio_u').val(unit);
        $('#precio_u').removeClass('mayorstock');
      }
      else if (unit<promotor && unit>=compra) {
        $('#precio_u').val(unit);
        $('#precio_u').addClass('mayorstock');
      }
      else{
        $('#precio_u').val(compra);
        $('#precio_u').addClass('mayorstock');
      }
      $("#importe").val(parseFloat($("#precio_u").val()*$("#cantidad").val()).toFixed(2));
    });
    if(e.which == 13) {
      $("#importe").focus();
    }
  });
  $('#importe').keyup(function(e){
    $("#precio_u").val(parseFloat($("#importe").val()/$("#cantidad").val()).toFixed(2));
    var unit=parseFloat($('#precio_u').val());
    if(unit>=promotor && unit>=compra){
        $('#precio_u').removeClass('mayorstock');
        $('#precio_u').val(unit);
      }
      else if (unit<promotor && unit>=compra) {
        $('#precio_u').addClass('mayorstock');
        $('#precio_u').val(unit);
      }
      else{
        $('#precio_u').val(compra);
        $('#precio_u').addClass('mayorstock');
      }
    if(e.which == 13) {
      if(unit<compra){
        $("#importe").val(parseFloat($("#precio_u").val()*$("#cantidad").val()).toFixed(2));
      }
      if($('#id').val()>0){
        var next= "<tr class='fila'>\n" +
                  "<td width='2%' style='padding:0px;' title='s'><img src='https://raw.githubusercontent.com/paolomelgar/www/master/huancayoprincipal/fotos/producto/a"+$("#id").val()+".jpg?timestamp=23124' width='100%' height='100%' class='img'></td>\n"+
                  "<td width='68%' class='produ'>" + $("#busqueda").val() + "</td>\n";
        if($('#cantidad').hasClass('mayorstock')){
          next += "<td width='10%' contenteditable='true' class='editme1 mayorstock' style='text-align:right'>" + $("#cantidad").val() + "</td>\n";
        }else{
          next += "<td width='10%' contenteditable='true' class='editme1' style='text-align:right'>" + $("#cantidad").val() + "</td>\n";
        }if(parseFloat($('#precio_u').val())>=promotor){
          next += "<td width='10%' contenteditable='true' class='editme2' style='text-align:right'>" + parseFloat($("#precio_u").val()).toFixed(2) + "</td>\n";
        }else{
          next += "<td width='10%' contenteditable='true' class='editme2 mayorstock' style='text-align:right'>" + parseFloat($("#precio_u").val()).toFixed(2) + "</td>\n";
        }
          next += "<td width='10%' style='text-align:right'>" + parseFloat($("#importe").val()).toFixed(2) + "</td>\n" +
                  "<td style='display:none'>" + $("#id").val() +"</td>\n" +
                  "<td style='display:none'>" + $("#compra").val() +"</td>\n" +
                  "<td style='display:none'>" + $("#promotor").val() +"</td>\n" +
                  "<td style='display:none'>" + $("#stock").text() +"</td>\n" +
                  "</tr>";
        $('#cantidad').removeClass('mayorstock');
        $('#precio_u').removeClass('mayorstock');
        $('#row').append(next);
        $('#subtotal').val(parseFloat(suma()).toFixed(2));
        $('#total').val(parseFloat(parseFloat($('#subtotal').val())-parseFloat($('#subtotal_devol').val())).toFixed(2));
        $('#roww').scrollTop(1000000);
        $('#cantprod').empty();
        $('#cantprod').append($('#row tr').length+" Productos");
        $('#busqueda').val("");
        $('#cantidad').val("");
        $('#precio_u').val("");
        $('#importe').val("");
        $('#id').val("");
        $('#compra').val("");
        $('#promotor').val("");
        $('#stock').hide();
        $("#busqueda").focus();
      }
      else{
        $('#busqueda').focus();
      }
    }
  });

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  function suma(){
    var z=0;
    $('#row tr').each(function () {
      z+=parseFloat($(this).find('td:eq(4)').text()); 
    });
    return z;
  }
  function suma1(){
    var z=0;
    $('#row1 tr').each(function () {
      z+=parseFloat($(this).find('td:eq(4)').text()); 
    });
    return z;
  }
  function anterior(cliente,id){
    if(cliente!=''){
      $.ajax({
        type: "POST",
        url: "buscaranterior.php",
        data: {cliente:cliente,
               id:id},
        beforeSend:function(){
          $('#anterior').show();
          $('#ant').empty();
          $('#ant').append("<table width='100%'><tr><td align='center'><img src='../loading.gif' width='90px'></td></tr></table>");
        },
        success: function(data){
          $('#ant').empty();
          $('#ant').append(data);
        }
      });
    }else{
      $('#anterior').hide();
    }
  } 
  function imprimir(serie,comprobante){
    $('#dx').empty();
    $.ajax({
      type: "POST",
      url: "vercomprobantes.php",
      dataType: "json",
      data: 'serie='+serie+'&com='+comprobante,
      success: function(data){
        var v1=0;
        var contenid;
        var x1 = screen.width/2 - 1200/2;
        var y1 = screen.height/2 - 700/2;
        var w=window.open('','',"width=1200,height=600,left="+x1+",top="+y1);
        switch(comprobante){
          case 'BOLETA DE VENTA':
            $('#dx').append("<table width='50%' style='margin-top:0px;font:0.9em arial;'><tr><td width='7%'>&nbsp</td><td width='93%'>"+data[1][12]+"</td></tr></table>\n"+
              "<table width='50%' style='margin-top:-3px;font:0.9em arial;'><tr><td width='7%'>&nbsp</td><td width='93%'>"+data[1][1]+"</td></tr></table>\n"+
              "<table width='50%' style='margin-top:-3px;font:0.9em arial;'><tr><td width='10%'>&nbsp</td><td width='90%'>"+data[1][2]+"</td></tr></table>\n"+
              "<table width='50%' style='margin-bottom:5px;margin-top:-5px'><tr><td width='5%' align='center'>&nbsp</td><td width='75%' align='center'></td><td width='10%' align='center'></td><td width='10%' align='center'></td></tr></table>\n"
            );
            for (var i=0;i<data[0].length;i++) {
              $('#dx').append("<table width='50%' style='margin-top:-8px;font:0.9em arial;font-weight:bold'><tr height='37px'><td width='5%' align='right'>"+data[0][i][1]+"&nbsp&nbsp&nbsp</td><td width='65%' style='line-height:15px'>"+data[0][i][0]+"</td><td width='8%' align='right'>"+data[0][i][2]+"</td><td width='22%' align='right'>"+data[0][i][3]+"</td></tr></table>");
            }
            while(v1<11-parseInt(data[0].length)){
              $('#dx').append("<table width='50%' style='margin-top:-8px'><tr height='37px'><td>&nbsp</td></tr></table>");
              v1++;
            }
            $('#dx').append("<table width='50%' style='font:0.9em arial;font-weight:bold;margin-top:10px'><tr><td width='90%' align='right'>&nbsp</td><td align='right' width='10%'>"+data[1][3]+"</td></tr></table></div>");contenid = document.getElementById("dx");
            w.document.write("<html><head><style type='text/css'>@page{size:A4 portrait;}@media print {html,body {width: 320mm;height: 150mm;margin-top:47px;margin-left:0px}}</style></head><body>"+contenid.innerHTML+"</body></html>");
          break;
          ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
          case 'FACTURA ELECTRONICA INNOVA':
              $('#dx').append("<div align='center'><img id='theImg' src='../logo_innova.png' style='width:300px;height:80px;'></div>\n"+
              "<table width='80%' align='center' style='font:0.7em Verdana;margin-top:1px;'><tr><td width='100%' align='center'>GRUPO FERRETERO INNOVA S.R.L.</td></tr></table>\n"+
              "<table width='80%' align='center' style='font:0.7em Verdana;margin-top:-7px;'><tr><td width='100%' align='center'>AV. MARISCAL CASTILLA 1704 JUNIN - HUANCAYO - EL TAMBO</td></tr></table>\n"+
              "<table width='80%' align='center' style='font:0.7em Verdana;margin-top:-7px;'><tr><td width='100%' align='center'>20601765641</td></tr></table>\n"+
              "<table width='80%' align='center' style='font:0.7em Verdana;margin-top:-7px;'><tr><td width='100%' align='center'>FACTURA ELECTRONICA: F003-"+data[1][13]+"</td></tr></table>\n"+
              "<table width='80%' align='center' style='font:0.8em Verdana;margin-top:-5px;'><tr><td width='10%'>FECHA: "+data[1][12]+"</td></tr></table>\n"+
              "<table width='80%' align='center' style='margin-top:-5px;font:0.8em Verdana;'><tr><td width='100%'>RUC: "+data[1][0]+"</td></tr></table>\n"+
              "<table width='80%' align='center' style='margin-top:-5px;font:0.8em Verdana;'><tr><td width='100%'>CLIENTE: "+data[1][1]+"</td></tr></table>\n"+
              "<table width='80%' align='center' style='margin-top:-5px;font:0.8em Verdana;'><tr><td width='100%'>DIRECCION: "+data[1][2]+"</td></tr></table>\n"+
              "<table width='80%' align='center' style='margin-top:0px;font:0.7em Verdana;margin-bottom:3px'><tr style='background-color:black;color:white;'><td width='3%' align='center'>CAN</td><td width='75%' align='center'>PRODUCTO</td><td width='10%' align='center'>P.UNIT</td><td width='12%' align='center'>IMPORTE</td></tr></table>\n"
            );
            for (var i=0;i<data[0].length;i++) {
              $('#dx').append("<table width='80%' align='center' style='margin-top:-6px;font:0.7em Verdana'><tr><td width='3%' align='right'>"+data[0][i][1]+"</td><td width='3%'></td><td width='72%'>"+data[0][i][0]+"</td><td width='10%' align='right'>"+data[0][i][2]+"</td><td width='12%' align='right'>"+data[0][i][3]+"</td></tr></table>");
            }

            var subigv2=parseFloat(data[1][3]/1.18).toFixed(2);
            var igv2=parseFloat(data[1][3]-subigv2).toFixed(2);


            $('#dx').append("<table width='80%' align='center' style='font:0.8em Verdana;margin-top:-6px;'><tr><td align='right' width='100%'>OP. GRAVADAS: S/ "+subigv2+"</td></tr></table></div>");
            $('#dx').append("<table width='80%' align='center' style='font:0.8em Verdana;margin-top:-6px;'><tr><td align='right' width='100%'>IGV: S/ "+igv2+"</td></tr></table></div>");
            $('#dx').append("<table width='80%' align='center' style='font:0.8em Verdana;margin-top:-6px;'><tr><td align='right' width='100%'>TOTAL: S/ "+data[1][3]+"</td></tr></table></div>");
            $('#dx').append("<table width='80%' align='center' style='font:0.8em Verdana;margin-top:-6px;'><tr><td width='100%'>SON: <span id=let></span></td></tr></table></div>");
            $('#dx').append("<table width='80%' align='center'><tr><td align='center'><div id='qrcodeTable'></td></tr></table>");
            $('#dx').append("<table width='80%' align='center' style='font:0.8em Verdana;margin-top:-6px;'><tr><td width='100%' align='center'>GRACIAS POR SU PREFERENCIA</td></tr></table></div>");
            $('#dx').append("<table width='80%' align='center' style='font:0.8em Verdana;margin-top:-6px;'><tr><td width='100%' align='center'>Para consultar el documento ingrese en www.innova.grupoferretero.com</td></tr></table></div>");
            jQuery('#qrcodeTable').qrcode({
              render  : "table",
              text  : "http://ferreboom.com:2000",
              width: 64,
              height: 64
            });
            $.ajax({
              type: "POST",
              url: "numerosaletras.php",
              async: false,
              data: 'b='+data[1][3],
              success: function(data){
                $('#let').append(data);
              }
            });
            contenid = document.getElementById("dx");
            w.document.write("<html><head><style type='text/css'>@page{size:A4 portrait;}</style></head><body>"+contenid.innerHTML+"</body></html>");
          break;
          ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
          case 'FACTURA BOOM':
            $('#dx').append("<table width='100%' style='margin-top:145px;font:0.8em arial;'><tr><td width='6%'>&nbsp</td><td width='6%'>"+data[1][12].slice(0,2)+"</td><td width='10%'>"+data[1][12].slice(3,5)+"</td><td width='78%'>"+data[1][12].slice(6,10)+"</td></tr></table>\n"+
              "<table width='100%' style='margin-top:9px;font:0.8em arial;'><tr><td width='70%'>"+data[1][1]+"</td><td width='30%'>"+data[1][0]+"</td></tr></table>\n"+
              "<table width='100%' style='margin-top:12px;font:0.7em arial;'><tr><td width='80%'>"+data[1][2]+"</td><td width='20%' style='font-weight:bold'>Cond. Pago: "+data[1][9]+"</td></tr></table>\n"+
              "<table width='100%' style='margin-bottom:2px;margin-top:0px'><tr><td width='5%' align='center'>&nbsp</td><td width='75%' align='center'>&nbsp</td><td width='10%' align='center'>&nbsp</td><td width='10%' align='center'>&nbsp</td></tr></table>\n"
            );
            for (var i=0;i<data[0].length;i++) {
              $('#dx').append("<table width='100%' style='margin-top:-5px;font:0.7em arial'><tr height='22px'><td width='6%' align='right'>"+data[0][i][1]+"</td><td <td width='3%'></td><td width='61%'>"+data[0][i][0]+"</td><td width='12%' align='right'>"+data[0][i][2]+"</td><td width='18%' align='right'>"+data[0][i][3]+"</td></tr></table>");
            }
            while(v1<33-parseInt(data[0].length)){
              $('#dx').append("<table width='100%' style='margin-top:-5px'><tr height='22px'><td>&nbsp</td></tr></table>");
              v1++;
            }
            var subigv1=parseFloat(data[1][3]/1.18).toFixed(2);
            var igv1=parseFloat(data[1][3]-subigv1).toFixed(2);
            $("#dx").append("<table width='100%' style='font:0.8em arial;margin-top:18px;'><tr><td width='6%'>&nbsp</td><td width='74%' id='let'></td><td width='10%'>&nbsp</td><td align='right' width='10%'>"+subigv1+"</td></tr></table>\n"+
              "<table width='100%' style='margin-top:6px;font:0.8em arial;'><tr><td width='90%'></td><td align='right' width='10%'>"+igv1+"</td></tr></table>\n"+
              "<table width='100%' style='margin-top:6px;font:0.8em arial;'><tr><td width='90%'></td><td align='right' width='10%'>"+data[1][3]+"</td></tr></table>");
            $.ajax({
              type: "POST",
              url: "numerosaletras.php",
              async: false,
              data: 'b='+data[1][3],
              success: function(data){
                $('#let').append(data);
              }
            });
            contenid = document.getElementById("dx");
            w.document.write("<html><head><style type='text/css'>@page{size:A4 portrait;}</style></head><body>"+contenid.innerHTML+"</body></html>");
          break;
          ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
          case 'FACTURA ELECTRONICA BOOM':
            $('#dx').append("<div align='center'><img id='theImg' src='../logo_ferreboom.jpg' style='width:300px;height:80px;'></div>\n"+
              "<table width='80%' align='center' style='font:0.7em Verdana;margin-top:-7px;'><tr><td width='100%' align='center'>RUC: 20600996968</td></tr></table>\n"+
              "<table width='80%' align='center' style='font:0.7em Verdana;margin-top:1px;'><tr><td width='100%' align='center'>DISTRIBUIDORA DE HERRAMIENTAS Y ACCESORIOS FERREBOOM S.A.C.</td></tr></table>\n"+
              "<table width='80%' align='center' style='font:0.7em Verdana;margin-top:-7px;'><tr><td width='100%' align='center'>JR. YAPURA N° 163 URB. CHACRA COLORADA - LIMA - LIMA - BREÑA</td></tr></table>\n"+
              "<table width='80%' align='center' style='font:0.7em Verdana;margin-top:-7px;'><tr><td width='100%' align='center'>CEL: 948394809 - 975380302 - FIJO:(064)228334</td></tr></table>\n"+
              "<table width='80%' align='center' style='font:0.7em Verdana;margin-top:-7px;'><tr><td width='100%' align='center'>FACTURA ELECTRONICA: F001-"+data[1][13]+"</td></tr></table>\n"+
              "<table width='80%' align='center' style='font:0.8em Verdana;margin-top:-5px;'><tr><td width='10%'>FECHA: "+data[1][12]+"</td></tr></table>\n"+
              "<table width='80%' align='center' style='margin-top:-5px;font:0.8em Verdana;'><tr><td width='100%'>RUC: "+data[1][0]+"</td></tr></table>\n"+
              "<table width='80%' align='center' style='margin-top:-5px;font:0.8em Verdana;'><tr><td width='100%'>CLIENTE: "+data[1][1]+"</td></tr></table>\n"+
              "<table width='80%' align='center' style='margin-top:-5px;font:0.8em Verdana;'><tr><td width='100%'>DIRECCION: "+data[1][2]+"</td></tr></table>\n"+
              "<table width='80%' align='center' style='margin-top:0px;font:0.7em Verdana;margin-bottom:3px'><tr style='background-color:black;color:white;'><td width='3%' align='center'>CAN</td><td width='75%' align='center'>PRODUCTO</td><td width='10%' align='center'>P.UNIT</td><td width='12%' align='center'>IMPORTE</td></tr></table>\n"
            );
            for (var i=0;i<data[0].length;i++) {
              $('#dx').append("<table width='80%' align='center' style='margin-top:-6px;font:0.7em Verdana'><tr><td width='3%' align='right'>"+data[0][i][1]+"</td><td width='3%'></td><td width='72%'>"+data[0][i][0]+"</td><td width='10%' align='right'>"+data[0][i][2]+"</td><td width='12%' align='right'>"+data[0][i][3]+"</td></tr></table>");
            }
            
            var subigv2=parseFloat(data[1][3]/1.18).toFixed(2);
            var igv2=parseFloat(data[1][3]-subigv2).toFixed(2);


            $('#dx').append("<table width='80%' align='center' style='font:0.8em Verdana;margin-top:-6px;'><tr><td align='right' width='100%'>OP. GRAVADAS: S/ "+subigv2+"</td></tr></table></div>");
            $('#dx').append("<table width='80%' align='center' style='font:0.8em Verdana;margin-top:-6px;'><tr><td align='right' width='100%'>IGV: S/ "+igv2+"</td></tr></table></div>");

            $('#dx').append("<table width='80%' align='center' style='font:0.8em Verdana;margin-top:-6px;'><tr><td align='right' width='100%'>TOTAL: S/ "+data[1][3]+"</td></tr></table></div>");
            $('#dx').append("<table width='80%' align='center' style='font:0.8em Verdana;margin-top:-6px;'><tr><td width='100%'>SON: <span id=let></span></td></tr></table></div>");
            $('#dx').append("<table width='80%' align='center'><tr><td align='center'><div id='qrcodeTable'></td></tr></table>");
            $('#dx').append("<table width='80%' align='center' style='font:0.8em Verdana;margin-top:-6px;'><tr><td width='100%' align='center'>GRACIAS POR SU PREFERENCIA</td></tr></table></div>");
            $('#dx').append("<table width='80%' align='center' style='font:0.8em Verdana;margin-top:-6px;'><tr><td width='100%' align='center'>Para consultar el documento ingrese en www.ferreboom.com</td></tr></table></div>");
            $('#dx').append("<table width='80%' align='center' style='font:0.8em Verdana;margin-top:-6px;'><tr><td width='100%' align='center'>BCP: CUENTA CORRIENTE 355-2284965-0-10</td></tr></table></div>");
            jQuery('#qrcodeTable').qrcode({
              render  : "table",
              text  : "http://ferreboom.com:2000",
              width: 64,
              height: 64
            });
            $.ajax({
              type: "POST",
              url: "numerosaletras.php",
              async: false,
              data: 'b='+data[1][3],
              success: function(data){
                $('#let').append(data);
              }
            });
            contenid = document.getElementById("dx");
            w.document.write("<html><head><style type='text/css'>@page{size:A4 portrait;}</style></head><body>"+contenid.innerHTML+"</body></html>");
          break;
          ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
          case 'NOTA DE PEDIDO':
            data[0].sort(function(a, b) {
                return a[8] - b[8];
            });
              $('#dx').append("<div align='center'><img id='theImg' src='../logo_ferreboom.jpg' style='width:300px;height:80px;'></div>\n"+
              "<table width='80%' align='center' style='font:0.7em Verdana;margin-top:-7px;'><tr><tr></tr><td width='100%' align='center'>NOTA DE PEDIDO</td></tr></table>\n"+
              "<table width='80%' align='center' style='font:0.7em Verdana;margin-top:-7px;'><tr><td width='100%' align='center'>JR. ANCASH 101 - CHILCA - HUANCAYO - JUNIN</td><td width='10%'>SERIE: </td><td width='25%' style='font-size:0.9em;font-weight:bold'>"+data[1][13]+"</td></tr></table>\n"+
              "<table width='80%' align='center' style='font:0.7em Verdana;margin-top:-7px;'><tr><td width='100%' align='center'>CEL: 948394809 - 975380302 BCP: CUENTA CORRIENTE 355-2284965-0-10</td></tr></table>");
              $('#dx').append("<table width='80%' align='center' style='font:0.8em Verdana;margin-top:-5px;'><tr><td width='10%'>FECHA: "+data[1][12]+"</td></tr></table>\n"+
              "<table width='80%' align='center' style='margin-top:-5px;font:0.8em Verdana;'><tr><td width='100%'>CLIENTE: "+data[1][1]+"</td><td width='10%'>Vendedor: </td><td width='25%'>"+data[1][6]+"</td></tr></table>\n"+
              "<table width='80%' align='center' style='margin-top:-5px;font:0.8em Verdana;'><tr><td width='100%'>DIRECCION: "+data[1][2].slice(0,84)+"</td></tr></table>\n"+
              "<table width='80%' align='center' style='margin-top:0px;font:0.7em Verdana;margin-bottom:3px'><tr style='background-color:black;color:white;'><td width='3%' align='center'>CAN</td><td width='75%' align='center'>PRODUCTO</td><td width='10%' align='center'>P.UNIT</td><td width='12%' align='center'>IMPORTE</td></tr></table>\n"
              );
              for (var i=0;i<data[0].length;i++) {
                $('#dx').append("<table width='80%' align='center' style='margin-top:-6px;font:0.7em Verdana'><tr><td width='3%' align='right'>"+data[0][i][1]+"</td><td width='3%'></td><td width='72%'>"+data[0][i][0]+"</td><td width='10%' align='right'>"+data[0][i][2]+"</td><td width='12%' align='right'>"+data[0][i][3]+"</td></tr></table>");
              }
              if(parseFloat(data[1][4])!=0){
                $('#dx').append("<table width='80%' align='center' style='margin-top:-2px;margin-bottom:5px;font:0.7em arial;'><tr><td width='20%' align='right'>DEVOLUCIONES:</td><td colspan='3' width='70%' align='right'>SUBTOTAL</td><td align='right'>"+data[1][3]+"</td></tr></table><hr style='margin-top:-8px'>");
                for (var i=0;i<data[2].length;i++) {
                  $('#dx').append("<table width='80%' align='center' style='margin-top:-6px;font:0.7em arial;'><tr><td width='3%' align='right'>"+data[2][i][1]+"</td><td width='3%'></td><td width='72%'>"+data[2][i][0]+"</td><td width='10%' align='right'>"+data[2][i][2]+"</td><td width='12%' align='right'>"+data[2][i][3]+"</td></tr></table>");
                }
                $('#dx').append("<table width='80%' align='center' style='margin-top:-6px;font:0.7em arial;'><tr><td colspan='4' width='90%' align='right'>DEVOLUCION</td><td align='right'>"+data[1][4]+"</td></tr></table>");
              }
              $('#dx').append("<table width='80%' align='center' style='font:0.8em Verdana;margin-top:-6px;'><tr><td align='right' width='100%'>TOTAL: S/ "+data[1][5]+"</td></tr></table></div>");
              $('#dx').append("<table width='80%' align='center' style='font:0.8em Verdana;margin-top:-6px;'><tr><td width='100%'>OBS: "+data[1][7]+"</td></tr></table>");
              $('#dx').append("<table width='80%' align='center' style='font:0.8em Verdana;margin-top:-6px;'><tr><td width='100%' align='center'>GRACIAS POR SU PREFERENCIA</td></tr></table></div>");
              
            contenid = document.getElementById("dx");
            w.document.write("<html><head><style type='text/css'>@page{size:A4 portrait;}</style></head><body>"+contenid.innerHTML+"</body></html>");
           
          break;
          ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
          case 'GUIA DE REMISION':
            $('#dx').append("<table width='100%' style='margin-top:145px;font:0.8em arial;'><tr><td width='10%'>&nbsp</td><td width='6%'>"+data[1][12].slice(0,2)+"</td><td width='6%'>"+data[1][12].slice(3,5)+"</td><td width='6%'>"+data[1][12].slice(6,10)+"</td><td width='12%'>&nbsp</td><td width='6%'>"+data[1][12].slice(0,2)+"</td><td width='6%'>"+data[1][12].slice(3,5)+"</td><td width='6%'>"+data[1][12].slice(6,10)+"</td><td width='42%'></td></tr></table>\n"+
              "<table width='100%' style='margin-top:19px;font:0.8em arial;'><tr><td width='2%'>&nbsp</td><td width='50%'>JR. ANCASH N° 101 - CHILCA - HUANCAYO - JUNIN</td><td width='1%'>&nbsp</td><td width='47%'>"+data[1][2]+"</td></tr></table>\n"+
              "<table width='100%' style='margin-top:31px;font:0.8em arial;'><tr><td width='18%'>&nbsp</td><td width='30%'>"+data[1][1]+"</td><td width='52%'>&nbsp</td></tr></table>\n"+
              "<table width='100%' style='margin-top:-2px;font:0.8em arial;'><tr><td width='38%'>&nbsp</td><td width='12%'>"+data[1][0]+"</td><td width='50%'>&nbsp</td></tr></table>\n"+
              "<table width='100%' style='margin-bottom:20px;margin-top:0px'><tr><td width='5%' align='center'>&nbsp</td><td width='75%' align='center'>&nbsp</td><td width='10%' align='center'>&nbsp</td><td width='10%' align='center'>&nbsp</td></tr></table>\n"
            );
            for (var i=0;i<data[0].length;i++) {
              $('#dx').append("<table width='100%' style='margin-top:-5px;font:0.7em arial'><tr height='22px'><td width='2%' align='right'>&nbsp</td><td width='60%'>&nbsp&nbsp&nbsp"+data[0][i][0]+"&nbsp&nbsp</td><td width='10%' align='right'>&nbsp&nbsp&nbsp&nbsp"+data[0][i][1]+"</td><td width='15%' align='right'>&nbspUND</td><td width='18%'></td></tr></table>");
            }
            while(v1<30-parseInt(data[0].length)){
              $('#dx').append("<table width='100%' style='margin-top:-5px'><tr height='22px'><td>&nbsp</td></tr></table>");
              v1++;
            }
            contenid = document.getElementById("dx");
            w.document.write("<html><head><style type='text/css'>@page{size:A4 portrait;}</style></head><body>"+contenid.innerHTML+"</body></html>");
          break;
          ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
          case 'COTIZACION':
            $('#dx').append("<div align='center'><img id='theImg' src='../logo_ferreboom.jpg' style='width:70%;height:150px;'></div>\n"+
              "<table width='100%'><tr><td align='center' colspan='4'><span align='center'><b>COTIZACION</b></span></tr></table>\n"+
              "<table width='100%' style='margin-top:-8px'><tr><td width='10%'>RUC:</td><td width='65%'>"+data[1][0]+"</td><td width='10%'>Fecha:</td><td width='15%'>"+data[1][12]+"</td></tr></table>\n"+
              "<table width='100%' style='margin-top:-8px'><tr><td width='10%'>CLIENTE:</td><td width='90%'>"+data[1][1]+"</td></tr></table>\n"+
              "<table width='100%' style='margin-top:-8px'><tr><td width='10%'>DIRECCION:</td><td width='65%'>"+data[1][2]+"</td><td width='10%'>Vendedor:</td><td width='15%'>"+data[1][6]+"</td></tr></table>\n"+
              "<table width='100%' style='margin-bottom:5px;margin-top:-5px'><tr bgcolor='black' style='color:white;font-weight:bold;font-size:12px;'><td width='5%' align='center'>CAN</td><td width='60%' align='center'>PRODUCTO</td><td width='10%' align='center'>P.UNITARIO</td><td width='10%' align='center'>IMPORTE</td></tr></table>\n"
            );
            for (var i=0;i<data[0].length;i++) {
              $('#dx').append("<table width='100%' style='margin-top:-9px'><tr><td width='2%' align='center'></td><td width='5%' align='right'>"+data[0][i][1]+"&nbsp</td><td width='60%'>"+data[0][i][0]+"</td><td width='10%' align='right'>"+data[0][i][2]+"</td><td width='10%' align='right'>"+data[0][i][3]+"</td></tr></table>");
            }
            $('#dx').append("<table width='100%' style='margin-top:-5px'><tr><td width='90%' align='right'>TOTAL</td><td align='right' width='10%'>S/. "+data[1][3]+"</td></tr></table>");
            contenid = document.getElementById("dx");
            w.document.write("<html><head><style type='text/css'>@page{size:A4 portrait;}@media print {html,body {width: 190mm;height: 320mm;}}</style></head><body>"+contenid.innerHTML+"</body></html>");
          break;
        }
        setTimeout(function() {
          w.focus();
          w.print();
          setTimeout(function(){
            w.close();
            if($('#dialogver').css('display') != 'block'){
              location.reload();
            }
          }, 200);
        }, 800);
        
      }
    });
  }
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  $('#row').on('click','.editme1',function(){
    document.execCommand('selectAll', false, null);
  });
  $('#row').on('click','.editme2',function(){
    document.execCommand('selectAll', false, null);
  });
  $('#row').on('keyup','.editme1',function(){
    if(parseFloat($(this).text())<=parseFloat($(this).parent().find('td:eq(8)').text())){
      $(this).removeClass('mayorstock');
    }else{
      $(this).addClass('mayorstock');
    }
    $(this).parent().find('td:eq(4)').text(parseFloat(parseFloat($(this).parent().find('td:eq(3)').text())*parseFloat($(this).text())).toFixed(2));
    $('#subtotal').val(parseFloat(suma()).toFixed(2));
    $('#total').val(parseFloat(parseFloat($('#subtotal').val())-parseFloat($('#subtotal_devol').val())).toFixed(2));
  });
  $('#row').on('keyup','.editme2',function(){
    if(parseFloat($(this).text())>=parseFloat($(this).parent().find('td:eq(6)').text())){
      $(this).parent().find('td:eq(4)').text(parseFloat($(this).parent().find('td:eq(2)').text())*parseFloat($(this).text()));
    }
    else{
      $(this).parent().find('td:eq(4)').text(parseFloat($(this).parent().find('td:eq(2)').text())*parseFloat($(this).parent().find('td:eq(6)').text()));
    }
    if(parseFloat($(this).text())>=parseFloat($(this).parent().find('td:eq(7)').text())){
      $(this).removeClass('mayorstock');
    }else{
      $(this).addClass('mayorstock');
    }
    $('#subtotal').val(parseFloat(suma()).toFixed(2));
    $('#total').val(parseFloat(parseFloat($('#subtotal').val())-parseFloat($('#subtotal_devol').val())).toFixed(2));
  });
  $('#row').on('blur','.editme2',function () {
    $(this).text(parseFloat(parseFloat($(this).next().text())/parseFloat($(this).prev().text())).toFixed(2));
    $(this).next().text(parseFloat($(this).next().text()).toFixed(2));
  });
  $('#row').on('click','.produ',function(){
    $("#row tr").removeClass('select');
    $(this).parent().addClass('select');
    var pp=$(this).parent().find('td:eq(5)').text();
    anterior($('#razon_social').val(),pp);
    var top=parseInt($(this).position().top)+30;
    var left=parseInt($(this).position().left);
    $("#result").css({"top":""+top+"px", "left":""+left+"px"});
    $.ajax({
      type: "POST",
      url: "producto.php",
      data: {b:$(this).text(),
             doc:$('#documento').val()},
      cache: false,
      success: function(data){
        $("#tb1").empty();
        $("#tb1").append(data);
        if($('#tb1 >tr').length =="0"){
          $("#result").hide();
        }else{
          $('#result').show();
        }
      }
    });
  });
  $('#row').on('contextmenu','.produ',function(e){
    $("#row tr").removeClass('select');
    $(this).parent().addClass('select');
    e.preventDefault();
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
        $('#subtotal').val(parseFloat(suma()).toFixed(2));
        $('#total').val(parseFloat(parseFloat($('#subtotal').val())-parseFloat($('#subtotal_devol').val())).toFixed(2));
        $('#cantprod').empty();
        $('#cantprod').append($('#row tr').length+" Productos");
      } 
    });
  });
////////////////////////////////////////////////////////////////////////////////////////////////////////////  
  $("#devol").click(function(){
    $("#row tr").removeClass('select');
    $("#dialog").dialog({
      title:"DEVOLUCION",
      autoOpen:true,
      closeOnEscape: true,
      closeText: "cerrar",
      draggable: true,
      height: 450,
      width: "90%",
      hide: { effect: "slideUp", duration: 500 },
      show: { effect: "slideDown", duration: 500 },
      modal: true,  
      resizable:true,
      close:function(){
        $("#row1 tr").removeClass('select');
      }
    });
  });
/////////////////////////////////////////////////////////////////////////////////////////////////////////////
  $('#busqueda1').keyup(function(e){
    $("#result").appendTo("#dialog");
    var top=parseInt($(this).position().top)+30;
    var left=parseInt($(this).position().left);
    $("#result").css({"top":""+top+"px", "left":""+left+"px"});
    producto($('#busqueda1').val(),e,"1");
  });
  $('#cantidad1').keyup(function(e){
    $('#importe1').val(parseFloat($("#precio_u1").val()*$("#cantidad1").val()).toFixed(2));
    if(e.which == 13) {
      $("#precio_u1").focus();
    }
  });
  $('#precio_u1').keyup(function(e){
    $("#importe1").val(parseFloat($("#precio_u1").val()*$("#cantidad1").val()).toFixed(2));
    if(e.which == 13) {
      $("#importe1").focus();
    }
  });
  $('#importe1').keyup(function(e){
    $("#precio_u1").val(parseFloat($("#importe1").val()/$("#cantidad1").val()).toFixed(3));
    if(e.which == 13) {
      $("#estado").focus();
    }
    });
  $('#estado').on('click',function(e){
    if(e.offsetY < 0){
      if($('#id1').val()>0 && $('#estado').val()!=""){
        $('#row1').append(
          "<tr class='fila'>\n" +
          "  <td width='2%' style='padding:0px;' title='s'><img src='https://raw.githubusercontent.com/paolomelgar/www/master/huancayoprincipal/fotos/producto/a"+$("#id1").val()+".jpg?timestamp=23124' width='100%' height='100%'></td>\n"+
          "  <td width='53%' class='produ'>" + $("#busqueda1").val() + "</td>\n" +
          "  <td width='10%' contenteditable='true' class='editme3' style='text-align:right'>" + $("#cantidad1").val() + "</td>\n" +
          "  <td width='10%' contenteditable='true' class='editme4' style='text-align:right'>" + parseFloat($("#precio_u1").val()).toFixed(2) + "</td>\n" +
          "  <td width='10%' style='text-align:right'>" + parseFloat($("#importe1").val()).toFixed(2) + "</td>\n" +
          "  <td width='15%' style='text-align:center'>" + $("#estado").val()+ "</td>\n" +
          "  <td style='display:none'>" + $("#id1").val() +"</td>\n" +
          "  <td style='display:none'>" + $("#compra1").val() +"</td>\n" +
          "</tr>\n"
        );
        $('#subtotal_devol').val(parseFloat(suma1()).toFixed(2));
        $('#devolucion').val(parseFloat(-suma1()).toFixed(2));
        $('#total').val(parseFloat(parseFloat($('#subtotal').val())-parseFloat($('#subtotal_devol').val())).toFixed(2));
        $('#estado').val("");
        $('#busqueda1').val("");
        $('#cantidad1').val("");
        $('#precio_u1').val("");
        $('#importe1').val("");
        $('#id1').val("");
        $('#compra1').val("");
        $("#busqueda1").focus(); 
      }
    }else{
      //dropdown is shown
    }
  });
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  $('#row1').on('click','.editme3',function(){
    document.execCommand('selectAll', false, null);
  });
  $('#row1').on('click','.editme4',function(){
    document.execCommand('selectAll', false, null);
  });
  $('#row1').on('keyup','.editme3',function(){
    $(this).parent().find('td:eq(4)').text(parseFloat(parseFloat($(this).parent().find('td:eq(3)').text())*parseFloat($(this).text())).toFixed(2));
      $('#subtotal_devol').val(parseFloat(suma1()).toFixed(2));
      $('#devolucion').val(parseFloat(-suma1()).toFixed(2));
      $('#total').val(parseFloat(parseFloat($('#subtotal').val())-parseFloat($('#subtotal_devol').val())).toFixed(2));
  });
  $('#row1').on('keyup','.editme4',function(){
    $(this).parent().find('td:eq(4)').text(parseFloat($(this).parent().find('td:eq(2)').text())*parseFloat($(this).text()));
      $('#subtotal_devol').val(parseFloat(suma1()).toFixed(2));
      $('#devolucion').val(parseFloat(-suma1()).toFixed(2));
      $('#total').val(parseFloat(parseFloat($('#subtotal').val())-parseFloat($('#subtotal_devol').val())).toFixed(2));
  });
  $('#row1').on('blur','.editme4',function () {
    $(this).text(parseFloat($(this).text()).toFixed(2));
    $(this).next().text(parseFloat($(this).next().text()).toFixed(2));
  });
  
  $('#row1').on('click','.produ',function(){
    $("#row1 tr").removeClass('select');
    $(this).parent().addClass('select');
    var pp=$(this).parent().find('td:eq(5)').text();
    anterior($('#razon_social').val(),pp);
  });
  $('#row1').on('contextmenu','.produ',function(e){
    $("#row1 tr").removeClass('select');
    $(this).parent().addClass('select');
    e.preventDefault();
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
        $('#subtotal_devol').val(parseFloat(suma1()).toFixed(2));
        $('#devolucion').val(parseFloat(-suma1()).toFixed(2));
        $('#total').val(parseFloat(parseFloat($('#subtotal').val())-parseFloat($('#subtotal_devol').val())).toFixed(2));
      } 
    });
  });
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  $("#sunat").click(function(){
    $('#dialogsunat').empty();
    $('#dialogsunat').show();
    $('#ruc').select();
    document.execCommand("copy");
    $('#dialogsunat').append("<iframe src='http://www.sunat.gob.pe/cl-ti-itmrconsruc/jcrS00Alias' width='100%' height='98%' id='frameDemo'></iframe><span class='ui-icon ui-icon-circle-close' id='sal' style='position:absolute;right:0px;top:0px;cursor:pointer'>");
    $('#sal').click(function(){
      $('#dialogsunat').hide();
    });
  });

  $('#buscar').click(function(){
    var fechaini=$('#fechaini').val();
    var fechafin=$('#fechafin').val();
    var clie=$('#clie').val();
    $.ajax({
      type: "POST",
      url: "verventas.php",
      dataType:"json",
      data: {ini:fechaini,
             fin:fechafin,
             cliente:clie},
      beforeSend:function(){
        $('#verbody').empty();
        $('#verbody').append("<tr><td align='center' colspan='8'><img src='../loading.gif' width='420px'></td></tr>");
      },       
      success: function(data){
        $("#verbody").empty();
        for (var i = 0; i <= data.length-1; i++) {
          if(data[i][6]=='ANULADO'){
            $("#verbody").append("<tr><td align='center' width='5%' style='color:blue;font-weight:bold;cursor:pointer;border:1px solid #B1B1B1' class='visualizar'>Anulado</td><td align='right' width='8%' style='border:1px solid #B1B1B1'>"+data[i][0]+"</td><td align='center' width='12%' style='border:1px solid #B1B1B1'>"+data[i][8]+"</td><td align='center' width='10%' style='border:1px solid #B1B1B1'>"+data[i][1]+"<br>"+data[i][2]+"</td><td align='center' width='10%' style='border:1px solid #B1B1B1'>"+data[i][3]+"</td><td width='27%' style='border:1px solid #B1B1B1'>"+data[i][4]+"</td><td align='center' width='10%' style='border:1px solid #B1B1B1'>"+data[i][5]+"</td><td align='center' width='8%' style='border:1px solid #B1B1B1'>"+data[i][6]+"</td><td align='right' width='10%' style='padding-right:10px;border:1px solid #B1B1B1'>S/ "+data[i][7]+"</td></tr>");
          }else{
            $("#verbody").append("<tr><td align='center' width='5%' style='color:red;font-weight:bold;cursor:pointer;border:1px solid #B1B1B1' class='visualizar'>Ver</td><td align='right' width='8%' style='border:1px solid #B1B1B1'>"+data[i][0]+"</td><td align='center' width='12%' style='border:1px solid #B1B1B1'>"+data[i][8]+"</td><td align='center' width='10%' style='border:1px solid #B1B1B1'>"+data[i][1]+"<br>"+data[i][2]+"</td><td align='center' width='10%' style='border:1px solid #B1B1B1'>"+data[i][3]+"</td><td width='27%' style='border:1px solid #B1B1B1'>"+data[i][4]+"</td><td align='center' width='10%' style='border:1px solid #B1B1B1'>"+data[i][5]+"</td><td align='center' width='8%' style='border:1px solid #B1B1B1'>"+data[i][6]+"</td><td align='right' width='10%' style='padding-right:10px;border:1px solid #B1B1B1'>S/ "+data[i][7]+"</td></tr>");
          }
        }
        $('#verbody> tr:odd').addClass('par');
        $('#verbody> tr:even').addClass('impar');
        $('#ventas').tableFilterRefresh();
      }
    });
  });
  $("#ver").click(function(){
    $('#clie').focus();
    $("#clie").autocomplete({
      source:"../ganancias/cliente.php",
      minLength:1
    });
    $("#dialogver").show();
    $('#buscar').click();
  });
  $("#salir").click(function(){
    $("#dialogver").hide();
    $("#observarpedido").dialog("close");
  });
  $("#saliranterior").click(function(){
    $("#anterior").hide();
  });
  var serie1,comprobante;
  $('#dialogver').on('click','.visualizar',function(){
    $('#observarpedido').dialog("open");
    serie1=$(this).parent().find('td:eq(1)').text();
    comprobante=$(this).parent().find('td:eq(4)').text();
    $.ajax({
      type: "POST",
      url: "verlistaproductos.php",
      data: 'serie='+serie1+'&com='+comprobante,
      beforeSend:function(){
        $('#observarpedido').empty();
        $('#observarpedido').append("<table width='100%'><tr><td align='center'><img src='../loading.gif' width='450px'></td></tr></table>");
      },
      success: function(data){
        $('#observarpedido').empty();
        $('#observarpedido').append(data);
      }
    });
    if($(this).parent().find('td:eq(6)').text()=='NO AFECTA'){
      if($(this).parent().find('td:eq(4)').text()=='FACTURA ELECTRONICA INNOVA' || $(this).parent().find('td:eq(4)').text()=='FACTURA ELECTRONICA BOOM'){
          if ($(this).parent().find('td:eq(7)').text()=='ANULADO'){
            $(".ui-dialog-buttonpane button:contains('ELIMINAR')").button("disable");
            $(".ui-dialog-buttonpane button:contains('EDITAR')").button("disable");
          }else{
            $(".ui-dialog-buttonpane button:contains('ELIMINAR')").button("enable");
            $(".ui-dialog-buttonpane button:contains('EDITAR')").button("enable");
          }
      }else{
          if ($(this).parent().find('td:eq(7)').text()=='ANULADO'){
            $(".ui-dialog-buttonpane button:contains('ELIMINAR')").button("disable");
            $(".ui-dialog-buttonpane button:contains('EDITAR')").button("disable");
          }else{
            $(".ui-dialog-buttonpane button:contains('ELIMINAR')").button("enable");
            $(".ui-dialog-buttonpane button:contains('EDITAR')").button("enable");
          }
        }
    }else if($(this).parent().find('td:eq(6)').text()=='CONTADO'){
      if($(this).parent().find('td:eq(3)').text().slice(0,10)!=fech){
        if($(this).parent().find('td:eq(4)').text()=='FACTURA ELECTRONICA INNOVA' || $(this).parent().find('td:eq(4)').text()=='FACTURA ELECTRONICA BOOM'){
          $(".ui-dialog-buttonpane button:contains('ELIMINAR')").button("enable");
          $(".ui-dialog-buttonpane button:contains('EDITAR')").button("enable");
        }else{
          $(".ui-dialog-buttonpane button:contains('ELIMINAR')").button("disable");
          $(".ui-dialog-buttonpane button:contains('EDITAR')").button("disable");
        }
      }
      else{
        if($(this).parent().find('td:eq(7)').text()=='ANULADO'){
          $(".ui-dialog-buttonpane button:contains('ELIMINAR')").button("disable");
        }else{
          $(".ui-dialog-buttonpane button:contains('ELIMINAR')").button("enable");
        }
        $(".ui-dialog-buttonpane button:contains('EDITAR')").button("disable");
      }
    }else if($(this).parent().find('td:eq(6)').text()=='CANCELADO'){
      $(".ui-dialog-buttonpane button:contains('ELIMINAR')").button("disable");
      $(".ui-dialog-buttonpane button:contains('EDITAR')").button("disable");
    }else{
      if($(this).parent().find('td:eq(7)').text()=='ANULADO'){
        $(".ui-dialog-buttonpane button:contains('ELIMINAR')").button("disable");                                                           
      }else{
        $(".ui-dialog-buttonpane button:contains('ELIMINAR')").button("enable");
      }
      if($('#cargo').val()=='ADMIN'){
        $(".ui-dialog-buttonpane button:contains('EDITAR')").button("enable");
      }else{
        $(".ui-dialog-buttonpane button:contains('EDITAR')").button("disable");
    }
    }
  });
  $('#observarpedido').dialog({
    title:"LISTA PEDIDOS",
    position: [1,166],
    autoOpen:false,
    height: 480,
    width: 450,
    fontSize:10,
    show: {effect: "slide",duration: 100},
    hide: {effect: "slide",duration: 100},
    buttons: [
      {
          text: " IMPRIMIR",
          click: function() { 
            imprimir(serie1,comprobante);
          }
      },
      {
          text: "NOTA DE CREDITO",
          icons: { primary: "ui-icon-trash" },
          click: function() { 
            swal({
              title: "Esta Seguro de Hacer Nota de Credito!",
              text: "",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Aceptar",
              cancelButtonText: "Cancelar"
            },
            function(isConfirm){
              if (isConfirm) {
                $("#observarpedido").dialog("close");
                $.ajax({
                  type: "POST",
                  url: "notadecredito.php",
                  data: 'serie='+serie1+'&com='+comprobante,
                  success: function(data){
                    serieventa=0;
                    $('#buscar').click();
                  }
                });
              } 
            });
          }
      },
      {
          text: " ELIMINAR",
          click: function() { 
            $("#dialoganular").dialog({
              title:"MOTIVO PARA ELIMINAR",
              width:"40%",
              modal:true,
              buttons: { 
                "ELIMINAR" : function(){ 
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
                      $("#observarpedido").dialog("close");
                      $.ajax({
                        type: "POST",
                        url: "eliminarcomprobantes.php",
                        data: 'serie='+serie1+'&com='+comprobante,
                        success: function(data){
                          serieventa=0;
                          $('#buscar').click();
                        }
                      });
                    } 
                  });
                },
              },
              open: function() {
                $('.radio').val("");
              }
            });
          }
      },
      {
          text: "VER",
          click: function() { 
            $.ajax({
              type: "POST",
              url: "vercomprobantes.php",
              dataType: "json",
              data: 'serie='+serie1+'&com='+comprobante,
              success: function(data){
                serieventa=0;
                credito=data[1][16];
                $('#form select[name="documento"]').prop('disabled', false);
                $('#form select[name="documento"]').val("0").change();
                $('#ruc').val(data[1][0]);
                $('#razon_social').val(data[1][1]);
                $('#direccion').val(data[1][2]);
                $('#subtotal').val(data[1][3]);
                $('#devolucion').val(data[1][4]);
                $('#total').val(data[1][5]);
                $('#subtotal_devol').val(-data[1][4]);
                $('#row').empty();
                for (var i=0;i<data[0].length;i++) {
                  var next= "<tr class='fila'>\n" +
                            "<td width='2%' style='padding:0px;' title='s'><img src='https://raw.githubusercontent.com/paolomelgar/www/master/huancayoprincipal/fotos/producto/a"+data[0][i][4]+".jpg?timestamp=23124' width='100%' height='100%'></td>\n"+
                            "<td width='68%' class='produ'>" + data[0][i][0] + "</td>\n"+
                            "<td width='10%' contenteditable='true' class='editme1' style='text-align:right'>" + data[0][i][1] + "</td>\n";
                  if(parseFloat(data[0][i][2])<parseFloat(data[0][i][6])){
                    next += "<td width='10%' contenteditable='true' class='editme2 mayorstock' style='text-align:right'>" + parseFloat(data[0][i][2]).toFixed(2) + "</td>\n";
                  }else{
                    next += "<td width='10%' contenteditable='true' class='editme2' style='text-align:right'>" + parseFloat(data[0][i][2]).toFixed(2) + "</td>\n";
                  }
                    next += "<td width='10%' align='right' style='text-align:right;'>" + data[0][i][3] + "</td>\n" +
                            "<td style='display:none'>" + data[0][i][4] +"</td>\n" +
                            "<td style='display:none'>" + data[0][i][5] +"</td>\n" +
                            "<td style='display:none'>" + data[0][i][6] +"</td>\n" +
                            "</tr>";
                  $('#row').append(next);
                }
                $('#row1').empty();
                for (var i=0;i<data[2].length;i++) {
                  $('#devol').removeClass('btn-info');
                  $('#devol').addClass('btn-danger');
                  $('#row1').append(
                    "<tr class='fila'>\n" +
                    "<td width='2%' style='padding:0px;' title='s'><img src='https://raw.githubusercontent.com/paolomelgar/www/master/huancayoprincipal/fotos/producto/a"+data[2][i][4]+".jpg?timestamp=23124' width='100%' height='100%'></td>\n"+
                    "<td width='53%' class='produ'>" + data[2][i][0] + "</td>\n" +
                    "<td width='10%' contenteditable='true' class='editme3' style='text-align:right'>" + data[2][i][1] + "</td>\n" +
                    "<td width='10%' contenteditable='true' class='editme4' style='text-align:right'>" + data[2][i][2] + "</td>\n" +
                    "<td width='10%' style='text-align:right'>" + data[2][i][3] + "</td>\n" +
                    "<td width='15%' style='text-align:center'>" + data[2][i][6]+ "</td>\n" +
                    "<td style='display:none'>" + data[2][i][4] +"</td>\n" +
                    "<td style='display:none'>" + data[2][i][5] +"</td>\n" +
                    "</tr>\n"
                  );
                }
                $('#cantprod').empty();
                $('#cantprod').append($('#row tr').length+" Productos");
              }
            });
            $("#dialogver").hide();
            $("#observarpedido").dialog("close");
            $('#guardarform').removeClass('btn-danger');
            $('#guardarform').addClass('btn-success');
            $("#guardarform").val("ENVIAR");
          }
      },
      {
          text: "EDITAR",
          click: function() { 
            $.ajax({
              type: "POST",
              url: "vercomprobantes.php",
              dataType: "json",
              data: 'serie='+serie1+'&com='+comprobante,
              success: function(data){
                serieventa=data[1][13];
                credito=data[1][16];
                $('#ruc').val(data[1][0]);
                $('#razon_social').val(data[1][1]);
                $('#direccion').val(data[1][2]);
                $('#subtotal').val(data[1][3]);
                $('#devolucion').val(data[1][4]);
                $('#total').val(data[1][5]);
                $('#vendedor').val(data[1][6]);
                $('#comentario').val(data[1][7]);
                $('#form select[name="documento"]').val(data[1][8]).change();
                $('#documento option').hide();
                if(data[1][9]=='CREDITO'){
                  $('#form select[name="forma-pago"]').val(data[1][9]);
                  $('.pago').show();
                  $('#limitecredito').empty();
                  $('#limitecredito').append("<p align='center'>LIMITE DE CREDITO:</p><p align='center'>S/ "+credito+"</p>");
                  $('#limitecredito').show();
                }
                else{
                  $('#form select[name="forma-pago"]').val(data[1][9]);
                  $('.pago').hide();
                }
                if(data[1][11]!='31/12/1969'){
                  $('#fechapago').val(data[1][11]);
                }
                if(data[1][14]=='NO'){
                  $('#form select[name="entregar"]').val('NO');
                }
                else{
                  $('#form select[name="entregar"]').val('SI'); 
                }
                $('#fecha').val(data[1][12]);
                $('#acuenta').val(data[1][10]);
                $('#documento').val(data[1][8]);
                $('#subtotal_devol').val(-data[1][4]);
                $('#row').empty();
                for (var i=0;i<data[0].length;i++) {
                  var next= "<tr class='fila'>\n" +
                            "<td width='2%' style='padding:0px;' title='s'><img src='https://raw.githubusercontent.com/paolomelgar/www/master/huancayoprincipal/fotos/producto/a"+data[0][i][4]+".jpg?timestamp=23124' width='100%' height='100%'></td>\n"+
                            "<td width='68%' class='produ'>" + data[0][i][0] + "</td>\n"+
                            "<td width='10%' contenteditable='true' class='editme1' style='text-align:right'>" + data[0][i][1] + "</td>\n";
                  if(parseFloat(data[0][i][2])<parseFloat(data[0][i][6])){
                    next += "<td width='10%' contenteditable='true' class='editme2 mayorstock' style='text-align:right'>" + parseFloat(data[0][i][2]).toFixed(2) + "</td>\n";
                  }else{
                    next += "<td width='10%' contenteditable='true' class='editme2' style='text-align:right'>" + parseFloat(data[0][i][2]).toFixed(2) + "</td>\n";
                  }
                    next += "<td width='10%' align='right' style='text-align:right;'>" + data[0][i][3] + "</td>\n" +
                            "<td style='display:none'>" + data[0][i][4] +"</td>\n" +
                            "<td style='display:none'>" + data[0][i][5] +"</td>\n" +
                            "<td style='display:none'>" + data[0][i][6] +"</td>\n" +
                            "</tr>";
                  $('#row').append(next);
                }
                $('#row1').empty();
                for (var i=0;i<data[2].length;i++) {
                  $('#devol').removeClass('btn-info');
                  $('#devol').addClass('btn-danger');
                  $('#row1').append(
                    "<tr class='fila'>\n" +
                    "<td width='2%' style='padding:0px;' title='s'><img src='https://raw.githubusercontent.com/paolomelgar/www/master/huancayoprincipal/fotos/producto/a"+data[2][i][4]+".jpg?timestamp=23124' width='100%' height='100%'></td>\n"+
                    "<td width='53%' class='produ'>" + data[2][i][0] + "</td>\n" +
                    "<td width='10%' contenteditable='true' class='editme3' style='text-align:right'>" + data[2][i][1] + "</td>\n" +
                    "<td width='10%' contenteditable='true' class='editme4' style='text-align:right'>" + data[2][i][2] + "</td>\n" +
                    "<td width='10%' style='text-align:right'>" + data[2][i][3] + "</td>\n" +
                    "<td width='15%' style='text-align:center'>" + data[2][i][6]+ "</td>\n" +
                    "<td style='display:none'>" + data[2][i][4] +"</td>\n" +
                    "<td style='display:none'>" + data[2][i][5] +"</td>\n" +
                    "</tr>\n"
                  );
                }
                $('#cantprod').empty();
                $('#cantprod').append($('#row tr').length+" Productos");
              }
            });
            $("#dialogver").hide();
            $("#observarpedido").dialog("close");
            $('#guardarform').removeClass('btn-success');
            $('#guardarform').addClass('btn-danger');
            $("#guardarform").val("EDITAR COMPROBANTE");
          }
      }
    ],
  });
  var barChart;
  var nn=0;
  $("#estadistica").click(function(){
    $("#clienteestadistica").autocomplete({
      source:"../ganancias/cliente.php",
      minLength:1,
      select: function (e,ui) {
        nn++;
        if(nn>1){barChart.destroy();}
        cliente=ui.item.value;
        $.ajax({
          type: "POST",
          url: "estadisticacliente.php",
          dataType: "json",
          data: {b:cliente},
          async: false,
          success: function(data){
            var dat = {
              labels: data[1].reverse(),
              datasets: [
              {
              fillColor: "#f63",
              strokeColor: "rgba(225,0,0,1)",
              data: data[0].reverse()
              }  ]  }
            var options = { 
              scaleFontSize: 15,
              scaleFontColor: "#000",
            };
            var cht = document.getElementById('trChart');
            var ctx = cht.getContext('2d');
            barChart = new Chart(ctx).Bar(dat,options);
          }
        }); 
      }
    });
    $("#dialogestadistica").show();
    $('#clienteestadistica').focus();
  });
  $("#salir2").click(function(){
    $("#dialogestadistica").hide();
  });
  $("a.external").click(function() {
    url = $(this).attr("href");
    window.open(url, '_blank');
    return false;
 });
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  $("#guardarform").click(function(){
    var restrict=$('#total').val()-$('#acuenta').val();
    if($('#documento').val()==0){
      swal("","Escoger el Tipo de Documento","error");
      $('#documento').addClass('mayorstock');
    }
    else if($('#forma-pago').val()=='CREDITO' && $('#fechapago').val()==''){
      swal("","RELLENAR FECHA DE PAGO","error");
      $('#fechapago').addClass('mayorstock');
    }
    else if($('#forma-pago').val()=='CREDITO' && restrict>credito){
      swal("","NO PUEDE PASAR EL LIMITE DE CREDITO","error");
      $('#total').addClass('mayorstock');
    }
    else if($('#id').val()>0 && $('#busqueda').val()!=""){
      swal("Hay un producto en busqueda","Debes Borrar o agregar","error");
    }else if($('#row1 tr').length>0 && $('#row tr').length>0){
      swal("Devoluciones no","error");
    }
    else{
      var str = $('#form').serializeArray();
      var producto=new Array();
      var cantidad=new Array();
      var precio_u=new Array();
      var importe=new Array();
      var id=new Array();
      var compra=new Array();
      var promot=new Array();
      var producto1=new Array();
      var cantidad1=new Array();
      var precio_u1=new Array();
      var importe1=new Array();
      var estado1=new Array();
      var id1=new Array();
      var compra1=new Array();
      var i=0;
      var j=0;
      $('#row tr').each(function(){
        producto[i]=$(this).find('td:eq(1)').text();
        cantidad[i]=$(this).find('td:eq(2)').text();
        precio_u[i]=$(this).find('td:eq(3)').text();
        importe[i]=$(this).find('td:eq(4)').text();
        id[i]=$(this).find('td:eq(5)').text();
        compra[i]=$(this).find('td:eq(6)').text();
        promot[i]=$(this).find('td:eq(7)').text();
        i++;
      });
      $('#row1 tr').each(function(){
        producto1[j]=$(this).find('td:eq(1)').text();
        cantidad1[j]=$(this).find('td:eq(2)').text();
        precio_u1[j]=$(this).find('td:eq(3)').text();
        importe1[j]=$(this).find('td:eq(4)').text();
        estado1[j]=$(this).find('td:eq(5)').text();
        id1[j]=$(this).find('td:eq(6)').text();
        compra1[j]=$(this).find('td:eq(7)').text();
        j++;
      });
      
      $("#procesarenvio").dialog({
        title:"LISTA PRODUCTOS",
        autoOpen:true,
        closeOnEscape: true,
        draggable: true,
        height: 490,
        width: "70%",
        modal: true,  
        resizable:true,
        buttons: { 
          "SOLO GUARDAR" : function(){ 
            $(this).dialog("close");
            $.ajax({
              type: "POST",
              url: "procesarventa.php",
              data: {str:str,
                    serieventa:serieventa,
                    seriepedido:seriepedido,
                    producto:producto,
                    cantidad:cantidad,
                    unitario:precio_u,
                    importe:importe,
                    id:id,
                    compra:compra,
                    promotor:promot,
                    producto1:producto1,
                    cantidad1:cantidad1,
                    unitario1:precio_u1,
                    importe1:importe1,
                    estado1:estado1,
                    id1:id1,
                    compra1:compra1},
              cache: false,
              beforeSend:function(){
                swal({
                  title: "Procesando Venta..",
                  text: "",
                  imageUrl: "../loading.gif",
                  showConfirmButton: false
                });
              },
              success: function(data){
                if($('#documento').val()=='FACTURA ELECTRONICA BOOM' || $('#documento').val()=='FACTURA ELECTRONICA INNOVA'){
                  var serieee=data;
                  $.ajax({
                    type: "POST",
                    url: "numerosaletras.php",
                    async: false,
                    data: 'b='+$('#subtotal').val(),
                    success: function(data){
                      $.ajax({
                        type: "POST",
                        url: "ley.php",
                        data: { b : data,
                                serie : serieee,
                                doc : $('#documento').val()},
                        success: function(data){
                        }
                      });
                    }
                  });
                }
                location.reload();
              }
            });
          },
          "GUARDAR E IMPRIMIR" : function(){
            $.ajax({
              type: "POST",
              url: "procesarventa.php",
              data: {str:str,
                    serieventa:serieventa,
                    seriepedido:seriepedido,
                    producto:producto,
                    cantidad:cantidad,
                    unitario:precio_u,
                    importe:importe,
                    id:id,
                    compra:compra,
                    promotor:promot,
                    producto1:producto1,
                    cantidad1:cantidad1,
                    unitario1:precio_u1,
                    importe1:importe1,
                    estado1:estado1,
                    id1:id1,
                    compra1:compra1},
              cache: false,
              beforeSend:function(){
                swal({
                  title: "Procesando Venta..",
                  text: "",
                  imageUrl: "../loading.gif",
                  showConfirmButton: false
                });
              },
              success: function(data){
                if($('#documento').val()=='FACTURA ELECTRONICA BOOM' || $('#documento').val()=='FACTURA ELECTRONICA INNOVA'){
                  var serieee=data;
                  $.ajax({
                    type: "POST",
                    url: "numerosaletras.php",
                    async: false,
                    data: 'b='+$('#subtotal').val(),
                    success: function(data){
                      $.ajax({
                        type: "POST",
                        url: "ley.php",
                        data: { b : data,
                                serie : serieee,
                                doc : $('#documento').val()},
                        success: function(data){
                        }
                      });
                    }
                  });
                }
                imprimir(data,$('#documento').val());
                //setTimeout(function(){location.reload();}, 200);
              }
            });
          } 
        },
        open: function() {
          $(this).parents('.ui-dialog-buttonpane button:eq(0)').focus();
          $(this).empty();
          var v=0;
          switch($('#documento').val()){
            
             case 'FACTURA BOOM':
              $(this).append("<div id='xd' align='center'><table width='100%' style='margin-top:-2px;font:0.9em arial;'><tr><td width='12%'>&nbsp</td><td width='10%'>"+$('#fecha').val().slice(0,2)+"</td><td width='20%'>"+$('#fecha').val().slice(3,5)+"</td><td width='58%'>"+$('#fecha').val().slice(9,10)+"</td></tr></table>\n"+
                "<table width='100%' style='margin-top:7px;font:0.9em arial;'><tr><td width='10%'>&nbsp</td><td width='60%'>"+$('#razon_social').val()+"</td><td width='15%'>&nbsp</td><td width='20%' style='font-size:17px;font-weight:bold'>"+$('#ruc').val()+"</td></tr></table>\n"+
                "<table width='100%' style='margin-top:10px;font:0.9em arial;'><tr><td width='10%'>&nbsp</td><td width='70%'>"+$('#direccion').val()+"</td><td width='20%' style='font-size:15px;font-weight:bold'>Cond. Pago: "+$('#forma-pago').val()+"</td></tr></table>\n"+
                "<table width='100%' style='margin-bottom:6px;margin-top:15px'><tr><td width='5%' align='center'>&nbsp</td><td width='75%' align='center'>&nbsp</td><td width='10%' align='center'>&nbsp</td><td width='10%' align='center'>&nbsp</td></tr></table>\n"
              );
              $('#row tr').each(function(){
                $('#xd').append("<table width='100%' style='margin-top:-8px;font:0.9em arial;font-weight:bold'><tr height='22px'><td width='15%' align='right'>"+$(this).find('td:eq(2)').text()+"&nbsp&nbsp&nbsp&nbsp&nbsp</td><td width='55%'>&nbsp&nbsp&nbsp&nbsp&nbsp"+$(this).find('td:eq(1)').text()+"</td><td width='15%' align='right'>"+$(this).find('td:eq(3)').text()+"</td><td width='15%' align='right'>"+$(this).find('td:eq(4)').text()+"</td></tr></table>");
              });
              while(v<42-parseInt($('#row tr').length)){
                $('#xd').append("<table width='100%' style='margin-top:-8px'><tr height='22px'><td>&nbsp</td></tr></table>");
                v++;
              }
              var subigv=parseFloat($('#subtotal').val()/1.18).toFixed(2);
              igv=parseFloat($('#subtotal').val()-subigv).toFixed(2);
              $("#xd").append("<table width='100%' style='font:0.9em arial;font-weight:bold;margin-top:-2px;'><tr><td width='10%'>&nbsp</td><td width='70%' id='letra'></td><td width='10%'>&nbsp</td><td align='right' width='10%'>"+subigv+"</td></tr></table>\n"+
                "<table width='100%' style='margin-top:6px;font:0.9em arial;font-weight:bold'><tr><td width='90%'></td><td align='right' width='10%'>"+igv+"</td></tr></table>\n"+
                "<table width='100%' style='margin-top:6px;font:0.9em arial;font-weight:bold'><tr><td width='59%'></td><td width='90%'></td><td align='right' width='10%'>"+parseFloat($('#subtotal').val()).toFixed(2)+"</td></tr></table></div>");
              $.ajax({
                type: "POST",
                url: "numerosaletras.php",
                data: 'b='+$('#subtotal').val(),
                success: function(data){
                  $('#letra').append(data);
                }
              });
            break;
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            case 'NOTA DE PEDIDO':
              $(this).append("<div id='xd'><table width='80%' align='center' style='margin-top:-8px;font:1.1em arial;'><tr><td width='5%'>&nbsp</td><td width='65%'>"+$('#fecha').val()+"</td><td width='10%'>Serie: </td><td width='25%' style='font-size:22px;font-weight:bold' id='serr'></td></tr></table>\n"+
                "<table width='80%' align='center' style='margin-top:-5px;font:1.1em arial;'><tr><td width='5%'>&nbsp</td><td width='60%'>"+$('#razon_social').val()+"</td><td width='10%'>Vendedor: </td><td width='25%'>"+$('#vendedor').val()+"</td></tr></table>\n"+
                "<table width='80%' align='center' style='margin-top:-5px;font:1.1em arial;'><tr><td width='5%'>&nbsp</td><td width='95%'>"+$('#direccion').val().slice(0,84)+"</td></tr></table>\n"+
                "<table width='80%' style='margin-bottom:6px;margin-top:0px'><tr><td width='5%' align='center'>&nbsp</td><td width='75%' align='center'>&nbsp</td><td width='10%' align='center'>&nbsp</td><td width='10%' align='center'>&nbsp</td></tr></table>\n"
              );
              $('#row tr').each(function(){
                $('#xd').append("<table width='78%' align='center' style='margin-top:-9px;font:1.1em arial;'><tr><td width='5%' align='right'>"+$(this).find('td:eq(2)').text()+"&nbsp&nbsp&nbsp&nbsp</td><td width='70%'>"+$(this).find('td:eq(1)').text()+"</td><td width='10%' align='right'>"+$(this).find('td:eq(3)').text()+"</td><td width='15%' align='right'>"+$(this).find('td:eq(4)').text()+"</td></tr></table>");
              });
              if($('#devolucion').val()!=0){
                $('#xd').append("<table width='78%' align='center' style='margin-top:-5px;margin-bottom:5px;font:1.1em arial;'><tr><td width='20%'>&nbsp&nbsp&nbsp&nbspDEVOLUCIONES:</td><td colspan='3' width='70%' align='right'>SUBTOTAL</td><td align='right'>"+parseFloat($('#subtotal').val()).toFixed(2)+"</td></tr></table><hr style='margin-top:-6px'>");
                $('#row1 tr').each(function(){
                  $('#xd').append("<table width='78%' align='center' style='margin-top:-9px;font:1.1em arial;'><tr><td width='5%' align='right'>"+$(this).find('td:eq(2)').text()+"&nbsp&nbsp&nbsp&nbsp</td><td width='70%'>"+$(this).find('td:eq(1)').text()+"</td><td width='10%' align='right'>"+$(this).find('td:eq(3)').text()+"</td><td width='15%' align='right'>"+$(this).find('td:eq(4)').text()+"</td></tr></table>");
                });
                $('#xd').append("<table width='78%' align='center' style='margin-top:-5px;font:1.1em arial;'><tr><td colspan='4' width='90%' align='right'>DEVOLUCION</td><td align='right'>"+parseFloat($('#devolucion').val()).toFixed(2)+"</td></tr></table>");
              }
              $('#xd').append("<table width='78%' align='center' style='margin-top:10px;font:1.1em arial;'><tr><td colspan='4' width='90%' align='right'>TOTAL</td><td align='right'>"+parseFloat($('#total').val()).toFixed(2)+"</td></tr></table>");
              $('#xd').append("<table width='78%' align='center' style='margin-top:10px;font:1.1em arial;'><tr><td width='5%'></td><td colspan='4' width='95%'>OBS: "+$('#comentario').val()+"</td></tr></table>");
            break;
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            case 'GUIA DE REMISION':
            var mm=1;
              $(this).append("<div id='xd' align='center'><table width='100%' style='margin-top:-2px;font:0.9em arial;'><tr><td width='13%'>&nbsp</td><td width='6%'>"+$('#fecha').val().slice(0,2)+"</td><td width='6%'>"+$('#fecha').val().slice(3,5)+"</td><td width='6%'>"+$('#fecha').val().slice(6,10)+"</td><td width='15%'>&nbsp</td><td width='6%'>"+$('#fecha').val().slice(0,2)+"</td><td width='6%'>"+$('#fecha').val().slice(3,5)+"</td><td width='6%'>"+$('#fecha').val().slice(6,10)+"</td><td width='36%'></td></tr></table>\n"+
                "<table width='100%' style='margin-top:19px;font:0.9em arial;'><tr><td width='5%'>&nbsp</td><td width='52%'>JR. ANCASH N° 101 - CHILCA - HUANCAYO - JUNIN</td><td width='43%'>"+$('#direccion').val()+"</td></tr></table>\n"+
                "<table width='100%' style='margin-top:51px;font:0.9em arial;'><tr><td width='20%'>&nbsp</td><td width='30%'>"+$('#razon_social').val()+"</td><td width='50%'>&nbsp</td></tr></table>\n"+
                "<table width='100%' style='margin-top:-5px;font:0.9em arial;'><tr><td width='38%'>&nbsp</td><td width='12%'>"+$('#ruc').val()+"</td><td width='50%'>&nbsp</td></tr></table>\n"+
                "<table width='100%' style='margin-bottom:34px;margin-top:0px'><tr><td width='5%' align='center'>&nbsp</td><td width='75%' align='center'>&nbsp</td><td width='10%' align='center'>&nbsp</td><td width='10%' align='center'>&nbsp</td></tr></table>\n"
              );
              $('#row tr').each(function(){
                $('#xd').append("<table width='100%' style='margin-top:-8px;font:0.9em arial;font-weight:bold'><tr height='22px'><td width='5%' align='right'>"+mm+"</td><td width='60%'>&nbsp&nbsp&nbsp"+$(this).find('td:eq(1)').text()+"&nbsp&nbsp</td><td width='10%' align='right'>&nbsp&nbsp&nbsp&nbsp"+$(this).find('td:eq(2)').text()+"</td><td width='15%' align='right'>&nbsp&nbspUND</td><td width='15%'></td></tr></table>");
                mm++;
              });
              while(v<36-parseInt($('#row tr').length)){
                $('#xd').append("<table width='100%' style='margin-top:-8px'><tr height='22px'><td>&nbsp</td></tr></table>");
                v++;
              }
              $("#xd").append("<table width='100%' style='font:0.9em arial;font-weight:bold;margin-top:20px'><tr><td width='10%'>&nbsp</td><td width='25%'>PAUL MELGAR POVEZ</td><td width='68%'></td></tr></table></div>");
            break;
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            case 'COTIZACION':
              $(this).append("<div id='xd'><div align='center'><img id='theImg' src='../producto/logo.jpg' style='width:70%;height:150px;'></div>\n"+
                "<table width='100%'><tr><td align='center' colspan='4'><span align='center'><b>COTIZACION</b></span></tr></table>\n"+
                "<table width='100%' style='margin-top:-8px'><tr><td width='10%'>RUC:</td><td width='65%'>"+$('#ruc').val()+"</td><td width='10%'>Fecha:</td><td width='15%'>"+$('#fecha').val()+"</td></tr></table>\n"+
                "<table width='100%' style='margin-top:-8px'><tr><td width='10%'>CLIENTE:</td><td width='90%'>"+$('#razon_social').val()+"</td></tr></table>\n"+
                "<table width='100%' style='margin-top:-8px'><tr><td width='10%'>DIRECCION:</td><td width='65%'>"+$('#direccion').val()+"</td><td width='10%'>Vendedor:</td><td width='15%'>"+$('#vendedor').val()+"</td></tr></table>\n"+
                "<table width='100%' style='margin-bottom:5px;margin-top:-5px'><tr bgcolor='black' style='color:white;font-weight:bold;font-size:12px;'><td width='5%' align='center'>CAN</td><td width='60%' align='center'>PRODUCTO</td><td width='10%' align='center'>P.UNITARIO</td><td width='10%' align='center'>IMPORTE</td></tr></table>\n"
              );
              $('#row tr').each(function(){
                $('#xd').append("<table width='100%' style='margin-top:-9px'><tr><td width='2%' align='center'></td><td width='5%' align='right'>"+$(this).find('td:eq(2)').text()+"&nbsp</td><td width='60%'>"+$(this).find('td:eq(1)').text()+"</td><td width='10%' align='right'>"+$(this).find('td:eq(3)').text()+"</td><td width='10%' align='right'>"+$(this).find('td:eq(4)').text()+"</td></tr></table>");
              });
              $('#xd').append("<table width='100%' style='margin-top:-5px'><tr><td width='90%' align='right'>TOTAL</td><td align='right' width='10%'>S/. "+parseFloat($('#subtotal').val()).toFixed(2)+"</td></tr></table>");
            break;
          }
        }
      });
    }
  });
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  $('#documento').change(function(){
    $('#documento').removeClass('mayorstock');
    if($('#documento').val()=='NOTA DE PEDIDO'){
      $('#devol').prop('disabled', false);
      $('#forma-pago option[value=CONTADO]').hide();
      $('#forma-pago option[value=CREDITO]').show();
      $('#forma-pago option[value=LETRA]').hide();
      $('#forma-pago option[value="NO AFECTA"]').hide();
      $('#form select[name="forma-pago"]').val('CREDITO');
      $('#form select[name="entregar"]').val('SI');
      $('#entregar option[value="NO"]').hide();
      $('#entregar option[value="SI"]').show();
      $('.notacredito').hide();
      $('.pago').show();
    }
    else if($('#documento').val()=='FACTURA INNOVA' || $('#documento').val()=='FACTURA BOOM'){
      $('#devol').prop('disabled', true);
      $('#forma-pago option[value=CONTADO]').show();
      $('#forma-pago option[value=CREDITO]').show();
      $('#forma-pago option[value=LETRA]').show();
      $('#forma-pago option[value="NO AFECTA"]').hide();
      $('#form select[name="forma-pago"]').val('CONTADO');
      $('#form select[name="entregar"]').val('NO');
      $('#entregar option[value="NO"]').show();
      $('#entregar option[value="SI"]').hide();
      $('.notacredito').hide();
      $('.pago').hide();
      $('#fechapago').val('');
      $('#acuenta').val(0);
    }
    else if($('#documento').val()=='NOTA DE CREDITO'){
      $('#devol').prop('disabled', true);
      $('#forma-pago option[value=CONTADO]').show();
      $('#forma-pago option[value=CREDITO]').show();
      $('#forma-pago option[value=LETRA]').hide();
      $('#forma-pago option[value="NO AFECTA"]').hide();
      $('#form select[name="forma-pago"]').val('CONTADO');
      $('#form select[name="entregar"]').val('NO');
      $('#entregar option[value="NO"]').show();
      $('#entregar option[value="SI"]').hide();
      
      $('.notacredito').show();

      $('.pago').hide();
      $('#fechapago').val('');
      $('#acuenta').val(0);
    }
    else{
      $('#devol').prop('disabled', true);
      $('#forma-pago option[value=CREDITO]').hide();
      $('#forma-pago option[value=CONTADO]').hide();
      $('#forma-pago option[value=LETRA]').hide();
      $('#forma-pago option[value="NO AFECTA"]').show();
      $('#form select[name="forma-pago"]').val('NO AFECTA');
      $('#form select[name="entregar"]').val('NO');
      $('#entregar option[value="NO"]').show();
      $('#entregar option[value="SI"]').hide();
      $('.notacredito').hide();
      $('.pago').hide();
      $('#fechapago').val('');
      $('#acuenta').val(0);
    }
  });

  $('#mostrarpendientes').click(function(){
    $('#pendientes').show();
    $.ajax({
      type: "POST",
      url: "pendiente.php",
      data: "",
      beforeSend:function(){
        $('#verpendientes').empty();
        $('#verpendientes').append("<table width='100%'><tr><td align='center'><img src='../loading.gif' width='400px'></td></tr></table>");
      },
      success:function(data){
        $('#verpendientes').empty();
        $('#verpendientes').append(data);
      }
    });
  });
  $('#verpendientes').on('click','.x',function(){
    var pen=$(this).parent().parent().find('td:eq(1)').text();
    $.ajax({
      type:"POST",
      url:"eliminarpedido.php",
      data:"del="+pen,
      success:function(data){
        socket.emit('notificacion',"");
        $('#mostrarpendientes').click();
      }
    });
  });
  $('#verpendientes').on('click','.imprimir1',function(){
    var pen=$(this).parent().parent().find('td:eq(1)').text();
    $.ajax({
      type:"POST",
      url:"imprimir1.php",
      dataType: "json",
      data:"del="+pen,
      success:function(data){
        $('#dx').empty();
        var contenid;
        var x1 = screen.width/2 - 1200/2;
        var y1 = screen.height/2 - 700/2;
        var w=window.open('','',"width=1200,height=600,left="+x1+",top="+y1);
        data[0].sort(function(a, b) {
                return a[3] - b[3];
            });
            $('#dx').append("<table width='80%' align='center' style='font:0.8em Verdana;'><tr><td width='100%' align='center'><b>ESTO NO ES UNA NOTA DE PEDIDO</b></td></tr></table>\n"+
              "<table width='80%' align='center' style='margin-top:-6px;font:0.8em Verdana;'><tr><td width='10%'>RUC:</td><td width='55%'>"+data[1][0]+"</td><td width='10%'>Fecha:</td><td width='25%'>"+data[1][9]+"</td></tr></table>\n"+
              "<table width='80%' align='center' style='margin-top:-6px;font:0.8em Verdana;'><tr><td width='10%'>CLIENTE:</td><td width='55%'>"+data[1][1]+"</td><td width='10%'>Vendedor:</td><td width='25%'>"+data[1][6]+"</td></tr></table>\n"+
              "<table width='80%' align='center' style='margin-top:-6px;font:0.8em Verdana;'><tr><td width='10%'>DIRECCION:</td><td width=100%' style='font-family:Agency FB'>"+data[1][2]+"</td></tr></table>\n"+
              "<table width='80%' align='center' style='margin-bottom:5px;margin-top:0px;font:0.7em Verdana;font-weight:bold;border-collapse:collapse'><tr style='border:1px solid black'><td width='10%'></td><td width='5%' align='center'>CAN</td><td width='72%' align='center'>PRODUCTO</td><td width='10%' align='center'>P.UNITARIO</td></tr></table>\n"
            );
            for (var i=0;i<data[0].length;i++) {
              $('#dx').append("<table width='80%' align='center' style='margin-top:-6px;font:0.8em Verdana;'><tr><td width='5%' align='center'><input style='width:10px;height:10px;border:1px solid black'></td><td width='5%' align='center'><input style='width:10px;height:10px;border:1px solid black'></td><td width='5%' align='right'>"+data[0][i][1]+"</td><td width='1%'></td><td width='72%'>"+data[0][i][0]+"</td><td width='10%' align='right'>"+data[0][i][2]+"</td></tr></table>");
            }
            $('#dx').append("<table width='80%' align='center' style='margin-top:-8px;font:0.9em Verdana;'><tr height='17px'><td align='right'>Total: "+data[1][5]+"</td></tr></table>");
            contenid = document.getElementById("dx");
            w.document.write("<html><head><style type='text/css'>@page{size:A4 portrait;}</style></head><body>"+contenid.innerHTML+"</body></html>");
            w.focus();
        w.print();
        setTimeout(function(){
          w.close();
          $('#mostrarpendientes').click();
        }, 200);
      }
    });
  });
  $('#verpendientes').on('click','.recibirpendiente',function(){
    if(serieventa>0){
      swal("","Cierra el pedido que pusiste EDITAR","error");
    }else{
      var pendi=$(this).parent().parent().find('td:eq(1)').text();
      $.ajax({
      type:"POST",
      url:"procesarpedido.php",
      dataType:"json",
      data:"ver="+pendi,
      success:function(data){
        credito=data[1][9];
        $('#ruc').val(data[1][0]);
        $('#razon_social').val(data[1][1]);
        $('#direccion').val(data[1][2]);
        //$('#subtotal').val(data[1][3]);
        $('#devolucion').val(data[1][4]);
        //$('#total').val(data[1][5]);
        $('#vendedor').val(data[1][6]);
        $('#comentario').val(data[1][7]);
        if (data[1][7]!='') {
          $('#comentario').addClass('mayorstock');
        }
        else{
          $('#comentario').removeClass('mayorstock');
        }
        $('#subtotal_devol').val(-data[1][4]);
        seriepedido=data[1][8];
        $('#row').empty();
        for (var i=0;i<data[0].length;i++) {
          var next= "<tr class='fila'>\n" +
                    "<td width='2%' style='padding:0px;' title='s'><img src='https://raw.githubusercontent.com/paolomelgar/www/master/huancayoprincipal/fotos/producto/a"+data[0][i][4]+".jpg?timestamp=23124' width='100%' height='100%'></td>\n"+
                    "<td width='68%' class='produ'>" + data[0][i][0] + "</td>\n"+
                    "<td width='10%' contenteditable='true' class='editme1' style='text-align:right'>" + data[0][i][1] + "</td>\n";
          if(parseFloat(data[0][i][2])<parseFloat(data[0][i][6])){
            next += "<td width='10%' contenteditable='true' class='editme2 mayorstock' style='text-align:right'>" + parseFloat(data[0][i][2]).toFixed(2) + "</td>\n";
          }else{
            next += "<td width='10%' contenteditable='true' class='editme2' style='text-align:right'>" + parseFloat(data[0][i][2]).toFixed(2) + "</td>\n";
          }
            next += "<td width='10%' align='right' style='text-align:right;'>" + data[0][i][3] + "</td>\n" +
                    "<td style='display:none'>" + data[0][i][4] +"</td>\n" +
                    "<td style='display:none'>" + data[0][i][5] +"</td>\n" +
                    "<td style='display:none'>" + data[0][i][6] +"</td>\n" +
                    "</tr>";
          $('#row').append(next);
        }
        $('#row1').empty();
        for (var i=0;i<data[2].length;i++) {
          $('#devol').removeClass('btn-info');
          $('#devol').addClass('btn-danger');
          $('#row1').append(
            "<tr class='fila'>\n" +
            "<td width='2%' style='padding:0px;' title='s'><img src='https://raw.githubusercontent.com/paolomelgar/www/master/huancayoprincipal/fotos/producto/a"+data[2][i][4]+".jpg?timestamp=23124' width='100%' height='100%'></td>\n"+
            "<td width='53%' class='produ'>" + data[2][i][0] + "</td>\n" +
            "<td width='10%' contenteditable='true' class='editme3' style='text-align:right'>" + data[2][i][1] + "</td>\n" +
            "<td width='10%' contenteditable='true' class='editme4' style='text-align:right'>" + data[2][i][2] + "</td>\n" +
            "<td width='10%' style='text-align:right'>" + data[2][i][3] + "</td>\n" +
            "<td width='15%' style='text-align:center'>" + data[2][i][6]+ "</td>\n" +
            "<td style='display:none'>" + data[2][i][4] +"</td>\n" +
            "<td style='display:none'>" + data[2][i][5] +"</td>\n" +
            "</tr>\n"
          );
        }
        $('#cantprod').empty();
        $('#cantprod').append($('#row tr').length+" Productos");
        $('#subtotal').val(parseFloat(suma()).toFixed(2));
        $('#total').val(parseFloat(parseFloat($('#subtotal').val())-parseFloat($('#subtotal_devol').val())).toFixed(2));

      }
    });
    $("#pendientes").hide();
  }
  });
  $('#salirpendientes').click(function(){
    $('#pendientes').hide();
  });

  $('#ingreso').click(function(){
    $("#dialogingresos").dialog({
      title:"REGISTRO DE INGRESOS/EGRESOS",
      width:"50%",
      modal:true,
      buttons: { 
        "Si" : function(){ 
          $.ajax({
            type:"POST",
            url:"ingresos.php",
            data:"oper="+$('#operacion').val()+
            "&tipo="+$('#tipomov').val()+
            "&monto="+$('#monto').val()+
            "&detalle="+$('#detalle').val()+
            "&transporte="+$('#transporte').val()+
            "&mediopago="+$('#mediopago').val()+
            "&personal="+$('#personal').val()+
            "&servicios="+$('#servicios').val()+
            "&transportesalida="+$('#transportesalida').val()+
            "&construccion="+$('#construccion').val()+
            "&tributarios="+$('#tributarios').val()+
            "&encar="+$('#vendedor').val(),
            success:function(data){
              swal($('#operacion').val()+" agregado Correctamente","","success");
            }
          });
          $(this).dialog( "close" ); 
        },
      },
      open: function() {
        $('#monto').val("");
        $('#detalle').val("");
        $('#personal').val("");
        $('#servicios').val("");
        $('#transportesalida').val("");
        $('#operacion').val("");
        $('#tipomov').val("");
        $('#transporte').val("");
        $('#construccion').val("");
        $('#tributarios').val("");
        $('select[id="operacion"]').val("EGRESO");
        $('.transporte').hide();
        $('.detalle').hide();
        $('.personal').hide();
        $('.servicios').hide();
        $('.construccion').hide();
        $('.transportesalida').hide();
        $('.tributarios').hide();
        $('#tipomov').change(function(){
          if($('select[id="tipomov"]').val()=='TRANSPORTE INGRESO'){
            $('.transporte').show();
            $('.detalle').hide();
            $('.personal').hide();
            $('.servicios').hide();
            $('.construccion').hide();
            $('.transportesalida').hide();
            $('.tributarios').hide();
          }else if($('select[id="tipomov"]').val()=='PERSONAL'){
            $('.detalle').hide();
            $('.personal').show();
            $('.transporte').hide();
            $('.servicios').hide();
            $('.construccion').hide();
            $('.transportesalida').hide();
            $('.tributarios').hide();
          }else if($('select[id="tipomov"]').val()=='SERVICIOS'){
            $('.detalle').hide();
            $('.personal').hide();
            $('.transporte').hide();
            $('.servicios').show();
            $('.construccion').hide();
            $('.transportesalida').hide();
            $('.tributarios').hide();
          }else if($('select[id="tipomov"]').val()=='TRANSPORTE SALIDA'){
            $('.detalle').hide();
            $('.personal').hide();
            $('.transporte').hide();
            $('.servicios').hide();
            $('.construccion').hide();
            $('.transportesalida').show();
            $('.tributarios').hide();
          }else if($('select[id="tipomov"]').val()=='CONSTRUCCION'){
            $('.detalle').hide();
            $('.personal').hide();
            $('.transporte').hide();
            $('.servicios').hide();
            $('.construccion').show();
            $('.transportesalida').hide();
            $('.tributarios').hide();
          }else if($('select[id="tipomov"]').val()=='GASTOS TRIBUTARIOS'){
            $('.detalle').hide();
            $('.personal').hide();
            $('.transporte').hide();
            $('.servicios').hide();
            $('.construccion').hide();
            $('.transportesalida').hide();
            $('.tributarios').show();
          }else{
            $('.transporte').hide();
            $('.personal').hide();
            $('.servicios').hide();
            $('.construccion').hide();
            $('.transportesalida').hide();
            $('.tributarios').hide();
            $('.detalle').show();
          }
        });
        $(this).parents('.ui-dialog-buttonpane button:hass(Si)').focus();
      }
    });
  });

  var soundFx = $('#sound');
  var not;
  $.ajax({
    type:"POST",
    url:"notificaciones.php",
    data:"",
    async: false,
    success:function(data){
      if(data>0){
        $('#mostrarpendientes').removeClass("gray");
        $('#mes').text(data);
      }else{
        $('#mostrarpendientes').addClass("gray");
      }
      not=data;
    }
  });
  socket.on('notificacion',function(data){ 
    if(data.message>not){
      $('#mostrarpendientes').show();
      soundFx[0].play();
      $('#mes').show();
      $('#mostrarpendientes').removeClass("gray");
      $('#mes').text(data.message);
      if($('#pendientes').css('display') == 'block'){
        $('#mostrarpendientes').click();
      }
    }else if(data.message>0 && data.message<=not){
      $('#mostrarpendientes').show();
      $('#mes').show();
      $('#mes').text(data.message);
      if($('#pendientes').css('display') == 'block'){
        $('#mostrarpendientes').click();
      }
    }else{
      $('#mes').hide();
      $('#mostrarpendientes').addClass("gray");
      $('#pendientes').hide();
    }
    not=data.message;
  });
  $('#efectivo').keyup(function(){
    $('#vuelto').css({"border":"1px solid red"});
    $('#vuelto').val(parseFloat($('#efectivo').val()-$('#total').val()).toFixed(2));
  });
})