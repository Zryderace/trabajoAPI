<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POST</title>
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

    <form action="">
        <label for="seleccionar">Añadir datos a la tabla:</label>
        <!--
            TODO hacer que esto enseñe un formulario con datos u otro
        -->
        <select name="seleccion"  onchange="mostrarFormulario()">
            <option value="equipos">Equipos</option>
            <option value="jugadores">Jugadores</option>
            <option value="posiciones">Posiciones</option>
        </select>
    </form>

    <form action="" method="post" id="equipos">
        <h1>Insertar Equipo</h1>
        <input type="hidden" name="tabla" value="equipos">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre">
        <label for="ciudad">Ciudad:</label>
        <input type="text" name="ciudad">
        <label for="estadio">Estadio:</label>
        <input type="text" name="estadio">
        <button type="submit">Prueba loco</button>
    </form>


    <br>


    <form action="" method="post" id="jugadores">
        <h1>Insertar Jugador</h1>
        <input type="hidden" name="tabla" value="jugadores">
        <!--
            TODO hacer que conecte a la BBDD y mostrar equipos automaticamente?
        -->
        <label for="idEquipo">Equipo</label>
        <select name="idEquipo">
            <option value="1">Real Madrid</option>
            <option value="2">FC Barcelona</option>
            <option value="3">Manchester United</option>
            <option value="4">Paris Saint-Germain</option>
            <option value="5">Bayern Munich</option>
        </select>
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre">
        <!--
            TODO hacer que conecte a la BBDD y mostrar equipos automaticamente?
        -->
        <label for="posicion">Posicion</label>
        <select name="posicion">
            <option value="Defensa Central">Defensa Central</option>
            <option value="Delantero">Delantero</option>
            <option value="Extremo">Extremo</option>
            <option value="Lateral">Lateral</option>
            <option value="Mediocentro Defensivo">Mediocentro Defensivo</option>
            <option value="Mediocentro Ofensivo">Mediocentro Ofensivo</option>
            <option value="Pivote">Pivote</option>
            <option value="Portero">Portero</option>
        </select>
        <label for="nacionalidad">nacionalidad:</label>
        <input type="nacionalidad" name="nacionalidad">
        <label for="edad">edad:</label>
        <input type="text" name="edad">
        <button type="submit">Prueba loco</button>
    </form>


    <br>

    
    <form action="" method="post" id="posiciones">
        <h1>Insertar Posicion</h1>
        <input type="hidden" name="tabla" value="posiciones">
        <label for="posicion">Posicion:</label>
        <input type="text" name="posicion">
        <label for="descripcion">descripcion:</label>
        <input type="text" name="descripcion">
        <button type="submit">Prueba loco</button>
    </form>

</body>
</html>