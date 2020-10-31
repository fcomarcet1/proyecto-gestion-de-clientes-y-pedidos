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
if (isset($_REQUEST["idPedido"])) {

  //select para obtener fecha, peso, alto, ancho de un determinado pedido tblpedidos

  $sqlselect = "SELECT * FROM tblpedidos p 
                INNER JOIN tblclientes c ON p.idcliente=c.idCliente 
                WHERE idPedido='" . $_REQUEST['idPedido'] . "' ";

  $resultado = mysqli_query($conexionpedidos, $sqlselect);
  $rowselectId = mysqli_fetch_array($resultado);
  //print_r($rowselectId);
  //echo $rowselectId["dtmFecha"];
  $total_rows = mysqli_num_rows($resultado);

  //$dateformat = date("d m Y", $rowselectId['dtmFecha']);

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
          <h1>Editar Pedido</h1>
          <form action="pedidos_update.php" method="post">
            <!-- Lista de seleccion -->
            <div class="form-group">
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalRelatedContent">Seleccionar Cliente</button>

              <label></label>
              <input type="hidden" class="form-control" name="cliente" id="idclienteselec" value="<?php echo $rowselectId["idcliente"]; ?>" />
            </div>
            <div class="form-group">
              <label>Nombre Cliente</label>
              <input type="text" name="nombre" class="form-control" id="namecli" value="<?php echo $rowselectId["strNombre"]; ?>" maxlength="50" required="">
            </div>
            <div class="form-group">
              <label>Fecha</label>
              <input type="date" name="fecha" class="form-control" value="<?php echo $rowselectId["dtmFecha"]; ?>" maxlength="50" required="">
            </div>
            <div class="form-group">
              <label>Peso</label>
              <input type="text" name="peso" class="form-control" value="<?php echo $rowselectId["strPeso"]; ?>" maxlength="75" required="">
            </div>
            <div class="form-group">
              <label>Alto</label>
              <input type="text" name="alto" class="form-control" value="<?php echo $rowselectId["strAlto"]; ?>" maxlength="75" required="">
            </div>
            <div class="form-group">
              <label>Ancho</label>
              <input type="text" name="ancho" class="form-control" value="<?php echo $rowselectId["strAncho"]; ?>" maxlength="50" required="">
            </div>

            <!-- Llamada a modal -->
            <!--  -->
            <!-- Button trigger modal-->
            <!--<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalRelatedContent">Seleccionar Cliente</button>-->

            <!--Modal: modalRelatedContent-->
            <div class="modal fade right" id="modalRelatedContent" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false">
              <div class="modal-dialog modal-side modal-bottom-right modal-notify modal-info" role="document">
                <!--Content-->
                <div class="modal-content">
                  <!--Header-->
                  <div class="modal-header">
                    <p class="heading">Clientes</p>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true" class="white-text">&times;</span>
                    </button>
                  </div>

                  <!--Body-->
                  <div class="modal-body">

                    <div class="row">

                      <?php
                      $resultadonombre = mysqli_query($conexionpedidos, "SELECT * FROM tblclientes");
                      ?>

                      <?php
                      if (mysqli_num_rows($resultadonombre) > 0) {
                      ?>
                        <table class='table table-hover'>
                        <thead class="thead-dark">
                          <tr>
                          <th scope="col">#</th>
                          <th scope="col">Nombre</th>
                          <th scope="col">Apellidos</th>
                          <th scope="col">>DNI</th>
                          </tr>
                          </thead>
                          <tbody>
                          <?php
                          $i = 0;
                          while ($row = mysqli_fetch_array($resultadonombre)) {
                            //Recupera una fila de resultados como un array asociativo, un array numérico  y lo almacena en $resultadonombre
                          ?>
                            <tr>
                              <td><?php echo $row["idCliente"]; ?></td>
                              <td><?php echo $row["strNombre"]; ?></td>
                              <td><?php echo $row["strApellidos"]; ?></td>
                              <td><?php echo $row["strDni"]; ?></td>
                              <td>
                                <a href="#" onclick="javascript:seleccionacliente('<?php echo $row['idCliente']; ?>','<?php echo $row['strNombre']; ?>')" 
                                title='cliente' id="anchorcliente" data-dismiss="modal"
                                  <span class='glyphicon glyphicon-ok'></span></a>
                              </td>
                            </tr>
                          <?php
                            $i++;
                          }
                          ?>
                          </tbody>
                        </table>
                      <?php
                      } else {
                        echo "No existen clientes actualmente";
                      }

                      mysqli_free_result($resultadonombre);
                      ?>
                    </div>
                  </div>
                </div>
                <!--/.Content-->
              </div>
            </div>
            <!--Modal: modalRelatedContent-->
            <input type="hidden" name="idClienteHdd" value="<?php echo $row["idCliente"]; ?>" />
            <input type="hidden" name="idPedidoHdd" value="<?php echo $rowselectId["idPedido"]; ?>" />
            <input type="submit" class="btn btn-primary" name="actualizar" value="Guardar pedido">
            
            <a href="pedidos_lista.php" class="btn btn-default">Cancelar</a>

            <?php mysqli_free_result($resultado);

            mysqli_close($conexionpedidos);
            ?>
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
  <script>
    function seleccionacliente(idcliente, strnombre) {

      $('#idclienteselec').val(idcliente);
      $('#namecli').val(strnombre);
      //$("#modalRelatedContent").modal('toggle'); // cierra modal
      $("#anchorcliente").attr("data-dismiss", 'modal');

    }
  </script>

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