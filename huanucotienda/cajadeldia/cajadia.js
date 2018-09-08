$(function(){
  var date = new Date();
  $('#fecha').datepicker({
    firstDay:1,
    dateFormat:'dd/mm/yy',
    changeMonth: true,
    changeYear: true,
    monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'],
    dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa']
  }).datepicker("setDate", date);;

  $('#filter1').tableFilter({
    filteredRows: function(filterStates) {
      var sumatotal  = 0;
      $('#verbody1 tr').filter(":visible").each(function(){
        sumatotal =  parseFloat(sumatotal) +  parseFloat($(this).find("td:eq(4)").text());        
      });
      $('#total1').text("S/ "+sumatotal.toFixed(2)); 
    },
    enableCookies: false
  });
  $('#filter2').tableFilter({
    filteredRows: function(filterStates) {
      var sumatotal  = 0;
      $('#verbody2 tr').filter(":visible").each(function(){
        sumatotal =  parseFloat(sumatotal) +  parseFloat($(this).find("td:eq(3)").text());        
      });
      $('#total2').text("S/ "+sumatotal.toFixed(2)); 
    },
    enableCookies: false
  });
  $('#filter3').tableFilter({
    filteredRows: function(filterStates) {
      var sumatotal  = 0;
      $('#verbody3 tr').filter(":visible").each(function(){
        sumatotal =  parseFloat(sumatotal) +  parseFloat($(this).find("td:eq(3)").text());        
      });
      $('#total3').text("S/ "+sumatotal.toFixed(2)); 
    },
    enableCookies: false
  });
  $('#filter4').tableFilter({
    filteredRows: function(filterStates) {
      var sumatotal  = 0;
      $('#verbody4 tr').filter(":visible").each(function(){
        sumatotal =  parseFloat(sumatotal) +  parseFloat($(this).find("td:eq(3)").text());        
      });
      $('#total4').text("S/ "+sumatotal.toFixed(2)); 
    },
    enableCookies: false
  });
  function buscar(){
    $.ajax({
      type: "POST",
      url: "dinerodeldia.php",
      dataType: "json",
      data: 'fecha='+$('#fecha').val(),
      beforeSend:function(){
        swal({
          title: "Buscando..",
          text: "",
          imageUrl: "../loading.gif",
          showConfirmButton: false
        });
      },
      success: function(data){
        swal.close();
        $('#com').val(data[0]);
        $('#credito').val(data[1]);
        $('#ingreso').val(data[2]);
        $('#egreso').val(data[3]);
        $('#real').val(data[4]);
        $('#diferencia').val(data[5]);
        $('#total').val(parseFloat(parseFloat(data[0])+parseFloat(data[1])+parseFloat(data[2])-parseFloat(data[3])).toFixed(2));
      }
    });
  }
  buscar();
  $('#fecha').change(function(){
    $('.result').hide();
    $('input[name=radio]').prop('checked', false);
    $('#result').empty();
    buscar();
  });
  $('#1').click(function(){
    $.ajax({
      type: "POST",
      dataType:"json",
      url: "comprobantes.php",
      data: 'fecha='+$('#fecha').val(),
      beforeSend:function(){
        swal({
          title: "Buscando..",
          text: "",
          imageUrl: "../loading.gif",
          showConfirmButton: false
        });
      },
      success: function(data){
        $(".result").hide();
        $("#result1").show();
        $("#verbody1").empty();
        for (var i = 0; i <= data.length-1; i++) {
          var n="<tr class='fila'>\n"+
                  "<td align='center' width='10%' style='border:1px solid #B1B1B1'>"+data[i][0]+"</td>\n"+
                  "<td align='center' width='15%' style='border:1px solid #B1B1B1'>"+data[i][1]+"</td>\n"+
                  "<td align='center' width='20%' style='border:1px solid #B1B1B1'>"+data[i][2]+"</td>\n"+
                  "<td width='35%' style='border:1px solid #B1B1B1'>"+data[i][3]+"</td>\n";
                  if(data[i][5]=='ANULADO'){
                    n +=  "<td align='right' width='10%' style='border:1px solid #B1B1B1'>0.00</td>\n"+
                          "<td align='center' width='10%' style='color:blue;font-weight:bold;cursor:pointer;border:1px solid #B1B1B1' class='visualizar'>Anulado</td>\n";
                  }else if(data[i][5]=='NO'){   
                    n +=  "<td align='right' width='10%' style='border:1px solid #B1B1B1'>0.00</td>\n"+
                          "<td align='center' width='10%' style='color:green;font-weight:bold;cursor:pointer;border:1px solid #B1B1B1' class='visualizar'>No Afecta</td>\n";
                  }else{
                    n +=  "<td align='right' width='8%' style='border:1px solid #B1B1B1'>"+data[i][4]+"</td>\n"+
                          "<td align='center' width='10%' style='color:red;font-weight:bold;cursor:pointer;border:1px solid #B1B1B1' class='visualizar'>Ver</td>\n";
                  }   
                n+="</tr>";
          $('#verbody1').append(n);
        }
        $('#filter1').tableFilterRefresh();
        $('.visualizar').click(function(){
          var serie=$(this).parent().find('td:eq(0)').text();
          var doc=$(this).parent().find('td:eq(2)').text();
          $.ajax({
            type: "POST",
            url: "productos.php",
            data: 'serie='+serie+'&doc='+doc,
            beforeSend:function(){
              $('#productos').empty();
              $('#productos').append("<table width='100%'><tr><td align='center'><img src='../loading.gif' width='400px'></td></tr></table>");
            },
            success: function(data){
              $("#productos").empty();
              $("#productos").append(data);
            }
          });
        });
        swal.close();
      }
    });
  });
  $('#2').click(function(){
    $.ajax({
      type: "POST",
      dataType:"json",
      url: "credito.php",
      data: 'fecha='+$('#fecha').val(),
      beforeSend:function(){
        swal({
          title: "Buscando..",
          text: "",
          imageUrl: "../loading.gif",
          showConfirmButton: false
        });
      },
      success: function(data){
        $(".result").hide();
        $("#result2").show();
        $("#verbody2").empty();
        for (var i = 0; i <= data.length-1; i++) {
          var n="<tr class='fila'>\n"+
                  "<td align='center' width='15%' style='border:1px solid #B1B1B1'>"+data[i][0]+"</td>\n"+
                  "<td align='center' width='20%' style='border:1px solid #B1B1B1'>"+data[i][1]+"</td>\n"+
                  "<td width='45%' style='border:1px solid #B1B1B1'>"+data[i][2]+"</td>\n"+
                  "<td align='right' width='20%' style='border:1px solid #B1B1B1'>"+data[i][3]+"</td>\n"+  
                  "</tr>";
          $('#verbody2').append(n);
        }
        $('#filter2').tableFilterRefresh();
        swal.close();
      }
    });
  });
  $('#3').click(function(){
    $.ajax({
      type: "POST",
      dataType:"json",
      url: "ingreso.php",
      data: 'fecha='+$('#fecha').val(),
      beforeSend:function(){
        swal({
          title: "Buscando..",
          text: "",
          imageUrl: "../loading.gif",
          showConfirmButton: false
        });
      },
      success: function(data){
        $(".result").hide();
        $("#result3").show();
        $("#verbody3").empty();
        for (var i = 0; i <= data.length-1; i++) {
          var n="<tr class='fila'>\n"+
                  "<td align='center' width='15%' style='border:1px solid #B1B1B1'>"+data[i][0]+"</td>\n"+
                  "<td align='center' width='10%' style='border:1px solid #B1B1B1'>"+data[i][1]+"</td>\n"+
                  "<td width='50%' style='border:1px solid #B1B1B1'>"+data[i][2]+"</td>\n"+  
                  "<td align='right' width='10%' style='border:1px solid #B1B1B1'>"+data[i][3]+"</td>\n"+  
                  "</tr>";
          $('#verbody3').append(n);
        }
        $('#filter3').tableFilterRefresh();
        swal.close();
      }
    });
  });
  $('#4').click(function(){
    $.ajax({
      type: "POST",
      dataType: "json",
      url: "egreso.php",
      data: 'fecha='+$('#fecha').val(),
      beforeSend:function(){
        swal({
          title: "Buscando..",
          text: "",
          imageUrl: "../loading.gif",
          showConfirmButton: false
        });
      },
      success: function(data){
        $(".result").hide();
        $("#result4").show();
        $("#verbody4").empty();
        for (var i = 0; i <= data.length-1; i++) {
          var n="<tr class='fila'>\n"+
                  "<td align='center' width='15%' style='border:1px solid #B1B1B1'>"+data[i][0]+"</td>\n"+
                  "<td align='center' width='10%' style='border:1px solid #B1B1B1'>"+data[i][1]+"</td>\n"+
                  "<td width='50%' style='border:1px solid #B1B1B1'>"+data[i][2]+"</td>\n"+  
                  "<td align='right' width='10%' style='border:1px solid #B1B1B1'>"+data[i][3]+"</td>\n"+  
                  "</tr>";
          $('#verbody4').append(n);
        }
        $('#filter4').tableFilterRefresh();
        swal.close();
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