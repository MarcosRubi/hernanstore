<?php
require_once '../func/LoginValidator.php';
require_once '../bd/bd.php';
require_once '../class/Clientes.php';

$Obj_Clientes = new Clientes();

$Res_Clientes = $Obj_Clientes->listarTodo();

if (isset($_GET['s'])) {
  $Res_Clientes = $Obj_Clientes->buscarCliente($_GET['s']);
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Clientes | Hernan Store</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="../plugins/toastr/toastr.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <!-- Navbar -->
    <?php require_once '../components/Navbar.php' ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php require_once '../components/Sidebar.php' ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="mt-5 col-12">
              <div class="card">
                <div class="card-header">
                  <?php
                  if (isset($_GET['s']) && $_GET['s'] !== "") { ?>
                    <div class="mt-3 mb-2 d-flex justify-content-between">
                      <h3 class='card-title'>Clientes encontrados para: <strong><?= $_GET['s'] ?></strong></h3>
                      <a href="./" class="btn btn-primary">Listar todo</a>
                    </div>
                  <?php } else if (!isset($_GET['id'])) {
                    echo "<h3 class='card-title'>Últimos clientes creados</h3>";
                  }
                  ?>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="table_users" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Nombre</th>
                        <th>Dirección</th>
                        <th>Teléfono</th>
                        <th>Correo</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php while ($DatosCliente = $Res_Clientes->fetch_assoc()) { ?>
                        <tr>
                          <td><a href="<?= $_SESSION['path'] ?>/cliente/?id=<?= $DatosCliente['id_cliente'] ?>"><?= $DatosCliente['nombre_cliente'] ?></a></td>
                          <td><?= $DatosCliente['direccion'] ?></td>
                          <td><?= $DatosCliente['telefono'] ?></td>
                          <td><?= $DatosCliente['correo'] ?></td>
                          <td>
                            <div class="d-flex justify-content-around">
                              <a class="mx-1 btn btn-primary" title="Nuevo Préstamo" onclick="nuevoPrestamo(<?= $DatosCliente['id_cliente'] ?>);">
                                <i class="fa fa-dollar-sign fa-lg"></i>
                                <sup><i class="fa fa-plus"></i></sup>
                                <span>Crear préstamo</span>
                              </a>
                              <a href="#" class="px-3 mx-1 btn btn-success" title="Listar Préstamos" onclick="listarPrestamos(<?= $DatosCliente['id_cliente'] ?>);">
                                <i class="fa fa-list fa-lg"></i>
                                <span>Listar préstamos</span>
                              </a>
                            </div>
                          </td>
                        </tr>
                      <?php } ?>
                    </tbody>

                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php require_once '../components/Footer.php' ?>
  </div>
  <!-- ./wrapper -->
  <!-- jQuery -->
  <script src="../plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- DataTables  & Plugins -->
  <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
  <script src="../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
  <script src="../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
  <script src="../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
  <script src="../plugins/jszip/jszip.min.js"></script>
  <script src="../plugins/pdfmake/pdfmake.min.js"></script>
  <script src="../plugins/pdfmake/vfs_fonts.js"></script>
  <script src="../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
  <script src="../plugins/datatables-buttons/js/buttons.print.min.js"></script>

  <!-- AdminLTE App -->
  <script src="../dist/js/adminlte.min.js"></script>
  <!-- dropzonejs -->
  <script src="../plugins/dropzone/min/dropzone.min.js"></script>
  <!-- jquery-validation -->
  <script src="../plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="../plugins/jquery-validation/additional-methods.min.js"></script>
  <!-- Toastr -->
  <script src="../plugins/toastr/toastr.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="../dist/js/demo.js"></script>
  <!-- Page specific script -->
  <script>
    $(function() {
      <?php include '../utils/frmEditEmployeeValidate.php' ?>

      $("#table_users").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "ordering": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print"]
      }).buttons().container().appendTo('#table_users_wrapper .col-md-6:eq(0)');
    });
  </script>
  <script>
    <?php
    if (isset($_SESSION['msg'])) {
      include '../func/Message.php';

      echo showMessage($_SESSION['type'], $_SESSION['msg']);
    }
    ?>

    function logout(path) {
      window.location.href = path + '/func/SessionDestroy.php';
    }

    function nuevoPrestamo(id) {
      window.location.href = '<?= $_SESSION['path'] ?>/prestamos/nuevo/?id=' + id
    }

    function listarPrestamos(id) {
      window.location.href = '<?= $_SESSION['path'] ?>/prestamos/listar/cliente/?id=' + id
    }
  </script>
  <?php include '../utils/initDropzoneConfiguration.php' ?>

</body>

</html>