$(function(){
  $('#fechaini').datepicker({
    firstDay:1,
    dateFormat:'dd/mm/yy',
    changeMonth: true,
    changeYear: true,
    monthNames: ['Enero', 'Febrero', 'Marzo',
    'Abril', 'Mayo', 'Junio',
    'Julio', 'Agosto', 'Setiembre',
    'Octubre', 'Noviembre', 'Diciembre'],
    dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa']
  });
  $('#fechafin').datepicker({
    firstDay:1,
    dateFormat:'dd/mm/yy',
    changeMonth: true,
    changeYear: true,
    monthNames: ['Enero', 'Febrero', 'Marzo',
    'Abril', 'Mayo', 'Junio',
    'Julio', 'Agosto', 'Setiembre',
    'Octubre', 'Noviembre', 'Diciembre'],
    dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa']
  });
  $("#cliente").focus();
  var date = new Date();
  $('#fechaini').datepicker('setDate', date);
  $('#fechafin').datepicker('setDate', date);
  $("input").keyup(function(){
    var start = this.selectionStart,
        end = this.selectionEnd;
    $(this).val( $(this).val().toUpperCase() );
    this.setSelectionRange(start, end);
  });
  $("input:text").focus(function(){
    $(this).select(); 
  }).click(function(){ 
    $(this).select(); 
  });
  $('#forma').change(function(){
    if($('#forma').val()!='EFECTIVO'){
      $('#banco1').css({"display":"block"});
      $('#nro1').css({"display":"block"});
    }
    else{
      $('#banco1').css({"display":"none"});
      $('#nro1').css({"display":"none"});
    }
  });
  $.ajax({
    type: "POST",
    url: "lista.php",
    data: 'proveedor='+$('#proveedor').val()+'&ini='+$('#fechaini').val()+'&fin='+$('#fechafin').val()+'&estado=PENDIENTE',
    success: function(data){
      $('#row').empty();
      $('#row').append(data);
      $("#verbody> tr").hover(
        function () {
          $('#verbody> tr').removeClass('selected');
          $(this).addClass('selected');
        }, 
        function () {
          $(this).removeClass('selected');
        }
      );
      $("#verbody tr").click(function(){
        $("#verbody tr").removeClass('select');
        $(this).addClass('select');
      });
    }
  });
  $('#buscar').click(function(){
    $.ajax({
      type: "POST",
      url: "lista.php",
      data: 'proveedor='+$('#proveedor').val()+'&ini='+$('#fechaini').val()+'&fin='+$('#fechafin').val()+'&estado='+$('#estado').val(),
      success: function(data){
        $('#row').empty();
        $('#row').append(data);
        $("#verbody> tr").hover(
          function () {
            $('#verbody> tr').removeClass('selected');
            $(this).addClass('selected');
          }, 
          function () {
            $(this).removeClass('selected');
          }
        );
        $("#verbody tr").click(function(){
          $("#verbody tr").removeClass('select');
          $(this).addClass('select');
        });
      }
    });
  });
  $("#proveedor").autocomplete({
    source:"../kardex_proveedor/proveedor.php",
    minLength:1
  });
  var value;
  var total;
  var name;
  var pendiente;
  $("#row").on('click','.detail',function(){
    value=$(this).parent().parent().find('td:eq(9)').text();
    total=$(this).parent().parent().find('td:eq(2)').text();
    name=$(this).parent().parent().find('td:eq(1)').text();
    pendiente=$(this).parent().parent().find('td:eq(3)').text();
    if($(this).parent().parent().find('td:eq(10)').text()=='SI'){
      $('.pagar').show();
      $('.cobrar').hide();
      $('#letras').hide();
      $.ajax({
        type: "POST",
        url: "adelantosletras.php",
        data: 'value='+value,
        success: function(data){
          $("#adelantos").empty();
          $("#adelantos").append(data);
        }
      });
    }
    else{
      $('.pagar').hide();
      $('.cobrar').show();
      $('#letras').show();
      $.ajax({
        type: "POST",
        url: "adelantos.php",
        data: 'value='+value,
        success: function(data){
          $("#adelantos").empty();
          $("#adelantos").append(data);
        }
      });
    }
    $.ajax({
      type: "POST",
      url: "productos.php",
      data: 'value='+value,
      success: function(data){
        $("#productos").empty();
        $("#productos").append(data);
      }
    });
  });
    $(".cobrar").on('click',function(){
      $('#monto').val("");
      $('#cambio').val("");
      if (total.slice(0,1)=='S'){
        $('#tipocambio').hide();
        pendiente=pendiente.slice(4);
      }
      else{
        $('#tipocambio').show();
        pendiente=pendiente.slice(4);
      }
      $('#name').val(name);
      $('#total').val(total);
      $('#pendiente').val(pendiente);
      $("#dialog").dialog({
        title:"PAGO PROVEEDORES",
        position: ['',140],
        height: 230,
        width: "70%",
        modal: true,
        buttons: { 
          "Si" : function(){
            $.ajax({
              type: "POST",
              url: "monto.php",
              data: 'value='+value+'&banco='+$('#banco').val()+'&nro='+$('#nro').val()+'&monto='+$('#monto').val()+'&cambio='+$('#cambio').val()+'&forma='+$('#forma').val()+'&proveedor='+$('#name').val(),
              success: function(data){
                $.ajax({
                  type: "POST",
                  url: "lista.php",
                  data: 'proveedor='+$('#proveedor').val()+'&ini='+$('#fechaini').val()+'&fin='+$('#fechafin').val()+'&estado=PENDIENTE',
                  success: function(data){
                    $('#row').empty();
                    $('#row').append(data);
                    $("#verbody> tr").hover(
                      function () {
                        $('#verbody> tr').removeClass('selected');
                        $(this).addClass('selected');
                      }, 
                      function () {
                        $(this).removeClass('selected');
                      }
                    );
                    $("#verbody tr").click(function(){
                      $("#verbody tr").removeClass('select');
                      $(this).addClass('select');
                    });
                  }
                });
              }
            });
            $( this ).dialog( "close" ); 
            $('.pagar').hide();
            $('.cobrar').hide();
            $('#letras').hide();
          },
          "No" : function(){
            $( this ).dialog( "close" );
          } 
        },
        open:function(){
          $('#monto').focus();
          $('#banco').val('');
          $('#nro').val('');
          $('#monto').val('');
          $('select[id="forma"]').val('DEPOSITO');
          $('#banco1').show();
          $('#nro1').show();
        } 
      });
    });
    $(".pagar").on('click',function(){
      $('#cambio2').val("");
      if (total.slice(0,1)=='S'){
        $('#cambio1').hide();
      }
      else{
        $('#cambio1').show();
      }
      $('#name1').val(name);
      $('#total1').val(total);
      $("#dialogpagoletra").dialog({
        title:"PAGO LETRAS",
        position: ['',140],
        width: "32%",
        modal:true,
        buttons: { 
          "Pagar" : function(){
            var monto=new Array();
            var fecha=new Array();
            var real=new Array();
            var id=new Array();
            var cambio=$('#cambio2').val();
            var i=0;    
            $('#dialogpagoletra .real').each(function(){
              if($(this).val()>0){
                monto[i]=$(this).parent().find('.monto').val();
                fecha[i]=$(this).parent().find('.fech').val();
                real[i]=$(this).val();
                id[i]=$(this).parent().find('.idd').val();
                i++;
              }
            });
            $.ajax({
              type: "POST",
              url: "montoletras.php",
              data: {monto:monto,
                    fecha:fecha,
                    real:real,
                    id:id,
                    cambio:cambio,
                    proveedor:name,
                    value:value},
              cache: false,
              success: function(data){
                $.ajax({
                  type: "POST",
                  url: "lista.php",
                  data: 'proveedor='+$('#proveedor').val()+'&ini='+$('#fechaini').val()+'&fin='+$('#fechafin').val()+'&estado=PENDIENTE',
                  success: function(data){
                    $('#row').empty();
                    $('#row').append(data);
                    $("#verbody> tr").hover(
                      function () {
                        $('#verbody> tr').removeClass('selected');
                        $(this).addClass('selected');
                      }, 
                      function () {
                        $(this).removeClass('selected');
                      }
                    );
                    $("#verbody tr").click(function(){
                      $("#verbody tr").removeClass('select');
                      $(this).addClass('select');
                    });
                  }
                });
              }
            });
            $( this ).dialog( "close" );
            $('.pagar').hide();
            $('.cobrar').hide();
            $('#letras').hide(); 
          },
          "Cancelar" : function(){
            $( this ).dialog( "close" );
          } 
        },
        open:function(){
          $('#monto').focus();
          $('#banco').val('');
          $.ajax({
            type: "POST",
            url: "verletras.php",
            dataType: "json",
            data: 'value='+value,
            success: function(data){
              $('#letras1').empty();
              for (var i=0;i<data.length;i++) {
                $('#letras1').append(
                  "<div style='margin-top:10px'>\n" +
                  "<input type='text' size='9' class='monto' value='"+data[i][0]+"' style='text-align:right'>&nbsp<input type='text' class='fech' value='"+data[i][1]+"' size='9'>&nbsp<input  style='text-align:right' type='text' class='real' size='9'><input type='hidden' class='idd' value='"+data[i][3]+"'>\n" +
                  "</div>\n"
                );
              }
              $('.fech').datepicker({
                firstDay:1,
                dateFormat:'dd/mm/yy',
                changeMonth: true,
                changeYear: true,
                monthNames: ['Enero', 'Febrero', 'Marzo',
                'Abril', 'Mayo', 'Junio',
                'Julio', 'Agosto', 'Setiembre',
                'Octubre', 'Noviembre', 'Diciembre'],
                dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa']
              });
              $('.fech').change(function(){
                var aa=$(this).parent().find('.idd').val();
                var bb=$(this).parent().find('.fech').val();
                swal({
                  title: "Esta Seguro de Cambiar Fecha!",
                  text: "La Nueva Fecha sera: "+bb,
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
                      url: "cambiarfecha.php",
                      data: {id:aa,
                             fecha:bb
                            },
                      success: function(data){
                      }
                    });
                    $('#dialogpagoletra').dialog("close");
                    $('#dialogpagoletra').dialog("open");
                  } 
                });
              });
            }
          });
        } 
      });
    });
    $('#monto').keyup(function(){
      var v=parseFloat($('#monto').val());
      if(v>parseFloat(pendiente)){
        if ($('#total').val().slice(0,1)=='S'){
        $('#monto').val($('#pendiente').val());
        }
        else{
        $('#monto').val($('#pendiente').val());
        }
      }
    });
    $('#letras').click(function(){
      $('#mon').val(total);
      var pen=pendiente.slice(0,1);
      $("#dialogletra").dialog({
        title:name,
        position: ['',140],
        height: 300,
        width: "32%",
        modal: true,
        buttons: { 
          "Si" : function(){
            var monto=new Array();
            var fecha=new Array();
            var unico=new Array();
            var i=0;
            $('#dialogletra div').each(function(){
              monto[i]=$(this).find('.monto').val();
              fecha[i]=$(this).find('.fech').val();
              unico[i]=$(this).find('.unico').val();
              i++;
            });
            $.ajax({
              type: "POST",
              url: "pagoletras.php",
              data: {monto:monto,
                    fecha:fecha,
                    unico:unico,
                    proveedor:name,
                    value:value,
                    pendiente:pen},
              cache: false,
              success: function(data){
                $.ajax({
                  type: "POST",
                  url: "lista.php",
                  data: 'proveedor='+$('#proveedor').val()+'&ini='+$('#fechaini').val()+'&fin='+$('#fechafin').val()+'&estado=PENDIENTE',
                  success: function(data){
                    $('#row').empty();
                    $('#row').append(data);
                    $("#verbody> tr").hover(
                      function () {
                        $('#verbody> tr').removeClass('selected');
                        $(this).addClass('selected');
                      }, 
                      function () {
                        $(this).removeClass('selected');
                      }
                    );
                    $("#verbody tr").click(function(){
                      $("#verbody tr").removeClass('select');
                      $(this).addClass('select');
                    });
                  }
                });
              }
            });
            $( this ).dialog( "close" ); 
          },
          "No" : function(){
            $( this ).dialog( "close" );
          }
        },
        open:function(){
          $('.x').click();
          $('#dialogletra').on('click','.x',function(){
            $('.x').parent().remove();
          });
        } 
      });
    });
  $('#dialogletra').on('click','#addletra',function(){
    $('#dialogletra').append('<div style="margin-top:10px"><input type="text" size="8" class="monto" style="text-align:right">&nbsp<input type="text" class="fech" size="9">&nbsp<input type="text" size="9" class="unico" style="text-align:right">&nbsp<input type="button" value="X" class="x"></div>');
    $('.fech').datepicker({
      firstDay:1,
      dateFormat:'dd/mm/yy',
      changeMonth: true,
      changeYear: true,
      monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'],
      dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa']
    });
    $('.x').click(function(){
      $(this).parent().remove();
    });
  });
});
