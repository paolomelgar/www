<?php 
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>FERREBOOM - Iniciar Sesion</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="huanuco/favicon.ico"/>
<link type="text/css" href="huanuco/bootstrap.min.css" rel="stylesheet" />
<link type="text/css" href="huanuco/sweet-alert.css" rel="stylesheet" />
<script type="text/javascript" src="huanuco/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="huanuco/jquery-ui-1.10.4.custom.min.js"></script>
<script type="text/javascript" src="huanuco/bootstrap.min.js"></script>
<script type="text/javascript" src="huanuco/sweet-alert.min.js"></script>
<script type="text/javascript">
  $(function(){
    var sesion="<?php if(isset($_SESSION['valida'])){echo $_SESSION['valida'];}else{echo "";}; ?>";
    var cargo="<?php if(isset($_SESSION['valida'])){echo $_SESSION['cargo'];}else{echo "";}; ?>";
    if(sesion!=""){
      if (screen.width <= 699) {
        location.href=sesion+"/mobile";
      }else{
        if(cargo=='CLIENTE'){
          location.href=sesion+"/ventasfuera/";
        }else{
          location.href=sesion+"/";
        }
      }
    }
    $('#myModal').modal({
      backdrop: 'static',
      keyboard: false
    })
    $('#button').click(function(){
      $.ajax({
        type: "POST",
        url: "verificar.php",
        data: $('#form').serialize(),
        dataType: "json",
        success: function(data){
          if(data.length==0){
            $('#user').focus();
            $('#pass').val("");
            swal("Datos Incorrectos","Por favor, Intente corregir sus datos","error");
          }else{
            swal({
                title: "Conectando..",
                text: "Espere un momento por favor",
                imageUrl: "../loading.gif",
                showConfirmButton: false
              });
            if (screen.width <= 699) {
              location.href=data[0]+"/mobile";
            }else{
              if(data[1]=='CLIENTE'){
                location.href=data[0]+"/ventasfuera/";
              }else{
                location.href=data[0]+"/";
              }
            }
          }
        }
      });
    });
  });
</script>
<style type="text/css">
  body{
    background: url('https://higherlogicdownload.s3.amazonaws.com/NSACCT/7e1b22bb-4736-47f7-a45d-41ce8d27e073/UploadedImages/bigstock-set-of-tools-in-tool-box-on-a--51238249.jpg');
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-size: 100% 100%;
  }
  input,select{
    margin-bottom: 0px !important;
  }
</style>
</head>
<body>
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header btn-primary">
          <h2 class="modal-title" align='middle'>&iexclIniciar Sesi&oacuten!</h2>
        </div>
        <div class="modal-body" style='text-align:center'>   
          <img src="https://raw.githubusercontent.com/paolomelgar/ferreboom/master/huanuco/logo_principal.png" width='70%' align="middle">
          <form id="form" name='form' style='margin-top:30px'>
            <div><img src='https://cdn0.iconfinder.com/data/icons/follower/154/follower-man-user-login-round-512.png' width='30px'>
              <input name="user" id="user" type="text" autofocus="autofocus" placeholder="Usuario">
            </div>
            <div style='margin-top:10px'>
            <img src='http://www.freeiconspng.com/uploads/login-key-icon-lock-locked-login-15.png' width='30px'>
              <input name="pass" id="pass" type="password" placeholder="Password">
            </div>
            <div style='margin-top:10px'>
              <img src='https://image.flaticon.com/icons/svg/54/54574.svg' width='30px'>
              <select name="local" id="local">
                <option disabled selected value>Local</option>
                <option value='huanuco'>Huanuco</option>
                <option value='huancayo'>Huancayo</option>
                <option value='huancayoprincipal'>Huancayo Principal</option>
                <option value='tarapaca'>Tarapaca</option>
                <option value='huanucotienda'>Huanuco Tienda</option>
              </select>
            </div>
            <div style='margin-top:10px'><input class="btn btn-primary" name="button" id="button" value="Iniciar Sesion" type="button"></div>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>