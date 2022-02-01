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
    <title>Modificar producto | Safari</title>
</head>
<body>
    <header>
        <?php
            require_once("../funciones.php");
            echo mostrarCabecera("Modificar producto","../paginas/productos.php","../../img/huella.png");
        ?>
    </header>
    <main>
        <div id="contenedor">
            <div id="contenedor_inser_pro">
                <?php
                    $conex = conectarServidor();

                    if(isset($_POST["id_producto"])){
                        $identificador=$_POST["id_producto"];
                        $consulta = $conex->query("select *
                                                from producto
                                                where id=$identificador");

                        while($fila = $consulta->fetch_array(MYSQLI_ASSOC)){
                            echo "<form action='#' method='post'>
                                    <span>
                                        <label>Nombre</label>
                                        <input type='text' name='n_producto' value=$fila[nombre]>
                                    </span>
                                    <br>
                                    <span>
                                        <label>Nombre</label>
                                        <input type='text' name='p_producto' value=$fila[precio]>
                                    </span>
                                    <br>
                                    <input type='submit' name='enviarModificacionPro' value='Modificar'>
                                    <input type='hidden' name='iden_pro' value='$identificador'>
                                </form>";
                        }
                    }
                    
                    


                    if(isset($_POST["enviarModificacionPro"])){

                        $nombre_producto=$_POST["n_producto"];
                        $p_producto=$_POST["p_producto"];
                        $iden=$_POST["iden_pro"];

                        if($p_producto<=0 || $p_producto===""){
                            echo "⇾ El precio no puede ser negativo o no puede estar vacio ⇽";
                        }else{
                            if($nombre_producto===""){
                                echo "⇾ El campo ' Nombre ' no puede estar vacio ⇽";
                            }else{
                                $sentencia = "update producto
                                              set nombre=?,precio=?
                                              where id=?";

                                $consulta = $conex->prepare($sentencia);
                                $consulta->bind_param("sdi",$nombre_producto,$p_producto,$iden);
                                $consulta->execute();

                                if($conex->affected_rows===0){
                                    echo "⇾ Fallo al modificar datos ⇽";
                                }else{
                                    echo "⇾ Datos modificados de forma correcta ⇽";
                                }
                            }
                        }
                        

                    }
                    
                    $conex->close();
                ?>
            </div>
        </div>
    </main>
</body>
</html>