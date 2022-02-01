<?php
    session_start();
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../../css/styles.css">
    <title>Iniciar sesión | Safari</title>
</head>
<body id='fondo_login'>
    <h1>Iniciar sesión</h1>
    <div id='con_login'>
        <div id='cuadrado'>
            <form action="#" method="post">
                <input class='campos_login' type='text' name='nom' placeholder='Nombre de usuario'>
                <br><br>
                <input class='campos_login' type='password' name='pass' placeholder='Contraseña'>
                <span id="spm">
                    <input id="mantener" type='checkbox' name='mantener'>Mantener sesión abierta
                </span>
                <input id='boton_acceder' type='submit' name='enviar' value='ACCEDER'>
                
            </form>
            <div id='volver'>
                Volver a la <a href='../../index.php'>página principal</a>
            </div>
        </div>
    </div>
    <div>
        <?php
            if(isset($_POST["enviar"])){
                if($_POST["nom"]==="" || $_POST["pass"]===""){
                    echo "<div id='aviso_login'>
                            <div>
                                <svg xmlns='http://www.w3.org/2000/svg' width='25' height='25' fill='currentColor' class='bi bi-exclamation-triangle' viewBox='0 0 16 16'>
                                    <path d='M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.146.146 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.163.163 0 0 1-.054.06.116.116 0 0 1-.066.017H1.146a.115.115 0 0 1-.066-.017.163.163 0 0 1-.054-.06.176.176 0 0 1 .002-.183L7.884 2.073a.147.147 0 0 1 .054-.057zm1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566z'/>
                                    <path d='M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995z'/>
                                </svg>
                                <p>
                                    <strong>LOS CAMPOS NO PUEDEN ESTAR VACÍOS</strong>
                                </p>
                            <div>
                          </div>";
                }else{
                    require_once("../funciones.php");
                    $conex = conectarServidor();

                    $nom = $_POST["nom"];
                    $pass = $_POST["pass"];
                    $pass = md5($pass);
                    
                    $sentencia = "select dni from dueño where nick=? and pass=?";
                    $consulta = $conex->prepare($sentencia);
                    $consulta->bind_param("ss",$nom,$pass);
                    $consulta->bind_result($dni);
                    $consulta->execute();

                    while($consulta->fetch()){$x = $dni;}

                    if(isset($x)){
                        if($x=="00000000"){
                            echo "<div id='succes'>
                                <div>
                                    <div class='spinner-border-sm spinner-border' role='status'>
                                        <span class='visually-hidden'>Loading...</span>
                                    </div>
                                    <p>
                                        <strong>ESPERE UN MOMENTO...</strong>
                                    </p>
                                </div>
                              </div>";

                            if(isset($_POST["mantener"])){
                                setcookie("como_admin","x",time()+(365*24*60*60),"/");
                            }else{
                                setcookie("como_admin","x",null,"/");
                            }

                            header("refresh:2.5;url=../../index.php");
                            
                        }else{
                            echo "<div id='succes'>
                                <div>
                                    <div class='spinner-border-sm spinner-border' role='status'>
                                        <span class='visually-hidden'>Loading...</span>
                                    </div>
                                    <p>
                                        <strong>ESPERE UN MOMENTO...</strong>
                                    </p>
                                </div>
                              </div>";
                        

                            $_SESSION["nick"] = $nom;
                            $nom = session_encode();
                            
                            if(isset($_POST["mantener"])){
                                setcookie("como_usuario",$nom,time()+(365*24*60*60),"/");
                            }else{
                                setcookie("como_usuario",$nom,null,"/");
                            }

                            header("refresh:2.5;url=../../index.php");
                        }

                    }else{
                        echo "<div id='aviso_login'>
                            <div>
                                <svg xmlns='http://www.w3.org/2000/svg' width='25' height='25' fill='currentColor' class='bi bi-exclamation-triangle' viewBox='0 0 16 16'>
                                    <path d='M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.146.146 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.163.163 0 0 1-.054.06.116.116 0 0 1-.066.017H1.146a.115.115 0 0 1-.066-.017.163.163 0 0 1-.054-.06.176.176 0 0 1 .002-.183L7.884 2.073a.147.147 0 0 1 .054-.057zm1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566z'/>
                                    <path d='M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995z'/>
                                </svg>
                                <p>
                                    <strong>EL USUARIO Y/O CONTRASEÑA NO SON CORRECTOS</strong>
                                </p>
                            <div>
                          </div>";
                    }

                    $consulta->close();
                    $conex->close();
                }
            }
        ?>
    </div>
</body>
</html>