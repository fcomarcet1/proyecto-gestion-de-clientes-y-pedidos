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

<!DOCTYPE html>
<html lang="es">
<!-- InstanceBegin template="/Templates/principal.dwt.php" codeOutsideHTMLIsLocked="false" -->

<head>
  <?php include_once("includes/meta.php"); ?>
  <?php include_once("includes/head.php"); ?>


  <!-- InstanceBeginEditable name="doctitle" -->
  <title>Adminstracion y Gestion de Pedidos</title>
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
                <img class="img-profile rounded-circle" src="img/prestamista.jpg">
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
            <h1 class="h3 mb-0 text-gray-800"> Bienvenido:<?php echo $_SESSION["usuario"] ?> al Panel de Administracion</h1>
            <a href="logout.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
              <i class="fas fa-user-times text-white-50"></i> Cerrar Sesion</a>
              
        </div>
        <!-- Content Row -->
        <div class="row">
            <div class="col-sm">
            <div>
                <div><h4><strong>  CLIENTES</strong></h4></div>
                <a href="clientes_lista.php" class="btn btn-primary btn-lg"> Lista Clientes</a>
            </div>
          <br/>
          <div>
            <!-- Buscador de clientes -->
            <form action="clientes_buscar.php" method="post" class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
              <div class="input-group">
                <label> Buscador de Clientes</label>
                <input type="text" name="cliente" class="form-control bg-light border-0 small" placeholder="Buscar Cliente..." aria-label="Search" aria-describedby="basic-addon2">
                <div class="input-group-append">
                  <button type="submit" value="buscarcliente" name="buscarcliente" id="buscarcliente" class="btn btn-primary">
                    <i class="fas fa-search fa-sm"></i>
                  </button>
                </div>
              </div>
            </form>
          </div>
            </div>
            <div class="col-sm">
            <div>
            <div>
              <h4>
                <strong>PEDIDOS</strong>
              </h4>
            </div>
            <a href="pedidos_lista.php" class="btn btn-primary btn-lg"> Lista Pedidos</a>
          </div>
          <br />
          <div >
            <!-- Buscador de productos -->
                  <form action="pedidos_buscar1.php" method="post" class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                    <div class="input-group">
                    <label> Buscador de Pedidos<br/>(Introduce un intervalo de fechas)</label>
                      <input type="date" name="fechapedido1" class="form-control bg-light border-0 small" placeholder="Buscar Pedido..." aria-label="Search" aria-describedby="basic-addon2" required>
                      <input type="date" name="fechapedido2" class="form-control bg-light border-0 small" placeholder="Buscar Pedido..." aria-label="Search" aria-describedby="basic-addon2" required>
                      <div class="input-group-append">
                        <button type="submit" value="buscarpedido" name="buscarpedido" id="buscarpedido" class="btn btn-primary">
                          <i class="fas fa-search fa-sm"></i>
                        </button>
                      </div>
                    </div>
                  </form>
            </div>
            </div>
            <div class="col-sm">
            </div>
        </div>
    </div>
    <!-- End of Main Content -->
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