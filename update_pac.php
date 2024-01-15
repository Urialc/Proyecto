<?php
include '../conexion.php';
$id_pac = $_GET['updateid_pac'];
$id_user = $_GET['updateid_user'];

$preview = "SELECT u.nombre AS nombre, u.apellido AS apellido, u.nacimiento AS nacimiento, u.correo as correo, u.contraseña AS contraseña, u.curp AS curp, u.telefono AS telefono, p.nss AS nss FROM Usuario AS u INNER JOIN Paciente AS p ON p.Usuario_ID = u.ID_Usuario WHERE u.ID_Usuario = $id_user AND p.ID_Paciente = $id_pac";
$result = mysqli_query($conn, $preview);
$row = mysqli_fetch_assoc($result);

$name = $row['nombre'];
$last = $row['apellido'];
$bith = $row['nacimiento'];
$mail = $row['correo'];
$pass = $row['contraseña'];
$cur = $row['curp'];
$mob = $row['telefono'];
$ssn = $row['nss'];

if(isset($_POST['submit'])){
    $nombre = $_POST['nombre'];
	$apellido = $_POST['apellido'];
	$nacimiento = $_POST['nacimiento'];
	$correo = $_POST['correo'];
	$contraseña = $_POST['contraseña'];
	$curp = $_POST['curp'];
	$telefono = $_POST['telefono'];
    $nss = $_POST['nss'];
    
    $update_pac = "UPDATE Paciente SET ID_Paciente = $id_pac, nss = '$nss' WHERE ID_Paciente = $id_pac";
    $consulta_up_pac = mysqli_query($conn, $update_pac);
    
    if(!$consulta_up_pac){
        echo '<script>alert("Error al actualizar paciente")</script>';
    }
    
    $update_user = "UPDATE Usuario SET ID_Usuario = $id_user, nombre = '$nombre', 
    apellido = '$apellido', nacimiento = '$nacimiento', correo = '$correo', 
    contraseña = '$contraseña', curp = '$curp', telefono = '$telefono' WHERE ID_Usuario = $id_user";
    $consulta_up_user = mysqli_query($conn, $update_user);

    if(!$consulta_up_user){
        echo '<script>alert("Error al actualizar el usuario")</script>';
    }
        
    if($consulta_up_pac && $consulta_up_user){
        echo '<script>alert("Paciente y usuario actualizados")</script>';
        header("Location: ../vistas/pacientes.php");
    }else{
        die(mysqli_query($conn));
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
    <title>Actualizar pacientes</title>
    <!-- Custom fonts for this template-->
    <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
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
                                <h1 class="h4 text-gray-900 mb-4">Actualizar pacientes</h1>
                            </div>
                            <form method ="POST">
                                <div class="form-group">
                                    <label>Nombre</label>
                                    <input type="text" class="form-control" maxlength="30" placeholder = "Nombre" name = "nombre" value=<?php echo $name;?>>
                                </div>
                                <div class="form-group">
                                    <label>Apellido</label>
                                    <input type="text" class="form-control" placeholder = "Apellido" name="apellido" value=<?php echo $last;?>>
                                </div>
                                <div class="form-group">
                                    <label>Nacimiento</label>
                                    <input type="date" class="form-control"  placeholder = "Fecha de nacimiento" name="nacimiento" value=<?php echo $birth;?>>
                                </div>
                                <div class="form-group">
                                    <label>Correo</label>
                                    <input type="email" class="form-control"  placeholder = "Correo" name="correo" value=<?php echo $mail;?>>
                                </div>
                                <div class="form-group">
                                    <label>Contraseña</label>
                                    <input type="password" class="form-control"  placeholder = "Contraseña" name="contraseña" value=<?php echo $pass;?>>
                                </div>
                                <div class="form-group">
                                    <label>Curp</label>
                                    <input type="text" class="form-control"  placeholder = "Curp" name="curp" value=<?php echo $cur;?>>
                                </div>
                                <div class="form-group">
                                    <label>Telefono</label>
                                    <input type="text" class="form-control"  placeholder = "Numero de telefono" name="telefono" value=<?php echo $mob;?>>
                                </div>
                                <div class="form-group">
                                    <label>Nss</label>
                                    <input type="text" class="form-control"  placeholder = "Nss" name="nss" value =<?php echo $ssn;?>>
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