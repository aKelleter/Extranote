<?php

// Constantes génériques de l'application
const APP_NAME = 'ExtraNote';
const APP_TITLE = 'ExtraNote - Gestionnaire de notes';
const APP_VERSION = '1.0.0';
const APP_DATE_UPDATE = '06/05/2024 16:15';

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

// Affiche complètement le titre des notes et favoris (un nombre entier compris entre "1" et "xx". Ou "O" pour afficher le titre complet)
const NOTE_TITLE_LIMIT = 5;
