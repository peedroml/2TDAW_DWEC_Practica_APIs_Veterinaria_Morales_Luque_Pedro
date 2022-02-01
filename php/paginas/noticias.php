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
    <link rel="icon" href="../img/../favicon.png" type="image/png"/>
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
            <?php
                $conex = conectarServidor();
                $numero_noticias_pagina=3;
                $desde = 0;
                $pagina = 1;
                
                if(isset($_POST["anterior"])){

                    $desde_anterior = $_POST["desde_anterior"];
                    $pagina_anterior = $_POST["pagina_anterior"];
                    $desde = $desde_anterior;
                    $pagina = $pagina_anterior;
                }elseif(isset($_POST["siguiente"])){
                    $desde_siguiente = $_POST["desde_siguiente"];
                    $pagina_siguiente = $_POST["pagina_siguiente"];
                    $desde = $desde_siguiente;
                    $pagina = $pagina_siguiente;
                }
                
                //Sacar el numero de noticias
                $total = $conex->query("select * from noticia");
                $n = $conex->query("select count(id) from noticia");
                while($fila = $n->fetch_array(MYSQLI_NUM)){
                    $numero_noticias=$fila[0];
                }
                
                //Sacar el numero de paginas que hay
                $numero_paginas=ceil($numero_noticias/$numero_noticias_pagina);

                //Consulta para sacar datos
                $consultar_noticias = "select *
                                       from noticia
                                       limit $desde,$numero_noticias_pagina";

                $consulta = $conex->query($consultar_noticias);

                //Mostrar datos
                while($fila = $consulta->fetch_array(MYSQLI_ASSOC)){
                    $cadena = substr($fila["contenido"],0,105);
                    $fecha = explode("-",$fila["fecha_publicacion"]);
                    $dia = ltrim($fecha[2],"0");
                    $mes = mostrarMes($fecha[1]);

                    echo "<div>
                            <h3>$fila[titulo]</h3>
                            <p>$cadena ...</p>
                            <img src='../../img/noticias/$fila[imagen]'>
                            <p>$dia de $mes del $fecha[0]</p>
                            <form class='form_noticias' action='pagina_dinamica.php' method='post'>
                                <input type='hidden' name='id_noticia' value='$fila[id]'>
                                <input type='hidden' name='enlacePagina' value='noticias.php'>
                                <input type='submit' name='ver' value='Ver noticia completa'>
                              </form>
                          </div>
                          <br>";

                }

                echo "<div id='anterior-siguiente'>";

                //Controlar que ponga el input Anterior disabled cuando no hay mas paginas
                echo "<div>
                        <lablel>Página $pagina de $numero_paginas</lablel>
                      </div>";
                if($pagina>1){
                    $desde=$desde-3;
                    $pagina--;
                    echo "<form action='#' method='post'>
                            <input type='submit' name='anterior' value='Anterior'>
                            <input type='hidden' name='desde_anterior' value='$desde'>
                            <input type='hidden' name='pagina_anterior' value='$pagina'>
                          </form>";
                }else{
                    echo "<form action='#' method='post'>
                            <input type='submit' name='anterior' value='Anterior' disabled>
                          </form>";
                }
                
                //Controlar que ponga el input Siguiente disabled cuando no hay mas paginas
                if($pagina != $numero_paginas){
                    $desde=$desde+3;
                    $pagina++;
                    echo "<form action='#' method='post'>
                            <input type='submit' name='siguiente' value='Siguiente'>
                            <input type='hidden' name='desde_siguiente' value='$desde'> 
                            <input type='hidden' name='pagina_siguiente' value='$pagina'>
                          </form>";
                }else{
                    echo "<form action='#' method='post'>
                            <input type='submit' name='siguiente' value='Siguiente' disabled>
                          </form>";
                }

                echo "</div>";
                $conex->close();
            ?>
        </div>
    </main>
    <footer>
        <?php
            echo mostrarFooter('../../img/whatsapp.png','../../img/face.png','../../img/insta.png','../../img/tw.png');
        ?>
    </footer>
</body>
</html>