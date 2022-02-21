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
    <script type="text/javascript" src="../../js/app3.js" defer></script>
    <title>Insertar noticia | Safari</title>
</head>
<body>
    <header>
        <?php
            require_once("../funciones.php");
            echo mostrarCabecera("Insertar noticia","../paginas/noticias.php","../../img/huella.png");
        ?>
    </header>
    <main>

    <div id="contenedor">
            <div id="contenedor_inser_pro">
                <form id="formu" action="#" method="post" enctype="multipart/form-data">
                    <span>
                        <label>ID</label>
                        <?php
                            $conex = conectarServidor();
                            $sacar_id=$conex->query("select auto_increment
                                                    from information_schema.TABLES
                                                    where TABLE_SCHEMA='veterinaria'
                                                    and TABLE_NAME='noticia'");
                            while($fila = $sacar_id->fetch_array(MYSQLI_ASSOC)){
                                $id=$fila["auto_increment"];
                                echo "<input id='id_noti' type='text' placeholder='$id' readonly>";
                            }
                        ?>
                    </span>
                    <br>
                    <span>
                        <label>Título</label>
                        <input id="titulo" type="text" name="titulo">
                    </span>
                    <br>
                    <span>
                        <label>Fecha de publicación</label>
                        <input id="fecha" type="date" name="fecha">
                    </span> 
                    <br>
                    <span>
                        <label>Contenido</label>
                        <br>
                        <textarea id='contenido' name="contenido"cols="30" rows="10">
                        </textarea>
                    </span> 
                    <br>
                    <span>
                        <label>Insertar imagen</label>
                        <br><br>
                        <input id='imagen' type="text" name="imagen">
                    </span> 
                    <br>
                    <input type="submit" id="enviar_nueva_noticia" name="enviar">
                </form>
            </div>
            <div id="res">
            </div>
        </div>

    </main>
</body>
</html>