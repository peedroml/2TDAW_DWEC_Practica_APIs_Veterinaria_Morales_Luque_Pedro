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
    <title>Insertar testimonio | Safari</title>
</head>
<body>
    <header>
        <?php
            require_once("../funciones.php");
            echo mostrarCabecera("Insertar testimonio","../paginas/testimonios.php","../../img/huella.png");
        ?>
    </header>
    <main>
        <div id="contenedor">
            <div id="contenedor_inser_tes">
                <form action="#" method="post">
                    <span>
                        <label>ID</label>
                        <?php
                            $conex = conectarServidor();
                            $sacar_id=$conex->query("select auto_increment
                                                    from information_schema.TABLES
                                                    where TABLE_SCHEMA='veterinaria'
                                                    and TABLE_NAME='testimonio'");
                            while($fila = $sacar_id->fetch_array(MYSQLI_ASSOC)){
                                $id=$fila["auto_increment"];
                                echo "<input type='text' placeholder='$id' readonly>";
                            }
                        ?>
                    </span>
                    <br>
                    <span>
                        <label>Autor</label>
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
                        ?>
                    </select>
                    </span>
                    <br>
                    <span>
                        <label>Fecha de publicación</label>
                        <input type="date" name="fecha">
                    </span>
                    <br>
                    <span>
                        <label>Contenido</label>
                        <br>
                        <textarea name="contenido" cols="30" rows="10">
                        </textarea>
                    </span>
                    <br>
                    <input type="submit" name="enviar">
                </form>
            </div>
            <div id="res">
                <?php
                    if(isset($_POST["enviar"])){
                        $n_dueño=$_POST["n_dueño"];
                        $fecha=$_POST["fecha"];
                        $contenido=$_POST["contenido"];

                        if($n_dueño===""){
                            echo "⇾ El campo ' Autor ' no puede estar vacio ⇽";
                        }else{
                            if($fecha===""){
                                echo "⇾ El campo ' Fecha ' no puede estar vacio ⇽";
                            }else{
                                $contenido = ltrim($contenido);
                                $longitud = strlen($contenido);

                                if($longitud===0 || $longitud>80){
                                    echo "⇾ El campo ' Contenido ' no puede estar vacio o no puede superar los 80 caracteres ⇽";
                                }else{
                                    $sentencia = "insert into testimonio values(null,?,?,?)";
                                    $consulta = $conex->prepare($sentencia);
                                    $consulta->bind_param("sss",$n_dueño,$contenido,$fecha);
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