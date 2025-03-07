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

//de json a array asociativo
$entrada = json_decode($entrada, true);


try {
    $consulta = "SELECT nombre FROM jugadores";
    // Preparamos la consulta para su ejecución segura con PDO
    $stmt = $_conexion->prepare($consulta);
    // Ejecutamos la consulta preparada
    $stmt->execute();
    // Obtenemos todos los resultados en un array asociativo
    $fila = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($fila); 
    // HE ENCONTRADO QUE SE PUEDE UTILIZAR "JSON_UNESCAPED_UNICODE" para evitar secuencias raras a la hora de mostrar el JSON.
    // echo json_encode($fila, JSON_UNESCAPED_UNICODE);

} catch (PDOException $e) {
    echo "Error en la consulta " . $e->getMessage();
}

