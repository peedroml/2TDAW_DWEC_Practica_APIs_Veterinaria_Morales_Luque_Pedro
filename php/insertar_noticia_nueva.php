<?php
    session_start();

    header('Content-Type: application/json');
    header("Access-Control-Allow-Origin: *");
    require_once("funciones.php");

    $conexion=conectarServidor();

    if(isset($_REQUEST["titulo"]) && isset($_REQUEST["contenido"]) && isset($_REQUEST["imagen"]) && isset($_REQUEST["fecha"])){
        $titulo=$_REQUEST["titulo"];
        $contenido=$_REQUEST["contenido"];
        $imagen=$_REQUEST["imagen"];
        $fecha=$_REQUEST["fecha"];

        $sentencia=$conexion->prepare("INSERT INTO noticia VALUES(null,?,?,?,?)");
        $sentencia->bind_param("ssss",$titulo,$contenido,$imagen,$fecha);

        $sentencia->execute();

        $filas_afectadas=$sentencia->affected_rows;

        if($filas_afectadas==1){
            echo $conexion->insert_id;
        }else{
            echo"false";
        }
    }else{
        echo"false";
    }
?>