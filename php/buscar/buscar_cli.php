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
    <title>Buscar Cliente | Safari</title>
</head>
<body>
    <header>
        <?php
            require_once("../funciones.php");
            echo mostrarCabecera("Buscar cliente","../paginas/clientes.php","../../img/huella.png");
        ?>
    </header>

    <main>
        <div id="contenedor">
            <div id="contenedorBuscarCli">
                <form action="#" method="post">
                    Nombre animal o dueño / Numero de teléfono dueño
                    <input type="text" name="busqueda">
                    <br><br>
                    <input type="submit" name="enviar">
                </form> 
            </div>
            <div id="resultadoBusqCli">
                <?php
                    if(isset($_POST["enviar"])){

                        $busqueda = $_POST["busqueda"];
                        $encontrado = false;
                        $r="";

                        $cabeza_tabla = "<table id='tablas_mostrar' border>
                                    <tr id='cabecera_tabla'>
                                        <td>Foto</td>
                                        <td>Nombre</td>
                                        <td>Tipo de animal</td>
                                        <td>Edad</td>
                                        <td>Nombre dueño</td>
                                    </tr>";

                        $conexion = conectarServidor();
                        
                        $sentencia = "select foto,nombre_animal,tipo_animal,edad,nombre_dueño
                                        from cliente
                                        where nombre_animal=?
                                        or nombre_dueño=?
                                        or telefono=?";

                        $consulta2 = $conexion->prepare($sentencia);
                        $consulta2->bind_param("sss",$busqueda,$busqueda,$busqueda);
                        $consulta2->bind_result($foto,$nombre_animal,$tipo_animal,$edad,$nombre_dueño);
                        $consulta2->execute();

                        while($consulta2->fetch()){
                            $r = $r."<tr>
                                        <td><img class='foto_animal' src='../../img/clientes/$foto'</td>
                                        <td>$nombre_animal</td>
                                        <td>$tipo_animal</td>
                                        <td>$edad</td>
                                        <td>$nombre_dueño</td>
                                     </tr>";
                        }

                        if($r===""){
                            echo "⇾ No se han encontrado datos acordes a tu busqueda ⇽";
                        }else{
                            echo $cabeza_tabla . $r . "</table>";
                        }

                        $consulta2->close();
                        $conexion->close();
                    }
                ?>
            </div>
        </div>
    </main>
</body>
</html>