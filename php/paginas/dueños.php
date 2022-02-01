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
    <title>Dueños | Safari</title>
</head>
<body>

    <?php
        require_once("../funciones.php");
        echo mostrarCabecera("Dueños","../../index.php","../../img/huella.png");
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
                    <a href="../insertar/insertar_dueño.php">Insertar dueño</a>
                </div>
                <div>
                    <a href="../buscar/buscar_dueño.php">Buscar dueño</a>
                </div>
            </div>

            <div id="contenedor_clientes">
                <div>
                    <table id="tablas_mostrar">
                        <tr id="cabecera_tabla">
                            <td>DNI</td>
                            <td>Nombre</td>
                            <td>Teléfono</td>
                            <td>Nick</td>
                        </tr>
                        <?php
                            $conex = conectarServidor();
                            $consulta = $conex->query("select * from dueño");

                            while($fila = $consulta->fetch_array(MYSQLI_ASSOC)){

                                if($fila["telefono"]===null || $fila["telefono"]==0){
                                    $tele = "No se ha insertado teléfono";
                                }else{
                                    $tele = $fila["telefono"];
                                }

                                echo "<tr>
                                        <td>$fila[dni]</td>
                                        <td>$fila[nombre]</td>
                                        <td>$tele</td>
                                        <td>$fila[nick]</td>
                                        <td class='tdForm'>
                                            <form action='../modificar/modificar_dueño.php' method='post'>
                                                <input type='submit' name='enviar' value='Modificar'>
                                                <input type='hidden' name='dni_dueño' value='$fila[dni]'>
                                            </form>
                                        </td>
                                      </tr>";
                            }
                            $conex->close();
                        ?>
                    </table>
                </div>
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