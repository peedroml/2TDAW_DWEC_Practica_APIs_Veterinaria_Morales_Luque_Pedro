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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300&display=swap" rel="stylesheet">
    <link rel="icon" href="../../img/favicon.png" type="image/png"/>
    <link rel="stylesheet" href="../../css/styles.css">
    <title>Consultar citas | Safari</title>
</head>
<body>
    <header>
        <?php
            require_once("../funciones.php");
            echo mostrarCabecera("Consultar citas","citas.php","../../img/huella.png");
        ?>
    </header>
    <main>

        <div id="contenedor">
            <div id="contenedor_borrar_cita">
                <?php
                    $conex = conectarServidor();
                    $consulta_mostrar_citas = $conex->query("select *
                                                             from citas
                                                             group by fecha_cita
                                                             order by fecha_cita desc");
                                                             
                    while($fila = $consulta_mostrar_citas->fetch_array(MYSQLI_ASSOC)){

                        $sacar_fechas_mismo_dia = $conex->query("select *
                                                                 from citas
                                                                 where fecha_cita='$fila[fecha_cita]'");

                        //Sacar la fecha de una manera legible para el usuario
                        $fecha_legible = explode("-",$fila["fecha_cita"]);
                        $dia = ltrim($fecha_legible[2],"0");
                        $mes = mostrarMes($fecha_legible[1]);

                        echo "<div class='f_citas'>
                                <p><b>Cita(s) para el día: </b>$dia de $mes del $fecha_legible[0]<p>
                              </div>";                                         

                        while($info = $sacar_fechas_mismo_dia->fetch_array(MYSQLI_ASSOC)){

                            $ver_cliente = $conex->query("select nombre_animal
                                                          from cliente
                                                          where id='$info[codigo_mascota]'");
                        
                            $ver_servicio = $conex->query("select descripcion
                                                           from servicio
                                                           where codigo='$info[codigo_servicio]'");

                            $resultado_ver_cliente = $ver_cliente->fetch_array(MYSQLI_NUM);
                            $resultado_ver_servicio = $ver_servicio->fetch_array(MYSQLI_NUM);

                            //Quitar la parte de los segundos de la hora
                            $hora = substr($info["hora_cita"],0,-3);

                            //Comprobar que la cita no se puede cancerlar
                            $fecha_cita = $info["fecha_cita"];
                            $time = time();
                            $dia_actual = date("d",$time);
                            $mes_actual = date("m",$time);
                            $año_actual = date("Y",$time);
                            $fecha_actual = $año_actual . "-" . $mes_actual . "-" . $dia_actual;
                            $es_antigua = false;

                            if($fecha_cita==$fecha_actual || $fecha_cita<$fecha_actual){
                                $boton_cancelar = "<button class='boton_cancel_f' disabled>Pasada</button>";
                            }else{
                                $boton_cancelar = "<button class='boton_cancel_t' disabled>Pendiente</button>"; 
                            }

                            echo "<div>
                                <div><b>Cliente: </b>$resultado_ver_cliente[0]</div>
                                <div><b>Servicio: </b>$resultado_ver_servicio[0]</div>
                                <div><b>Hora: </b>$hora</div>
                                <div>$boton_cancelar</div>
                              </div>
                              <br><br>";
                        }
                    }   
                ?>
            </div>
        </div>
    </main>
</body>
</html>