<?php

// Version
const VERSION = '0.5.0';

const FAVORIS = [
    [
        'id' => 1,    
        'title'=>'Charger une image en JS', 
        'type' => 'code',
        'content' => 'let img = new Image(); img.src = "img/ship.png";'
    ],
    [
        'id' => 2,
        'title'=>'Parcourir et trier les items d\'un tableau en JS', 
        'type' => 'code',
        'content' => '
            let personnages = ["Mario", "Luigi", "Peach", "Bowser", "Toad", "Yoshi"]; 
            personnages.sort();
            personnages.forEach(perso => {
            console.log(perso);});'
    ],
    [
        'id' => 3,  
        'type' => 'code',
        'title'=>'Créer un objet en JS',
        'content' => 'let perso = {nom: "Mario", age: 40, taille: 1.50};'
    ],
];