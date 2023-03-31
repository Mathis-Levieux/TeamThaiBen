<?php


class Files
{
    private object $db;
    private string $files_name;
    private int $files_id;
    private int $files_show;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function uploadFile($name): void
    {
        $sql = "INSERT INTO sk_files (files_name) VALUES (:name)";
        $query = $this->db->prepare($sql);
        $query->execute([
            'name' => $name
        ]);
    }

    public function deleteFile($id): void
    {
        $sql = "DELETE FROM sk_files WHERE files_id = :id";
        $query = $this->db->prepare($sql);
        $query->execute([
            'id' => $id
        ]);
    }

    public function getAllFiles(): array
    {
        $sql = "SELECT * FROM sk_files";
        $query = $this->db->prepare($sql);
        $query->execute();
        $files = $query->fetchAll(PDO::FETCH_ASSOC);
        return $files;
    }

    public function getFileById($id)
    {
        $sql = "SELECT * FROM sk_files WHERE files_id = :id";
        $query = $this->db->prepare($sql);
        $query->execute([
            'id' => $id
        ]);
        $file = $query->fetch(PDO::FETCH_ASSOC);
        return $file;
    }

    public function changeFileBoolean($id, $boolean): void
    {
        $sql = "UPDATE sk_files SET files_show = :boolean WHERE files_id = :id";
        $query = $this->db->prepare($sql);
        $query->bindValue(':boolean', $boolean, PDO::PARAM_BOOL);
        $query->bindValue(':id', $id, PDO::PARAM_INT);
        $query->execute();
    }

    public function getFilesToShow(): array | bool
    {
        $sql = "SELECT * FROM sk_files WHERE files_show = 1";
        $query = $this->db->prepare($sql);
        $query->execute();
        $files = $query->fetchAll(PDO::FETCH_ASSOC);
        return $files;
    }
}
