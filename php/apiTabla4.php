<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DELETE</title>
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
        error_reporting(E_ALL);
        ini_set("display_errors", 1);
        require "conexionPDO.php";
    ?>
</head>

<body>
    <div class="container m-4">
        <h1>BORRAR DATOS A LA BBDD</h1>
        <form action="" method="post">
            <div class="mb-3">
                <label for="seleccion" class="form-label">Borrar datos en la tabla: </label>
                <select name="seleccion" class="form-select" onchange="mostrarFormulario()">
                    <option selected disabled>---ELIJA UNA TABLA---</option>
                    <option value="equipos">Equipos</option>
                    <option value="jugadores">Jugadores</option>
                    <option value="posiciones">Posiciones</option>
                </select>
            </div>
            <div id="campoEquipo" class="mb-3" style="display: none;">
                <h2>Borrar un equipo:</h2>
                <label for="nombreEquipo_borrar" class="form-label">Nombre Equipo a borrar:</label>
                <input type="text" class="form-control" name="nombreEquipo_borrar" placeholder="Escribe el nombre de un equipo..."><br>
            </div>
            <div id="campoJugador" class="mb-3" style="display: none;">
                <h2>Borrar un jugador:</h2>
                <label for="nombreJugador_borrar" class="form-label">Nombre Jugador a borrar:</label>
                <input type="text" class="form-control" name="nombreJugador_borrar" placeholder="Escribe el nombre de un futbolista..."><br>
            </div>
            <div id="campoPosicion" class="mb-3" style="display: none;">
                <h2>Borrar una posición:</h2>
                <label for="nombrePosicion_borrar" class="form-label">Nombre Posición a borrar:</label>
                <input type="text" class="form-control" name="nombrePosicion_borrar" placeholder="Escribe la posición de fútbol..."><br>
            </div>
            <button class="btn btn-primary" type="submit" id="campoBoton" style="display: none;">Borrar</button>
        </form>
    </div>
    
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $metodo = "DELETE";
        $tabla = isset($_POST["seleccion"]) ? $_POST["seleccion"] : "";
        $nombreJugador = $_POST["nombreJugador_borrar"];
        $nombreEquipo = $_POST["nombreEquipo_borrar"];
        $nombrePosicion = $_POST["nombrePosicion_borrar"];
        $datos = [];
        $url = "http://localhost/trabajoAPI/php/nucleoAPI.php";

        $error = false;

        //hacemos trim, hacemos la primera mayuscula
        if ($error) {

        } else {
            if ($nombreJugador != "" && $nombreEquipo != "" && $nombrePosicion != "") {
                echo "Selecciona solo 1 opción.";
            } else {
                if ($tabla == "jugadores") {
                    $nombreJugador = ucfirst(trim($nombreJugador));
                    $resultado = $_conexion -> query("SELECT * FROM jugadores");
                    $resultado2 = $_conexion -> query("SELECT * FROM jugadores WHERE nombre = '$nombreJugador'");
                    if ($nombreJugador == "") {
                        echo ("Por favor introduce un jugador.");
                        $error = true;
                    } else if ($resultado2->rowCount() == 0) {
                        echo ("Ese jugador no existe. Introduce un jugador que esté dentro de la base de datos.");
                        $error = true;
                    } else {
                        $url = $url . "?=" . urlencode($nombreJugador);
                        $datos = [
                            "nombreJugador_borrar" => $_POST["nombreJugador_borrar"],
                            "tabla" => $tabla
                        ];
        
                        //all gucci sigma 100% aura no cap
        
                        //no tenemos que dat datos ya que va por url
                        $opciones = [
                            "http" => [
                                "header" => "Content-Type: application/json",
                                "method" => $metodo,
                                "content" => json_encode($datos)
                            ]
                        ];
        
                        // echo "la puta url es: " . $url ."<br>";
                        $contexto = stream_context_create($opciones);
        
                        try {
                            $respuesta = file_get_contents($url, false, $contexto);
                            //construye una conexion HTTP usando el contexto de stream context
                        } catch (Exception $e) {
                            echo "Error al realizar la solicitud " . $e->getMessage();
                        }
        
                        echo "<pre>" . htmlspecialchars($respuesta) . "</pre>";
                    }
                } else if ($tabla == "equipos") {
                    $nombreEquipo = ucfirst(trim($nombreEquipo));
                    $resultado = $_conexion -> query("SELECT * FROM equipos");
                    $resultado2 = $_conexion -> query("SELECT * FROM equipos WHERE nombre = '$nombreEquipo'");
                    if ($nombreEquipo == "") {
                        echo ("Por favor introduce un equipo.");
                        $error = true;
                    } else if ($resultado2->rowCount() == 0) {
                        echo ("Ese equipo no existe. Introduce un equipo que esté dentro de la base de datos.");
                        $error = true;
                    } else {
                        $url = $url . "?=" . urlencode($nombreEquipo);
                        $datos = [
                            "nombreEquipo_borrar" => $_POST["nombreEquipo_borrar"],
                            "tabla" => $tabla
                        ];
                        //all gucci sigma 100% aura no cap
        
                        //no tenemos que dat datos ya que va por url
                        $opciones = [
                            "http" => [
                                "header" => "Content-Type: application/json",
                                "method" => $metodo,
                                "content" => json_encode($datos)
                            ]
                        ];
        
                        // echo "la puta url es: " . $url ."<br>";
                        $contexto = stream_context_create($opciones);
        
                        try {
                            $respuesta = file_get_contents($url, false, $contexto);
                            //construye una conexion HTTP usando el contexto de stream context
                        } catch (Exception $e) {
                            echo "Error al realizar la solicitud " . $e->getMessage();
                        }
        
                        echo "<pre>" . htmlspecialchars($respuesta) . "</pre>";
                    }
                } else if ($tabla == "posiciones") {
                    $nombrePosicion = ucfirst(trim($nombrePosicion));
                    $resultado = $_conexion -> query("SELECT * FROM posiciones");
                    $resultado2 = $_conexion -> query("SELECT * FROM posiciones WHERE posicion = '$nombrePosicion'");
                    if ($nombrePosicion == "") {
                        echo ("Por favor introduce una posición de fútbol.");
                        $error = true;
                    } else if ($resultado2->rowCount() == 0) {
                        echo ("Esa posición no existe. Introduce una posición de fútbol que esté dentro de la base de datos.");
                        $error = true;
                    } else {
                        $url = $url . "?=" . urlencode($nombreEquipo);
                        $datos = [
                            "nombrePosicion_borrar" => $_POST["nombrePosicion_borrar"],
                            "tabla" => $tabla
                        ];
                        //all gucci sigma 100% aura no cap
        
                        //no tenemos que dat datos ya que va por url
                        $opciones = [
                            "http" => [
                                "header" => "Content-Type: application/json",
                                "method" => $metodo,
                                "content" => json_encode($datos)
                            ]
                        ];
        
                        // echo "la puta url es: " . $url ."<br>";
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
    
            }
        }
    }
    ?>
</body>
</html>