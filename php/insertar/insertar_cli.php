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
    <title>Insertar Cliente | Safari</title>
</head>
<body>
    <header>
        <?php
            require_once("../funciones.php");
            echo mostrarCabecera("Insertar cliente","../paginas/clientes.php","../../img/huella.png");
        ?>
    </header>

    <main>
        <div id="contenedor">
            <div id="formulario_insertar_cli">
                <form action="#" method="post" enctype="multipart/form-data">
                    <span>ID</span>
                    <?php
                        $conex=conectarServidor();
                        $consulta=$conex->query("select auto_increment
                                                 from information_schema.TABLES
                                                 where TABLE_SCHEMA='veterinaria'
                                                 and TABLE_NAME='cliente'");
                        while($fila = $consulta->fetch_array(MYSQLI_ASSOC)){
                            $id=$fila["auto_increment"];
                            echo "<input type='text' placeholder='$id' readonly>";
                        }
                        
                    ?>
                    <br><br>
                    <span>Nombre del animal</span>
                    <input type="text" name="nombre_ani">
                    <br><br>
                    <span>Tipo de animal</span>
                    <input type="text" name="tipo_animal">
                    <br><br>
                    <span>Edad del animal</span>
                    <input type="number" name="edad_animal">
                    <br><br>
                    <span>Nombre del dueño</span>
                    <select name='n_dueño'>
                        <option value="" selected>- Selecciona un dueño -</option>
                        <?php
                            $ver_cli = $conex->query("select nombre
                                                      from dueño");

                            while($fila = $ver_cli->fetch_array(MYSQLI_ASSOC)){
                                if($fila["nombre"]!="Administrador"){
                                    echo "<option value='$fila[nombre]'>$fila[nombre]</option>";
                                }
                            }

                            $conex->close();
                        ?>
                    </select>
                    <br><br>
                    <span>Nueva contraseña</span>
                    <input type="text" name="contra">
                    <br><br>
                    <span>Teléfono de contacto</span>
                    <input type="number" name="tel">
                    <br><br>
                    <div>Insertar foto de la mascota</div>
                    <input type="file" name="foto_animal">
                    <br><br>
                    <input type="submit" name="enviar">
                    <br><br>
                </form>
            </div>
            <?php
                if(isset($_POST["enviar"])){

                    $n_animal = $_POST["nombre_ani"];
                    $t_animal = $_POST["tipo_animal"];
                    $e_animal = $_POST["edad_animal"];
                    $n_dueño = $_POST["n_dueño"];
                    $contra = $_POST["contra"];
                    $tele = $_POST["tel"];
                    $tipo_fichero = $_FILES["foto_animal"]["type"];
                    $ruta_temp = $_FILES["foto_animal"]["tmp_name"];

                    
                    if($tipo_fichero==="image/jpeg" || $tipo_fichero==="image/png"){

                        if($n_animal!==""){

                            if($t_animal!==""){

                                if($e_animal>0){

                                    if($n_dueño!==""){

                                        if($contra!==""){

                                            if($tele!==""){

                                                $conex=conectarServidor();

                                                switch($tipo_fichero){
                                                    case "image/jpeg":
                                                        $nombre_para_foto="animal_$id.jpeg";
                                                        break;
                                                    case "image/png":
                                                        $nombre_para_foto="animal_$id.png";
                                                        break;
                                                }

                                                if(!file_exists("../../img/clientes")){
                                                    mkdir("../../img/clientes");
                                                };

                                                $ruta = "../../img/clientes/$nombre_para_foto";
                                                move_uploaded_file($ruta_temp,$ruta);

                                                $sen = ("insert into cliente values(null,?,?,?,?,?,?,?)");
                                                $consulta = $conex->prepare($sen);
                                                $consulta->bind_param("ssissss",$t_animal,$n_animal,$e_animal,$n_dueño,$contra,$tele,$nombre_para_foto);
                                                $consulta->execute();

                                                echo "<div id='aviso'>
                                                        ⇾ Datos insertados correctamente ⇽
                                                    </div>";

                                                $conex->close();

                                            }else{
                                                echo "<div id='aviso'>
                                                    ⇾ Debe de completar el campo ' Telefono de contacto ' ⇽
                                                </div>";
                                            }

                                        }else{
                                            echo "<div id='aviso'>
                                                ⇾ Debe de completar el campo ' Nueva contraseña ' ⇽
                                            </div>";
                                        }

                                    }else{
                                        echo "<div id='aviso'>
                                            ⇾ Debe de completar el campo ' Nombre del dueño ' ⇽
                                        </div>";
                                    }

                                }else{
                                    echo "<div id='aviso'>
                                     ⇾ Debe de completar el campo ' Edad del animal ' ⇽
                                    </div>";
                                }

                            }else{
                                echo "<div id='aviso'>
                                     ⇾ Debe de completar el campo ' Tipo de animal ' ⇽
                                  </div>";
                            }

                        }else{
                            echo "<div id='aviso'>
                                ⇾ Debe de completar el campo ' Nombre del animal ' ⇽
                              </div>";
                        }
                        
                    }else{
                        echo "<div id='aviso'>
                                ⇾ Debe insertar una imagen en el formato PNG o JPG ⇽
                              </div>";
                    }

                }

            ?>
        </div>
    </main>
</body>
</html>