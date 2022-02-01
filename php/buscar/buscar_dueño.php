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
    <title>Buscar dueño | Safari</title>
</head>
<body>
    <header>
        <?php
            require_once("../funciones.php");
            echo mostrarCabecera("Buscar dueño","../paginas/dueños.php","../../img/huella.png");
        ?>
    </header>
    <main>
        <div id="contenedor">
            <div id="contenedor_inser_pro">
                <form action="#" method="post">
                    <label>Buscar por nombre, nick o teléfono del dueño</label>
                    <br><br>
                    <input type="text" name="busqueda">
                    <br><br>
                    <input type="submit" name="enviar">
                </form>
            </div>
            <div id="resultadoBusq">
                <?php
                    if(isset($_POST["enviar"])){
                        $conex = conectarServidor();
                        $busqueda = $_POST["busqueda"];
                        $out="";
                        $sentencia="select dni,telefono,nombre,nick
                                    from dueño
                                    where nombre=? or nick=? or telefono=?";
                        
                        $consulta = $conex->prepare($sentencia);
                        $consulta->bind_param("sss",$busqueda,$busqueda,$busqueda);
                        $consulta->bind_result($dni,$telefono,$nombre,$nick);
                        $consulta->execute();

                        while($consulta->fetch()){

                            if($telefono==0){
                                $reT = "No se ha insertado teléfono";
                            }else{
                                $reT = $telefono;
                            }

                            $out = $out . "<tr>
                                            <td>$dni</td>
                                            <td>$nombre</td>
                                            <td>$reT</td>
                                            <td>$nick</td>
                                           </tr>";
                        }

                        if($out===""){
                            echo "⇾ No hemos encontrado nada que se asemeje a su consulta ⇽";
                        }else{
                            $cabecera = "<table id='tablas_mostrar'>
                                            <tr id='cabecera_tabla'>
                                                <td>DNI</td>
                                                <td>Nombre</td>
                                                <td>Telefono</td>
                                                <td>Nick</td>
                                            </tr>";
                            
                            echo $cabecera . $out . "</table>";

                            $consulta->close();
                            $conex->close();
                        }
                    }
                ?>
            </div>
        </div>
    </main>
</body>
</html>