<?php
require_once('../config/config.php');

class Eventos {
    public function buscar($texto) {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoParaConectar();
        $cadena = "SELECT * FROM `Eventos` WHERE `nombre` LIKE '%$texto%'";
        $datos = mysqli_query($con, $cadena);
        $con->close();
        return $datos;
    }

    public function todos() {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoParaConectar();
        $cadena = "SELECT * FROM `Eventos`";
        $datos = mysqli_query($con, $cadena);
        $con->close();
        return $datos;
    }

    public function uno($evento_id) {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoParaConectar();
        $cadena = "SELECT * FROM `Eventos` WHERE `evento_id` = $evento_id";
        $datos = mysqli_query($con, $cadena);
        $con->close();
        return $datos;
    }

    public function insertar($nombre, $fecha, $ubicacion, $descripcion) {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoParaConectar();
        $cadena = "INSERT INTO `Eventos` (`nombre`, `fecha`, `ubicacion`, `descripcion`) 
                   VALUES ('$nombre', '$fecha', '$ubicacion', '$descripcion')";
        $result = mysqli_query($con, $cadena);
        $con->close();
        return $result;
    }

    public function actualizar($evento_id, $nombre, $fecha, $ubicacion, $descripcion) {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoParaConectar();
        $cadena = "UPDATE `Eventos` SET `nombre`='$nombre', `fecha`='$fecha', `ubicacion`='$ubicacion', `descripcion`='$descripcion' 
                   WHERE `evento_id` = $evento_id";
        $result = mysqli_query($con, $cadena);
        $con->close();
        return $result;
    }

    public function eliminar($evento_id) {
        $con = new ClaseConectar();
        $con = $con->ProcedimientoParaConectar();
        $cadena = "DELETE FROM `Eventos` WHERE `evento_id` = $evento_id";
        $result = mysqli_query($con, $cadena);
        $con->close();
        return $result;
    }
}
?>
