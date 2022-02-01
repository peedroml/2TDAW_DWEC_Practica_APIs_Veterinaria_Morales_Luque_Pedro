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
    <title>Citas | Safari</title>
</head>
<body>

    <?php
        require_once("../funciones.php");
        echo mostrarCabecera("Citas","../../index.php","../../img/huella.png");
    ?>
    
    <header>
        <?php
            if(isset($_COOKIE["como_admin"])){
                echo mostrarNavAdmin("../../index.php","clientes.php","productos.php","servicios.php","testimonios.php","noticias.php","citas.php","dueños.php");

                if(isset($_POST["cerrar_sesion"])){
                    setcookie("como_admin",null,-3,"/");
                    header("location:../../index.php");
                }

            }
        ?>
    </header>

    <main>
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
            
            echo "  </table>
                    </div>
                    <div class='insertar_datos'>
                        <div>
                            <a href='../insertar/insertar_cita.php'>Insertar cita</a>
                        </div>
                        <div>
                            <a href='../buscar/buscar_cita.php'>Buscar cita</a>
                        </div>
                        <div>
                            <a href='../borrar/borrar_cita.php'>Borrar cita</a>
                        </div>
                        <div>
                            <a href='consultar_citas.php'>Consultar citas</a>
                        </div>
                    </div>";
            
        ?>
    </main>
    
    <footer>
        <?php
            echo mostrarFooter('../../img/whatsapp.png','../../img/face.png','../../img/insta.png','../../img/tw.png');
        ?>
    </footer>
</body>
</html>