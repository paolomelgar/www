<?php 
session_start();
if($_SESSION['valida']=='innova'){
?>
<html>
<head>
  <title>VENTAS</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css"/>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link type="text/css" href="../jquery-ui-1.10.4.custom.min.css" rel="stylesheet" />
  <link type="text/css" href="../sweet-alert.css" rel="stylesheet" />
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script type="text/javascript" src="//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js"></script>
  <script type="text/javascript" src="../jquery-ui-1.10.4.custom.min.js"></script>
  <script type='text/javascript' src='../picnet.table.filter.min.js'></script> 
  <script type="text/javascript" src="../sweet-alert.min.js"></script>
  <script type="text/javascript" src="../jquery.longpress.js"></script>
  <script src="../Chart.min.js"></script>
  <style type="text/css">
  
  input,textarea{
    text-transform: uppercase;
  }

  .ui-dialog .ui-dialog-title {
    text-align: center;
    width: 100%;
  }

  .slick-initialized .swipe-tab {
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -webkit-align-items: center;
        -ms-flex-align: center;
            align-items: center;
    -webkit-box-pack: center;
    -webkit-justify-content: center;
        -ms-flex-pack: center;
            justify-content: center;
    height: 30px;
    background: none;
    border: 0;
    color: #757575;
    cursor: pointer;
    text-align: center;

    border-bottom: 3px solid transparent;
    -webkit-transition: all 0.5s;
    transition: all 0.5s;
  }
  .slick-initialized .swipe-tab:hover {
    color: #000;
  }
  .slick-initialized .swipe-tab.active-tab {
    border-bottom-color: #000;
    color: #000;
    font-weight: bold;
    font-size:17px !important;
  }

  .main-container {
    padding: 2px;
  }
  a.external:link{text-decoration:none;font-weight:bold;color:blue;font-size: 18px;}
  a.external:visited{text-decoration:none;font-weight:bold;color:blue;font-size: 18px;}
  a.internal:link{text-decoration:none;font-weight:bold;color:red;font-size: 18px;}
  a.internal:visited{text-decoration:none;font-weight:bold;color:red;font-size: 18px;}

  .par{
    background-color: white;
  }
  .impar{
    background-color: #E5FFFE;
  }
  .mayorstock{
    background-color: red;
    color: white;
  }
  .select{
    background-color: #f63;
    color:white;
  }
</style>
<script type="text/javascript">
  $(function () {
  var date = new Date();
  $('#fechaini').datepicker({
    firstDay:1,
    dateFormat:'dd/mm/yy',
    monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'],
    dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa']
  }).datepicker("setDate", date);

  $('#ventas').tableFilter({
    filteredRows: function(filterStates) {
      var sumatotal  = 0;
      $('#verbody tr').filter(":visible").each(function(){
        sumatotal =  parseFloat(sumatotal) +  parseFloat($(this).find("td:eq(3)").text().slice(3));        
      });
      $('#sumatotal').text("S/ "+sumatotal.toFixed(2)); 
    },
    enableCookies: false
  });

  var $swipeTabsContainer = $('.swipe-tabs'),
    $swipeTabs = $('.swipe-tab'),
    $swipeTabsContentContainer = $('.swipe-tabs-container'),
    currentIndex = 0,
    activeTabClassName = 'active-tab';

  $swipeTabsContainer.on('init', function(event, slick) {
    $swipeTabsContentContainer.removeClass('invisible');
    $swipeTabsContainer.removeClass('invisible');

    currentIndex = slick.getCurrent();
    $swipeTabs.removeClass(activeTabClassName);
    $('.swipe-tab[data-slick-index=' + currentIndex + ']').addClass(activeTabClassName);
  });

  $swipeTabsContainer.slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    arrows: false,
    infinite: false,
    swipeToSlide: true,
    touchThreshold: 10
  });

  $swipeTabsContentContainer.slick({
    asNavFor: $swipeTabsContainer,
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    infinite: false,
    swipeToSlide: true,
    draggable: false,
    touchThreshold: 10
  });

  $swipeTabs.on('click', function(event) {
    currentIndex = $(this).data('slick-index');
    $swipeTabs.removeClass(activeTabClassName);
    $('.swipe-tab[data-slick-index=' + currentIndex +']').addClass(activeTabClassName);
    $swipeTabsContainer.slick('slickGoTo', currentIndex);
    $swipeTabsContentContainer.slick('slickGoTo', currentIndex);
  });

  $swipeTabsContentContainer.on('swipe', function(event, slick, direction) {
    currentIndex = $(this).slick('slickCurrentSlide');
    $swipeTabs.removeClass(activeTabClassName);
    $('.swipe-tab[data-slick-index=' + currentIndex + ']').addClass(activeTabClassName);
  });


  function hideKeyboard() {
    setTimeout(function() {
      var field = document.createElement('input');
      field.setAttribute('type', 'text');
      field.setAttribute('style', 'position:absolute; top: 0px; opacity: 0; -webkit-user-modify: read-write-plaintext-only; left:0px;');
      document.body.appendChild(field);
      field.onfocus = function(){
        setTimeout(function() {
          field.setAttribute('style', 'display:none;');
          setTimeout(function() {
            document.body.removeChild(field);
            document.body.focus();
          }, 10);
        }, 10);
      };
      field.focus();
    }, 10);
  }

  $("a.external").click(function() {
    url = $(this).attr("href");
    window.open(url, '_blank');
    return false;
 });
  $("a.internal").click(function() {
    location.href="../sistema/salir.php";
 });


  
  $('body').click(function(){
    $('#result').hide();
    $('#resultruc').hide();
    return false;
  });

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  var typingTimer;
  function ruc(consulta,e){
    $.ajax({
      type: "POST",
      url: "cliente.php",
      data: {b:consulta},
      cache: false,
      dataType: "json",
      beforeSend:function(){
        $('#resultruc').show();
        $('#resultruc').empty();
        $('#resultruc').append("<img src='../loading.gif' width='100%'>");
      },
      success: function(data){
        $("#resultruc").empty();
        if(data.length>0){
          for (var i = 0; i <= data.length-1; i++) {
            $("#resultruc").append("<div style='border-bottom: 1px solid #ccc;' class='w3-round-top sel'><div style='font-size:11px;font-weight:bold' class='r'>"+data[i][0]+"</div><div style='font-size:11px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;color:blue;font-weight:bold' class='n'>"+data[i][1]+"</div><div style='font-size:10px;white-space: nowrap;overflow: hidden;text-overflow: ellipsis;' class='d'>"+data[i][2]+"</div></div>");
          }
        }else{
          $("#resultruc").append("<div class='w3-text-red' style='text-align:center'><div>No Hay Resultados</div></div>");
        }
        $('#resultruc> div:odd').addClass('impar');
        $('#resultruc> div:even').addClass('par');
      }
    });
  }

  $('#resultruc').on('click','.sel',function(){
    $('#ruc').val($(this).find('.r').text());
    $('#razon_social').val($(this).find('.n').text());
    $('#direccion').val($(this).find('.d').text());
  });  

  /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  $('#ruc').keyup(function(e){
    if(e.keyCode == 13){
      ruc($('#ruc').val(),e);
      hideKeyboard();
    }
  }); 
  $('#razon_social').on('search', function(e){
    ruc($('#razon_social').val(),e);
    hideKeyboard();
  });
  $('.ruc').click(function(){
    var top=parseInt($(this).position().top)+40;
    var left=parseInt($(this).position().left);
    var width=parseInt($(this).width()+20);
    $("#resultruc").css({"top":""+top+"px", "left":""+left+"px"});
    $("#resultruc").css("width", ""+width+"px");
  });
  //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  var x='unidad';
  function producto(consulta,r){
      $.ajax({
        type: "POST",
        url: "producto.php",
        data: {b:consulta},
        cache: false,
        dataType: "json",
        beforeSend:function(){
          $('#result').show();
          $('#result').empty();
          $('#result').append("<img src='../loading.gif' width='100%'>");
        },
        success: function(data){
          $("#result").empty();
          if(data.length>0){
            for (var i = 0; i <= data.length-1; i++) {
              $("#result").append("<div style='height:60px;border-bottom: 1px solid #ccc;' class='w3-row'><input type='hidden' value='"+data[i][2]+"' class='compra'><input type='hidden' value='"+data[i][7]+"' class='espe'><input type='hidden' value='"+data[i][0]+"' class='id'><div class='w3-col imag' style='width:59px' id='"+data[i][0]+"'><img src='https://raw.githubusercontent.com/paolomelgar/www/master/innova/foto"+$("#mysql").val()+"/a"+data[i][0]+".jpg' width='59' height='59'></div><div class='w3-rest prod"+r+"' style='height:60px'><div style='height:30px;font-size:13px;font-weight:bold;color:#797979;line-height: 1.2;' class='pro'>"+data[i][1]+"</div><div class='w3-row' style='height:30px;font-size:9px'><div class='w3-col' style='width:20%;text-align:center'><div>STOCK</div><div style='font-weight:bold;color:red;font-size:14px' class='stock'>"+data[i][4]+"</div></div><div class='w3-col u' style='width:20%;text-align:center'><div>UNIDAD</div><div style='font-weight:bold;color:blue;font-size:14px' class='unidad'>"+data[i][5]+"</div></div><div class='w3-col u' style='width:20%;text-align:center'><div>MAYOR</div><div style='font-weight:bold;color:blue;font-size:14px' class='mayor'>"+data[i][6]+"</div></div><div class='w3-col u' style='width:20%;text-align:center'><div>ESPECIAL</div><div style='font-weight:bold;color:blue;font-size:14px' class='especial'>"+data[i][7]+"</div></div><div class='w3-col' style='width:20%;text-align:center'><div>X/CAJA</div><div style='font-weight:bold;color:#797979;font-size:14px'>"+data[i][3]+"</div></div></div></div></div>");
            }
          }else{
            $("#result").append("<div class='w3-text-red' style='text-align:center'><div>No Hay Resultados</div></div>");
          }
          $('#result> div:odd').addClass('impar');
          $('#result> div:even').addClass('par');
          $('.u').find('.'+x).addClass('select');
          $('.u').longpress(function() {
              $('.u').find('.select').removeClass('select');
            if($(this).find('.unidad').text()!=''){
              x="unidad";
              $('.u').find('.unidad').addClass('select');
            }else if($(this).find('.mayor').text()!=''){
              x="mayor";
              $('.u').find('.mayor').addClass('select');
            }else{
              x="especial";
              $('.u').find('.especial').addClass('select');
            }
          });
        }
      });
  }
  $('#result').on('click','.imag', function(){
    var id=$(this).prev().val();
    var pro=$(this).next().find('.pro').text();
    swal({
      title: "",
      text: "<img src='https://raw.githubusercontent.com/paolomelgar/www/master/innova/foto"+$("#mysql").val()+"/a"+id+".jpg' height='300' width='300'><br><div style='font-size:16px;color:blue;font-weight:bold'>"+pro+"</div>",   
      html: true,
      animation: "slide-from-top",
      confirmButtonColor: "#2196F3",
    });
  }); 
  $('#result').on('click','.prod', function(){
    var id=$(this).prev().prev().val();
    var esp=$(this).prev().prev().prev().val();
    var compra=$(this).prev().prev().prev().prev().val();
    var pro=$(this).find('.pro').text();
    var precio=$(this).find('.select').text();
    var stoc=$(this).find('.stock').text();
    $("#resultprod").prepend("<div style='height:60px;border-bottom: 1px solid #ccc;' class='w3-row product'><div class='w3-col img' style='width:59px'><img src='https://raw.githubusercontent.com/paolomelgar/www/master/innova/foto"+$("#mysql").val()+"/a"+id+".jpg' width='59px'></div><div class='w3-rest' style='height:60px'><div style='height:30px;font-size:13px;font-weight:bold;color:#797979;line-height: 1.2;' class='produc'>"+pro+"</div><div><input type='number' class='w3-border w3-round w3-right importe' style='width:65px;text-align:right;' value='0.00' readonly='readonly'><input type='number' class='w3-border w3-round w3-right unitario' style='width:65px;text-align:right;margin-right:7px' value='"+precio+"'><input type='number' class='w3-border w3-round w3-right cant' style='width:45px;text-align:right;margin-right:7px'><span class='stoc' style='color:red;display:none;font-weight:bold;margin-left:20px'>"+stoc+"</span><input type='hidden' value='"+compra+"' class='comp'><input type='hidden' value='"+esp+"' class='espec'><input type='hidden' value='"+id+"' class='idd'></div></div></div></div>");
    $('.cant:first').focus();
    $('#producto').val("");
    $('#cant').text($('.product').length);
  }); 
  
  $('#result').on('click','.prod1', function(){
    var id=$(this).prev().prev().val();
    var esp=$(this).prev().prev().prev().val();
    var compra=$(this).prev().prev().prev().prev().val();
    var pro=$(this).find('.pro').text();
    var precio=$(this).find('.select').text();
    var stoc=$(this).find('.stock').text();
    $("#resultprod1").prepend("<div style='height:60px;border-bottom: 1px solid #ccc;' class='w3-row product1'><div class='w3-col img' style='width:59px'><img src='https://raw.githubusercontent.com/paolomelgar/www/master/innova/foto"+$("#mysql").val()+"/a"+id+".jpg' width='59px'></div><div class='w3-rest' style='height:60px'><div style='height:30px;font-size:13px;font-weight:bold;color:#797979;line-height: 1.2;' class='produc1'>"+pro+"</div><div><input type='number' class='w3-border w3-round w3-right importe1' style='width:65px;text-align:right;' value='0.00' readonly='readonly'><input type='number' class='w3-border w3-round w3-right unitario1' style='width:65px;text-align:right;margin-right:7px' value='"+precio+"'><input type='number' class='w3-border w3-round w3-right cant1' style='width:45px;text-align:right;margin-right:7px'><select class='w3-border w3-round w3-right estado1' style='width:70px;margin-right:7px'><option value='BUENO'>BUENO</option><option value='MALOGRADO TIENDA'>MALOGRADO TIENDA</option><option value='MALOGRADO FABRICA'>MALOGRADO FABRICA</option></select><input type='hidden' value='"+compra+"' class='comp1'><input type='hidden' value='"+esp+"' class='espec1'><input type='hidden' value='"+id+"' class='idd1'></div></div></div></div>");
    $('.cant1:first').focus();
    $('#producto1').val("");
  });

  $('#resultprod').on('click','.img', function(){
    $("#resultprod").removeClass('select');
    $(this).parent().addClass('select');
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
        $('.select').remove();
        $('#subtotal').val(parseFloat(suma()).toFixed(2));
        $('#total').val(parseFloat(parseFloat($('#subtotal').val())+parseFloat($('#subdevolucion').val())).toFixed(2));
        $('#cant').text($('.product').length);
      } 
    });
  }); 

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  $('#producto').on('search', function(e){
    var top=parseInt($(this).position().top)+40;
    var left=parseInt($(this).position().left);
    $("#result").css({"top":""+top+"px", "left":""+left+"px"});
    producto($('#producto').val(),"");
    hideKeyboard();
  });  

  $('#close2').click(function(){
    $('#dialog').hide();
  });

  function suma(){
    var z=0;
    $('.product').each(function () {
      z+=parseFloat($(this).find('.importe').val());
    });
    return z;
  }
  $('#resultprod').on('click','.cant',function(){
    document.execCommand('selectAll', false, null);
  });
  $('#resultprod').on('click','.unitario',function(){
    document.execCommand('selectAll', false, null);
  });
  $('#resultprod').on('keyup','.cant',function(){
    if(parseFloat($(this).val())<=parseFloat($(this).parent().find('.stoc').text())){
      $(this).removeClass('mayorstock');
      $(this).parent().find('.stoc').hide();
    }else{
      $(this).addClass('mayorstock');
      $(this).parent().find('.stoc').show();
    }
    $(this).parent().find('.importe').val(parseFloat(parseFloat($(this).parent().find('.unitario').val())*parseFloat($(this).val())).toFixed(2));
    $('#subtotal').val(parseFloat(suma()).toFixed(2));
    $('#total').val(parseFloat(parseFloat($('#subtotal').val())+parseFloat($('#subdevolucion').val())).toFixed(2));
  });
  $('#resultprod').on('keyup','.unitario',function(){
    if(parseFloat($(this).val())>=parseFloat($(this).parent().find('.comp').val())){
      $(this).parent().find('.importe').val(parseFloat($(this).parent().find('.cant').val())*parseFloat($(this).val()));
    }
    else{
      $(this).parent().find('.importe').val(parseFloat($(this).parent().find('.cant').val())*parseFloat($(this).parent().find('.comp').val()));
    }
    if(parseFloat($(this).val())>=parseFloat($(this).parent().find('.espec').val())){
      $(this).removeClass('mayorstock');
    }else{
      $(this).addClass('mayorstock');
    }
    $('#subtotal').val(parseFloat(suma()).toFixed(2));
    $('#total').val(parseFloat(parseFloat($('#subtotal').val())+parseFloat($('#subdevolucion').val())).toFixed(2));
  });
  $('#resultprod').on('blur','.unitario',function () {
    $(this).val(parseFloat(parseFloat($(this).prev().val())/parseFloat($(this).next().val())).toFixed(2));
    $(this).prev().val(parseFloat($(this).prev().val()).toFixed(2));
  });
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  $('#producto1').on('search', function(e){
    var top=parseInt($(this).position().top)+45;
    var left=parseInt($(this).position().left+$('#dialog').position().left);
    $("#result").css({"top":""+top+"px", "left":""+left+"px"});
    producto($('#producto1').val(),"1");
    hideKeyboard();
  });
  function suma1(){
    var z1=0;
    $('.product1').each(function () {
      z1+=parseFloat($(this).find('.importe1').val());
    });
    return z1;
  }
  $('#resultprod1').on('click','.cant1',function(){
    document.execCommand('selectAll', false, null);
  });
  $('#resultprod1').on('click','.unitario1',function(){
    document.execCommand('selectAll', false, null);
  });
  $('#resultprod1').on('keyup','.cant1',function(){
    $(this).parent().find('.importe1').val(parseFloat(parseFloat($(this).parent().find('.unitario1').val())*parseFloat($(this).val())).toFixed(2));
    $('#subdevolucion').val(parseFloat(-suma1()).toFixed(2));
    $('#total').val(parseFloat(parseFloat($('#subtotal').val())+parseFloat($('#subdevolucion').val())).toFixed(2));
  });
  $('#resultprod1').on('keyup','.unitario1',function(){
    $(this).parent().find('.importe1').val(parseFloat(parseFloat($(this).parent().find('.cant1').val())*parseFloat($(this).val())).toFixed(2));
    $('#subdevolucion').val(parseFloat(-suma1()).toFixed(2));
    $('#total').val(parseFloat(parseFloat($('#subtotal').val())+parseFloat($('#subdevolucion').val())).toFixed(2));
  });
  $('#resultprod1').on('blur','.unitario1',function () {
    $(this).val(parseFloat(parseFloat($(this).prev().val())/parseFloat($(this).next().val())).toFixed(2));
    $(this).prev().val(parseFloat($(this).prev().val()).toFixed(2));
  });
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  
  $('#estad').click(function(){
    $('#resultestad').show();
    var barChart;
    $.ajax({
      type: "POST",
      url: "estadistica.php",
      data: "",
      dataType: "json",
      async: false,
      success: function(data){
        var dat = {
          labels: data[1].reverse(),
          datasets: [
          {
          fillColor: "#f63",
          strokeColor: "rgba(225,0,0,1)",
          data: data[0].reverse()
          }  ]  }
        var options = { 
          scaleFontSize: 15,
          scaleFontColor: "#000",
        };
        var cht = document.getElementById('trChart');
        var ctx = cht.getContext('2d');
        barChart = new Chart(ctx).Line(dat,options);
      }
    });
  });
  $('#close').click(function(){
    $('#resultestad').hide();
  });

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  
  $('#ver').click(function(){
    $('#vercom').show();
    $('#busc').click();
  });
  $('#busc').click(function(){
    var fechaini=$('#fechaini').val();
    $.ajax({
      type: "POST",
      url: "verpedido.php",
      dataType:"json",
      data: {ini:fechaini},
      beforeSend:function(){
        $('#verbody').empty();
        $('#verbody').append("<tr><td align='center' colspan='8'><img src='../loading.gif' width='100%'></td></tr>");
      },       
      success: function(data){
        $("#verbody").empty();
        for (var i = 0; i <= data.length-1; i++) {
          if(data[i][3]=='NO'){
            $("#verbody").append("<tr style='font-size:11px'><td align='center' style='color:red;font-weight:bold;border:1px solid #B1B1B1;' class='visualizar'>Ver<input type='hidden' class='serie' value='"+data[i][0]+"'></td><td align='center' style='border:1px solid #B1B1B1'>"+data[i][5]+"<br>"+data[i][1]+"</td><td align='center' style='border:1px solid #B1B1B1'>"+data[i][2]+"</td><td align='right' style='border:1px solid #B1B1B1'>"+data[i][4]+"</td></tr>");
          }else if(data[i][3]=='SI'){
            $("#verbody").append("<tr style='font-size:11px'><td align='center' style='color:blue;font-weight:bold;border:1px solid #B1B1B1;'>Vendido</td><td align='center' style='border:1px solid #B1B1B1'>"+data[i][5]+"<br>"+data[i][1]+"</td><td align='center' style='border:1px solid #B1B1B1'>"+data[i][2]+"</td><td align='right' style='border:1px solid #B1B1B1'>"+data[i][4]+"</td></tr>");
          }else{
            $("#verbody").append("<tr style='font-size:11px'><td align='center' style='color:green;font-weight:bold;border:1px solid #B1B1B1;'>Anulado</td><td align='center' style='border:1px solid #B1B1B1'>"+data[i][5]+"<br>"+data[i][1]+"</td><td align='center' style='border:1px solid #B1B1B1'>"+data[i][2]+"</td><td align='right' style='border:1px solid #B1B1B1'>"+data[i][4]+"</td></tr>");
          }
        }
        $('#verbody> tr:odd').addClass('par');
        $('#verbody> tr:even').addClass('impar');
        $('#ventas').tableFilterRefresh();
      }
    });
  });
  $('#close1').click(function(){
    $('#vercom').hide();
  })
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  var seriepedido=0;
  var nropedido=0;
  $('#verbody').on('click','.visualizar',function(){
    serie1=$(this).find('.serie').val();
    $.ajax({
      type: "POST",
      url: "editarpedido.php",
      dataType: "json",
      data: 'ver='+serie1,
      cache: false,
      beforeSend:function(){
          swal({
            title: "Cargando..",
            text: "",
            imageUrl: "../loading.gif",
            showConfirmButton: false
          });
        },
      success: function(data){
        swal.close();
        $('#ruc').val(data[1][0]);
        $('#razon_social').val(data[1][1]);
        $('#direccion').val(data[1][2]);
        $('#subtotal').val(data[1][3]);
        $('#devolucion').val(data[1][4]);
        $('#total').val(data[1][5]);
        $('#comentario').val(data[1][7]);
        $('#subdevolucion').val(data[1][4]);
        seriepedido=data[1][8];
        nropedido=data[1][9];
        $('#resultprod').empty();
        for (var i=0;i<data[0].length;i++) {
          $("#resultprod").prepend("<div style='height:60px;border-bottom: 1px solid #ccc;' class='w3-row product'><div class='w3-col img' style='width:59px'><img src='https://raw.githubusercontent.com/paolomelgar/www/master/innova/foto"+$("#mysql").val()+"/a"+data[0][i][4]+".jpg' width='59px'></div><div class='w3-rest' style='height:60px'><div style='height:30px;font-size:13px;font-weight:bold;color:#797979;line-height: 1.2;' class='produc'>"+data[0][i][0]+"</div><div><input type='number' class='w3-border w3-round w3-right importe' style='width:65px;text-align:right;' value='"+data[0][i][3]+"' readonly='readonly'><input type='number' class='w3-border w3-round w3-right unitario' style='width:65px;text-align:right;margin-right:7px' value='"+data[0][i][2]+"'><input type='number' class='w3-border w3-round w3-right cant' value='"+data[0][i][1]+"' style='width:45px;text-align:right;margin-right:7px'><span class='stoc' style='color:red;display:none;font-weight:bold;margin-left:20px'>0</span><input type='hidden' value='"+data[0][i][5]+"' class='comp'><input type='hidden' value='"+data[0][i][6]+"' class='espec'><input type='hidden' value='"+data[0][i][4]+"' class='idd'></div></div></div></div>");
        }
        $('#resultprod1').empty();
        for (var i=0;i<data[2].length;i++) {
          if(data[2][i][6]=='BUENO'){
            $("#resultprod1").prepend("<div style='height:60px;border-bottom: 1px solid #ccc;' class='w3-row product1'><div class='w3-col img' style='width:59px'><img src='https://raw.githubusercontent.com/paolomelgar/www/master/innova/foto"+$("#mysql").val()+"/a"+data[2][i][4]+".jpg' width='59px'></div><div class='w3-rest' style='height:60px'><div style='height:30px;font-size:13px;font-weight:bold;color:#797979;line-height: 1.2;' class='produc1'>"+data[2][i][0]+"</div><div><input type='number' class='w3-border w3-round w3-right importe1' style='width:65px;text-align:right;' value='"+data[2][i][3]+"' readonly='readonly'><input type='number' class='w3-border w3-round w3-right unitario1' style='width:65px;text-align:right;margin-right:7px' value='"+data[2][i][2]+"'><input type='number' class='w3-border w3-round w3-right cant1' value='"+data[2][i][1]+"' style='width:45px;text-align:right;margin-right:7px'><select class='w3-border w3-round w3-right estado1' style='width:70px;margin-right:7px'><option value='BUENO' selected>BUENO</option><option value='MALOGRADO TIENDA'>MALOGRADO TIENDA</option><option value='MALOGRADO FABRICA'>MALOGRADO FABRICA</option></select><input type='hidden' value='"+data[2][i][5]+"' class='comp1'><input type='hidden' value='' class='espec1'><input type='hidden' value='"+data[2][i][4]+"' class='idd1'></div></div></div></div>");
          }else if(data[2][i][6]=='MALOGRADO TIENDA'){
            $("#resultprod1").prepend("<div style='height:60px;border-bottom: 1px solid #ccc;' class='w3-row product1'><div class='w3-col img' style='width:59px'><img src='https://raw.githubusercontent.com/paolomelgar/www/master/innova/foto"+$("#mysql").val()+"/a"+data[2][i][4]+".jpg' width='59px'></div><div class='w3-rest' style='height:60px'><div style='height:30px;font-size:13px;font-weight:bold;color:#797979;line-height: 1.2;' class='produc1'>"+data[2][i][0]+"</div><div><input type='number' class='w3-border w3-round w3-right importe1' style='width:65px;text-align:right;' value='"+data[2][i][3]+"' readonly='readonly'><input type='number' class='w3-border w3-round w3-right unitario1' style='width:65px;text-align:right;margin-right:7px' value='"+data[2][i][2]+"'><input type='number' class='w3-border w3-round w3-right cant1' value='"+data[2][i][1]+"' style='width:45px;text-align:right;margin-right:7px'><select class='w3-border w3-round w3-right estado1' style='width:70px;margin-right:7px'><option value='BUENO'>BUENO</option><option value='MALOGRADO TIENDA' selected>MALOGRADO TIENDA</option><option value='MALOGRADO FABRICA'>MALOGRADO FABRICA</option></select><input type='hidden' value='"+data[2][i][5]+"' class='comp1'><input type='hidden' value='' class='espec1'><input type='hidden' value='"+data[2][i][4]+"' class='idd1'></div></div></div></div>");
          }else{
            $("#resultprod1").prepend("<div style='height:60px;border-bottom: 1px solid #ccc;' class='w3-row product1'><div class='w3-col img' style='width:59px'><img src='https://raw.githubusercontent.com/paolomelgar/www/master/innova/foto"+$("#mysql").val()+"/a"+data[2][i][4]+".jpg' width='59px'></div><div class='w3-rest' style='height:60px'><div style='height:30px;font-size:13px;font-weight:bold;color:#797979;line-height: 1.2;' class='produc1'>"+data[2][i][0]+"</div><div><input type='number' class='w3-border w3-round w3-right importe1' style='width:65px;text-align:right;' value='"+data[2][i][3]+"' readonly='readonly'><input type='number' class='w3-border w3-round w3-right unitario1' style='width:65px;text-align:right;margin-right:7px' value='"+data[2][i][2]+"'><input type='number' class='w3-border w3-round w3-right cant1' value='"+data[2][i][1]+"' style='width:45px;text-align:right;margin-right:7px'><select class='w3-border w3-round w3-right estado1' style='width:70px;margin-right:7px'><option value='BUENO'>BUENO</option><option value='MALOGRADO TIENDA'>MALOGRADO TIENDA</option><option value='MALOGRADO FABRICA' selected>MALOGRADO FABRICA</option></select><input type='hidden' value='"+data[2][i][5]+"' class='comp1'><input type='hidden' value='' class='espec1'><input type='hidden' value='"+data[2][i][4]+"' class='idd1'></div></div></div></div>");
          }
        }
        $('#cant').text($('.product').length);
      }
    });
    $('#vercom').hide();
    $("#guardarform").text("EDITAR COMPROBANTE");
    $("#guardarform").removeClass("w3-green");
    $("#guardarform").addClass("w3-red");
  });
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
  $("#guardarform").on('click',function(){
    
      var str = $('#form').serializeArray();
      var producto=new Array();
      var cantidad=new Array();
      var precio_u=new Array();
      var importe=new Array();
      var id=new Array();
      var compra=new Array();
      var promot=new Array();
      var producto1=new Array();
      var cantidad1=new Array();
      var precio_u1=new Array();
      var importe1=new Array();
      var estado1=new Array();
      var id1=new Array();
      var compra1=new Array();
      var i=0;
      var j=0;
      $($('.product').get().reverse()).each(function () {
        producto[i]=$(this).find('.produc').text();
        cantidad[i]=$(this).find('.cant').val();
        precio_u[i]=$(this).find('.unitario').val();
        importe[i]=$(this).find('.importe').val();
        id[i]=$(this).find('.idd').val();
        compra[i]=$(this).find('.comp').val();
        promot[i]=$(this).find('.espec').val();
        i++;
      });
      $($('.product1').get().reverse()).each(function () {
        producto1[j]=$(this).find('.produc1').text();
        cantidad1[j]=$(this).find('.cant1').val();
        precio_u1[j]=$(this).find('.unitario1').val();
        importe1[j]=$(this).find('.importe1').val();
        estado1[j]=$(this).find('.estado1').val();
        id1[j]=$(this).find('.idd1').val();
        compra1[j]=$(this).find('.comp1').val();
        j++;
      });
      $.ajax({
        type: "POST",
        url: "procesarpedido.php",
        data: {str:str,
              serie:seriepedido,
              nro:nropedido,
              producto:producto,
              cantidad:cantidad,
              unitario:precio_u,
              importe:importe,
              id:id,
              compra:compra,
              promotor:promot,
              producto1:producto1,
              cantidad1:cantidad1,
              unitario1:precio_u1,
              importe1:importe1,
              estado1:estado1,
              id1:id1,
              compra1:compra1,},
        cache: false,
        beforeSend:function(){
          swal({
            title: "Procesando Pedido..",
            text: "",
            imageUrl: "../loading.gif",
            showConfirmButton: false
          });
        },
        success: function(data){
          //socket.emit('notificacion',"");
          swal({
            title: "Nro Pedido",
            text: "<span style='color:#F63;font-weight:bold;font-size:80px'>"+data+"</span>",
            html: true,
            imageUrl: "../correcto.jpg",
          },
          function(isConfirm){
            if (isConfirm) {
              location.reload();
            } 
          });
        }
      });
  });

  $("#devol").click(function(){
    $("#dialog").show();
  });
});
</script>
</head>
<body>
  <input type='hidden' value='<?php echo $_SESSION['mysql']?>' id='mysql'>
  <form id="form" name="form" action="" method="post" autocomplete="off">
<input type='hidden' id='id'>
<div class="sub-header ">
  <div class="swipe-tabs">
    <div class="swipe-tab" style='background-color:#f63;color:white;font-size:16px;'>Cliente</div>
    <div class="swipe-tab" style='background-color:#f63;color:white;font-size:16px;'>Productos</div>
    <div class="swipe-tab" style='background-color:#f63;color:white;font-size:16px;'>Comentarios</div>
  </div>
</div>
<div class="main-container">
  <div class="swipe-tabs-container">
    <div class="swipe-tab-content">
      <div class='w3-container'>
      <div class='w3-margin-top'>
        <div id="resultruc" style='position:absolute;width:20%;max-height:300px;overflow-y:overlay;overflow-x:hidden;display:none' class='w3-border w3-border-blue w3-round'>
        </div>
        <div id="resultestad" style='position:absolute;top:30px;left:1%;width:31.3%;height:300px;display:none;' class='w3-border w3-border-blue w3-round w3-yellow w3-container'>
          <span class="w3-button w3-large w3-red w3-display-topright" title="Close Modal" id='close'>&times;</span>
          <canvas id="trChart" style='width:100%;height:100%;' class='w3-display-bottom'></canvas>
        </div>
        <div id="vercom" style='position:absolute;top:30px;left:1%;width:31.3%;height:400px;display:none;' class='w3-border w3-border-blue w3-round w3-green'>
          <span class="w3-button w3-red w3-display-topright" title="Close Modal" id='close1'>&times;</span>
          <div class='w3-row w3-center' style='height:40px'><input type="text" id="fechaini" style="font-weight:bold;text-align:center;width:120px;margin-top:5px" class='w3-border w3-round' readonly='readonly'>&nbsp<button class='w3-border w3-border-indigo w3-round w3-blue' id='busc'>Buscar</button></div>
          <div style='max-height:350px;overflow-y:overlay;overflow-x:hidden;'>
            <table width="100%" align="center" id='ventas' style='border-collapse:collapse;border:1px solid #B1B1B1;'>
              <thead class='w3-yellow'>
                <tr class='w3-blue'>
                  <th width="15%" style='border:1px solid #B1B1B1'>V</th>
                  <th width="20%" style='border:1px solid #B1B1B1'>HORA</th>
                  <th width="45%" style='border:1px solid #B1B1B1'>CLIENTE</th>
                  <th width="20%" style='border:1px solid #B1B1B1'>TOTAL</th>
                </tr>
              </thead>
              <tbody id="verbody">
              </tbody>
            </table>
          </div>
        </div>

        <div class="w3-row ">
          <div class="w3-col" style="width:100px">RUC:</div>
          <div class="w3-rest "><input type='search' name="ruc" id='ruc' class="w3-input w3-border w3-round ruc" maxlength="11"></div>
        </div>
        <div class="w3-row w3-margin-top">
          <div class="w3-col" style="width:100px">CLIENTE:</div>
          <div class="w3-rest "><input type='search' name="razon_social" id='razon_social' class="w3-input w3-border w3-round ruc"></div>
        </div>
        <div class="w3-row w3-margin-top">
          <div class="w3-col" style="width:100px">DIRECCION:</div>
          <div class="w3-rest "><textarea type='text' name="direccion" id='direccion' class="w3-input w3-border w3-round" style='height:100px'></textarea></div>
        </div>
        <div class="w3-row w3-margin-top" style='text-align:center'>
          <button class="w3-button w3-round-large w3-blue" id='ver'><i class="fa fa-file-text-o"></i>&nbspVER</button>
        </div>
        <div class="w3-row w3-margin-top" style='text-align:center'>
          <button class="w3-button w3-round-large w3-orange" id='estad'><i class="fa fa-bar-chart"></i>&nbsp<span id='vendedor'><?php echo $_SESSION['nombre']; ?></span></button>
        </div>
        <div class="w3-row w3-margin-top" style='text-align:center'>
          <a href="index.php" class="external">Nueva Ventana</a>
        </div>
        

      </div>
      </div>
    </div>
    <div class="swipe-tab-content">
      
      <div class="w3-row w3-margin-left">
        <div class="w3-col w3-right" style="width:150px;text-align:center"><button class="w3-button w3-round w3-aqua w3-border w3-border-cyan" id='devol'>DEVOLUCION</button></div>
        <div class="w3-rest" ><input type='search' id='producto' class="w3-input w3-border w3-border-blue w3-round" placeholder='Buscar Producto...'></div>
      </div>
      <div id="result" style='position:absolute;width:28%;max-height:320px;overflow-y:overlay;overflow-x:hidden;display:none;z-index:3' class='w3-border w3-border-blue w3-round'>
      </div>
      <div id="resultprod" style='height:380px;overflow-y:overlay;overflow-x:hidden;'>
        <!--<div style='height:60px' class='w3-row'><div class="w3-col" style="width:60px"><img src='a5.jpg' width='60px'></div><div class="w3-rest" style='height:60px'><div style='height:30px;font-size:12px'>ALICATE</div><div><input type='text' class="w3-border w3-round w3-right" style='width:65px;text-align:right;'><input type='text' class="w3-border w3-round w3-right" style='width:65px;text-align:right;margin-right:7px'><input type='text' class="w3-border w3-round w3-right" style='width:45px;text-align:right;margin-right:7px'></div></div></div>-->
      </div>
      <div id="dialog" style='position:absolute;top:5px;left:34.3%;width:31.3%;height:420px;display:none;background-color:white;z-index:2' class='w3-border w3-border-blue w3-round'>
        <span class="w3-button w3-red w3-display-topright" title="Close Modal" id='close2'>&times;</span>
        <div class="w3-row w3-center w3-blue" style='height:38px;font-size:28px;margin-bottom:2px'>
          <b>DEVOLUCION</b>
        </div>
        <div class="w3-row w3-margin-left">
          <div class="w3-col"><input type='search' id='producto1' class="w3-input w3-border w3-border-blue w3-round" placeholder='Buscar Producto...' style='width:95%'></div>
        </div>
        <div id="resultprod1" style='height:300px;overflow-y:overlay;overflow-x:hidden;'>
        </div>
      </div>
      <div>
        <div class='w3-row'>
          <div class='w3-col w3-text-red' style='width:40%;text-align:center;'><b><span id='cant'>0</span> productos</b></div>
          <div class='w3-col' style='width:20%;text-align:center'>
           <div class="w3-text-blue">Sub Total</div>
          <input type='text' name="subtotal" class="w3-border w3-round" style='width:65px;text-align:right;' value="0.00" readonly='readonly' id='subtotal'>
          </div>
          <div class='w3-col' style='width:20%;text-align:center'>
            <div class="w3-text-blue">Devolucion</div>
          <input type='text' name="subdevolucion" class="w3-border w3-round" style='width:65px;text-align:right;' value="0.00" readonly='readonly' id='subdevolucion'>
          </div>
          <div class='w3-col' style='width:20%;text-align:center'>
            <div class="w3-text-blue">Total</div>
          <input type='text' name="total" class="w3-border w3-round" style='width:65px;text-align:right;' value="0.00" readonly='readonly' id='total'>
          </div>
        </div>
      </div>
    </div>
    <div class="swipe-tab-content">
      <div class='w3-padding'>
        <textarea name="comentarios" id="comentario" style="height:150px" class='w3-input w3-border w3-round'></textarea>
      </div>
      <div class="w3-row w3-margin-top" style='text-align:center'>
        <button class="w3-button w3-round-large w3-green" id='guardarform'>ENVIAR</button>
      </div>
      <div class="w3-row w3-margin-top" style='text-align:center;margin-top:200px !important'>
          <a href="../sistema/salir.php" class="internal">Salir</a>
        </div>
    </div>
  </div>
</div>
</form>
</body>
</html>
<?php }else{
  header("Location: ../");
} ?>

