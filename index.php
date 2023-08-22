<?php
require_once './func/LoginValidator.php';
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
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
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
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-info">
                <div class="inner">
                  <h3>$1,380.00</h3>

                  <p>Ganancias obtenidas</p>
                </div>
                <div class="icon">
                  <i class="ion ion-cash"></i>
                </div>
                <a href="#" class="small-box-footer">Más detalles <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-olive">
                <div class="inner">
                  <h3>13</h3>

                  <p>Préstamos completados</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">Más detalles <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-warning">
                <div class="inner">
                  <h3>14</h3>

                  <p>Nuevos clientes</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer">Más detalles <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-success">
                <div class="inner">
                  <h3>06</h3>

                  <p>Nuevos préstamos</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer">Más detalles <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
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
              <div class="card">
                <div class="border-0 card-header">
                  <div class="d-flex justify-content-between">
                    <h3 class="card-title">Ingresos e inversión</h3>
                    <a href="javascript:void(0);">Imprimir reporte</a>
                  </div>
                </div>
                <div class="card-body">
                  <div class="d-flex">
                    <p class="d-flex flex-column">
                      <span class="text-lg text-bold">$9,230.00</span>
                      <span>Ingresos e inversión del 2023</span>
                    </p>
                    <p class="ml-auto text-right d-flex flex-column">
                      <span class="text-success">
                        <i class="fas fa-arrow-up"></i> 33.1%
                      </span>
                      <span class="text-muted">Desde el mes pasado</span>
                    </p>
                  </div>
                  <!-- /.d-flex -->

                  <div class="position-relative">
                    <canvas id="sales-chart" height="198"></canvas>
                  </div>

                  <div class="flex-row d-flex justify-content-end">
                    <span class="mr-2">
                      <i class="fas fa-square text-primary"></i> Ingresos
                    </span>

                    <span>
                      <i class="fas fa-square text-gray"></i> Inversión
                    </span>
                  </div>
                </div>
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col-md-6 -->
            <div class="py-3 col-lg-6">
              <div class="card">
                <div class="border-0 card-header">
                  <h3 class="card-title">Últimos préstamos</h3>
                  <!-- <div class="card-tools">
                  <a href="#" class="btn btn-tool btn-sm">
                    <i class="fas fa-download"></i>
                  </a>
                  <a href="#" class="btn btn-tool btn-sm">
                    <i class="fas fa-bars"></i>
                  </a>
                </div> -->
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
                      <tr>
                        <td>
                          <a href="#">
                            <img src="dist/img/default-150x150.png" alt="Product 1" class="mr-2 img-circle img-size-32">
                            Evelia Ruelas Sánchez
                          </a>
                        </td>
                        <td>$130 USD</td>
                        <td>
                          <small class="mr-1 text-success">
                            <i class="fas fa-arrow-up"></i>
                            12%
                          </small>
                          $24.00
                        </td>
                        <td>
                          <a href="#" class="text-muted">
                            <i class="fas fa-search-dollar fa-lg"></i>
                          </a>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <a href="#">
                            <img src="dist/img/default-150x150.png" alt="Product 1" class="mr-2 img-circle img-size-32">
                            Almendra Godoy Tamayo
                          </a>
                        </td>
                        <td>$29 USD</td>
                        <td>
                          <small class="mr-1 text-warning">
                            <i class="fas fa-arrow-down"></i>
                            0.5%
                          </small>
                          123,234
                        </td>
                        <td>
                          <a href="#" class="text-muted">
                            <i class="fas fa-search-dollar fa-lg"></i>
                          </a>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <a href="#">
                            <img src="dist/img/default-150x150.png" alt="Product 1" class="mr-2 img-circle img-size-32">
                            Alvin Valle Montez
                          </a>
                        </td>
                        <td>$1,230 USD</td>
                        <td>
                          <small class="mr-1 text-danger">
                            <i class="fas fa-arrow-down"></i>
                            3%
                          </small>
                          198
                        </td>
                        <td>
                          <a href="#" class="text-muted">
                            <i class="fas fa-search-dollar fa-lg"></i>
                          </a>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <a href="#">
                            <img src="dist/img/default-150x150.png" alt="Product 1" class="mr-2 img-circle img-size-32">
                            Jairo Linares Santiago
                          </a>
                        </td>
                        <td>$199 USD</td>
                        <td>
                          <small class="mr-1 text-success">
                            <i class="fas fa-arrow-up"></i>
                            63%
                          </small>
                          87
                        </td>
                        <td>
                          <a href="#" class="text-muted">
                            <i class="fas fa-search-dollar fa-lg"></i>
                          </a>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <a href="#">
                            <img src="dist/img/default-150x150.png" alt="Product 1" class="mr-2 img-circle img-size-32">
                            Troilo Viera Comejo
                          </a>
                        </td>
                        <td>$199 USD</td>
                        <td>
                          <small class="mr-1 text-success">
                            <i class="fas fa-arrow-up"></i>
                            63%
                          </small>
                          87
                        </td>
                        <td>
                          <a href="#" class="text-muted">
                            <i class="fas fa-search-dollar fa-lg"></i>
                          </a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col-md-6 -->
            <div class="col-md-12">
              <!-- The time line -->
              <div class="timeline">
                <!-- timeline time label -->
                <div class="time-label">
                  <span class="bg-red">14 Ago. 2023</span>
                </div>
                <!-- /.timeline-label -->
                <!-- timeline item -->
                <div>
                  <i class="fas fa-hand-holding-usd bg-olive"></i>
                  <div class="timeline-item">
                    <span class="time"><i class="fas fa-clock"></i> 12:42 PM</span>
                    <h3 class="timeline-header"><a href="#">Evelia Ruelas Sánchez</a> ha realizado un abono</h3>
                  </div>
                </div>
                <!-- END timeline item -->
                <!-- timeline item -->
                <div>
                  <i class="fas fa-check bg-orange"></i>
                  <div class="timeline-item">
                    <span class="time"><i class="fas fa-clock"></i> 12:28 PM</span>
                    <h3 class="timeline-header no-border"><a href="#">Jairo Linares Santiago</a> préstamo aprobado
                      ($350)</h3>
                  </div>
                </div>
                <!-- END timeline item -->
                <!-- timeline item -->
                <div>
                  <i class="fas fa-receipt bg-info"></i>
                  <div class="timeline-item">
                    <span class="time"><i class="fas fa-clock"></i> 12:05 PM</span>
                    <h3 class="timeline-header"><a href="#">Alvin Valle Montez</a> ha solventado su deuda</h3>
                  </div>
                </div>
                <!-- END timeline item -->
                <!-- timeline time label -->
                <div class="time-label">
                  <span class="bg-green">Anteriormente</span>
                </div>
                <!-- /.timeline-label -->
                <!-- timeline item -->
                <div>
                  <i class="fa fa-receipt bg-info"></i>
                  <div class="timeline-item">
                    <span class="time"><i class="fas fa-clock"></i> Hace 2 días</span>
                    <h3 class="timeline-header"><a href="#"> Almendra Godoy Tamayo</a> ha solventado su deuda</h3>
                  </div>
                </div>
                <!-- END timeline item -->
                <!-- timeline item -->
                <div>
                  <i class="fas fa-handshake-slash bg-maroon"></i>

                  <div class="timeline-item">
                    <span class="time"><i class="fas fa-clock"></i> Hace 3 días</span>

                    <h3 class="timeline-header"><a href="#">Troilo Viera Comejo</a> solicitud de préstamo denegada</h3>
                  </div>
                </div>
                <!-- END timeline item -->
                <div>
                  <i class="fas fa-clock bg-gray"></i>
                </div>
              </div>
            </div>
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <?php require_once './components/Footer.php' ?>

  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE -->
  <script src="dist/js/adminlte.js"></script>

  <!-- OPTIONAL SCRIPTS -->
  <script src="plugins/chart.js/Chart.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="dist/js/pages/dashboard3.js"></script>
</body>

</html>