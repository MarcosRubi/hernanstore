<?php
require_once '../../func/LoginValidator.php';

require_once '../../bd/bd.php';
require_once '../../class/Prestamos.php';
require_once '../../class/Reset.php';

$Obj_Prestamos = new Prestamos();
$Obj_Reset = new Reset();

$Res_DatosPrestamos = $Obj_Prestamos->ListarDatosParaDocumento($_GET['id']);

$DatosPrestamo = $Res_DatosPrestamos->fetch_assoc();

$mediaTotal = $Obj_Reset->CalcularMontoCuotas($DatosPrestamo["capital_prestamo"], $DatosPrestamo["num_cuotas"], $DatosPrestamo["porcentaje_interes"]);

$primerFormato = [
    "txtValor" => $DatosPrestamo["capital_prestamo"],
    "txtFecha" => $DatosPrestamo["fecha_primer_pago"],
    "txtNumCuotas" => $DatosPrestamo["num_cuotas"],
    "txtInteres" => $DatosPrestamo["porcentaje_interes"],
    "txtIdPlazoPago" => $DatosPrestamo["id_plazo_pago"],
    "txtFechaInicio" => $DatosPrestamo["fecha_primer_pago"],
];

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Factura <?= $DatosPrestamo['nombre_cliente'] ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">

</head>

<body class="hold-transition sidebar-mini" style="font-size:16px !important;">
    <div class="wrapper">
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="margin-left:0px;">
            <section class="content mt-2 pt-2">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <!-- Main content -->
                            <div class="invoice p-3 mb-3">
                                <!-- title row -->
                                <div class="row">
                                    <div class="col-12 mb-4">
                                        <h4 class="d-flex justify-content-between align-middle">
                                            <img src="../../dist/img/AdminLTELogo.png" alt="Logo" style="max-width:10rem;">
                                            <small style="display:flex;align-items:center;"><?= date("d") . "-" . date("m") . "-" . date('Y') . " " . date("h:i:s A") ?></small>
                                        </h4>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- info row -->
                                <div class="row invoice-info">
                                    <div class="col-sm-4 invoice-col">
                                        <br>
                                        <address>
                                            <strong>Hernan Store.</strong><br>
                                            Dirección Main Stree 123<br>
                                            Teléfono #1: (503) 0000-0000<br>
                                            Teléfono #2: (503) 0000-0000<br>
                                            Correo: correoejemplo@gmail.com
                                        </address>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-4 invoice-col">
                                        Cliente
                                        <address>
                                            <strong><?= $DatosPrestamo['nombre_cliente'] ?></strong>
                                        </address>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-4 invoice-col">
                                        <br>
                                        <b>Factura #<?= $DatosPrestamo['id_prestamo'] ?></b><br>
                                        <!-- <b>Factura creada:</b>  -->
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->

                                <!-- Table row -->

                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="text-center py-2">DETALLES DEL PRÉSTAMO</h5>
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Fecha Solicitud</th>
                                                    <th>Capital</th>
                                                    <th>Cuotas</th>
                                                    <th>Valor Cuota</th>
                                                    <th>Período Pagos</th>
                                                    <th>Fecha Primer Pago</th>
                                                    <th>Estado</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><?= $Obj_Reset->ReemplazarMes($Obj_Reset->FechaInvertir(substr($DatosPrestamo['fecha_prestamo'], 0, -9))) ?></td>
                                                    <td><?= $Obj_Reset->FormatoDinero($DatosPrestamo['capital_prestamo']) ?></td>
                                                    <td><?= $DatosPrestamo['num_cuotas'] ?></td>
                                                    <td><?= $Obj_Reset->FormatoDinero($mediaTotal) ?></td>
                                                    <td><?= $DatosPrestamo['plazo_pago'] ?></td>
                                                    <td><?= $Obj_Reset->ReemplazarMes($Obj_Reset->FechaInvertir($DatosPrestamo['fecha_primer_pago'])) ?></td>
                                                    <td><?= $DatosPrestamo['nombre_estado'] ?></td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <?php
                                        // if ($Res_Cuotas->num_rows >= 1) { 
                                        ?>
                                        <div class="row mt-5">
                                            <!-- /.col -->
                                            <div class="col-12">
                                                <div class="table-responsive">
                                                    <div id="table-results"></div>
                                                </div>
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                        <?php #} 
                                        ?>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->


                            </div>
                            <!-- /.invoice -->
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="../../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="../../plugins/jszip/jszip.min.js"></script>
    <script src="../../plugins/pdfmake/pdfmake.min.js"></script>
    <script src="../../plugins/pdfmake/vfs_fonts.js"></script>
    <script src="../../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="../../plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script>
        function getTable(data) {
            $.ajax({
                url: '../../utils/tableLendingPrint.php',
                method: 'POST',
                data: {
                    formData: data
                },
                success: function(response) {
                    $('#table-results').html(response);
                }
            });
        }

        window.addEventListener("load", () => {
            getTable(<?= json_encode($primerFormato) ?>)
            setTimeout(() => {
                window.print();
            }, 500);
        });
    </script>
</body>

</html>