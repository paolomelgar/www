<!DOCTYPE html>
<html>
<head>
  <title>INICIO</title>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 
  <link type="text/css" href="../bootstrap.min.css" rel="stylesheet" />
  <link type="text/css" href="../sweet-alert.css" rel="stylesheet" />
  <link type="text/css" href="../jquery-ui-1.10.4.custom.min.css" rel="stylesheet" />
  <script type="text/javascript" src="../jquery-1.11.1.min.js"></script>
  <script type="text/javascript" src="../jquery-ui-1.10.4.custom.min.js"></script> 
  <script type="text/javascript" src="../bootstrap.min.js"></script>
  <script type='text/javascript' src='../picnet.table.filter.min.js'></script> 
  <script type="text/javascript" src="../sweet-alert.min.js"></script>  
  <script src="../Chart.min.js"></script> 

</head>
<body>
  <table width='100%'>
    <tr>
      <td width='50%' style='color:rgba(255,85,85)' align='center'><h2>VENTAS MENSUALES</h2></td>
      <td width='50%' style='color:rgba(85,190,255)' align='center'><h2>VENTAS POR HORA</h2></td>
    </tr>
    <tr>
      <td width='50%' ><canvas id="canvas" style='width:100%;height:500px;'></canvas></td>
      <td width='50%' ><canvas id="canvas1" style='width:100%;height:500px;'></canvas></td>
    </tr>
  </table>
</body>
<script type="text/javascript" >
    $.ajax({
      type: "POST",
      url: "estadistica.php",
      dataType: "json",
      async: false,
      success: function(data){
        var dat = {
          labels: data[1].reverse(),
          datasets: [
          {
          fillColor: "rgba(255, 85, 85, .4)",
          strokeColor: "rgba(255,85,85)",
          data: data[0].reverse()
          }  ]  }
        var options = { 
          scaleFontSize: 15,
          scaleFontColor: "#000",
        };
        var cht = document.getElementById('canvas');
        var ctx = cht.getContext('2d');
        var barChar
        t = new Chart(ctx).Bar(dat,options);
      }
    });
    $.ajax({
      type: "POST",
      url: "estadisticahora.php",
      dataType: "json",
      async: false,
      success: function(data){
        var dat = {
          labels: data[1],
          datasets: [
          {
          fillColor: "rgba(85, 190, 255, .4)",
          strokeColor: "rgba(85,190,255)",
          data: data[0]
          }  ]  }
        var options = { 
          title: {
            display: true,
            text: 'TEST'
        },
          scaleFontSize: 15,
          scaleFontColor: "#000",
        };
        var cht = document.getElementById('canvas1');
        var ctx = cht.getContext('2d');
        var barChart = new Chart(ctx).Bar(dat,options);
      }
    });
  </script>
</html>
