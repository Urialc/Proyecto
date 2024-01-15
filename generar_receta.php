<?php
    include '../../admin/conexion.php';
error_reporting(0);
session_start();
$actualsesion = $_SESSION['usuario'];

//obtener numero de cita
$id_cita = $_GET['genid_cita'];

//obtener id del paciente
$id_user = $_GET['genid_user'];

//nombre doctor - perfil
$nuser = "SELECT nombre, apellido FROM Usuario WHERE correo = '$actualsesion'";
$consul_nuser = mysqli_query($conn, $nuser);
$row = mysqli_fetch_assoc($consul_nuser);
$user = $row['nombre'] . ' ' . $row['apellido'];

//nombre usuario
$nuser = "SELECT nombre, apellido FROM Usuario WHERE ID_Usuario = '$id_user'";
$consul_nuser = mysqli_query($conn, $nuser);
$row = mysqli_fetch_assoc($consul_nuser);
$paciente = $row['nombre'] . ' ' . $row['apellido'];

//verificacion de sesion
if ($actualsesion == null || $actualsesion == '') {
    header("Location: ../../sesion/login.php");
    die();
}else{
    
    $vista_doc = "SELECT u.correo, d.ID_Doctor as ID_Doctor
    FROM Usuario as u 
    INNER JOIN Empleado as e on e.Usuario_ID = u.ID_Usuario 
    INNER JOIN Doctor AS d ON d.Empleado_ID = e.ID_Empleado WHERE u.correo = '$actualsesion'";
    $consul_vista_doc = mysqli_query ($conn, $vista_doc);
    $row = mysqli_fetch_assoc($consul_vista_doc);
    $doctor_id = $row['ID_Doctor'];
    //crear tratamiento, receta
    if(isset($_POST['submit'])){
        $id_pac = $_POST['paciente'];
        $fecha_in = $_POST['fecha_inicio'];
        $fecha_fn = $_POST['fecha_fin'];
        $id_med = $_POST['medicamento'];
        $desc_med = $_POST['desc_med'];
        $ind_med = $_POST['ind_med'];
        $costo = $_POST['costo'];
        
        $inseret_trat = "INSERT INTO Tratamiento (Medicamento_ID, descripcion, fecha_inicio, fecha_fin, costo) 
        VALUES ('$id_med', '$ind_med', '$fecha_in', '$fecha_fn', '$costo')";
        $result_trat = mysqli_query($conn, $inseret_trat);
        
        if($result_trat){
            //ultimo id generado
            $last_id_trat = mysqli_insert_id($conn);
            //insertar en receta
            $insert_recet = "INSERT INTO Receta (Paciente_ID, Cita_ID, descripcion, Tratamiento_ID) 
            values('$id_user','$id_cita', '$des_med', '$last_id_trat')";
            $result_recet = mysqli_query($conn, $insert_recet);
            if(!$insert_recet){
                echo '<script>alert("Error al generar receta")</script>';
                die(mysqli_error($conn));

            }
        }else{
            
            echo '<script>alert("Error al generar tratamiento")</script>';
            die(mysqli_error($conn));
        }
        if($result_trat && $result_recet ){
            echo '<script>alert("Receta creada correctamente")</script>';
            header("Location: ../vistas/recetas.php");
        }
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
    <title>Generar receta</title>
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
                                <h1 class="h4 text-gray-900 mb-4">Generar receta</h1>
                            </div>
                            <form method ="POST">
                                <div class="form-group">
                                    <label>Nombre paciente</label>
                                    <input type="text" class="form-control" name="paciente" value = <?php echo $paciente;?> readonly>
                                </div>
                                <div class="form-group">
                                    <label>Fecha inicio</label>
                                    <input type="datetime-local" class="form-control" name="fecha_inicio" id="fechaInicio">
                                    <script>
                                        var today = new Date();
                                        var dd = String(today.getDate()).padStart(2, '0');
                                        var mm = String(today.getMonth() + 1).padStart(2, '0');
                                        var yyyy = today.getFullYear();
                                        var hours = String(today.getHours()).padStart(2, '0');
                                        today = yyyy + '-' + mm + '-' + dd + 'T' + hours + ':00';
                                        document.getElementById("fechaInicio").setAttribute("min", today);
                                        var fechaInicioInput = document.getElementById("fechaInicio");
                                        var fechaFinInput = document.getElementById("fechaFin");
                                        fechaInicioInput.addEventListener('input', function() {
                                        fechaFinInput.setAttribute('min', fechaInicioInput.value);
                                        if (fechaFinInput.value <= fechaInicioInput.value) {
                                            fechaFinInput.value = '';
                                        }
                                        });
                                    </script>
                                </div>
                                    
                                <div class="form-group">
                                    <label>Fecha fin</label>
                                    <input type="datetime-local" class="form-control" name="fecha_fin" id="fechaFin">
                                </div>
                                    
                                    <script>
                                    var fechaInicioInput = document.getElementById("fechaInicio");
                                    var fechaFinInput = document.getElementById("fechaFin");
                                    fechaFinInput.addEventListener('input', function() {
                                        if (fechaFinInput.value <= fechaInicioInput.value) {
                                        fechaFinInput.setCustomValidity('La fecha fin debe ser posterior a la fecha de inicio');
                                        } else {
                                        fechaFinInput.setCustomValidity('');
                                        }
                                    });
                                    </script>
                                
                                <div class="form-group">
                                    <label>Medicamento</label>
                                    <select class="form-control" name="medicamento" id="medicamentoSelect">
                                        <option selected>Selecciona un medicamento</option>
                                        <?php
                                        $consul = "SELECT ID_Medicamento, nombre FROM Medicamento";
                                        $result = mysqli_query($conn, $consul);
                                        if($result){
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo '<option value="' . $row['ID_Medicamento'] . '">' . $row['nombre'] . '</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label>Descripcion Medicamento</label>
                                    <input type="text" class="form-control" placeholder = "Descripcion Medicamento" name="desc_med" autocomplete="off" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Indicacion Mediamento</label>
                                    <input type="text" class="form-control"  placeholder = "Indicacion Medicamento" name="ind_med" autocomplete="off" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Costo Medicamento</label>
                                    <input type="text" class="form-control" placeholder="Costo" name="costo" id="costoInput" readonly>
                                </div>
                                
                                <script>
                                    document.getElementById("medicamentoSelect").addEventListener("change", function() {
                                        var select = document.getElementById("medicamentoSelect");
                                        var selectedOption = select.options[select.selectedIndex].value;
                                        
                                        // Realizar una solicitud AJAX para obtener el costo del medicamento
                                        var xhr = new XMLHttpRequest();
                                        xhr.onreadystatechange = function() {
                                            if (xhr.readyState === XMLHttpRequest.DONE) {
                                                if (xhr.status === 200) {
                                                    var costoMedicamento = xhr.responseText;
                                                    document.getElementById("costoInput").value = costoMedicamento;
                                                } else {
                                                    console.error('Hubo un problema al obtener el costo del medicamento.');
                                                }
                                            }
                                        };
                                        xhr.open('GET', 'obtener_costo.php?id=' + selectedOption, true);
                                        xhr.send();
                                    });
                                </script>
                                <button type="submit" class="btn btn-primary" name = "submit">Generar</button>
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