<?php
require_once '../func/LoginValidator.php';
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
                  <h3 class="card-title">Listado de clientes</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="table_users" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Nombre</th>
                        <th>Dirección</th>
                        <th>Teléfono</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><a href="<?= $_SESSION['Path'] ?>/cliente/?id=1">Serapio Cantú Valdivia</a></td>
                        <td>91500 Piedras de Afilar</td>
                        <td>9340 5126</td>
                        <td>
                          <div class="d-flex justify-content-around">
                            <a class="mx-1 btn btn-primary" title="Nuevo Préstamo">
                              <i class="fa fa-dollar-sign fa-lg"></i>
                              <sup><i class="fa fa-plus"></i></sup>
                            </a>
                            <a href="#" class="px-3 mx-1 btn btn-success" title="Listar Préstamos">
                              <i class="fa fa-list fa-lg"></i>
                            </a>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td><a href="<?= $_SESSION['Path'] ?>/cliente/?id=1">Elena Ramirez</a></td>
                        <td>12345 Main Street</td>
                        <td>555-123-4567</td>
                        <td>
                          <div class="d-flex justify-content-around">
                            <a class="mx-1 btn btn-primary" title="Nuevo Préstamo">
                              <i class="fa fa-dollar-sign fa-lg"></i>
                              <sup><i class="fa fa-plus"></i></sup>
                            </a>
                            <a href="#" class="px-3 mx-1 btn btn-success" title="Listar Préstamos">
                              <i class="fa fa-list fa-lg"></i>
                            </a>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td><a href="<?= $_SESSION['Path'] ?>/cliente/?id=1">Juan Perez</a></td>
                        <td>9876 Elm Avenue</td>
                        <td>555-987-6543</td>
                        <td>
                          <div class="d-flex justify-content-around">
                            <a class="mx-1 btn btn-primary" title="Nuevo Préstamo">
                              <i class="fa fa-dollar-sign fa-lg"></i>
                              <sup><i class="fa fa-plus"></i></sup>
                            </a>
                            <a href="#" class="px-3 mx-1 btn btn-success" title="Listar Préstamos">
                              <i class="fa fa-list fa-lg"></i>
                            </a>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td><a href="<?= $_SESSION['Path'] ?>/cliente/?id=1">María González</a></td>
                        <td>4567 Oak Lane</td>
                        <td>555-234-5678</td>
                        <td>
                          <div class="d-flex justify-content-around">
                            <a class="mx-1 btn btn-primary" title="Nuevo Préstamo">
                              <i class="fa fa-dollar-sign fa-lg"></i>
                              <sup><i class="fa fa-plus"></i></sup>
                            </a>
                            <a href="#" class="px-3 mx-1 btn btn-success" title="Listar Préstamos">
                              <i class="fa fa-list fa-lg"></i>
                            </a>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td><a href="<?= $_SESSION['Path'] ?>/cliente/?id=1">Ricardo Sánchez</a></td>
                        <td>6543 Pine Road</td>
                        <td>555-678-9012</td>
                        <td>
                          <div class="d-flex justify-content-around">
                            <a class="mx-1 btn btn-primary" title="Nuevo Préstamo">
                              <i class="fa fa-dollar-sign fa-lg"></i>
                              <sup><i class="fa fa-plus"></i></sup>
                            </a>
                            <a href="#" class="px-3 mx-1 btn btn-success" title="Listar Préstamos">
                              <i class="fa fa-list fa-lg"></i>
                            </a>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td><a href="<?= $_SESSION['Path'] ?>/cliente/?id=1">Laura Brown</a></td>
                        <td>7890 Maple Avenue</td>
                        <td>555-345-6789</td>
                        <td>
                          <div class="d-flex justify-content-around">
                            <a class="mx-1 btn btn-primary" title="Nuevo Préstamo">
                              <i class="fa fa-dollar-sign fa-lg"></i>
                              <sup><i class="fa fa-plus"></i></sup>
                            </a>
                            <a href="#" class="px-3 mx-1 btn btn-success" title="Listar Préstamos">
                              <i class="fa fa-list fa-lg"></i>
                            </a>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td><a href="<?= $_SESSION['Path'] ?>/cliente/?id=1">Alexander Smith</a></td>
                        <td>5678 Birch Lane</td>
                        <td>555-890-1234</td>
                        <td>
                          <div class="d-flex justify-content-around">
                            <a class="mx-1 btn btn-primary" title="Nuevo Préstamo">
                              <i class="fa fa-dollar-sign fa-lg"></i>
                              <sup><i class="fa fa-plus"></i></sup>
                            </a>
                            <a href="#" class="px-3 mx-1 btn btn-success" title="Listar Préstamos">
                              <i class="fa fa-list fa-lg"></i>
                            </a>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td><a href="<?= $_SESSION['Path'] ?>/cliente/?id=1">Sophia Johnson</a></td>
                        <td>4321 Cedar Road</td>
                        <td>555-567-8901</td>
                        <td>
                          <div class="d-flex justify-content-around">
                            <a class="mx-1 btn btn-primary" title="Nuevo Préstamo">
                              <i class="fa fa-dollar-sign fa-lg"></i>
                              <sup><i class="fa fa-plus"></i></sup>
                            </a>
                            <a href="#" class="px-3 mx-1 btn btn-success" title="Listar Préstamos">
                              <i class="fa fa-list fa-lg"></i>
                            </a>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td><a href="<?= $_SESSION['Path'] ?>/cliente/?id=1">William Anderson</a></td>
                        <td>8765 Elm Street</td>
                        <td>555-901-2345</td>
                        <td>
                          <div class="d-flex justify-content-around">
                            <a class="mx-1 btn btn-primary" title="Nuevo Préstamo">
                              <i class="fa fa-dollar-sign fa-lg"></i>
                              <sup><i class="fa fa-plus"></i></sup>
                            </a>
                            <a href="#" class="px-3 mx-1 btn btn-success" title="Listar Préstamos">
                              <i class="fa fa-list fa-lg"></i>
                            </a>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td><a href="<?= $_SESSION['Path'] ?>/cliente/?id=1">Isabella Martinez</a></td>
                        <td>7890 Oak Avenue</td>
                        <td>555-234-5678</td>
                        <td>
                          <div class="d-flex justify-content-around">
                            <a class="mx-1 btn btn-primary" title="Nuevo Préstamo">
                              <i class="fa fa-dollar-sign fa-lg"></i>
                              <sup><i class="fa fa-plus"></i></sup>
                            </a>
                            <a href="#" class="px-3 mx-1 btn btn-success" title="Listar Préstamos">
                              <i class="fa fa-list fa-lg"></i>
                            </a>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td><a href="<?= $_SESSION['Path'] ?>/cliente/?id=1">Sofia Brown</a></td>
                        <td>6789 Pine Avenue</td>
                        <td>555-123-4567</td>
                        <td>
                          <div class="d-flex justify-content-around">
                            <a class="mx-1 btn btn-primary" title="Nuevo Préstamo">
                              <i class="fa fa-dollar-sign fa-lg"></i>
                              <sup><i class="fa fa-plus"></i></sup>
                            </a>
                            <a href="#" class="px-3 mx-1 btn btn-success" title="Listar Préstamos">
                              <i class="fa fa-list fa-lg"></i>
                            </a>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td><a href="<?= $_SESSION['Path'] ?>/cliente/?id=1">Liam Davis</a></td>
                        <td>9876 Elm Street</td>
                        <td>555-234-5678</td>
                        <td>
                          <div class="d-flex justify-content-around">
                            <a class="mx-1 btn btn-primary" title="Nuevo Préstamo">
                              <i class="fa fa-dollar-sign fa-lg"></i>
                              <sup><i class="fa fa-plus"></i></sup>
                            </a>
                            <a href="#" class="px-3 mx-1 btn btn-success" title="Listar Préstamos">
                              <i class="fa fa-list fa-lg"></i>
                            </a>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td><a href="<?= $_SESSION['Path'] ?>/cliente/?id=1">Emma Martinez</a></td>
                        <td>2345 Maple Avenue</td>
                        <td>555-901-2345</td>
                        <td>
                          <div class="d-flex justify-content-around">
                            <a class="mx-1 btn btn-primary" title="Nuevo Préstamo">
                              <i class="fa fa-dollar-sign fa-lg"></i>
                              <sup><i class="fa fa-plus"></i></sup>
                            </a>
                            <a href="#" class="px-3 mx-1 btn btn-success" title="Listar Préstamos">
                              <i class="fa fa-list fa-lg"></i>
                            </a>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td><a href="<?= $_SESSION['Path'] ?>/cliente/?id=1">Oliver Johnson</a></td>
                        <td>8765 Oak Lane</td>
                        <td>555-567-8901</td>
                        <td>
                          <div class="d-flex justify-content-around">
                            <a class="mx-1 btn btn-primary" title="Nuevo Préstamo">
                              <i class="fa fa-dollar-sign fa-lg"></i>
                              <sup><i class="fa fa-plus"></i></sup>
                            </a>
                            <a href="#" class="px-3 mx-1 btn btn-success" title="Listar Préstamos">
                              <i class="fa fa-list fa-lg"></i>
                            </a>
                          </div>
                        </td>
                      </tr>
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
  <!-- AdminLTE for demo purposes -->
  <script src="../dist/js/demo.js"></script>
  <!-- Page specific script -->
  <script>
    $(function() {
      $("#table_users").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "ordering": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print"]
      }).buttons().container().appendTo('#table_users_wrapper .col-md-6:eq(0)');
    });
  </script>
</body>

</html>