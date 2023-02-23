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

    public function addNewEvent()
    {
        if (isset($_POST['submitNewEvent'])) {
            if (empty($_POST['newEventTitle'])) {
                var_dump($_POST['newEventTitle']);
                echo 'Veuillez remplir le champ';
                $errors['NewEventTitle'] = 'Veuillez remplir le champ';
            }
            if (empty($_POST['newEventDesc'])) {
                echo 'Veuillez remplir le champ';
                $errors['newEventDesc'] = 'Veuillez remplir le champ';
            }
            if (empty($_POST['newEventDate'])) {
                echo 'Veuillez remplir le champ';
                $errors['newEventDate'] = 'Veuillez remplir le champ';
            }
            if (empty($_POST['newEventHour'])) {
                echo 'Veuillez remplir le champ';
                $errors['newEventHour'] = 'Veuillez remplir le champ';
            }
            if (empty($_POST['newEventType'])) {
                echo 'Veuillez remplir le champ';
                $errors['newEventType'] = 'Veuillez remplir le champ';
            }

            if (!isset($errors)) {
                $newEvent = new Events();
                $newEvent->addNewEvent($_POST['newEventTitle'], $_POST['newEventDesc'], $_POST['newEventDate'], $_POST['newEventHour'], $_POST['newEventType']);
                $message = 'L\'événement a bien été ajouté';
            }
        }
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

// Utilisation de la méthode pour ajouter un nouvel événement

if (isset($_POST['submitNewEvent'])) {
    $newEvent = new EventsController();
    $newEvent->addNewEvent();
}














include('../views/dashboard-events.php');
