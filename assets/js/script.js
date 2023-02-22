// GESTION DES IMAGES PREVIEW DANS LE DASHBOARD GALERIE

class ImagePreviewer { // Classe qui permet de prévisualiser les images dans le dashboard galerie
    constructor(inputSelector, containerSelector) {
        this.images = []; // Tableau qui contient les images
        this.input = document.querySelector(inputSelector); // Sélectionne l'input
        this.container = document.querySelector(containerSelector); // Sélectionne le container
        this.input.addEventListener("change", this.handleInputChange.bind(this)); // Ecoute l'événement change sur l'input
    }

    handleInputChange() { // Quand l'input change
        const files = this.input.files; // Récupère les fichiers
        for (let i = 0; i < files.length; i++) { // Pour chaque fichier
            this.images.push(files[i]); // On l'ajoute au tableau
        }
        this.renderImages(); // On affiche les images
    }

    renderImages() { // Affiche les images
        let images = ""; // On initialise la variable qui contiendra les images
        this.images.forEach((image, index) => { // Pour chaque image
            const id = `image_${index}`; // On génère un id
            images += `<div class="preview-img">
                    <img src="${URL.createObjectURL(image)}" alt="image">
                  </div>`;
        });
        this.container.innerHTML = images; // On affiche les images
    }
}

// Utilisation
const previewer = new ImagePreviewer("#inputPhotos", ".preview-container");






// ------------------------------ //

// AJAX POUR L'AFFICHAGE DES ALBUMS DANS LE DASHBOARD GALERIE

// eventlistener pour le select qui permet de choisir l'album
document.querySelector("#album-select").addEventListener("change", function () {
    // Récupère le nom de l'album
    const albumName = document.querySelector("#album-select").options[document.querySelector("#album-select").selectedIndex].text;
});



