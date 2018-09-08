$(function(){
	$( document ).tooltip({
		show: null,
        position: {
        my: "left top",
        at: "left bottom"
      },
      open: function( event, ui ) {
        ui.tooltip.animate({ top: ui.tooltip.position().top + 10 }, "fast" );
      },
		content:function(){
        return this.getAttribute("title");
      }
	});
	$('#fecha').datepicker({
	    firstDay:1,
	    dateFormat:'dd/mm/yy',
	    monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Setiembre','Octubre','Noviembre','Diciembre'],
	    dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa']
	});
	function buscar(m,y){
		$.ajax({
	      type: "POST",
	      url: "calendar.php",
	      data: 'm='+m+'&y='+y,
	      beforeSend:function(){
            swal({
              title: "...",
              imageUrl: "../loading.gif",
              showConfirmButton: false
            });
          },
	      success: function(data){
	      	swal.close();
	      	$('#map').empty();
	      	$('#map').append(data);
	      }
		});
	}
	function editar(id,value,tipo){
		$.ajax({
            type: "POST",
            url: "editarnumero.php",
            data: {id:id,
            	   value:value,
            	   tipo:tipo},
            success: function(data){
				swal({
		            title: "Correcto",
		            text: "Operacion Realizada Correctamente",
		            imageUrl: "../correcto.jpg"
		          },
		          function(isConfirm){
		            if (isConfirm) {
		              buscar($('#month').val(),$('#year').val());
		            } 
		        });
            }
        })
	}
	var date= new Date();
	$('#month').val(parseInt(date.getMonth())+1);
	$('#year').val(date.getFullYear());
	buscar($('#month').val(),$('#year').val());
	$('#month').change(function(){
		buscar($('#month').val(),$('#year').val());
	});
	$('#year').change(function(){
		buscar($('#month').val(),$('#year').val());
	});
	$('#prev').click(function(){
		if(parseInt($('#month').val())<=1){
			$('#month').val(12);
			$('#year').val(parseInt($('#year').val())-1);
		}else{
			$('#month').val(parseInt($('#month').val())-1);
		}
  		buscar($('#month').val(),$('#year').val());
  	});
  	$('#next').click(function(){
		if(parseInt($('#month').val())>=12){
			$('#month').val(1);
			$('#year').val(parseInt($('#year').val())+1);
		}else{
			$('#month').val(parseInt($('#month').val())+1);
		}
  		buscar($('#month').val(),$('#year').val());
  	});
  	
	$('#map').on('dblclick','tr td', function() {
	});
	var id;
	var dat;
	$('#map').on('click','.letra',function(){
		$('#unico').val("");
		$('.un').show();
	    var fecha=$(this).parent().find('.daynum').text()+"/"+$('#month').val()+"/"+$('#year').val();
	    $("#fecha").datepicker("setDate", fecha);
		id=$(this).attr('id')
		$('#myModal').modal();
		$('.modal-title').text($(this).text());
		dat="fecha";
	});
	$('#map').on('click','.total',function(){
		$('.un').hide();
	    var fecha=$(this).parent().find('.daynum').text()+"/"+$('#month').val()+"/"+$('#year').val();
	    $("#fecha").datepicker("setDate", fecha);
		id=$(this).attr('id')
		$('#myModal').modal();
		$('.modal-title').text($(this).text());
		dat="total";
	});
	$('#realunico').click(function(){
		editar(id,$('#unico').val(),"unico");
	});
	$('#realfecha').click(function(){
		editar(id,$('#fecha').val(),dat);
	});
});