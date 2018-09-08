$(function(){
  var date= new Date();
  var m=date.getMonth();
  var y=date.getFullYear();
  m=parseInt(m)+1;
  m=("00" + m).slice (-2);
  $('select[id="month"]').val(m);
  $('select[id="year"]').val(y);
  $.ajax({
      type: "POST",
      url: "lista.php",
      data: 'm='+$('#month').val()+'&y='+$('#year').val(),
      beforeSend:function(){
        $('#body').empty();
        $('#body').append("<table width='100%'><tr><td align='center'><img src='../loading.gif'></td></tr></table>");
      },
      success: function(html){
        $('#body').empty();
        $('#body').append(html);
      }
  });
  $('#buscar').click(function(){
    $.ajax({
        type: "POST",
        url: "lista.php",
        data: 'm='+$('#month').val()+'&y='+$('#year').val(),
        beforeSend:function(){
        $('#body').empty();
        $('#body').append("<table width='100%'><tr><td align='center'><img src='../loading.gif'></td></tr></table>");
      },
        success: function(html){
          $('#body').empty();
          $('#body').append(html);
        }
    });
  });
  $( document ).tooltip({
    position: {
        my: "left top",
        at: "right+5 top-5",
      },
    content:function(){
        return this.getAttribute("title");
      }
  });
});