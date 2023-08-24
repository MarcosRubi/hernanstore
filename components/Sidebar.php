<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= $_SESSION['Path'] ?>" class="brand-link">
        <img src="<?= $_SESSION['Path'] ?>/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Hernan Store</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel -->
        <div class="pb-3 mt-3 mb-3 user-panel">
            <button type="button" class="btn d-flex" data-toggle="modal" data-target="#modal-data-username">
                <div class="image">
                    <img src="<?= $_SESSION['Path'] . $_SESSION['UrlFoto'] ?>" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block"><?= $_SESSION['NombreEmpleado'] ?></a>
                </div>
            </button>
        </div>


        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item menu-open">
                    <a href="#" class="nav-link active">
                        <p>
                            CLIENTES
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= $_SESSION['Path'] ?>/clientes/" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Listar Clientes
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= $_SESSION['Path'] ?>/cliente/nuevo" class="nav-link">
                                <i class="nav-icon fas fa-user-plus"></i>
                                <p>
                                    Nuevo Cliente
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link ">
                        <p>
                            PRESTAMOS
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-file-invoice-dollar"></i>
                                <p>
                                    Completados
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-dollar-sign"></i>
                                <p>
                                    En Proceso
                                </p>
                                <span class="badge badge-success right">6</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-comments-dollar"></i>
                                <p>
                                    Pendientes
                                </p>
                                <span class="badge badge-primary right">6</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link ">
                        <p>
                            PAGOS
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-calendar-times"></i>
                                <p>
                                    Atrasados
                                </p>
                                <span class="badge badge-danger right">2</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-hourglass-half"></i>
                                <p>
                                    Próximos
                                </p>
                                <span class="badge badge-warning right">6</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link ">
                        <p>
                            AVISOS
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-clock"></i>
                                <p>
                                    Recordatorios
                                </p>
                                <span class="badge badge-primary right">2</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link ">
                        <p>
                            ADMINISTRADOR
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-chart-bar"></i>
                                <p>
                                    Reporte
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-users-cog"></i>
                                <p>
                                    Empleados
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-th-list"></i>
                                <p>
                                    Estados
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="<?= $_SESSION['Path'] ?>/func/SessionDestroy.php" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>
                            Cerrar sesión
                        </p>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

<div class="modal fade" id="modal-data-username">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Actualiza tus datos <b>Marcos Rubí</b></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- form start -->
                <form>
                    <div class="pb-0 card-body">
                        <div class="form-group">
                            <label for="txtEmail">Email</label>
                            <input type="email" class="form-control" id="txtEmail" placeholder="Email" value="danielhernandez9980@gmail.com">
                        </div>
                        <div class="form-group">
                            <div id="actions" class="m-0 row align-items-center w-100">
                                <div class="p-0 col-lg-12">
                                    <div class="btn-group w-100">
                                        <span class="btn btn-success col fileinput-button">
                                            <i class="fas fa-plus"></i>
                                            <span>Subir imagen</span>
                                        </span>
                                    </div>
                                </div>
                                <div class="table table-striped files col-lg-12" id="previews">
                                    <div id="template" class="flex mt-2 row align-items-center justify-content-around">
                                        <div class="col-auto">
                                            <span class="preview"><img class="rounded-circle" src="data:," alt="" data-dz-thumbnail /></span>
                                        </div>
                                        <div class="align-self-center btn-group">
                                            <button data-dz-remove class="btn btn-danger delete">
                                                <i class="fas fa-trash"></i>
                                                <span>Eliminar</span>
                                            </button>
                                        </div>
                                        <div class="col">
                                            <strong class="error text-danger" data-dz-errormessage></strong>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="mb-0 shadow-none card collapsed-card">
                            <div class="p-0 card-header d-flex">
                                <div class="pb-2 card-tools">
                                    <button type="button" class="text-md btn btn-tool text-danger" data-card-widget="collapse">Cambiar
                                        contraseña</i>
                                    </button>
                                </div>
                                <!-- /.card-tools -->
                            </div>
                            <!-- /.card-header -->
                            <div class="px-0 py-2 card-body">
                                <div class="gap-1 d-flex">
                                    <div class="form-group">
                                        <label for="txtOldPassword">Contraseña actual</label>
                                        <input type="password" class="form-control" id="txtOldPassword" placeholder="Contraseña actual">
                                    </div>
                                    <div class="form-group">
                                        <label for="txtNewPassword">Nueva contraseña</label>
                                        <input type="password" class="form-control" id="txtNewPassword" placeholder="Nueva contraseña">
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-block btn-primary">Actualizar datos</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>