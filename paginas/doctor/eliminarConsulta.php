<?php
    include('conexion.php');
    try {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];/* update medicos set estatus=0 where id_medico=:elid */
            $eliminarConsulta = "DELETE FROM pacientes WHERE id='$id'";
            $resultado7 = mysqli_prepare($conn,$eliminarConsulta);
            if(mysqli_stmt_execute($resultado7)){
                header('location:consultas.php?respuesta=ELIMINADO CORRECTAMENTE');
            }
        }
    } catch (Exception $e) {
        header('location:consultas.php?respuesta=ERROR'. $e->getMessage());
    }
?>