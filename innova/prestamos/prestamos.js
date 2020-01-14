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
  $.ajax({
    type: "POST",
    url: "lista.php",
    data: 'ini='+$('#fechaini').val()+'&fin='+$('#fechafin').val()+'&estado=PENDIENTE',
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
    }
  });
  $('#buscar').click(function(){
    $.ajax({
      type: "POST",
      url: "lista.php",
      data: 'ini='+$('#fechaini').val()+'&fin='+$('#fechafin').val()+'&estado='+$('#estado').val(),
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
      }
    });
  });
  $('#registro').click(function(){
    $("#dialog").dialog({
      title:"REGISTRAR PRESTAMO",
      position: ['',140],
      height: 350,
      width: "40%",
      modal: true,
      buttons: { 
        "Si" : function(){
          var monto=new Array();
          var fecha=new Array();
          var i=0;
          $('#dialog div').each(function(){
            monto[i]=$(this).find('.monto').val();
            fecha[i]=$(this).find('.fech').val();
            i++;
          });
          $.ajax({
            type: "POST",
            url: "agregarprestamo.php",
            data: {monto:monto,
                  fecha:fecha,
                  total:$('#mon').val(),
                  banco:$('#banco').val(),
                  documento:$('#doc').val()
                  },
            cache: false,
            success: function(data){
              swal("Correcto!!", "Se Agrego Correctamente el Prestamo", "success");
              $.ajax({
                type: "POST",
                url: "lista.php",
                data: 'ini='+$('#fechaini').val()+'&fin='+$('#fechafin').val()+'&estado=PENDIENTE',
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
      } 
    });
  });
  $("#row").on('click','.cobrar',function(){
    var serie=$(this).parent().parent().find('td:eq(9)').text();
    var banco=$(this).parent().parent().find('td:eq(1)').text();
    var documento=$(this).parent().parent().find('td:eq(2)').text();
    var monto=$(this).parent().parent().find('td:eq(3)').text();
    var interes=$(this).parent().parent().find('td:eq(4)').text();
    swal({
      title: "Esta Seguro de Realizar el Pago!",
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
          url: "monto.php",
          data: 'id='+serie+'&banco='+banco+'&documento='+documento+'&monto='+monto+'&interes='+interes,
          success: function(data){
            $.ajax({
              type: "POST",
              url: "lista.php",
              data: 'ini='+$('#fechaini').val()+'&fin='+$('#fechafin').val()+'&estado=PENDIENTE',
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
              }
            });
          }
        });
        swal("Correcto!!", "El Pago se Realizo Correctamente", "success");
      } 
    });
  });
  $('#dialog').on('click','#add',function(){
    $('#dialog').append('<div style="margin-top:10px">MONTO: <input type="text" size="8" class="monto" style="text-align:right">FECHA PAGO: <input type="text" size="8" class="fech" style="text-align:right">&nbsp<input type="button" value="X" class="x"></div>');
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