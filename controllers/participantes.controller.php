<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

require_once('../models/participantes.model.php');

$participantes = new Participantes;

switch ($_GET["op"]) {
    case 'buscar':
        if (!isset($_POST["texto"])) {
            echo json_encode(["error" => "Participant name not specified."]);
            exit();
        }
        $texto = $_POST["texto"];
        $datos = $participantes->buscar($texto);
        while ($row = mysqli_fetch_assoc($datos)) {
            $todos[] = $row;
        }
        echo json_encode($todos);
        break;

    case 'todos':
        $datos = $participantes->todos();
        while ($row = mysqli_fetch_assoc($datos)) {
            $todos[] = $row;
        }
        echo json_encode($todos);
        break;

    case 'uno':
        if (!isset($_POST["participante_id"])) {
            echo json_encode(["error" => "Participant ID not specified."]);
            exit();
        }
        $participante_id = intval($_POST["participante_id"]);
        $datos = $participantes->uno($participante_id);
        $res = mysqli_fetch_assoc($datos);
        echo json_encode($res);
        break;

    case 'insertar':
        if (!isset($_POST["nombre"]) || !isset($_POST["apellido"]) || !isset($_POST["email"])) {
            echo json_encode(["error" => "Missing required parameters."]);
            exit();
        }
        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        $email = $_POST["email"];
        $telefono = isset($_POST["telefono"]) ? $_POST["telefono"] : null;

        $result = $participantes->insertar($nombre, $apellido, $email, $telefono);
        echo json_encode(["result" => $result]);
        break;

    case 'actualizar':
        if (!isset($_POST["participante_id"]) || !isset($_POST["nombre"]) || !isset($_POST["apellido"]) || !isset($_POST["email"])) {
            echo json_encode(["error" => "Missing required parameters."]);
            exit();
        }
        $participante_id = intval($_POST["participante_id"]);
        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        $email = $_POST["email"];
        $telefono = isset($_POST["telefono"]) ? $_POST["telefono"] : null;

        $result = $participantes->actualizar($participante_id, $nombre, $apellido, $email, $telefono);
        echo json_encode(["result" => $result]);
        break;

    case 'eliminar':
        if (!isset($_POST["participante_id"])) {
            echo json_encode(["error" => "Participant ID not specified."]);
            exit();
        }
        $participante_id = intval($_POST["participante_id"]);
        $result = $participantes->eliminar($participante_id);
        echo json_encode(["result" => $result]);
        break;

    default:
        echo json_encode(["error" => "Invalid operation."]);
        break;
}
?>
