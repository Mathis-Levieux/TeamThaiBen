<?php

class Photos
{

    private int $_id;
    private string $_name;
    private string $_desc;

    private object $_pdo;

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

    // nous avons besoin d'un constructeur pour instancier la connexion à la base de données
    public function __construct()
    {
        $this->_pdo = Database::connect();
    }

    /**
     * methode pour récupérer la liste de tous les clients
     *
     * @return array
     */
    public function getAllClients() : array
    {
        // nous préparons la requête
        $query = $this->_pdo->prepare('SELECT * FROM clients');

        // nous executons la requête
        $query->execute();

        // nous retournons le resultat de la requête
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
