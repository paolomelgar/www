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
  $(document).tooltip({
    position: {
            my: "left top",
            at: "right+2 ",
        },
      content: function() {
        return $(this).html();
      }
  });
  $("input").keyup(function(){
      var start = this.selectionStart,
          end = this.selectionEnd;
      $(this).val( $(this).val().toUpperCase() );
      this.setSelectionRange(start, end);
    });  
  $('#serie').keydown(function(e) {
    if ((e.keyCode < 48 || e.keyCode > 57) && (e.keyCode < 96 || e.keyCode > 105) && e.keyCode != 8 && e.keyCode != 9)
        e.preventDefault();
  });
  $('#numero').keydown(function(e) {
    if ((e.keyCode < 48 || e.keyCode > 57) && (e.keyCode < 96 || e.keyCode > 105) && e.keyCode != 8 && e.keyCode != 9)
        e.preventDefault();
  });
  $('#serie').blur(function(){
    if($("#serie").val()=='' || $("#serie").val()==0)
    { $("#serie").val('')
    }else{
      var h = $("#serie").val();
      h=("00" + h).slice (-3);
      $("#serie").val(h);
    }
  });
  $('#numero').blur(function(){
    if($("#numero").val()=='' || $("#numero").val()==0)
    { $("#numero").val('')
    }else{
      var h = $("#numero").val();
      h=("000000" + h).slice (-7);
      $("#numero").val(h);
    }
  });
  var serieventa=0;
  $('body').click(function(){
    $('#resultruc').hide();
    $('#result').hide();
  });
  $('#ventas').tableFilter({
    filteredRows: function(filterStates) {
      var sumatotal  = 0;
      var sumatotal1  = 0;
      $('#verbody tr').filter(":visible").each(function(){
        if($(this).find("td:eq(7)").text().slice(0,1)=='S'){
          sumatotal =  parseFloat(sumatotal) +  parseFloat($(this).find("td:eq(7)").text().slice(3));       
        }
        else{
          sumatotal1 =  parseFloat(sumatotal1) +  parseFloat($(this).find("td:eq(7)").text().slice(2));        
        }
      });
      $('#sumatotal').html("<b style='color:blue'>S/ "+sumatotal.toFixed(2)+"</b><br><b style='color:green'>$ "+sumatotal1.toFixed(2)+"</b>"); 
    },
    enableCookies: false
  });
  $('#dialogver').draggable();
  $('#dialogestadistica').draggable();
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  var typingTimer;
  function ruc(consulta,e){
    if(e.which!=13 && e.which<37 || e.which>40){
      clearTimeout(typingTimer);
      typingTimer = setTimeout(function(){  
      $.ajax({
        type: "POST",
        url: "proveedor.php",
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
            var compra=parseFloat($('#tb1>tr:eq('+x+')').find('td:eq(4)').text());
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
              $("#result"+result).hide();
              $("#busqueda"+result).focus();
            }
            else{
              anterior(id);
              $('#busqueda'+result).val(producto);
              $('#cantidad'+result).val("1");
              $('#precio_u'+result).val(compra);
              $('#importe'+result).val(compra);
              $('#id'+result).val(id);
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
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  $("#busqueda").keyup(function(e){
    var top=parseInt($(this).position().top)+30;
    var left=parseInt($(this).position().left);
    $("#result").css({"top":""+top+"px", "left":""+left+"px"});
    producto($('#busqueda').val(),e,"");
  });  
  $('#cantidad').keyup(function(e){
    $('#importe').val(parseFloat($("#precio_u").val()*$("#cantidad").val()).toFixed(2));
    if(e.which == 13) {
      $("#precio_u").focus();
    }
  });
  $('#precio_u').keyup(function(e){
    $('#importe').val(parseFloat($("#precio_u").val()*$("#cantidad").val()).toFixed(2));
    if(e.which == 13) {
      $("#importe").focus();
    }
  });
  $('#importe').keyup(function(e){
    $("#precio_u").val(parseFloat($("#importe").val()/$("#cantidad").val()).toFixed(2));
    if(e.which == 13) {
      if($('#id').val()>0){
        $('#row').append(
          "<tr class='fila'>\n" +
          "  <td width='2%' style='padding:0px;' title='s'><img src='https://raw.githubusercontent.com/paolomelgar/www/master/huanuco/fotos/producto/a"+$("#id").val()+".jpg?timestamp=23124' width='100%' height='100%' class='img'></td>\n"+
          "  <td width='66%' class='produ'>" + $("#busqueda").val() + "</td>\n"+
          "  <td width='10%' contenteditable='true' class='editme1' style='text-align:right'>" + $("#cantidad").val() + "</td>\n"+
          "  <td width='10%' contenteditable='true' class='editme2' style='text-align:right'>" + parseFloat($("#precio_u").val()).toFixed(2) + "</td>\n"+
          "  <td width='10%' contenteditable='true' class='editme3' style='text-align:right'>" + parseFloat($("#importe").val()).toFixed(2) + "</td>\n" +
          "  <td width='2%' align='right'><input type='radio' class='radio'></td>\n" +
          "  <td style='display:none'>" + $("#id").val() +"</td>\n" +
          "</tr>\n"
        );
        $('#subtotal').val(parseFloat(suma()).toFixed(2));
        $('#total').val(parseFloat(parseFloat($('#subtotal').val())+parseFloat($('#flete').val())).toFixed(2));
        $('#roww').scrollTop(1000000);
        $('#cantprod').empty();
        $('#cantprod').append($('#row tr').length+" Productos");
        $('#busqueda').val("");
        $('#cantidad').val("");
        $('#precio_u').val("");
        $('#importe').val("");
        $('#id').val("");
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
  function anterior(id){
    $.ajax({
      type: "POST",
      url: "buscaranterior.php",
      data: {id:id},
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
  } 
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  $('#row').on('click','.editme1',function(){
    document.execCommand('selectAll', false, null);
  });
  $('#row').on('click','.editme2',function(){
    document.execCommand('selectAll', false, null);
  });
  $('#row').on('click','.editme3',function(){
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
  $('#row').on('keypress','.editme3',function(e){
    $(this).val($(this).val().replace(/[^0-9\.]/g,''));
    if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
        event.preventDefault();
    }
  });
  $('#row').on('input','.editme1',function(){
    $(this).parent().find('td:eq(4)').text(parseFloat(parseFloat($(this).parent().find('td:eq(3)').text())*parseFloat($(this).text())).toFixed(2));
    $('#subtotal').val(parseFloat(suma()).toFixed(2));
    $('#total').val(parseFloat(parseFloat($('#subtotal').val())+parseFloat($('#flete').val())).toFixed(2));
  });
  $('#row').on('keyup','.editme2',function(){
    $(this).parent().find('td:eq(4)').text(parseFloat(parseFloat($(this).parent().find('td:eq(2)').text())*parseFloat($(this).text())).toFixed(2));
    $('#subtotal').val(parseFloat(suma()).toFixed(2));
    $('#total').val(parseFloat(parseFloat($('#subtotal').val())+parseFloat($('#flete').val())).toFixed(2));
  });
  $('#row').on('keyup','.editme3',function(){
    $(this).parent().find('td:eq(3)').text(parseFloat(parseFloat($(this).text())/parseFloat($(this).parent().find('td:eq(2)').text())).toFixed(2));
    $('#subtotal').val(parseFloat(suma()).toFixed(2));
    $('#total').val(parseFloat(parseFloat($('#subtotal').val())+parseFloat($('#flete').val())).toFixed(2));
  });
  $('#row').on('blur','.editme2',function(){
    $(this).next().text(parseFloat($(this).next().text()).toFixed(2));
  });
  $('#row').on('blur','.editme3',function(){
    $(this).text(parseFloat($(this).text()).toFixed(2));
  });
  $('#row').on('click','.produ',function(){
    $("#row tr").removeClass('select');
    $(this).parent().addClass('select');
    var pp=$(this).parent().find('td:eq(6)').text();
    anterior(pp);
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
        $('#total').val(parseFloat(parseFloat($('#subtotal').val())+parseFloat($('#flete').val())).toFixed(2));
        $('#cantprod').empty();
        $('#cantprod').append($('#row tr').length+" Productos");
      } 
    });
  });
//////////////////////////////////////////////////////////////////////////////////////////////////////////// 
  $("#sunat").click(function(){
    $('#dialogsunat').empty();
    $('#dialogsunat').show();
    $('#ruc').select();
    document.execCommand("copy");
    $('#dialogsunat').append("<iframe src='http://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/frameCriterioBusqueda.jsp' width='100%' height='98%' id='frameDemo'></iframe><span class='ui-icon ui-icon-circle-close' id='sal' style='position:absolute;right:0px;top:0px;cursor:pointer'>");
    $('#sal').click(function(){
      $('#dialogsunat').hide();
    });
  });
  var id;
  $('#row').on('click','.radio',function(){
    $('.radio').attr('checked',false);
    $(this).prop("checked", true);
    var prod=$(this).parent().parent().find('td:eq(1)').text();
    id=$(this).parent().parent().find('td:eq(6)').text();
    var unit=$(this).parent().parent().find('td:eq(3)').text();
    var compr;
    anterior(id);
    $("#iden").text(id);
    if($('#billete').val()=='SOLES'){
      $('#2').text(unit);
      compr=parseFloat(unit);
    }
    else{
      $('#2').text(parseFloat(parseFloat(unit)*parseFloat($('#cambio').val())).toFixed(2));
      compr=parseFloat(parseFloat(unit)*parseFloat($('#cambio').val())).toFixed(2);
    }
    $("#3").keyup(function(){
      $('#11').text(parseFloat(($(this).text()-compr)*100/compr).toFixed(2)+"%");
    });
    $("#4").keyup(function(){
      $('#12').text(parseFloat(($(this).text()-compr)*100/compr).toFixed(2)+"%");
    });
    $.ajax({
      type: "POST",
      url: "verprecios.php",
      dataType:"json",
      data: 'id='+id,
      success: function(data){
        $('#1').text(data[0]);
        $('#3').text(data[1]);
        $('#4').text(data[2]);
        $('#5').text(data[3]);
        $('#11').text(parseFloat((data[1]-compr)*100/compr).toFixed(2)+"%");
        $('#12').text(parseFloat((data[2]-compr)*100/compr).toFixed(2)+"%");
      }
    });
    $("#precios").dialog({
      title:prod,
      height: 200,
      width: "55%",
      hide: { effect: "slideUp", duration: 100 },
      show: { effect: "slideDown", duration: 100 },
      close:function(){
        $('.radio').attr('checked',false);
      }
    });
  }); 
  $('.text').on('click',function () { document.execCommand('selectAll', false, null); });
  $('#precios').on('focusout','td[contenteditable=true]',function(){
    $.ajax({
      type: "POST",
      url: "cambiarprecios.php",
      data: "val="+$(this).text()+"&pos="+$(this).index()+"&id="+id,
      success: function(data){   
          $('.error').fadeIn(400).delay(1000).fadeOut(400);
      }
    });
  });
  $('#flete').on('input',function(){
    $('#total').val(parseFloat(parseFloat($('#subtotal').val())+parseFloat($(this).val())).toFixed(2));
  });
  $("#agregar").click(function(){
    $("#agregardatos").dialog({
      title: 'Agregar Producto',
      height: 345,
      width: "30%",
      hide: { effect: "slideUp", duration: 100 },
      show: { effect: "slideDown", duration: 100 },
      modal: true,  
      buttons: [ { text: "Ok", click: function() { 
        if($('#formagregar select[name="familia"]').val()!=null){
          str = new FormData($('#formagregar')[0]);
          str.append("accion",caso);
          $.ajax({
            type: "POST",
            url: "../producto/add.php",
            data: str,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data){ 
              $('#busqueda').val($('#producto').val()+" "+$('#marca').val());                                                
            }
          });
          $( this ).dialog( "close" ); 
        }else{
          swal("","Escoger Categoria","error");
        }
      } } ],
      open:function(){
        $('#formagregar input[type="file"]').val('');
        $('#formagregar input[type="text"]').val('');
        $('#formagregar select[name="familia"]').val("");
        $('#formagregar select[name="activo1"]').val("SI");
        caso="add";
        $("#formagregar input[name='marca']").autocomplete({
          source:"../producto/marca.php",
          minLength:1
        });
        $("#formagregar input[name='producto']").autocomplete({
          source:"../producto/producto.php",
          minLength:1
        });
        function split( val ) {
          return val.split( /,\s*/ );
        }
        function extractLast( term ) {
          return split( term ).pop();
        }
        $( "#proveedor" )
        .on( "keydown", function( event ) {
            if ( event.keyCode === $.ui.keyCode.TAB &&
                $( this ).autocomplete( "instance" ).menu.active ) {
              event.preventDefault();
            }
        })
        .autocomplete({
            source: function( request, response ) {
              $.getJSON( "../producto/proveedor.php", {
                term: extractLast( request.term )
              }, response );
            },
            focus: function() {
              // prevent value inserted on focus
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
      }
    });
  });
  


  var ver;
  $('#buscar').click(function(){
    var fechaini=$('#fechaini').val();
    var fechafin=$('#fechafin').val();
    var prov=$('#prov').val();
    $.ajax({
      type: "POST",
      url: "vercompras.php",
      dataType:"json",
      data: {ini:fechaini,
             fin:fechafin,
             proveedor:prov},
      beforeSend:function(){
        $('#verbody').empty();
        $('#verbody').append("<tr><td align='center' colspan='8'><img src='../loading.gif' width='420px'></td></tr>");
      },       
      success: function(data){
        $("#verbody").empty();
        for (var i = 0; i <= data.length-1; i++) {
            var n="<tr>\n";
                    if(data[i][6]=='ANULADO'){
                    n += "<td align='center' width='5%' style='color:blue;font-weight:bold;cursor:pointer;border:1px solid #B1B1B1' class='visualizar'>Anulado</td>\n";
                    }else{   
                    n += "<td align='center' width='5%' style='color:red;font-weight:bold;cursor:pointer;border:1px solid #B1B1B1' class='visualizar'>Ver</td>\n";
                    }   
                    n += "<td align='right' width='8%' style='border:1px solid #B1B1B1'>"+data[i][0]+"</td>\n"+
                    "<td align='center' width='12%' style='border:1px solid #B1B1B1'>"+data[i][1]+"<br>"+data[i][2]+"</td>\n"+
                    "<td align='center' width='15%' style='border:1px solid #B1B1B1'>"+data[i][3]+"</td>\n"+
                    "<td width='30%' style='border:1px solid #B1B1B1'>"+data[i][4]+"</td>\n"+
                    "<td align='center' width='10%' style='border:1px solid #B1B1B1'>"+data[i][5]+"</td>\n"+
                    "<td align='center' width='10%' style='border:1px solid #B1B1B1'>"+data[i][6]+"</td>\n";
                    if(data[i][9]=='SOLES'){
                    n += "<td align='right' width='10%' style='padding-right:10px;border:1px solid #B1B1B1;color:blue'>S/ "+data[i][7]+"</td>\n";
                    }else{
                    n += "<td align='right' width='10%' style='padding-right:10px;border:1px solid #B1B1B1;color:green'>$ "+data[i][7]+"</td>\n";
                    }
                    n += "<td style='display:none'>"+data[i][8]+"</td>\n"+
                  "</tr>";
            $('#verbody').append(n);
        }
        $('#verbody> tr:odd').addClass('par');
        $('#verbody> tr:even').addClass('impar');
        $('#ventas').tableFilterRefresh();
      }
    });
  });
  $("#ver").click(function(){
    $('#prov').focus();
    $("#prov").autocomplete({
      source:"../kardex_proveedor/proveedor.php",
      minLength:1
    });
    $("#dialogver").show();
    $('#buscar').click();
  });
  var value;
  $('#dialogver').on('click','.visualizar',function(){
    $( '#observarpedido' ).dialog( "open" );
    value=$(this).parent().find('td:eq(8)').text();
    doc=$(this).parent().find('td:eq(3)').text();
    if($('#cargo').val()!='CAJERO'){
      if($(this).parent().find('td:eq(6)').text()=='ANULADO'){
        $(".ui-dialog-buttonpane button:contains('ELIMINAR')").button("disable");
      }else{
        $(".ui-dialog-buttonpane button:contains('ELIMINAR')").button("enable");
      }
    }else{
      $(".ui-dialog-buttonpane button:contains('ELIMINAR')").button("disable");
      $(".ui-dialog-buttonpane button:contains('EDITAR')").button("disable");
    }
    $.ajax({
      type: "POST",
      url: "verlistaproductos.php",
      data: 'value='+value,
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
  $('#observarpedido').dialog({
    title:"LISTA PEDIDOS",
    position: [1,166],
    autoOpen:false,
    height: 480,
    width: 450,
    show: {
    effect: "slide",
    duration: 100
    },
    hide: {
      effect: "slide",
      duration: 100
    },
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
              data: 'value='+value+'&doc='+doc,
              success: function(data){
                serieventa=0;
                $('#buscar').click();
              }
            });
          } 
        });
      },
      "VER" : function(){
        $.ajax({
          type: "POST",
          url: "vercomprobantes.php",
          dataType: "json",
          data: 'value='+value,
          success: function(data){
            serieventa=0;
            $('#ruc').val(data[1][0]);
            $('#razon_social').val(data[1][1]);
            $('#direccion').val(data[1][2]);
            $('#subtotal').val(data[1][5]);
            $('#flete').val(data[1][6]);
            $('#total').val(data[1][7]);
            if(data[1][15]=='DOLARES'){
              $('select[id="billete"]').val(data[1][15]);
              $('#cambio').val(data[1][16]).show();
            }
            else{
              $('select[id="billete"]').val(data[1][15]);
              $('#cambio').val('').hide();
            }
            $('#row').empty();
            for (var i=0;i<data[0].length;i++) {
              $('#row').append(
                "<tr class='fila'>\n" +
                "  <td width='2%' style='padding:0px;' title='s'><img src='https://raw.githubusercontent.com/paolomelgar/www/master/huanuco/fotos/producto/a"+data[0][i][4]+".jpg?timestamp=23124' width='100%' height='100%' class='img'></td>\n"+
                "  <td width='66%' class='produ'>" + data[0][i][0] + "</td>\n"+
                "  <td width='10%' contenteditable='true' class='editme1' style='text-align:right'>" + data[0][i][1] + "</td>\n"+
                "  <td width='10%' contenteditable='true' class='editme2' style='text-align:right'>" + data[0][i][2] + "</td>\n"+
                "  <td width='10%' contenteditable='true' class='editme3' style='text-align:right'>" + data[0][i][3] + "</td>\n" +
                "  <td width='2%' align='right'><input type='radio' class='radio'></td>\n" +
                "  <td style='display:none'>" + data[0][i][4] +"</td>\n" +
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
      },
      "EDITAR" : function(){
        $.ajax({
          type: "POST",
          url: "vercomprobantes.php",
          dataType: "json",
          data: 'value='+value,
          success: function(data){
            serieventa=value;
            $('#forma-pago option[value=CONTADO]').show();
            $('#forma-pago option[value=CREDITO]').show();
            $('#ruc').val(data[1][0]);
            $('#razon_social').val(data[1][1]);
            $('#direccion').val(data[1][2]);
            if(data[1][17]=='NO'){
              $('form select[name="entregado"]').val('NO');
            }else{
              $('form select[name="entregado"]').val('SI');
            }
            $('#subtotal').val(data[1][5]);
            $('#flete').val(data[1][6]);
            $('#total').val(data[1][7]);
            $('#comentario').val(data[1][14]);
            $('#serie').val(data[1][10]);
            $('#numero').val(data[1][11]);
            $('#form select[name="documento"]').val(data[1][8]);
            if(data[1][8]=='NOTA DE PEDIDO'){
              $('#serie').hide();
              $('#numero').hide();
            }else{
              $('#serie').show();
              $('#numero').show();
            }
            if(data[1][9]=='CREDITO'){
              $('#form select[name="forma-pago"]').val(data[1][9]);
              $('.pago').show();
              $('#fechapago').val(data[1][12]);
            }else{
              $('#form select[name="forma-pago"]').val(data[1][9]);
              $('.pago').hide();
              $('#fechapago').val('');
            }
            if(data[1][15]=='DOLARES'){
              $('select[id="billete"]').val(data[1][15]);
              $('#cambio').val(data[1][16]).show();
            }else{
              $('select[id="billete"]').val(data[1][15]);
              $('#cambio').val('').hide();
            }
            $('#fecha').val(data[1][13]);
            $('#row').empty();
            for (var i=0;i<data[0].length;i++) {
              $('#row').append(
                "<tr class='fila'>\n" +
                "  <td width='2%' style='padding:0px;' title='s'><img src='https://raw.githubusercontent.com/paolomelgar/www/master/huanuco/fotos/producto/a"+data[0][i][4]+".jpg?timestamp=23124' width='100%' height='100%' class='img'></td>\n"+
                "  <td width='66%' class='produ'>" + data[0][i][0] + "</td>\n"+
                "  <td width='10%' contenteditable='true' class='editme1' style='text-align:right'>" + data[0][i][1] + "</td>\n"+
                "  <td width='10%' contenteditable='true' class='editme2' style='text-align:right'>" + data[0][i][2] + "</td>\n"+
                "  <td width='10%' contenteditable='true' class='editme3' style='text-align:right'>" + data[0][i][3] + "</td>\n" +
                "  <td width='2%' align='right'><input type='radio' class='radio'></td>\n" +
                "  <td style='display:none'>" + data[0][i][4] +"</td>\n" +
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
  });
  var barChart;
  var nn=0;
  $("#estadistica").click(function(){
    $("#clienteestadistica").autocomplete({
      source:"../kardex_proveedor/proveedor.php",
      minLength:1,
      select: function (e,ui) {
        nn++;
        if(nn>1){barChart.destroy();}
        cliente=ui.item.value;
        $.ajax({
          type: "POST",
          url: "estadisticaproveedor.php",
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
              scaleFontColor: "#000"
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
  $("#salir").click(function(){
    $("#dialogver").hide();
    $("#observarpedido").dialog("close");
  });
  $("#salir2").click(function(){
    $("#dialogestadistica").hide();
  });
  $("a.external").click(function(){
      url = $(this).attr("href");
      window.open(url, '_blank');
      return false;
   });
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  $('#loading').dialog({
    autoOpen:false,
    modal:true
  });
  $('#billete').change(function(){
    if($('#billete').val()=='DOLARES'){
      $('#cambio').show();
    }
    else{
      $('#cambio').hide();
    }
  });
  $("#guardarform").click(function(){
    if($('#documento').val()==0){
      swal("","Escoger el Tipo de Documento","error");
      $('#documento').addClass('mayorstock');
    }else if($('#id').val()>0 && $('#busqueda').val()!=""){
      swal("Hay un producto en busqueda","Debes Borrar o agregar","error");
    }
    else{
      swal({
        title: "Esta Seguro de Realizar la Compra!!",
        text: "",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Aceptar",
        cancelButtonText: "Cancelar"
      },
      function(isConfirm){
        if (isConfirm) {
          var str = $('#form').serializeArray();
          var producto=new Array();
          var cantidad=new Array();
          var precio_u=new Array();
          var importe=new Array();
          var id=new Array();
          var i=0;
          $('#row tr').each(function(){
            producto[i]=$(this).find('td:eq(1)').text();
            cantidad[i]=$(this).find('td:eq(2)').text();
            precio_u[i]=$(this).find('td:eq(3)').text();
            importe[i]=$(this).find('td:eq(4)').text();
            id[i]=$(this).find('td:eq(6)').text();
            i++;
          });
          var contenido;
          if($('#fechapago').val()!='' || $('#forma-pago').val()!='CREDITO'){
            $.ajax({
              type: "POST",
              url: "procesarcompra.php",
              data: {str:str,
                    editar:serieventa,
                    producto:producto,
                    cantidad:cantidad,
                    unitario:precio_u,
                    importe:importe,
                    id:id},
              cache: false,
              beforeSend:function(){
                $('#loading').dialog("open");
              },
              success: function(data){
                //document.write(data);
                location.reload();
              }
            });
          }
          else{
            swal("","RELLENAR FECHA DE PAGO","error");
            $('#fechapago').addClass('mayorstock');
          }
        }
      });
    }
  });
$('#form select[name="forma-pago"]').val('');
  $('#documento').change(function(){
    $('#documento').removeClass('mayorstock');
    if($('#documento').val()=='NOTA DE PEDIDO'){
      $('#forma-pago option[value=CONTADO]').show();
      $('#forma-pago option[value=CREDITO]').show();
      $('#serie').hide();
      $('#numero').hide();
      $('#form select[name="forma-pago"]').val('CONTADO');
    }
    else if($('#documento').val()=='FACTURA'){
      $('#forma-pago option[value=CONTADO]').show();
      $('#forma-pago option[value=CREDITO]').show();
      $('#serie').show();
      $('#numero').show();
      $('#form select[name="forma-pago"]').val('CONTADO');
      $('.pago').hide();
      $('#fechapago').val('');
    }
    else{
      $('#forma-pago option[value=CONTADO]').hide();
      $('#forma-pago option[value=CREDITO]').hide();
      $('#serie').hide();
      $('#numero').hide();
      $('#form select[name="forma-pago"]').val('');
      $('.pago').hide();
      $('#fechapago').val('');
    }
  });
  $('#forma-pago').change(function(){
    if($('#forma-pago').val()=='CREDITO'){
      $('.pago').show();
    }
    else{
      $('.pago').hide();
      $('#fechapago').val('');
    }
  });
  $("#saliranterior").click(function(){
    $("#anterior").hide();
  });
});

