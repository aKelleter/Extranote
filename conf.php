<?php

// Constantes génériques de l'application
const APP_VERSION = '0.11.0';
const APP_DATE_UPDATE = '03/05/2024 16:35';
const APP_NAME = 'ExtraNote';
const APP_TITLE = 'ExtraNote - Gestionnaire de notes';


// Constante du répertoire de stockage des notes
const NOTES_DIR = 'notes';

// Constantes des types de notes
const NOTE_TYPES = ['note' => 'Note textuelle', 'code' => 'Code Source', 'lien' => 'Lien / Url'];

// Constantes de tri
const SORT_BY_DATE = 'date';
const SORT_BY_TITLE = 'title';
const SORT_BY_TYPE = 'type';
const SORT_BY_FAVORIS = 'favoris';
// Tri par défaut
const SORT_BY_DEFAULT = SORT_BY_DATE;
// Ordre de tri : Ascendant et descendant
const SORT_ORDER_ASC = 'asc';
const SORT_ORDER_DESC = 'desc';
// Ordre de tri par défaut
const SORT_ORDER_DEFAULT = SORT_ORDER_DESC;



// Liste des notes
/*
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
*/