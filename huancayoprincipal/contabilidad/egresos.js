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
          sumaingreso = parseFloat(sumaingreso) + parseFloat($(this).find("td:eq(4)").text());
        }
        else{
          sumaegreso = parseFloat(sumaegreso) + parseFloat($(this).find("td:eq(4)").text());        
        }
      });
      var total=parseFloat(sumaegreso);
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
            "<td width='5%' align='right'>"+(i+1)+"</td>\n"+
              "<td width='10%' align='center'>"+data[i][0]+"</td>\n"+
              "<td width='10%' align='center'>"+data[i][9]+"-"+data[i][8]+"</td>\n"+
              "<td width='15%' align='center'>"+data[i][6]+"</td>\n"+
              "<td width='5%' align='right'>"+data[i][3]+"</td>\n"+
              "<td width='45%'>"+data[i][4]+"</td>\n"+
              "<td width='10%' align='center'>"+data[i][10]+"</td>\n"+
              "<td style='display:none'>"+data[i][7]+"</td>\n"+
              "</tr>";
          $('#verbody').append(n);
        }
        $('#venta').tableFilterRefresh();
        $('#verbody').on('focusout','td[contenteditable=true]',function(){

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

 
   
});