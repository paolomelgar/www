<?php 
session_start();
if($_SESSION['valida']=='huancayo'){
?>
<html>
<head>
  <title>FERREBOOM</title>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 
  <link rel="stylesheet" type="text/css" href="../sistema/style/principal.css">
  <link type="text/css" href="../jquery-ui-1.10.4.custom.min.css" rel="stylesheet" />
  <script type="text/javascript" src="../jquery-1.11.1.min.js"></script>
  <script type="text/javascript" src="../jquery-ui-1.10.4.custom.min.js"></script>  
  <script src="../socket.io.js"></script>
  <script type="text/javascript" src="sistema/sistema.js"></script>
  <style type="text/css">
    * {
      margin: 0;
      padding: 0;
      box-sizing:border-box;
      font-family:Arial, Helvetica, sans-serif;
    }

    .menu{
      display: flex;
      background: linear-gradient(#4b6cb7, #182848);
    }

    #btn-menu{
      display: none;
    }
    label{
      display: none;
      margin-left: 15px;
    }

    .menu li {
      width: 224px;
    }

    .menu ul {
      background: linear-gradient(#4b6cb7, #182848);
      list-style: none;
    }

    .menu ul ul {
      display: none;
      background: linear-gradient(#182848,#4b6cb7);
    }

    .menu ul a {
      text-shadow:1px 1px 1px #000;
      font-size: 13px;
      display: block;
      padding: 5px 50px;
      color: white;
      text-decoration: none;
      border:1px solid #FFF;
    }

    .menu ul ul a {
      font-size: 13px;
      padding: 5px 20px;
    }

    .menu a:hover {
      background-color: #FFF105;
      color:black;
    }

    .menu ul li:hover ul {
      display: block;
      position: absolute;

    }
    .ui-tooltip{
        background: #262626;
        color:white;
        border:2px solid #262626;
    }
    .selected {
        cursor: pointer;
        background: #09F;
    }
    .select {
        color: #F63 !important;
        font-weight: bold;
    }
    ::-webkit-scrollbar{
      width: 8px;  /* for vertical scrollbars */
    }
    ::-webkit-scrollbar-track{
      background: rgba(0, 0, 0, 0);
    }
    ::-webkit-scrollbar-thumb{
      background: rgba(0, 0, 0, 0.5);
    }
    .fila:hover{
        color:yellow !important;
        cursor: pointer;
        font-weight: bold;
    }
  </style>
</head>
<body style='position:fixed;width:100%;height:100%'>
  <audio id="sound"><source src="notify.wav"></source></audio>
  <div id='name' style='display:none'><?php echo $_SESSION['nombre']; ?></div>
  <div id='cargo' style='display:none'><?php echo $_SESSION['cargo']; ?></div>
  <div style='position:absolute;bottom:0px;right:0px;cursor:pointer;background: linear-gradient(#4b6cb7, #182848);color:white;padding:5px;border-radius:10px 0px 0px 10px' id='chat'>
    <img src='sistema/chat1.png' width='45px'>
    <div>CHAT</div>
  </div>
  <div style='position:absolute;bottom:0px;right:-250px;width:250px;height:600px;' id='area'>
  <table width='100%' style='border-collapse:collapse;border:1px solid black;background-image: url("sistema/image.jpg");'>
    <tr><td style='height:200px;background: linear-gradient(#4b6cb7, #182848);'><div id='users' style='height:200px;overflow-y:scroll;color:white'></div></td></tr>
    <tr><td width='100%' style='padding:2px;height:30px;background: linear-gradient(#4b6cb7, #182848);'><input style='width:100%;height:26px' type='text' id='con' placeholder='Buscar...'></td></tr>
    <tr><td width='100%' style='background-color:black;color:white;height:23px;font-size:17px;display:inline-block;'><div id='receptor'>Elige a alguien para Chatear</div></td></tr>
    <tr><td width='100%' style='height:300px;'>
      <div style='overflow-y:scroll;height:300px;padding:0px' id='scroll'>
        <table style='border-collapse:collapse'>
          <tr>
            <td id='areachat' valign='bottom' width='250px' height='300px'>
            </td>
          </tr>
        </table>
      </div>
    </td></tr>
    <tr>
      <td width='100%' style='height:15px;display:inline-block;'>
        <div id='escr' style='margin-top:0px;color:#6C6C6C;float:left;font-size:11px'></div>
        <div id='visto' style='color:#6C6C6C;text-align:right;float:right;font-size:11px;display:none;margin-right:10px'></div>
      </td>
    </tr>
    <tr><td width='100%' style='padding:2px;height:30px;'><input style='width:100%;height:26px;' type='text' id='input' readonly='readonly' placeholder='Escribe un Mensaje...'></td></tr>
  </table>
  </div>
  <table width="100%" height="100%" border="0" style='border-collapse: collapse;'>
    <tr>
        <th style='background: linear-gradient(#4b6cb7, #182848);' height='25px'>
          <input type='checkbox' id='btn-menu'>
          <label for='btn-menu' align='left'><img src='../ventasfuera/menu-icon.png'></label>
          <nav class="menu">
        <?php
        switch ($_SESSION['cargo']) {
          case 'ADMIN':
            ?>
            <ul>
              <li style="background-color: #FFF105;" class='submenu'><a href="#" >ADMINISTRACION</a>
                  <ul>
                  <li><a href="proveedor/" target="contenedor">PROVEEDORES</a></li>
                  <li><a href="cliente/" target="contenedor">CLIENTES</a></li>
                  <li><a href="transportista/" target="contenedor">TRANSPORTISTAS</a></li>
                  <li><a href="usuario/" target="contenedor">USUARIOS</a></li>
                  <li><a href="producto/" target="contenedor">PRODUCTOS</a></li>
                  <li><a href="marca/" target="contenedor">MARCAS</a></li>
                  <li><a href="familia/" target="contenedor">CATEGORIAS</a></li>
                  <li><a href="query/" target="contenedor">CONSULTAS</a></li>
                  <?php if($_SESSION['nombre']=='PAOLO MELGAR'){?>
                  <li><a href="http://admin:12345678@ferreboom.ddns.net:81/" target="_blank">CAMARA VIGILANCIA</a></li>
                  <?php } ?>
                  <li><a href="http://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/jcrS00Alias" target="_blank">RUC</a></li>
                </ul>
              </li>
            </ul>
            <ul>
              <li class='submenu'><a href="#" >COMPRAS</a>
                  <ul>
                  <li><a href="compras/" target="_blank">COMPRAS</a></li>
                  <li><a href="calendario/" target="contenedor">CRONOGRAMA PAGOS</a></li>
                  <li><a href="maps/" target="contenedor">GOOGLE MAPS</a></li>
                </ul>
              </li>
            </ul>
            <ul>
              <li><a href="#" >VENTAS</a>
                  <ul>
                  <li><a href="caja/" target="_blank">CAJA TIENDA</a></li>
                  <li><a href="ventas/" target="_blank">VENTA TIENDA</a></li>
                  <li><a href="ganancias/" target="contenedor">GANANCIA POR VENTA</a></li>
                  <li><a href="malogrados/" target="contenedor">REPORTE MALOGRADOS</a></li>
                </ul>
              </li>
            </ul>
            <ul>
              <li><a href="#" >TESORERIA</a>
                  <ul>
                  <li><a href="cajadeldia/" target="contenedor">CAJA DEL DIA</a></li>
                  <li><a href="cajamayor/" target="contenedor">CAJA MAYOR</a></li>
                  <li><a href="cobranzas/" target="contenedor">COBRO CLIENTES</a></li>
                  <li><a href="pagoproveedor/" target="contenedor">PAGO PROVEEDORES</a></li>
                  <li><a href="egresos/" target="contenedor">INGRESO/EGRESO</a></li>
                  <li><a href="balancemensual/" target="contenedor">BALANCE MENSUAL</a></li>
                </ul>
              </li>
            </ul>
            <ul>
              <li><a href="#" >ESTADISTICAS</a>
                  <ul>
                  <li><a href="kardex_cliente/" target="contenedor">REPORTE CLIENTES</a></li>
                  <li><a href="kardex_proveedor/" target="contenedor">REPORTE PROVEEDORES</a></li>
                </ul>
              </li>
            </ul>
            <ul>
              <li><a href="salir.php" >SALIR</a></li>
            </ul>
            <?php
          break;
          case 'CAJERO':
            ?>
            <ul>
              <li style="background-color: #FFF105;" class='submenu'><a href="#" >ADMINISTRACION</a>
                  <ul>
                    <li><a href="proveedor/" target="contenedor">PROVEEDORES</a></li>
                  <li><a href="cliente/" target="contenedor">CLIENTES</a></li>
                  <li><a href="transportista/" target="contenedor">TRANSPORTISTAS</a></li>
                  <li><a href="producto/" target="contenedor">PRODUCTOS</a></li>
                  <li><a href="marca/" target="contenedor">MARCAS</a></li>
                  <li><a href="familia/" target="contenedor">CATEGORIAS</a></li>
                  <li><a href="maps/" target="contenedor">MAPS</a></li>
                </ul>
              </li>
            </ul>
            <ul>
              <li><a href="http://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/jcrS00Alias" target="_blank">SUNAT RUC</a></li>
            </ul>
            <ul>
              <li><a href="#" >VENTAS</a>
                  <ul>
                  <li><a href="caja/" target="_blank">CAJA</a></li>
                  <li><a href="compras/" target="_blank">COMPRAS</a></li>
                  <li><a href="malogrados/" target="contenedor">MALOGRADOS</a></li>
                </ul>
              </li>
            </ul>
            <ul>
              <li><a href="#" >TESORERIA</a>
                  <ul>
                  <li><a href="cajadeldia/" target="contenedor">CAJA DEL DIA</a></li>
                  <li><a href="cobranzas/" target="contenedor">COBRO CLIENTES</a></li>
                </ul>
              </li>
            </ul>
            <ul>
              <li><a href="#" >ESTADISTICAS</a>
                  <ul>
                  <li><a href="kardex_cliente/" target="contenedor">REPORTE CLIENTES</a></li>
                  <li><a href="kardex_proveedor/" target="contenedor">REPORTE PROVEEDORES</a></li>
                </ul>
              </li>
            </ul>
            <ul>
              <li><a href="salir.php" >SALIR</a></li>
            </ul>
            <?php
          break;
          case 'PROMOTOR':
            ?>
            <ul>
              <li><a href="maps/" target="contenedor">MAPS CLIENTES</a></li>
            </ul>
            <ul>
              <li><a href="catalogo" target="contenedor">CATALOGO</a></li>
            </ul>
            <ul>
              <li><a href="ventas/" target="contenedor">VENTAS</a></li>
            </ul>
            <ul>
              <li><a href="cobranzas/" target="contenedor">DEUDA CLIENTES</a></li>
            </ul>
            <ul>
              <li><a href="kardex_cliente/" target="contenedor">REPORTE CLIENTES</a></li>
            </ul>
            <ul>
              <li><a href="salir.php" >SALIR</a></li>
            </ul>
            <?php
          break;
          case 'VENDEDOR':
            ?>
            <ul>
              <li><a href="maps/" target="contenedor">MAPS CLIENTES</a></li>
            </ul>
            <ul>
              <li><a href="http://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/jcrS00Alias" target="_blank">SUNAT RUC</a></li>
            </ul>
            <ul>
              <li><a href="ventas/" target="_blank">VENTAS</a></li>
            </ul>
            <ul>
              <li><a href="kardex_cliente/" target="contenedor">REPORTES</a></li>
            </ul>
            <ul>
              <li><a href="salir.php" >SALIR</a></li>
            </ul>
            <?php
          break;
        }
        ?>
        </nav>
      </th>
      </tr>
      <tr height='100%'>
        <th align="center">
            <iframe name="contenedor" src="sistema/inicio.php" style='border: none;top: 0; right: 0;bottom: 0; left: 0;width: 100%;height: 100%;'>
        </th>
    </tr>
  </table>
  
</body>
<html>
<?php }else{
  header("Location: ../");
} ?>
