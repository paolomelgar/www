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
  $('#fechapago').datepicker({
    firstDay:1,
    dateFormat:'dd/mm/yy',
    monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'],
    changeMonth: true,
    changeYear: true,
    dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa']
  }).datepicker("setDate", date);
  $('#venta').tableFilter({
        filteredRows: function(filterStates) {
          var sumatotal  = 0;
          var sumapendiente = 0;
          var sumaacuenta  = 0;
          var sumatotal1  = 0;
          var sumapendiente1 = 0;
          var sumaacuenta1  = 0;
          $('#verbody tr').filter(":visible").each(function(){
            if($(this).find("td:eq(3)").text().slice(0,1)=='S'){
              sumatotal =  parseFloat(sumatotal) +  parseFloat($(this).find("td:eq(2)").text().slice(3));        
              sumapendiente =   parseFloat(sumapendiente) +  parseFloat($(this).find("td:eq(3)").text().slice(3));
              sumaacuenta =   parseFloat(sumaacuenta) +  parseFloat($(this).find("td:eq(4)").text().slice(3));
            }
            else{
              sumatotal1 =  parseFloat(sumatotal1) +  parseFloat($(this).find("td:eq(2)").text().slice(2));        
              sumapendiente1 =   parseFloat(sumapendiente1) +  parseFloat($(this).find("td:eq(3)").text().slice(2));
              sumaacuenta1 =   parseFloat(sumaacuenta1) +  parseFloat($(this).find("td:eq(4)").text().slice(2));
            }
          });
          $('#sumatotal').html("<b style='color:blue'>S/ "+sumatotal.toFixed(2)+"</b><br><b style='color:green'>$ "+sumatotal1.toFixed(2)+"</b>"); 
          $('#sumapendiente').html("<b style='color:blue'>S/ "+sumapendiente.toFixed(2)+"</b><br><b style='color:green'>$ "+sumapendiente1.toFixed(2)+"</b>"); 
          $('#sumaacuenta').html("<b style='color:blue'>S/ "+sumaacuenta.toFixed(2)+"</b><br><b style='color:green'>$ "+sumaacuenta1.toFixed(2)+"</b>"); 
        },
        enableCookies: false
      });

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
      $('.pago').show();
    }
    else{
      $('.pago').hide();
    }
  });

  function buscar(){
    var str = $('#form').serializeArray();
    $.ajax({
      type: "POST",
      dataType: "json",
      url: "lista.php",
      data: str,
      beforeSend:function(){
        swal({
          title: "Buscando Deudas..",
          text: "",
          imageUrl: "../loading.gif",
          showConfirmButton: false
        });
      },
      success: function(data){
        swal.close();
        $("#verbody").empty();
        for (var i = 0; i <= data.length-1; i++) {
          var n="<tr class='fila'\n>"+
            "<td width='11%' align='right'>"+data[i][0]+"</td>\n"+
            "<td width='24%'>"+data[i][1]+"</td>";
          if(data[i][10]=='SOLES'){
            n+="<td width='10%' align='right' style='color:blue'>S/ "+data[i][2]+"</td>\n"+
            "<td width='10%' style='background-color:#f63;color:blue;font-size:14px' align='right'>S/ "+data[i][3]+"</td>\n"+
            "<td width='10%' align='right' style='color:blue'>S/ "+data[i][4]+"</td>";
          }else{
            n+="<td width='10%' align='right' style='color:green'>$ "+data[i][2]+"</td>\n"+
            "<td width='10%' style='background-color:#f63;color:green;font-size:14px' align='right'>$ "+data[i][3]+"</td>\n"+
            "<td width='10%' align='right' style='color:green'>$ "+data[i][4]+"</td>";
          }
            n+="<td width='10%' align='center'>"+data[i][5]+"</td>\n"+
            "<td width='10%' align='center'>"+data[i][6]+"</td>\n"+
            "<td width='5%' align='center'>"+data[i][7]+"</td>\n"+
            "<td width='10%' align='center'><div style='cursor:pointer;color:red' class='detail'>"+data[i][8]+"</div></td>\n"+
            "<td style='display:none'>"+data[i][9]+"</td>\n"+
          "</tr>";
          $('#verbody').append(n);
        }
        $('#venta').tableFilterRefresh();
      }
    });
  }

  buscar();
  $('#buscar').click(function(){
    buscar();
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
    if($(this).parent().parent().find('td:eq(8)').text()=='LETRA'){
      $('#pagarletra').show();
      $('#pagar').hide();
      $('#letras').hide();
      $.ajax({
        type: "POST",
        url: "adelantosletra.php",
        data: 'value='+value,
        beforeSend:function(){
          $('#adelantos').empty();
          $('#adelantos').append("<table width='100%'><tr><td align='center'><img src='../loading.gif' width='220px'></td></tr></table>");
        },
        success: function(data){
          $("#adelantos").empty();
          $("#adelantos").append(data);
        }
      });
    }
    else{
      $('#pagarletra').hide();
      $('#pagar').show();
      $('#letras').show();
      $.ajax({
        type: "POST",
        url: "adelantos.php",
        data: 'value='+value,
        beforeSend:function(){
          $('#adelantos').empty();
          $('#adelantos').append("<table width='100%'><tr><td align='center'><img src='../loading.gif' width='220px'></td></tr></table>");
        },
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
      beforeSend:function(){
        $('#productos').empty();
        $('#productos').append("<table width='100%'><tr><td align='center'><img src='../loading.gif' width='220px'></td></tr></table>");
      },
      success: function(data){
        $("#productos").empty();
        $("#productos").append(data);
      }
    });
  });
  var pendiente1;
  $("#pagar").on('click',function(){
    if (total.slice(0,1)=='S'){
      $('.cambio').hide();
      pendiente1=pendiente.slice(3);
    }
    else{
      $('.cambio').show();
      pendiente1=pendiente.slice(2);
    }
    $('#name').val(name);
    $('#total').val(total);
    $('#pendiente').val(pendiente1);
    $("#dialog").dialog({
      title:"PAGO PROVEEDORES",
      position: ['',140],
      height: 230,
      width: "70%",
      modal: true,
      buttons: { 
        "Confirmar Pago" : function(){
          if($('#banco').val()==''){
            swal("","FALTA RELLENAR BANCO","error");
          }else if($('#nro').val()==''){
            swal("","FALTA RELLENAR NUMERO UNICO","error");
          }else{
          $.ajax({
            type: "POST",
            url: "monto.php",
            data: {value:value,
                   banco:$('#banco').val(),
                   nro:$('#nro').val(),
                   monto:$('#monto').val(),
                   cambio:$('#tipocambio').val(),
                   forma:$('#forma').val(),
                   proveedor:$('#name').val(),
                   mediopago:$('#mediopago').val(),
                   fechapago:$('#fechapago').val()
                  },
            success: function(data){
              buscar();
            }
          });
          $( this ).dialog( "close" ); 
          $('#pagarletra').hide();
          $('#pagar').hide();
          $('#letras').hide();
        }}
      },
      open:function(){
        $('#monto').focus();
        $('#banco').val('');
        $('#nro').val('');
        $('#monto').val('');
        $('#tipocambio').val('');
        $('select[id="forma"]').val('DEPOSITO');
        $('.pago').show();
      } 
    });
  });
    $("#pagarletra").on('click',function(){
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
        width: "50%",
        modal:true,
        buttons: { 
          "Si" : function(){
            var monto=new Array();
            var fecha=new Array();
            var real=new Array();
            var fechapagoo=new Array();
            var unicoo=new Array();
            var cambio=$('#cambio2').val();
            var i=0;
            $('#dialogpagoletra div').each(function(){
              monto[i]=$(this).find('.monto').val();
              fecha[i]=$(this).find('.fech').val();
              real[i]=$(this).find('.real').val();
              fechapagoo[i]=$(this).find('.fechapagoo').val();
              unicoo[i]=$(this).find('.unicoo').val();
              i++;
            });
            $.ajax({
              type: "POST",
              url: "montoletras.php",
              data: {monto:monto,
                    fecha:fecha,
                    real:real,
                    cambio:cambio,
                    proveedor:name,
                    value:value,
                    fechapagoo:fechapagoo,
                    unicoo:unicoo},
              cache: false,
              success: function(data){
                buscar();
              }
            });
            $( this ).dialog( "close" );
            $('.pagar').hide();
            $('.cobrar').hide();
            $('#letras').hide(); 
          }
        },
        open:function(){
          $('#monto').focus();
          $('#cambio2').val("");
          $.ajax({
            type: "POST",
            url: "verletras.php",
            dataType: "json",
            data: 'value='+value,
            success: function(data){
              $('#letras1').empty();
              for (var i=0;i<data.length;i++) {
                $('#letras1').append(
                  "<div style='margin-top:10px' align='center'>\n" +
                  "<input type='text' class='monto' value='"+data[i][0]+"' style='text-align:right;width:120px' readonly='readonly'>&nbsp<input type='text' class='fech' value='"+data[i][1]+"' style='text-align:right;width:120px' readonly='readonly'>&nbsp<input type='text' class='unicoo' value='"+data[i][4]+"' style='width:120px;text-align:center' readonly='readonly'>&nbsp<input  style='text-align:right;width:120px' type='text' class='real'>&nbsp<input  style='text-align:right;width:120px' type='text' class='fechapagoo'><input type='hidden' class='idd' value='"+data[i][3]+"' style='width:120px;text-align:center' readonly='readonly'>\n" +
                  "</div>\n"
                );
                $('.fechapagoo').datepicker({
                  firstDay:1,
                  dateFormat:'dd/mm/yy',
                  monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'],
                  changeMonth: true,
                  changeYear: true,
                  dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa']
                });
              }
            }
          });
        } 
      });
    });
    $('#monto').keyup(function(){
      var v=parseFloat($('#monto').val());
      if(v>parseFloat(pendiente1)){
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
                buscar();
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
    $('#dialogletra').append('<div style="margin-top:2px"><input type="text" class="monto" style="text-align:right;width:100px">&nbsp<input type="text" class="fech" style="width:100px;text-align:center">&nbsp<input type="text" class="unico" style="text-align:right;width:100px">&nbsp<input type="button" class="btn btn-danger x" value="X"></div>');
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
});
