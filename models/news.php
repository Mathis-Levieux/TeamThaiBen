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

    public function addNews(string $title, string $content, int $type, string $date): void
    {
        $query = $this->_db->prepare('INSERT INTO sk_news (news_title, news_content, news_type_id, news_date) VALUES (:title, :content, :type, :date)');
        $query->execute([
            'title' => $title,
            'content' => $content,
            'type' => $type,
            'date' => $date

        ]);
    }

    public function getNews(): array
    {
        $query = $this->_db->prepare('SELECT * FROM sk_news');
        $query->execute();
        $news = $query->fetchAll(PDO::FETCH_ASSOC);
        return $news;
    }

    public function getNewsById(int $id): array | bool
    {
        $query = $this->_db->prepare('SELECT * FROM sk_news WHERE news_id = :id');
        $query->execute([
            'id' => $id
        ]);
        $news = $query->fetch(PDO::FETCH_ASSOC);
        return $news;
    }

    public function deleteNews(int $id): void
    {
        $query = $this->_db->prepare('DELETE FROM sk_news WHERE news_id = :id');
        $query->execute([
            'id' => $id
        ]);
    }
}
