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
    <title>Insertar producto | Safari</title>
</head>
<body>
    <header>
        <?php
            require_once("../funciones.php");
            echo mostrarCabecera("Insertar producto","../paginas/productos.php","../../img/huella.png");
        ?>
    </header>
    <main>

    <div id="contenedor">
            <div id="contenedor_inser_pro">
                <form action="#" method="post">
                    <span> 
                        <label>ID</label>
                    <?php
                        $conexion = conectarServidor();
                        $sacar_id=$conexion->query("select auto_increment
                                                 from information_schema.TABLES
                                                 where TABLE_SCHEMA='veterinaria'
                                                 and TABLE_NAME='producto'");
                        while($fila = $sacar_id->fetch_array(MYSQLI_ASSOC)){
                            $id=$fila["auto_increment"];
                            echo "<input type='text' placeholder='$id' readonly>";
                        }
                    ?>
                    </span>
                    <br>
                    <span>
                        <label>Nombre</label>
                        <input type="text" name="nombre">
                    </span>
                    <br>
                    <span>
                        <label>Precio</label>
                        <input type="text" name="precio">
                    </span> 
                    <br>
                    <input type="submit" name="enviar">
                </form>
            </div>
            <div id="res">
                <?php
                    if(isset($_POST["enviar"])){
                        $nombre = $_POST["nombre"];
                        $precio = $_POST["precio"];

                        if($precio<=0 || $precio===""){
                            echo "⇾ El precio no puede ser negativo o no puede estar vacio ⇽";
                        }else{
                            if($nombre===""){
                                echo "⇾ El campo ' Nombre ' no puede estar vacio ⇽";
                            }else{
                                $sentencia = "insert into producto values(null,?,?)";
                                $consulta = $conexion->prepare($sentencia);
                                $consulta->bind_param("si",$nombre,$precio);
                                $consulta->execute();

                                if($conexion->affected_rows===0){
                                    echo "⇾ Datos introducidos de forma erronea ⇽";
                                }else{
                                    echo "⇾ Datos introducidos correctamente ⇽";
                                }

                                $consulta->close();
                                $conexion->close();
                            }
                        }
                    }
                ?>
            </div>
        </div>

    </main>
</body>
</html>