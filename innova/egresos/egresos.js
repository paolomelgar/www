$(function(){
  var date = new Date();
  $('#inicio').datepicker({
    firstDay:1,
    dateFormat:'dd/mm/yy',
    monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'],
    changeMonth: true,
    changeYear: true,
    dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa']
  }).datepicker("setDate", date);
  $('#final').datepicker({
    firstDay:1,
    dateFormat:'dd/mm/yy',
    monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'],
    changeMonth: true,
    changeYear: true,
    dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa']
  }).datepicker("setDate", date);
  $('#prueba').datepicker({
    firstDay:1,
    dateFormat:'dd/mm/yy',
    monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'],
    changeMonth: true,
    changeYear: true,
    dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa']
  }).datepicker("setDate", date);
  $('#fechafactura').datepicker({
    firstDay:1,
    dateFormat:'dd/mm/yy',
    monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'],
    changeMonth: true,
    changeYear: true,
    dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa']
  }).datepicker("setDate", date);
  $("textarea").keyup(function(){
    var start = this.selectionStart,
        end = this.selectionEnd;
    $(this).val( $(this).val().toUpperCase() );
    this.setSelectionRange(start, end);
  });
  var m=date.getMonth();
  var y=date.getFullYear();
  m=("00" + m).slice (-2);
  $('select[id="month"]').val(m);
  $('select[id="year"]').val(y);
  $('#venta').tableFilter({
    filteredRows: function(filterStates) {
      var sumaingreso  = 0;
      var sumaegreso  = 0;
      $('#verbody tr').filter(":visible").each(function(){
        if($(this).find("td:eq(3)").text()=='INGRESO'){
          sumaingreso = parseFloat(sumaingreso) + parseFloat($(this).find("td:eq(5)").text());
        }
        else{
          sumaegreso = parseFloat(sumaegreso) + parseFloat($(this).find("td:eq(5)").text());        
        }
      });
      var total=parseFloat(sumaingreso)-parseFloat(sumaegreso);
      $('#total').text("S/. "+total.toFixed(2)); 
    },
    enableCookies: false
  });
  $('#myModal').modal('show');
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
            "<td width='3%' align='right'>"+(i+1)+"</td>";
            if($('#nombre').val()=='PAULO ANTONY MELGAR POVEZ' || $('#nombre').val()=='JEANIRA PEREZ'){
              n+="<td width='5%' align='center' contenteditable='true'>"+data[i][0]+"</td>\n"+
              "<td width='5%' align='center' contenteditable='true'>"+data[i][1]+"</td>\n"+
              "<td width='8%' align='center'>"+data[i][8]+"</td>\n"+
              "<td width='10%' align='center' contenteditable='true'>"+data[i][2]+"</td>\n"+
              "<td width='5%' align='right' contenteditable='true'>"+data[i][3]+"</td>\n"+
              "<td width='35%' contenteditable='true'>"+data[i][4]+"</td>";
            }else{
              n+="<td width='5%' align='center'>"+data[i][0]+"</td>\n"+
              "<td width='5%' align='center'>"+data[i][1]+"</td>\n"+
              "<td width='8%' align='center'>"+data[i][8]+"</td>\n"+
              "<td width='10%' align='center'>"+data[i][2]+"</td>\n"+
              "<td width='5%' align='right'>"+data[i][3]+"</td>\n"+
              "<td width='35%'>"+data[i][4]+"</td>";
            }
            n+="<td width='5%' align='center'>"+data[i][9]+"</td>\n"+
            "<td width='5%' align='center'>"+data[i][10]+"</td>\n"+
            "<td width='8%' align='center'>"+data[i][5]+"</td>\n"+ //usuario
            "<td width='11%' align='center'>"+data[i][6]+"</td>\n"+
            "<td style='display:none'>"+data[i][7]+"</td>\n"+
            "</tr>";
          $('#verbody').append(n);
        }
        $('#venta').tableFilterRefresh();
        $('#verbody').on('focusout','td[contenteditable=true]',function(){

          $.ajax({
                type: "POST",
                url: "modificar.php",
                data: "val="+$(this).text()+"&pos="+$(this).index()+"&id="+$(this).parent().find('td:eq(11)').text(),
                beforeSend:function(){
                },
                success: function(data){
                    $('.error').fadeIn(400).delay(2000).fadeOut(400);
                }
            });
        });
      }
    });
  }
  buscar();
  $('#buscar').click(function(){
    buscar();
  });
  $('#busc').click(function(){
    $.ajax({
      type: "POST",
      url: "estadistica.php",
      data: '&m='+$('select[id="month"]').val()+'&y='+$('select[id="year"]').val()+'&t='+$('#forma').val(),
      beforeSend:function(){
        swal({
          title: "Consultando Estadistica..",
          text: "Esto puede tardar unos Segundos",
          imageUrl: "../loading.gif",
          showConfirmButton: false
        });
      },
      success: function(data){
        swal.close();
        $("#canvas").empty();
        $("#canvas").append(data);
      }
    });
  });
  $('#busc').click();
  $('#egreso').click(function(){
    $("#dialogingresos").dialog({
      title:"REGISTRO DE INGRESOS/EGRESOS",
      width:"50%",
      modal:true,
      buttons: { 
        "Si" : function(){ 
          $.ajax({
            type:"POST",
            url:"../caja/ingresos.php",
            data:"oper="+$('#operacion').val()+
            "&tipo="+$('#tipomov').val()+
            "&mediopago="+$('#mediopago').val()+
            "&monto="+$('#monto').val()+
            "&detalle="+$('#detalle').val()+
            "&transporte="+$('#transporte').val()+
            "&personal="+$('#personal').val()+
            "&servicios="+$('#servicios').val()+
            "&tributarios="+$('#tributarios').val()+
            "&numfactura="+$('#numfactura').val()+
            "&fechafactura="+$('#fechafactura').val()+
            "&encar="+$('#vendedor').val(),
            success:function(data){
              swal($('#operacion').val()+" agregado Correctamente","","success");
              buscar();
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
        $('#operacion').val("");
        $('#tipomov').val("");
        $('#transporte').val("");
        $('#tributarios').val("");
        $('#numfactura').val("");
        $('#fechafactura').val("");
        $('select[id="operacion"]').val("EGRESO");
        $('.transporte').hide();
        $('.detalle').hide();
        $('.personal').hide();
        $('.servicios').hide();
        $('.tributarios').hide();
        $('.numfactura').hide();
        $('.fechafactura').hide();
        $('#tipomov').change(function(){
          if($('select[id="tipomov"]').val()=='TRANSPORTE INGRESO'){
            $('.transporte').show();
            $('.detalle').hide();
            $('.personal').hide();
            $('.servicios').hide();
            $('.tributarios').hide();
          }else if($('select[id="tipomov"]').val()=='PERSONAL'){
            $('.detalle').hide();
            $('.personal').show();
            $('.transporte').hide();
            $('.servicios').hide();
            $('.tributarios').hide();
          }else if($('select[id="tipomov"]').val()=='SERVICIOS'){
            $('.detalle').hide();
            $('.personal').hide();
            $('.transporte').hide();
            $('.servicios').show();
            $('.tributarios').hide();
          }else if($('select[id="tipomov"]').val()=='GASTOS TRIBUTARIOS'){
            $('.detalle').hide();
            $('.personal').hide();
            $('.transporte').hide();
            $('.servicios').hide();
            $('.tributarios').show();
          }else{
            $('.transporte').hide();
            $('.personal').hide();
            $('.servicios').hide();
            $('.tributarios').hide();
            $('.detalle').show();
          }
        });
        $('#comprobante').change(function(){
          if($('select[id="comprobante"]').val()=='SI'){
            $('.comprobantef').show();
          }else{
            $('.comprobantef').hide();
          }
        });
        $(this).parents('.ui-dialog-buttonpane button:hass(Si)').focus();
      }
    });
  });

  $('#row').on('contextmenu','.fila',function(e){
    $("#row tr").removeClass('selected1');
    $(this).addClass('selected1');
    e.preventDefault();
    if($('.selected1').find('td:eq(1)').text()!=$('#prueba').val()){
        swal("","NO SE PUEDE ELIMINAR EGRESO DE FECHA ANTERIOR","error");
    }else if($('.selected1').find('td:eq(2)').text()=='ANULADO'){
        swal("","ESTE EGRESO YA SE ELIMINÓ","error");
    }
    else{
      swal({
        title: "Esta Seguro de Eliminar?",
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
            url: "eliminar.php",
            data: 'monto='+$('.selected1').find('td:eq(4)').text()+
                  '&sesion='+$('.selected1').find('td:eq(7)').text()+
                  '&tipo='+$('.selected1').find('td:eq(2)').text()+
                  '&id='+$('.selected1').find('td:eq(11)').text()+
                  '&fecha='+$('.selected1').find('td:eq(1)').text(),
            success: function(data){
            }
          });
          $('.selected1').remove();
        } 
      });
    }
  });
   
});