$(function(){
  $('#venta').tableFilter({
    filteredRows: function(filterStates) {
      var sumacantidad  = 0;
      var sumacompra = 0;
      var sumaventa  = 0;
      var sumatotal  = 0;
      $('#verbody tr').filter(":visible").each(function(){
        sumacantidad =   parseFloat(sumacantidad) +  parseFloat($(this).find("td:eq(7)").text());
        sumacompra =  parseFloat(sumacompra) +  parseFloat($(this).find("td:eq(7)").text())*parseFloat($(this).find("td:eq(8)").text());
        sumaventa =  parseFloat(sumaventa) +  parseFloat($(this).find("td:eq(7)").text())*parseFloat($(this).find("td:eq(9)").text());        
        sumatotal =  parseFloat(sumatotal) +  parseFloat($(this).find("td:eq(11)").text());        
      });
      $('#sumacantidad').text(sumacantidad.toFixed(0)); 
      $('#sumacompra').text(sumacompra.toFixed(2)); 
      $('#sumaventa').text(sumaventa.toFixed(2)); 
      $('#sumatotal').text(sumatotal.toFixed(2)); 
      $('#porcentaje').text(((sumatotal)*100/sumacompra).toFixed(2)+"%"); 
    },
    enableCookies: false
  });
  $('#myModal').modal('show');
  var date = new Date();
  $('#inicio').datepicker({
    firstDay:1,
    dateFormat:'dd/mm/yy',
    changeMonth: true,
    changeYear: true,
    monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'],
    dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa']
  }).datepicker("setDate", date);
  $('#final').datepicker({
    firstDay:1,
    dateFormat:'dd/mm/yy',
    changeMonth: true,
    changeYear: true,
    monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'],
    dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa']
  }).datepicker("setDate", date);
  $("input").keyup(function(){
    var start = this.selectionStart,
        end = this.selectionEnd;
    $(this).val( $(this).val().toUpperCase() );
    this.setSelectionRange(start, end);
  });
  var x;
  var m=date.getMonth();
  var y=date.getFullYear();
  m=("00" + m).slice (-2);
  $('select[id="month"]').val(m);
  $('select[id="year"]').val(y);
  $('select[id="vendedor"]').val("");
  $('#buscar').click(function(){
    var str = $('#form').serialize();
    $.ajax({
      type: "POST",
      url: "lista.php",
      dataType:"json",
      data: str,
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
        $('#verbody').empty();
        for (var i = 0; i <= data.length-1; i++) {
          var next= "<tr class='fila'>\n" +
                  "<td style='text-align:right' width='2%'>"+(i+1)+"</td>\n"+
                  "<td style='text-align:center' width='8%'>"+data[i][11]+"</td>\n"+
                  "<td style='text-align:center' width='5%'>"+data[i][1]+"<br>"+data[i][2] +"</td>\n"+
                  "<td style='text-align:center' width='8%'>"+data[i][3]+"</td>\n"+
                  "<td style='text-align:center' width='5%'>"+data[i][0]+"</td>\n"+
                  "<td width='15%'>"+data[i][4]+"</td>\n"+
                  "<td width='26%'>"+data[i][5]+"</td>\n";
              if(data[i][3]=='DEVOLUCION'){
                next += "<td style='text-align:right;color:red' width='3%'>"+(-data[i][6])+"</td>\n";
                next += "<td style='text-align:right;color:red' width='7%'>"+data[i][7]+"</td>\n";
                next += "<td style='text-align:right;color:red' width='7%'>"+data[i][8]+"</td>\n";
                next += "<td style='text-align:right;color:red' width='7%'>"+data[i][9]+"</td>\n";
                next += "<td style='text-align:right;color:red;padding-right:10px;' width='7%'>"+(-data[i][10])+"</td>\n";
              }else{
                next += "<td style='text-align:right;' width='3%'>"+data[i][6]+"</td>\n";
                next += "<td style='text-align:right;' width='7%'>"+data[i][7]+"</td>\n";
                next += "<td style='text-align:right;' width='7%'>"+data[i][8]+"</td>\n";
                next += "<td style='text-align:right;' width='7%'>"+data[i][9]+"</td>\n";
                next += "<td style='text-align:right;padding-right:10px;' width='7%'>"+data[i][10]+"</td>\n";
              }
              next += "</tr>";
          $('#verbody').append(next);
        }
        $('#verbody> tr:even').addClass('impar');
        $('#venta').tableFilterRefresh();
      }
    });
  });
  $('#buscar').click();
  var myPie;
  var m=0;
  $('#busc').click(function(){
    if(m>0){
      myPie.destroy();
    } 
    m++; 
    $.ajax({
      type: "POST",
      url: "estadistica.php",
      dataType: "json",
      data: 'm='+$('select[id="month"]').val()+'&y='+$('select[id="year"]').val()+'&t='+$('#forma').val(),
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
        if(data[2] =='ferreteria'){
          for (var i = 0;i < data[0].length ;i++) {
            var color;
            if (i==0) { color="#FE6868"; }
            else if(i==1){ color="#689FFE"; }
            else if(i==2){ color="#7DFE92"; }
            else if(i==3){ color="#F8FF74"; }
            else if(i==4){ color="#D268FC"; }
            else if(i==5){ color="#77FDF6"; }
            else if(i==6){ color="#FFB66D"; }
            else if(i==7){ color="#959391"; }
            else if(i==8){ color="#FFFFFF"; }
            else if(i==9){ color="#FF8FE8"; }
            data[0][i]={
                  value : parseFloat(data[0][i]+0).toFixed(2),
                  color : color,
                  label : data[1][i] ,
                  labelColor : 'white',
                  labelFontSize : '14'
              };
          }
          var pieData=data[0];
          myPie = new Chart(document.getElementById("canvas").getContext("2d")).Pie(pieData, {                        
          animationSteps: 40,
          animationEasing: 'easeInOutQuart'   });
        }else if(data[2]=='vendedor'){
          for (var i = 0;i < data[0].length ;i++) {
            var color;
            if (i==0) { color="#FE6868"; }
            else if(i==1){ color="#689FFE"; }
            else if(i==2){ color="#7DFE92"; }
            else if(i==3){ color="#F8FF74"; }
            else if(i==4){ color="#D268FC"; }
            else if(i==5){ color="#77FDF6"; }
            else if(i==6){ color="#FFB66D"; }
            else if(i==7){ color="#959391"; }
            else if(i==8){ color="#FFFFFF"; }
            else if(i==9){ color="#FF8FE8"; }
            else if(i==10){ color="#FE6868"; }
            else if(i==11){ color="#689FFE"; }
            else if(i==12){ color="#7DFE92"; }
            else if(i==13){ color="#F8FF74"; }
            else if(i==14){ color="#D268FC"; }
            else if(i==15){ color="#77FDF6"; }
            else if(i==16){ color="#FFB66D"; }
            else if(i==17){ color="#959391"; }
            else if(i==18){ color="#FFFFFF"; }
            else if(i==19){ color="#FF8FE8"; }
            data[0][i]={
                  value : parseFloat(data[0][i]+0).toFixed(2),
                  color : color,
                  label : data[1][i] ,
                  labelColor : 'white',
                  labelFontSize : '14'
              };
          }
          var pieData=data[0];
          myPie = new Chart(document.getElementById("canvas").getContext("2d")).Pie(pieData, {                        
          animationSteps: 40,
          animationEasing: 'easeInOutQuart'   });
        }else {
          var dat = {
            labels: data[1],
            datasets: [{
              fillColor: "rgba(151,187,205,0.2)",
              strokeColor: "rgba(151,187,205,1)",
              pointColor: "rgba(151,187,205,1)",
              pointStrokeColor: "#fff",
              pointHighlightFill: "#fff",
              pointHighlightStroke: "rgba(151,187,205,1)",
              pointLabelFontSize: 5,
              data: data[0]
            }  ]  }
          var options = { 
            scaleFontSize: 15,
            scaleFontColor: "#000"
          };
          var cht = document.getElementById('canvas');
          var ctx = cht.getContext('2d');
          myPie = new Chart(ctx).Line(dat,options);
        }
      }
    });
  });
  $('#busc').click();
  $("#cliente").autocomplete({
    source:"cliente.php",
    minLength:1
  }); 
  $("#producto").autocomplete({
    source:"producto.php",
    minLength:1
  });
  $("#marca").autocomplete({
    source:"marca.php",
    minLength:1
  }); 
  $('#excel').click(function(){
    $.ajax({
      type: "POST",
      url: "excel.php",
      data: 'inicio='+$('#inicio').val()+'&final='+$('#final').val(),
      dataType:'html',
      beforeSend:function(){
        swal({
          title: "Exportando Estadisticas a Excel",
          text: "Esto puede tardar unos Minutos, sea paciente",
          imageUrl: "../loading.gif",
          showConfirmButton: false
        });
      },
      success: function(data){
        swal.close();
        window.open("data:application/vnd.ms-excel;charset=utf-8,%EF%BB%BF" + encodeURIComponent(data));      
        e.preventDefault();
      }
    });
  });
});