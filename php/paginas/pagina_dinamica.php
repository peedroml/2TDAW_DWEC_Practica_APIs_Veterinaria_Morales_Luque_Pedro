<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="../../css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300&display=swap" rel="stylesheet">
    <link rel="icon" href="../../img/favicon.png" type="image/png"/>
    <title>Noticia | Safari</title>
</head>
<body>
    <header>
        <?php
            require_once("../funciones.php");
            $enlace = $_POST["enlacePagina"];
            echo mostrarCabecera("Noticia",$enlace,"../../img/huella.png");
        ?>
    </header>
    <main>
        <div id="contenedor">
            <?php
                $conex = conectarServidor();
                $id = $_POST['id_noticia'];
                
                $consulta = $conex->query("select titulo,contenido,imagen
                                              from noticia
                                              where id=$id");
                
                while($fila = $consulta->fetch_array(MYSQLI_ASSOC)){
                    echo "<div id='contenedor_noti'>
                            <h2>$fila[titulo]</h2>
                            <div id='noticia_grande'>
                                <p>$fila[contenido]</p>
                                <img src='../../img/noticias/$fila[imagen]'
                            </div>
                          </div>";
                }

                                    

                $conex->close();
            ?>
        </div>
    </main>
</body>
</html>