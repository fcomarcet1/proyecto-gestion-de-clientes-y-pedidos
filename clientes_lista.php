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
            <h1 class="h3 mb-0 text-black-800">LISTA DE CLIENTES</h1>
            <a href="logout.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Cerrar Sesion</a>
          </div>

          <!-- Content Row -->
          <div class="row">
            <div class="col-lg-12 mx-auto">
              <div class="page-header clearfix">
                <!-- AÑADIR CLIENTE -->
                <?php if ($_SESSION['nivel'] == $usuarioadmin) { ?>
                  <a href="clientes_add.php" class="btn btn-success pull-right">Añadir Cliente</a>
                <?php
                }
                ?>
              </div>
              <?php
              $resultado = mysqli_query($conexionpedidos, "SELECT * FROM tblclientes 
                                                          inner join tblprovincias
                                                          on intProvincia = idProvincia ");
              $row = mysqli_fetch_array($resultado);
              //print_r($row);
              
              ?>
              <?php
              if (mysqli_num_rows($resultado) > 0) {
              ?>
                <table class='table table-hover '>
                  
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Dni</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellidos</th>
                    <th scope="col">Direccion</th>
                    <th scope="col">Localidad</th>
                    <th scope="col">Provincia</th>
                    <th scope="col">Codigo Postal</th>
                    <?php if ($_SESSION['nivel'] == $usuarioadmin) { ?>
                      <th scope="col">Acciones</th>
                    <?php
                    }
                    ?>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                  $i = 0;
                  while ($row = mysqli_fetch_array($resultado)) {
                    //Recupera una fila de resultados como un array asociativo, un array numérico  y lo almacena en $resultado
                  ?>
                    <tr>
                      <td><?php echo $row["idCliente"]; ?></td>
                      <td><?php echo $row["strDni"]; ?></td>
                      <td><?php echo $row["strNombre"]; ?></td>
                      <td><?php echo $row["strApellidos"]; ?></td>
                      <td><?php echo $row["strDireccion"]; ?></td>
                      <td><?php echo $row["strLocalidad"]; ?></td>
                      <td><?php echo $row["strNombreProvincia"]; ?></td>
                      <td><?php echo $row["strCp"]; ?></td>
                      <td>
                        <?php if ($_SESSION['nivel'] == $usuarioadmin) { ?>
                          <a href="clientes_edit.php?idCliente=<?php echo $row["idCliente"];?>&intProvincia=<?php echo $row["intProvincia"];?>" title='Editar registro'><span class='glyphicon glyphicon-pencil'></span></a>
                          <a href="clientes_delete.php?idCliente=<?php echo $row["idCliente"]; ?>" class="material-icons" onclick="return Confirmation()"><span class="glyphicon glyphicon-trash "></span></a>
                        <?php } ?>
                      </td>
                    </tr>
                  <?php
                  $i++;
                  }
                  mysqli_free_result($resultado);
                  ?>
                  </tbody>
                </table>
              <?php
              } else {
                echo "No se encontro resultados";
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
  <!-- Ventana confirmacion delete -->
  <script type="text/javascript">
    function Confirmation() {

      if (confirm('Esta seguro de eliminar el registro?') == true) {
        alert('El registro ha sido eliminado correctamente!!!');
        return true;
      } else {
        //alert('Cancelo la eliminacion');
        return false;
      }
    }
  </script>
</body>
<!-- InstanceEnd -->
</html>