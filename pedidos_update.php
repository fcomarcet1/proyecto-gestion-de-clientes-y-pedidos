<?php include_once("conexiones/conexionpedidos.php"); ?>

<?php
session_start();

if (!isset($_SESSION["usuario"])) {

  header("location:acceso.php?action=login");
}

if (($_SESSION["nivel"]) !== $usuarioadmin) {

  session_destroy();
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


<?php

if (isset($_POST["actualizar"])) {


  $nombre = $_POST['nombre'];
  $dtmFecha = $_POST['fecha'];
  $peso = $_POST['peso'];
  $ancho = $_POST['ancho'];
  $alto = $_POST['alto'];
  $idPedidohdd = $_POST['idPedidoHdd'];
  $idclientehdd = $_POST['cliente'];


  $sqlupdate = "UPDATE tblpedidos 
                  SET idcliente = '" . $_POST['cliente'] . "',
                      dtmFecha='" . $_POST['fecha'] . "',
                      strPeso='" . $_POST['peso'] . "',
                      strAncho='" . $_POST['ancho'] . "' ,
                      strAlto='" . $_POST['alto'] . "'   
               WHERE idPedido='" . $_POST['idPedidoHdd'] . "' ";

  $resultadoupdate = mysqli_query($conexionpedidos, $sqlupdate);

  if (($resultadoupdate)) {
    header("location: pedidos_lista.php");
    exit();
  } else {
    $error = true;
    $error_msg = "Error: " . $sqlupdate . " " . mysqli_error($conexionpedidos);
  }
} else {

  echo "no se recibio el parametro";
}

?>

<?php mysqli_close($conexionpedidos); ?>


<!DOCTYPE html>
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
        <?php include_once("includes/topbar.php"); ?>
        <!-- End of Topbar -->
        <!-- Begin Page Content -->
        <!-- /.container-fluid -->
        <!-- Content Row -->
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
  <?php include_once("includes/logoutmodal.php"); ?>
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