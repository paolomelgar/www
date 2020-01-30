<?php 
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>INNOVA - Iniciar Sesion</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="favicon.ico"/>
<link type="text/css" href="bootstrap.min.css" rel="stylesheet" />
<link type="text/css" href="sweet-alert.css" rel="stylesheet" />
<script type="text/javascript" src="jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="jquery-ui-1.10.4.custom.min.js"></script>
<script type="text/javascript" src="bootstrap.min.js"></script>
<script type="text/javascript" src="sweet-alert.min.js"></script>
<script type="text/javascript">
  $(function(){
    var sesion="<?php if(isset($_SESSION['valida']) && $_SESSION['valida']!="false"){echo $_SESSION['valida'];}else{echo "";}; ?>";
    var cargo="<?php if(isset($_SESSION['valida']) && $_SESSION['valida']!="false"){echo $_SESSION['cargo'];}else{echo "";}; ?>";
    if(sesion!=""){
      if (screen.width <= 699) {
        location.href="mobile/";
      }else{
        if(cargo=='CLIENTE'){
          location.href="ventasfuera/";
        }else{
          location.href="sistema/";
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
              location.href="mobile/";
            }else{
              if(data[0]=='CLIENTE'){
                location.href="ventasfuera/";
              }else{
                location.href="sistema/";
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
    background: url('http://www.ferreteriaflorida.com/_bd/_img/555251944758a48d21a57ae1cca8d6ab.jpg') ;
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
        <div class="modal-header" style='background-color:#FE6B08;color:white'>
          <h2 class="modal-title" align='middle'>&iexclIniciar Sesi&oacuten!</h2>
        </div>
        <div class="modal-body" style='text-align:center'>   
          <img src="logo_innova.png" width='70%' align="middle">
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
                <option value='dorispovez'>Doris Povez</option>
                <option value='johannagutierrez'>Johanna Gutierrez</option>
                <option value='prolongacionhuanuco'>Prol huanuco</option>
                <option value='laprincipal'>La Principal</option>
                <option value='innovahuanuco'>Innova Huanuco</option>
                <option value='innovaprincipal'>Innova Principal</option>
                <option value='jauja'>Jauja</option>
                <option value='tingomaria'>Tingo Maria</option>
                <option value='tarapac'>Tarapaca</option>
                <option value='kalimax'>Kalimax</option>
                <option value='ayacucho'>Ayacucho</option>
                <option value='fitfood'>Fit Food</option>
              </select>
            </div>
            <div style='margin-top:10px'><input class="btn btn-warning" name="button" id="button" value="Iniciar Sesion" type="button"></div>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>