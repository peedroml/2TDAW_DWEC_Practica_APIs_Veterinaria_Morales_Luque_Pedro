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
    <title>Productos | Safari</title>
</head>
<body>
    <?php
        require_once("../funciones.php");
        echo mostrarCabecera("Productos","../../index.php","../../img/huella.png");
    ?>
    <header>
        <?php
            if(isset($_COOKIE["como_usuario"])){
                echo mostrarNavUser("../../index.php","mis_mascotas.php","mis_datos.php","mis_citas.php","productos.php","servicios.php","galeria.php");

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
                    if(!isset($_COOKIE["como_admin"])){
                        echo "<div>
                                <a href='../buscar/buscar_producto.php'>Buscar producto</a>
                              </div>";
                    }else{
                        echo "<div>
                                <a href='../borrar/borrar_producto.php'>Borrar producto</a>
                              </div>
                              <div>
                                <a href='../insertar/insertar_producto.php'>Insertar producto</a>
                              </div>
                              <div>
                                <a href='../buscar/buscar_producto.php'>Buscar producto</a>
                              </div>";
                    }
                ?>
            </div>
            <div id="contenedorPro">
                <table id="tablas_mostrar">
                    <tr id="cabecera_tabla">
                        <td>Nombre</td>
                        <td>Precio</td>
                    </tr>

                    <?php

                        $conexion = conectarServidor();

                        $mostrarPro = $conexion->query("select id,nombre,precio
                                                        from producto
                                                        order by precio asc");
                        
                        if(isset($_COOKIE["como_admin"])){
                            while($fila = $mostrarPro->fetch_array(MYSQLI_ASSOC)){
                                echo "<tr>
                                        <td>$fila[nombre]</td>
                                        <td>$fila[precio] €</td>
                                        <td class='tdForm'>
                                            <form class='form' action='../modificar/modificar_producto.php' method='post'>
                                                <input type='submit' name='enviar' value='Modificar'>
                                                <input type='hidden' name='id_producto' value='$fila[id]'>
                                            </form>
                                        </td>
                                      </tr>";
                            }
                        }else{
                            while($fila = $mostrarPro->fetch_array(MYSQLI_ASSOC)){
                                echo "<tr>
                                        <td>$fila[nombre]</td>
                                        <td>$fila[precio] €</td>
                                      </tr>";
                            }
                        }

                        $conexion->close();
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