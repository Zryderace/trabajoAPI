<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POST</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script>
        function mostrarFormulario() {
            let seleccion = document.querySelector("select[name=seleccion]").value;

            let campoEquipo = document.getElementById("campoEquipo");
            let campoJugador = document.getElementById("campoJugador");
            let campoPosicion = document.getElementById("campoPosicion");
            let campoBoton = document.getElementById("campoBoton");

            campoEquipo.style.display = "none";
            campoJugador.style.display = "none";
            campoPosicion.style.display = "none";
            campoBoton.style.display = "none";

            if (seleccion == "equipos") {
                campoEquipo.style.display = "block";
                campoBoton.style.display = "block";
            } else if (seleccion == "jugadores") {
                campoJugador.style.display = "block";
                campoBoton.style.display = "block";
            } else if (seleccion == "posiciones") {
                campoPosicion.style.display = "block";
                campoBoton.style.display = "block";
            }
        }
    </script>
    <?php
        // Activa la visualización de errores para depuración
        error_reporting(E_ALL);
        ini_set("display_errors", 1);

        // Recoger informacion del archivo de conexion.
        require "conexionPDO.php";
    ?>
</head>
<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $metodo = "POST";
        // Variable para controlar que hemos enviado al nucleoAPI
        $tabla = isset($_POST["seleccion"]) ? $_POST["seleccion"] : "";
        // Array donde se almacenará la información que deseamos enviar al nucleoAPI
        $datos = []; 
        // URL donde se enviarán los datos
        $url = "http://localhost/trabajoAPI/php/nucleoAPI.php";

        // Booleano para controlar errores
        $error = false;

        // Comprobación según la tabla seleccionada
        if ($tabla == "equipos") {
            // Recoge y limpia los datos del formulario
            $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : "";
            $ciudad = isset($_POST["ciudad"]) ? $_POST["ciudad"] : "";
            $estadio = isset($_POST["estadio"]) ? $_POST["estadio"] : "";

            $nombre = ucfirst(strtolower(trim($nombre)));
            $ciudad = ucfirst(strtolower(trim($ciudad)));
            $estadio = ucfirst(strtolower(trim($estadio)));

            // Verifica si el equipo ya existe en la base de datos
            $arrayEquipos = [];
            try {
                $res = $_conexion->query("SELECT * FROM equipos");
                foreach($res as $equipos) {
                    array_push($arrayEquipos, $equipos["nombre"]);
                }
            } catch (PDOException $e) {
                echo "Error en la consulta " . $e->getMessage();
            }

            // Validación de datos
            if ($nombre == "" || $ciudad == "" || $estadio == "") {
                echo ("<p>Por favor rellene todos los datos</p>");
                $error = true;
            } elseif (strlen($nombre) < 3) {
                echo ("<p>Por favor introduce 3 o más letras para el nombre del equipo!</p>");
                $error = true;
            } elseif (strlen($ciudad) < 3) {
                echo ("<p>Por favor introduce 3 o más letras para la ciudad del equipo!</p>");
                $error = true;
            } elseif (strlen($estadio) < 3) {
                echo ("<p>Por favor introduce 3 o más letras para el estadio del equipo!</p>");
                $error = true;
            } elseif (in_array($nombre, $arrayEquipos)) {
                echo ("<p>El equipo introducido ya existe en la BBDD.</p>");
                $error = true;
            }
        } else if ($tabla == "jugadores") {
            // Recoge y limpia los datos del formulario
            $idEquipo = isset($_POST["equipoJugador"]) ? $_POST["equipoJugador"] : "";
            $nombre = isset($_POST["nombreJugador"]) ? $_POST["nombreJugador"] : "";
            $posicion = isset($_POST["posicionJugador"]) ? $_POST["posicionJugador"] : "";
            $nacionalidad = isset($_POST["nacionalidad"]) ? $_POST["nacionalidad"] : "";
            $edad = isset($_POST["edad"]) ? $_POST["edad"] : "";

            $nombre = ucfirst(strtolower(trim($nombre)));
            $nacionalidad = ucfirst(strtolower(trim($nacionalidad)));
            $edad = trim($edad);

            // Verifica si el jugador ya existe
            $arrayJugadores = [];
            try {
                $res = $_conexion->query("SELECT * FROM jugadores");
                foreach($res as $jugadores) {
                    array_push($arrayJugadores, $jugadores["nombre"]);
                }
            } catch (PDOException $e) {
                echo "Error en la consulta " . $e->getMessage();
            }

            // Validación de datos
            if ($nombre == "" || $idEquipo == "" || $posicion == "" || $nacionalidad == "" || $edad == "") {
                echo ("<p>Por favor rellene todos los datos</p>");
                $error = true;
            } elseif (strlen($nombre) < 3) {
                echo ("<p>Por favor introduce 3 o más letras para el nombre del futbolista!</p>");
                $error = true;
            } elseif (strlen($nacionalidad) < 3) {
                echo ("<p>Por favor introduce 3 o más letras para la nacionalidad del futbolista!</p>");
                $error = true;
            } elseif ($edad < 16 || $edad >= 100) {
                echo ("<p>Por favor introduce una edad entre 16 y 100 años!</p>");
                $error = true;
            } elseif (in_array($nombre, $arrayJugadores)) {
                echo ("<p>El jugador introducido ya existe en la BBDD.</p>");
                $error = true;
            } 
        } else if ($tabla == "posiciones") {
            // Recoge y limpia los datos del formulario
            $posicion = isset($_POST["posicion"]) ? $_POST["posicion"] : "";
            $descripcion = isset($_POST["descripcion"]) ? $_POST["descripcion"] : "";

            $posicion = ucfirst(strtolower(trim($posicion)));
            $descripcion = ucfirst(trim($descripcion));

            // Verifica si el nombre de la posicion ya existe
            $arrayPosiciones = [];
            try {
                $res = $_conexion->query("SELECT * FROM posiciones");
                foreach($res as $posiciones) {
                    array_push($arrayPosiciones, $posiciones["posicion"]);
                }
            } catch (PDOException $e) {
                echo "Error en la consulta " . $e->getMessage();
            }

            // Validación de datos
            if ($posicion == "" || $descripcion == "") {
                echo ("<p>Por favor rellene todos los datos</p>");
                $error = true;
            } elseif (strlen($posicion) < 3) {
                echo ("<p>Por favor introduce 3 o más letras para la posicion!</p>");
                $error = true;
            } elseif (strlen($descripcion) < 3) {
                echo ("<p>Por favor introduce 3 o más letras para la descripcion de la posición!</p>");
                $error = true;
            } elseif (in_array($posicion, $arrayPosiciones)) {
                echo ("<p>La posicion introducida ya existe en la BBDD.</p>");
                $error = true;
            }
            
        } else {
            $error = true;
            echo ("<p>No existe tabla en BBDD</p>");
        }

        if (!$error) {
            // Si no hubo errores, prepara los datos para nucleoAPI
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
            } else if ($tabla == "posiciones") {
                $datos = [
                    "posicion" => $posicion,
                    "descripcion" => $descripcion,
                    "tabla" => $tabla
                ];
            } else {
                $error = true;
                echo ("<p>No existe tabla en BBDD</p>");
            }

            // Configura la solicitud HTTP a la API
            $opciones = [
                "http" => [
                    "header" => "Content-Type: application/json",
                    "method" => $metodo,
                    "content" => json_encode($datos)
                ]
            ];

            $contexto = stream_context_create($opciones);

            /**
             * Establece una conexión HTTP con stream_context_create(),
             * envía una solicitud POST con los datos y devuelve la respuesta del servidor.
             * Si hay un error, muestra el mensaje. El false evita que PHP busque el archivo en las rutas de include_path.
            */
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