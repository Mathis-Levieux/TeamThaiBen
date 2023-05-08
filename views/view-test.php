<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>


    <button id="loadPhotosBtn">Charger les photos</button>
    <div id="photosContainer"></div>


    <script>
        document.getElementById('loadPhotosBtn').addEventListener('click', loadPhotos);

        function loadPhotos() {
            // Configurer les options de la requête fetch
            const requestOptions = {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    nbPhotos: 5
                })
            };

            // Effectuer la requête fetch
            fetch('../controllers/test.php', requestOptions)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erreur lors de la requête : ' + response.statusText);
                    }
                    return response.text();
                })
                .then(images => {
                    document.getElementById('photosContainer').innerHTML = images;
                })
                .catch(error => {
                    console.error(error);
                });
        };
    </script>
</body>

</html>