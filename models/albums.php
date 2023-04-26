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
        NATURAL JOIN sk_albums_contains_photos 
        NATURAL JOIN sk_albums 
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

    /**
     * Récupère le nom d'un album en fonction de son id
     * @param int $id
     * @return string
     */
    public function getAlbumNameById(int $id)
    {
        $sql = "SELECT albums_name FROM sk_albums WHERE albums_id = :id";
        $query = $this->_db->prepare($sql);
        $query->execute([
            'id' => $id
        ]);
        $albumName = $query->fetch(PDO::FETCH_COLUMN);
        return $albumName;
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


    /**
     * Récupère tous les albums
     * @return array
     */
    public function getAlbums()
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

    public function modifyAlbumName(string $name, int $id): void
    {
        $sql = "UPDATE sk_albums SET albums_name = :name WHERE albums_id = :id";
        $query = $this->_db->prepare($sql);
        $query->execute([
            'name' => $name,
            'id' => $id
        ]);
    }
}
