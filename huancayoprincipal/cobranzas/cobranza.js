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
    data: 'cliente='+$('#cliente').val()+'&ini='+$('#fechaini').val()+'&fin='+$('#fechafin').val()+'&estado=PENDIENTE',
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
      data: 'cliente='+$('#cliente').val()+'&ini='+$('#fechaini').val()+'&fin='+$('#fechafin').val()+'&estado='+$('#estado').val(),
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
  $("#cliente").autocomplete({
    source:"../maps/cliente.php",
    minLength:1
  });
  $("#row").on('click','.check',function(){
    if ($('.check').is(':checked')) {
      $('#juntar').show();
    }else{
      $('#juntar').hide();
    }
  });
  $('#juntar').click(function(){
    var total=0;
    var ruc;
    var p=0;
    var serie=new Array();
    $("input:checked").each(function(){
      total+=parseFloat($(this).parent().parent().find('td:eq(5)').text());
      ruc=$(this).parent().parent().find('td:eq(11)').text();
      cliente=$(this).parent().parent().find('td:eq(3)').text();
      serie[p]=$(this).parent().parent().find('td:eq(2)').text();
      p++;
    });
    $('#mon').val(total.toFixed(2));
    $('#ruc').val(ruc);
    $("#dialogletra").dialog({
        title:cliente,
        position: ['',140],
        height: 300,
        width: "32%",
        modal: true,
        buttons: { 
          "Si" : function(){
            var monto=new Array();
            var fecha=new Array();
            var factura=new Array();
            var i=0;
            $('#dialogletra div').each(function(){
              monto[i]=$(this).find('.monto').val();
              fecha[i]=$(this).find('.fech').val();
              factura[i]=$(this).find('.factura').val();
              i++;
            });
            $.ajax({
              type: "POST",
              url: "letraclientes.php",
              dataType:"json",
              data: {monto:monto,
                    fecha:fecha,
                    serie:serie,
                    factura:factura,
                    ruc:$('#ruc').val(),
                    total:total},
              cache: false,
              success: function(data){
                window.open("letrapdf.php", '_blank');
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
    $('#dialogletra').append('<div style="margin-top:10px"><input type="text" size="8" class="monto" style="text-align:right">&nbsp<input type="text" class="fech" size="9">&nbsp<input type="text" class="factura" size="9">&nbsp<input type="button" value="X" class="x"></div>');
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
    $('.x').click(function(){
      $(this).parent().remove();
    });
  });

  $("#row").on('click','.detail',function(){
    var serie=$(this).parent().parent().find('td:eq(2)').text();
    $.ajax({
      type: "POST",
      url: "productos.php",
      data: 'serie='+serie,
      success: function(data){
        $("#productos").empty();
        $("#productos").append(data);
      }
    });
    $.ajax({
      type: "POST",
      url: "adelantos.php",
      data: 'serie='+serie,
      success: function(data){
        $("#adelantos").empty();
        $("#adelantos").append(data);
      }
    });
  });
  $("#row").on('click','.detailletra',function(){
    var serie=$(this).parent().parent().find('td:eq(2)').text();
    var ccc=$(this).parent().parent().find('td:eq(3)').text();
    $.ajax({
      type: "POST",
      url: "detalleletra.php",
      data: 'serie='+serie,
      success: function(data){
        $("#productos").empty();
        $("#productos").append(data);
        $('#acordion').accordion({active: false, collapsible: true, heightStyle: "content"});
      }
    });
    $.ajax({
      type: "POST",
      url: "adelantosletra.php",
      data: 'serie='+serie,
      success: function(data){
        $("#adelantos").empty();
        $("#adelantos").append(data);
        $('#imprimir').click(function(){
          $.ajax({
            type: "POST",
            url: "printletra.php",
            dataType: "json",
            data: 'serie='+serie,
            success: function(data){
              $('#xd').empty();
              $('#xd').append("<table width='100%' style='margin-top:0px;font:1.1em Verdana;'><tr><td align='center' colspan='4'><span align='center'><b>LETRAS PENDIENTES</b></span></tr></table>\n"+
                "<table width='100%' style='margin-top:0px;font:1.1em Verdana;'><tr><td width='10%'>CLIENTE:</td><td width='90%'>"+ccc+"</td></tr></table>\n"+
                "<table width='100%' style='margin-top:0px;font:1.1em Verdana;margin-bottom:10px'><tr><td width='25%' align='center'>FECHA PAGO</td><td width='25%' align='center'>Nro FACTURA</td><td width='25%' align='center'>TOTAL</td><td width='25%' align='center'>Nro UNICO</td></tr></table>"
              );
              for (var i=0;i<data.length;i++) {
                $('#xd').append("<table width='100%' style='margin-top:-9px;font:1.1em Verdana;'><tr><td width='25%' align='center'>"+data[i][3]+"</td><td width='25%' align='center'>"+data[i][0]+"</td><td width='25%' align='center'>S/. "+data[i][1]+"</td><td width='25%' align='center'>"+data[i][2]+"</td></tr></table>");
              }
              var contenid = document.getElementById("xd");
              var x1 = screen.width/2 - 1000/2;
              var y1 = screen.height/2 - 700/2;
              var w=window.open('','',"width=1000,height=600,left="+x1+",top="+y1);
              w.document.write("<html><head><style type='text/css'>@page{size:A4 landscape;}@media print {html,body {width: 320mm;height: 150mm;margin-top:47px;margin-left:0px}}</style></head><body>"+contenid.innerHTML+"</body></html>");
              w.focus();
              w.print();
              setTimeout(function(){w.close();}, 200);
            }
          });
        });
      }
    });
  });
  $("#row").on('click','.cobrar',function(){
    var serie=$(this).parent().parent().find('td:eq(2)').text();
    $('#name').val($(this).parent().parent().find('td:eq(3)').text());
    $('#total').val($(this).parent().parent().find('td:eq(4)').text());
    $('#pendiente').val($(this).parent().parent().find('td:eq(5)').text());
    $('#monto').keyup(function(e){
      var v=parseFloat($('#monto').val());
      if(v>$('#pendiente').val()){
        $('#monto').val($('#pendiente').val());
      }
    });
    $("#dialog").dialog({
      title:"COBRO CREDITOS",
      position: ['',140],
      height: 230,
      width: "70%",
      modal: true,
      buttons: { 
        "Si" : function(){
          $.ajax({
            type: "POST",
            url: "monto.php",
            data: 'serie='+serie+'&banco='+$('#banco').val()+'&nro='+$('#nro').val()+'&monto='+$('#monto').val()+'&vendedor='+$('#vendedor').val()+'&forma='+$('#forma').val()+'&cliente='+$('#name').val(),
            success: function(data){
              $.ajax({
                type: "POST",
                url: "lista.php",
                data: 'cliente='+$('#cliente').val()+'&ini='+$('#fechaini').val()+'&fin='+$('#fechafin').val()+'&estado=PENDIENTE',
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
              $.ajax({
                type: "POST",
                url: "adelantos.php",
                data: 'serie='+serie,
                success: function(data){
                  $("#adelantos").empty();
                  $("#adelantos").append(data);
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
        $('#monto').focus();
        $('#banco').val('');
        $('#nro').val('');
        $('#monto').val('');
        $('select[id="forma"]').val('EFECTIVO');
      } 
    });
    $.ajax({
      type: "POST",
      url: "productos.php",
      data: 'serie='+serie,
      success: function(data){
        $("#productos").empty();
        $("#productos").append(data);
      }
    });
    $.ajax({
      type: "POST",
      url: "adelantos.php",
      data: 'serie='+serie,
      success: function(data){
        $("#adelantos").empty();
        $("#adelantos").append(data);
      }
    });
  });
$("#row").on('click','.cobrarletra',function(){
    var value=$(this).parent().parent().find('td:eq(2)').text();
    var name=$(this).parent().parent().find('td:eq(3)').text();
    $('#name1').val(name);
    $('#total1').val($(this).parent().parent().find('td:eq(5)').text());
    $("#dialogpagoletra").dialog({
        title:"COBRO LETRAS",
        position: ['',140],
        width: "30%",
        modal:true,
        buttons: { 
          "Cobrar" : function(){
            var monto=new Array();
            var fecha=new Array();
            var real=new Array();
            var id=new Array();
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
                    cliente:name,
                    value:value},
              cache: false,
              success: function(data){
                location.reload();
              }
            });
            $( this ).dialog( "close" );
          },
          "No" : function(){
            $( this ).dialog( "close" );
          } 
        },
        open:function(){
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
                  "<input type='text' size='9' class='monto' value='"+data[i][0]+"' style='text-align:right'>&nbsp<input type='text' class='fech' value='"+data[i][1]+"' size='9'>&nbsp<input  style='text-align:right' type='text' class='real' size='9'><input type='hidden' class='idd' value='"+data[i][2]+"'>\n" +
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
  $('#mostrarpendientes').click(function(){
    $("#pendientes").dialog({
      title:"PENDIENTE",
      position: ['',0],
      height: 400,
      width: "60%",
      modal: true,
      buttons: { 
        "Si" : function(){
          var seri=new Array();
          var ad=new Array();
          var cl=new Array();
          var i=0;
          $('#verbody1 tr').each(function(){
            seri[i]=$(this).find('td:eq(0)').text();
            ad[i]=$(this).find('td:eq(4)').text();
            cl[i]=$(this).find('td:eq(1)').text();
            i++;
          });
          $.ajax({
            type: "POST",
            url: "cobrarpromotor.php",
            data: { serie:seri,
                    monto:ad,
                    cliente:cl,
                    vendedor:$('#vend').val()
                  },
            success: function(data){
            }
          });
          $( this ).dialog( "close" ); 
        },
        "No" : function(){
          $( this ).dialog( "close" );
        }
      },
      open:function(){
        $.ajax({
          type: "POST",
          url: "vendedorpendiente.php",
          dataType: "json",
          data: '',
          success: function(data){
            $('select[id="vend"]').empty();
            $('#acuenta').empty();
            $('select[id="vend"]').append('<option>---------</option>');
            for(var i=0;i<data.length;i++){
              $('select[id="vend"]').append('<option val="'+data[i]+'">'+data[i]+'</option>');
            }
            $('#vend').change(function(){
              $.ajax({
                type: "POST",
                url: "pendientes.php",
                data: 'vendedor='+$('#vend').val(),
                success: function(data){
                  $('#acuenta').empty();
                  $('#acuenta').append(data);
                  $("#verbody1> tr").hover(
                    function () {
                      $('#verbody1> tr').removeClass('selected');
                      $(this).addClass('selected');
                    }, 
                    function () {
                      $(this).removeClass('selected');
                    }
                  );
                  $("#verbody1 tr").click(function(){
                    var ser=$(this).find('td:eq(0)').text();
                    $("#verbody1 tr").removeClass('selectc');
                    $(this).addClass('selectc');
                    $.ajax({
                      type: "POST",
                      url: "productos.php",
                      data: 'serie='+ser,
                      success: function(data){
                        $("#productos").empty();
                        $("#productos").append(data);
                      }
                    });
                    $.ajax({
                      type: "POST",
                      url: "adelantos.php",
                      data: 'serie='+ser,
                      success: function(data){
                        $("#adelantos").empty();
                        $("#adelantos").append(data);
                      }
                    });
                  });
                }
              });
            });
          }
        });
      } 
    });
  });
});