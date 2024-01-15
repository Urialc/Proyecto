<?php
include '../conexion.php';
    
    if(isset($_GET['deleteid_pac']) && isset($_GET['deleteid_user'])){
        $id_pac = $_GET['deleteid_pac'];
        $id_user = $_GET['deleteid_user'];
        
        //Eliminar paciente
        $del_pac = "DELETE FROM Paciente WHERE ID_Paciente = $id_pac";
        $consulta_pac = mysqli_query($conn, $del_pac);
        
        if(!$consulta_pac){
            echo '<script>alert("Error al eliminar el paciente")</script>';
        }
        
        //Eliminar usuario
        $del_user = "DELETE FROM Usuario WHERE ID_Usuario = $id_user";
        $consulta_user = mysqli_query($conn, $del_user);
        
        if(!$consulta_user){
            echo '<script>alert("Error al eliminar el usuario")</script>';
        }
        
        if($consulta_pac && $consulta_user){
            echo '<script>alert("Paciente y usuario eliminados")</script>';
            header("Location: ../vistas/pacientes.php");
        }
    }
?>