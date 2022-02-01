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
    <title>Clientes | Safari</title>
</head>
<body>

    <?php
        require_once("../funciones.php");
        echo mostrarCabecera("Clientes","../../index.php","../../img/huella.png");
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
                    <a href="../insertar/insertar_cli.php">Insertar cliente</a>
                </div>
                <div>
                    <a href="../buscar/buscar_cli.php">Buscar cliente</a>
                </div>
            </div>

            <div id="contenedor_clientes">
                <div>
                    <table id="tablas_mostrar">
                        <tr id="cabecera_tabla">
                            <td>Foto</td>
                            <td>Nombre</td>
                            <td>Tipo de animal</td>
                            <td>Edad</td>
                            <td>Nombre dueño</td>
                        </tr>
                        <?php
                            $conex = conectarServidor();

                            $mostrarCli = $conex->query("select id,tipo_animal,nombre_animal,edad,nombre_dueño,foto
                                                        from cliente");

                            while($fila = $mostrarCli->fetch_array(MYSQLI_ASSOC)){
                                echo "<tr>
                                        <td><img class='foto_animal' src='../../img/clientes/$fila[foto]'</td>
                                        <td>$fila[nombre_animal]</td>
                                        <td>$fila[tipo_animal]</td>
                                        <td>$fila[edad]</td>
                                        <td>$fila[nombre_dueño]</td>
                                        <td class='tdForm'>
                                            <form class='form_td' action='../modificar/modificar_cliente.php' method='post'>
                                                <input type='submit' name='enviar' value='Modificar datos'>
                                                <input type='hidden' name='id_cliente' value='$fila[id]'>
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