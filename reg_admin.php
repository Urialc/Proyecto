<?php
include '../conexion.php';

if(isset($_POST['submit'])){
    $nombre = $_POST['nombre'];
	$apellido = $_POST['apellido'];
	$nacimiento = $_POST['nacimiento'];
	$correo = $_POST['correo'];
	$contraseña = $_POST['contraseña'];
	$curp = $_POST['curp'];
	$telefono = $_POST['telefono'];
    $turno = $_POST['turno'];
    
    $user = "INSERT INTO Usuario (nombre, apellido, nacimiento, correo, contraseña, curp, telefono) 
    values('$nombre', '$apellido', '$nacimiento', '$correo', '$contraseña', '$curp', '$telefono')";
    $result_user = mysqli_query($conn, $user);
    
    if($result_user){
        
        $ultimo_id_user = mysqli_insert_id($conn);
        $empleado = "INSERT INTO Empleado (Usuario_ID, turno) 
        values('$ultimo_id_user','$turno')";
        $result_emp = mysqli_query($conn, $empleado);
        
        $ultimo_id_admin = mysqli_insert_id($conn);
        $result_admin = "INSERT INTO Administrador (Empleado_ID)
        VALUES ($ultimo_id_admin)";
        $result_doc = mysqli_query($conn, $result_admin);
    }else{
        die(mysqli_error($conn));
    }
    if($result_user && $result_emp && $result_doc){
        echo '<script>alert("Administrador creado correctamente")</script>';
        header("Location: ../vistas/administradores.php");
    }
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
    <title>Registro Admin</title>
    <!-- Custom fonts for this template-->
    <link href="../../vendor/fontawesome-free/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-primary">
    <div class="container">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Registrar administrador</h1>
                            </div>
                            <form method ="POST">
                                <div class="form-group">
                                    <label>Nombre</label>
                                    <input type="text" class="form-control" maxlength="30" placeholder = "Nombre" name = "nombre">
                                </div>
                                <div class="form-group">
                                    <label>Apellido</label>
                                    <input type="text" class="form-control" maxlength="50" placeholder = "Apellido" name="apellido">
                                </div>
                                <div class="form-group">
                                    <label>Nacimiento</label>
                                    <input type="date" class="form-control" placeholder="Fecha de nacimiento" name="nacimiento" id="fechaNacimiento">
                                </div>
                                <script>
                                    var inputNacimiento = document.getElementById("fechaNacimiento");
                                    // Calcular la fecha hace 6 años desde la fecha actual
                                    var fechaLimite = new Date();
                                    fechaLimite.setFullYear(fechaLimite.getFullYear() - 18);
                                    // Formatear la fecha límite para establecerla como atributo "min" en el input
                                    var yyyy = fechaLimite.getFullYear();
                                    var mm = String(fechaLimite.getMonth() + 1).padStart(2, '0');
                                    var dd = String(fechaLimite.getDate()).padStart(2, '0');
                                    var fechaMinima = yyyy + '-' + mm + '-' + dd;
                                    inputNacimiento.setAttribute("max", fechaMinima);
                                </script>
                                <div class="form-group">
                                    <label>Correo</label>
                                    <input type="email" class="form-control" maxlength="100" placeholder = "Correo" name="correo">
                                </div>
                                <div class="form-group">
                                    <label>Contraseña</label>
                                    <input type="password" class="form-control" maxlength="100" placeholder = "Contraseña" name="contraseña">
                                </div>
                                <div class="form-group">
                                    <label>Curp</label>
                                    <input type="text" class="form-control" maxlength="18" placeholder = "Curp" name="curp">
                                </div>
                                <div class="form-group">
                                    <label>Telefono</label>
                                    <input type="text" class="form-control" maxlength="10" placeholder = "Numero de telefono" name="telefono">
                                </div>
                                <div class="form-group">
                                    <label>Turno</label>
                                    <input type="text" class="form-control"  placeholder = "Turno" name="turno">
                                </div>
                                <button type="submit" class="btn btn-primary" name = "submit">Registrarse</button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="forgot-password.html">Olvidaste tu contraseña ?</a>
                            </div>
                            <div class="text-center">
                                <a class="small" href="login.html">Ya tienes una cuenta ? inicia sesion</a>
                            </div>
                        </div>
                    </div>
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
</body>
</html>