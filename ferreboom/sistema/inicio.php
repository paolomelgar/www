<!DOCTYPE html>
<?php require_once('../connection.php'); ?>
<html>
<title>TIENDA</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link type="text/css" href="../sweet-alert.css" rel="stylesheet" />
<script type="text/javascript" src="../jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="../sweet-alert.min.js"></script> 
<script src="../Chart.min.js"></script>
<style>
html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
</style>
<body class="w3-light-grey">

<!-- !PAGE CONTENT! -->
<div class="w3-main" >

  <!-- Header -->
  <header class="w3-container">
    <h5><b><i class="fa fa-dashboard"></i> Mi Resumen del Dia</b></h5>
  </header>

  <div class="w3-row-padding w3-margin-bottom w3-twothird">
    
    <div class="w3-row-padding w3-margin-bottom ">
    <div class="w3-quarter">
      <div class="w3-container w3-red w3-padding-16">
        <div class="w3-left"><i class="fa fa-comment w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>52</h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Messages</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-blue w3-padding-16">
        <div class="w3-left"><i class="fa fa-eye w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>99</h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Views</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-teal w3-padding-16">
        <div class="w3-left"><i class="fa fa-share-alt w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>23</h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Shares</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-orange w3-text-white w3-padding-16">
        <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>50</h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Users</h4>
      </div>
    </div>
  </div>
      <div>
        <h5>Ultimas Alertas</h5>
        <table class="w3-table w3-striped w3-white" border='1' style='border:1px solid #cccccc'>
          <thead>
          <tr style='background-color:#464646;color:white'>
            <th></th>
            <th style='text-align:center'>TIPO</th>
            <th style='text-align:center'>CONCEPTO</th>
            <th style='text-align:center'>USUARIO</th>
            <th style='text-align:center'>TIEMPO</th>
            <th></th>
          </tr>
          </thead>
          <tbody id='body'>
          </tbody>
        </table>
      </div>
      </div>
    </div>
  </div>

  <hr>
  <div class="w3-container">
    <h5>Resultados General</h5>
    <p>Total Ventas</p>
    <div class="w3-grey">
      <div class="w3-container w3-center w3-padding w3-green" style="width:95%">95%</div>
    </div>

  </div>
  <!-- End page content -->
</div>

<script>
$(function(){

  $.ajax({
      type: "POST",
      url: "lista.php",
      dataType:"json",
      data: "",
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
        $('#body').empty();
        for (var i = 0; i <= data.length-1; i++) {
          var next= "<tr class='fila'>\n" +
                  "<td>"+(i+1)+"</td>\n"+
                  "<td class='w3-"+data[i][4]+"' style='text-align:center'>"+data[i][0]+"</td>\n"+
                  "<td class='w3-"+data[i][4]+"'>"+data[i][1]+"</td>\n"+
                  "<td class='w3-"+data[i][4]+"' style='text-align:center'>"+data[i][3]+"</td>\n"+
                  "<td class='w3-"+data[i][4]+"' style='text-align:center'>"+data[i][2]+"</td>\n"+
                  "<td style='text-align:center'><input type='checkbox'></td>\n";
              next += "</tr>";
          $('#body').append(next);
        }
      }
    });
});
</script>

</body>
</html>
