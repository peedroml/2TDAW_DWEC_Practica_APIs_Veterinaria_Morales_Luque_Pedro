<?php
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    require_once("../funciones.php");

    sleep(2);

    $conex = conectarServidor();
    $noticias = [];

    $consulta = $conex->query("select * from noticia");

    while($noticia = $consulta->fetch_array(MYSQLI_ASSOC)){
        $noticias[] = $noticia;
    }

    echo json_encode($noticias);
?>