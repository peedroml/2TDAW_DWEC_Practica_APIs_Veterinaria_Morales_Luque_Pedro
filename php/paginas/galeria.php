<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300&display=swap" rel="stylesheet">
    <link rel="icon" href="../../img/favicon.png" type="image/png" />
    <link rel="stylesheet" href="../../css/styles.css">
    <title>Galería | Safari</title>
</head>

<body>
    <?php
    require_once("../funciones.php");
    echo mostrarCabecera("Galería", "../../index.php", "../../img/huella.png");
    ?>

    <header>
        <?php
        if (isset($_COOKIE["como_usuario"])) {
            echo mostrarNavUser("../../index.php", "mis_mascotas.php", "mis_datos.php", "mis_citas.php", "productos.php", "servicios.php","galeria.php");

            if (isset($_POST["cerrar_sesion"])) {
                setcookie("como_usuario", null, -3, "/");
                header("location:../../index.php");
            }
        } elseif (isset($_COOKIE["como_admin"])) {
            echo mostrarNavAdmin("../../index.php", "clientes.php", "productos.php", "servicios.php", "testimonios.php", "noticias.php", "citas.php", "dueños.php","galeria.php");

            if (isset($_POST["cerrar_sesion"])) {
                setcookie("como_admin", null, -3, "/");
                header("location:../../index.php");
            }
        } else {
            echo mostrarNavSin("../../index.php", "productos.php", "servicios.php", "login.php","galeria.php");
        }
        ?>
    </header>
</body>

</html>