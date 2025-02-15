<?php

    $_host = "localhost";
    $_bd = "equipodesarrollo";
    $_usuario = "root";
    $_contrasenia = "";

    //conexion con PDO PHP Dta Object

    try {
        //creamos objeto PDO es te incluye info para interactuar con la bbdd y realizar consultas, inserciones...
        $_conexion = new PDO("mysql:host=$_host;dbname=$_bd;charset=utf8", $_usuario, $_contrasenia);
    
        //configurar PDO para que salgan errores

        $_conexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



    } catch (PDOException $e) {
        die("ERROR: no se puede conectar " . $e -> getMessage());
    }


?>