<?php include_once("conexiones/conexionpedidos.php");?>

<?php 
session_start();  

if(!isset($_SESSION["usuario"])){  

     header("location:acceso.php?action=login");
     exit();  
}

$timenow = time();
if((($timenow- $_SESSION["instante"])>$timexpired)){

      session_destroy();
      header ("Location:acceso.php?action=login");
      exit();

}

$_SESSION["instante"]=$timenow;

?>

<?php
if(isset($_POST['enviar']))
{    

     $nombre = $_POST['nombre'];
     $apellidos = $_POST['apellidos'];
     $dni = $_POST['dni'];
     $direccion = $_POST['direccion'];
     $localidad = $_POST['localidad'];
     $provincia = $_POST['provincia'];
     //echo "$provincia";
     $cp = $_POST['cp'];

     $sqlinsert = "INSERT INTO tblclientes 
     (strDni,strNombre,strApellidos,strDireccion,strLocalidad,intProvincia,strCp)
     VALUES ('$dni','$nombre','$apellidos',' $direccion','$localidad','$provincia','$cp')";
	
     if (mysqli_query($conexionpedidos, $sqlinsert)) {
        header("location: clientes_lista.php");
        exit();
     } 
	else {
        $error= true;
        $error_msg = "Error: " . $sqlinsert . " " . mysqli_error($conexionpedidos);
    
     }
     mysqli_close($conexionpedidos);
}
?>

<?php
 $query = mysqli_query($conexionpedidos, "SELECT * FROM tblprovincias");
?>

<!DOCTYPE html>
<html lang="es"><!-- InstanceBegin template="/Templates/principal.dwt.php" codeOutsideHTMLIsLocked="false" -->

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
<h1>Añadir Nuevo Cliente</h1>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div class="form-group">
        <label>Nombre</label>
        <input type="text" name="nombre" placeholder="Introduzca su Nombre" class="form-control" value="" maxlength="100" required="">
    </div>
    <div class="form-group ">
        <label>Apellidos</label>
        <input type="text" name="apellidos" placeholder="Introduzca sus Apellidos" class="form-control" value="" maxlength="50" required="">
    </div>
    <div class="form-group">
        <label>Dni</label>
        <input type="text" name="dni" placeholder="Introduzca su DNI" pattern="[0-9]{8}[A-Za-z]{1}" 
        title="Debe poner 8 números y una letra" class="form-control" value="" maxlength="75" required="">
    </div>
    <div class="form-group">
        <label>Direccion</label>
        <input type="text" name="direccion" placeholder="Introduzca su Direccion" class="form-control" value="" maxlength="75" required="">
    </div>
    <div class="form-group">
        <label>Localidad</label>
        <input type="text" name="localidad" placeholder="Introduzca su Localidad" class="form-control" value="" maxlength="50" required="">
    </div>
    <div class="form-group">
        <label>Provincia</label>
        <select class="custom-select mr-sm-2" name="provincia">
            <option value="provincia" selected>Selecciona tu Provincia</option>
            <?php
            while ($rowprovincia = mysqli_fetch_array($query)) {
              echo "<option value=" . $rowprovincia['idProvincia'] . ">" . $rowprovincia['idProvincia'] . '  ' . $rowprovincia['strNombreProvincia'] .  "</option>";
            }
            ?>
          </select>
    </div>
    <div class="form-group">
        <label>CP</label>
        <input type="text" name="cp" placeholder="Introduzca Codigo Postal" class="form-control" value="" maxlength="35" required="">
    </div>

    <input type="submit" class="btn btn-primary" name="enviar" value="Aceptar">
    <a href="index.php" class="btn btn-default">Cancelar</a>
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

<!-- InstanceEnd --></html>
