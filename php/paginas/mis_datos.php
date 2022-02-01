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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="icon" href="../../img/favicon.png" type="image/png"/>
    <link rel="stylesheet" href="../../css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300&display=swap" rel="stylesheet">
    <title>Mis datos | Safari</title>
</head>
<body>

    <?php
        require_once("../funciones.php");
        echo mostrarCabecera("Mis datos","../../index.php","../../img/huella.png");
    ?>

    <header>
        <?php
            if(isset($_COOKIE["como_usuario"])){
                echo mostrarNavUser("../../index.php","mis_mascotas.php","mis_datos.php","mis_citas.php","productos.php","servicios.php");

                if(isset($_POST["cerrar_sesion"])){
                    setcookie("como_usuario",null,-3,"/");
                    header("location:../../index.php");
                }

            }
        ?>
    </header>
    
    <main>
        <div id="contenedor_clientes">
            <div>
                    <form action="#" method="post">
                        <?php
                            $conex = conectarServidor();

                            $find = $conex->query("select *
                                                from dueño
                                                where nick='$_SESSION[nick]'");

                            while($fila = $find->fetch_array(MYSQLI_ASSOC)){

                                if($fila["telefono"]==""){
                                    $x = "<input type='text' name='telefono' placeholder='Nuevo número'>";
                                }else{
                                    $x = "<input type='text' name='telefono' placeholder='$fila[telefono]'>";
                                }

                                echo "<div id='mis_datos'>
                                        <span>
                                            <label>Nombre de usuario</label>
                                            <input type='text' name='nombre' disabled value='$fila[nombre]'>
                                        </span>
                                        <br><br>
                                        <span>
                                            <label>DNI</label>
                                            <input type='text' name='DNI' disabled value='$fila[dni]'>
                                        </span>
                                        <br><br>
                                        <span>
                                            <label>Teléfono</label>
                                            $x
                                        </span>
                                        <br><br>
                                        <span>
                                            <label>Nick</label>
                                            <input type='text' name='nombre' disabled value='$fila[nick]'>
                                        </span>
                                        <br><br>
                                        <span>
                                            <label>Nueva contraseña</label>
                                            <input type='text' name='nueva_pass'>
                                        </span>
                                    </div>
                                    <br><br>
                                    <input class='eFD' type='submit' name='enviar' value='Modificar datos'>
                                    <input type='hidden' name='pass_antigua' value='$fila[pass]'>
                                    <input type='hidden' name='tele_antiguo' value='$fila[telefono]'>";
                                    
                            }
                        ?>
                    </form>
            </div>
        </div>
        <div id='aviso_modificar'>
                <?php
                    if(isset($_POST["enviar"])){
                        if($_POST["telefono"]=="" && $_POST["nueva_pass"]===""){
                            echo "<div id='aviso_login2'>
                                    <div>
                                        <svg xmlns='http://www.w3.org/2000/svg' width='25' height='25' fill='currentColor' class='bi bi-exclamation-triangle' viewBox='0 0 16 16'>
                                            <path d='M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.146.146 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.163.163 0 0 1-.054.06.116.116 0 0 1-.066.017H1.146a.115.115 0 0 1-.066-.017.163.163 0 0 1-.054-.06.176.176 0 0 1 .002-.183L7.884 2.073a.147.147 0 0 1 .054-.057zm1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566z'/>
                                            <path d='M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995z'/>
                                        </svg>
                                        <p>
                                            <strong>EDITE EL TELÉFONO Y/O LA CONTRASEÑA PARA PODER MODIFICAR SUS DATOS</strong>
                                        </p>
                                    <div>
                                </div>";
                        }else{
                            if($_POST["telefono"]==""){
                                $telefono = $_POST["tele_antiguo"];
                            }else{
                                $telefono = $_POST["telefono"];
                            }

                            if($_POST["nueva_pass"]==""){
                                $nueva_pass = $_POST["pass_antigua"];
                            }else{
                                $nueva_pass = md5($_POST["nueva_pass"]);
                            }

                            $modificar_dueño = $conex->prepare("update dueño
                                                                set telefono=?,pass=?
                                                                where nick='$_SESSION[nick]'");

                            $modificar_dueño->bind_param("ss",$telefono,$nueva_pass);
                            $modificar_dueño->execute();

                            echo "<div id='aviso_login2_succes'>
                                <div>
                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-bookmark-check' viewBox='0 0 16 16'>
                                        <path fill-rule='evenodd' d='M10.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z'/>
                                        <path d='M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5V2zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1H4z'/>
                                    </svg>
                                    <p>
                                        <strong>DATOS MODIFICADOS SATISFACTORIAMENTE</strong>
                                    </p>
                                </div>
                              </div>";

                            $modificar_dueño->close();
                            $conex->close();

                            
                        }
                    }
                ?>
            </div>
    </main>
</body>
</html>