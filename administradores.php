<?php
    include '../conexion.php';
    session_start();
error_reporting(0);
$actualsesion = $_SESSION['usuario'];

$sesion = "SELECT tipo_usuario FROM Usuario WHERE correo = '$actualsesion'";
$result = mysqli_query($conn, $sesion);
$row = mysqli_fetch_assoc($result);
$type_user = $row['tipo_usuario'];

if ($actualsesion == null || $actualsesion == '' || $type_user != 1) {
    header("Location: ../../sesion/login.php");
    die();
}else{
    $nuser = "SELECT nombre, apellido FROM Usuario WHERE correo = '$actualsesion'";
$consul_nuser = mysqli_query($conn, $nuser);
$row = mysqli_fetch_assoc($consul_nuser);
$user = $row['nombre'] . ' ' . $row['apellido'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Consultas</title>

    <!-- Custom fonts for this template -->
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="../../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Sistema Hospital</div>
            </a>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">
            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="index.html">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Sistema</span></a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider">
            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Ajustes</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Componentes:</h6>
                        <a class="collapse-item" href="../acciones/reg_pac.php">Registrar paciente</a>
                        <a class="collapse-item" href="../acciones/reg_doc.php">Registrar doctor</a>
                        <a class="collapse-item" href="../acciones/reg_admin.php">Registrar admininistrador</a>
                        <a class="collapse-item" href="../acciones/agendar_cita.php">Agendar cita </a>
                    </div>
                </div>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider">
            <!-- Heading -->
            <div class="sidebar-heading">
                Adicionales
            </div>
            <!-- Nav Item - Tables -->
            <li class="nav-item active">
                <a class="nav-link" href="./pacientes.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Pacientes</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="./doctores.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Doctores</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="./consultas.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Consultas</span></a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">
            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <?php echo $user; ?>
                                </span>
                                <img class="img-profile rounded-circle"
                                    src="../../img/undraw_profile.svg">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="../../sesion/perfil.php">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Perfil
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="../../sesion/cerrar.php">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Salir
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Administradores</h1>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Lista de Administradores</h6>
                        <br>
                        <a href="../acciones/reg_admin.php">
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#user">
                                <span class="glyphicon glyphicon-plus"></span> Registar Admin <i class="fa fa-user-plus"></i>
                            </button>
                        </a>
                    </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th scope = "col">ID Administrador</th>
                                            <th scope = "col">ID Usuario</th>
                                            <th scope = "col">Nombre</th>
                                            <th scope = "col">Apellido</th>
                                            <th scope = "col">Edad</th>
                                            <th scope = "col">Correo</th>
                                            <th scope = "col">Telefono</th>
                                            <th scope = "col">Accion</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $vista = "SELECT a.ID_Administrador as admi, u.ID_Usuario as usuario, u.nombre as nombre, u.apellido as apellido, TIMESTAMPDIFF(YEAR, u.nacimiento, CURRENT_DATE()) as edad, u.correo as correo, u.telefono as telefono
                                            FROM Usuario AS u INNER JOIN Empleado as e on e.Usuario_ID = u.ID_Usuario INNER JOIN Administrador as a on a.Empleado_ID = e.ID_Empleado";
                                            $result = mysqli_query($conn, $vista);
                                            if($result){
                                                while($row = mysqli_fetch_assoc($result)){
                                                    $id_admin = $row['admi'];
                                                    $id_user = $row['usuario'];
                                                    $name = $row['nombre'];
                                                    $last = $row['apellido'];
                                                    $age = $row['edad'];
                                                    $email = $row['correo'];
                                                    $mobile = $row['telefono'];
                                                    echo '<tr>
                                                    <th scope = "row">'.$id_admin.'</th>
                                                    <td>'.$id_user.'</th>
                                                    <td>'.$name.'</td>
                                                    <td>'.$last.'</td>
                                                    <td>'.$age.'</td>
                                                    <td>'.$email.'</td>
                                                    <td>'.$mobile.'</td>
                                                    <td>
                                                    <button class="btn btn-primary"><a href="../acciones/update_admi.php?updateid_pac='.$id_admin.'&updateid_user='.$id_user.'" class="text-dark">Cambiar</a></button>
                                                    <button class="btn btn-primary"><a href="../acciones/delete_admi.php?deleteid_pac='.$id_admin.'&deleteid_user='.$id_user.'" class="text-dark">Eliminar</a></button>
                                                    </td>
                                                    </tr>';
                                                }
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; la mmalona KCU 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"></span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="../../vendor/jquery/jquery.min.js"></script>
    <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="../../js/sb-admin-2.min.js"></script>
    <!-- Page level plugins -->
    <script src="../../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../../vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <!-- Page level custom scripts -->
    <script src="../../js/demo/datatables-demo.js"></script>
</body>
</html>
