<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GET Jugadores</title>
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
        $metodo = "DELETE";
        $nombreJugador = $_POST["nombreJugador_borrar"];
        $datos = [];
        $url = "http://localhost/trabajoAPI/php/nucleoAPI.php";

        $error = false;

        //hacemos trim, hacemos la primera mayuscula
        $nombreJugador = ucfirst(trim($nombreJugador));
        $resultado = $_conexion -> query("SELECT * FROM jugadores");

        if ($nombreJugador == "") {
            echo ("Por favor introduce un jugador.");
            $error = true;
        } else {
            $url = $url . "?=" . urlencode($nombreJugador);
        }
        $datos = [
            "nombreJugador_borrar" => $_POST["nombreJugador_borrar"]
        ];

        if ($error) {
            //hay algun error

        } else {
            //all gucci sigma 100% aura no cap

            //no tenemos que dat datos ya que va por url
            $opciones = [
                "http" => [
                    "header" => "Content-Type: application/json",
                    "method" => $metodo,
                    "content" => json_encode($datos)
                ]
            ];

            var_dump($datos);

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
        <div class="container m-4">
            <h1>BORRAR JUGADOR</h1>
            <div class="mb-3">
                <label for="nombreJugador_borrar" class="form-label">Nombre Jugador a buscar:</label>
                <input type="text" class="form-control" name="nombreJugador_borrar" placeholder="Escribe el nombre de un futbolista...">
            </div>
            <button class="btn btn-primary" type="submit">Borrar</button>
        </div>
    </form>

</body>
</html>