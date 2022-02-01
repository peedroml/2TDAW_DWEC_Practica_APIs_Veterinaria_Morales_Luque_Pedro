<?php
    session_start();

    if(!isset($_COOKIE["como_admin"])){
        header("location:login.php");
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
    <title>Testimonios | Safari</title>
</head>
<body>

    <?php
        require_once("../funciones.php");
        echo mostrarCabecera("Testimonios","../../index.php","../../img/huella.png");
    ?>
    
    <header>
        <?php
            echo mostrarNavAdmin("../../index.php","clientes.php","productos.php","servicios.php","testimonios.php","noticias.php","citas.php","dueños.php","galeria.php");
            if(isset($_POST["cerrar_sesion"])){
                setcookie("como_admin",null,-3,"/");
                header("location:../../index.php");
            }
        ?>
    </header>
    <main>
        <div id="contenedor">
            <div class="insertar_datos">
                <div>
                    <a href="../insertar/insertar_testimonio.php">Insertar nuevo testimonio</a>
                </div>
            </div>
            <div id="contenedorTes">
                <table id="tablas_mostrar">
                    <tr id="cabecera_tabla">
                        <td>Autor</td>
                        <td>Contenido</td>
                        <td>Fecha de publicacion</td>
                    </tr>
                    <?php
                        $conex = conectarServidor();
                        $mostrarTes = $conex->query("select *
                                                     from testimonio
                                                     order by fecha_publicacion desc");
                        
                        while($fila = $mostrarTes->fetch_array(MYSQLI_ASSOC)){
                            
                            $fecha = explode("-",$fila["fecha_publicacion"]);
                            $dia = ltrim($fecha[2],"0");
                            $mes = mostrarMes($fecha[1]);

                            echo "<tr>
                                    <td>$fila[autor]</td>
                                    <td>$fila[contenido]</td>
                                    <td>$dia de $mes del $fecha[0]</td>
                                  </tr>";
                        }
                        $conex->close();
                    ?>
                </table>
            </div>
        </div>
    </main>
    <footer>
        <?php
            echo mostrarFooter('../../img/whatsapp.png','../../img/face.png','../../img/insta.png','../../img/tw.png');
        ?>
    </footer>
</body>
</html>