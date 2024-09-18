<?php
require_once('../config/config.php');

class Participantes {
    public function buscar($texto) {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoParaConectar();
        $cadena = "SELECT * FROM `Participantes` WHERE `nombre` LIKE '%$texto%'";
        $datos = mysqli_query($con, $cadena);
        $con->close();
        return $datos;
    }

    public function todos() {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoParaConectar();
        $cadena = "SELECT * FROM `Participantes`";
        $datos = mysqli_query($con, $cadena);
        $con->close();
        return $datos;
    }

    public function uno($participante_id) {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoParaConectar();
        $cadena = "SELECT * FROM `Participantes` WHERE `participante_id` = $participante_id";
        $datos = mysqli_query($con, $cadena);
        $con->close();
        return $datos;
    }

    public function insertar($nombre, $apellido, $email, $telefono) {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoParaConectar();
        $cadena = "INSERT INTO `Participantes` (`nombre`, `apellido`, `email`, `telefono`) 
                   VALUES ('$nombre', '$apellido', '$email', '$telefono')";
        $result = mysqli_query($con, $cadena);
        $con->close();
        return $result;
    }

    public function actualizar($participante_id, $nombre, $apellido, $email, $telefono) {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoParaConectar();
        $cadena = "UPDATE `Participantes` SET `nombre`='$nombre', `apellido`='$apellido', `email`='$email', `telefono`='$telefono' 
                   WHERE `participante_id` = $participante_id";
        $result = mysqli_query($con, $cadena);
        $con->close();
        return $result;
    }

    public function eliminar($participante_id) {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoParaConectar();
        $cadena = "DELETE FROM `Participantes` WHERE `participante_id` = $participante_id";
        $result = mysqli_query($con, $cadena);
        $con->close();
        return $result;
    }
}
?>
