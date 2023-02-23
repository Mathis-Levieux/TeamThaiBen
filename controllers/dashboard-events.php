<?php

require('../config/env.php');
require('../helpers/Database.php');
require('../models/events.php');

session_start();

if (!isset($_SESSION['login'])) {
    header('Location: controller-login.php');
}



class EventsController // Création d'une classe newEventTypeController pour gérer l'ajout d'un nouveau type d'événement
{
    public function addEventType()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (empty($_POST['NewEventType'])) {
                echo 'Veuillez remplir le champ';
                $errors['NewEventType'] = 'Veuillez remplir le champ';
            } else { // vérifier si le type n'existe pas déjà
                $newEventType = new Events();
                $newEventType = $newEventType->getEventTypes();
                foreach ($newEventType as $eventType) {
                    if ($_POST['NewEventType'] == $eventType['events_type']) {
                        echo 'Ce type d\'événement existe déjà';
                        $errors['NewEventType'] = 'Ce type d\'événement existe déjà';
                    }
                }
                if (!isset($errors)) {
                    $newEventType = new Events();
                    $newEventType->addEventType($_POST['NewEventType']);
                }
            }
        }
    }

    public function showSelectEventType() // Affiche les types d'événements dans un select
    {
        $showSelectEventType = new Events();
        $showSelectEventType = $showSelectEventType->getEventTypes();
        foreach ($showSelectEventType as $eventType) {
            echo '<option value="' . $eventType['events_type_id'] . '">' . $eventType['events_type'] . '</option>';
        }
    }

    public function deleteEventType($id)
    {
        $deleteEventType = new Events();
        $deleteEventType->deleteEventType($id);
    }
}

// Utilisation de la méthode pour ajouter un nouveau type d'événement

if (isset($_POST['submitNewEventType']) && (isset($_POST['NewEventType']))) {
    $newEventType = new EventsController();
    $newEventType->addEventType();
}


// Utilisation de la méthode pour supprimer un type d'événement

if (isset($_POST['deleteEventType']) && isset($_POST['submitDeleteEventType'])) {
    $deleteEventType = new EventsController();
    $deleteEventType->deleteEventType($_POST['deleteEventType']);
    $message = 'Le type d\'événement a bien été supprimé';
}





include('../views/dashboard-events.php');
