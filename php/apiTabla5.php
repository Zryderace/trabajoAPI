<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POST</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <?php
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    require "conexionPDO.php";
    ?>
</head>

<body>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $metodo = "POST";
        $tabla = isset($_POST["seleccion"]) ? $_POST["seleccion"] : "";
        $datos = [];
        $url = "http://localhost/trabajoAPI/php/nucleoAPI.php";

        $error = false;

        if ($tabla == "equipos") {
            $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : "";
            $ciudad = isset($_POST["ciudad"]) ? $_POST["ciudad"] : "";
            $estadio = isset($_POST["estadio"]) ? $_POST["estadio"] : "";

            $nombre = ucfirst(strtolower(trim($nombre)));
            $ciudad = ucfirst(strtolower(trim($ciudad)));
            $estadio = ucfirst(strtolower(trim($estadio)));

            $arrayEquipos = [];
            try {
                $res = $_conexion->query("SELECT * FROM equipos");
                foreach($res as $equipos) {
                    array_push($arrayEquipos, $equipos["nombre"]);
                }
            } catch (PDOException $e) {
                echo "Error en la consulta " . $e->getMessage();
            }

            if ($nombre == "" || $ciudad == "" || $estadio == "") {
                echo ("Por favor rellene todos los datos");
                $error = true;
            } elseif (strlen($nombre) < 3) {
                echo ("Por favor introduce 3 letras o mas para nombreEquipo");
                $error = true;
            }
            elseif (strlen($ciudad) < 3) {
                echo ("Por favor introduce 3 letras o mas para nombreEquipo");
                $error = true;
            }
            elseif (strlen($estadio) < 3) {
                echo ("Por favor introduce 3 letras o mas para nombreEquipo");
                $error = true;
            } elseif (in_array($nombre, $arrayEquipos)) {
                echo ("El equipo introducido ya existe en la BBDD.");
                $error = true;
            }
            
        } else if ($tabla == "jugadores") {

            $idEquipo = isset($_POST["equipoJugador"]) ? $_POST["equipoJugador"] : "";
            $nombre = isset($_POST["nombreJugador"]) ? $_POST["nombreJugador"] : "";
            $posicion = isset($_POST["posicionJugador"]) ? $_POST["posicionJugador"] : "";
            $nacionalidad = isset($_POST["nacionalidad"]) ? $_POST["nacionalidad"] : "";
            $edad = isset($_POST["edad"]) ? $_POST["edad"] : "";

            

            $nombre = ucfirst(strtolower(trim($nombre)));
            $nacionalidad = ucfirst(strtolower(trim($nacionalidad)));
            $edad = trim($edad);

            $arrayJugadores = [];
            try {
                $res = $_conexion->query("SELECT * FROM jugadores");
                foreach($res as $jugadores) {
                    array_push($arrayJugadores, $jugadores["nombre"]);
                }
            } catch (PDOException $e) {
                echo "Error en la consulta " . $e->getMessage();
            }


            if ($nombre == "" || $idEquipo == "" || $posicion == "" || $nacionalidad == "" || $edad == "") {
                echo ("por favor rellena todos los datos");
                $error = true;
            } elseif (strlen($nombre) < 3) {
                    echo ("Por favor introduce 3 letras o mas para nombre");
                    $error = true;
                }
                elseif (strlen($nacionalidad) < 3) {
                    echo ("Por favor introduce 3 letras o mas para nacionalidad");
                    $error = true;
                }
                elseif ($edad < 16 || $edad >= 100) {
                    echo ("Por favor introduce edad >15 y <100");
                    $error = true;
                } elseif (in_array($nombre, $arrayJugadores)) {
                    echo ("El jugador introducido ya existe en la BBDD.");
                    $error = true;
                }

            
            
        } else if ($tabla == "posiciones") {
            $posicion = isset($_POST["posicion"]) ? $_POST["posicion"] : "";
            $descripcion = isset($_POST["descripcion"]) ? $_POST["descripcion"] : "";

            $posicion = ucfirst(strtolower(trim($posicion)));
            $descripcion = ucfirst(trim($descripcion));

            $arrayPosiciones = [];
            try {
                $res = $_conexion->query("SELECT * FROM posiciones");
                foreach($res as $posiciones) {
                    array_push($arrayPosiciones, $posiciones["posicion"]);
                }
            } catch (PDOException $e) {
                echo "Error en la consulta " . $e->getMessage();
            }

            if ($posicion == "" || $descripcion == "") {
                echo ("por favor rellena todos los datos");
                $error = true;
            } elseif (strlen($posicion) < 3) {
                echo ("Por favor introduce 3 letras o mas para posicion");
                $error = true;
            } elseif (strlen($descripcion) < 3) {
                echo ("Por favor introduce 3 letras o mas para descripcion");
                $error = true;
            } elseif (in_array($posicion, $arrayPosiciones)) {
                echo ("La posicion introducida ya existe en la BBDD.");
                $error = true;
            }
            
        } else {
            $error = true;
            echo ("No existe tabla en BBDD");
        }



        if ($error) {
            //Podemos mostrar información/mensajes en caso de errores para advertir al usuario.

        } else {
            if ($tabla == "equipos") {
                $datos = [
                    "nombre" => $nombre,
                    "ciudad" => $ciudad,
                    "estadio" => $estadio,
                    "tabla" => $tabla
                ];
            } else if ($tabla == "jugadores") {
                $datos = [
                    "idEquipo" => $idEquipo,
                    "nombre" => $nombre,
                    "posicion" => $posicion,
                    "nacionalidad" => $nacionalidad,
                    "edad" => $edad,
                    "tabla" => $tabla
                ];
            } else  if ($tabla == "posiciones") {
                $datos = [
                    "posicion" => $posicion,
                    "descripcion" => $descripcion,
                    "tabla" => $tabla
                ];
            } else {
                $error = true;
                echo ("no existe tabla en BBDD");
            }




            $opciones = [
                "http" => [
                    "header" => "Content-Type: application/json",
                    "method" => $metodo,
                    "content" => json_encode($datos)
                ]
            ];

            $contexto = stream_context_create($opciones);

            try {
                $respuesta = file_get_contents($url, false, $contexto);
                //construye una conexion HTTP usando el contexto de stream context
            } catch (Exception $e) {
                echo "Error al realizar la solicitud " . $e->getMessage();
            }

            echo "<pre>" . htmlspecialchars($respuesta) . "</pre>";
        }
    }
    ?>

    <?php

    try {
        // Uso DISTINCT por fallo en la recogida de fetchAll. Muestra los datos duplicados...
        $consulta = "SELECT DISTINCT nombre FROM equipos ORDER BY id";
        $stmt = $_conexion->prepare($consulta);
        $stmt->execute();
        $fila = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //print_r($fila);
    } catch (PDOException $e) {
        echo "Error en la consulta " . $e->getMessage();
    }

    try {
        // En este caso, no entiendo porque no hace falta
        $consulta2 = "SELECT posicion FROM posiciones";
        $stmt = $_conexion->prepare($consulta2);
        $stmt->execute();
        $fila2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //print_r($fila2);
    } catch (PDOException $e) {
        echo "Error en la consulta " . $e->getMessage();
    }
    ?>

    <div class="container m-4">
        <h1>INSERTAR DATOS A LA BBDD</h1>
        <form action="" method="post">
            <div class="mb-3">
                <label for="seleccion" class="form-label">Insertar datos en la tabla: </label>
                <select name="seleccion" class="form-select" onchange="mostrarFormulario()">
                    <option selected disabled>---ELIJA UNA TABLA---</option>
                    <option value="equipos">Equipos</option>
                    <option value="jugadores">Jugadores</option>
                    <option value="posiciones">Posiciones</option>
                </select>
            </div>
            <div id="campoEquipo" class="mb-3" style="display: none;">
                <h2>Insertar un nuevo equipo:</h2>
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" name="nombre" class="form-control" placeholder="Escribe el nombre del equipo..."><br>
                <label for="ciudad" class="form-label">Ciudad:</label>
                <input type="text" name="ciudad" class="form-control" placeholder="Escribe la ciudad donde se encuentra..."><br>
                <label for="estadio" class="form-label">Estadio:</label>
                <input type="text" name="estadio" class="form-control" placeholder="Escribe el nombre del estadio...">
            </div>

            <div id="campoJugador" class="mb-3" style="display: none;">
                <h2>Insertar un nuevo jugador:</h2>
                <label for="equipoJugador" class="form-label">Equipo:</label>
                <select name="equipoJugador" class="form-select">
                    <option selected disabled>---ELIJA UN EQUIPO---</option>
                    <?php

                    $contador = 1;
                    foreach($fila as $aux) { ?>
                        <option value="<?php echo $contador ?>"><?php echo $aux["nombre"] ?></option>
                        
                    <?php
                    $contador++;
                 }
                    
                ?>
                </select><br>

                <label for="nombreJugador" class="form-label">Nombre:</label>
                <input type="text" name="nombreJugador" class="form-control" placeholder="Escribe el nombre del futbolista..."><br>
                <label for="posicionJugador" class="form-label">Posición:</label>
                <select name="posicionJugador" class="form-select">
                <option selected disabled>---ELIJA UNA POSICIÓN---</option>
                    <?php

                    $contador = 1;
                    foreach($fila2 as $aux) { ?>
                        <option value="<?php echo $aux["posicion"] ?>"><?php echo $aux["posicion"] ?></option>
                        
                    <?php
                    $contador++;
                 }
                    
                ?>
                </select><br>
                <label for="nacionalidad" class="form-label">Nacionalidad:</label>
                <input type="text" name="nacionalidad" class="form-control" placeholder="Escribe la nacionalidad del futbolista..."><br>
                <label for="edad" class="form-label">Edad:</label>
                <input type="number" name="edad" class="form-control" placeholder="Escribe la edad del futbolista...">
            </div>

            <div id="campoPosicion" class="mb-3" style="display: none;">
                <h2>Insertar una nueva posición:</h2>
                <label for="posicion" class="form-label">Posición:</label>
                <input type="text" name="posicion" class="form-control" placeholder="Escribe el nombre de la nueva posición..."><br>
                <label for="descripcion" class="form-label">Descripción:</label>
                <input type="text" name="descripcion" class="form-control" placeholder="Escribe una breve descripción de la posición...">
            </div>

            <button type="submit" class="btn btn-primary" id="campoBoton" style="display: none;">Ejecutar accion</button>
        </form>


</body>

</html>