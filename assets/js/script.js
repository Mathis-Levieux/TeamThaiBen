// GESTION DES IMAGES PREVIEW DANS LE DASHBOARD GALERIE

console.log("Script chargé");

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


// Si on est sur la page galerie
if (document.querySelector("#inputPhotos")) {
    // Utilisation du previewer d'images dans le dashboard galerie
    const previewer = new ImagePreviewer("#inputPhotos", ".preview-container");
}


class PdfPreviewer { // Classe qui permet de prévisualiser les images dans le dashboard galerie
    constructor(inputSelector, containerSelector) {
        this.pdf = []; // Tableau qui contient les images
        this.input = document.querySelector(inputSelector); // Sélectionne l'input
        this.container = document.querySelector(containerSelector); // Sélectionne le container
        this.input.addEventListener("change", this.handleInputChange.bind(this)); // Ecoute l'événement change sur l'input
    }

    handleInputChange() { // Quand l'input change
        const files = this.input.files; // Récupère les fichiers
        for (let i = 0; i < files.length; i++) { // Pour chaque fichier
            this.pdf.push(files[i]); // On l'ajoute au tableau
        }
        this.renderPdf(); // On affiche les images
    }

    renderPdf() { // Affiche les images
        let html = ""; // On initialise la variable qui contiendra les images
        this.pdf.forEach((pdf, index) => { // Pour chaque image
            const id = `pdf_${index}`; // On génère un id
            html += `<div class="preview-pdf col-lg-12">
                    <iframe class="h-100 col-lg-12" src="${URL.createObjectURL(pdf)}"> </iframe>
                  </div>`;

        });
        console.log(html);
        this.container.innerHTML = html; // On affiche les images

    }

}
// Si on est sur la page fichier
if (document.querySelector("#inputFile")) {
    // Utilisation du previewer d'images dans le dashboard fichier
    const previewer2 = new PdfPreviewer("#inputFile", ".preview-container");
}







// ------------------------------ //

// AJAX POUR L'AFFICHAGE DES ALBUMS DANS LE DASHBOARD GALERIE

// // eventlistener pour le select qui permet de choisir l'album
// document.querySelector("#album-select").addEventListener("change", function () {
//     // Récupère le nom de l'album
//     const albumName = document.querySelector("#album-select").options[document.querySelector("#album-select").selectedIndex].text;
// });



