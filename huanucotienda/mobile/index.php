<?php 
session_start();
if($_SESSION['valida']=='huanucotienda'){
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
  <script type="text/javascript" src="../Chart.min.js"></script>
  <script src="../socket.io.js"></script>
  <script type="text/javascript" src="mobile.js"></script>
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
</head>
<body>
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
            <div class='w3-row w3-center' style='height:40px'><input type="text" id="fechaini" style="font-weight:bold;text-align:center;width:120px;margin-top:5px" class='w3-border w3-round' readonly='readonly'>&nbsp<input type="button" value="Buscar" class='w3-border w3-border-indigo w3-round w3-blue' id='busc'></div>
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
            <input type="button" value="VER" id="ver" class='w3-button w3-round-large w3-blue'>
          </div>
          <div class="w3-row w3-margin-top" style='text-align:center'>
            <input type="button" value="<?php echo $_SESSION['nombre']; ?>" id="estad" class='w3-button w3-round-large w3-orange' >
            <!--<button class="w3-button w3-round-large w3-orange" id='estad'><i class="fa fa-bar-chart"></i>&nbsp<span id='vendedor'><?php echo $_SESSION['nombre']; ?></span></button>-->
          </div>
          <div class="w3-row w3-margin-top" style='text-align:center'>
            <a href="index.php" class="external">Nueva Ventana</a>
          </div>
          

        </div>
        </div>
      </div>
      <div class="swipe-tab-content">
        
        <div class="w3-row w3-margin-left">
          <div class="w3-col w3-right" style="width:150px;text-align:center"><input type="button" value="DEVOLUCION" id="devol" class='w3-button w3-round w3-aqua w3-border w3-border-cyan'></div>
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
          <input type="button" value="EMVIAR" id="guardarform" class='w3-button w3-round-large w3-green'>
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

