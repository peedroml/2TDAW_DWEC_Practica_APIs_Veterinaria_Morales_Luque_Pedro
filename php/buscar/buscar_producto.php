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
    <title>Buscar producto | Safari</title>
</head>
<body>
    <header>
        <?php
            require_once("../funciones.php");
            echo mostrarCabecera("Buscar producto","../paginas/productos.php","../../img/huella.png");
        ?>
    </header>
    <main>
        <div id="contenedor">
            <div id="contenedor_inser_pro">
                <form action="#" method="post">
                    <label>Introduce el nombre del producto o el precio</label>
                    <br><br>
                    <input type="text" name="busqueda">
                    <br><br>
                    <input type="submit" name="enviar">
                </form>
            </div>
            <div id="resultadoBusq">
                
                <?php
                    if(isset($_POST["enviar"])){
                        $conexion = conectarServidor();
                        $busqueda = $_POST["busqueda"];
                        $out="";

                        //Comprobar si los datos introducidos por el usuario es un numero decimal
                        if(is_numeric($busqueda)){
                            $busqueda=doubleval($busqueda);
                        }
                        
                        $sentencia = "select nombre,precio
                                      from producto
                                      where nombre=?
                                      or precio=?";
                        
                        $consulta = $conexion->prepare($sentencia);
                        $consulta->bind_param("sd",$busqueda,$busqueda);
                        $consulta->bind_result($nombre,$precio);
                        $consulta->execute();

                        while($consulta->fetch()){
                            $out = $out . "<tr>
                                             <td>$nombre</td>
                                             <td>$precio €</td>
                                           </tr>";
                        }
                        
                        if($out===""){
                            echo "⇾ No hemos encontrado nada que se asemeje a su consulta ⇽";
                        }else{
                            $cabecera = "<table id='tablas_mostrar'>
                                            <tr id='cabecera_tabla'>
                                                <td>Nombre</td>
                                                <td>Precio</td>
                                            </tr>";
                            
                            echo $cabecera . $out . "</table>";
                        }
                            
                        $consulta->close();
                        $conexion->close();
                    }
                ?>
            </div>
        </div>
    </main>
</body>
</html>