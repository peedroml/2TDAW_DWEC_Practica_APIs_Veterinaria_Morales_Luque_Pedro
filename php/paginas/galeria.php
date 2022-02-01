<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300&display=swap" rel="stylesheet">
    <link rel="icon" href="../../img/favicon.png" type="image/png" />
    <link rel="stylesheet" href="../../css/styles.css">
    <script type="text/javascript" src="../../js/names.js"></script>
    <script type="text/javascript" src="../../js/app.js" defer></script>
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
            echo mostrarNavUser("../../index.php", "mis_mascotas.php", "mis_datos.php", "mis_citas.php", "productos.php", "servicios.php", "galeria.php");

            if (isset($_POST["cerrar_sesion"])) {
                setcookie("como_usuario", null, -3, "/");
                header("location:../../index.php");
            }
        } elseif (isset($_COOKIE["como_admin"])) {
            echo mostrarNavAdmin("../../index.php", "clientes.php", "productos.php", "servicios.php", "testimonios.php", "noticias.php", "citas.php", "dueños.php", "galeria.php");

            if (isset($_POST["cerrar_sesion"])) {
                setcookie("como_admin", null, -3, "/");
                header("location:../../index.php");
            }
        } else {
            echo mostrarNavSin("../../index.php", "productos.php", "servicios.php", "login.php", "galeria.php");
        }
        ?>
    </header>

    <main>
        <div id="contenedor">
            <div class="insertar_datos">
                <h2>¡ ÚLTIMAS FOTOS DE NUESTROS CLIENTES !</h2>
            </div>
        </div>
        <div  id="contenedorGaleria">
            <div class="bordes-galeria rounded-pill">
            </div>
        </div>
    </main>
</body>

</html>