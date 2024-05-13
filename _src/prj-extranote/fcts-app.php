<?php
/**
 * ******************************************************************
 *  Fonctions de base de  l'application
 * ******************************************************************
 */

/**
 * Retourne toutes les notes sous la forme d'un tableau de tableaux
 * 
 * Recherche les fichiers "*.json" dans le répertoire des notes passé en paramètre
 * ouvre les contenus de chaque note et les fusionne dans un tableau
 * 
 * @param string $directory 
 * @return array|empty
 */
function GETListAllNotes($directory = NOTES_DIR) {
    $files = glob($directory.'/*.json');    
    $notes = [];

    if(file_exists($directory))
    {
        foreach($files as $file){
            $notes = array_merge($notes, json_decode(file_get_contents($file), true));
        }
    }

    return $notes;
}

/**
 * Système de tri des notes
 * Retourne un tableau de notes triées en fonction des paramètres
 * 
 * @param mixed $listNotes 
 * @param string $term 
 * @param string $order 
 * @return array 
 */
function GETNotesSortedBy($listNotes, $term = SORT_BY_DEFAULT, $order = SORT_ORDER_DEFAULT) {
        
    //Systeme de tri
    switch($term){
        case SORT_BY_DATE:
            if($order == SORT_ORDER_DESC)
                usort($listNotes, function($a, $b) use ($term) {
                    return strtotime($b[$term]) - strtotime($a[$term]);
                });
            else
                usort($listNotes, function($a, $b) use ($term) {
                    return strtotime($a[$term]) - strtotime($b[$term]);
                });
            break;
        case SORT_BY_TITLE:
            if($order == SORT_ORDER_DESC)
                usort($listNotes, function($a, $b) {
                    return strcmp($b['title'], $a['title']);
                });
            else
                usort($listNotes, function($a, $b) {
                    return strcmp($a['title'], $b['title']);
                });
            break;
        case SORT_BY_TYPE:
            if($order == SORT_ORDER_DESC)
                usort($listNotes, function($a, $b) {
                    return strcmp($b['type'], $a['type']);
                });
            else
                usort($listNotes, function($a, $b) {
                    return strcmp($a['type'], $b['type']);
                });
            break;
        case SORT_BY_FAVORIS:
            $listNotes = array_filter($listNotes, function($note){
                return $note['favoris'] == 1;
            });
            break;
    }
   
    return $listNotes;
}


/**
 * Ajout d'une nouvelle note dans un fichier au format JSON
 * 
 * @param mixed $title 
 * @param mixed $content 
 * @param mixed $type 
 * @param mixed $favoris 
 * @return int|false 
 */
function ADDNewNoteToFile($title, $content, $type, $favoris) {
    
    $result = false;
    $filename = NOTES_DIR.'/notes-'.date("d-m-Y").'-'.T_RandNumber(5).'.json';

    $note [] = [
        'title' => $title,
        'content' => $content,
        'type' => $type,
        'favoris' => $favoris,
        'filename' => $filename,
        'date' => date("d-m-Y H:i:s")
    ];      
   
    if(file_exists(NOTES_DIR))
        $result = file_put_contents($filename, json_encode($note));
    
    return $result;
}

/**
 * Supprimer une note = suppression du fichier
 * 
 * @param mixed $file 
 * @return bool 
 */
function DELETENoteFile($file) {
    if(file_exists($file))
        $st = unlink($file);
    else
        $st = false;

    return $st;
}

/**
 * Charger le contenu d'une note au départ du fichier passé en paramètre
 * 
 * @param mixed $file 
 * @return array|false 
 */
function LOADNoteFromFile($file) {    
    // Si le fichier n'existe pas
    if(!file_exists($file))
        return false;

    // Chargement de la note
    $note = json_decode(file_get_contents($file), true);
    $note = $note[0];

    return $note;
}

/**
 * Mise à jour du contenu d'une note dans le fichier
 * 
 * @param mixed $note_record 
 * @return int|false 
 */
function UPDATENoteFile($note_record) {
    $result = false;
    $note [] = [
        'title' => $note_record['title'],
        'content' => $note_record['content'],
        'type' => $note_record['type'],
        'favoris' => $note_record['favoris'],
        'filename' => $note_record['file'],
        'date' => $note_record['date']
    ];

    $result = file_put_contents($note_record['file'], json_encode($note));
    
    return $result;
}

/**
 * Recherche une chaîne de caractères dans le titre ou le contenu des notes
 * Retourne un tableau de notes correspondant à la recherche
 * 
 * @param mixed $listNotes 
 * @param mixed $search 
 * @return array|false 
 */
function SEARCHInNotes($listNotes, $search) {
    $search = strtolower($search);
    $listNotes = array_filter($listNotes, function($note) use ($search){
        return (strpos(strtolower($note['title']), $search) !== false || strpos(strtolower($note['content']), $search) !== false);
    });

    return $listNotes;
}

/**
 * Gestion des valeurs de tri pour l'affichage des liste déroulantes
 * du formulaire de tri des notes 
 * Utilisée dans la fonction d'affichage du formulaire de tri : HTMLInsertFormSortNote()
 * 
 * @param string $sorted_by 
 * @param string $sort_order 
 * @return string[] 
 */
function SORTManager($sorted_by, $sort_order) {

    // Gestion du selected du selected_order 
    $selected = [SORT_BY_DATE => '', SORT_BY_TITLE => '', SORT_BY_TYPE => '', SORT_BY_FAVORIS => ''];

    switch ($sorted_by) {
        case SORT_BY_DATE:
            $selected[SORT_BY_DATE] = 'selected';
            break;
        case SORT_BY_TITLE:  
            $selected[SORT_BY_TITLE] = 'selected'; 
            break;
        case SORT_BY_TYPE:
            $selected[SORT_BY_TYPE] = 'selected';
            break;
        case SORT_BY_FAVORIS:
            $selected[SORT_BY_FAVORIS] = 'selected';
            break;        
    }

    // Gestions des options de tri
    $selected_order = [SORT_ORDER_ASC => '', SORT_ORDER_DESC => ''];

    switch ($sort_order) {
        case SORT_ORDER_ASC:
            $selected_order[SORT_ORDER_ASC] = 'selected';
            break;
        case SORT_ORDER_DESC:  
            $selected_order[SORT_ORDER_DESC] = 'selected'; 
            break;        
    }

    return array('selected' => $selected, 'selected_order' => $selected_order);

}

