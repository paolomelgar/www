var app = require('express')(), 
mysql = require('mysql'),
server = require('http').createServer(app), 
io = require('socket.io')(server), 
usuarios=[] ; 
var users={};
var connection = mysql.createConnection({
  host     : 'localhost',
  user     : 'root',
  password : '',
  database : 'paolo'
});
connection.connect(function(error){
   if(error){
      throw error;
   }else{
      console.log('Conexion correcta.');
   }
});
server.listen(3000);

app.get('/',function(req,res){ 
	res.sendFile(__dirname+'/index.html'); 
}); 

io.on('connection',function(socket){ 
	socket.emit('id',socket.id);
	socket.on('usuario',function(data){ 
		var query = connection.query('SELECT * FROM usuario WHERE nombre="'+data.usuario+'" AND activo="SI"', function(error, result){
	        if(error){
	           throw error;
	        }else{
	            if(result.length>0){
					if(data.cargo=='CLIENTE ESPECIAL'){
						var d = new Date();
						datetext = d.toTimeString();
						datetext = datetext.split(' ')[0];
						socket.broadcast.emit('cliente',{
							usuario:data.usuario,
							hora:datetext
						});
					}
					var users = new Array();
					users[0] = data.usuario;
					users[1] = data.cargo;
					users[2] = data.idd;
					usuarios.push(users);
					socket.usuario=data.idd; 
					socket.broadcast.emit('usuario',usuarios); 
					socket.emit('usuario',usuarios);
					console.log('Usuarios: '+usuarios);
	            }else{
					socket.emit('delete');
	            }
		    }
		});
		 
	}); 
	socket.on('con',function(data){
		socket.emit('usuario',usuarios);
	})
	socket.on('user-message',function(data){ 
		var d = new Date();
		datetext = d.toTimeString();
		datetext = datetext.split(' ')[0];
		if(data.message=='visto'){
       		var qq = connection.query('UPDATE chat SET visto="'+datetext+'" WHERE visto="FIN" AND emisor="'+data.receptor+'" AND receptor="'+data.emisor+'"');
		}
		else if(data.message=='fin'){
		    var qq = connection.query('UPDATE chat SET visto="FIN" WHERE visto="MEDIO" AND emisor="'+data.receptor+'" AND receptor="'+data.emisor+'"');
		}
		else if(data.message!='vacio' && data.message!='escribiendo'){
			var q = connection.query("INSERT INTO chat (emisor,receptor,mensaje,fecha,hora,visto) VALUES ('"+data.emisor+"','"+data.receptor+"','"+data.message+"',NOW(),NOW(),'MEDIO')");
			socket.emit(data.emisor,{
				emisor:data.emisor,
				message:"medio",
				receptor:data.receptor
			});
		}
		for(var i = 0; i < usuarios.length; i++) {
		  if(usuarios[i][0] == data.receptor) {
		  	var socketid = usuarios[i][2];
		    if(data.message=='visto'){
	            io.to(socketid).emit(data.receptor,{ 
					emisor:data.emisor,
					message:"visto",
					hora:datetext
				});
			}else if(data.message=='escribiendo'){
				io.to(socketid).emit(data.receptor,{ 
					emisor:data.emisor,
					message:"escribiendo"
				});
			}else if(data.message=='vacio'){
				io.to(socketid).emit(data.receptor,{ 
					emisor:data.emisor,
					message:"vacio"
				});
			}else if(data.message=='fin'){
				io.to(socketid).emit(data.receptor,{ 
					emisor:data.receptor,
					message:"fin",
					receptor:data.emisor
				});
			}else{
				io.to(socketid).emit(data.receptor,{ 
					emisor:data.emisor,
					message:data.message,
					hora:datetext
				});
			}
		  }
		}
	}); 
	socket.on('disconnect',function(data){ 
		if(!socket.usuario) return;
		var index;
		for(var i = 0; i < usuarios.length; i++) {
		   if(usuarios[i][2] == socket.usuario) {
		     index=i;
		   }
		}
		usuarios.splice(index, 1); 
		socket.broadcast.emit('usuario',usuarios);
		console.log('Usuarios: '+usuarios); 
	}); 
	socket.on('notificacion',function(data){ 
		var count;
		if(data>0){
			connection.query('UPDATE total_pedido SET entregado="EDIT" WHERE seriepedido='+data)
		}
		var query = connection.query('SELECT * FROM total_pedido WHERE entregado="NO"', function(error, result){
	        if(error){
	           throw error;
	        }else{
	           count = result.length;
           	   socket.broadcast.emit('notificacion',{ 
					message:count
			   });
			   socket.emit('notificacion',{ 
					message:count
			   });
		    }
		});
		
	});
}); 

