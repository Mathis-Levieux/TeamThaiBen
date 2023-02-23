<?php

class Photos
{

    private int $_id;
    private string $_name;
    private string $_path;
    private string $_albumId;

    private object $_pdo;

    public function __construct()
    {
        $this->_pdo = Database::connect();
    }

    public function createPhoto($name, $path, $albumId)
    {
        $this->_name = $name;
        $this->_path = $path;
        $this->_albumId = $albumId;
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

    public function getPhotoById($id)
    {
        // nous préparons la requête
        $query = $this->_pdo->prepare('SELECT * FROM sk_photos WHERE photos_id = :id');

        // nous executons la requête
        $query->execute([
            ':id' => $id
        ]);

        // nous retournons le résultat
        return $query->fetch();
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


    public function deletePhoto($id)
    {
        // Nous préparons la requête pour supprimer l'id de la photo dans la table albums_contains_photos
        $query = $this->_pdo->prepare('DELETE FROM sk_albums_contains_photos WHERE photos_id = :id');

        // nous executons la requête
        $query->execute([
            ':id' => $id
        ]);
        
        // nous préparons la requête
        $query = $this->_pdo->prepare('DELETE FROM sk_photos WHERE photos_id = :id');

        // nous executons la requête
        $query->execute([
            ':id' => $id
        ]);

    }
}
