<?php
include '../conexion.php';

if(isset($_GET['deleteid_cita'])){
    $id_cita = $_GET['deleteid_cita'];
    
    // Eliminar tratamiento
    $del_trat = "DELETE t, r
    FROM Tratamiento as t INNER JOIN Receta as r ON t.ID_Tratamiento = r.Tratamiento_ID
    WHERE r.Cita_ID = $id_cita";
    $consul_del_trat = mysqli_query($conn, $del_trat);
    if(!$consul_del_trat){
        echo '<script>alert("Error al eliminar tratamiento")</script>';
    }
    
    // Eliminar recetas
    $del_rec = "DELETE FROM Receta WHERE Cita_ID = $id_cita";
    $consul_del_rec = mysqli_query($conn, $del_rec);
    if(!$consul_del_rec){
        echo '<script>alert("Error al eliminar receta")</script>';
    }
    
    // Eliminar cita
    $del_cita = "DELETE FROM Cita WHERE ID_Cita = $id_cita";
    $consul_del_cita = mysqli_query($conn, $del_cita);
    if(!$consul_del_cita){
        echo '<script>alert("Error al eliminar Cita")</script>';
    }
    
    if($consul_del_rec && $consul_del_cita && $consul_del_trat){
        echo '<script>alert("Cita eliminada correctamente")</script>';
        header("Location: ../vistas/citas.php");
        exit;
    }
}
?>