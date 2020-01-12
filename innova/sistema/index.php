<?php 
session_start();
$a="";
if($_SESSION['mysql']=="dorispovez"){
  $a="DORIS POVEZ";
}else if($_SESSION['mysql']=="johannagutierrez"){
  $a="JOHANNA GUTIERREZ";
}else if($_SESSION['mysql']=="innovahuanuco"){
  $a="INNOVA HUANUCO";
}else if($_SESSION['mysql']=="innovaelectric"){
  $a="INNOVA ELECTRIC";
}else if($_SESSION['mysql']=="laprincipal"){
  $a="LA PRINCIPAL";
}else if($_SESSION['mysql']=="innovaprincipal"){
  $a="INNOVA PRINCIPAL";
}else if($_SESSION['mysql']=="lymgroup"){
  $a="L & M GROUP";
}else if($_SESSION['mysql']=="almacen"){
  $a="ALMACEN";
}else if($_SESSION['mysql']=="jauja"){
  $a="JAUJA";
}else if($_SESSION['mysql']=="tingomaria"){
  $a="TINGO MARIA";
}else if($_SESSION['mysql']=="tarapac"){
  $a="TARAPACA";
}else if($_SESSION['mysql']=="prolongacionhuanuco"){
  $a="PROLONGACION HUANUCO";
}
if($_SESSION['valida']=='innova'){
?>
<html>
<head>
	<title><?php echo $a; ?></title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 
	<link rel="shortcut icon" href="../favicon.ico"/>
	<link rel="stylesheet" type="text/css" href="style/principal.css">
	<link type="text/css" href="../jquery-ui-1.10.4.custom.min.css" rel="stylesheet" />
	<script type="text/javascript" src="../jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="../jquery-ui-1.10.4.custom.min.js"></script>  
	<script src="../socket.io.js"></script>
	<script type="text/javascript" src="sistema.js"></script>
	<style type="text/css">
		* {
			margin: 0;
			padding: 0;
			box-sizing:border-box;
			font-family:Arial, Helvetica, sans-serif;
		}

		.menu{
			display: flex;
			background-color: #4d4d4d;
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
			background-color: #4d4d4d;
			list-style: none;
		}

		.menu ul ul {
			display: none;
			background: #4d4d4d;
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
<body>
	<audio id="sound"><source src="notify.wav"></source></audio>
	<div id='name' style='display:none'><?php echo $_SESSION['nombre']; ?></div>
	<div id='cargo' style='display:none'><?php echo $_SESSION['cargo']; ?></div>
	<div style='position:absolute;bottom:0px;right:0px;cursor:pointer' id='chat'>
		<img src='chat.png' width='30px'>
	</div>
	<div style='position:absolute;bottom:0px;right:0px;width:250px;height:600px;display:none;' id='area'>
		<table width='100%' style='border-collapse:collapse;border:1px solid black;background-image: url("http://img3.todoiphone.net/wp-content/uploads/2014/03/WhatsApp-Wallpaper-39.jpg");'>
			<tr><td style='height:200px;background-color:#4d4d4d;'><div id='users' style='height:200px;overflow-y:scroll;color:white'></div></td></tr>
			<tr><td width='100%' style='padding:2px;height:30px;background-color:#4d4d4d;'><input style='width:100%;height:26px' type='text' id='con' placeholder='Buscar...'></td></tr>
			<tr><td width='100%' style='background-color:black;color:white;height:23px;'><div id='receptor'>Selecciona a alguien para Chatear</div></td></tr>
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
				<td width='100%' style='height:15px;'>
					<div id='escr' style='margin-top:0px;color:#6C6C6C;float:left;font-size:11px'></div>
					<div id='visto' style='color:#6C6C6C;text-align:right;float:right;font-size:11px;display:none;margin-right:10px'></div>
				</td>
			</tr>
			<tr><td width='100%' style='padding:2px;height:30px;'><input style='width:100%;height:26px' type='text' id='input' readonly='readonly' placeholder='Escribe un Mensaje...'></td></tr>
		</table>
	</div>
	<table width="100%" height="100%" border="0" style='border-collapse: collapse;'>
		<tr>
		    <th style='background-color: #2d4b7c;' height='25px'>
		    	<input type='checkbox' id='btn-menu'>
		    	<label for='btn-menu' align='left'><img src='../ventasfuera/menu-icon.png'></label>
			    <nav class="menu">
			    	<?php
				switch ($_SESSION['cargo']) {
					case 'ADMIN':
						?>
						<ul>
							<li style="background-color: #F63;"><a href="#" >ADMINISTRACION</a>
						  		<ul>
									<li><a href="../proveedor/" target="contenedor">PROVEEDORES</a></li>
									<li><a href="../cliente/" target="contenedor">CLIENTES</a></li>
									<li><a href="../transportista/" target="contenedor">TRANSPORTISTAS</a></li>
									<li><a href="../usuario/" target="contenedor">USUARIOS</a></li>
									<li><a href="../producto/" target="contenedor">PRODUCTOS</a></li>
									<li><a href="../marca/" target="contenedor">MARCAS</a></li>
									<li><a href="../familia/" target="contenedor">FAMILIAS</a></li>
									<li><a href="../query/" target="contenedor">CONSULTAS</a></li>
									<li><a href="http://www.sunat.gob.pe/cl-ti-itmrconsruc/jcrS00Alias" target="_blank">RUC</a></li>
								</ul>
							</li>
						</ul>
						<ul>
							<li><a href="#" >COMPRAS</a>
							  	<ul>
									<li><a href="../compras/" target="_blank">COMPRAS</a></li>
									<li><a href="../calendario/" target="contenedor">CRONOGRAMA PAGOS</a></li>
									<li><a href="../maps/" target="contenedor">GOOGLE MAPS</a></li>
								</ul>
							</li>
						</ul>
						<ul>
							<li><a href="#" >VENTAS</a>
							  	<ul>
									<li><a href="../caja/" target="_blank">CAJA TIENDA</a></li>
									<li><a href="../ventas/" target="_blank">VENTA TIENDA</a></li>
									<li><a href="../ganancias/" target="contenedor">GANANCIA POR VENTA</a></li>
									<li><a href="../malogrados/" target="contenedor">REPORTE MALOGRADOS</a></li>
									<li><a href="../ticketpromedio/" target="contenedor">TICKET PROMEDIO</a></li>
								</ul>
							</li>
						</ul>
						<ul>
							<li><a href="#" >TESORERIA</a>
							  	<ul>
									<li><a href="../cajadeldia/" target="contenedor">CAJA DEL DIA</a></li>
									<li><a href="../cajamayor/" target="contenedor">CAJA MAYOR</a></li>
									<li><a href="../cajamayorefectivo/" target="contenedor">CAJA MAYOR EFECTIVO</a></li>
                  					<li><a href="../cajamayortarjeta/" target="contenedor">CAJA MAYOR TARJETA</a></li>
									<li><a href="../cobranzas/" target="contenedor">COBRO CLIENTES</a></li>
									<li><a href="../pagoproveedor/" target="contenedor">PAGO PROVEEDORES</a></li>
									<li><a href="../prestamos/" target="contenedor">PAGO PRESTAMOS</a></li>
									<li><a href="../egresos/" target="contenedor">INGRESO/EGRESO</a></li>
								</ul>
							</li>
						</ul>
						<ul>
							<li><a href="#" >ESTADISTICAS</a>
							  	<ul>
									<li><a href="../kardex_cliente/" target="contenedor">REPORTE CLIENTES</a></li>
									<li><a href="../kardex_proveedor/" target="contenedor">REPORTE PROVEEDORES</a></li>
								</ul>
							</li>
						</ul>
						<ul>
							<li><a href="salir.php" >SALIR</a></li>
						</ul>
						<?php
					break;
					case 'ENCARGADOTIENDA':
						?>
						<ul>
							<li style="background-color: #F63;"><a href="#" >ADMINISTRACION</a>
						  		<ul>
									<li><a href="../proveedor/" target="contenedor">PROVEEDORES</a></li>
									<li><a href="../cliente/" target="contenedor">CLIENTES</a></li>
									<li><a href="../transportista/" target="contenedor">TRANSPORTISTAS</a></li>
									<li><a href="../producto/" target="contenedor">PRODUCTOS</a></li>
									<li><a href="../marca/" target="contenedor">MARCAS</a></li>
									<li><a href="../familia/" target="contenedor">FAMILIAS</a></li>
									<li><a href="../query/" target="contenedor">CONSULTAS</a></li>
									<li><a href="http://www.sunat.gob.pe/cl-ti-itmrconsruc/jcrS00Alias" target="_blank">RUC</a></li>
								</ul>
							</li>
						</ul>
						<ul>
							<li><a href="#" >COMPRAS</a>
							  	<ul>
									<li><a href="../compras/" target="_blank">COMPRAS</a></li>
									<li><a href="../calendario/" target="contenedor">CRONOGRAMA PAGOS</a></li>
									<li><a href="../maps/" target="contenedor">GOOGLE MAPS</a></li>
								</ul>
							</li>
						</ul>
						<ul>
							<li><a href="#" >VENTAS</a>
							  	<ul>
									<li><a href="../caja/" target="_blank">CAJA TIENDA</a></li>
									<li><a href="../ventas/" target="_blank">VENTA TIENDA</a></li>
									<li><a href="../ganancias/" target="contenedor">GANANCIA POR VENTA</a></li>
									<li><a href="../malogrados/" target="contenedor">REPORTE MALOGRADOS</a></li>
									<li><a href="../ticketpromedio/" target="contenedor">TICKET PROMEDIO</a></li>
								</ul>
							</li>
						</ul>
						<ul>
							<li><a href="#" >TESORERIA</a>
							  	<ul>
									<li><a href="../cajadeldia/" target="contenedor">CAJA DEL DIA</a></li>
									<li><a href="../cajamayor/" target="contenedor">CAJA MAYOR</a></li>
									<li><a href="../cajamayorefectivo/" target="contenedor">CAJA MAYOR EFECTIVO</a></li>
                  					<li><a href="../cajamayortarjeta/" target="contenedor">CAJA MAYOR TARJETA</a></li>
									<li><a href="../cobranzas/" target="contenedor">COBRO CLIENTES</a></li>
									<li><a href="../pagoproveedor/" target="contenedor">PAGO PROVEEDORES</a></li>
									<li><a href="../prestamos/" target="contenedor">PAGO PRESTAMOS</a></li>
									<li><a href="../egresos/" target="contenedor">INGRESO/EGRESO</a></li>
								</ul>
							</li>
						</ul>
						<ul>
							<li><a href="#" >ESTADISTICAS</a>
							  	<ul>
									<li><a href="../kardex_cliente/" target="contenedor">REPORTE CLIENTES</a></li>
									<li><a href="../kardex_proveedor/" target="contenedor">REPORTE PROVEEDORES</a></li>
								</ul>
							</li>
						</ul>
						<ul>
							<li><a href="salir.php" >SALIR</a></li>
						</ul>
						<?php
					break;					
					case 'ASISTENTE':
						?>
						<ul>
							<li style="background-color: #FF6500;"><a href="#" >ADMINISTRACION</a>
						  		<ul>
									<li><a href="../cliente/" target="contenedor">CLIENTES</a></li>
									<li><a href="http://www.sunat.gob.pe/cl-ti-itmrconsruc/jcrS00Alias" target="_blank">RUC</a></li>
								</ul>
							</li>
						</ul>
						<ul>
							<li><a href="#" >VENTAS</a>
							  	<ul>
									<li><a href="../caja/" target="_blank">CAJA TIENDA</a></li>
									<li><a href="../ventas/" target="_blank">VENTA TIENDA</a></li>
									<li><a href="../malogrados/" target="contenedor">REPORTE MALOGRADOS</a></li>
								</ul>
							</li>
						</ul>
						<ul>
							<li><a href="#" >TESORERIA</a>
							  	<ul>
									<li><a href="../cajadeldia/" target="contenedor">CAJA DEL DIA</a></li>
									<li><a href="../cajamayor/" target="contenedor">CAJA MAYOR</a></li>
									<li><a href="../cajamayorefectivo/" target="contenedor">CAJA MAYOR EFECTIVO</a></li>
                  					<li><a href="../cajamayortarjeta/" target="contenedor">CAJA MAYOR TARJETA</a></li>
									<li><a href="../cobranzas/" target="contenedor">COBRO CLIENTES</a></li>
									<li><a href="../pagoproveedor/" target="contenedor">PAGO PROVEEDORES</a></li>							
									<li><a href="../egresos/" target="contenedor">INGRESO/EGRESO</a></li>
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
							<li style="background-color: #FF6500"><a href="#" >ADMINISTRACION</a>
						  		<ul>
									<li><a href="../cliente/" target="contenedor">CLIENTES</a></li>
									<li><a href="../maps/" target="contenedor">GOOGLE MAPS</a></li>
								</ul>
							</li>
						</ul>
						<ul>
							<li><a href="http://www.sunat.gob.pe/cl-ti-itmrconsruc/jcrS00Alias" target="_blank">SUNAT RUC</a></li>
						</ul>
						<ul>
							<li><a href="#" >VENTAS</a>
							  	<ul>
									<li><a href="../caja/" target="_blank">CAJA</a></li>
								</ul>
							</li>
						</ul>
						<ul>
							<li><a href="#" >TESORERIA</a>
							  	<ul>
									<li><a href="../cajadeldia/" target="contenedor">CAJA DEL DIA</a></li>
									<li><a href="../cobranzas/" target="contenedor">COBRO CLIENTES</a></li>
									<li><a href="../cajamayor/" target="contenedor">CAJA MAYOR</a></li>
									<li><a href="../cajamayorefectivo/" target="contenedor">CAJA MAYOR EFECTIVO</a></li>
								</ul>
							</li>				
						</ul>
						<ul>
							<li><a href="salir.php" >SALIR</a></li>
						</ul>

						<?php
					break;
					case 'VENDEDOR':
						?>
						<ul>
							<li><a href="http://www.sunat.gob.pe/cl-ti-itmrconsruc/jcrS00Alias" target="_blank">SUNAT RUC</a></li>
						</ul>
						<ul>
							<li><a href="../producto/" target="contenedor">PRODUCTOS</a></li>
						</ul>
						<ul>
							<li><a href="../ventas/" target="_blank">VENTAS</a></li>
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
       			<iframe name="contenedor" src="inicio.html" style='border: none;top: 0; right: 0;bottom: 0; left: 0;width: 100%;height: 100%;'>
	    	</th>
	 	</tr>
	</table>
	
</body>
<html>
<?php }else{
	header("Location: ../");
} ?>
