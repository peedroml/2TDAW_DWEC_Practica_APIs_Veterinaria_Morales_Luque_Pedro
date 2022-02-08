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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="icon" href="../../img/favicon.png" type="image/png"/>
    <script type="text/javascript" src="../../js/app2.js" defer></script>
    <link rel="stylesheet" href="../../css/styles.css">
    <title>Noticias | Safari</title>
</head>
<body>

    <?php
        require_once("../funciones.php");
        echo mostrarCabecera("Noticias","../../index.php","../../img/huella.png");
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
                    <a href="../insertar/insertar_noticia.php">Insertar nueva noticia</a>
                </div>
            </div>
        </div>
        <div id="contenedorNot">
        </div>
    </main>
    <footer>
        <?php
            echo mostrarFooter('../../img/whatsapp.png','../../img/face.png','../../img/insta.png','../../img/tw.png');
        ?>
    </footer>
</body>
</html>