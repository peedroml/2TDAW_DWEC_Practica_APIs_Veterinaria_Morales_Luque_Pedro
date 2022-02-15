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
                <form action="#" method="post" enctype="multipart/form-data">
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
                        <input id='imagen' type="file" name="imagen">
                    </span> 
                    <br>
                    <input type="submit" id="enviar_nueva_noticia" name="enviar">
                </form>
            </div>
            <div id="res">
                <?php
                    if(isset($_POST["enviar"])){
                        $titulo = $_POST["titulo"];
                        $fecha = $_POST["fecha"];
                        $contenido = $_POST["contenido"];
                        $tipo_fichero = $_FILES["imagen"]["type"];
                        $ruta_temp = $_FILES["imagen"]["tmp_name"];

                        if($tipo_fichero==="image/jpeg" || $tipo_fichero==="image/png"){
                            if($titulo!==""){
                                if($fecha!==""){
                                    $contenido = ltrim($contenido);
                                    $longitud = strlen($contenido);
                                    if($longitud===0 || $longitud>500){
                                        echo "<div id='aviso'>
                                                ⇾ El campo ' Contenido ' no puede estar vacio o no puede superar los 500 caracteres⇽
                                              </div>";
                                    }else{
                                        $consulta_id = $conex->query("select auto_increment
                                                                      from information_schema.TABLES
                                                                      where TABLE_SCHEMA='veterinaria'
                                                                      and TABLE_NAME='noticia'");
                                        
                                        while($fila = $consulta_id->fetch_array(MYSQLI_ASSOC)){
                                            $id = $fila["auto_increment"];
                                        }

                                        switch($tipo_fichero){
                                            case "image/png":
                                                $nombre_archivo="noticia_$id.png";
                                                break;
                                            case "image/jpeg":
                                                $nombre_archivo="noticia_$id.jpeg";
                                                break;
                                        }

                                        if(!file_exists("../../img/noticias")){
                                            mkdir("../../img/noticias");
                                        }

                                        $ruta = "../../img/noticias/$nombre_archivo";
                                        move_uploaded_file($ruta_temp,$ruta);

                                        $sentencia = "insert into noticia values(null,?,?,?,?)";
                                        $consulta = $conex->prepare($sentencia);
                                        $consulta->bind_param("ssss",$titulo,$contenido,$nombre_archivo,$fecha);
                                        $consulta->execute();
                                        echo "<div id='aviso'>
                                                ⇾ Datos insertados correctamente ⇽
                                              </div>";

                                        $conex->close();
                                    }
                                }else{
                                    echo "<div id='aviso'>
                                            ⇾ Debe de completar el campo ' Fecha de publicacion ' ⇽
                                          </div>";
                                }
                            }else{
                                echo "<div id='aviso'>
                                        ⇾ Debe de completar el campo ' Titulo ' ⇽
                                      </div>";
                            }
                        }else{
                            echo "<div id='aviso'>
                                    ⇾ La imagen tiene que ser png o jpg ⇽
                                  </div>";
                        }
                    }
                ?>
            </div>
        </div>

    </main>
</body>
</html>