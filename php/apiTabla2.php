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
        error_reporting(E_ALL);
        ini_set("display_errors", 1);
        require "conexionPDO.php";
    ?>
</head>
<body>
    <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $metodo = "POST";
                $tabla = isset($_POST["tabla"]) ? $_POST["tabla"] : "";
                $datos = [];
                $url = "http://localhost/trabajoAPI/php/nucleoAPI.php";

                $error = false;

                $consulta = "SELECT * FROM equipos";
                $resultado = $_conexion -> query($consulta);
                $equipos = [];
                while($fila = $resultado -> fetch_assoc()) {
                    array_push($equipos, $fila["id"]);
                }        

                if ($tabla=="equipos") {
                    $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : "";
                    $ciudad = isset($_POST["ciudad"]) ? $_POST["ciudad"] : "";
                    $estadio = isset($_POST["estadio"]) ? $_POST["estadio"] : "";

                    if ($nombre==""||$ciudad==""||$estadio=="") {
                        echo("por favor rellena todos los datos");
                        $error = true;
                    } else {
        
                        //TODO HACER LIMPIEZA DE INYECCION DE CODIGO Y VALIDAR TIPO DE DATOS
                        
                        $nombre = ucfirst(strtolower(trim($nombre)));
                        $ciudad = ucfirst(strtolower(trim($ciudad)));
                        $estadio = ucfirst(strtolower(trim($estadio)));
        
                        if (strlen($nombre)<3) {
                            echo("Por favor introduce 3 letras o mas para nombreEquipo");
                            $error = true;
                        }
                        if (strlen($ciudad)<3) {
                            echo("Por favor introduce 3 letras o mas para nombreEquipo");
                            $error = true;
                        }
                        if (strlen($estadio)<3) {
                            echo("Por favor introduce 3 letras o mas para nombreEquipo");
                            $error = true;
                        }
                    }
                } else if ($tabla=="jugadores") {
                    $idEquipo = isset($_POST["idEquipo"]) ? $_POST["idEquipo"] : "";
                    $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : "";
                    $posicion = isset($_POST["posicion"]) ? $_POST["posicion"] : "";
                    $nacionalidad = isset($_POST["nacionalidad"]) ? $_POST["nacionalidad"] : "";
                    $edad = isset($_POST["edad"]) ? $_POST["edad"] : "";

                    if ($nombre==""||$idEquipo==""||$posicion==""||$nacionalidad==""||$edad=="") {
                        echo("por favor rellena todos los datos");
                        $error = true;
                    } else {
        
                        //TODO HACER LIMPIEZA DE INYECCION DE CODIGO Y VALIDAR TIPO DE DATOS

                        //idEquipo deben venir bien dados, hacer comprobacion con BBDD despues en API
                        //igual con posicion

                        $nombre = ucfirst(strtolower(trim($nombre)));
                        $nacionalidad = ucfirst(strtolower(trim($nacionalidad)));
                        $edad = trim($edad);
        
                        if (strlen($nombre)<3) {
                            echo("Por favor introduce 3 letras o mas para nombre");
                            $error = true;
                        }
                        if (strlen($nacionalidad)<3) {
                            echo("Por favor introduce 3 letras o mas para nacionalidad");
                            $error = true;
                        }
                        if ($edad<16||$edad>=100) {
                            echo("Por favor introduce edad >15 y <100");
                            $error = true;
                        }
                    }
                } else  if ($tabla=="posiciones") {
                    $posicion = isset($_POST["posicion"]) ? $_POST["posicion"] : "";
                    $descripcion = isset($_POST["descripcion"]) ? $_POST["descripcion"] : "";

                    if ($posicion==""||$descripcion=="") {
                        echo("por favor rellena todos los datos");
                        $error = true;
                    } else {
        
                        //aqui no hace falta limpieza, comprabar en API posicion es distinta

                        $posicion = ucfirst(strtolower(trim($posicion)));
                        $descripcion = ucfirst(trim($descripcion));
        
                        if (strlen($posicion)<3) {
                            echo("Por favor introduce 3 letras o mas para posicion");
                            $error = true;
                        }
                        if (strlen($descripcion)<3) {
                            echo("Por favor introduce 3 letras o mas para descripcion");
                            $error = true;
                        }
                    }
                } else {
                    $error = true;
                    echo("no existe tabla en BBDD");
                }



                if ($error) {
                    //hay algun error
                    
                } else {
                    //all gucci sigma 100% aura no cap

                    if ($tabla=="equipos") {
                        $datos = [
                            "nombre" => $nombre,
                            "ciudad" => $ciudad,
                            "estadio" => $estadio,
                            "tabla" => $tabla
                        ];
                    } else if ($tabla=="jugadores") {
                        $datos = [
                            "idEquipo" => $idEquipo,
                            "nombre" => $nombre,
                            "posicion" => $posicion,
                            "nacionalidad" => $nacionalidad,
                            "edad" => $edad,
                            "tabla" => $tabla
                        ];
                    } else  if ($tabla=="posiciones") {
                        $datos = [
                            "posicion" => $posicion,
                            "descripcion" => $descripcion,
                            "tabla" => $tabla
                        ];
                    } else {
                        $error = true;
                        echo("no existe tabla en BBDD");
                    }
                    

                    
                                    
                    $opciones = [
                        "http" => [
                            "header" => "Content-Type: application/jason",
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
                    <!-- MEJORAR CON FOREACH - para recoger los que se encuentren de la tabla equipos y no escribirlos a mano -->
                    <?php foreach($equipos as $equipo) { ?>
                        <option value="<?php echo $idEquipo ?>">
                            <?php echo $nombre ?>
                        </option>
                    <?php } ?>
                    <!--
                        <option value="1">Real Madrid</option>
                        <option value="2">FC Barcelona</option>
                        <option value="3">Manchester United</option>
                        <option value="4">Paris Saint-Germain</option>
                        <option value="5">Bayern Munich</option>
                    -->
                </select><br>
                
                <label for="nombreJugador" class="form-label">Nombre:</label>
                <input type="text" name="nombreJugador" class="form-control" placeholder="Escribe el nombre del futbolista..."><br>
                <label for="posicion" class="form-label">Posición:</label>
                <select name="posicion" class="form-select">
                    <option selected disabled>---ELIJA UNA POSICIÓN---</option>
                    <!-- MEJORAR CON FOREACH - para recoger los que se encuentren de la tabla equipos y no escribirlos a mano -->
                    <option value="portero">Portero</option>
                    <option value="defensa Central">Defensa Central</option>
                    <option value="delantero">Delantero</option>
                    <option value="extremo">Extremo</option>
                    <option value="lateral">Lateral</option>
                    <option value="mediocentroDefensivo">Mediocentro Defensivo</option>
                    <option value="mediocentroOfensivo">Mediocentro Ofensivo</option>
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