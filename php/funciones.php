<?php

    function conectarServidor(){
        $con = new mysqli("localhost","root","","veterinaria");
        $con->set_charset("utf8");
        return $con;
    }


    function mostrarCabecera($nombre_pagina=0,$ruta='',$ruta_img){
        
        $re="<div id='cabecera'>
                <h1>$nombre_pagina</h1>
                <a href='$ruta'>
                    <img id='foto_logo' src='$ruta_img' alt='logo'>
                </a>
              </div>";
        return $re;
    }

    function mostrarNavAdmin($index,$clientes,$productos,$servicios,$testimonios,$noticias,$citas,$dueños){
        $re="<nav>
            <ul>
                <li>
                    <a class='a_menu' href='$index'>Inicio</a>
                </li>
                <li>
                    <a class='a_menu' href='$clientes'>Clientes</a>
                </li>
                <li>
                    <a class='a_menu' href='$productos'>Productos</a>
                </li>
                <li>
                    <a class='a_menu' href='$servicios'>Servicios</a>
                </li>
                <li>
                    <a class='a_menu' href='$testimonios'>Testimonios</a>
                </li>
                <li>
                    <a class='a_menu' href='$noticias'>Noticias</a>
                </li>
                <li>
                    <a class='a_menu' href='$citas'>Citas</a>
                </li>
                <li>
                    <a class='a_menu' href='$dueños'>Dueños</a>
                </li>
                <li>
                    <form id='cerrar' action='#' method='POST'>
                        <input type='submit' name='cerrar_sesion' value='Cerrar sesión'>
                    </form>
                </li>
            </ul>
        </nav>";
        return $re;
    }

    function mostrarNavUser($index,$mis_mascotas,$mis_datos,$mis_citas,$productos,$servicios){
        $re="<nav>
            <ul>
                <li>
                    <a class='a_menu' href='$index'>Inicio</a>
                </li>
                <li>
                    <a class='a_menu' href='$mis_mascotas'>Mis mascotas</a>
                </li>
                <li>
                    <a class='a_menu' href='$mis_datos'>Mis datos</a>
                </li>
                <li>
                    <a class='a_menu' href='$mis_citas'>Mis citas</a>
                </li>
                <li>
                    <a class='a_menu' href='$productos'>Productos</a>
                </li>
                <li>
                    <a class='a_menu' href='$servicios'>Servicios</a>
                </li>
                <li>
                    <form id='cerrar' action='#' method='POST'>
                        <input type='submit' name='cerrar_sesion' value='Cerrar sesión'>
                    </form>
                </li>
            </ul>
        </nav>";
        return $re;
    }

    function mostrarNavSin($index,$productos,$servicios,$acceder){
        $re="<nav>
            <ul>
                <li>
                    <a class='a_menu' href='$index'>Inicio</a>
                </li>
                <li>
                    <a class='a_menu' href='$productos'>Productos</a>
                </li>
                <li>
                    <a class='a_menu' href='$servicios'>Servicios</a>
                </li>
                <li>
                    <a class='a_menu' href='$acceder'>Acceder</a>
                </li>
            </ul>
        </nav>";
        return $re;
    }

    function mostrarFooter($w,$f,$i,$t){
        $re = "<div id='redes'>
            <h4>Redes sociales</h4>
            <div id='lista_redes'>
                <li><a href=''><img src='$w'></a></li>
                <li><a href=''><img src='$f'></a></li>
                <li><a href=''><img src='$i'></a></li>
                <li><a href=''><img src='$t'></a></li>
            </div>
        </div>
        <div id='judiciales'>
            <h4>Veterinaria Safari© Todos los derechos reservados</h4>
        </div>";

        return $re;
    }

    function mostrarMes($numero_mes){
        switch($numero_mes){
            case 1:
                $res = "Enero";
                break;
            case 2:
                $res = "Febrero";
                break;
            case 3:
                $res = "Marzo";
                break;
            case 4:
                $res = "Abril";
                break;
            case 5:
                $res = "Mayo";
                break;
            case 6:
                $res = "Junio";
                break;
            case 7:
                $res = "Julio";
                break;
            case 8:
                $res = "Agosto";
                break;
            case 9:
                $res = "Septiembre";
                break;
            case 10:
                $res = "Octubre";
                break;
            case 11:
                $res = "Noviembre";
                break;
            case 12:
                $res = "Diciembre";
                break;    
        }
        return $res;
    }

?>