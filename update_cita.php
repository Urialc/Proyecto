<?php
include '../conexion.php';
$id_cita = $_GET['updateid_cita'];
$id_consul = $_GET['updateid_consul'];
$id_pac = $_GET['updateid_pac'];
$costo = $_GET['update_costo'];

$vista = "SELECT c.ID_Cita as cita, u.nombre as paciente, u.apellido as apellido, u.ID_Usuario as id_pac, c.fecha as fecha, c.Consultorio_ID as consultorio,
s.nombre as servicio, s.ID_Servicio as id_servicio, c.costo as costo, cu.disponibilidad as disponibilidad
FROM Cita AS c 
INNER JOIN Consultorio as cu ON c.Consultorio_ID = cu.ID_Consultorio
INNER JOIN Paciente as p ON c.Paciente_ID = p.ID_Paciente
INNER JOIN Usuario as u ON p.Usuario_ID = u.ID_Usuario
INNER JOIN Servicio as s ON s.ID_Servicio = c.Servicio_ID WHERE c.ID_Cita = $id_cita and u.ID_Usuario = $id_pac";
$result = mysqli_query($conn, $vista);
$row = mysqli_fetch_assoc($result);

$paciente = $row['paciente'];
$apellido = $row['apellido'];
$fecha = $row['fecha'];
$servicio = $row['servicio'];
$id_servicio =$row['id_servicio'];
$costo = $row['costo'];

if(isset($_POST['submit'])){
    $id_cita = $_POST['id_cita']; // Asegúrate de tener el ID de la cita que se va a actualizar
    $id_paciente = $_POST['paciente'];
    $fecha = $_POST['fecha_cita'];
    $consultorio = $_POST['consultorio'];
    $servicio = $_POST['servicio'];
    $costo = $_POST['costo'];
    // Consultar si ya existe una cita con la misma fecha y consultorio, excluyendo la cita que se está actualizando
    $sql = "SELECT ID_Cita FROM Cita WHERE fecha = '$fecha' AND Consultorio_ID = '$consultorio' AND ID_Cita <> '$id_cita'";
    $result = $conn->query($sql);
    // Si ya existe una cita con la misma fecha y consultorio (excepto la cita que se está actualizando), mostrar un mensaje de error
    if ($result->num_rows > 0) {
        echo '<script>alert("Ya existe una cita con la misma fecha y consultorio")</script>';
        header("Location: ../vistas/citas.php");
    } else {
        // Si no existe una cita con esa fecha y consultorio, proceder con la actualización
        $cita = "UPDATE Cita SET 
                Consultorio_ID = '$consultorio', Servicio_ID = '$servicio', 
                fecha = '$fecha', costo = '$costo' WHERE ID_Cita = $id_cita";
        
        $up_cita = $conn->query($cita);
        
        if ($up_cita) {
            echo '<script>alert("Cita actualizada correctamente")</script>';
            header("Location: ../vistas/citas.php");
            exit();
        } else {
            echo '<script>alert("Error al actualizar la cita")</script>';
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
                                <h1 class="h4 text-gray-900 mb-4">Actualizar Cita</h1>
                            </div>
                            <form method ="POST">
                                <div class="form-group">
                                    <label>Nombre paciente</label>
                                    <input type="text" class="form-control" name="paciente" readonly value = <?php echo $paciente ?> >
                                </div>
                                <div class="form-group">
                                    <label>Fecha</label>
                                    <input type="datetime-local" class="form-control" name="fecha_cita" id="fecha" value = <?php echo $fecha?>>
                                    <script>
                                        var today = new Date();
                                        var dd = String(today.getDate()).padStart(2, '0');
                                        var mm = String(today.getMonth() + 1).padStart(2, '0'); // January is 0!
                                        var yyyy = today.getFullYear();
                                        var hours = String(today.getHours()).padStart(2, '0');
                                        today = yyyy + '-' + mm + '-' + dd + 'T' + hours + ':00'; // Incluimos la hora actual sin minutos
                                        // Here's the important part: Convert the PHP variable to a string
                                        var fecha = <?php echo json_encode($fecha); ?>;
                                        // Now we can use the fecha variable in our JavaScript code
                                        if (fecha) {
                                            var input = document.getElementById("fecha");
                                            input.value = fecha;
                                            input.setAttribute("min", today);
                                        }
                                    </script>
                                </div>
                                <div class="form-group">
                                    <label>Numero consultorio</label>
                                        <select class="form-control" name="consultorio">
                                            <?php echo ' <option value = '.$id_consul.'>'.$id_consul.'</option>'?>
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
                                        <select class="form-control" name="servicio">
                                            <?php echo ' <option value = '.$id_paciente.'>'.$servicio.'</option>'?>
                                            <?php
                                            $esps = "SELECT *
                                            FROM Servicio Where ID_Servicio != $id_servicio";
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
                                    <input type="text" class="form-control"  placeholder = "Costo" name="costo" value = <?php echo $costo?> readonly>
                                </div>
                                <button type="submit" class="btn btn-primary" name = "submit">Actualizar</button>
                            </form>
                            <hr>
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