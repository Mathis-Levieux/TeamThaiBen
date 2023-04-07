<?php

class Database
{

    private static object $_pdo; // nous définissons une propriété statique privée nommée $_pdo


    /** 
     * Connection à la base de données
     * @return object
     */
    public static function connect(): object // nous définissons une méthode statique publique qui retourne un objet PDO
    {
        try {
            self::$_pdo = new PDO(DSN, USER, PASSWORD);
            self::$_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return self::$_pdo;
        } catch (PDOException $e) { // nous attrapons l'exception PDOException et nous l'affichons
            echo $e->getMessage();
        }
    }
}
