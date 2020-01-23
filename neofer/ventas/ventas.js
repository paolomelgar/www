var socket=io.connect('http://ferreboom.com:4000');
socket.on('connect', function() {
  socket.emit('room', "Huanuco");
});
$(function(){
  var date = new Date();
  $('#fechaini').datepicker({
    firstDay:1,
    dateFormat:'dd/mm/yy',
    monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'],
    dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa']
  }).datepicker("setDate", date);
  $('#fechafin').datepicker({
    firstDay:1,
    dateFormat:'dd/mm/yy',
    monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'],
    dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa']
  }).datepicker("setDate", date);
  $('#fecha').datepicker({
    firstDay:1,
    dateFormat:'dd/mm/yy',
    monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'],
    dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa']
  }).datepicker("setDate", date);
  $("#busqueda").focus();
  var credito=0;
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
  var seriepedido=0;
  var nropedido=0;
  $('body').click(function(){
    $('#resultruc').hide();
    $('#result').hide();
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
  $('#ventas').tableFilter({
    filteredRows: function(filterStates) {
      var sumatotal  = 0;
      $('#verbody tr').filter(":visible").each(function(){
        sumatotal =  parseFloat(sumatotal) +  parseFloat($(this).find("td:eq(7)").text().slice(3));        
      });
      $('#sumatotal').text("S/ "+sumatotal.toFixed(2)); 
    },
    enableCookies: false
  });
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  var typingTimer;
  function ruc(consulta,e){
    if(e.which!=13 && e.which<37 || e.which>40){
      clearTimeout(typingTimer);
      typingTimer = setTimeout(function(){  
      $.ajax({
        type: "POST",
        url: "../caja/cliente.php",
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
    if (e.which==13) {
      if ($("#busqueda"+result).val() !=0) {
        $.ajax({
        type: "POST",
        url: "producto.php",
        data: {b:consulta},
        dataType: "json",
        cache: false,
        beforeSend:function(){
          $('#result').show();
          $('#tb1').empty();
          $('#tb1').append("<tr><td align='center'><img src='../loading.gif' width='90px'><td>Buscando...</td></td></tr>");
        },
        success: function(data){
          $("#tb1").empty();
          x=0;
          if(data!=''){
            for (var i = 0; i <= data.length-1; i++) {
              $("#tb1").append("<tr class='tr' style='font-weight:bold;'>\n"+
                                "<td style='padding:0px;' title='s'><img src='https://raw.githubusercontent.com/paolomelgar/www/master/neofer/fotos/producto/a"+data[i][7]+".jpg?timestamp=23124' width='100%' height='100%'></td>\n"+
                                "<td style='display:none;'>"+data[i][0]+"</td>\n"+
                                "<td>"+data[i][1]+"</td>\n"+
                                "<td>"+data[i][2]+"</td>\n"+
                                "<td style='display:none'>"+data[i][3]+"</td>\n"+
                                "<td style='text-align:right'>"+data[i][4]+"</td>\n"+
                                "<td style='color:red;text-align:right'>"+data[i][5]+"</td>\n"+
                                "<td style='text-align:right;background-color:#f63'>"+data[i][6]+"</td>\n"+
                              "</tr>");
            }
            $('#tb1> tr:eq(' + x + ')').addClass('selected');
          }else{
            $('#tb1').append("<tr><td style='color:red;font-weight:bold' colspan='9' align='center'>No Hay resultados para esta busqueda...</td></tr>");
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
            promotor=parseFloat($('#tb1>tr:eq('+x+')').find('td:eq(7)').text()).toFixed(2);
            unit=parseFloat($('#tb1>tr:eq('+x+')').find('td:eq(7)').text()).toFixed(2);
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
            }else{
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
      }
    }else if (e.which==38) {
      if(x>=0){
        x=x-1;
        $('#tb1> tr').removeClass('selected');
        $('#tb1> tr:eq(' + x + ')').addClass('selected');
      }
      else {
        x=x+$('#tb1 >tr').length-1;
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
    }else{
      if ($("#busqueda"+result).val() ==0) {
        $("#result").hide();
      }else{
        $('#tb1> tr').removeClass('selected');
        x=-1;
      }
    } 
  }
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
      if(unit>=promotor){
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
    if(unit>=promotor){
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
                  "<td width='2%' style='padding:0px;' title='s'><img src='https://raw.githubusercontent.com/paolomelgar/www/master/neofer/fotos/producto/a"+$("#id").val()+".jpg?timestamp=23124' width='100%' height='100%' class='img'></td>\n"+
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
        url: "../caja/buscaranterior.php",
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
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  $('#row').on('click','.editme1',function(){
    document.execCommand('selectAll', false, null);
  });
  $('#row').on('click','.editme2',function(){
    document.execCommand('selectAll', false, null);
  });
  $('#row').on('keypress','.editme1',function(e){
    $(this).val($(this).val().replace(/[^\d].+/, ""));
      if ((event.which < 48 || event.which > 57)) {
          event.preventDefault();
      }
  });
  $('#row').on('keypress','.editme2',function(e){
    $(this).val($(this).val().replace(/[^0-9\.]/g,''));
    if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
        event.preventDefault();
    }
  });
  $('#row').on('input','.editme1',function(){
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
          "  <td width='2%' style='padding:0px;' title='s'><img src='https://raw.githubusercontent.com/paolomelgar/www/master/neofer/fotos/producto/a"+$("#id1").val()+".jpg?timestamp=23124' width='100%' height='100%'></td>\n"+
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
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//https://www.xvideos.com/video35394971/sexy_casting_her_first_video_ever
  $('#row1').on('click','.editme3',function(){
    document.execCommand('selectAll', false, null);
  });
  $('#row1').on('click','.editme4',function(){
    document.execCommand('selectAll', false, null);
  });
  $('#row').on('keypress','.editme3',function(e){
    $(this).val($(this).val().replace(/[^\d].+/, ""));
      if ((event.which < 48 || event.which > 57)) {
          event.preventDefault();
      }
  });
  $('#row').on('keypress','.editme4',function(e){
    $(this).val($(this).val().replace(/[^0-9\.]/g,''));
    if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
        event.preventDefault();
    }
  });
  $('#row1').on('input','.editme3',function(){
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
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  $("#informacion").on('click','#sunat',function(data){
    swal({
      title: "Buscando en la Sunat..",
      text: "",
      imageUrl: "../loading.gif",
      showConfirmButton: false
    });
    socket.emit('sunat',$("#ruc").val());
    socket.on('sunat',function(data){ 
      $('#razon_social').val(data.razon);
      $('#direccion').val(data.direccion);
      swal.close();
    });
  });

  $('#buscar').click(function(){
    var fechaini=$('#fechaini').val();
    var fechafin=$('#fechafin').val();
    var clie=$('#clie').val();
    $.ajax({
      type: "POST",
      url: "verpedido.php",
      dataType:"json",
      data: {ini:fechaini,
             fin:fechafin,
             cliente:clie,
             ven:$('#vendedor').val()},
      beforeSend:function(){
        $('#verbody').empty();
        $('#verbody').append("<tr><td align='center' colspan='8'><img src='../loading.gif' width='420px'></td></tr>");
      },       
      success: function(data){
        $("#verbody").empty();
        for (var i = 0; i <= data.length-1; i++) {
          if(data[i][6]=='NO'){
            $("#verbody").append("<tr><td align='center' width='5%' style='color:red;font-weight:bold;cursor:pointer;border:1px solid #B1B1B1' class='visualizar'>Ver</td><td align='right' width='8%' style='border:1px solid #B1B1B1'>"+data[i][0]+"</td><td align='center' width='12%' style='border:1px solid #B1B1B1'>"+data[i][1]+"<br>"+data[i][2]+"</td><td align='center' width='15%' style='border:1px solid #B1B1B1'>"+data[i][3]+"</td><td width='30%' style='border:1px solid #B1B1B1'>"+data[i][4]+"</td><td align='center' width='10%' style='border:1px solid #B1B1B1'>"+data[i][5]+"</td><td align='center' width='10%' style='border:1px solid #B1B1B1'>"+data[i][6]+"</td><td align='right' width='10%' style='padding-right:10px;border:1px solid #B1B1B1'>S/ "+data[i][7]+"</td></tr>");
          }else if(data[i][6]=='SI'){
            $("#verbody").append("<tr><td align='center' width='5%' style='color:blue;font-weight:bold;cursor:pointer;border:1px solid #B1B1B1' class='visualizar'>Vendido</td><td align='right' width='8%' style='border:1px solid #B1B1B1'>"+data[i][0]+"</td><td align='center' width='12%' style='border:1px solid #B1B1B1'>"+data[i][1]+"<br>"+data[i][2]+"</td><td align='center' width='15%' style='border:1px solid #B1B1B1'>"+data[i][3]+"</td><td width='30%' style='border:1px solid #B1B1B1'>"+data[i][4]+"</td><td align='center' width='10%' style='border:1px solid #B1B1B1'>"+data[i][5]+"</td><td align='center' width='10%' style='border:1px solid #B1B1B1'>"+data[i][6]+"</td><td align='right' width='10%' style='padding-right:10px;border:1px solid #B1B1B1'>S/ "+data[i][7]+"</td></tr>");
          }else{
            $("#verbody").append("<tr><td align='center' width='5%' style='color:green;font-weight:bold;cursor:pointer;border:1px solid #B1B1B1' class='visualizar'>Anulado</td><td align='right' width='8%' style='border:1px solid #B1B1B1'>"+data[i][0]+"</td><td align='center' width='12%' style='border:1px solid #B1B1B1'>"+data[i][1]+"<br>"+data[i][2]+"</td><td align='center' width='15%' style='border:1px solid #B1B1B1'>"+data[i][3]+"</td><td width='30%' style='border:1px solid #B1B1B1'>"+data[i][4]+"</td><td align='center' width='10%' style='border:1px solid #B1B1B1'>"+data[i][5]+"</td><td align='center' width='10%' style='border:1px solid #B1B1B1'>"+data[i][6]+"</td><td align='right' width='10%' style='padding-right:10px;border:1px solid #B1B1B1'>S/ "+data[i][7]+"</td></tr>");
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

  var serie1;
  $('#dialogver').on('click','.visualizar',function(){
    $('#observarpedido').dialog("open");
    serie1=$(this).parent().find('td:eq(1)').text();
    $.ajax({
      type: "POST",
      url: "verlistaproductos.php",
      data: 'ver='+serie1,
      beforeSend:function(){
        $('#observarpedido').empty();
        $('#observarpedido').append("<table width='100%'><tr><td align='center'><img src='../loading.gif' width='450px'></td></tr></table>");
      },
      success: function(data){
        $('#observarpedido').empty();
        $('#observarpedido').append(data);
      }
    });
    if($(this).parent().find('td:eq(6)').text()=='SI'){
      $(".ui-dialog-buttonpane button:contains('EDITAR')").button("disable");
    }else if($(this).parent().find('td:eq(6)').text()=='NO'){
      $(".ui-dialog-buttonpane button:contains('EDITAR')").button("enable");
    }
  });

  $('#observarpedido').dialog({
    title:"LISTA PEDIDOS",
    position: [1,136],
    autoOpen:false,
    height: 480,
    width: 450,
    show: {effect: "slide",duration: 100},
    hide: {effect: "slide",duration: 100},
    buttons: { 
      "EDITAR" : function(){ 
        $.ajax({
          type: "POST",
          url: "editarpedido.php",
          dataType: "json",
          data: 'ver='+serie1,
          cache: false,
          success: function(data){
            $('#ruc').val(data[1][0]);
            $('#razon_social').val(data[1][1]);
            $('#direccion').val(data[1][2]);
            $('#subtotal').val(data[1][3]);
            $('#devolucion').val(data[1][4]);
            $('#total').val(data[1][5]);
            $('#vendedor').val(data[1][6]);
            $('#comentario').val(data[1][7]);
            $('#subtotal_devol').val(-data[1][4]);
            seriepedido=data[1][8];
            nropedido=data[1][9];
            $('#row').empty();
            for (var i=0;i<data[0].length;i++) {
              var next= "<tr class='fila'>\n" +
                        "<td width='2%' style='padding:0px;' title='s'><img src='https://raw.githubusercontent.com/paolomelgar/www/master/neofer/fotos/producto/a"+data[0][i][4]+".jpg?timestamp=23124' width='100%' height='100%'></td>\n"+
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
                "<td width='2%' style='padding:0px;' title='s'><img src='https://raw.githubusercontent.com/paolomelgar/www/master/neofer/fotos/producto/a"+data[2][i][4]+".jpg?timestamp=23124' width='100%' height='100%'></td>\n"+
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
            socket.emit('notificacion',"");
          }
        });
        $("#dialogver").hide();
        $("#observarpedido").dialog("close");
        $('#guardarform').removeClass('btn-success');
        $('#guardarform').addClass('btn-danger');
        $("#guardarform").val("EDITAR COMPROBANTE");
      }
    }
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
          url: "../caja/estadisticacliente.php",
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
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////7
  $("#guardarform").one('click',function(){
    if($('#id').val()>0 && $('#busqueda').val()!=""){
      $('#procesarenvio').dialog( "close" ); 
      swal("Hay un producto en busqueda","Debes Borrar o agregar","error");
    }else{
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
      $.ajax({
        type: "POST",
        url: "procesarpedido.php",
        data: {str:str,
              serie:seriepedido,
              nro:nropedido,
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
              compra1:compra1,
              credito:credito},
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
          socket.emit('notificacion',"Huanuco");
          swal({
            title: "Nro Pedido",
            text: "<span style='color:#F63;font-weight:bold;font-size:80px'>"+data+"</span>",
            html: true,
            imageUrl: "../correcto.jpg",
          },
          function(isConfirm){
            if (isConfirm) {
              location.reload();
            } 
          });
        }
      });
    }
  });
});

