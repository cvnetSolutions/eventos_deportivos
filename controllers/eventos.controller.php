<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

require_once('../models/eventos.model.php');

$eventos = new Eventos;
switch ($_GET["op"]) {
    case 'buscar':
        if (!isset($_POST["texto"])) {
            echo json_encode(["error" => "Event name not specified."]);
            exit();
        }
        $texto = $_POST["texto"];
        $datos = $eventos->buscar($texto);
        while ($row = mysqli_fetch_assoc($datos)) {
            $todos[] = $row;
        }
        echo json_encode($todos);
        break;

    case 'todos':
        $datos = $eventos->todos();
        while ($row = mysqli_fetch_assoc($datos)) {
            $todos[] = $row;
        }
        echo json_encode($todos);
        break;

    case 'uno':
        if (!isset($_POST["evento_id"])) {
            echo json_encode(["error" => "Event ID not specified."]);
            exit();
        }
        $evento_id = intval($_POST["evento_id"]);
        $datos = $eventos->uno($evento_id);
        $res = mysqli_fetch_assoc($datos);
        echo json_encode($res);
        break;

    case 'insertar':
        if (!isset($_POST["nombre"]) || !isset($_POST["fecha"]) || !isset($_POST["ubicacion"]) || !isset($_POST["descripcion"])) {
            echo json_encode(["error" => "Missing required parameters."]);
            exit();
        }
        $nombre = $_POST["nombre"];
        $fecha = $_POST["fecha"];
        $ubicacion = $_POST["ubicacion"];
        $descripcion = $_POST["descripcion"];
        $result = $eventos->insertar($nombre, $fecha, $ubicacion, $descripcion);
        echo json_encode(["result" => $result]);
        break;

    case 'actualizar':
        if (!isset($_POST["evento_id"]) || !isset($_POST["nombre"]) || !isset($_POST["fecha"]) || !isset($_POST["ubicacion"]) || !isset($_POST["descripcion"])) {
            echo json_encode(["error" => "Missing required parameters."]);
            exit();
        }
        $evento_id = intval($_POST["evento_id"]);
        $nombre = $_POST["nombre"];
        $fecha = $_POST["fecha"];
        $ubicacion = $_POST["ubicacion"];
        $descripcion = $_POST["descripcion"];
        $result = $eventos->actualizar($evento_id, $nombre, $fecha, $ubicacion, $descripcion);
        echo json_encode(["result" => $result]);
        break;

    case 'eliminar':
        if (!isset($_POST["evento_id"])) {
            echo json_encode(["error" => "Event ID not specified."]);
            exit();
        }
        $evento_id = intval($_POST["evento_id"]);
        $result = $eventos->eliminar($evento_id);
        echo json_encode(["result" => $result]);
        break;

    default:
        echo json_encode(["error" => "Invalid operation."]);
        break;
}
?>
