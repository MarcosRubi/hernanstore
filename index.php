<?php
require_once './func/LoginValidator.php';
require_once './bd/bd.php';
require_once './class/Prestamos.php';
require_once './class/Reset.php';

$Obj_prestamos =  new Prestamos();
$Obj_Reset =  new Reset();

$Res_Prestamos = $Obj_prestamos->listarUltimosPrestamos();

?>


<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Hernan Store | Inicio</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- IonIcons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- dropzonejs -->
  <link rel="stylesheet" href="plugins/dropzone/min/dropzone.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- JQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>

</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <!-- Navbar -->
    <?php require_once './components/Navbar.php' ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php require_once './components/Sidebar.php' ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <!-- Small boxes (Stat box) -->

          <div class="row">
            <div class="card container-fluid">
              <div class="card-header">
                <h5 class="card-title">Estadísticas</h5>
                <div class="card-tools">
                  <div class="btn-group">
                    <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                      <i class="fas fa-wrench"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                      <a href="#" onclick="javascript:updateDataCards(event,'week')" class="dropdown-item">Datos de la semana</a>
                      <a href="#" onclick="javascript:updateDataCards(event,'month')" class="dropdown-item">Datos del mes</a>
                      <a href="#" onclick="javascript:updateDataCards(event,'year')" class="dropdown-item active">Datos del año</a>
                    </div>
                  </div>
                </div>
              </div>

              <div id="DataCards"></div>
              <!-- ./col -->
            </div>
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="py-3 col-lg-6">
              <?php require_once './components/Chart_investments_vs_expanses.php' ?>

              <!-- /.card -->
            </div>
            <!-- /.col-md-6 -->
            <div class="py-3 col-lg-6">
              <div class="card">
                <div class="border-0 card-header">
                  <h3 class="card-title">Últimos préstamos</h3>
                </div>
                <div class="p-0 card-body table-responsive">
                  <table class="table table-striped table-valign-middle">
                    <thead>
                      <tr>
                        <th>Cliente</th>
                        <th>Monto</th>
                        <th>Ganancias</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php while ($DatosPrestamos = $Res_Prestamos->fetch_assoc()) { ?>
                        <tr>
                          <td>
                            <a href="<?= $_SESSION['path'] ?>/cliente/?id=<?= $DatosPrestamos['id_cliente'] ?>">
                              <?= $DatosPrestamos['nombre_cliente'] ?>
                            </a>
                          </td>
                          <td><?= $Obj_Reset->FormatoDinero($DatosPrestamos['capital_prestamo']) ?></td>
                          <td><?= $Obj_Reset->FormatoDinero($DatosPrestamos['ganancias']) ?></td>
                          <td>
                            <a href="<?= $_SESSION['path'] ?>/prestamos/pago-cuota/?id=<?= $DatosPrestamos['id_prestamo'] ?>" class="text-muted">
                              <i class="fas fa-search-dollar fa-lg"></i>
                            </a>
                          </td>
                        </tr>
                      <?php  } ?>
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col-md-6 -->
            <div class="col-md-12">
              <!-- The time line -->
              <?php #require_once './components/Timeline.php'
              ?>
            </div>
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <?php require_once './components/Footer.php' ?>

  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->

  <!-- Bootstrap -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE -->
  <script src="dist/js/adminlte.js"></script>
  <!-- Charts Scripts -->
  <script src="plugins/chart.js/Chart.min.js"></script>
  <!-- dropzonejs -->
  <script src="plugins/dropzone/min/dropzone.min.js"></script>
  <!-- Toastr -->
  <script src="plugins/toastr/toastr.min.js"></script>
  <!-- jquery-validation -->
  <script src="plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="plugins/jquery-validation/additional-methods.min.js"></script>
  <!-- required -->
  <script src="dist/js/demo.js"></script>

  <!-- Validaciones -->
  <script>
    $(function() {
      <?php include 'utils/frmEditEmployeeValidate.php' ?>

      updateDataCards(null, 'year');
    });

    <?php
    if (isset($_SESSION['msg'])) {
      include './func/Message.php';

      echo showMessage($_SESSION['type'], $_SESSION['msg']);
    }
    ?>

    function logout(path) {
      window.location.href = path + '/func/SessionDestroy.php';
    }

    function updateDataCards(e, filterData) {
      if (e) {
        document.querySelector('a.active').classList.remove('active')
        e.target.classList.add('active')
      }

      $.ajax({
        type: 'POST',
        url: '<?= $_SESSION['path'] ?>' + '/components/DataCards.php',
        data: {
          filter: filterData
        },
        success: function(response) {
          $('#DataCards').html(response);
        },
      });
    }
  </script>

  <?php include 'utils/initDropzoneConfiguration.php' ?>



</body>

</html>