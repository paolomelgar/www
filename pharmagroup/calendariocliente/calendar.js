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
	var date= new Date();
	var d=date.getDate();
	var m=date.getMonth();
	var y=date.getFullYear();
	m=parseInt(m)+1;
	m=("00" + m).slice (-2);
	var id=d+""+m+""+y;
	$('select[id="month"]').val(m);
	$('select[id="year"]').val(y);
	$.ajax({
      type: "POST",
      url: "calendar.php",
      data: 'm='+$('#month').val()+'&y='+$('#year').val(),
      success: function(html){
      	$('#map').empty();
      	$('#map').append(html);
      	$('#'+id).css({"background-color":"#F63"});
      }
	});
	$('#month').change(function(){
		$.ajax({
	      type: "POST",
	      url: "calendar.php",
	      data: 'm='+$('#month').val()+'&y='+$('#year').val(),
	      success: function(html){
	      	$('#map').empty();
	      	$('#map').append(html);
	      	$('#'+id).css({"background-color":"#F63"});
	      }
		});
	});
	$('#year').change(function(){
		$.ajax({
	      type: "POST",
	      url: "calendar.php",
	      data: 'm='+$('#month').val()+'&y='+$('#year').val(),
	      success: function(html){
	      	$('#map').empty();
	      	$('#map').append(html);
	      	$('#'+id).css({"background-color":"#F63"});
	      }
		});
	});
	$('#prev').click(function(){
		var prev=parseInt($('#month').val())-1;
		var year=$('#year').val();
		if(prev<=0){
			prev=12;
			var year=parseInt(year)-1;
		}
        prev=("00" + prev).slice (-2);
		$('select[id="month"]').val(prev);
		$('select[id="year"]').val(year);
  		$.ajax({
	      type: "POST",
	      url: "calendar.php",
	      data: 'm='+prev+'&y='+year,
	      success: function(html){
	      	$('#map').empty();
	      	$('#map').append(html);
	      	$('#'+id).css({"background-color":"#F63"});
	      }
		});
  	});
  	$('#next').click(function(){
  		var next=parseInt($('#month').val())+1;
  		var year=$('#year').val();
		if(next>=13){
			next=01;
			var year=parseInt(year)+1;
		}
  		next=("00" + next).slice (-2);
		$('select[id="month"]').val(next);
		$('select[id="year"]').val(year);
  		$.ajax({
	      type: "POST",
	      url: "calendar.php",
	      data: 'm='+next+'&y='+year,
	      success: function(html){
	      	$('#map').empty();
	      	$('#map').append(html);
	      	$('#'+id).css({"background-color":"#F63"});
	      }
		});
  	});
  	$("#map").on('mouseenter',function(){
	    $('#row td').each(function () {
	      $(this).hover(
	        function () {
	          $('#row> td').removeClass('selected');
	          $(this).addClass('selected');
	        }, 
	        function () {
	          $(this).removeClass('selected');
	        }
	      );
	      $(this).click(function(){
	        $("#row td").removeClass('select');
	        $(this).addClass('select');
		  });
		});
	});
	$('#map').on('click','.letra',function(){
		var num=$(this).attr('id');
		swal({   
			title: "Editar N° UNICO!",   
			text: $(this).text(),   
			type: "input",   
			showCancelButton: true,   
			closeOnConfirm: false,   
			confirmButtonColor: "#DD6B55",
			animation: "slide-from-top",   
			inputPlaceholder: "Escribir Unico" 
		}, 
		function(inputValue){   
			if (inputValue === false) 
				return false;      
			if (inputValue === "") {     
				swal.showInputError("Debes Escribir un Numero");     
				return false   
			}      
			$.ajax({
                type: "POST",
                url: "editarnumero.php",
                data: {id:num,
                	   num:inputValue},
                success: function(data){
					swal({
			            title: "Correcto",
			            text: "El nuevo N° Unico es "+inputValue,
			            imageUrl: "../correcto.jpg"
			          },
			          function(isConfirm){
			            if (isConfirm) {
			              location.reload();
			            } 
			        });
                }
            });
		});
	});
});