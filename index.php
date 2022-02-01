<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link type="text/css" rel="stylesheet" href="css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300&display=swap" rel="stylesheet">
    <link rel="icon" href="img/favicon.png" type="image/png"/>
    <title>Inicio | Safari</title>
</head>
<body>

    <?php
        require_once("php/funciones.php");
        echo mostrarCabecera("Safari","index.php","img/huella.png");
    ?>
    
    <header>
        <?php
            if(isset($_COOKIE["como_usuario"])){
                echo mostrarNavUser("index.php","php/paginas/mis_mascotas.php","php/paginas/mis_datos.php","php/paginas/mis_citas.php","php/paginas/productos.php","php/paginas/servicios.php","php/paginas/galeria.php");

                if(isset($_POST["cerrar_sesion"])){
                    setcookie("como_usuario",null,-3,"/");
                    header("location:index.php");
                }

            }elseif(isset($_COOKIE["como_admin"])){
                echo mostrarNavAdmin("index.php","php/paginas/clientes.php","php/paginas/productos.php","php/paginas/servicios.php","php/paginas/testimonios.php","php/paginas/noticias.php","php/paginas/citas.php","php/paginas/dueños.php","php/paginas/galeria.php");
            
                if(isset($_POST["cerrar_sesion"])){
                    setcookie("como_admin",null,-3,"/");
                    header("location:index.php");
                }
            
            }else{
                echo mostrarNavSin("index.php","php/paginas/productos.php","php/paginas/servicios.php","php/paginas/login.php","php/paginas/galeria.php");
            }
        ?>
    </header>

    <main>

        <div id="fondo_aleatorio">
            <?php
                require_once("php/funciones.php");
                //Escoger un fondo aleatorio para el fondo
                $fotos = ["fondo_perro.jpg","foto_gato.jpg","foto_loro.jpg","foto_hamster.jpg"];
                $escoger_foto = random_int(0,count($fotos)-1);
                echo "<img id='foto_ale' src='img/$fotos[$escoger_foto]'>";
            ?>
        </div>

        <div id="contenedor">
            <div id="descripcion">
                <h2>¡Bienvenido a Safari!</h2>
                <div>
                    <div>
                        <div id="pregunta">
                            <img src="img/pregunta.png">
                            <p>¿Quiénes somos?</p>
                        </div>
                    </div>

                    <div id="ubi">
                        <img src="img/ubi.png">
                        <p>¿Donde estamos?</p>
                    </div>

                    <div id="ok">
                        <img src="img/ok.png">
                        <p>¿Cuál es nuestro compromiso?</p>
                    </div>
                </div>
            </div>

            <div id="ultimas_noticias">
                <h2>Noticias recientes</h2>
                <?php
                    $conexion = conectarServidor();
                    
                    $noticias_3 = $conexion->query("select titulo,contenido,imagen,id
                                                  from noticia
                                                  order by id desc
                                                  limit 3");

                    while($fila = $noticias_3->fetch_array(MYSQLI_ASSOC)){
                        $cadena = substr($fila["contenido"],0,105);
                        echo "<h4>$fila[titulo]</h4>
                              <p>$cadena ...</p>
                              <img class='imagenes_index_noticias' src='img/noticias/$fila[imagen]'><br>
                              <form class='form_noticias' action='php/paginas/pagina_dinamica.php' method='post'>
                                <input type='hidden' name='id_noticia' value='$fila[id]'>
                                <input type='hidden' name='enlacePagina' value='../../index.php'>
                                <input type='submit' name='ver' value='Ver noticia completa'>
                              </form>
                              <br>";
                    }

                    $conexion->close();
                ?>
            </div>
            <div id="testimonio_aleatorio">
                <h2>Testimonios recientes de nuestros clientes</h2>
                <?php
                    $conexion = conectarServidor();
                    //Ver cual es el valor maximo para despues hacer un numero aleatorio
                    $consul = $conexion->query("select max(id) from testimonio");
                    $n_datos = $consul->fetch_array(MYSQLI_NUM);

                    //Se obtiene un numero aleatorio
                    $n_random = random_int(1,$n_datos[0]); 

                    //Se hace la consulta y se muestra por pantalla
                    $consul2 = $conexion->query("select autor,contenido from testimonio where id=$n_random");
                    
                    foreach($consul2 as $x){
                        echo "<p id='contenido_test'>$x[contenido]</p>
                              -<em id='autor'> $x[autor] </em>-";
                    }
                ?>
            </div>
            <div id="contacto">
                <h2>Contacta con nosotros</h2>
                <form action="#" method="post">
                    <input type="text" name="nombre" placeholder="Nombre*">
                    <input type="text" name="apellidos" placeholder="Apellidos*">
                    <br><br>
                    <input type="email" name="email" placeholder="Email*">
                    <input type="number" name="numero" placeholder="Telefono">
                    <br><br>
                    <textarea placeholder="Consulta*"></textarea>
                    <br><br>
                    <input type="checkbox" value="publi" checked>Quiero recibir novedades de la veterinaria
                    <br><br>
                    <input type="checkbox" value="acepto">Acepto los términos y condiciones de privacidad
                    <br><br>
                    <input type="reset" name="enviar">
                    <input type="submit" name="reiniciar">
                </form>
            </div>
        </div>
    </main>

    <footer>
        <?php
            echo mostrarFooter('img/whatsapp.png','img/face.png','img/insta.png','img/tw.png');
        ?>
    </footer>
</body>
</html>