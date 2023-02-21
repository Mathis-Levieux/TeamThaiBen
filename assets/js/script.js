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


// GESTION DE L'AFFICHAGE DES ALBUMS DYNAMIQUEMENT DANS LE DASHBOARD GALERIE

class AjaxAlbums { // Classe qui permet d'afficher les albums dynamiquement dans le dashboard galerie
    constructor(containerSelector, url) {
        this.container = document.querySelector(containerSelector); // Sélectionne le container
        this.url = url; // Url de la requête ajax
        this.albums = []; // Tableau qui contient les albums
        this.renderAlbums(); // Affiche les albums
    }

    renderAlbums() { // Affiche les albums
        fetch(this.url) // Requête ajax
            .then(response => response.json()) // On récupère la réponse au format json
            .then(albums => { // On récupère les albums
                this.albums = albums; // On les ajoute au tableau
                this.render(); // On affiche les albums
            })
            .catch(error => console.log(error)); // En cas d'erreur
    }

    render() { // Affiche les albums
        let albums = ""; // On initialise la variable qui contiendra les albums
        this.albums.forEach(album => { // Pour chaque album
            albums += `<option value="${album.id}">${album.name}</option>`;
        });
        this.container.innerHTML = albums; // On affiche les albums
    }
}

// Utilisation
const ajaxAlbums = new AjaxAlbums(".album-container", "../../api/albums");

// eventlistener pour afficher les images d'un album dans le dashboard galerie
document.querySelector("#album-select").addEventListener("change", function () {
    const albumId = document.querySelector("#album-select").value;
    
});