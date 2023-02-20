<?php

class Photos
{

    private int $_id;
    private string $_name;
    private string $_path;
    private int $_albumId;

    private object $_pdo;

    // nous avons besoin d'un constructeur pour instancier la connexion à la base de données
    public function __construct($name, $path, $albumId)
    {
        $this->_name = $name;
        $this->_path = $path;
        $this->_albumId = $albumId;
        $this->_pdo = Database::connect();
    }

    // methode magique pour get les attributs
    public function __get($attribut)
    {
        return $this->$attribut;
    }

    // methode magique pour set les attributs
    public function __set($attribut, $value)
    {
        $this->$attribut = $value;
    }



    public function uploadPhoto()
    {
        // nous préparons la requête
        $query = $this->_pdo->prepare('INSERT INTO sk_photos (photos_name, photos_path) VALUES (:name, :path)');

        // nous executons la requête
        $query->execute([
            ':name' => $this->_name,
            ':path' => $this->_path,
        ]);

        // Nous préparons la requête pour ajouter l'id de la photo dans la table albums_contains_photos
        $query = $this->_pdo->prepare('INSERT INTO sk_albums_contains_photos (albums_id, photos_id) VALUES (:albumId, :photoId)');

        // nous executons la requête
        $query->execute([
            ':albumId' => $this->_albumId,
            ':photoId' => $this->_pdo->lastInsertId()
        ]);
    }


    public function deletePhoto()
    {
        // nous préparons la requête
        $query = $this->_pdo->prepare('DELETE FROM sk_photos WHERE id = :id');

        // nous executons la requête
        $query->execute([
            ':id' => $this->_id
        ]);
    }
}
