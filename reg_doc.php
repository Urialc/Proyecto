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
    $especialidad = $_POST['especialidad'];
    
    $user = "INSERT INTO Usuario (nombre, apellido, nacimiento, correo, contraseña, curp, telefono, tipo_usuario) 
    values('$nombre', '$apellido', '$nacimiento', '$correo', '$contraseña', '$curp', '$telefono', 2)";
    $result_user = mysqli_query($conn, $user);
    
    if($result_user){
        //creacion empleado
        $ultimo_id_user = mysqli_insert_id($conn);
        $empleado = "INSERT INTO Empleado (Usuario_ID, turno) 
        values('$ultimo_id_user','$turno')";
        $result_emp = mysqli_query($conn, $empleado);
        //creacion doctor
        $ultimo_id_doc = mysqli_insert_id($conn);
        $doctor = "INSERT INTO Doctor (Empleado_ID, Especialidad_ID)
        VALUES ($ultimo_id_doc, $especialidad)";
        $result_doc = mysqli_query($conn, $doctor);
        //ultimo id
        $last_id_consul= mysqli_insert_id($conn);
        $consultorio = "INSERT INTO Consultorio(Doctor_ID, disponibilidad)
        VALUES ($last_id_consul, 1)";
        $result_consul = mysqli_query($conn, $consultorio);

    }else{
        die(mysqli_error($conn));
    }
    if($result_user && $result_emp && $result_doc && $result_consul){
        echo '<script>alert("Doctor creado correctamente")</script>';
        header("Location: ../vistas/doctores.php");
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
    <title>Registro Doctor</title>
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
                                <h1 class="h4 text-gray-900 mb-4">Registrar doctor</h1>
                            </div>
                            <form method ="POST">
                                <div class="form-group">
                                    <label>Nombre</label>
                                    <input type="text" class="form-control" maxlength="30" placeholder = "Nombre" name = "nombre" autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <label>Apellido</label>
                                    <input type="text" class="form-control" maxlength="50" placeholder = "Apellido" name="apellido" autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <label>Nacimiento</label>
                                    <input type="date" class="form-control" placeholder="Fecha de nacimiento" name="nacimiento" id="fechaNacimiento">
                                </div>
                                <script>
                                    var inputNacimiento = document.getElementById("fechaNacimiento");
                                    
                                    // Calcular la fecha hace 6 años desde la fecha actual
                                    var fechaLimite = new Date();
                                    fechaLimite.setFullYear(fechaLimite.getFullYear() - 25);
                                    
                                    // Formatear la fecha límite para establecerla como atributo "min" en el input
                                    var yyyy = fechaLimite.getFullYear();
                                    var mm = String(fechaLimite.getMonth() + 1).padStart(2, '0');
                                    var dd = String(fechaLimite.getDate()).padStart(2, '0');
                                    var fechaMinima = yyyy + '-' + mm + '-' + dd;
                                    
                                    inputNacimiento.setAttribute("max", fechaMinima);
                                </script>
                                <div class="form-group">
                                    <label>Correo</label>
                                    <input type="email" class="form-control" maxlength="100" placeholder = "Correo" name="correo" autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <label>Contraseña</label>
                                    <input type="password" class="form-control" maxlength="100" placeholder = "Contraseña" name="contraseña" autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <label>Curp</label>
                                    <input type="text" class="form-control" maxlength="18" placeholder = "Curp" name="curp" autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <label>Telefono</label>
                                    <input type="text" class="form-control" maxlength="10" placeholder = "Numero de telefono" name="telefono" autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <label>Turno</label>
                                    <select class="form-control" name="turno" required>
                                        <option selected>Seleccione un turno</option>
                                        <option  value="M">Mañana</option>
                                        <option  value="T">Tarde</option>
                                        <option  value="N">Noche</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Especialidad</label>
                                        <select class="form-control" name="especialidad" required>
                                            <option selected>Selecciona una especialidad</option>
                                            <?php
                                            $esps = "SELECT * FROM Especialidad";
                                            $result = mysqli_query($conn, $esps);
                                            if($result){
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo '<option value="' . $row['ID_Especialidad'] . '">' . $row['nombre'] . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
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