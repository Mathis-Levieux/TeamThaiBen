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
}
