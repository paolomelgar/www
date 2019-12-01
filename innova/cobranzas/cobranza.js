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
  $('#fechapagooo').datepicker({
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
      $('#verbody tr').filter(":visible").each(function(){
        sumatotal =  parseFloat(sumatotal) +  parseFloat($(this).find("td:eq(4)").text());        
        sumapendiente =   parseFloat(sumapendiente) +  parseFloat($(this).find("td:eq(5)").text());
        sumaacuenta =   parseFloat(sumaacuenta) +  parseFloat($(this).find("td:eq(6)").text());
      });
      $('#sumatotal').text("S/ "+sumatotal.toFixed(2)); 
      $('#sumapendiente').text("S/ "+sumapendiente.toFixed(2)); 
      $('#sumaacuenta').text("S/ "+sumaacuenta.toFixed(2)); 
    },
    enableCookies: false
  });

  $("#cliente").focus();
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
          var as;
          if(data[i][8]>60){
            as= "bgcolor='#FF8B8B'";
          }else if(data[i][8]<=60 && data[i][8]>30){
            as= "bgcolor='#EFFF82'";
          }else{
            as= "bgcolor='#74FF64'";
          }
          var n="<tr class='fila' "+as+"\n>"+
            "<td width='2%' align='center'><img src='print.png' width='18px' style='cursor:pointer' class='print'></td>\n"+
            "<td width='13%'>"+data[i][0]+"</td>\n"+
            "<td width='5%' align='right'>"+data[i][1]+"</td>\n"+
            "<td width='20%' >"+data[i][2]+"</td>\n"+
            "<td width='10%' align='right'>"+data[i][3]+"</td>\n"+
            "<td width='10%' style='background-color:#f63;color:blue;font-size:14px' align='right'>"+data[i][4]+"</td>\n"+
            "<td width='10%' align='right'>"+data[i][5]+"</td>\n"+
            "<td width='10%' align='center'>"+data[i][6]+"</td>\n"+
            "<td width='10%' align='center'>"+data[i][7]+"</td>\n"+
            "<td width='10%' align='center'><div class='detail' style='cursor:pointer;color:red'>DETALLES</div></td>\n"+
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
  $("#cliente").autocomplete({
    source:"../maps/cliente.php",
    minLength:1
  });
  $("#row").on('click','.detail',function(){
    var serie=$(this).parent().parent().find('td:eq(2)').text();
    $('#cobrar').show();
    $("#verbody tr").removeClass('select');
    $(this).parent().parent().addClass('select');
    $.ajax({
      type: "POST",
      url: "productos.php",
      data: 'serie='+serie,
      beforeSend:function(){
        $('#productos').empty();
        $('#productos').append("<table width='100%'><tr><td align='center'><img src='../loading.gif' width='220px'></td></tr></table>");
      },
      success: function(data){
        $("#productos").empty();
        $("#productos").append(data);
      }
    });
    $.ajax({
      type: "POST",
      url: "adelantos.php",
      data: 'serie='+serie,
      beforeSend:function(){
        $('#adelantos').empty();
        $('#adelantos').append("<table width='100%'><tr><td align='center'><img src='../loading.gif' width='220px'></td></tr></table>");
      },
      success: function(data){
        $("#adelantos").empty();
        $("#adelantos").append(data);
      }
    });
  });
  $("#cobrar").on('click',function(){
    var serie=$('.select').find('td:eq(2)').text();
    $('#name').val($('.select').find('td:eq(3)').text());
    $('#total').val($('.select').find('td:eq(4)').text());
    $('#pendiente').val($('.select').find('td:eq(5)').text());
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
        "Cobrar" : function(){
          if($('#banco').val()==''){
            swal("","FALTA RELLENAR BANCO","error");
          }else if($('#nro').val()==''){
            swal("","FALTA RELLENAR NUMERO UNICO","error");
          }else{
          $.ajax({
            type: "POST",
            url: "monto.php",
            data: {
                  serie:serie,
                  banco:$('#banco').val(),
                  nro:$('#nro').val(),
                  monto:$('#monto').val(),
                  // vendedor:$('#vendedor').val(),
                  forma:$('#forma').val(),
                  cliente:$('#name').val(),
                  fechapagooo:$('#fechapagooo').val()
            },
            success: function(data){
              buscar();
            }
          });
          $( this ).dialog( "close" ); 
        }}
      },
      open:function(){
        $('#monto').focus();
        $('#banco').val('');
        $('#nro').val('');
        $('#monto').val('');
        $('select[id="forma"]').val('EFECTIVO').change();
      } 
    });
  });
  $("#row").on('click','.print',function(){
    $("#verbody tr").removeClass('select');
    $(this).parent().parent().addClass('select');
    var serie=$(this).parent().parent().find('td:eq(2)').text();
    $('#dx').empty();
    $.ajax({
      type: "POST",
      url: "../caja/vercomprobantes.php",
      dataType: "json",
      data: 'serie='+serie+'&com=NOTA DE PEDIDO',
      success: function(data){
        $('#dx').append("<table width='80%' align='center' style='margin-top:-8px;font:1.1em arial;'><tr><td width='5%'>&nbsp</td><td width='60%'>"+data[1][12]+"</td><td width='10%'>Serie: </td><td width='25%' style='font-size:22px;font-weight:bold'>"+data[1][13]+"</td></tr></table>\n"+
          "<table width='80%' align='center' style='margin-top:-5px;font:1.1em arial;'><tr><td width='5%'>&nbsp</td><td width='60%'>"+data[1][1]+"</td><td width='10%'>Vendedor: </td><td width='25%'>"+data[1][6]+"</td></tr></table>\n"+
          "<table width='80%' align='center' style='margin-top:-5px;font:1.1em arial;'><tr><td width='5%'>&nbsp</td><td width='95%'>"+data[1][2].slice(0,84)+"</td></tr></table>\n"+
          "<table width='80%' style='margin-bottom:6px;margin-top:0px'><tr><td width='5%' align='center'>&nbsp</td><td width='75%' align='center'>&nbsp</td><td width='10%' align='center'>&nbsp</td><td width='10%' align='center'>&nbsp</td></tr></table>\n"
        );
        for (var i=0;i<data[0].length;i++) {
          $('#dx').append("<table width='78%' align='center' style='margin-top:-9px;font:1.1em arial;'><tr><td width='5%' align='right'>"+data[0][i][1]+"&nbsp&nbsp&nbsp&nbsp</td><td width='70%'>"+data[0][i][0]+"</td><td width='10%' align='right'>"+data[0][i][2]+"</td><td width='15%' align='right'>"+data[0][i][3]+"</td></tr></table>");
        }
        if(parseFloat(data[1][4])!=0){
          $('#dx').append("<table width='78%' align='center' style='margin-top:-5px;margin-bottom:5px;font:1.1em arial;'><tr><td width='20%'>&nbsp&nbsp&nbsp&nbspDEVOLUCIONES:</td><td colspan='3' width='70%' align='right'>SUBTOTAL</td><td align='right'>"+data[1][3]+"</td></tr></table><hr style='margin-top:-6px'>");
          for (var i=0;i<data[2].length;i++) {
            $('#dx').append("<table width='78%' align='center' style='margin-top:-9px;font:1.1em arial;'><tr><td width='5%' align='right'>"+data[2][i][1]+"&nbsp&nbsp&nbsp&nbsp</td><td width='70%'>"+data[2][i][0]+"</td><td width='10%' align='right'>"+data[2][i][2]+"</td><td width='15%' align='right'>"+data[2][i][3]+"</td></tr></table>");
          }
          $('#dx').append("<table width='78%' align='center' style='margin-top:-5px;font:1.1em arial;'><tr><td colspan='4' width='90%' align='right'>DEVOLUCION</td><td align='right'>"+data[1][4]+"</td></tr></table>");
        }
        $('#dx').append("<table width='78%' align='center' style='margin-top:10px;font:1.1em arial;'><tr><td colspan='4' width='90%' align='right'>TOTAL</td><td align='right'>"+data[1][5]+"</td></tr></table>");
        $('#dx').append("<table width='78%' align='center' style='margin-top:20px;font:1.1em arial;'><tr><td width='5%'></td><td colspan='4' width='95%'>OBS: "+data[1][7]+"</td></tr></table>");
        var contenid = document.getElementById("dx");
        var x1 = screen.width/2 - 1200/2;
        var y1 = screen.height/2 - 700/2;
        var w=window.open('','',"width=1200,height=600,left="+x1+",top="+y1);
        w.document.write("<html><head><style type='text/css'>@page{size:A4 landscape;}@media print {html,body {width: 320mm;height: 150mm;margin-top:50px;margin-left:-60px}}</style></head><body>"+contenid.innerHTML+"</body></html>");
        w.focus();
        w.print();
        setTimeout(function(){w.close();}, 200);
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
        "Confirmar Cobranza" : function(){
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
            beforeSend:function(){
              swal({
                title: "Procesando Cobranza..",
                text: "",
                imageUrl: "../loading.gif",
                showConfirmButton: false
              });
            },
            success: function(data){
              swal.close();
              $("#pendientes").dialog( "close" ); 
              buscar();
            }
          });
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
              var z=0;
              $.ajax({
                type: "POST",
                url: "pendientes.php",
                data: 'vendedor='+$('#vend').val(),
                success: function(data){
                  $('#acuenta').empty();
                  $('#acuenta').append(data);
                  $('#verbody1 tr').each(function () {
                    z+=parseFloat($(this).find('td:eq(4)').text()); 
                  });
                  $('#sumapendiente1').text(parseFloat(z).toFixed(2));
                  $("#verbody1 tr").click(function(){
                    var ser=$(this).find('td:eq(0)').text();
                    $("#verbody1 tr").removeClass('selectc');
                    $(this).addClass('selectc');
                    $.ajax({
                      type: "POST",
                      url: "productos.php",
                      data: 'serie='+ser,
                      beforeSend:function(){
                        $('#productos').empty();
                        $('#productos').append("<table width='100%'><tr><td align='center'><img src='../loading.gif' width='220px'></td></tr></table>");
                      },
                      success: function(data){
                        $("#productos").empty();
                        $("#productos").append(data);
                      }
                    });
                    $.ajax({
                      type: "POST",
                      url: "adelantos.php",
                      data: 'serie='+ser,
                      beforeSend:function(){
                        $('#adelantos').empty();
                        $('#adelantos').append("<table width='100%'><tr><td align='center'><img src='../loading.gif' width='220px'></td></tr></table>");
                      },
                      success: function(data){
                        $("#adelantos").empty();
                        $("#adelantos").append(data);
                      }
                    });
                  });
                  $("#verbody1 tr").bind("contextmenu",function(e){
                    $("#verbody1 tr").removeClass('select');
                    $(this).addClass('select');
                    var mmm=$(this).find('td:eq(6)').text();
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
                        $.ajax({
                          type: "POST",
                          url: "borrar.php",
                          data: 'id='+mmm,
                          success: function(data){
                            $('.select').remove();
                            z=0;
                            $('#verbody1 tr').each(function () {
                              z+=parseFloat($(this).find('td:eq(4)').text()); 
                            });
                            $('#sumapendiente1').text(z);
                          }
                        });
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