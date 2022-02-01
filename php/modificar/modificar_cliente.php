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
    <link type="text/css" rel="stylesheet" href="../../css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300&display=swap" rel="stylesheet">
    <link rel="icon" href="../../img/favicon.png" type="image/png"/>
    <title>Modificar cliente | Safari</title>
</head>
<body>
    <header>
        <?php
            require_once("../funciones.php");
            echo mostrarCabecera("Modificar cliente","../paginas/clientes.php","../../img/huella.png");
        ?>
    </header>
    <main>
        <div id="contenedor">
            <div id="contenedor_inser_pro">
                <?php
                    $conex = conectarServidor();
                    if(isset($_POST["id_cliente"])){
                        $id_animal = $_POST["id_cliente"];

                        $consulta = $conex->query("select telefono,contraseña,tipo_animal,nombre_animal,edad,nombre_dueño,foto
                                                from cliente
                                                where id=$id_animal");
                        
                        while($fila = $consulta->fetch_array(MYSQLI_ASSOC)){
                            
                            echo "<form id='formMoCli' action='#' method='post' enctype='multipart/form-data'>
                                    <span>
                                        <label>Nombre del animal</label>
                                        <input type='text' name='nombre_ani' value='$fila[nombre_animal]'>
                                    </span>
                                    <br>
                                    <span>
                                        <label>Tipo de animal</label>
                                        <input type='text' name='tipo_animal' value='$fila[tipo_animal]'>
                                    </span>
                                    <br>
                                    <span>
                                        <label>Edad del animal</label>
                                        <input type='number' name='edad_animal' value='$fila[edad]'>
                                    </span>
                                    <br>
                                    <span>
                                        <label>Nombre del dueño</label>
                                        <input type='text' name='nombre_dueño' value='$fila[nombre_dueño]'>
                                    </span>
                                    <br>
                                    <span>
                                        <label>Nueva contraseña</label>
                                        <input type='text' name='contra' value='$fila[contraseña]'>
                                    </span>
                                    <br>
                                    <span>
                                        <label>Telefono de contacto</label>
                                        <input type='text' name='tel' value='$fila[telefono]'>
                                    </span>
                                    <br>
                                    
                                    <img id='flotante' src='../../img/clientes/$fila[foto]'>
                                    <input type='hidden' name='nombre_foto_actual' value='$fila[foto]'>
                                    <br>
                                    <div>
                                        Insertar nueva foto de la mascota
                                    </div>
                                    <br>
                                    <input type='file' name='foto_animal'>
                                    <br><br>
                                    <input type='submit' name='enviarModificacionCli' value='Modificar'>
                                    <input type='hidden' name='den_cli' value='$id_animal'>
                                    <br>
                                </form>";
                        }
                    }
                    

                    if(isset($_POST["enviarModificacionCli"])){

                        $n_animal = $_POST["nombre_ani"];
                        $t_animal = $_POST["tipo_animal"];
                        $e_animal = $_POST["edad_animal"];
                        $n_dueño = $_POST["nombre_dueño"];
                        $contra = $_POST["contra"];
                        $tele = $_POST["tel"];
                        $identificador = $_POST["den_cli"];

                            if($n_animal!==""){
                                if($t_animal!==""){
                                    if($e_animal>0){
                                        if($n_dueño!==""){
                                            if($contra!==""){
                                                if($tele!==""){
                                                    $conex=conectarServidor();
                                                        
                                                    if(!is_uploaded_file($_FILES["foto_animal"]["tmp_name"])){

                                                        $nombre_foto_antigua=$_POST["nombre_foto_actual"];
                                                        
                                                        $sentencia = "update cliente
                                                                      set tipo_animal=?,nombre_animal=?,edad=?,nombre_dueño=?,contraseña=?,telefono=?,foto=?
                                                                      where id=?";
                                                        $consulta = $conex->prepare($sentencia);
                                                        $consulta->bind_param("ssissssi",$t_animal,$n_animal,$e_animal,$n_dueño,$contra,$tele,$nombre_foto_antigua,$identificador);
                                                        $consulta->execute();
                                                        echo "<div id='aviso'>
                                                                ⇾ Datos modificados satisfactoriamente⇽
                                                              </div>";
                                                        $consulta->close();
                                                        $conex->close();
                                                    }else{

                                                        $nombre_archivo = $_FILES["foto_animal"]["name"];
                                                        $tipo_fichero = $_FILES["foto_animal"]["type"];
                                                        $ruta_temp = $_FILES["foto_animal"]["tmp_name"];
                                                        $nombre_foto_antigua=$_POST["nombre_foto_actual"];

                                                        if($tipo_fichero==="image/jpeg" || $tipo_fichero==="image/png"){
                                                            
                                                            switch($tipo_fichero){
                                                                case "image/jpeg":
                                                                    $nombre_para_foto="animal_$identificador.jpg";
                                                                    break;
                                                                case "image/png":
                                                                    $nombre_para_foto="animal_$identificador.png";
                                                                    break;
                                                            }

                                                            unlink("../../img/clientes/$nombre_foto_antigua");

                                                            if(!file_exists("../../img/clientes")){
                                                                mkdir("../../img/clientes");
                                                            }
            
                                                            $ruta = "../../img/clientes/$nombre_para_foto";
                                                            move_uploaded_file($ruta_temp,$ruta);

                                                            $sentencia = "update cliente
                                                                          set tipo_animal=?,nombre_animal=?,edad=?,nombre_dueño=?,contraseña=?,telefono=?,foto=?
                                                                          where id=?";
                                                            $consulta = $conex->prepare($sentencia);
                                                            $consulta->bind_param("ssissssi",$t_animal,$n_animal,$e_animal,$n_dueño,$contra,$tele,$nombre_para_foto,$identificador);
                                                            $consulta->execute();

                                                            echo "<div id='aviso'>
                                                                    ⇾ Datos modificados satisfactoriamente⇽
                                                                </div>";

                                                            $consulta->close();
                                                            $conex->close();

                                                        }else{
                                                            echo "<div id='aviso'>
                                                                    ⇾ Debe insertar una imagen en el formato PNG o JPG ⇽
                                                                  </div>";
                                                        }
                                                    }

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
                    }
                ?>
            </div>
        </div>
    </main>
</body>
</html>