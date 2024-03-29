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
        this.deleteOldPreview(); // On supprime l'ancienne prévisualisation
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
        this.images = []; // On vide le tableau
    }

    deleteOldPreview() { // Supprime l'ancienne prévisualisation
        const oldPreview = document.querySelector(".preview-img");
        const oldPreviews = document.querySelectorAll(".preview-img");
        if (oldPreview) {
            oldPreviews.forEach(oldPreview => {
                console.log(this.images);
            });
        }
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
        this.pdf = []; // On vide le tableau
        const files = this.input.files; // Récupère les fichiers
        for (let i = 0; i < files.length; i++) { // Pour chaque fichier
            this.pdf.push(files[i]); // On l'ajoute au tableau
        }
        this.deleteOldPreview(); // On supprime l'ancienne prévisualisation
        this.renderPdf(); // On affiche les images
    }

    deleteOldPreview() { // Supprime l'ancienne prévisualisation
        const oldPreview = document.querySelector(".preview-pdf");
        if (oldPreview) {
            oldPreview.remove();
        }
    }

    renderPdf() { // Affiche les images
        let html = ""; // On initialise la variable qui contiendra les images
        this.pdf.forEach((pdf, index) => { // Pour chaque image
            const id = `pdf_${index}`; // On génère un id
            html += `<div class="preview-pdf mb-3 col-lg-12">
                    <iframe class="h-100 col-lg-12" src="${URL.createObjectURL(pdf)}"> </iframe>
                  </div>`;

        });
        this.container.innerHTML = html; // On affiche les images

    }

}
// Si on est sur la page fichier
if (document.querySelector("#inputFile")) {
    // Utilisation du previewer d'images dans le dashboard fichier
    const previewer2 = new PdfPreviewer("#inputFile", ".preview-container");
}




// Gestion du dashboard dynamique

/////// GALERIE ////////
if (document.getElementById('addPhoto')) {
    const addPhoto = document.getElementById('addPhoto');
    const addPhotoContent = document.getElementById('addPhotoContent');

    const deletePhoto = document.getElementById('deletePhoto');
    const deletePhotoContent = document.getElementById('deletePhotoContent');
    const deletePhotoButton = document.getElementById('deletePhotoButton');
    const deletePhotoButton2 = document.getElementById('deletePhotoButton2');

    const editAlbum = document.getElementById('editAlbum');
    const editAlbumContent = document.getElementById('editAlbumContent');
    const editAlbumButton = document.getElementById('editAlbumButton');
    const editAlbumButton2 = document.getElementById('editAlbumButton2');
    const editAlbumButton3 = document.getElementById('editAlbumButton3');

    // écouteurs d'événements pour les onglets

    deletePhoto.addEventListener('click', function () {
        addPhotoContent.classList.add('d-none');
        addPhoto.classList.remove('active-tab');

        editAlbumContent.classList.add('d-none');
        editAlbum.classList.remove('active-tab');

        deletePhotoContent.classList.remove('d-none');
        deletePhoto.classList.add('active-tab');

    });

    addPhoto.addEventListener('click', function () {
        deletePhotoContent.classList.add('d-none');
        deletePhoto.classList.remove('active-tab');

        editAlbumContent.classList.add('d-none');
        editAlbum.classList.remove('active-tab');

        addPhotoContent.classList.remove('d-none');
        addPhoto.classList.add('active-tab');

    });

    editAlbum.addEventListener('click', function () {
        deletePhotoContent.classList.add('d-none');
        deletePhoto.classList.remove('active-tab');

        addPhotoContent.classList.add('d-none');
        addPhoto.classList.remove('active-tab');

        editAlbumContent.classList.remove('d-none');
        editAlbum.classList.add('active-tab');
    });

    // Gestion des localStorage et des onglets actifs pour les recharger après un refresh

    deletePhotoButton.addEventListener('click', function () {
        localStorage.setItem('ongletActif', 'deletePhoto');
    })

    if (deletePhotoButton2) {
        deletePhotoButton2.addEventListener('click', function () {
            localStorage.setItem('ongletActif', 'deletePhoto');
        })
    }

    editAlbumButton.addEventListener('click', function () {
        localStorage.setItem('ongletActif', 'editAlbum');
    })

    editAlbumButton2.addEventListener('click', function () {
        localStorage.setItem('ongletActif', 'editAlbum');
    })

    editAlbumButton3.addEventListener('click', function () {
        localStorage.setItem('ongletActif', 'editAlbum');
    })

    if (localStorage.getItem('ongletActif') == 'deletePhoto') {
        addPhotoContent.classList.add('d-none');
        addPhoto.classList.remove('active-tab');

        editAlbumContent.classList.add('d-none');
        editAlbum.classList.remove('active-tab');

        deletePhotoContent.classList.remove('d-none');
        deletePhoto.classList.add('active-tab');

        localStorage.setItem('ongletActif', '');
    }

    if (localStorage.getItem('ongletActif') == 'editAlbum') {
        deletePhotoContent.classList.add('d-none');
        deletePhoto.classList.remove('active-tab');

        addPhotoContent.classList.add('d-none');
        addPhoto.classList.remove('active-tab');

        editAlbumContent.classList.remove('d-none');
        editAlbum.classList.add('active-tab');

        localStorage.setItem('ongletActif', '');
    }
}
/////////// EVENTS ////////
if (document.getElementById('editEventTypes')) {


    const editEventTypes = document.getElementById('editEventTypes');
    const editEventTypesContent = document.getElementById('editEventTypesContent');
    const editEventTypesButton = document.getElementById('editEventTypesButton');
    const editEventTypesButton2 = document.getElementById('editEventTypesButton2');

    const deleteEvent = document.getElementById('deleteEvent');
    const deleteEventContent = document.getElementById('deleteEventContent');
    const deleteEventButton = document.getElementById('deleteEventButton');

    const addEvent = document.getElementById('addEvent');
    const addEventContent = document.getElementById('addEventContent');

    // écouteurs d'événements pour les onglets

    editEventTypes.addEventListener('click', function () {
        deleteEventContent.classList.add('d-none');
        deleteEvent.classList.remove('active-tab');

        addEventContent.classList.add('d-none');
        addEvent.classList.remove('active-tab');

        editEventTypesContent.classList.remove('d-none');
        editEventTypes.classList.add('active-tab');

    });

    deleteEvent.addEventListener('click', function () {
        editEventTypesContent.classList.add('d-none');
        editEventTypes.classList.remove('active-tab');

        addEventContent.classList.add('d-none');
        addEvent.classList.remove('active-tab');

        deleteEventContent.classList.remove('d-none');
        deleteEvent.classList.add('active-tab');

    });

    addEvent.addEventListener('click', function () {
        editEventTypesContent.classList.add('d-none');
        editEventTypes.classList.remove('active-tab');

        deleteEventContent.classList.add('d-none');
        deleteEvent.classList.remove('active-tab');

        addEventContent.classList.remove('d-none');
        addEvent.classList.add('active-tab');
    });

    // Gestion des localStorage et des onglets actifs pour les recharger après un refresh

    deleteEventButton.addEventListener('click', function () {
        localStorage.setItem('ongletActif', 'deleteEvent');
    })

    if (localStorage.getItem('ongletActif') == 'deleteEvent') {
        editEventTypesContent.classList.add('d-none');
        editEventTypes.classList.remove('active-tab');

        addEventContent.classList.add('d-none');
        addEvent.classList.remove('active-tab');

        deleteEventContent.classList.remove('d-none');
        deleteEvent.classList.add('active-tab');

        localStorage.setItem('ongletActif', '');
    }

    editEventTypesButton.addEventListener('click', function () {
        localStorage.setItem('ongletActif', 'editEventTypes');
    })

    editEventTypesButton2.addEventListener('click', function () {
        localStorage.setItem('ongletActif', 'editEventTypes');
    })

    if (localStorage.getItem('ongletActif') == 'editEventTypes') {
        deleteEventContent.classList.add('d-none');
        deleteEvent.classList.remove('active-tab');

        addEventContent.classList.add('d-none');
        addEvent.classList.remove('active-tab');

        editEventTypesContent.classList.remove('d-none');
        editEventTypes.classList.add('active-tab');

        localStorage.setItem('ongletActif', '');
    }

    if (localStorage.getItem('ongletActif') == 'addEvent') {
        editEventTypesContent.classList.add('d-none');
        editEventTypes.classList.remove('active-tab');

        deleteEventContent.classList.add('d-none');
        deleteEvent.classList.remove('active-tab');

        addEventContent.classList.remove('d-none');
        addEvent.classList.add('active-tab');

        localStorage.setItem('ongletActif', '');
    }
}

////// ARTICLES //////

if (document.getElementById('addNews')) {
    const addNews = document.getElementById('addNews');
    const addNewsContent = document.getElementById('addNewsContent');
    const addNewsButton = document.getElementById('addNewsButton');

    const editNewsTypes = document.getElementById('editNewsTypes');
    const editNewsTypesContent = document.getElementById('editNewsTypesContent');
    const editNewsTypesButton = document.getElementById('editNewsTypesButton');
    const editNewsTypesButton2 = document.getElementById('editNewsTypesButton2');

    const deleteNews = document.getElementById('deleteNews');
    const deleteNewsContent = document.getElementById('deleteNewsContent');
    const deleteNewsButton = document.querySelectorAll('.deleteNewsButton');

    // écouteurs d'événements pour les onglets

    addNews.addEventListener('click', function () {
        editNewsTypesContent.classList.add('d-none');
        editNewsTypes.classList.remove('active-tab');

        deleteNewsContent.classList.add('d-none');
        deleteNews.classList.remove('active-tab');

        addNewsContent.classList.remove('d-none');
        addNews.classList.add('active-tab');
    });

    editNewsTypes.addEventListener('click', function () {
        addNewsContent.classList.add('d-none');
        addNews.classList.remove('active-tab');

        deleteNewsContent.classList.add('d-none');
        deleteNews.classList.remove('active-tab');

        editNewsTypesContent.classList.remove('d-none');
        editNewsTypes.classList.add('active-tab');
    });

    deleteNews.addEventListener('click', function () {
        editNewsTypesContent.classList.add('d-none');
        editNewsTypes.classList.remove('active-tab');

        addNewsContent.classList.add('d-none');
        addNews.classList.remove('active-tab');

        deleteNewsContent.classList.remove('d-none');
        deleteNews.classList.add('active-tab');
    });

    // Gestion des localStorage et des onglets actifs pour les recharger après un refresh

    addNewsButton.addEventListener('click', function () {
        localStorage.setItem('ongletActif', 'addNews');
    })

    if (localStorage.getItem('ongletActif') == 'addNews') {
        editNewsTypesContent.classList.add('d-none');
        editNewsTypes.classList.remove('active-tab');

        deleteNewsContent.classList.add('d-none');
        deleteNews.classList.remove('active-tab');

        addNewsContent.classList.remove('d-none');
        addNews.classList.add('active-tab');

        localStorage.setItem('ongletActif', '');
    }

    editNewsTypesButton.addEventListener('click', function () {
        localStorage.setItem('ongletActif', 'editNewsTypes');
    })

    editNewsTypesButton2.addEventListener('click', function () {
        localStorage.setItem('ongletActif', 'editNewsTypes');
    })

    if (localStorage.getItem('ongletActif') == 'editNewsTypes') {
        addNewsContent.classList.add('d-none');
        addNews.classList.remove('active-tab');

        deleteNewsContent.classList.add('d-none');
        deleteNews.classList.remove('active-tab');

        editNewsTypesContent.classList.remove('d-none');
        editNewsTypes.classList.add('active-tab');

        localStorage.setItem('ongletActif', '');
    }
    if (document.querySelector('.deleteNewsButton')) {
        console.log('ok');
        deleteNewsButton.forEach(function (element) {
            element.addEventListener('click', function () {
                localStorage.setItem('ongletActif', 'deleteNews');
            })
        })
    }

    if (localStorage.getItem('ongletActif') == 'deleteNews') {
        editNewsTypesContent.classList.add('d-none');
        editNewsTypes.classList.remove('active-tab');

        addNewsContent.classList.add('d-none');
        addNews.classList.remove('active-tab');

        deleteNewsContent.classList.remove('d-none');
        deleteNews.classList.add('active-tab');

        localStorage.setItem('ongletActif', '');
    }


}

////// FICHIERS //////

if (document.getElementById('addFile')) {

    const addFile = document.getElementById('addFile');
    const addFileContent = document.getElementById('addFileContent');

    const editFile = document.getElementById('editFile');
    const editFileContent = document.getElementById('editFileContent');
    const editFileButton = document.querySelector('.editFileButton');
    const editFileButton2 = document.querySelector('.editFileButton2');

    // écouteurs d'événements pour les onglets

    addFile.addEventListener('click', function () {
        editFileContent.classList.add('d-none');
        editFile.classList.remove('active-tab');

        addFileContent.classList.remove('d-none');
        addFile.classList.add('active-tab');
    });

    editFile.addEventListener('click', function () {
        addFileContent.classList.add('d-none');
        addFile.classList.remove('active-tab');

        editFileContent.classList.remove('d-none');
        editFile.classList.add('active-tab');
    });

    // Gestion des localStorage et des onglets actifs pour les recharger après un refresh

    if (document.querySelector('.editFileButton')) {
        editFileButton.addEventListener('click', function () {
            localStorage.setItem('ongletActif', 'editFile');
        })
    }

    if (document.querySelector('.editFileButton2')) {
        editFileButton2.addEventListener('click', function () {
            localStorage.setItem('ongletActif', 'editFile');
        })
    }

    if (localStorage.getItem('ongletActif') == 'editFile') {
        addFileContent.classList.add('d-none');
        addFile.classList.remove('active-tab');

        editFileContent.classList.remove('d-none');
        editFile.classList.add('active-tab');

        localStorage.setItem('ongletActif', '');
    }
}