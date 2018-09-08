$(function(){
  $('#producto').focus();
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
  $(document).tooltip({
    position: {
            my: "left top",
            at: "right+2 ",
        },
      content: function() {
        return $(this).html();
      }
  });
  $(document).ready(function() {
        $('#venta').tableFilter({
          filteredRows: function(filterStates) {
            var sumacantidad  = 0;
            var sumatotal  = 0;
            $('#verbody tr').filter(":visible").each(function(){
              sumacantidad =   parseFloat(sumacantidad) +  parseFloat($(this).find("td:eq(4)").text());
              sumatotal =  parseFloat(sumatotal) +  parseFloat($(this).find("td:eq(6)").text());        
            });
            $('#sumacantidad').text(sumacantidad.toFixed(0)); 
            $('#sumatotal').text(sumatotal.toFixed(2)); 
          },
          enableCookies: false
        });
      });
  function buscar(){
    var str = $('#form').serialize();
    $.ajax({
      type: "POST",
      dataType:"json",
      url: "lista.php",
      data: str,
      beforeSend:function(){
        $('#verbody').empty();
        $('#verbody').append("<tr><td align='center' colspan='8'><img src='../loading.gif' width='420px'></td></tr>");
      },
      success: function(data){
        $("#verbody").empty();
        for (var i = 0; i <= data.length-1; i++) {
          $("#verbody").append("<tr class='fila'><td align='right' width='3%' style='border:1px solid #B1B1B1'>"+(i+1)+"</td><td align='center' width='12%' style='border:1px solid #B1B1B1'>"+data[i][1]+"</td><td align='right' width='8%' style='border:1px solid #B1B1B1'>"+data[i][0]+"</td><td width='40%' style='border:1px solid #B1B1B1'>"+data[i][2]+"</td><td align='right' width='6%' style='border:1px solid #B1B1B1'>"+data[i][3]+"</td><td width='8%' align='right' style='border:1px solid #B1B1B1'>"+data[i][4]+"</td><td align='right' width='8%' style='border:1px solid #B1B1B1'>"+data[i][5]+"</td><td align='center' width='15%' style='border:1px solid #B1B1B1'>"+data[i][6]+"</td><td style='display:none'>"+data[i][7]+"</td></tr>");
        }
        $('#verbody> tr:odd').addClass('par');
        $('#verbody> tr:even').addClass('impar');
        $('#venta').tableFilterRefresh();
        $('#row').on('click','.fila',function(){
          $("#row tr").removeClass('selected1');
          $(this).addClass('selected1');
        });
      }
    });
  }
  buscar();
  $('#buscar').click(function(){
    buscar();
  });
  $('#agregar').click(function(){
    $('#dialog').dialog({
      title:"AGREGAR DEVOLUCION",
      height: 500,
      width: "90%",
      hide: { effect: "slideUp", duration: 100 },
      show: { effect: "slideDown", duration: 100 },
      modal: true, 
      buttons: { 
        "Confirmar" : function(){ 
          var producto1=new Array();
          var cantidad1=new Array();
          var precio_u1=new Array();
          var estado1=new Array();
          var id1=new Array();
          var j=0;
          $('#row1 tr').each(function(){
            producto1[j]=$(this).find('td:eq(1)').text();
            cantidad1[j]=$(this).find('td:eq(2)').text();
            precio_u1[j]=$(this).find('td:eq(3)').text();
            estado1[j]=$(this).find('td:eq(5)').text();
            id1[j]=$(this).find('td:eq(6)').text();
            j++;
          });
          $.ajax({
            type: "POST",
            url: "malogrados.php",
            data:{estado1:estado1,
                  producto1:producto1,
                  cantidad1:cantidad1,
                  unitario1:precio_u1,
                  id1:id1},
            success: function(data){
              buscar();
            }
          });
          $( this ).dialog( "close" );
        }
      },
      open: function() {
        $('#row1').empty();
        $('#busqueda1').val("");
        $('#cantidad1').val("");
        $('#precio_u1').val("");
        $('#importe1').val("");
        $('select[id="estado1"]').val("");
        $('#id1').val("");
      }
    });
  });
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
var typingTimer;
  function producto(consulta,e,result){
    if(e.which!=13 && e.which<37 || e.which>40){
      clearTimeout(typingTimer);
      typingTimer = setTimeout(function(){  
      $.ajax({
        type: "POST",
        url: "../compras/producto.php",
        data: {b:consulta,
               doc:'NOTA DE PEDIDO'},
        cache: false,
        success: function(data){
          if(consulta!=''){
            $("#tb1").empty();
            $("#tb1").append(data);
            if($('#tb1 >tr').length =="0"){
              $("#result").hide();
            }else{
              $('#result').show();
            }
          }else{
            $("#result").hide();
          }
          $('#tb1> tr:even').addClass('par');
          $('#tb1> tr:odd').addClass('impar');
          $("#tb1> tr").hover(
            function () {
              $('#tb1> tr').removeClass('selected');
              $(this).addClass('selected');
              x=$(this).index();
            }, 
            function () {
              $(this).removeClass('selected');
            }
          );
          $('#tb1 tr').click(function(){
            var id=$('#tb1>tr:eq('+x+')').find('td:eq(1)').text();
            var producto=$('#tb1>tr:eq('+x+')').find('td:eq(2)').text()+" "+$('#tb1>tr:eq('+x+')').find('td:eq(3)').text();
            var compra=parseFloat($('#tb1>tr:eq('+x+')').find('td:eq(4)').text());
            $('#row'+result+' tr').each(function () {
              if(producto == $(this).find('td:eq(1)').text()){
                swal("","Este producto ya esta en la lista","error");
                $(this).addClass('mayorstock');
              }
              else{
                $(this).removeClass('mayorstock');
              }
            });
            if ($('#row'+result+' tr').hasClass('mayorstock')) {
              $('#busqueda'+result).val(consulta);
              $('#cantidad'+result).val("");
              $('#precio_u'+result).val("");
              $('#importe'+result).val("");
              $('#id'+result).val("");
              $("#result").hide();
              $("#busqueda"+result).focus();
            }
            else{
              $('#busqueda'+result).val(producto);
              $('#cantidad'+result).val("1");
              $('#precio_u'+result).val(compra);
              $('#importe'+result).val(compra);
              $('#id'+result).val(id);
              $("#result").hide();
              $("#cantidad"+result).focus();
            }
          });
        }
      });
}, 400);
      x=-1;
    }else if (e.which==38) {
      if(x>=0){
        x=x-1;
        $('#tb1> tr').removeClass('selected');
        $('#tb1> tr:eq(' + x + ')').addClass('selected');
      }
      else {
        x=x+$('#tb1 >tr').length;
        $('#tb1> tr').removeClass('selected');
        $('#tb1> tr:eq(' + x + ')').addClass('selected');
      }
    }else if (e.which==40) {
      if (x<$('#tb1 >tr').length-1) {
        x++;
        $('#tb1> tr').removeClass('selected');
        $('#tb1> tr:eq(' + x + ')').addClass('selected');
      }
      else{
        x=x-$('#tb1 >tr').length+1;
        $('#tb1> tr').removeClass('selected');
        $('#tb1> tr:eq(' + x + ')').addClass('selected');
      }
    }else if (e.which==13) {
      if ($("#busqueda"+result).val() !=0 && x>=0) {
        $('#tb1 tr').click();
      }
      else{
        $("#busqueda"+result).focus();
        $("#result").hide();
      }
    }
  }
  $('#busqueda1').keyup(function(e){
    var top=parseInt($(this).position().top)+30;
    var left=parseInt($(this).position().left);
    $("#result").css({"top":""+top+"px", "left":""+left+"px"});
    producto($('#busqueda1').val(),e,"1");
  });
  $('#cantidad1').keyup(function(e){
    $('#importe1').val(parseFloat($("#precio_u1").val()*$("#cantidad1").val()).toFixed(2));
    if(e.which == 13) {
      $("#precio_u1").focus();
    }
  });
  $('#precio_u1').keyup(function(e){
    $("#importe1").val(parseFloat($("#precio_u1").val()*$("#cantidad1").val()).toFixed(2));
    if(e.which == 13) {
      $("#importe1").focus();
    }
  });
  $('#importe1').keyup(function(e){
    $("#precio_u1").val(parseFloat($("#importe1").val()/$("#cantidad1").val()).toFixed(3));
    if(e.which == 13) {
      $("#estado1").focus();
    }
    });
  $('#estado1').on('click',function(e){
    if(e.offsetY < 0){
      if($('#id1').val()>0 && $('#estado1').val()!=""){
        $('#row1').append(
          "<tr class='fila'>\n" +
          "  <td width='2%' style='padding:0px;' title='s'><img src='https://dl.dropboxusercontent.com/u/104755692/huanuco/a"+$("#id1").val()+".jpg?timestamp=23124' width='100%' height='100%'></td>\n"+
          "  <td width='53%' class='produ'>" + $("#busqueda1").val() + "</td>\n" +
          "  <td width='10%' contenteditable='true' class='editme3' style='text-align:right'>" + $("#cantidad1").val() + "</td>\n" +
          "  <td width='10%' contenteditable='true' class='editme4' style='text-align:right'>" + parseFloat($("#precio_u1").val()).toFixed(2) + "</td>\n" +
          "  <td width='10%' style='text-align:right'>" + parseFloat($("#importe1").val()).toFixed(2) + "</td>\n" +
          "  <td width='15%' style='text-align:center'>" + $("#estado1").val()+ "</td>\n" +
          "  <td style='display:none'>" + $("#id1").val() +"</td>\n" +
          "</tr>\n"
        );
        $('#subtotal_devol').val(parseFloat(suma1()).toFixed(2));
        $('#estado1').val("");
        $('#busqueda1').val("");
        $('#cantidad1').val("");
        $('#precio_u1').val("");
        $('#importe1').val("");
        $('#id1').val("");
        $('#compra1').val("");
        $("#busqueda1").focus(); 
      }
    }else{
      //dropdown is shown
    }
  });
 function suma1(){
    var z=0;
    $('#row1 tr').each(function () {
      z+=parseFloat($(this).find('td:eq(4)').text()); 
    });
    return z;
  }
  $('#row').on('contextmenu','.fila',function(e){
    if($('#cargo').text()=='ADMIN'){
      $("#row tr").removeClass('selected1');
      $(this).addClass('selected1');
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
            url: "eliminar.php",
            data: {prod:$('.selected1').find('td:eq(3)').text(),
                   cant:$('.selected1').find('td:eq(4)').text(),
                   id:$('.selected1').find('td:eq(8)').text()},
            success: function(data){
            }
          });
          $('.selected1').remove();
        } 
      });
    }
  });
});