<?php include_once("conexiones/conexionpedidos.php"); ?>

<?php
//acceso.php

session_start();

if (isset($_SESSION["usuario"])) {

     header("location:index.php");
     exit();
}

//REGISTRO

if (isset($_POST["registro"])) {
     if (empty($_POST["usuario"]) || empty($_POST["passwd"]) || empty($_POST["passwdrepeat"])) 
     {
          echo '<script>alert("Rellene los campos")</script>';
     }
     else
     {     

          if(($_POST["passwd"]) == ($_POST["passwdrepeat"])){
               $usuariorepeat = mysqli_real_escape_string($conexionpedidos, $_POST["usuario"]);
               $sqlbuscarusuario = "SELECT * FROM tblusuarios
                                   WHERE strNombre ='" . $usuariorepeat . "'";

               $resultadobuscar = mysqli_query($conexionpedidos, $sqlbuscarusuario);
               $countrow = mysqli_num_rows($resultadobuscar);

               if ($countrow == 1) 
               {
                    echo "<script>
                              alert('Este usuario ya esta registrado en el sistema. Por favor escoga otro Nombre')
                         </script>";
               } 
               else
               {

                    $usuario = mysqli_real_escape_string($conexionpedidos, $_POST["usuario"]);
                    $password = mysqli_real_escape_string($conexionpedidos, $_POST["passwd"]);
                    $passwdhash = password_hash($password, PASSWORD_DEFAULT);


                    $sqlinsert = "INSERT INTO tblusuarios (strNombre, strPasswd) 
                    VALUES('$usuario', '$passwdhash')";


                    if (mysqli_query($conexionpedidos, $sqlinsert)) 
                    {

                         echo '<script>alert("Registro correcto")</script>';
                    }
               }
          }else{
               echo '<script>alert("Las contraseñas no coinciden")</script>';
          }     
     }
}

//LOGIN

if (isset($_POST["login"])) {

     if (empty($_POST["usuario"]) || empty($_POST["passwd"])) {

          echo '<script>alert("Rellene los campos")</script>';
     } else {


          $usuario = mysqli_real_escape_string($conexionpedidos, $_POST["usuario"]);
          $password = mysqli_real_escape_string($conexionpedidos, $_POST["passwd"]);
          $sqlselect = "SELECT * FROM tblusuarios WHERE strNombre = '$usuario'";
          $resultado = mysqli_query($conexionpedidos, $sqlselect);
          

          if (mysqli_num_rows($resultado) > 0) {

               while ($row = mysqli_fetch_array($resultado)) {

                    if (password_verify($password, $row["strPasswd"])) {

                             
                         
                         $_SESSION["usuario"] = $usuario;
                         $_SESSION['nivel']  = $row["strNivel"];
                         $_SESSION['instante'] = time();
                         $tipoususario = $row["strNivel"];

                         mysqli_free_result($resultado);

                         header("location:index.php");
                    }
                    else{
                         echo '<script>alert("Datos de acceso incorrectos")</script>';
                    }
               }
          } else {

               echo '<script>alert("Datos de registro erroneos")</script>';
          }
     }
     desconexionpedidos();
}
?>
<!DOCTYPE html>
<html>

<head>
     <?php include_once("includes/loginmeta.php"); ?>
     <title>Login</title>

</head>

<body>

     <body class="bg-gradient-primary">

          <div class="container">

               <!-- Outer Row -->
               <div class="row justify-content-center">

                    <div class="col-xl-10 col-lg-12 col-md-9">

                         <div class="card o-hidden border-0 shadow-lg my-5">
                              <div class="card-body p-0">
                                   <!-- Nested Row within Card Body -->
                                   <div class="row">
                                        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                                        <div class="col-lg-6">
                                             <div class="p-5">
                                                  <div class="text-center">
                                                       <h1 class="h4 text-gray-900 mb-4">Acceder al Sistema</h1>
                                                  </div>

                                                  <?php
                                                  if (isset($_GET["action"]) == "login") {
                                                  ?>

                                                       <h3 align="center">Login</h3>
                                                       <br />
                                                       <form class="user" action="" method="POST">
                                                            <div class="form-group">
                                                                 <input type="text" name="usuario" class="form-control form-control-user" aria-describedby="emailHelp" placeholder="Introduce tu nombre de usuario..." required/>
                                                            </div>
                                                            <div class="form-group">
                                                                 <input type="password" name="passwd" class="form-control form-control-user" aria-describedby="emailHelp" placeholder="Introduce tu contraseña usuario..." required/>
                                                            </div>
                                                            <div class="form-group">
                                                                
                                                            </div>
                                                            <input type="submit" name="login" value="Login" class="btn btn-primary btn-user btn-block" />
                                                       </form>
                                                       <div class="text-center">
                                                            <p><a class="small" href="acceso.php">Registro</a>
                                                            <?php
                                                       } else {
                                                            ?>
                                                            </p>
                                                            <p><br />
                                                            </p>
                                                            <h3 align="center">Registro</h3>
                                                            <br />
                                                            <form class="user" action="" method="POST">
                                                                 <div class="form-group">
                                                                      <input type="text" name="usuario" class="form-control form-control-user" aria-describedby="emailHelp" placeholder="Introduce tu nombre para registrarte..."required />
                                                                 </div>
                                                                 <div class="form-group">
                                                                      <input type="password" name="passwd" class="form-control form-control-user" aria-describedby="emailHelp" placeholder="Introduce tu contraseña para registrarte..."required />
                                                                 </div>
                                                                 <div class="form-group">
                                                                      <input type="password" name="passwdrepeat" class="form-control form-control-user" aria-describedby="emailHelp" placeholder="Introduce de nuevo tu contraseña..."required />
                                                                 </div>
                                                                 <input type="submit" name="registro" value="Registrarse" class="btn btn-primary btn-user btn-block" />
                                                                 <br />
                                                                 <p align="center"><a href="acceso.php?action=login">Login</a></p>
                                                            </form>
                                                       <?php
                                                       }
                                                       ?>
                                                       </div>

                                                       <!-- Bootstrap core JavaScript-->
                                                       <script src="vendor/jquery/jquery.min.js"></script>
                                                       <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

                                                       <!-- Core plugin JavaScript-->
                                                       <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

                                                       <!-- Custom scripts for all pages-->
                                                       <script src="js/sb-admin-2.min.js"></script>


     </body>

</html>