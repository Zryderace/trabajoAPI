<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GET Jugadores</title>
    <?php
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    require "conexionPDO.php";
    ?>
</head>
<body>

    <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $metodo = "GET";
            $nombreJugador = $_POST["nombreJugador"];
            $informacion = isset($_POST["informacion"]) ? $_POST["informacion"] : "";
            $datos = [];
            $url = "http://localhost/trabajoAPI/php/nucleoAPI.php";

            $error = false;

            if ($informacion=="") {
                echo("por favor selecciona tipo de formacion a enseñar");
                $error = true;
            } else {
                $url .= "?informacion=$informacion";
            }
            

            //hacemos trim, pasamos todo a minuscula, hacemos la primera mayuscula
            $nombreJugador = ucfirst(strtolower(trim($nombreJugador)));

            if (strlen($nombreJugador)<3) {
                echo("Por favor introduce 3 letras o mas para una mejor busqueda");
                $error = true;
            } else {
                $url = $url . "&nombreJugador=" . $nombreJugador;
            }


            if ($error) {
                //hay algun error
                
            } else {
                //all gucci sigma 100% aura no cap
                                
                //no tenemos que dat datos ya que va por url
                $opciones = [
                    "http" => [
                        "header" => "Content-Type: application/jason",
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
    ?>

    <form action="" method="post">
        <label for="nombreJugador">Nombre Jugador a buscar:</label>
        <input type="text" name="nombreJugador">
        <label for="informacion">Informacion:</label>
        <select name="informacion" class="form-select" onchange="mostrarFormulario()">
            <option value="" selected disabled>Selecciona informacion</option>
            <option value="*">Toda la info</option>
            <option value="idEquipo">idEquipo</option>
            <option value="nombre">nombre</option>
            <option value="edad">edad</option>
            <option value="nacionalidad">nacionalidad</option>
        </select>
        <button type="submit">Prueba loco</button>
    </form>
</body>
</html>