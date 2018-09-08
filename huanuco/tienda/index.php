<!DOCTYPE html>
<?php session_start();require_once('../connection.php'); ?>
<html>
<title>TIENDA</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script type="text/javascript" src="../jquery-1.11.1.min.js"></script>
<script src="../Chart.min.js"></script>
<style>
html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
</style>
<body class="w3-light-grey">

<!-- Top container -->
<div class="w3-bar w3-top w3-black w3-large" style="z-index:4">
  <button class="w3-bar-item w3-button w3-hover-none w3-hover-text-light-grey" onclick="w3_open();"><i class="fa fa-bars"></i>  Menu</button>
  <span class="w3-bar-item w3-right">Logo</span>
</div>

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-white w3-animate-left" style="z-index:3;width:300px;display:none" id="mySidebar"><br>
  <div class="w3-container w3-row">
    <div class="w3-col s4">
      <img src="avatar2.png" class="w3-circle w3-margin-right" style="width:46px">
    </div>
    <div class="w3-col s8 w3-bar">
      <span>Hola, <strong><?php echo $_SESSION['nombre']; ?></strong></span><br>
      <a href="#" class="w3-bar-item w3-button"><i class="fa fa-envelope"></i></a>
      <a href="#" class="w3-bar-item w3-button"><i class="fa fa-user"></i></a>
      <a href="#" class="w3-bar-item w3-button"><i class="fa fa-cog"></i></a>
    </div>
  </div>
  <hr>
  <div class="w3-container">
    <h5>Menu Principal</h5>
  </div>
  <div class="w3-bar-block">
    <a href="#" class="w3-bar-item w3-button w3-padding w3-blue"><i class="fa fa-globe fa-fw"></i>  Vision General</a>
    <a href="#" class="w3-bar-item w3-button w3-padding"><i class="fa fa-database fa-fw"></i>  Bases de Datos</a>
    <a href="#" class="w3-bar-item w3-button w3-padding"><i class="fa fa-desktop fa-fw"></i>  Movimientos</a>
    <a href="#" class="w3-bar-item w3-button w3-padding"><i class="fa fa-eye fa-fw"></i>  Deudas</a>
    <a href="#" class="w3-bar-item w3-button w3-padding"><i class="fa fa-dollar fa-fw"></i>  Tesoreria</a>
    <a href="#" class="w3-bar-item w3-button w3-padding"><i class="fa fa-bar-chart fa-fw"></i>  Estadisticas</a>
    <a href="#" class="w3-bar-item w3-button w3-padding"><i class="fa fa-cog fa-fw"></i>  Ajustes</a>
  </div>
  <hr>
  <div class="w3-container">
    <h5>Links</h5>
  </div>
  <div class="w3-bar-block">
    <a href="#" class="w3-bar-item w3-button w3-padding w3-white"><i class="fa fa-users fa-fw"></i>  Sunat</a>
    <a href="#" class="w3-bar-item w3-button w3-padding"><i class="fa fa-map-marker fa-fw"></i>  Google Maps</a>
    <a href="#" class="w3-bar-item w3-button w3-padding"><i class="fa fa-cc-visa fa-fw"></i>  Bcp</a>
  </div>
</nav>


<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-top:43px;">

  <!-- Header -->
  <header class="w3-container">
    <h5><b><i class="fa fa-dashboard"></i> Mi Resumen del Dia</b></h5>
  </header>

  <div class="w3-row-padding w3-margin-bottom">
    <div class="w3-third">
      <h5>Regions</h5>
      <canvas id="canvas" style='width:100%;height:350px;'></canvas>
    </div>
    <div class="w3-twothird">
      <div>
        <div class="w3-quarter">
          <div class="w3-container w3-red w3-padding-16">
            <div class="w3-left"><i class="fa fa-comment w3-xxxlarge"></i></div>
            <div class="w3-right">
              <h3>
                <?php 
                  $sql=mysqli_query($con,"SELECT count(*) FROM total_ventas where fecha='2017-09-16' and entregado='SI'");
                  $row=mysqli_fetch_row($sql);
                  echo $row[0];
                ?>
              </h3>
            </div>
            <div class="w3-clear"></div>
            <h4>Total</h4>
          </div>
        </div>
        <div class="w3-quarter">
          <div class="w3-container w3-blue w3-padding-16">
            <div class="w3-left"><i class="fa fa-dollar w3-xxxlarge"></i></div>
            <div class="w3-right w3-large">
              <h3>
                <?php 
                  $sql=mysqli_query($con,"SELECT SUM(total) FROM total_ventas where fecha='2017-09-16' and entregado='SI'");
                  $row=mysqli_fetch_row($sql);
                  echo "S/ ".$row[0];
                ?>
              </h3>
            </div>
            <div class="w3-clear"></div>
            <h4>Ventas</h4>
          </div>
        </div>
        <div class="w3-quarter">
          <div class="w3-container w3-teal w3-padding-16">
            <div class="w3-left"><i class="fa fa-bell w3-xxxlarge"></i></div>
            <div class="w3-right">
              <h3>23</h3>
            </div>
            <div class="w3-clear"></div>
            <h4>Alertas</h4>
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
      <br>
      <div>
        <h5>Ultimas Alertas</h5>
        <table class="w3-table w3-striped w3-white" border='1' style='border:1px solid #cccccc'>
          <tr style='background-color:#464646;color:white'>
            <td>Tipo de Alerta</td>
            <td>Nombre de la Alerta</td>
            <td>Usuario</td>
            <td>Tiempo</td>
          </tr>
          <tr>
            <td><i class="fa fa-dollar w3-text-green w3-large">  Precios</i></td>
            <td class='w3-red'>Corrigio Precio de Venta</td>
            <td class='w3-red'>PAULO MELGAR</td>
            <td class='w3-red'><i>10 mins</i></td>
          </tr>
          <tr>
            <td><i class="fa fa-bookmark w3-text-red w3-large">  Cuenta Vencida</i></td>
            <td class='w3-green'>4 dia de Pago Letra</td>
            <td class='w3-green'></td>
            <td class='w3-green'><i>15 mins</i></td>
          </tr>
          <tr>
            <td><i class="fa fa-user w3-text-blue w3-large">  Nuevo Usuario</i></td>
            <td class='w3-red'>Registro DIMACESA S.R.L.</td>
            <td class='w3-red'>SANDY HUAYLAS</td>
            <td class='w3-red'><i>17 mins</i></td>
          </tr>
          <tr>
            <td><i class="fa fa-dollar w3-text-green w3-large">  Precios</i></td>
            <td class='w3-yellow'>Corrigio Precio de Devolucion</td>
            <td class='w3-yellow'>RONALD MANRIQUE</td>
            <td class='w3-yellow'><i>25 mins</i></td>
          </tr>
          <tr>
            <td><i class="fa fa-bookmark w3-text-red w3-large">  Cuenta Vencida</i></td>
            <td class='w3-yellow'>8 dia de Pago Letra</td>
            <td class='w3-yellow'></td>
            <td class='w3-yellow'><i>28 mins</i></td>
          </tr>
          <tr>
            <td><i class="fa fa-dollar w3-text-green w3-large">  Precios</i></td>
            <td class='w3-red'>Corrigio Precio de Venta</td>
            <td class='w3-red'>JHILMER RIVERA</td>
            <td class='w3-red'><i>35 mins</i></td>
          </tr>
          <tr>
            <td><i class="fa fa-user w3-text-blue w3-large">  Nuevo Usuario</i></td>
            <td class='w3-green'>Registro MARIN CARRILLO TAPIA</td>
            <td class='w3-red'>SANDY HUAYLAS</td>
            <td class='w3-green'><i>39 mins</i></td>
          </tr>
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
      <div class="w3-container w3-center w3-padding w3-green" style="width:38%">+38%</div>
    </div>

  </div>
  <!-- End page content -->
</div>

<script>
// Get the Sidebar
var mySidebar = document.getElementById("mySidebar");

// Get the DIV with overlay effect
var overlayBg = document.getElementById("myOverlay");

// Toggle between showing and hiding the sidebar, and add overlay effect
function w3_open() {
    if (mySidebar.style.display === 'block') {
        mySidebar.style.display = 'none';
        overlayBg.style.display = "none";
    } else {
        mySidebar.style.display = 'block';
        overlayBg.style.display = "block";
    }
}

// Close the sidebar with the close button
function w3_close() {
    mySidebar.style.display = "none";
    overlayBg.style.display = "none";
}
$(function(){
  var newopts = {
    inGraphDataShow: true,
    inGraphDataRadiusPosition: 2,
    inGraphDataFontColor: 'white'
}
  var pieData = [
    {
        value: 50,
        color: "#2196F3",
    },
    {
       value: 30,
       color: "#f44336",
    },
    {
       value: 40,
       color: "#4CAF50",
    }
]
var pieCtx = document.getElementById('canvas').getContext('2d');
new Chart(pieCtx).Pie(pieData, newopts);
});
</script>

</body>
</html>
