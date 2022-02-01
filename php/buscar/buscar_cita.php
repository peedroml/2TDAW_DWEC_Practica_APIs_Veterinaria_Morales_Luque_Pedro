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
    <title>Buscar cita | Safari</title>
</head>
<body>
    <header>
        <?php
            require_once("../funciones.php");
            echo mostrarCabecera("Buscar cita","../paginas/citas.php","../../img/huella.png");
        ?>
    </header>
    <main>
        <div id="contenedor">
            <div id="contenedor_inser_pro">
                <form action="#" method="post">
                    <label>Inserte nombre de mascota, nombre del servicio o fecha de la cita:</label>
                    <br><br>
                    <input type="text" name="busqueda" size="80">
                    <br><br>
                    <input type="submit" name="enviar">
                </form>
            </div>
            <div id="contenedor_borrar_cita">
                <?php
                    if(isset($_POST["enviar"])){
                        $busqueda = $_POST["busqueda"];
                        $conex = conectarServidor();
                        
                        //Validar si es una fecha
                        $x = explode("-",$busqueda);
                        if(count($x)===3 && checkdate($x[1],$x[0],$x[2])){
                            $mes_para_servidor=$x[1];
                            $dia_para_servidor=$x[0];

                            if($mes_para_servidor<10){$mes_para_servidor = "0".$x[1];}
                            if($dia_para_servidor<10){$dia_para_servidor = "0".$x[0];}
                            $fecha_para_servidor=$x[2]."-".$mes_para_servidor."-".$dia_para_servidor;

                            $general = $conex->query("select *
                                                      from citas
                                                      where fecha_cita='$fecha_para_servidor'");
                            
                            while($fila = $general->fetch_array(MYSQLI_ASSOC)){
                                $ver_cliente = $conex->query("select nombre_animal
                                                              from cliente
                                                              where id='$fila[codigo_mascota]'");
                        
                                $ver_servicio = $conex->query("select descripcion
                                                               from servicio
                                                               where codigo='$fila[codigo_servicio]'");

                                $resultado_ver_cliente = $ver_cliente->fetch_array(MYSQLI_NUM);
                                $resultado_ver_servicio = $ver_servicio->fetch_array(MYSQLI_NUM);

                                //Quitar la parte de los segundos de la hora
                                $hora = substr($fila["hora_cita"],0,-3);

                                //Sacar la fecha de una manera legible para el usuario
                                $fecha_legible = explode("-",$fila["fecha_cita"]);
                                $dia = ltrim($fecha_legible[2],"0");
                                $mes = mostrarMes($fecha_legible[1]);

                                echo "<div>
                                        <div><b>Cliente: </b>$resultado_ver_cliente[0]</div>
                                        <div><b>Servicio: </b>$resultado_ver_servicio[0]</div>
                                        <div><b>Fecha: </b>$dia de $mes del $fecha_legible[0]</div>
                                        <div><b>Hora: </b>$hora</div>
                                      </div>
                                      <br><br>";

                            }

                            $conex->close();

                        }elseif(is_string($busqueda)){
                            
                            $comprobar_cliente = "select id
                                                  from cliente
                                                  where nombre_animal=?";

                            $ejec1 = $conex->prepare($comprobar_cliente);
                            $ejec1->bind_param("s",$busqueda);
                            $ejec1->bind_result($r);
                            $ejec1->execute();
                            $ejec1->fetch();

                            if($r == 0){

                                $comprobar_servicio = "select codigo
                                                       from servicio
                                                       where descripcion=?";
                                
                                $ejec2 = $conex->prepare($comprobar_servicio);
                                $ejec2->bind_param("s",$busqueda);
                                $ejec2->bind_result($r2);
                                $ejec2->execute();
                                $ejec2->fetch();

                                
                                if($r2 == 0){
                                    echo "<div id='aviso'>
                                            ⇾ Lo sentimos, no hemos encontrado ninguna cita que se asemeje a tu busqueda ⇽
                                          </div>";
                                    $ejec1->close();
                                    $ejec2->close();
                                }else{
                                    $ejec2->close();
                                    $general = $conex->query("select *
                                                              from citas
                                                              where codigo_servicio=$r2");
                                    
                                    while($fila = $general->fetch_array(MYSQLI_ASSOC)){

                                        $ver_cliente = $conex->query("select nombre_animal
                                                              from cliente
                                                              where id='$fila[codigo_mascota]'");
                        
                                        $ver_servicio = $conex->query("select descripcion
                                                                    from servicio
                                                                    where codigo='$fila[codigo_servicio]'");

                                        $resultado_ver_cliente = $ver_cliente->fetch_array(MYSQLI_NUM);
                                        $resultado_ver_servicio = $ver_servicio->fetch_array(MYSQLI_NUM);

                                        $hora = substr($fila["hora_cita"],0,-3);

                                        
                                        $fecha_legible = explode("-",$fila["fecha_cita"]);
                                        $dia = ltrim($fecha_legible[2],"0");
                                        $mes = mostrarMes($fecha_legible[1]);

                                        echo "<div>
                                                <div><b>Cliente: </b>$resultado_ver_cliente[0]</div>
                                                <div><b>Servicio: </b>$resultado_ver_servicio[0]</div>
                                                <div><b>Fecha: </b>$dia de $mes del $fecha_legible[0]</div>
                                                <div><b>Hora: </b>$hora</div>
                                            </div>
                                            <br><br>";

                                    }

                                }
                            }else{
                                $ejec1->close();

                                $general = $conex->query("select *
                                                           from citas
                                                           where codigo_mascota=$r");

                                if($general->num_rows!=0){
                                    
                                    while($fila = $general->fetch_array(MYSQLI_ASSOC)){

                                        $ver_cliente = $conex->query("select nombre_animal
                                                                      from cliente
                                                                      where id='$fila[codigo_mascota]'");
                            
                                        $ver_servicio = $conex->query("select descripcion
                                                                        from servicio
                                                                        where codigo='$fila[codigo_servicio]'");
    
                                        $resultado_ver_cliente = $ver_cliente->fetch_array(MYSQLI_NUM);
                                        $resultado_ver_servicio = $ver_servicio->fetch_array(MYSQLI_NUM);
    
                                        $hora = substr($fila["hora_cita"],0,-3);
    
                                            
                                        $fecha_legible = explode("-",$fila["fecha_cita"]);
                                        $dia = ltrim($fecha_legible[2],"0");
                                        $mes = mostrarMes($fecha_legible[1]);
    
                                        echo "<div>
                                                <div><b>Cliente: </b>$resultado_ver_cliente[0]</div>
                                                <div><b>Servicio: </b>$resultado_ver_servicio[0]</div>
                                                <div><b>Fecha: </b>$dia de $mes del $fecha_legible[0]</div>
                                                <div><b>Hora: </b>$hora</div>
                                               </div>
                                               <br><br>";
    
                                    }
                                }else{
                                    echo "<div id='aviso'>
                                            ⇾ Lo sentimos, ese cliente no tiene ninguna cita pendiente ⇽
                                          </div>";
                                }
                            }

                            $conex->close();
                        }

                    }
                ?>
            </div>
        </div>
    </main>
</body>
</html>