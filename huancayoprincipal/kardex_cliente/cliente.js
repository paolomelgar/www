$(function(){
  $('#inicio').datepicker({
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
  $('#final').datepicker({
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
  $('#inicio').datepicker('setDate', date);
  $('#final').datepicker('setDate', date);
  $("input:text").focus(function(){
    $(this).select(); 
  }).click(function(){ 
    $(this).select(); 
  });
  $.ajax({
    type: "POST",
    url: "lista.php",
    data: 'cliente='+$('#cliente').val()+'&inicio='+$('#inicio').val()+'&final='+$('#final').val()+'&change='+$('#change').val(),
    success: function(data){
      $('#row').empty();
      $('#row').append(data);
    }
  });
  $('#buscar').click(function(){
    var str = $('#form').serialize();
    $.ajax({
      type: "POST",
      url: "lista.php",
      data: str,
      success: function(data){
        $('#row').empty();
        $('#row').append(data);
      }
    });
  });
$("#row").on('mouseenter',function(){
    $('#verbody tr').each(function(){
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
        $("#row tr").removeClass('selected1');
        $(this).addClass('selected1');
      });
    });
  });
  $("#cliente").autocomplete({
    source:"cliente.php",
    minLength:1
  }); 
});