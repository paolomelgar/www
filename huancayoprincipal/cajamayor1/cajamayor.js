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
        $('#caja').val(data[0]);
        $('#credito').val(data[1]);
        $('#ingreso').val(data[2]);
        $('#contado').val(data[3]);
        $('#proveedor').val(data[4]);
        $('#egreso').val(data[5]);
        $('#totaldia').val(parseFloat(parseFloat(data[0])+parseFloat(data[1])+parseFloat(data[2])-parseFloat(data[3])-parseFloat(data[4])-parseFloat(data[5])).toFixed(2));
        $('#total').val("");
      }
    });
  });
  $.ajax({
    type: "POST",
    url: "dinerodeldia.php",
    dataType: "json",
    data: 'fecha='+$('#fecha').val(),
    success: function(data){
      $('#caja').val(data[0]);
      $('#credito').val(data[1]);
      $('#ingreso').val(data[2]);
      $('#contado').val(data[3]);
      $('#proveedor').val(data[4]);
      $('#egreso').val(data[5]);
      $('#totaldia').val(parseFloat(parseFloat(data[0])+parseFloat(data[1])+parseFloat(data[2])-parseFloat(data[3])-parseFloat(data[4])-parseFloat(data[5])).toFixed(2));
      $('#total').val("");
    }
  });
  
  $('#1').click(function(){
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
      url: "ingreso.php",
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
      url: "contado.php",
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
            var value=$(this).parent().parent().find('td:eq(6)').text();
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
        });
      }
    });
  });
  $('#4').click(function(){
    $.ajax({
      type: "POST",
      url: "pagoproveedor.php",
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
  $('#5').click(function(){
    $.ajax({
      type: "POST",
      url: "egreso.php",
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

});