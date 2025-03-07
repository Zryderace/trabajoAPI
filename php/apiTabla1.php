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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <?php
    $respuesta = [];
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $metodo = "GET";
            $nombreJugador = $_POST["nombreJugador"];
            $informacion = isset($_POST["informacion"]) ? $_POST["informacion"] : "";
            $datos = [];
            $url = "http://localhost/trabajoAPI/php/nucleoAPI.php";

        $error = false;

            if ($informacion=="") {
                $errorInfo = "Por favor selecciona tipo de informacion a enseñar";
                $error = true;
            } else {
                $url .= "?informacion=$informacion";
            }
            

        //hacemos trim, pasamos todo a minuscula, hacemos la primera mayuscula
        $nombreJugador = ucfirst(strtolower(trim($nombreJugador)));

            if (strlen($nombreJugador)<3) {
                $errorLongitud = "Por favor introduce 3 letras o mas para una mejor busqueda";
                $error = true;
            } else {
                $url = $url . "&nombreJugador=" . $nombreJugador;
            }


        if ($error) {
            //hay algun error

        } else {
            //all gucci sigma 100% aura no cap

            //no tenemos que dar datos ya que va por url
            $opciones = [
                "http" => [
                    "header" => "Content-Type: application/jason",
                    "method" => $metodo,
                    "content" => json_encode($datos)
                ]
            ];

            // echo "la p*ta url es: " . $url ."<br>";

            //crear contexto para mandar

            $contexto = stream_context_create($opciones);

                try {
                    //recibir respuesta de API
                    $respuesta = file_get_contents($url, false, $contexto);
                    //construye una conexion HTTP usando el contexto de stream context
                    //transformamos respuesta json a array asociativo para php
                    $respuesta = json_decode($respuesta, true);
                } catch (Exception $e) {
                    echo "Error al realizar la solicitud " . $e->getMessage();
                }
        
                // echo "<pre>" . htmlspecialchars($respuesta) . "</pre>";
                
            }
            

        }
    ?>

    <div class="container mt-5">
    <h2 class="mb-4">Formulario de Búsqueda de Jugador</h2>

    <form action="" method="post" class="border p-4 rounded shadow-sm bg-light">
        <div class="mb-3">
            <label for="nombreJugador" class="form-label">Nombre Jugador a buscar:</label>
            <!--
                quitar los required para ver mensajes de control de errores
            -->
            <input type="text" name="nombreJugador" class="form-control" id="nombreJugador" required>
        </div>

        <div class="mb-3">
            <label for="informacion" class="form-label">Información:</label>
            <select name="informacion" class="form-select" id="informacion" required>
                <option value="" selected disabled>Selecciona información</option>
                <option value="*">Toda la info</option>
                <option value="idEquipo">idEquipo</option>
                <option value="nombre">nombre</option>
                <option value="edad">edad</option>
                <option value="nacionalidad">nacionalidad</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary w-100">Buscar</button>
        
        <br>

        <?php
            echo isset($errorInfo) ? '<div class="alert alert-danger mt-3" role="alert">' . $errorInfo . '</div>' : "";
            echo isset($errorLongitud) ? '<div class="alert alert-danger mt-3" role="alert">' . $errorLongitud . '</div>' : "";
        ?>
    </form>
</div>

<div class="container mt-5">
    <h2 class="mb-4">Lista de Jugadores</h2>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Equipo ID</th>
                <th>Nombre</th>
                <th>Posición</th>
                <th>Nacionalidad</th>
                <th>Edad</th>
            </tr>
        </thead>
        <tbody>
            <?php
                
                foreach ($respuesta as $jugador) { 
                    echo "<tr>";
                    echo "<td>" . (isset($jugador['id']) ? $jugador['id'] : 'N/A') . "</td>";
                    echo "<td>" . (isset($jugador['idEquipo']) ? $jugador['idEquipo'] : 'N/A') . "</td>";
                    echo "<td>" . (isset($jugador['nombre']) ? $jugador['nombre'] : 'N/A') . "</td>";
                    echo "<td>" . (isset($jugador['posicion']) ? $jugador['posicion'] : 'N/A') . "</td>";
                    echo "<td>" . (isset($jugador['nacionalidad']) ? $jugador['nacionalidad'] : 'N/A') . "</td>";
                    echo "<td>" . (isset($jugador['edad']) ? $jugador['edad'] : 'N/A') . "</td>";
                    echo "</tr>";
                }
            ?>
        </tbody>
    </table>
</div>

</body>

</html>