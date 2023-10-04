<?php
require_once '../func/LoginValidator.php';

?>


<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Reporte | Hernan Store</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- dropzonejs -->
  <link rel="stylesheet" href="../plugins/dropzone/min/dropzone.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="../plugins/toastr/toastr.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- jQuery -->
  <script src="../plugins/jquery/jquery.min.js"></script>
  <!-- ChartJS -->
  <script src="../plugins/chart.js/Chart.min.js"></script>
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper position-relative">
    <!-- Navbar -->
    <?php require_once '../components/Navbar.php' ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php require_once '../components/Sidebar.php' ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <!-- Small boxes (Stat box) -->

          <div class="row">
            <div class="card container-fluid">
              <div class="card-header">
                <h5 class="card-title">Estadísticas</h5>
              </div>

              <div id="DataCards"></div>
              <!-- ./col -->
            </div>
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- Main content -->
      <section class="content ">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div id="table-progress"></div>
            </div>
            <div class="col-md-12">
              <!-- LINE CHART -->
              <div class="card card-info">
                <div class="card-header">
                  <h3 class="card-title">Ingresos y egresos del <?= date('Y') ?></h3>

                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button>
                    <button type="button" class="btn btn-tool" onclick="toggleShowChart();">
                      <i class="fas fa-exchange-alt"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body">
                  <div id="chartContent"></div>
                </div>
                <!-- /.card-body -->
              </div>
            </div>

            <div class="row">
              <!-- DONUT CHART -->
              <div class="col-md-4">
                <div class="card card-danger">
                  <div class="card-header">
                    <h3 class="card-title">Ingresos de inversores</h3>

                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                      </button>
                      <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                      </button>
                    </div>
                  </div>
                  <div class="card-body">
                    <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                  </div>
                  <!-- /.card-body -->
                </div>
              </div>

              <!-- DONUT CHART -->
              <div class="col-md-4">
                <div class="card card-danger">
                  <div class="card-header">
                    <h3 class="card-title">Egresos de inversores</h3>

                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                      </button>
                      <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                      </button>
                    </div>
                  </div>
                  <div class="card-body">
                    <canvas id="donutChart2" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                  </div>
                  <!-- /.card-body -->
                </div>
              </div>

              <!-- DONUT CHART -->
              <div class="col-md-4">
                <div class="card card-danger">
                  <div class="card-header">
                    <h3 class="card-title">Ganancias de inversores</h3>

                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                      </button>
                      <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                      </button>
                    </div>
                  </div>
                  <div class="card-body">
                    <canvas id="donutChart3" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                  </div>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col (RIGHT) -->
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->

    </div>
    <!-- /.content-wrapper -->
    <div class="position-fixed bg-info" style=" z-index: 5000; bottom: 1rem; right: 1rem;  border-radius: 50%;box-shadow: rgba(0, 0, 0, 0.16) 0px 10px 36px 0px, rgba(0, 0, 0, 0.06) 0px 0px 0px 1px;">
      <div class="btn-group">
        <button type="button" class="btn btn-tool dropdown-toggle text-white" data-toggle="dropdown" aria-expanded="false" style="padding: 2rem 1rem;">
          <i class="fas fa-lg fa-wrench"></i>
        </button>
        <ul class="dropdown-menu" x-placement="top-start" x-out-of-boundaries="" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-160px, -84px, 0px);">
          <li><a href="#" onclick="javascript:updateData(event,'year')" class="dropdown-item active">Datos del año</a></li>
          <li><a href="#" onclick="javascript:updateData(event,'month')" class="dropdown-item">Datos del mes</a></li>
          <li><a href="#" onclick="javascript:updateData(event,'week')" class="dropdown-item">Datos de la semana</a></li>
          <li><a href="#" onclick="javascript:updateData(event,'day')" class="dropdown-item ">Datos de hoy</a></li>
        </ul>
      </div>
    </div>
    <!-- Main Footer -->
    <?php require_once '../components/Footer.php' ?>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Add Content Here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->


  <!-- Bootstrap 4 -->
  <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- dropzonejs -->
  <script src="../plugins/dropzone/min/dropzone.min.js"></script>
  <!-- Toastr -->
  <script src="../plugins/toastr/toastr.min.js"></script>
  <!-- AdminLTE App -->
  <script src="../dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="../dist/js/demo.js"></script>
  <!-- Page specific script -->
  <script>
    $(function() {
      //-------------
      //- DONUT CHART -
      //-------------
      // Get context with jQuery - using jQuery's .get() method.
      var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
      var donutChartCanvas2 = $('#donutChart2').get(0).getContext('2d')
      var donutChartCanvas3 = $('#donutChart3').get(0).getContext('2d')
      var donutData = {
        labels: [
          'Inversor 1',
          'Inversor 2',
          'Inversor 3',
        ],
        datasets: [{
          data: [700, 500, 400],
          backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
        }]
      }
      var donutOptions = {
        maintainAspectRatio: false,
        responsive: true,
      }
      //Create pie or douhnut chart
      // You can switch between pie and douhnut using the method below.
      new Chart(donutChartCanvas, {
        type: 'doughnut',
        data: donutData,
        options: donutOptions
      })
      new Chart(donutChartCanvas2, {
        type: 'doughnut',
        data: donutData,
        options: donutOptions
      })
      new Chart(donutChartCanvas3, {
        type: 'doughnut',
        data: donutData,
        options: donutOptions
      })


    })
  </script>
  <!-- Validaciones -->
  <script>
    let showChart = 'Line';
    let rangeTime = 'year';

    $(function() {
      updateData(null, rangeTime);
    });

    function toggleShowChart() {
      if (showChart === 'Line') {
        showChart = 'Bar'
      } else {
        showChart = 'Line'
      }
      updateData(null, rangeTime)
    }

    function updateData(e, filterData) {
      if (e) {
        document.querySelector('a.active').classList.remove('active')
        e.target.classList.add('active')
      }
      updateDataCards(e, filterData)
      updateDataChartLine(e, filterData)
      updateTableProgress(e, filterData)

      rangeTime = filterData
    }

    function updateDataChartLine(e, filterData) {
      $.ajax({
        type: 'POST',
        url: '<?= $_SESSION['path'] ?>' + '../components/' + showChart + 'chart_investments_expanses.php',
        data: {
          filter: filterData
        },
        success: function(response) {
          $('#chartContent').html(response);
        },
      });
    }

    function updateDataCards(e, filterData) {
      $.ajax({
        type: 'POST',
        url: '<?= $_SESSION['path'] ?>' + '../components/DataCards.php',
        data: {
          filter: filterData
        },
        success: function(response) {
          $('#DataCards').html(response);
        },
      });
    }

    function updateTableProgress(e, filterData) {
      $.ajax({
        type: 'POST',
        url: '<?= $_SESSION['path'] ?>' + '../components/TableProgress.php',
        data: {
          filter: filterData
        },
        success: function(response) {
          $('#table-progress').html(response);
        },
      });
    }


    <?php
    if (isset($_SESSION['msg'])) {
      include '../func/Message.php';

      echo showMessage($_SESSION['type'], $_SESSION['msg']);
    }
    ?>

    function logout(path) {
      window.location.href = path + '/func/SessionDestroy.php';
    }
  </script>

  <?php include '../utils/initDropzoneConfiguration.php' ?>
</body>

</html>