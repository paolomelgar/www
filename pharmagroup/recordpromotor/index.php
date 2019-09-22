<?php 
session_start();
if($_SESSION['valida']=='pharmagroup' && $_SESSION['cargo']!='CLIENTE') {
?>
<html>
<head>
  <title>RECORD PROMOTOR</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" /> 
<link type="text/css" href="../jquery-ui-1.10.4.custom.min.css" rel="stylesheet" />
<script type="text/javascript" src="../jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="../jquery-ui-1.10.4.custom.min.js"></script>  
<script type="text/javascript" src="record.js"></script>
<script type="text/javascript">
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
      success: function(data){
        $('#total').empty();
        $('#total').append(data);
        $("#verbody> tr").hover(
          function () {
            $('#verbody> tr').removeClass('selected');
            $(this).addClass('selected');
          }, 
          function () {
            $(this).removeClass('selected');
          }
        );
        $("#verbody> tr").click(function(){
          $("#verbody tr").removeClass('select');
          $(this).addClass('select');
        });
      }
    });
    $('#buscar').click(function(){
      $.ajax({
        type: "POST",
        url: "lista.php",
        data: 'm='+$('#month').val()+'&y='+$('#year').val(),
        success: function(data){
          $('#total').empty();
          $('#total').append(data);
          $("#verbody> tr").hover(
            function () {
              $('#verbody> tr').removeClass('selected');
              $(this).addClass('selected');
            }, 
            function () {
              $(this).removeClass('selected');
            }
          );
          $("#verbody> tr").click(function(){
            $("#verbody tr").removeClass('select');
            $(this).addClass('select');
          });
        }
      });
    });
    $('#total').on('click','.ver',function(){
      var serie=$(this).parent().find('td:eq(8)').text();
      $.ajax({
        type: "POST",
        url: "verproductos.php",
        data: 'serie='+serie,
        success: function(data){
          $('#producto').empty();
          $('#producto').append(data);
          $('#producto .tr').each(function(){
            $(this).hover(
              function () {
                $('#producto> tr').removeClass('selected');
                $(this).addClass('selected');
              }, 
              function () {
                $(this).removeClass('selected');
              }
            );
          });
        }
      });
    });
  });
</script>
<style type="text/css">
  #cabecera{
    background-color: #58ACFA;
    margin-top :-7px;
  }
  .par{
    background-color: white;
  }
  .impar{
    background-color: #E0F8E0;
  }
  .con{
    color: red;
  }
  .selected {
    cursor: pointer;
    background: #FF3;
  }
  .select {
    background: #F63;
  }
  .ui-widget{
    font-family: "Times New Roman";
   }
   .ui-dialog .ui-dialog-title {
    text-align: center;
    width: 100%;
  }
</style>
</head>
<body>
  <table width='100%' height='100%' style='border-collapse:collapse'>
    <tr style='background-color:#47FCA7;'>
      <th width="20%" >MES:
        <select id='month'>
          <option value='01'>ENERO</option>
          <option value='02'>FEBRERO</option>
          <option value='03'>MARZO</option>
          <option value='04'>ABRIL</option>
          <option value='05'>MAYO</option>
          <option value='06'>JUNIO</option>
          <option value='07'>JULIO</option>
          <option value='08'>AGOSTO</option>
          <option value='09'>SETIEMBRE</option>
          <option value='10'>OCTUBRE</option>
          <option value='11'>NOVIEMBRE</option>
          <option value='12'>DICIEMBRE</option>
        </select>
      </th>
      <th width='20%'>AÑO:
        <select id='year'>
          <option>2015</option>
          <option>2016</option>
          <option>2017</option>
          <option>2018</option>
          <option>2019</option>
          <option>2020</option>
        </select>
      </th>
      <th width="30%" ><input type="button" id="buscar" value="BUSCAR"/></th>
      <th width="30%"><a href='#' id='estadistica'><img src='../estad.png' height='20px' width='40px' style='margin-left:20px'></a></th>
    </tr>
    <tr>
      <td width='70%' height='100%' colspan='3' id='total' valign='top' style='overflow:auto;'></td>
      <td width='30%' height='100%' colspan='3' id='producto' valign='top' style='overflow:auto;'></td>
    </tr>
  </table>
</body>
</html>
<?php }else{
  header("Location: ../");
} ?>
