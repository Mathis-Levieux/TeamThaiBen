<?php

class Database
{

    private static object $_pdo; // nous définissons une propriété statique privée de type PDO

    public static function connect(): object // nous définissons une méthode statique publique qui retourne un objet PDO
    {
        // instanciation de l'objet PDO si il n'existe pas
        self::$_pdo = new PDO(DSN, USER, PASSWORD);

        // nous activons les erreurs PDO et les exceptions PDO
        self::$_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
        // nous retournons l'objet PDO
        return self::$_pdo;
    }
}
