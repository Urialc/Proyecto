<?php
$usuario = $_POST["user_correo"];
$contraseña = $_POST["user_pass"];
session_start();
$_SESSION['usuario'] = $usuario;

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Hospital";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM Usuario WHERE correo = ? AND contraseña = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $usuario, $contraseña);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $tipo_usuario = $row['tipo_usuario'];
    $user_id = $row['ID_Usuario'];

    if ($tipo_usuario === 2) { //Doctores
        header("Location: ../doctor/vistas/citas.php");
        exit();
    } elseif ($tipo_usuario === 1) {//Administradores
        header("Location: ../admin/vistas/consultas.php");
        exit();
    } elseif ($tipo_usuario === 0) {//Pacientes
        header("Location: ../usuario/vistas/citas.php");
        exit();
    }
}else {
    // Las credenciales no coinciden
    header("Location: login.html");
    session_destroy();
}

$stmt->close();
$conn->close();
?>