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
        sumatotal =  parseFloat(sumatotal) +  parseFloat($(this).find("td:eq(3)").text());        
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
        sumatotal =  parseFloat(sumatotal) +  parseFloat($(this).find("td:eq(4)").text());        
      });
      $('#total3').text("S/ "+sumatotal.toFixed(2)); 
    },
    enableCookies: false
  });
  $('#filter4').tableFilter({
    filteredRows: function(filterStates) {
      var sumatotal  = 0;
      $('#verbody4 tr').filter(":visible").each(function(){
        sumatotal =  parseFloat(sumatotal) +  parseFloat($(this).find("td:eq(4)").text());        
      });
      $('#total4').text("S/ "+sumatotal.toFixed(2)); 
    },
    enableCookies: false
  });
  $('#filter5').tableFilter({
    filteredRows: function(filterStates) {
      var sumatotal  = 0;
      $('#verbody5 tr').filter(":visible").each(function(){
        sumatotal =  parseFloat(sumatotal) +  parseFloat($(this).find("td:eq(3)").text());        
      });
      $('#total5').text("S/ "+sumatotal.toFixed(2)); 
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
        $('#caja').val(data[0]);
        $('#credito').val(data[1]);
        $('#ingreso').val(data[2]);
        $('#contado').val(data[3]);
        $('#proveedor').val(data[4]);
        $('#egreso').val(data[5]);
        $('#totaldia').val(parseFloat(parseFloat(data[0])+parseFloat(data[1])+parseFloat(data[2])-parseFloat(data[3])-parseFloat(data[4])-parseFloat(data[5])).toFixed(2));
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
        $("#result1").show();
        $("#verbody1").empty();
        for (var i = 0; i <= data.length-1; i++) {
          var n="<tr class='fila'>\n"+
                  "<td align='center' width='15%' style='border:1px solid #B1B1B1'>"+data[i][0]+"</td>\n"+
                  "<td align='center' width='20%' style='border:1px solid #B1B1B1'>"+data[i][1]+"</td>\n"+
                  "<td width='45%' style='border:1px solid #B1B1B1'>"+data[i][2]+"</td>\n"+
                  "<td align='right' width='20%' style='border:1px solid #B1B1B1'>"+data[i][3]+"</td>\n"+  
                  "</tr>";
          $('#verbody1').append(n);
          $('#filter1').tableFilterRefresh();
          swal.close();
        }
      }
    });
  });

  $('#2').click(function(){
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
        $("#result2").show();
        $("#verbody2").empty();
        for (var i = 0; i <= data.length-1; i++) {
          var n="<tr class='fila'>\n"+
                  "<td align='center' width='15%' style='border:1px solid #B1B1B1'>"+data[i][0]+"</td>\n"+
                  "<td align='center' width='20%' style='border:1px solid #B1B1B1'>"+data[i][1]+"</td>\n"+
                  "<td width='50%' style='border:1px solid #B1B1B1'>"+data[i][2]+"</td>\n"+  
                  "<td align='right' width='15%' style='border:1px solid #B1B1B1'>"+data[i][3]+"</td>\n"+  
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
      url: "contado.php",
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
                  "<td align='center' width='15%' style='border:1px solid #B1B1B1'>"+data[i][2]+"</td>\n"+
                  "<td width='50%' style='border:1px solid #B1B1B1'>"+data[i][3]+"</td>";
                  if(data[i][5]>0){
                    n+="<td align='right' width='10%' style='border:1px solid #B1B1B1'>"+parseFloat(data[i][4]*data[i][5]).toFixed(2)+"</td>";
                  }else{
                    n+="<td align='right' width='10%' style='border:1px solid #B1B1B1'>"+parseFloat(data[i][4]).toFixed(2)+"</td>";
                  }
                  n+="</tr>";
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
      dataType:"json",
      url: "pagoproveedor.php",
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
                  "<td align='center' width='10%' style='border:1px solid #B1B1B1'>"+data[i][0]+"</td>\n"+
                  "<td align='center' width='10%' style='border:1px solid #B1B1B1'>"+data[i][1]+"</td>\n"+
                  "<td align='center' width='15%' style='border:1px solid #B1B1B1'>"+data[i][2]+"</td>\n"+
                  "<td align='center' width='15%' style='border:1px solid #B1B1B1'>"+data[i][6]+"</td>\n"+
                  "<td width='40%' style='border:1px solid #B1B1B1'>"+data[i][3]+"</td>";
                  if(data[i][5]>0){
                    n+="<td align='right' width='10%' style='border:1px solid #B1B1B1'>"+parseFloat(data[i][4]*data[i][5]).toFixed(2)+"</td>";
                  }else{
                    n+="<td align='right' width='10%' style='border:1px solid #B1B1B1'>"+parseFloat(data[i][4]).toFixed(2)+"</td>";
                  }
                  n+="</tr>";
          $('#verbody4').append(n);
        }
        $('#filter4').tableFilterRefresh();
        swal.close();
      }
    });
  });

  $('#5').click(function(){
    $.ajax({
      type: "POST",
      dataType:"json",
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
        $("#result5").show();
        $("#verbody5").empty();
        for (var i = 0; i <= data.length-1; i++) {
          var n="<tr class='fila'>\n"+
                  "<td align='center' width='15%' style='border:1px solid #B1B1B1'>"+data[i][0]+"</td>\n"+
                  "<td align='center' width='20%' style='border:1px solid #B1B1B1'>"+data[i][1]+"</td>\n"+
                  "<td width='50%' style='border:1px solid #B1B1B1'>"+data[i][2]+"</td>\n"+  
                  "<td align='right' width='15%' style='border:1px solid #B1B1B1'>"+data[i][3]+"</td>\n"+  
                  "</tr>";
          $('#verbody5').append(n);
        }
        $('#filter5').tableFilterRefresh();
        swal.close();
      }
    });
  });

});