<?php include_once("conexiones/conexionpedidos.php"); ?>

<?php
session_start();
//var_dump($_SESSION);

if (!isset($_SESSION["usuario"])) {

  header("location:acceso.php?action=login");
  exit();
}

$timenow = time();
if ((($timenow - $_SESSION["instante"]) > $timexpired)) {

  session_destroy();
  header("Location:acceso.php?action=login");
  exit();
}

$_SESSION["instante"] = $timenow;

?>

<html lang="es">
<!-- InstanceBegin template="/Templates/principal.dwt.php" codeOutsideHTMLIsLocked="false" -->

<head>
  <?php include_once("includes/meta.php"); ?>
  <?php include_once("includes/head.php"); ?>

  <!-- InstanceBeginEditable name="doctitle" -->
  <title>Dashboard Gestion Pedidos</title>
  <!-- InstanceEndEditable -->
  <!-- Custom fonts for this template-->

  <!-- InstanceBeginEditable name="head" -->
  <!-- InstanceEndEditable -->
</head>

<body id="page-top">
  <!-- InstanceBeginEditable name="contenido" -->
  <!-- Page Wrapper -->
  <div id="wrapper">
    <!-- Sidebar -->
    <?php include_once("includes/menu.php"); ?>
    <!-- End of Sidebar -->
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
      <!-- Main Content -->
      <div id="content">
        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Search -->
          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>
            <!-- Nav Item - Alerts -->

            <!-- Nav Item - Messages -->
            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION["usuario"] ?></span>
                <img class="img-profile rounded-circle" src="https://source.unsplash.com/QAB-WJcbgJk/60x60">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>
          </ul>
        </nav>
        <!-- End of Topbar -->
        <!-- Begin Page Content -->
        <!-- /.container-fluid -->
        <div class="container-fluid">
          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Resultados de la busqueda de pedidos...</h1>
            <a href="logout.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Cerrar Sesion</a>
          </div>
          <!-- Content Row -->
          <div class="row">
            <div class="col-lg-12 mx-auto">
              <div class="page-header clearfix">
                <!-- AÑADIR PEDIDO -->
                <?php if ($_SESSION['nivel'] == $usuarioadmin) { ?>
                  <a href="pedidos_add.php" class="btn btn-success pull-right">Nuevo Pedidos</a>
                <?php } ?>
              </div>
              <?php
              
              if (isset($_POST['buscarpedido'])) 
              {
                
                $fechapedido1 = $_POST['fechapedido1'];
                $fechapedido2 = $_POST['fechapedido2'];

                $fechapedido1 = htmlspecialchars($fechapedido1);
                $fechapedido1 = mysqli_real_escape_string($conexionpedidos, htmlspecialchars($_POST['fechapedido1']));

                $fechapedido2 = htmlspecialchars($fechapedido2);
                $fechapedido2 = mysqli_real_escape_string($conexionpedidos, htmlspecialchars($_POST['fechapedido2']));

                if($fechapedido1 < $fechapedido2 ){  
                
                    $resultado = mysqli_query($conexionpedidos, "SELECT * FROM tblpedidos p 
                                                             INNER JOIN tblclientes c on p.idcliente=c.idCliente 
                                                             WHERE (`dtmFecha` BETWEEN '" . $fechapedido1 . "' AND '" . $fechapedido2 . "') 
                                                             ORDER BY `dtmFecha`");
                    if (mysqli_num_rows($resultado) > 0) 
                    {
                    ?>
                    <table class='table table-hover'>
                        <thead>
                        <td>#</td>
                        <td>Fecha</td>
                        <td>Nombre</td>
                        <td>Apellidos</td>
                        <td>Peso</td>
                        <td>Alto</td>
                        <td>Ancho</td>
                        
                        <?php if ($_SESSION['nivel'] == $usuarioadmin) { ?>
                            <td>Acciones</td>
                        <?php
                        }
                        ?>
                        </thead>
                        <?php
                        $i = 0;
                        while ($row = mysqli_fetch_array($resultado)) {
                        ?>
                        <tr>
                            <td><?php echo $row["idPedido"]; ?></td>
                            <td><?php echo $row["dtmFecha"]; ?></td>
                            <td><?php echo $row["strNombre"]; ?></td>
                            <td><?php echo $row["strApellidos"]; ?></td>
                            <td><?php echo $row["strPeso"]; ?></td>
                            <td><?php echo $row["strAlto"]; ?></td>
                            <td><?php echo $row["strAncho"]; ?></td>
                            <td>
                            <?php if ($_SESSION['nivel'] == $usuarioadmin) { ?>
                                <a href="clientes_edit.php?idCliente=<?php echo $row["idCliente"]; ?>" title='Editar registro'><span class='glyphicon glyphicon-pencil'></span></a>
                                <a href="clientes_delete.php?idCliente=<?php echo $row["idCliente"]; ?>" class="material-icons" onclick="return Confirmation()"><span class="glyphicon glyphicon-trash"></span></a>
                            <?php } ?>
                            </td>
                        </tr>
                        <?php
                        $i++;
                        }
                        mysqli_free_result($resultado);
                        ?>
                    </table>
                    <?php
                    } 
                    else 
                    {
                    echo "No existe ningun pedido .Vuelve a intentarlo";
                    }
                }else{
                    echo '<script>alert("La 1º fecha no puede ser anterior a la 2º fecha intoducida ")</script>'; ?>
                  <a href="index.php" class="btn btn-primary btn-lg"> Atras</a>
                  <div>
                    <?php echo "Por favor vuelve a realizar tu busqueda."; ?>
                  </div>
                  <?php
                }
              }
              else
              {
                echo "Campos de busqueda vacio introduce un rango de fechas";
              }
             
              mysqli_close($conexionpedidos);
              ?>
            </div>
          </div>
        </div>
      </div>
      <!-- End of Main Content -->
      <!-- Footer -->
      <?php include_once("includes/pie.php"); ?>
      <!-- End of Footer -->
    </div>
    <!-- End of Content Wrapper -->
  </div>
  <!-- End of Page Wrapper -->
  <!-- Scroll to Top Button-->
  <?php include_once("includes/scrollbuttonup.php"); ?>
  <!-- Logout Modal-->

  <!-- InstanceEndEditable -->
  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>
  <!-- Page level plugins -->
  <script src="vendor/chart.js/Chart.min.js"></script>
  <!-- Page level custom scripts -->
  <script src="js/demo/chart-area-demo.js"></script>
  <script src="js/demo/chart-pie-demo.js"></script>
</body>
<!-- InstanceEnd -->

</html>