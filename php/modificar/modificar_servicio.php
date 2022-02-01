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
    <title>Modificar servicio | Safari</title>
</head>
<body>
    <header>
        <?php
            require_once("../funciones.php");
            echo mostrarCabecera("Modificar servicio","../paginas/servicios.php","../../img/huella.png");
        ?>
    </header>
    <main>
        <div id="contenedor">
            <div id="contenedor_inser_pro">
                <?php
                    $conex = conectarServidor();
                    if(isset($_POST["id_servicio"])){
                        $identificador=$_POST["id_servicio"];

                        $consulta = $conex->query("select *
                                                   from servicio
                                                   where codigo=$identificador");

                        while($fila = $consulta->fetch_array(MYSQLI_ASSOC)){
                            echo "<form action='#' method='post'>
                                    <span>
                                        <label>Nombre del servicio</label>
                                        <input type='text' name='n_servicio' value=$fila[descripcion]>
                                    </span>
                                    <br>
                                    <span>
                                        <label>Duración</label>
                                        <input type='text' name='d_servicio' value=$fila[duracion]>
                                    </span>
                                    <br>
                                    <span>
                                        <label>Precio</label>
                                        <input type='text' name='p_servicio' value=$fila[precio]>
                                    </span>
                                    <br>
                                    <input type='submit' name='enviarModificacionSer' value='Modificar'>
                                    <input type='hidden' name='ide_ser' value='$identificador'>
                                </form>";
                        }
                    }
                    

                    if(isset($_POST["enviarModificacionSer"])){
                        
                        $n_servicio=$_POST["n_servicio"];
                        $duracion=$_POST["d_servicio"];
                        $precio=$_POST["p_servicio"];
                        $identificador=$_POST["ide_ser"];

                        if($n_servicio===""){
                            echo "⇾ El campo ' Nombre del servicio ' no puede estar vacio ⇽";
                        }else{
                            if($duracion<=0 || $duracion===""){
                                echo "⇾ La duracion del servicio no puede ser negativa o no puede estar vacio ⇽";
                            }else{
                                if($precio<=0 || $precio===""){
                                    echo "⇾ El precio del servicio no puede ser negativo o no puede estar vacio ⇽";
                                }else{
                                    $sentencia = "update servicio
                                                  set descripcion=?,duracion=?,precio=?
                                                  where codigo=?";

                                    $consulta = $conex->prepare($sentencia);
                                    $consulta->bind_param("sidi",$n_servicio,$duracion,$precio,$identificador);
                                    $consulta->execute();

                                    if($conex->affected_rows===0){
                                        echo "⇾ Datos modificados de forma erronea ⇽";
                                    }else{
                                        echo "⇾ Datos modificados correctamente ⇽";
                                    }

                                    $consulta->close();
                                    $conex->close();
                                }
                            }
                        }

                    }
                    
                    
                ?>
            </div>
        </div>
    </main>
</body>
</html>