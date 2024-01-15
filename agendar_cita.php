<?php
include '../conexion.php';

if(isset($_POST['submit'])){
    $id_paciente = $_POST['paciente'];
    $fecha = $_POST['fecha_cita'];
    $consultorio = $_POST['consultorio'];
    $servicio = $_POST['servicio'];
    $costo = $_POST['costo'];
    
    // Consultar si ya existe una cita con la misma fecha y consultorio
    $sql = "SELECT ID_Cita FROM Cita WHERE fecha = '$fecha' AND Consultorio_ID = '$consultorio'";
    $result = $conn->query($sql);

    // Si ya existe una cita con la misma fecha y consultorio, redirigir o mostrar un mensaje de error
    if ($result->num_rows > 0) {
        header("Location: ../vistas/citas.php?error=duplicado");
        exit();
    } else {
        // Si no existe una cita con esa fecha y consultorio, proceder con la inserción
        $cita = "INSERT INTO Cita (Paciente_ID, Consultorio_ID, Servicio_ID, fecha, costo) 
        VALUES ('$id_paciente', '$consultorio', '$servicio', '$fecha', '$costo')";
        
        $result_user = $conn->query($cita);
        
        if ($result_user) {
            echo '<script>alert("Cita generada correctamente")</script>';
        } else {
            header("Location: ../vistas/citas.php?error=generar");
            exit();
        }
    }
    // Cerrar la conexión
    $conn->close();
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
                                <h1 class="h4 text-gray-900 mb-4">Agendar Cita</h1>
                            </div>
                            <form method ="POST">
                                <div class="form-group">
                                    <label>Nombre paciente</label>
                                        <select class="form-control" name="paciente">
                                            <option selected>Selecciona un paciente</option>
                                            <?php
                                            $pac = "SELECT p.ID_Paciente, u.nombre, u.apellido
                                            FROM Paciente as p 
                                            INNER JOIN Usuario as u on p.Usuario_ID = u.ID_Usuario";
                                            $result = mysqli_query($conn, $pac);
                                            if($result){
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $paciente = $row['nombre'] . ' ' . $row['apellido'];
                                                    echo '<option value="' . $row['ID_Paciente'] . '"> '.$paciente.'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                </div>
                                <div class="form-group">
                                    <label>Fecha</label>
                                    <input type="datetime-local" class="form-control" name="fecha_cita" id="fecha">
                                    <script>
                                        var today = new Date();
                                        var dd = String(today.getDate()).padStart(2, '0');
                                        var mm = String(today.getMonth() + 1).padStart(2, '0'); // January is 0!
                                        var yyyy = today.getFullYear();
                                        var hours = String(today.getHours()).padStart(2, '0');
                                        today = yyyy + '-' + mm + '-' + dd + 'T' + hours + ':00'; // Incluimos la hora actual sin minutos
                                        document.getElementById("fecha").setAttribute("min", today);
                                    </script>
                                </div>
                                <div class="form-group">
                                    <label>Numero consultorio</label>
                                        <select class="form-control" name="consultorio">
                                            <option selected>Selecciona un consultorio</option>
                                            <?php
                                            $consul = "SELECT ID_Consultorio
                                            FROM Consultorio";
                                            $result = mysqli_query($conn, $consul);
                                            if($result){
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo '<option value="' . $row['ID_Consultorio'] . '">' . $row['ID_Consultorio'] . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                </div>
                                <div class="form-group">
                                    <label>Servicio</label>
                                        <select class="form-control" name="servicio" id="SelectServicio">
                                            <option selected>Selecciona un servicio</option>
                                            <?php
                                            $esps = "SELECT *
                                            FROM Servicio";
                                            $result = mysqli_query($conn, $esps);
                                            if($result){
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo '<option value="' . $row['ID_Servicio'] . '">' . $row['nombre'] . '</option>'; 
                                                }
                                            }
                                            ?>
                                        </select>
                                </div>
                                <div class="form-group">
                                    <label>Costo</label>
                                    <input type="text" class="form-control"  placeholder = "Costo" name="costo" id="costoInput" readonly>
                                </div>
                                
                                <script>
                                    document.getElementById("SelectServicio").addEventListener("change", function() {
                                        var select = document.getElementById("SelectServicio");
                                        var selectedOption = select.options[select.selectedIndex].value;
                                        
                                        // Realizar una solicitud AJAX para obtener el costo del medicamento
                                        var xhr = new XMLHttpRequest();
                                        xhr.onreadystatechange = function() {
                                            if (xhr.readyState === XMLHttpRequest.DONE) {
                                                if (xhr.status === 200) {
                                                    var costoServicio = xhr.responseText;
                                                    document.getElementById("costoInput").value = costoServicio;
                                                } else {
                                                    console.error('Hubo un problema al obtener el costo del servicio.');
                                                }
                                            }
                                        };
                                        xhr.open('GET', 'obtener_costo.php?id=' + selectedOption, true);
                                        xhr.send();
                                    });
                                </script>
                                
                                <button type="submit" class="btn btn-primary" name = "submit">Agendar</button>
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