<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

// se usa para enviar una cabecera HTTP a palo seco indicando el tipo de dato/contenido de las respuestas
header("Content-Type: application/json"); 
require "conexionPDO.php";

// Guardar el metodo del cliente en la variable
$metodo = $_SERVER["REQUEST_METHOD"];

// Lee el cuerpo de las solicitudes enviadas
$entrada = file_get_contents("php://input");

//de json a array asociativo
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

    if (count($res) == 0) {
        //no existe jugador/es con nombre, cambiar res
        $res = [
            "error" => "no existe jugador con ese nombre"
        ];
    }

    //lo hacemos json otra vez
    echo json_encode($res);
}

function controlPost($_conexion, $entrada) {
    if ($entrada["tabla"] == "equipos") {
        try {
            $consulta = $_conexion->prepare("INSERT INTO equipos (nombre, ciudad, estadio) VALUES (:n, :c, :e)");

            $consulta->execute([
                "n" => $entrada["nombre"],
                "c" => $entrada["ciudad"],
                "e" => $entrada["estadio"],
            ]);
            echo "Equipo insertado correctamente :D";
        } catch (PDOException $e) {
            echo "Error en la consulta " . $e->getMessage();
        }
        
    }else if ($entrada["tabla"] == "jugadores") {
        try {
            $consulta = $_conexion->prepare("INSERT INTO jugadores (idEquipo, nombre, posicion, nacionalidad, edad) VALUES (:i, :n, :p, :c, :e)");

            $consulta->execute([
                "i" => $entrada["idEquipo"],
                "n" => $entrada["nombre"],
                "p" => $entrada["posicion"],
                "c" => $entrada["nacionalidad"],
                "e" => $entrada["edad"],
            ]);
            echo "Jugador insertado correctamente :D";
        } catch (PDOException $e) {
            echo "Error en la consulta " . $e->getMessage();
        }
    } else if ($entrada["tabla"] == "posiciones") {
        try {
            $consulta = $_conexion->prepare("INSERT INTO posiciones (posicion, descripcion) VALUES (:p, :d)");

            $consulta->execute([
                "p" => $entrada["posicion"],
                "d" => $entrada["descripcion"],
            ]);
            echo "Posicion insertada correctamente :D";
        } catch (PDOException $e) {
            echo "Error en la consulta " . $e->getMessage();
        }
    }

}

function controlPut($_conexion, $entrada) {
    if ($entrada["tabla"] == "equipos") {
        try {
            $consulta = $_conexion->prepare("UPDATE equipos SET nombre = :n, ciudad = :c, estadio = :e WHERE id = :i");

            $consulta->execute([
                "i" => $entrada["idEquipo"],
                "n" => $entrada["nombre"],
                "c" => $entrada["ciudad"],
                "e" => $entrada["estadio"],
            ]);
            echo "Equipo actualizado correctamente :D <br>";
        } catch (PDOException $e) {
            echo "Error en la consulta " . $e->getMessage();
        }
        
    } else if ($entrada["tabla"] == "jugadores") {
        try {
            $consulta = $_conexion->prepare("UPDATE jugadores SET idEquipo = :iE, nombre = :n, posicion = :p, nacionalidad = :c, edad = :e WHERE id = :iJ");

            $consulta->execute([
                "iJ" => $entrada["idJugador"],
                "iE" => $entrada["idEquipo"],
                "n" => $entrada["nombre"],
                "p" => $entrada["posicion"],
                "c" => $entrada["nacionalidad"],
                "e" => $entrada["edad"],
            ]);
            echo "Jugador actualizado correctamente :D <br>";
        } catch (PDOException $e) {
            echo "Error en la consulta " . $e->getMessage();
        }
    } else if ($entrada["tabla"] == "posiciones") {
        try {
            $consulta = $_conexion->prepare("UPDATE posiciones SET descripcion = :d WHERE posicion = :p");

            $consulta->execute([
                "p" => $entrada["posicion"],
                "d" => $entrada["descripcion"],
            ]);
            echo "Posicion actualizada correctamente :D <br>";
        } catch (PDOException $e) {
            echo "Error en la consulta " . $e->getMessage();
        }
    }
}
function controlDelete($_conexion, $entrada) {
    if ($entrada["tabla"] == "equipos") {
        $nombreEquipo = isset($entrada["nombre"]) && !empty($entrada["nombre"]) ? $entrada["nombre"] : "";
        $consulta = "SELECT * FROM equipos";
        $stmt = $_conexion -> prepare($consulta);
        $stmt -> execute();

        $consulta = "DELETE FROM equipos WHERE nombre = :n";
        $stmt = $_conexion -> prepare($consulta);
        $stmt -> execute([
            "n" => $entrada["nombreEquipo_borrar"]
        ]);
        if($stmt){
            echo json_encode(["mensaje" => "Se ha borrado correctamente el equipo."]);
        } else {
            echo json_encode(["mensaje" => "Error al acceder a los datos."]);
        }
    } else if ($entrada["tabla"] == "jugadores") {
        $nombreJugador = isset($entrada["nombre"]) && !empty($entrada["nombre"]) ? $entrada["nombre"] : "";
        $consulta = "SELECT * FROM jugadores";
        $stmt = $_conexion -> prepare($consulta);
        $stmt -> execute();

        $consulta = "DELETE FROM jugadores WHERE nombre = :n";
        $stmt = $_conexion -> prepare($consulta);
        $stmt -> execute([
            "n" => $entrada["nombreJugador_borrar"]
        ]);
        if($stmt){
            echo json_encode(["mensaje" => "Se ha borrado correctamente el jugador."]);
        } else {
            echo json_encode(["mensaje" => "Error al acceder a los datos."]);
        }
    } else if ($entrada["tabla"] == "posiciones") {
        $nombrePosicion = isset($entrada["posicion"]) && !empty($entrada["posicion"]) ? $entrada["posicion"] : "";
        $consulta = "SELECT * FROM posiciones";
        $stmt = $_conexion -> prepare($consulta);
        $stmt -> execute();

        $consulta = "DELETE FROM posiciones WHERE posicion = :p";
        $stmt = $_conexion -> prepare($consulta);
        $stmt -> execute([
            "p" => $entrada["nombrePosicion_borrar"]
        ]);
        if($stmt){
            echo json_encode(["mensaje" => "Se ha borrado correctamente la posición."]);
        } else {
            echo json_encode(["mensaje" => "Error al acceder a los datos."]);
        }
    }
}