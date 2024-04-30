<?php

/**
 * ***********************************************
 *  Fichier de fonctions catégorisées comme outils
 * ***********************************************
 */

/**
 * Génération de nombre aléatoire
 * 
 * @param int $e 
 * @return string 
 */
function T_RandNumber($e = 4)
{
    $nrand = '';
    for($i=0;$i<$e;$i++)
    {
        $nrand .= mt_rand(1, 9);
    }
   
    return $nrand;
}

/**
 * Affichage d'un tableau
 * 
 * @param mixed $data 
 * @param mixed $tile 
 * @return void 
 */
function T_Printr($data, $tile = null){
    if($tile)
        echo '<h2>'.$tile.'</h2>';
    
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}