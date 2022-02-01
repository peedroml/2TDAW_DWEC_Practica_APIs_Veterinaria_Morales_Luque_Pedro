<?php
    session_start();

    if(!isset($_COOKIE["como_admin"])){
        header("location:../paginas/login.php");
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300&display=swap" rel="stylesheet">
    <link rel="icon" href="../../img/favicon.png" type="image/png"/>
    <link rel="stylesheet" href="../../css/styles.css">
    <title>Borrar producto | Safari</title>
</head>
<body>
    <header>
        <?php
            require_once("../funciones.php");
            echo mostrarCabecera("Eliminar producto","../paginas/productos.php","../../img/huella.png");
        ?>
    </header>
    <main>

        <div id="contenedor">
            <div id="contenedor_borrar_pro">
                <form action="#" method="post">
                    Ingresa el nombre del producto que deseas eliminar
                    <input type="text" name="nombre">
                    <br><br>
                    <input type="submit" name="enviar">
                </form>
            </div>
            <div id="res_eliminar">
                <?php
                    if(isset($_POST["enviar"])){
                        $conexion = conectarServidor();
                        $nombre_pro = $_POST["nombre"];

                        $sentencia = "delete from producto
                                      where nombre=?";

                        $consulta = $conexion->prepare($sentencia);
                        $consulta->bind_param("s",$nombre_pro);
                        $consulta->execute();

                        if($conexion->affected_rows===0){
                            echo "⇾ No se ha encontrado ningun producto con ese nombre ⇽";
                        }else{
                            echo "⇾ Datos eliminados satisfactoriamente ⇽";
                        }
                        $consulta->close();
                        $conexion->close();
                    }
                ?>
            </div>
        </div>

    </main>
</body>
</html>