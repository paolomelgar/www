$(function(){
  $('#fecha').datepicker({
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
  $('#fecha').datepicker('setDate', date);
  $('#fecha').change(function(){
    $('input[name=radio]').prop('checked', false);
    $('#result').empty();
    $.ajax({
      type: "POST",
      url: "dinerodeldia.php",
      dataType: "json",
      data: 'fecha='+$('#fecha').val(),
      success: function(data){
        $('#com').val(data[0].toFixed(2));
        $('#credito').val(data[1]);
        $('#ingreso').val(data[2]);
        $('#egreso').val(data[3]);
        $('#real').val(data[4]);
        $('#diferencia').val(data[5]);
        $('#total').val(parseFloat(parseFloat(data[0])+parseFloat(data[1])+parseFloat(data[2])-parseFloat(data[3])).toFixed(2));
      }
    });
  });
  $.ajax({
    type: "POST",
    url: "dinerodeldia.php",
    dataType: "json",
    data: 'fecha='+$('#fecha').val(),
    success: function(data){
      $('#com').val(data[0].toFixed(2));
      $('#credito').val(data[1]);
      $('#ingreso').val(data[2]);
      $('#egreso').val(data[3]);
      $('#real').val(data[4]);
      $('#diferencia').val(data[5]);
      $('#total').val(parseFloat(parseFloat(data[0])+parseFloat(data[1])+parseFloat(data[2])-parseFloat(data[3])).toFixed(2));
    }
  });
  $('#1').click(function(){
    $.ajax({
      type: "POST",
      url: "comprobantes.php",
      data: 'fecha='+$('#fecha').val(),
      success: function(data){
        $("#result").empty();
        $("#result").append(data);
        $('#verbody tr').each(function (){
          $(this).hover(
            function () {
              $('#verbody> tr').removeClass('selected');
              $(this).addClass('selected');
            }, 
            function () {
              $(this).removeClass('selected');
            }
          );
          $(this).click(function(){
            $("#verbody tr").removeClass('select');
            $(this).addClass('select');
          });
          $('.ver').click(function(){
            var serie=$(this).parent().parent().find('td:eq(0)').text();
            var doc=$(this).parent().parent().find('td:eq(2)').text();
            $.ajax({
              type: "POST",
              url: "productos.php",
              data: 'serie='+serie+'&doc='+doc,
              success: function(data){
                $("#productos").empty();
                $("#productos").append(data);
              }
            });
          });
        });
      }
    });
  });
  $('#2').click(function(){
    $.ajax({
      type: "POST",
      url: "credito.php",
      data: 'fecha='+$('#fecha').val(),
      success: function(data){
        $("#result").empty();
        $("#result").append(data);
        $('#verbody tr').each(function (){
          $(this).hover(
            function () {
              $('#verbody> tr').removeClass('selected');
              $(this).addClass('selected');
            }, 
            function () {
              $(this).removeClass('selected');
            }
          );
          $(this).click(function(){
            $("#verbody tr").removeClass('select');
            $(this).addClass('select');
          });
        });
      }
    });
  });
  $('#3').click(function(){
    $.ajax({
      type: "POST",
      url: "ingreso.php",
      data: 'fecha='+$('#fecha').val(),
      success: function(data){
        $("#result").empty();
        $("#result").append(data);
      }
    });
  });
  $('#4').click(function(){
    $.ajax({
      type: "POST",
      url: "egreso.php",
      data: 'fecha='+$('#fecha').val(),
      success: function(data){
        $("#result").empty();
        $("#result").append(data);
      }
    });
  });
  $('#real').keyup(function(){
    $('#diferencia').val(parseFloat(parseFloat($(this).val())-parseFloat($('#total').val())).toFixed(2));
  });
  $('#cerrar').click(function(){
    swal({
      title: "Esta Seguro de Cerrar Caja!",
      text: "",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Aceptar",
      cancelButtonText: "Cancelar",
      closeOnConfirm: false
    },
    function(isConfirm){
      if (isConfirm) {
        $.ajax({
          type: "POST",
          url: "cerrarcaja.php",
          data: 'total='+$('#total').val()+'&real='+$('#real').val()+'&diferencia='+$('#diferencia').val(),
          success: function(data){
          }
        });
        swal("Correcto!!", "La caja fue cerrado Correctamente", "success");
      }
    });
  });
});