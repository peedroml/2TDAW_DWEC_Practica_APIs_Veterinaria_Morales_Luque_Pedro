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
    <title>Insertar servicio | Safari</title>
</head>
<body>

    <header>
        <?php
            require_once("../funciones.php");
            echo mostrarCabecera("Insertar servicio","../paginas/servicios.php","../../img/huella.png");
        ?>
    </header>
    <main>
        <div id="contenedor">
           <div id="contenedor_inser_ser">
               <form action="#" method="post">
                   <span>
                       <label>ID</label>
                       <?php
                        $conex = conectarServidor();
                        $sacar_id=$conex->query("select auto_increment
                                                 from information_schema.TABLES
                                                 where TABLE_SCHEMA='veterinaria'
                                                 and TABLE_NAME='servicio'");
                        while($fila = $sacar_id->fetch_array(MYSQLI_ASSOC)){
                            $id=$fila["auto_increment"];
                            echo "<input type='text' placeholder='$id' readonly>";
                        }
                    ?>
                   </span>
                   <br>
                   <span>
                       <label>Descripcion</label>
                       <input type="text" name="desc">
                   </span>
                   <br>
                   <span>
                       <label>Duracion</label>
                       <input type="number" name="duracion">
                   </span>
                   <br>
                   <span>
                       <label>Precio</label>
                       <input type="number" name="precio">
                   </span>
                   <br>
                   <input type="submit" name="enviar">
               </form>
           </div>
           <div id="res">
               <?php
                    if(isset($_POST["enviar"])){
                        $desc = $_POST["desc"];
                        $duracion = $_POST["duracion"];
                        $precio = $_POST["precio"];

                        if($desc===""){
                            echo "⇾ El campo ' Descripcion ' no puede estar vacio ⇽";
                        }else{
                            if($duracion<=0 || $duracion===""){
                                echo "⇾ La duracion no puede ser negativa o no puede estar vacio ⇽";
                            }else{
                                if($precio<=0 || $precio===""){
                                    echo "⇾ El precio no puede ser negativo o no puede estar vacio ⇽";
                                }else{
                                    $sentencia = "insert into servicio values(null,?,?,?)";
                                    $consulta = $conex->prepare($sentencia);
                                    $consulta->bind_param("sii",$desc,$duracion,$precio);
                                    $consulta->execute();

                                    if($conex->affected_rows===0){
                                        echo "⇾ Datos introducidos de forma erronea ⇽";
                                    }else{
                                        echo "⇾ Datos introducidos correctamente ⇽";
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