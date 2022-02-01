"use strict"

//Seleccionamos el contenedor de la galeria
const contenedor_galeria = document.querySelector("#contenedorGaleria");

//Hacemos la funcion para crear los contenedores
const crearContenedor=()=>{
    //Contenedor de la foto y el texto
    let nuevo_contenedor = document.createElement("div");

    //Contenedor para la foto
    let contenedor_foto = document.createElement("div");
    contenedor_foto.classList.add("text-center");
    contenedor_foto.classList.add("bordes-galeria");
    contenedor_foto.classList.add("rounded-pill")
    
    nuevo_contenedor.appendChild(contenedor_foto);

    //Contenedor para el texto
    let contenedor_texto = document.createElement("div");
    contenedor_texto.classList.add("text-center")

    nuevo_contenedor.appendChild(contenedor_texto)

    return nuevo_contenedor;
} 
