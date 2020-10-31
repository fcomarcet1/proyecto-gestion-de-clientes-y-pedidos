<?php include_once("conexiones/conexionpedidos.php"); ?>
<?php
session_start();

if (!isset($_SESSION["usuario"])) {

  header("location:acceso.php?action=login");
}

if (($_SESSION["nivel"]) !== $usuarioadmin) {

  session_destroy();
  header("location:acceso.php?action=login");
  exit;
}


$timenow = time();
if ((($timenow - $_SESSION["instante"]) > $timexpired)) {

  session_destroy();
  header("Location:acceso.php?action=login");
  exit;
}

$_SESSION["instante"] = $timenow;
?>
<?php
$query = mysqli_query($conexionpedidos, "SELECT idCliente, strNombre,strApellidos, strDni FROM tblclientes");
?>

<?php
if (isset($_POST['enviar'])) {

  $cliente = $_POST['cliente'];
  $fecha = $_POST['fecha'];
  $peso = $_POST['peso'];
  $alto = $_POST['alto'];
  $ancho = $_POST['ancho'];


  $sqlinsert = "INSERT INTO tblpedidos 
    (idcliente, dtmFecha, strPeso, strAlto, strAncho)
VALUES ('$cliente','$fecha','$peso','$alto','$ancho')";

  if (mysqli_query($conexionpedidos, $sqlinsert)) {
    header("location: pedidos_lista.php");
    exit();
  } else {
    $error = true;
    $error_msg = "Error: " . $sqlinsert . " " . mysqli_error($conexionpedidos);
  }
  mysqli_close($conexionpedidos);
}
?>



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
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Panel de Administracion</h1>
            <a href="logout.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Cerrar Sesion</a>
          </div>
          <!-- Content Row -->
          <h1>Nuevo Pedido</h1>
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <!-- Lista de seleccion -->
            <!-- *********************************************************************** -->
            <!-- *********************************************************************** -->
            <div class="form-group">
              <label>Cliente</label>

              <select class="custom-select mr-sm-2" name="cliente">
                <option value="clientes" selected>Selecciona cliente</option>
                <?php
                while ($row = mysqli_fetch_array($query)) {
                  echo "<option value=" . $row['idCliente'] . ">" . $row['idCliente'] . '  ' . $row['strNombre'] . ' ' . $row['strApellidos'] . ' ' . $row['strDni'] . "</option>";
                }
                ?>
              </select>
            </div>
            <div class="form-group ">
              <label>Fecha</label>
              <input type="date" name="fecha"  class="form-control" value="" maxlength="50" required="">
            </div>
            <div class="form-group">
              <label>Peso</label>
              <input type="text" name="peso" placeholder="Introduzca el Peso [gr,kg]" class="form-control" value="" maxlength="75" required="">
            </div>
            <div class="form-group">
              <label>Alto</label>
              <input type="text" name="alto" placeholder="Introduzca la Altura [cm,m]" class="form-control" value="" maxlength="75" required="">
            </div>
            <div class="form-group">
              <label>Ancho</label>
              <input type="text" name="ancho"placeholder="Introduzca la Anchura [cm, m]" class="form-control" value="" maxlength="50" required="">
            </div>

            <input type="submit" class="btn btn-primary" name="enviar" value="Guardar Nuevo pedido">
            <a href="pedidos_lista.php" class="btn btn-default">Cancelar</a>
          </form>
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