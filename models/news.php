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

    /**
     * fonction permettant de récupérer toutes les news
     * 
     * @return array
     */
    public function getNews(): array
    {
        $query = $this->_db->prepare('SELECT * FROM sk_news');
        $query->execute();
        $news = $query->fetchAll(PDO::FETCH_ASSOC);
        return $news;
    }

    public function getLastFiveNews(): array
    {
        $query = $this->_db->prepare('SELECT * FROM sk_news ORDER BY news_date DESC LIMIT 5');
        $query->execute();
        $news = $query->fetchAll(PDO::FETCH_ASSOC);
        return $news;
    }


    /**
     * fonction permettant de récupérer une news grâce à son id
     * 
     * @param int $id
     * @return array|bool
     */

    public function getNewsById(int $id): array | bool
    {
        $query = $this->_db->prepare('SELECT * FROM sk_news WHERE news_id = :id');
        $query->execute([
            'id' => $id
        ]);
        $news = $query->fetch(PDO::FETCH_ASSOC);
        return $news;
    }

    public function getLastNews(): array | bool
    {
        $query = $this->_db->prepare('SELECT * FROM sk_news ORDER BY news_date DESC LIMIT 1');
        $query->execute();
        $news = $query->fetch(PDO::FETCH_ASSOC);
        return $news;
    }


    /**
     * fonction permettant de supprimer un article
     * 
     * @param int $id
     * @return void
     * 
     */
    public function deleteNews(int $id): void
    {
        $query = $this->_db->prepare('DELETE FROM sk_news WHERE news_id = :id');
        $query->execute([
            'id' => $id
        ]);
    }

    /**
     * fonction permettant de modifier une news
     * 
     * @param int $id
     * @param string $title
     * @param string $content
     * @param int $type
     * 
     * @return void
     */
    public function modifyNews(int $id, string $title, string $content, int $type): void
    {
        $query = $this->_db->prepare('UPDATE sk_news SET news_title = :title, news_content = :content, news_type_id = :type WHERE news_id = :id');
        $query->execute([
            'id' => $id,
            'title' => $title,
            'content' => $content,
            'type' => $type
        ]);
    }

    /**
     * fonction permettant de récupérer les news triées par date et par id
     * 
     * @return array|bool
     */
    public function getNewsSortedByDateAndId(): array | bool
    {
        $query = $this->_db->prepare('SELECT * FROM sk_news ORDER BY news_date DESC, news_id DESC');
        $query->execute();
        $news = $query->fetchAll(PDO::FETCH_ASSOC);
        return $news;
    }
}
