"use strict"

//Seleccionamos el contenedor de la galeria
const contenedor_galeria = document.querySelector("#contenedorGaleria");

//Funcion para ampliar la imagen del animal
const nombre_animal_modal = document.querySelector("#nombreAnimal");
const imagen_animal_modal = document.querySelector("#imagenEspecifica");
const modal_imagen_grande = document.querySelector("#modalFotoGrande")
const header = document.querySelector(".headerG");

const ampliarImagen = (imagen,nombre, url_imagen) => {
    imagen.addEventListener("click",
        () => {
            header.classList.remove("headerG");
            header.classList.add("headerSin");
            nombre_animal_modal.innerText = nombre;
            imagen_animal_modal.src = url_imagen;
            imagen_animal_modal.classList.add("w-100")
            $(modal_imagen_grande).modal("toggle");
        }
    )
}

//Hacemos la funcion para crear los contenedores
const crearContenedor = (foto, texto) => {
    //Contenedor de la foto y el texto
    let nuevo_contenedor = document.createElement("div");
    nuevo_contenedor.classList.add("con_DG");

    //==================================================

    //Contenedor para la foto
    let contenedor_foto = document.createElement("div");
    contenedor_foto.classList.add("text-center");

    //Foto
    let img_animal = document.createElement("img");
    img_animal.src = foto;
    img_animal.classList.add("imagenes-galeria")

    //Añadir funcion para sacar modal
    ampliarImagen(img_animal,texto,foto);

    //==================================================

    //Contenedor para el texto
    let contenedor_texto = document.createElement("div");
    contenedor_texto.classList.add("text-center");

    //Texto
    let texto_informativo = document.createElement("p");
    texto_informativo.innerText = texto;
    texto_informativo.classList.add("mt-4")

    //==================================================

    contenedor_foto.appendChild(img_animal);
    contenedor_texto.appendChild(texto_informativo);
    nuevo_contenedor.appendChild(contenedor_foto);
    nuevo_contenedor.appendChild(contenedor_texto);

    return nuevo_contenedor;
}

contenedor_galeria.appendChild(crearContenedor(`http://www.metgroup.com.ar/wp-content/uploads/2016/09/girl-500x500.jpg`, "Animal 1"));
contenedor_galeria.appendChild(crearContenedor(`https://icdn.dtcn.com/image/digitaltrends_es/url-95a97f92c62bd91ba8bc4fe83088b47a-500x500.jpg`, "Animal 2"));