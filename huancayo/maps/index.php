<!DOCTYPE html>
<html>
<head>
	<title>MAPS</title>
	<meta charset="utf-8" />
	<link type="text/css" href="../jquery-ui-1.10.4.custom.min.css" rel="stylesheet" />
	<link type="text/css" href="../bootstrap.min.css" rel="stylesheet" />
	<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyA2i8NDRSI90Nk1FGt9aN0Nu5m7HE2c1t8&sensor=false"></script>
	<script type="text/javascript" src="../jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="../jquery-ui-1.10.4.custom.min.js"></script>
	<script>
	var map;
	function initialize() {
		var mapProp = {
		  center:new google.maps.LatLng(-9.932211,-76.241930),
		  zoom:15,
		  mapTypeId:google.maps.MapTypeId.ROADMAP
		  };
		map=new google.maps.Map(document.getElementById("googleMap"),
			mapProp);
		var marker;
		<?php 
            $con =  mysqli_connect('localhost','root','','paolo');
                    mysqli_query ($con,"SET NAMES 'utf8'"); 
            $q=mysqli_query($con,"SELECT cliente,latitud,longitud,activo FROM cliente WHERE latitud!='' AND longitud!=''");
            while ($row=mysqli_fetch_assoc($q)){
            	if($row['activo']=='SI' ){ ?>
	            	marker=new google.maps.Marker({
						position:new google.maps.LatLng(<?php echo $row['latitud']; ?>,<?php echo $row['longitud']; ?>),
						map:map
					});
				<?php }else{ ?>
					marker=new google.maps.Marker({
						position:new google.maps.LatLng(<?php echo $row['latitud']; ?>,<?php echo $row['longitud']; ?>),
						map:map,
						icon:'iconos/blank.png'
					});
				<?php } ?>
				marker['infowindow'] = new google.maps.InfoWindow({
		            content: "<?php echo $row['cliente']; ?>",
		        });

			    google.maps.event.addListener(marker, 'mouseover', function() {
			        this['infowindow'].open(map, this);
			    });
			    google.maps.event.addListener(marker, 'mouseout', function() {
			        this['infowindow'].close(map, this);
			    });
            <?php
            } 
        ?>
	}
	
	$(function(){
		initialize();
		$("input:text").focus(function(){
		    $(this).select(); 
		}).click(function(){ 
		    $(this).select(); 
		});
		$('#fecha').datepicker({
		    firstDay:1,
		    dateFormat:'dd/mm/yy',
		    changeMonth: true,
		    changeYear: true,
		    monthNames: ['Enero', 'Febrero', 'Marzo',
		    'Abril', 'Mayo', 'Junio',
		    'Julio', 'Agosto', 'Setiembre',
		    'Octubre', 'Noviembre', 'Diciembre'],
		    dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa']
		});
		var date = new Date();
  		$('#fecha').datepicker('setDate', date);
		$('select[id="vendedor"]').val(" ");
		var markerss=[];
		var polyline = [];
		var flightPath=new google.maps.Polyline({
		    path: polyline,
		    strokeColor: '#FF0000',
		    strokeOpacity: 1.0,
		    strokeWeight: 2
		  });
		$('select[id="vendedor"]').change(function(){
			flightPath.setMap(null);
			polyline=[];
			for (var i = 0; i < markerss.length; i++) {
                markerss[i].setMap(null);
            }
			$.ajax({
                type: "POST",
                url: "position.php",
                dataType: "json",
                data: 'vendedor='+$(this).val()+'&fecha='+$('#fecha').val(),
                success: function(data){
		            for (var i=0;i<data[0].length;i++) {
	                    markers=new google.maps.Marker({
							position:new google.maps.LatLng(data[0][i] ,data[1][i]),
							map:map,
							icon:'iconos/marker'+(i+1)+'.png'
						});
						markers['infowindow'] = new google.maps.InfoWindow({
				            content: data[2][i] ,
				        });

					    google.maps.event.addListener(markers, 'mouseover', function() {
					        this['infowindow'].open(map, this);
					    });
					    google.maps.event.addListener(markers, 'mouseout', function() {
					        this['infowindow'].close(map, this);
					    });
					    polyline.push(new google.maps.LatLng(data[0][i] ,data[1][i]));
					    markerss.push(markers);
	                }
	                flightPath = new google.maps.Polyline({
					    path: polyline,
					    geodesic: true,
					    strokeColor: '#0325FF',
					    strokeOpacity: 1.0,
					    strokeWeight: 2
					  });
	                 flightPath.setMap(map);
                }
            });	
		});
		$('#fecha').change(function(){
			flightPath.setMap(null);
			polyline=[];
			for (var i = 0; i < markerss.length; i++) {
                markerss[i].setMap(null);
            }
			$.ajax({
                type: "POST",
                url: "position.php",
                dataType: "json",
                data: 'vendedor='+$('#vendedor').val()+'&fecha='+$(this).val(),
                success: function(data){
		            for (var i=0;i<data[0].length;i++) {
	                    markers=new google.maps.Marker({
							position:new google.maps.LatLng(data[0][i] ,data[1][i]),
							map:map,
							icon:'iconos/marker'+(i+1)+'.png'
						});
						markers['infowindow'] = new google.maps.InfoWindow({
				            content: data[2][i] ,
				        });

					    google.maps.event.addListener(markers, 'mouseover', function() {
					        this['infowindow'].open(map, this);
					    });
					    google.maps.event.addListener(markers, 'mouseout', function() {
					        this['infowindow'].close(map, this);
					    });
					    markerss.push(markers);
					    polyline.push(new google.maps.LatLng(data[0][i] ,data[1][i]));
	                }
	                flightPath = new google.maps.Polyline({
					    path: polyline,
					    geodesic: true,
					    strokeColor: '#0325FF',
					    strokeOpacity: 1.0,
					    strokeWeight: 2
					  });
	                 flightPath.setMap(map);
                }
            });	
			
		})
		
		$("#cliente").autocomplete({
		    source:"cliente.php",
		    minLength:1,
		    select: function (e,ui) {
		    	cliente=ui.item.value;
		    	$.ajax({
                type: "POST",
                url: "buscar.php",
                dataType: "json",
                data: 'b='+cliente,
                success: function(data){
                	var infowindow = new google.maps.InfoWindow({
					    content: cliente
					});
					var marker1 = new google.maps.Marker({
					    position: new google.maps.LatLng(data[0],data[1]),
					    map: map
					});
					infowindow.open(map,marker1);
			        google.maps.event.addListenerOnce(map, 'idle', function() {
					google.maps.event.trigger(map, 'resize');
					map.setCenter(new google.maps.LatLng(data[0],data[1]));
					});
                }
              });		    
		    }
		});
	})
	</script>
	<style>
      html, body, #googleMap {
        height: 100%;
        margin: 0px;
        padding: 0px;

      }
      #googleMap img {
	    max-width: none;
	  }
	  .gm-style-iw {
	  	padding: 1px 1px 1px 1px;
	  }
    </style>
</head>
<body>
	<div id='ferreteria' style='position:fixed;z-index:1000;margin-left:100px'>
		<tr>
			<td>CLIENTE: <input type='text' id='cliente' style='text-transform:uppercase'></td>
			<td>PROMOTOR: 
				<?php 
                require_once('../connection.php'); 
                $q=mysqli_query($con,"SELECT * FROM usuario WHERE activo='SI' AND cargo!='CLIENTE'");
                        ?>
              <select name="vendedor" id="vendedor">
                <?php while ($row=mysqli_fetch_assoc($q)){?>
                <option value="<?php echo $row['nombre']?>"><?php echo $row['nombre']?></option>
                <?php } ?>
              </select>
			</td>
			<td>FECHA: <input type='text' id='fecha' style='width:90px;text-align:right'></td>
		</tr>
	</div>
	<div id="googleMap"></div>
</body>
</html>
