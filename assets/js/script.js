// GESTION DES IMAGES PREVIEW DANS LE DASHBOARD GALERIE

const previewContainer = document.querySelector(".preview-container")
const inputPhotos = document.querySelector("#inputPhotos")

let imagesArray = []

inputPhotos.addEventListener("change", () => { // Ajoute les images dans le tableau imagesArray
    const files = inputPhotos.files // Récupère les fichiers
    for (let i = 0; i < files.length; i++) {
        imagesArray.push(files[i])
    }
    displayImages()
})


function displayImages() { // Affiche les images dans le container
    let images = "";
    imagesArray.forEach((image, index) => { // Pour chaque image, on crée un div avec l'image

        const id = `image_${index}`;
        images += `<div class="preview-img">
                  <img src="${URL.createObjectURL(image)}" alt="image">
                </div>`;
    });
    previewContainer.innerHTML = images;
}