<?php

// NUméro de version de l'application
const APP_VERSION = '0.8.0';
const APP_DATE_UPDATE = '30/04/2024 16:30';
const APP_NAME = 'ExtraNote';
const APP_TITLE = 'ExtraNote - Gestionnaire de notes';


// Répertoire de stockage des notes
const NOTES_DIR = 'notes';

// Liste des favoris
const APP_NOTES = [
    [
        'title'=>'Charger une image en JS', 
        'type' => 'code',
        'content' => 'let img = new Image(); img.src = "img/ship.png";',
        'favoris' => 0,
        'filename' => 'notes\/notes-29-04-2024-00001.json'
    ],
    [
        'title'=>'Parcourir et trier les items d\'un tableau en JS', 
        'type' => 'code',
        'content' => '
            let personnages = ["Mario", "Luigi", "Peach", "Bowser", "Toad", "Yoshi"]; 
            personnages.sort();
            personnages.forEach(perso => {
            console.log(perso);});',
        'favoris' => 1,
        'filename' => 'notes\/notes-29-04-2024-00002.json'
    ],
    [
        'title'=>'Créer un objet en JS',
        'type' => 'code',       
        'content' => 'let perso = {nom: "Mario", age: 40, taille: 1.50};',
        'favoris' => 1,
        'filename' => 'notes\/notes-29-04-2024-00003.json'
    ],
];