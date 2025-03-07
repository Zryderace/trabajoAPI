<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CURL 3</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <?php
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
    require "conexionPDO.php";
    ?>
</head>

<body>
    <div class="container m-4">
        <h1>Mostrar todas las posiciones junto a su descripción</h1>
        <?php
        $apiURL = "http://localhost/trabajoAPI/php/nucleoAPIcURL3.php";

        $curl = curl_init(); // Iniciar una sesion cURL, por que? Pq cURL requiere de una estrucutra en memoria para 
                            // almacenar la info de la solicitud y la respuesta

        curl_setopt($curl, CURLOPT_URL, $apiURL); // Establecer la URL a consultar
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Devolver el resultado en lugar de imprimirlo en pantalla

        $res = curl_exec($curl); // Ejecutar la sesion

        curl_close($curl);

        // var_dump($res); // Mostrarlo primero para ver el formatin de json

         // Lo convierte a array asociativo 
        

        ?>
        <h3>JSON</h3>
        <?php
            echo $res;
        ?>
        <br><hr>
        
        <h3>ARRAY ASOCIATIVO</h3>
        <?php
        $res = json_decode($res, true);
        var_dump($res);

        ?>
    </div>


</body>

</html>