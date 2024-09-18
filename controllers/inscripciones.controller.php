<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

require_once('../models/inscripciones.model.php');

$inscripciones = new Inscripciones;
switch ($_GET["op"]) {
    case 'buscarPorEvento':
        if (!isset($_POST["evento_id"])) {
            echo json_encode(["error" => "Event ID not specified."]);
            exit();
        }
        $evento_id = intval($_POST["evento_id"]);
        $datos = $inscripciones->buscarPorEvento($evento_id);
        while ($row = mysqli_fetch_assoc($datos)) {
            $todos[] = $row;
        }
        echo json_encode($todos);
        break;

    case 'todos':
        $datos = $inscripciones->todos();
        while ($row = mysqli_fetch_assoc($datos)) {
            $todos[] = $row;
        }
        echo json_encode($todos);
        break;

    case 'uno':
        if (!isset($_POST["inscripcion_id"])) {
            echo json_encode(["error" => "Inscription ID not specified."]);
            exit();
        }
        $inscripcion_id = intval($_POST["inscripcion_id"]);
        $datos = $inscripciones->uno($inscripcion_id);
        $res = mysqli_fetch_assoc($datos);
        echo json_encode($res);
        break;

    case 'insertar':
        if (!isset($_POST["evento_id"]) || !isset($_POST["participante_id"]) || !isset($_POST["fecha_inscripcion"])) {
            echo json_encode(["error" => "Missing required parameters."]);
            exit();
        }
        $evento_id = intval($_POST["evento_id"]);
        $participante_id = intval($_POST["participante_id"]);
        $fecha_inscripcion = $_POST["fecha_inscripcion"];
        $result = $inscripciones->insertar($evento_id, $participante_id, $fecha_inscripcion);
        echo json_encode(["result" => $result]);
        break;

    case 'actualizar':
        if (!isset($_POST["inscripcion_id"]) || !isset($_POST["evento_id"]) || !isset($_POST["participante_id"]) || !isset($_POST["fecha_inscripcion"])) {
            echo json_encode(["error" => "Missing required parameters."]);
            exit();
        }
        $inscripcion_id = intval($_POST["inscripcion_id"]);
        $evento_id = intval($_POST["evento_id"]);
        $participante_id = intval($_POST["participante_id"]);
        $fecha_inscripcion = $_POST["fecha_inscripcion"];
        $result = $inscripciones->actualizar($inscripcion_id, $evento_id, $participante_id, $fecha_inscripcion);
        echo json_encode(["result" => $result]);
        break;

    case 'eliminar':
        if (!isset($_POST["inscripcion_id"])) {
            echo json_encode(["error" => "Inscription ID not specified."]);
            exit();
        }
        $inscripcion_id = intval($_POST["inscripcion_id"]);
        $result = $inscripciones->eliminar($inscripcion_id);
        echo json_encode(["result" => $result]);
        break;

    default:
        echo json_encode(["error" => "Invalid operation."]);
        break;
}
?>
