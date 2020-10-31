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
$query = mysqli_query($conexionpedidos, "SELECT * FROM tblprovincias");

$rowprovincia = mysqli_fetch_array($query);
?>

<?php
if (isset($_REQUEST["idCliente"])) {

  $sqlselect = "SELECT * FROM tblclientes
  inner join tblprovincias
  on intProvincia = idProvincia 
  WHERE idCliente='" . $_REQUEST['idCliente'] . "'  ";
  $resultado = mysqli_query($conexionpedidos, $sqlselect);
  $rowselectId = mysqli_fetch_array($resultado);
  $total_rows = mysqli_num_rows($resultado);
  echo "";
  mysqli_free_result($resultado);
} else {
  echo "No se recibio el parametro idCliente";
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
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Editar Cliente</h1>
            <a href="logout.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Cerrar Sesion</a>
          </div>

          <form action="clientes_update.php" name="form1" id="form1" method="post">
            <div class="form-group">
              <label>Nombre</label>
              <input type="text" name="nombre" class="form-control" value="<?php echo $rowselectId["strNombre"]; ?>" maxlength="100" required="">
            </div>
            <div class="form-group ">
              <label>Apellidos</label>
              <input type="text" name="apellidos" class="form-control" value="<?php echo $rowselectId["strApellidos"]; ?>" maxlength="50" required="">
            </div>
            <div class="form-group">
              <label>Dni</label>
              <input type="text" name="dni" class="form-control" value="<?php echo $rowselectId["strDni"]; ?>" maxlength="75" required="">
            </div>
            <div class="form-group">
              <label>Direccion</label>
              <input type="text" name="direccion" class="form-control" value="<?php echo $rowselectId["strDireccion"]; ?>" maxlength="75" required="">
            </div>
            <div class="form-group">
              <label>Localidad</label>
              <input type="text" name="localidad" class="form-control" value="<?php echo $rowselectId["strLocalidad"]; ?>" maxlength="50" required="">
            </div>
            <div class="form-group">
              <label>Provincia</label>
              <select class="custom-select mr-sm-2" name="provincia">
                <option value="provincia" selected>Selecciona Provincia</option>
                <?php
                while ($rowprovincia = mysqli_fetch_array($query)) {
                  
                  echo "<option selected='selected' value=" . $rowprovincia['idProvincia'] . ">" . $rowprovincia['idProvincia'] . '  ' . $rowprovincia['strNombreProvincia'] .  "</option>";
                }
                ?>
              </select>
            </div>
            <div class="form-group">
              <label>CP</label>
              <input type="text" name="cp" class="form-control" value="<?php echo $rowselectId["strCp"]; ?>" maxlength="35" required="">
            </div>
            <input type="hidden" name="idClienteHdd" value="<?php echo $rowselectId["idCliente"]; ?>" />
            <input type="hidden" name="idprovinciaHdd" value="<?php echo $rowprovincia["idProvincia"]; ?>" />
            <input type="submit" class="btn btn-primary" name="actualizar" value="Actualizar">
            <a href="clientes_lista.php" class="btn btn-default">Cancelar</a>
          </form>

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