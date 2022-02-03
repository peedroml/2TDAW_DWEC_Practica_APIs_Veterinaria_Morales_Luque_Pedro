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
    texto_informativo.classList.add("fs-5")

    //==================================================

    contenedor_foto.appendChild(img_animal);
    contenedor_texto.appendChild(texto_informativo);
    nuevo_contenedor.appendChild(contenedor_foto);
    nuevo_contenedor.appendChild(contenedor_texto);

    return nuevo_contenedor;
}

//Funcion asincrona para utilizar la api de los perros
async function insertarEnPagina(nombre_animal){
    const respuesta = await fetch("https://dog.ceo/api/breeds/image/random");
    const datos = await respuesta.json();
    const foto = datos.message;

    contenedor_galeria.appendChild(crearContenedor(foto,nombre_animal));
}

//Sacamos 3 numeros aleatorios y utilizamos el JSON de personas ficticias para sacar un nombre 
const nombres = [];
for(let i=0;i<3;i++){
    let x = Math.floor(Math.random() * (usuarios.length - 0));
    //Sacamos el nombre y ponemos la primera letra en mayuscula
    let y = usuarios[x]["name"]["first"].charAt(0).toUpperCase() + usuarios[x]["name"]["first"].slice(1);
    nombres.push(y);
}

//Hacemos un bucle para sacar los nombres del array y añadirle una foto de la API
for(let nombre of nombres){
    insertarEnPagina(nombre);
}