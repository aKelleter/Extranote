<?php
/**
 * ***********************************************
 *  Fonction outils de l'application
 * ***********************************************
 */

/**
 * Génération d'un nombre aléatoire
 * Un nombre aléatoire de 4 chiffres par défaut
 * 
 * @param int $e 
 * @return string 
 */
function T_RandNumber($e = 4) {
    $nrand = '';
    for($i=0;$i<$e;$i++)
    {
        $nrand .= mt_rand(1, 9);
    }
   
    return $nrand;
}

/**
 * Affichage d'un tableau pour le debug de l'application
 * de manière structurée
 * 
 * @param mixed $data 
 * @param mixed $tile 
 * @return void 
 */
function T_Printr($data, $tile = null) {
    if($tile)
        echo '<h2>'.$tile.'</h2>';
    
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}

/**
 * Limiter une chaine de caractères à un nombre de caractères donné
 * 
 * @param mixed $string 
 * @param int $limit 
 * @return mixed 
 */
function T_LimitString($string, $limit = NOTE_TITLE_LIMIT) {
    if(strlen($string) > $limit && $limit > 0)
        return substr($string, 0, $limit).'...';
    else
        return $string;
}