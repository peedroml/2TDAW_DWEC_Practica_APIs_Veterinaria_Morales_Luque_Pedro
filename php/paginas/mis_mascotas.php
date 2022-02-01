<?php
    session_start();

    if(!isset($_COOKIE["como_usuario"])){
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
    <title>Mis mascotas | Safari</title>
</head>
<body>

    <?php
        require_once("../funciones.php");
        echo mostrarCabecera("Mis mascotas","../../index.php","../../img/huella.png");
    ?>

    <header>
        <?php
            if(isset($_COOKIE["como_usuario"])){
                echo mostrarNavUser("../../index.php","mis_mascotas.php","mis_datos.php","mis_citas.php","productos.php","servicios.php");

                if(isset($_POST["cerrar_sesion"])){
                    setcookie("como_usuario",null,-3,"/");
                    header("location:../../index.php");
                }

            }
        ?>
    </header>
    
    <main>
    <div id="contenedor_clientes">
                <div>
                    <table id="tablas_mostrar">
                        <tr id="cabecera_tabla">
                            <td>Foto</td>
                            <td>Nombre</td>
                            <td>Tipo de animal</td>
                            <td>Edad</td>
                        </tr>
                        <?php
                            session_decode($_COOKIE["como_usuario"]);
                            
                            $conex = conectarServidor();

                            $find = $conex->query("select nombre
                                                   from dueño
                                                   where nick='$_SESSION[nick]'");

                            while($fila = $find->fetch_array(MYSQLI_ASSOC)){
                                $mostrarCli = $conex->query("select id,tipo_animal,nombre_animal,edad,nombre_dueño,foto
                                                        from cliente
                                                        where nombre_dueño='$fila[nombre]'");

                                while($fila2 = $mostrarCli->fetch_array(MYSQLI_ASSOC)){
                                    echo "<tr>
                                            <td><img class='foto_animal' src='../../img/clientes/$fila2[foto]'</td>
                                            <td>$fila2[nombre_animal]</td>
                                            <td>$fila2[tipo_animal]</td>
                                            <td>$fila2[edad]</td>
                                        </tr>";
                                }
                            }

                            $conex->close();
                        ?>
                    </table>
                </div>
    </main>
    <footer>
        <?php
            echo mostrarFooter('../../img/whatsapp.png','../../img/face.png','../../img/insta.png','../../img/tw.png');
        ?>
    </footer>
</body>
</html>