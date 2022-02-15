<?php
    session_start();
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
    <title>Servicios | Safari</title>
</head>
<body>

    <?php
        require_once("../funciones.php");
        echo mostrarCabecera("Servicios","../../index.php","../../img/huella.png");
    ?>
    
    <header>
        <?php
            if(isset($_COOKIE["como_usuario"])){
                echo mostrarNavUser("../../index.php","mis_mascotas.php","mis_datos.php","mis_citas.php","productos.php","servicios.php","galeria.php","noticias.php");

                if(isset($_POST["cerrar_sesion"])){
                    setcookie("como_usuario",null,-3,"/");
                    header("location:../../index.php");
                }

            }elseif(isset($_COOKIE["como_admin"])){
                echo mostrarNavAdmin("../../index.php","clientes.php","productos.php","servicios.php","testimonios.php","noticias.php","citas.php","dueños.php","galeria.php");

                if(isset($_POST["cerrar_sesion"])){
                    setcookie("como_admin",null,-3,"/");
                    header("location:../../index.php");
                }

            }else{
                echo mostrarNavSin("../../index.php","productos.php","servicios.php","login.php","galeria.php");
            }
        ?>
    </header>
    <main>
        <div id="contenedor">
            <div class="insertar_datos">
                <?php
                    if(isset($_COOKIE["como_admin"])){
                        echo "<div>
                                <a href='../insertar/insertar_servicio.php'>Insertar servicio</a>
                              </div>";
                    }
                ?>
                <div>
                    <a href="../buscar/buscar_servicio.php">Buscar servicio</a>
                </div>
            </div>
        </div>
        <di id="contenedorSer">
            <table id="tablas_mostrar">
                <tr id="cabecera_tabla">
                    <td>Nombre del servicio</td>
                    <td>Duración</td>
                    <td>Precio</td>
                </tr>
                <?php
                    $conexion = conectarServidor();
                    $mostrarSer=$conexion->query("select *
                                                  from servicio
                                                  order by duracion asc");
                    
                    if(isset($_COOKIE["como_admin"])){
                        while($fila = $mostrarSer->fetch_array(MYSQLI_ASSOC)){
                            echo "<tr>
                                    <td>$fila[descripcion]</td>
                                    <td>$fila[duracion] minutos</td>
                                    <td>$fila[precio] €</td>
                                    <td class='tdForm'>
                                        <form class='form' action='../modificar/modificar_servicio.php' method='post'>
                                            <input type='submit' name='enviar' value='Modificar'>
                                            <input type='hidden' name='id_servicio' value='$fila[codigo]'>
                                        </form>
                                    </td>
                                  </tr>";
                        } 
                    }else{
                        while($fila = $mostrarSer->fetch_array(MYSQLI_ASSOC)){
                            echo "<tr>
                                    <td>$fila[descripcion]</td>
                                    <td>$fila[duracion] minutos</td>
                                    <td>$fila[precio] €</td>
                                  </tr>";
                        } 
                    }
                    
                                                                     
                    $conexion->close();
                ?>
            </table>
        </di>
    </main>
    <footer>
        <?php
            echo mostrarFooter('../../img/whatsapp.png','../../img/face.png','../../img/insta.png','../../img/tw.png');
        ?>
    </footer>
</body>
</html>