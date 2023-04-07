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

    public function getEventTypes() // Récupère tous les types d'événements
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

    public function addNewEvent($name, $desc, $date, $hour, $type)
    {
        $sql = "INSERT INTO sk_events (events_name, events_desc, events_date, events_hour, events_type_id) VALUES (:name, :desc, :date, :hour, :type)";
        $query = $this->db->prepare($sql);
        $query->execute([
            'name' => $name,
            'desc' => $desc,
            'date' => $date,
            'hour' => $hour,
            'type' => $type
        ]);
    }

    public function getEventType($id) // Récupère le type d'événement d'un événement en particulier
    {
        $sql = "SELECT sk_events_types.events_type FROM sk_events_types INNER JOIN sk_events ON sk_events_types.events_type_id = sk_events.events_type_id WHERE sk_events.events_id = :id";
        $query = $this->db->prepare($sql);
        $query->execute([
            'id' => $id
        ]);
        $eventType = $query->fetchAll(PDO::FETCH_ASSOC);
        return $eventType;
    }

    public function deleteEvent($id)
    {
        $sql = "DELETE FROM sk_events WHERE events_id = :id";
        $query = $this->db->prepare($sql);
        $query->execute([
            'id' => $id
        ]);
    }
}
