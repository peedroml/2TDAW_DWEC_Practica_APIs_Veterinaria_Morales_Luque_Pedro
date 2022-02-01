<?php
    session_start();

    if(!isset($_COOKIE["como_usuario"])){
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
    <title>Mis citas | Safari</title>
</head>
<body>

    <?php
        require_once("../funciones.php");
        echo mostrarCabecera("Mis citas","../../index.php","../../img/huella.png");
    ?>

    <header>
        <?php
            if(isset($_COOKIE["como_usuario"])){
                echo mostrarNavUser("../../index.php","mis_mascotas.php","mis_datos.php","mis_citas.php","productos.php","servicios.php","galeria.php");

                if(isset($_POST["cerrar_sesion"])){
                    setcookie("como_usuario",null,-3,"/");
                    header("location:../../index.php");
                }

            }
        ?>
    </header>

    <main>
        <div id="contenedor_mis_citas">
            <?php

            setlocale(LC_ALL,"es-ES.UTF-8");
            $time = time();
            $mes = ucfirst(strftime("%B",$time));
            $año_actual = date("Y",$time);
            $dia_actual = date("j",$time);


            $meses_año = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"] ;
            $dias_semana=["L","M","X","J","V","S","D"];
            $mes_siguiente=0;
            $año=$año_actual;

            for($i=0;$i<12;$i++){
                if($meses_año[$i]===$mes){
                    $mes_siguiente=$i;
                }
            }

            if(isset($_POST["enviar_siguiente"])){
                $mes_siguiente=$_POST["mes_siguiente"];
                $año=$_POST["año_s"];
                
                if($mes_siguiente>11){
                    $mes_siguiente=0;
                    $año++;
                }

            }elseif(isset($_POST["enviar_anterior"])){
                $mes_siguiente=$_POST["mes_anterior"];
                $año=$_POST["año_a"];

                if($mes_siguiente<0){
                    $mes_siguiente=11;
                    $año--;
                }
            }

            $sengundos_actuales = mktime(0,0,0,$mes_siguiente+1,1,$año);

            $dias_meses = date("t",$sengundos_actuales);
            $dia = date("N",$sengundos_actuales);

            echo "<div id='contenedor_calendario'>
                    <table>
                        <tr id='encabezado_calendario'>
                            <td colspan=2>
                                <form action='#' method='post'>
                                    <input type='submit' name='enviar_anterior' value='<'>
                                    <input type='hidden' name='año_a' value='$año'>
                                    <input type='hidden' name='mes_anterior' value='"; echo $mes_siguiente-1 . "'>
                                </form>
                            </td>
                            <td colspan=3>
                                <p>$meses_año[$mes_siguiente] - $año</p>
                            </td>
                            <td colspan=2>
                                <form action='#' method='post'>
                                    <input type='submit' name='enviar_siguiente' value='>'>
                                    <input type='hidden' name='año_s' value='$año'>
                                    <input type='hidden' name='mes_siguiente' value='"; echo $mes_siguiente+1 . "'>
                                </form>
                            </td>
                        </tr>
                        <tr>";

                        $casilla=0;
                        foreach($dias_semana as $x){
                            echo "<td class='dias_semana'>$x</td>";
                            $casilla++;
                            if($casilla===7){
                                echo "<tr></tr>";
                                $casilla=0;
                            }
                        }

                        for($i=1;$i<$dia;$i++){
                            echo "<td></td>";
                            $casilla++;
                            if($casilla===7){
                                echo "<tr></tr>";
                                $casilla=0;
                            }
                        }

                        for($j=1;$j<=$dias_meses;$j++){
                            if($j==$dia_actual && $mes===$meses_año[$mes_siguiente]){
                                echo "<td id='dia_actual'>$j</td>";
                            }else{
                                echo "<td>$j</td>";
                            }
                            $casilla++;
                            if($casilla===7){
                                echo "<tr></tr>";
                                $casilla=0;
                            }
                        }

                echo "</table></div>";

                $conex = conectarServidor();

                $ver_nombre = $conex->query("select nombre
                                            from dueño
                                            where nick='$_SESSION[nick]'");
                
                while($fila1 = $ver_nombre->fetch_array(MYSQLI_ASSOC)){

                    $ver_cli = $conex->query("select id from cliente where nombre_dueño='$fila1[nombre]'");

                    while($fila2 = $ver_cli->fetch_array(MYSQLI_ASSOC)){
                        
                        $ver_cita = $conex->query("select * from citas where codigo_mascota=$fila2[id]");

                        while($fila3 = $ver_cita->fetch_array(MYSQLI_ASSOC)){
                            
                            $fecha_legible = explode("-",$fila3["fecha_cita"]);
                            $dia = ltrim($fecha_legible[2],"0");
                            $mes = mostrarMes($fecha_legible[1]);

                            echo "<div class='f_citas'>
                                    <p><b>Cita(s) para el día: </b>$dia de $mes del $fecha_legible[0]<p>
                                </div>";

                            $sacar_fechas_mismo_dia = $conex->query("select *
                                                                    from citas
                                                                    where fecha_cita='$fila3[fecha_cita]'");

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
                                    <div><b>Mascota: </b>$resultado_ver_cliente[0]</div>
                                    <div><b>Servicio: </b>$resultado_ver_servicio[0]</div>
                                    <div><b>Hora: </b>$hora</div>
                                    <div>$boton_cancelar</div>
                                </div>
                                <br><br>";
                            }
                        }

                    }

                }
            ?>
        </div>
    </main>

    <footer>
        <?php
            echo mostrarFooter('../../img/whatsapp.png','../../img/face.png','../../img/insta.png','../../img/tw.png');
        ?>
    </footer>
</body>
</html>