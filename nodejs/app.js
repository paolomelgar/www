const request = require('request').defaults({jar: true});
const cheerio = require('cheerio');
var app = require('express')(), 
server = require('http').createServer(app), 
io = require('socket.io').listen(server),
mysql = require('mysql');
server.listen(4000);

app.get('/',function(req,res){ 
	res.sendFile(__dirname+'/index.html'); 
}); 
console.log('Conexion correcta.');
const clean   = str => str.replace(/\s+/g, ' ');
const urlCode = 'http://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/captcha?accion=random';
const urlPost = 'http://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/jcrS00Alias';
var usuarios=[]; 
io.on('connection',function(socket){ 
	socket.on('room', function(room) {
        socket.join(room);
    });
    socket.on('usuario',function(data){ 
		var connection = mysql.createConnection({host:'localhost',user:'root',password:'',database:data.local});
		var query = connection.query('SELECT * FROM usuario WHERE nombre="'+data.usuario+'" AND activo="SI"', function(error, result){
	        if(error){
	           throw error;
	        }else{
	            if(result.length>0){
					var users = new Array();
					users[0] = data.usuario;
					users[1] = socket.id;
					usuarios.push(users);
					socket.usuario=socket.id; 
					io.sockets.in("chat").emit('usuario',Array.from(new Set(usuarios.map(x=> x[0]))));
					console.log('Usuarios: '+Array.from(new Set(usuarios.map(x=> x[0]))));
					socket.join("chat");
	            }else{
					socket.emit('delete');
	            }
		    }
		});
	}); 
	socket.on('notificacion',function(data){ 
	   io.sockets.in(data).emit('notificacion',"");
		    
		
	});
	socket.on('sunat', (data) => { 
		request(urlCode, (err, response, code) => {
		  const formData = {
		    nroRuc:data, 
		    accion:'consPorRuc', 
		    numRnd: code
		  };
		  request.post({url:urlPost, form: formData}, (err, response, body)=>{ 
		    if (!err && response.statusCode == 200) {
		      const $ = cheerio.load(body);
		      const $table = $(".form-table").eq(2);
		      var i=0;
		      var razon,direccion;
		      $table.find('tr').each((i, el)=>{
		        const b = $(el).find('td[colspan=3]');
		        if(i==0){
		        	razon=clean(b.text()).substr(14);
			    }else if(i==6){
			    	direccion=clean(b.text());
			    }
		        i++;
		      });
		      if(razon.includes("SOCIEDAD COMERCIAL DE RESPONSABILIDAD LIMITADA")){
		      	razon=razon.replace("SOCIEDAD COMERCIAL DE RESPONSABILIDAD LIMITADA", "S.R.L.");
		      }else if(razon.includes("SOCIEDAD ANONIMA CERRADA")){
		      	razon=razon.replace("SOCIEDAD ANONIMA CERRADA", "S.A.C.");
		      }else if(razon.includes("SOCIEDAD ANONIMA")){
		      	razon=razon.replace("SOCIEDAD ANONIMA", "S.A.");
		      }else if(razon.includes("EMPRESA INDIVIDUAL DE RESPONSABILIDAD LIMITADA")){
		      	razon=razon.replace("EMPRESA INDIVIDUAL DE RESPONSABILIDAD LIMITADA", "E.I.R.L.");
		      }
			  socket.emit("sunat",{ 
					razon:razon,
					direccion:direccion
				});
		      return;
		    }
		    socket.emit("sunat",{ 
					razon:"No encuentra la Base de Datos de la Sunat",
					direccion:""
				});
		  });
		});
	});
}); 