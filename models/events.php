<?php

class Events
{
    private object $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function getEvents()
    {
        $sql = "SELECT * FROM sk_events";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEvent($id)
    {
        $sql = "SELECT * FROM sk_events WHERE id = :id";
        $query = $this->db->prepare($sql);
        $query->execute([
            'id' => $id
        ]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function addEventType($name)
    {
        $sql = "INSERT INTO sk_events_types (events_type) VALUES (:name)";
        $query = $this->db->prepare($sql);
        $query->execute([
            'name' => $name
        ]);
    }

    public function getEventTypes()
    {
        $sql = "SELECT * FROM sk_events_types";
        $query = $this->db->prepare($sql);
        $query->execute();
        $eventTypes = $query->fetchAll(PDO::FETCH_ASSOC);
        return $eventTypes;
    }

    public function deleteEventType($id)
    {
        $sql = "DELETE FROM sk_events_types WHERE events_type_id = :id";
        $query = $this->db->prepare($sql);
        $query->execute([
            'id' => $id
        ]);
    }
}
