<?php


class Files
{
    private object $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function uploadFile($name)
    {
        $sql = "INSERT INTO sk_files (files_name) VALUES (:name)";
        $query = $this->db->prepare($sql);
        $query->execute([
            'name' => $name
        ]);
    }

    public function deleteFile($id)
    {
        $sql = "DELETE FROM sk_files WHERE files_id = :id";
        $query = $this->db->prepare($sql);
        $query->execute([
            'id' => $id
        ]);
    }
}
