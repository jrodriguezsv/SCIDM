<?php
    $host = "localhost";
    $port = "5432";
    $user = "oracle";
    $pass = "oracle";
    $db   = "inventario";

    $conexion = pg_connect ("host=".$host." port=".$port." user=".$user." password=".$pass." dbname=".$db."");

    /*if(!$conexion)
        echo "<p><i>No me conecte</i></p>";
    else
        echo "<p><i>Me conecte</i></p>";*/
?>