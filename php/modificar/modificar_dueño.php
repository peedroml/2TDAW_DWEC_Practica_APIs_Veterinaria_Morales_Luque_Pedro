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
    <title>Modificar dueño | Safari</title>
</head>
<body>
    <header>
        <?php
            require_once("../funciones.php");
            echo mostrarCabecera("Modificar dueño","../paginas/dueños.php","../../img/huella.png");
        ?>
    </header>
    <main>
        <div id="contenedor">
            <div id="contenedor_inser_pro">
                <?php
                    $conex = conectarServidor();

                    if(isset($_POST["dni_dueño"])){
                        $identificador=$_POST["dni_dueño"];
                        $consulta = $conex->query("select *
                                                from dueño
                                                where dni='$identificador'");

                        while($fila = $consulta->fetch_array(MYSQLI_ASSOC)){

                            if($fila["telefono"]===null || $fila["telefono"]==0){
                                $campo_tele = "<span>
                                                    <label>Teléfono</label>
                                                    <input type='text' name='telefono' placeholder='Nuevo teléfono'>
                                               </span>";
                            }else{
                                $campo_tele = "<span>
                                                    <label>Teléfono</label>
                                                    <input type='text' name='telefono' value=$fila[telefono]>
                                               </span>";
                            }

                            echo "<form action='#' method='post'>
                                    <span>
                                        <label>DNI</label>
                                        <input type='text' name='nuevo_dni' value=$fila[dni]>
                                    </span>
                                    <br>
                                    <span>
                                        <label>Nombre</label>
                                        <input type='text' name='n_dueño' value=$fila[nombre]>
                                    </span>
                                    <br>
                                    $campo_tele
                                    <br>
                                    <span>
                                        <label>Nick</label>
                                        <input type='text' name='nick' value=$fila[nick]>
                                    </span>
                                    <br>
                                    <input type='submit' name='enviarModificacionDUE' value='Modificar'>
                                    <input type='hidden' name='iden_due' value='$identificador'>
                                </form>";
                        }
                    }
                    
                    if(isset($_POST["enviarModificacionDUE"])){

                        $dni=$_POST["nuevo_dni"];
                        $nombre=$_POST["n_dueño"];
                        $telefono=$_POST["telefono"];
                        $nick=$_POST["nick"];

                        if($dni===""){
                            echo "<div id='aviso'>
                                    ⇾ Debe de completar el campo ' DNI ' ⇽
                                  </div>";
                        }elseif($nombre===""){
                            echo "<div id='aviso'>
                                    ⇾ Debe de completar el campo ' Nombre ' ⇽
                                  </div>";
                        }elseif($nick===""){
                            echo "<div id='aviso'>
                                    ⇾ Debe de completar el campo ' Nick ' ⇽
                                  </div>";
                        }else{
                            $anti = $_POST["iden_due"];

                            if($telefono===0){
                                $telefono=null;
                            }

                            $sentencia = "update dueño
                                          set dni=?,nombre=?,telefono=?,nick=?
                                          where dni='$anti'";

                            $consulta = $conex->prepare($sentencia);
                            $consulta->bind_param("ssss",$dni,$nombre,$telefono,$nick);
                            $consulta->execute();

                            echo "<div id='aviso'>
                                    ⇾ Datos modificados correctamente ⇽
                                  </div>";

                        }

                    }
                    
                    $conex->close();
                ?>
            </div>
        </div>
    </main>
</body>
</html>