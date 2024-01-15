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
    $nss = $_POST['nss'];
    
    $insercion = "INSERT INTO Usuario (nombre, apellido, nacimiento, correo, contraseña, curp, telefono, tipo_usuario) 
    values('$nombre', '$apellido', '$nacimiento', '$correo', '$contraseña', '$curp', '$telefono', 0)";
    $result = mysqli_query($conn, $insercion);
    if($result){
        echo '<script>alert("Usuario creado correctamente")</script>';
        $ultimo_id = mysqli_insert_id($conn);
        
        $paciente = "INSERT INTO Paciente (Usuario_ID, nss) 
        values('$ultimo_id','$nss')";
        $paciente_result = mysqli_query($conn, $paciente);
        header("Location: ../vistas/pacientes.php");
    }else{
        die(mysqli_error($conn));
    }

    $ultimo_id = mysql_insert_id($conn); 
    echo $ultimo_id; 
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
    <title>Registrar Paciente</title>
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
                                <h1 class="h4 text-gray-900 mb-4">Registro paciente</h1>
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
                                    var fechaNacimientoInput = document.getElementById("fechaNacimiento");
                                    // Obtener la fecha actual en el formato adecuado para el input date
                                    var today = new Date();
                                    var dd = String(today.getDate() - 2).padStart(2, '0');
                                    var mm = String(today.getMonth() + 1).padStart(2, '0'); // Enero es 0!
                                    var yyyy = today.getFullYear();
                                    var fechaActual = yyyy + '-' + mm + '-' + dd;
                                    fechaNacimientoInput.setAttribute("max", fechaActual);
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
                                    <label>Nss</label>
                                    <input type="text" class="form-control" maxlength="11" placeholder = "Nss" name="nss">
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