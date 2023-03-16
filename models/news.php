<?php

class News
{
    private object $_db;

    public function __construct()
    {
        $this->_db = Database::connect();
    }

    public function addNewsType($name)
    {
        $query = $this->_db->prepare('INSERT INTO sk_news_types (news_type) VALUES (:name)');
        $query->execute([
            'name' => $name
        ]);
    }

    public function getNewsTypes()
    {
        $query = $this->_db->prepare('SELECT * FROM sk_news_types');
        $query->execute();
        $newsTypes = $query->fetchAll(PDO::FETCH_ASSOC);
        return $newsTypes;
    }

    public function deleteNewsType(int $id): void
    {
        $query = $this->_db->prepare('DELETE FROM sk_news_types WHERE news_type_id = :id');
        $query->execute([
            'id' => $id
        ]);
    }
}
