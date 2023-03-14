<?php

class Albums
{
    private $_db;

    public function __construct()
    {
        $this->_db = database::connect();
    }

    public function getAlbumsById($id) // On crée une méthode qui prend en paramètre $id et qui retourne un tableau associatif
    {
        $sql = "SELECT * 
        FROM sk_photos 
        INNER JOIN sk_albums_contains_photos 
        ON sk_photos.photos_id = sk_albums_contains_photos.photos_id 
        INNER JOIN sk_albums 
        ON sk_albums_contains_photos.albums_id = sk_albums.albums_id 
        WHERE sk_albums.albums_id = :id
        ";
        $query = $this->_db->prepare($sql);
        $query->execute([
            'id' => $id
        ]);
        $album = $query->fetchAll(PDO::FETCH_ASSOC); // On stocke le résultat dans la variable $album
        json_encode($album); // On encode en JSON
        return $album; // On retourne le résultat
    }


    public function getAlbumNameById($id) // On crée une méthode qui prend en paramètre $id et qui retourne un tableau associatif
    {
        $sql = "SELECT albums_name FROM sk_albums WHERE albums_id = :id";
        $query = $this->_db->prepare($sql);
        $query->execute([
            'id' => $id
        ]);
        $albumName = $query->fetch(PDO::FETCH_ASSOC); // On stocke le résultat dans la variable $albumName
        return $albumName; // On retourne le résultat
    }

    public function getAlbumsByName($name) // On crée une méthode qui prend en paramètre $name et qui retourne un tableau associatif
    {
        $sql = "SELECT * FROM sk_albums WHERE albums_name = :name";
        $query = $this->_db->prepare($sql);
        $query->execute([
            'name' => $name
        ]);
        $album = $query->fetch(PDO::FETCH_ASSOC); // On stocke le résultat dans la variable $album
        return $album; // On retourne le résultat
    }

    public function getAlbums() // On crée une méthode qui retourne un tableau associatif
    {
        $sql = "SELECT * FROM sk_albums";
        $query = $this->_db->prepare($sql);
        $query->execute();
        $albums = $query->fetchAll(PDO::FETCH_ASSOC); // On stocke le résultat dans la variable $albums
        return $albums; // On retourne le résultat
    }



    public function createNewAlbum($name)
    {
        $sql = "INSERT INTO sk_albums (albums_name) VALUES (:name)";
        $query = $this->_db->prepare($sql);
        $query->execute([
            'name' => $name
        ]);
    }

    public function deleteAlbum($id)
    {   // Supprime les photos de la table intermédiaire
        $sql = "DELETE FROM sk_albums_contains_photos WHERE albums_id = :id";
        $query = $this->_db->prepare($sql);
        $query->execute([
            'id' => $id
        ]);
        // Supprimer l'album de la table albums
        $sql = "DELETE FROM sk_albums WHERE albums_id = :id";
        $query = $this->_db->prepare($sql);
        $query->execute([
            'id' => $id
        ]);
        // Supprimer les photos de la table photos
        $sql = "DELETE FROM sk_photos WHERE photos_id NOT IN (SELECT photos_id FROM sk_albums_contains_photos)";
        $query = $this->_db->prepare($sql);
        $query->execute();
    }

    public function showPhotosFromAlbum($id)
    {
        $sql = "SELECT * FROM sk_photos WHERE photos_id IN (SELECT photos_id FROM sk_albums_contains_photos WHERE albums_id = :id)";
        $query = $this->_db->prepare($sql);
        $query->execute([
            'id' => $id
        ]);
        $photos = $query->fetchAll(PDO::FETCH_ASSOC);
        return $photos;
    }

    public function modifyAlbumName($name, $id)
    {
        $sql = "UPDATE sk_albums SET albums_name = :name WHERE albums_id = :id";
        $query = $this->_db->prepare($sql);
        $query->execute([
            'name' => $name,
            'id' => $id
        ]);
    }
}
