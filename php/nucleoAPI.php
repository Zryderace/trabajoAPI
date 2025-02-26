<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

//se usa para enviar una cabecera HTTP a palo seco
//normalmente se redirige con location pero tambien se usa para indicar el tipo de dato contenido
header("Content-Type: application/json");
require "conexionPDO.php";

$metodo = $_SERVER["REQUEST_METHOD"];
//lee el cuerpo de la solicitud
$entrada = file_get_contents("php://input");
// var_dump($entrada);
//de json a array clave
$entrada = json_decode($entrada, true);

switch ($metodo) {
    case 'GET':
        controlGet($_conexion, $entrada);
        break;
    case 'POST':
        controlPost($_conexion, $entrada);
        break;
    case 'PUT':
        controlPut($_conexion, $entrada);
        break;
    case 'DELETE':
        controlDelete($_conexion, $entrada);
        break;

    default:
        echo json_encode(["metodo" => "otro"]);
        break;
}

function controlGet($_conexion, $entrada)
{
    //recibimos nombre del jugador
    //si esta vacia devolvemos todos
    //si no esta el jugador damos json error
    //hacer todos los nombre a mayusculas

    //devolver mensaje oculto con palabra secreta? por los jajas

    //TODO recoger informacion

    $informacion = $_GET["informacion"];

    $consulta = "SELECT $informacion FROM jugadores";

    if ($_GET["nombreJugador"] == "") {
        // $consulta = "SELECT * FROM jugadores";
        $stmt = $_conexion->prepare($consulta);
        $stmt->execute();
    } else {
        $consulta .= " WHERE nombre LIKE :c";
        $stmt = $_conexion->prepare($consulta);
        $parecido = '%' . $_GET["nombreJugador"] . '%';
        $stmt->execute([
            "c" => $parecido
        ]);
    }

    //solo para get
    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($res)==0) {
        //no existe jugador/es con nombre, cambiar res
        $res = [
            "error" => "no existe jugador con ese nombre"
        ];
    }
    
    //lo hacemos json otra vez
    echo json_encode($res);
}
function controlPost($_conexion, $entrada)
{
    try {
        $consulta = "INSERT INTO desarrolladoras (nombre_desarrolladora, ciudad, anno_fundacion) VALUES (:n, :c, :a)";
        $stmt = $_conexion->prepare($consulta);
        $stmt->execute([
            "n" => $entrada["nombre_desarrolladora"],
            "c" => $entrada["ciudad"],
            "a" => $entrada["anno_fundacion"]
        ]);
        echo json_encode(["todo" => "bien"]);
    } catch (PDOException $e) {
        echo $e->getMessage();
        echo json_encode(["error" => "no se pudo meter"]);
    }
}
function controlPut($_conexion, $entrada)
{

    //comprobar desarrolladora exista

    $nombre_desarrolladora = isset($entrada["nombre_desarrolladora"]) && !empty($entrada["nombre_desarrolladora"]) ? $entrada["nombre_desarrolladora"] : "";

    try {

        $consulta = $_conexion->prepare("SELECT * FROM desarrolladoras WHERE nombre_desarrolladora = :nombre");

        $consulta->execute(["nombre" => $nombre_desarrolladora]);

        $fila = $consulta->fetch();

        if ($fila) {
            //aqui existe
            try {
                $consulta = "UPDATE desarrolladoras SET ciudad = :c, anno_fundacion = :a WHERE nombre_desarrolladora = :nombre";
                $stmt = $_conexion->prepare($consulta);
                //si lo hace true si no false
                $stmt->execute([
                    "nombre" => $entrada["nombre_desarrolladora"],
                    "c" => $entrada["ciudad"],
                    "a" => $entrada["anno_fundacion"]
                ]);
                echo json_encode(["todo" => "bien"]);
            } catch (PDOException $e) {
                echo $e->getMessage();
                echo json_encode(["error" => "no se pudo update"]);
            }
        } else {
            echo json_encode(["error" => "no existe desarrolladora con ese nombre"]);
        }
    } catch (PDOException $e) {
        echo "ERROR: no se puede recuperar la consulta " . $e->getMessage();
    }
}
function controlDelete($_conexion, $entrada)
{
    $nombre_desarrolladora = isset($entrada["nombre_desarrolladora"]) && !empty($entrada["nombre_desarrolladora"]) ? $entrada["nombre_desarrolladora"] : "";

    try {
        $consulta = $_conexion->prepare("SELECT * FROM desarrolladoras WHERE nombre_desarrolladora = :nombre");

        $consulta->execute(["nombre" => $nombre_desarrolladora]);

        $fila = $consulta->fetch();

        if ($fila) {
            try {
                $consulta = "DELETE FROM desarrolladoras WHERE nombre_desarrolladora = :n";
                $stmt = $_conexion->prepare($consulta);
                $stmt->execute([
                    "n" => $entrada["nombre_desarrolladora"],
                ]);
                echo json_encode(["todo" => "bien"]);
            } catch (PDOException $e) {
                echo $e->getMessage();
                echo json_encode(["error" => "no se pudo borrar"]);
            }
        } else {
            echo json_encode(["error" => "no existe desarrolladora con ese nombre"]);
        }
    } catch (PDOException $e) {
        echo "ERROR: no se puede recuperar la consulta " . $e->getMessage();
    }
}
