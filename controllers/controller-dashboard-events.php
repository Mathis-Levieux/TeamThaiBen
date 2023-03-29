<?php

require('../config/env.php');
require('../helpers/Database.php');
require('../models/events.php');

session_start();

if (!isset($_SESSION['login'])) {
    header('Location: controller-login.php');
}

$title = 'Administration - Calendrier';

class EventsController // Création d'une classe newEventTypeController pour gérer l'ajout d'un nouveau type d'événement
{
    public array $errors = [];
    public string $success = '';

    public function addEventType()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (empty($_POST['NewEventType'])) {
                $this->errors[] = 'Veuillez remplir le champ';
            } else { // vérifier si le type n'existe pas déjà
                $newEventCheck = new Events();
                $newEventCheck = $newEventCheck->getEventTypes();
                foreach ($newEventCheck as $eventType) {
                    if ($_POST['NewEventType'] == $eventType['events_type']) {
                        $this->errors[] = 'Ce type d\'événement existe déjà';
                    }
                }
                if (empty($this->errors)) {
                    $newEventType = new Events();
                    $newEventType->addEventType($_POST['NewEventType']);
                    $this->success = 'Le type d\'événement a bien été ajouté';
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

    public function deleteEventType()
    {
        if (empty($_POST['deleteEventType'])) {
            $this->errors[] = 'Veuillez sélectionner un type d\'événement à supprimer';
        } else {

            // On vérifie qu'il n'y a pas d'événements de ce type
            $checkEvents = new Events();
            $checkEvents = $checkEvents->getEvents();
            foreach ($checkEvents as $event) {
                if ($_POST['deleteEventType'] == $event['events_type_id']) {
                    $exist = true;
                }
            }
            if (isset($exist)) {
                $this->errors[] = 'Il y a des événements de ce type, veuillez les supprimer avant de supprimer le type';
            }

            if (empty($this->errors)) {
                $deleteEventType = new Events();
                $deleteEventType->deleteEventType($_POST['deleteEventType']);
                $this->success = 'Le type d\'événement a bien été supprimé';
            }
        }
    }

    public function addNewEvent()
    {
        if (isset($_POST['submitNewEvent'])) {
            if (empty($_POST['newEventTitle']) || empty($_POST['newEventDesc'])  || empty($_POST['newEventDate']) || empty($_POST['newEventHour']) || empty($_POST['newEventType'])) {
                $this->errors[] = 'Veuillez remplir tous les champs';
            } else if (!preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $_POST['newEventDate'])) {
                $this->errors[] = 'Le format de la date est incorrect';
            }

            // On vérifie que la date n'est pas passée
            $date = new DateTime($_POST['newEventDate']);
            $date = $date->format('Y-m-d');
            $today = new DateTime();
            $today = $today->format('Y-m-d');
            if ($date < $today) {
                $this->errors[] = 'La date de l\'événement ne peut pas être passée';
            }


            if (empty($this->errors)) {
                $newEvent = new Events();
                $newEvent->addNewEvent($_POST['newEventTitle'], $_POST['newEventDesc'], $_POST['newEventDate'], $_POST['newEventHour'], $_POST['newEventType']);
                $this->success = 'L\'événement a bien été ajouté';
            }
        }
    }

    public function displayEventList()
    {
        $displayEventList = new Events();
        $displayEventList = $displayEventList->getEvents();
        echo '<form action="controller-dashboard-events.php" method="post">';
        echo '<table class="table table-striped table-hover table-bordered">';
        echo '<tbody class="align-middle">';
        echo '<tr>';
        echo '<th scope="col">Titre</th>';
        echo '<th scope="col">Date</th>';
        echo '<th scope="col">Heure</th>';
        echo '<th scope="col">Type</th>';
        echo '<th scope="col">Supprimer</th>';
        echo '</tr>';
        foreach ($displayEventList as $event) {
            // obtenir le nom du type d'événement
            $eventType = new Events();
            $eventType = $eventType->getEventType($event['events_id']); // on récupère le type d'évènement grâce à l'id de l'évènement
            echo '<tr>';
            echo '<td>' . $event['events_name'] . '</td>';
            echo '<td>' . $event['events_date'] . '</td>';
            echo '<td>' . $event['events_hour'] . '</td>';
            echo '<td>' . $eventType[0]['events_type'] . '</td>';
            echo '<td>';
            echo '<div class="btn-group">';
            echo '<input type="checkbox" name="eventsToDelete[]" value="' . $event['events_id'] . '" id="' . $event['events_id'] . '" class="p-2 form-check-input m-auto">';
            echo '</div>';
            echo '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
        echo '<input id="deleteEventButton" type="submit" name="submitDeleteEvents" class="mt-3 btn btn-outline-dark rounded-pill border-2 fw-bold" value="Supprimer">';
        echo '</form>';
    }

    public function deleteEvents()
    {
        if (isset($_POST['submitDeleteEvents'])) {
            if (empty($_POST['eventsToDelete'])) {
                $this->errors[] = 'Veuillez sélectionner au moins un événement à supprimer';
            }
            if (empty($this->errors)) {
                foreach ($_POST['eventsToDelete'] as $eventToDelete) {
                    $deleteEvent = new Events();
                    $deleteEvent->deleteEvent($eventToDelete);
                    $this->success = 'Les événements ont bien été supprimés';
                }
            }
        } else {
            $this->errors[] = 'Veuillez sélectionner au moins un événement à supprimer';
        }
    }

    public function getErrorsMessages(): array
    {
        return $this->errors;
    }

    public function getSuccessMessage(): string
    {
        return $this->success;
    }
}
// Utilisation de la méthode pour ajouter un nouveau type d'événement
if (isset($_POST['submitNewEventType']) && (isset($_POST['NewEventType']))) {
    $newEventType = new EventsController();
    $newEventType->addEventType();
}

// Utilisation de la méthode pour supprimer un type d'événement

if (isset($_POST['submitDeleteEventType'])) {
    $deleteEventType = new EventsController();
    $deleteEventType->deleteEventType();
}

// Utilisation de la méthode pour ajouter un nouvel événement

if (isset($_POST['submitNewEvent'])) {
    $newEvent = new EventsController();
    $newEvent->addNewEvent();
}

// Utilisation de la méthode pour supprimer un ou plusieurs événements

if (isset($_POST['submitDeleteEvents'])) {
    $deleteEvents = new EventsController();
    $deleteEvents->deleteEvents();
}







include('../views/view-dashboard-events.php');
