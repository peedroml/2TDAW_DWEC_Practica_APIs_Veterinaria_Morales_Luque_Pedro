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
    <title>Insertar dueño | Safari</title>
</head>
<body>
    <header>
        <?php
            require_once("../funciones.php");
            echo mostrarCabecera("Insertar dueño","../paginas/dueños.php","../../img/huella.png");
        ?>
    </header>
    <main>

    <div id="contenedor">
            <div id="contenedor_inser_pro">
                <form action="#" method="post" enctype="multipart/form-data">
                    <span>
                        <label>DNI</label>
                        <input type="text" name="dni">
                    </span>
                    <br>
                    <span>
                        <label>Nombre usuario</label>
                        <input type="text" name="nombre">
                    </span>
                    <br>
                    <span>
                        <label>Teléfono (Opcional)</label>
                        <input type="number" name="telefono">
                    </span>
                    <br>
                    <span>
                        <label>Nick</label>
                        <input type="text" name="nick">
                    </span>
                    <br>
                    <span>
                        <label>Contraseña</label>
                        <input type="text" name="pass">
                    </span>
                    <br>
                    <input type="submit" name="enviar">
                </form>
            </div>
            <div id="res">
                <?php
                    if(isset($_POST["enviar"])){
                        $dni = $_POST["dni"];
                        $nombre = $_POST["nombre"];
                        $telefono = $_POST["telefono"];
                        $nick = $_POST["nick"];
                        $pass = $_POST["pass"];

                        if($telefono===""){
                            $telefono=null;
                        }

                        if($dni!==""){
                            if($nombre!==""){
                                if($nick!==""){
                                    if($pass!==""){
                                        $pass = md5($pass);

                                        $conex = conectarServidor();

                                        $sentencia = $conex->prepare("insert into dueño values(?,?,?,?,?)");
                                        $sentencia->bind_param("sssss",$dni,$nombre,$telefono,$nick,$pass);
                                        $sentencia->execute();

                                        echo "<div id='succes'>
                                                ⇾ Dueño insertado correctamente ⇽
                                              </div>";

                                        $sentencia->close();
                                        $conex->close();
                                    }else{
                                        echo "<div id='error'>
                                            ⇾ Tiene que completar el campo ' Contraseña ' ⇽
                                        </div>";
                                    }
                                }else{
                                    echo "<div id='error'>
                                            ⇾ Tiene que completar el campo ' Nick ' ⇽
                                          </div>";
                                }
                            }else{
                                echo "<div id='error'>
                                        ⇾ Tiene que completar el campo ' Nombre usuario ' ⇽
                                    </div>";
                            }
                        }else{
                            echo "<div id='error'>
                                    ⇾ Tiene que completar el campo ' DNI ' ⇽
                                  </div>";
                        }
                    }
                ?>
            </div>
        </div>

    </main>
</body>
</html>