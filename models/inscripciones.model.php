<?php
require_once('../config/config.php');

class Inscripciones {
    public function buscarPorEvento($evento_id) {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoParaConectar();
        $cadena = "SELECT * FROM `Inscripciones` WHERE `evento_id` = $evento_id";
        $datos = mysqli_query($con, $cadena);
        $con->close();
        return $datos;
    }

    public function todos() {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoParaConectar();
        $cadena = "SELECT * FROM `Inscripciones`";
        $datos = mysqli_query($con, $cadena);
        $con->close();
        return $datos;
    }

    public function uno($inscripcion_id) {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoParaConectar();
        $cadena = "SELECT * FROM `Inscripciones` WHERE `inscripcion_id` = $inscripcion_id";
        $datos = mysqli_query($con, $cadena);
        $con->close();
        return $datos;
    }

    public function insertar($evento_id, $participante_id, $fecha_inscripcion) {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoParaConectar();
        $cadena = "INSERT INTO `Inscripciones` (`evento_id`, `participante_id`, `fecha_inscripcion`) 
                   VALUES ($evento_id, $participante_id, '$fecha_inscripcion')";
        $result = mysqli_query($con, $cadena);
        $con->close();
        return $result;
    }

    public function actualizar($inscripcion_id, $evento_id, $participante_id, $fecha_inscripcion) {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoParaConectar();
        $cadena = "UPDATE `Inscripciones` SET `evento_id`=$evento_id, `participante_id`=$participante_id, `fecha_inscripcion`='$fecha_inscripcion'
                   WHERE `inscripcion_id` = $inscripcion_id";
        $result = mysqli_query($con, $cadena);
        $con->close();
        return $result;
    }

    public function eliminar($inscripcion_id) {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoParaConectar();
        $cadena = "DELETE FROM `Inscripciones` WHERE `inscripcion_id` = $inscripcion_id";
        $result = mysqli_query($con, $cadena);
        $con->close();
        return $result;
    }
}
?>
