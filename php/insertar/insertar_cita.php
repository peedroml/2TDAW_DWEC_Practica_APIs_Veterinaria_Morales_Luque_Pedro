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
    <title>Insertar cita | Safari</title>
</head>
<body>
    <header>
        <?php
            require_once("../funciones.php");
            echo mostrarCabecera("Insertar cita","../paginas/citas.php","../../img/huella.png");
        ?>
    </header>
    <main>

    <div id="contenedor">
            <div id="contenedor_inser_tes">
                <form action="#" method="post">
                <?php
                    $conex = conectarServidor();

                    $x = "select *
                          from cliente";

                    $sacar_clientes = $conex->query($x);

                    echo "<select name='cliente'>
                            <option selected value='0'>- Selecciona un cliente -</option>";

                    while($fila = $sacar_clientes->fetch_array(MYSQLI_ASSOC)){
                        echo "<option value='$fila[id]'>$fila[nombre_animal]</option>";
                    }
                    echo "</select>
                          <br><br>
                          <select name='servicio'>
                            <option selected value='0'>- Selecciona el servicio -</option>";

                    $y = "select *
                          from servicio";

                    $sacar_servicio = $conex->query($y);

                    while($fila = $sacar_servicio->fetch_array(MYSQLI_ASSOC)){
                        echo "<option value='$fila[codigo]'>$fila[descripcion]</option>";
                    }

                    echo "</select>
                          <br><br>
                          <span>
                            <label>Fecha de la cita</label>
                            <input type='date' name='fecha'>
                          </span>
                          <br><br>
                          <span>
                            <label>Hora de la cita</label>
                            <input type='time' name='hora'>
                          </span>";
                ?>
                    <input type="submit" name="enviar">
                </form>
            </div>
            <div id="res">
                <?php
                    if(isset($_POST["enviar"])){
                        $iden_cliente = $_POST["cliente"];
                        $iden_servicio = $_POST["servicio"];
                        $fecha_cita = $_POST["fecha"];
                        $hora = $_POST["hora"] . ":00";  

                        if($iden_cliente!=0){
                            if($iden_servicio!=0){

                                $time = time();
                                $dia_actual = date("d",$time);
                                $mes_actual = date("m",$time);
                                $año_actual = date("Y",$time);
                                $fecha_actual = $año_actual . "-" . $mes_actual . "-" . $dia_actual;

                                if($fecha_cita!="" && $fecha_cita>=$fecha_actual){
                                    if($hora!=""){
                                        $tiene_fecha=false;

                                        $k = "select *
                                              from citas
                                              where codigo_mascota='$iden_cliente'";

                                        $consulta_cita = $conex->query($k);

                                        while($fila = $consulta_cita->fetch_array(MYSQLI_ASSOC)){
                                            if($fila["fecha_cita"]==$fecha_cita && $fila["hora_cita"]==$hora){
                                                $tiene_fecha=true;
                                            }
                                        }
                                        
                                        if($tiene_fecha){
                                            echo "<div id='aviso'>
                                                ⇾ Ese cliente ya cuenta con una cita el mismo dia y la misma hora ⇽
                                              </div>";
                                        }else{
                                            $sentencia = "insert into citas values(?,?,?,?)";
                                            $consulta = $conex->prepare($sentencia);
                                            $consulta->bind_param("iiss",$iden_cliente,$iden_servicio,$fecha_cita,$hora);
                                            $consulta->execute();

                                            echo "<div id='aviso'>
                                                ⇾ Cita insertarda correctamente ⇽
                                              </div>";

                                            $consulta->close();
                                        }

                                        $conex->close();
                                    }else{
                                        echo "<div id='aviso'>
                                                ⇾ Debe de completar el campo ' Hora de la cita ' ⇽
                                              </div>";
                                    }
                                }else{
                                    echo "<div id='aviso'>
                                        ⇾ La fecha de la cita no puede ser pasada o debe de completar el campo ⇽
                                      </div>";
                                }
                            }else{
                                echo "<div id='aviso'>
                                        ⇾ Debe seleccionar un servicio ⇽
                                      </div>";
                            }
                        }else{
                            echo "<div id='aviso'>
                                    ⇾ Debe seleccionar un animal ⇽
                                  </div>";
                        }
                    }
                ?>
            </div>
        </div>

    </main>
</body>
</html>