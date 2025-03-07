<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INICIO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <?php 
        error_reporting(E_ALL);
        ini_set("display_errors",1);
        require "conexionPDO.php";
    ?>
</head>
<body>
    <div class="container text-center mt-5">
        <h1>Q pasa pisha, aquí nuestra API:</h1>
        <p class="mt-3">Elige una opción:</p>
        <div class="d-grid gap-3 col-6 mx-auto mt-4">
            <a href="apiTabla5.php" class="btn btn-primary btn-lg">Mostrar todos los nombres de los futbolistas</a>
            <a href="apiTabla6.php" class="btn btn-secondary btn-lg">Mostrar todos los equipos junto a sus informaciones</a>
            <a href="apiTabla7.php" class="btn btn-primary btn-lg">Mostrar todas las posiciones junto a su descripción</a>
        </div>
    </div>

    
</body>
</html>