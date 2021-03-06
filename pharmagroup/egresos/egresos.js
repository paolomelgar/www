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
  $("textarea").keyup(function(){
    var start = this.selectionStart,
        end = this.selectionEnd;
    $(this).val( $(this).val().toUpperCase() );
    this.setSelectionRange(start, end);
  });
  $('#venta').tableFilter({
    filteredRows: function(filterStates) {
      var sumaingreso  = 0;
      var sumaegreso  = 0;
      $('#verbody tr').filter(":visible").each(function(){
        if($(this).find("td:eq(3)").text()=='INGRESO'){
          sumaingreso = parseFloat(sumaingreso) + parseFloat($(this).find("td:eq(4)").text());
        }
        else{
          sumaegreso = parseFloat(sumaegreso) + parseFloat($(this).find("td:eq(4)").text());        
        }
      });
      var total=parseFloat(sumaingreso)-parseFloat(sumaegreso);
      $('#total').text("S/. "+total.toFixed(2)); 
    },
    enableCookies: false
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
            "<td width='5%' align='right'>"+(i+1)+"</td>\n"+
            "<td width='8%' align='center'>"+data[i][0]+"</td>\n"+
            "<td width='8%' align='center'>"+data[i][1]+"</td>\n"+
            "<td width='10%' align='center'>"+data[i][2]+"</td>\n"+
            "<td width='5%' align='right'>"+data[i][3]+"</td>\n"+
            "<td width='39%'>"+data[i][4]+"</td>\n"+
            "<td width='8%' align='center'>"+data[i][5]+"</td>\n"+ //usuario
            "<td width='15%' align='center'>"+data[i][6]+"</td>\n"+
            "<td style='display:none'>"+data[i][7]+"</td>\n"+
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
            data:"oper="+$('#operacion').val()+"&tipo="+$('#tipomov').val()+"&monto="+$('#monto').val()+"&detalle="+$('#detalle').val()+"&transporte="+$('#transporte').val()+"&encar="+$('#vendedor').val(),
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
        $('select[id="tipomov"]').val("");
        $('select[id="operacion"]').val("EGRESO");
        $('#transporte').val("");
        $('.transporte').hide();
        $('#tipomov').change(function(){
          if($('select[id="tipomov"]').val()=='TRANSPORTE INGRESO'){
            $('.transporte').show();
          }else{
            $('.transporte').hide();
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
        swal("","No se puede eliminar egreso de fecha anterior","error");
    }else{
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
            url: "eliminar.php",
            data: 'monto='+$('.selected1').find('td:eq(4)').text()+'&sesion='+$('.selected1').find('td:eq(7)').text()+'&tipo='+$('.selected1').find('td:eq(2)').text()+'&id='+$('.selected1').find('td:eq(8)').text()+'&fecha='+$('.selected1').find('td:eq(1)').text(),
            success: function(data){
            }
          });
          $('.selected1').remove();
        } 
      });
    }
  });
   
});