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
      var total=parseFloat(sumaingreso)-parseFloat(sumaegreso);
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
            "<td width='15%' align='center'>"+data[i][1]+"</td>\n"+
            "<td width='15%' align='center'>"+data[i][2]+"</td>\n"+
            "<td width='10%' align='right'>"+data[i][3]+"</td>\n"+
            "<td width='30%'>"+data[i][4]+"</td>\n"+
            "<td width='15%' align='center'>"+data[i][5]+"</td>\n"+
            "<td style='display:none'>"+data[i][6]+"</td>\n"+
          "</tr>";
          $('#verbody').append(n);
        }
        $('#venta').tableFilterRefresh();
      }
    });
  }
  buscar();
  $('#buscar').click(function(){
    buscar();
  });
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
        if(data[2]=='vendedor'){
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
  $('#egreso').click(function(){
    $("#dialogingresos").dialog({
      title:"REGISTRO DE INGRESOS/EGRESOS",
      width:"50%",
      modal:true,
      buttons: { 
        "Si" : function(){ 
          $.ajax({
            type:"POST",
            url:"egresos.php",
            data:"oper="+$('#operacion').val()+"&tipo="+$('#tipomov').val()+"&monto="+$('#monto').val()+"&detalle="+$('#detalle').val()+"&transporte="+$('#transporte').val()+"&encar="+$('#vendedor').val(),
            success:function(data){
              swal($('#operacion').val()+" agregado Correctamente","","success");
              buscar();
            }
          });
          $(this).dialog( "close" ); 
        },
      },
      open: function() {
        $('#monto').val("");
        $('#detalle').val("");
        $('select[id="tipomov"]').val("");
        $('select[id="operacion"]').val("EGRESO");
        $('#transporte').val("");
        $('.transporte').hide();
        $('#tipomov').change(function(){
          if($('select[id="tipomov"]').val()=='FLETE'){
            $('.transporte').show();
          }else{
            $('.transporte').hide();
          }
        });
        $(this).parents('.ui-dialog-buttonpane button:hass(Si)').focus();
      }
    });
  });

  $('#row').on('contextmenu','.fila',function(e){
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
          data: 'monto='+$('.selected1').find('td:eq(5)').text()+'&sesion='+$('.selected1').find('td:eq(7)').text()+'&tipo='+$('.selected1').find('td:eq(3)').text()+'&id='+$('.selected1').find('td:eq(7)').text()+'&fecha='+$('.selected1').find('td:eq(1)').text(),
          success: function(data){
          }
        });
        $('.selected1').remove();
      } 
    });
  });
   
});