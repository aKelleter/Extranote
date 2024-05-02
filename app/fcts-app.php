<?php
/**
 * ******************************************************************
 *  Fichier de fonctions destinées au fonctionnement de l'application
 * ******************************************************************
 */

/**
 * Affichage du formulaire d'ajout de note
 * 
 * @return string 
 */
function HTMLFormAddNewNote(){
    $html = '
            <div class="row">
                <div class="col-12">                    
                    <h1 class="mb-3 appMainColor appPageTitle">Nouvelle note</h1>   
                </div>
            </div> 
            <div class="row">
                <div class="col-12">                    
                
                    <form id="form_add_note" action="index.php" method="post">
                        <div class="mb-3 form-group">
                            <label for="title_note" class="form-label appLabel">Titre</label>
                            <input type="text" class="form-control" name="title_note" ide="title_note" placeholder="Title" required>
                        </div>
                        <div class="mb-3 form-group">
                            <label for="type_note" class="form-label appLabel">Type</label>
                            <select name="type_note" id="type_note" class="form-control" required>
                                <option value="note">Note textuelle</option>
                                <option value="code">Code Source</option>
                                <option value="lien">Lien / Url</option>
                            </select>
                        </div>
                        <div class="mb-3 form-group">                                                   
                            <input class="form-check-input" type="checkbox" value="1" id="favori_note" name="favori_note">
                            <label class="form-check-label" for="favori_note">Ajouter aux favoris</label>
                        </div>    
                        <div class="mb-3 form-group">
                            <label for="content" class="form-label appLabel" id="label_content_note">Contenu</label>
                            <textarea name="content_note" id="content_note"class="form-control" placeholder="Content" rows="10" required></textarea>
                        </div>
                        <input type="hidden" name="action" value="addnote">
                        <button type="submit" class="btn btn-outline-success">Ajouter</button>
                    </form>
                    
                </div>
            </div>';

    return $html;
}
/**
 * Affichage de la liste des favoris
 * 
 * @param mixed $list 
 * @return string 
 */
function HTMLViewListFavorites()
{
    // Intialisation des variables
    $notes = '';
    $sortedNotes = '';
    $html = '';

    // Acquisition et tri des notes
    $notes = GETArrayNotes();
    $sortedNotes = GETNotesSortedBy($notes, SORT_BY_FAVORIS);
        
    $html = '
    <hr>
    <div class="row">
        <div class="col-12">                    
            <h1 class="mb-3 appMainColor appPageTitle">Favoris <img src="assets/img/section.png"></h1>   
        </div>
    </div>
    <div class="row">
        <div class="col-12">                     
            <div>';
        if(empty($sortedNotes)){
            $html .= '<div class="alert alert-success text-center">Aucun favoris pour le moment</div>';
        }else{                    
            foreach($sortedNotes as $note)
            {                
                    $html .= '  
                    <a href="index.php?page=view&file='.$note['filename'].'" class="appNoteBox">
                        <div class="row appNote" alt="Lire">                            
                                <div class="col-12">
                                    <span class="badge text-bg-secondary">'.$note['type'].'</span>                     
                                    <h2 class="mb-3 appMainColor">'.$note['title'].'</h2>                                                     
                                </div>
                        </div>
                    </a>';               
            }
        }
        $html .='</div></div></div>';
    return $html;
}

/**
 * Affichage de la liste des notes sur la page d'accueil
 * 
 * @return string 
 */
function HTMLViewListNotes($sorted_by, $order){

    // Intialisation des variables
    $notes = '';
    $sortedNotes = '';
    $html = '';

    // Acquisition et tri des notes
    $notes = GETArrayNotes();
    $sortedNotes = GETNotesSortedBy($notes, $sorted_by, $order);
    //DEBUG// T_Printr($sortedNotes, 'HTMLListNotes'); die();

    $html = '
    <div class="row">
        <div class="col-12">                    
            <h1 class="mb-3 appMainColor appPageTitle">Notes <img src="assets/img/section.png"></h1>   
        </div>
    </div>'
        .HTMLInsertFormSortNote($sorted_by, $order).'
    <div class="row">
        <div class="col-12">                     
            <div>';
            if(empty($sortedNotes)){
                $html .= '<div class="alert alert-success text-center">Aucune note pour le moment</div>';
            }else{                    
                foreach($sortedNotes as $note){
                    $html .= ' 
                    <a href="index.php?page=view&file='.$note['filename'].'" class="appNoteBox">
                        <div class="row appNote">
                            
                                <div class="col-12">
                                    <span class="badge text-bg-secondary">'.$note['type'].'</span>                     
                                    <h2 class="mb-3 appMainColor">'.$note['title'].'</h2> 
                                    <small>'.$note['date'].'</small>                                                  
                                </div>
                        </div>
                    </a>';
                }
            }
            $html .='</div>
        </div>
    </div>';           

    return $html;
}   

/**
 * Affichage d'un message
 * 
 * @param mixed $msg 
 * @param string $type 
 * @return string 
 */
function HTMLInsertMessage($msg, $type = 'info')
{
    $html = '
        <div class="row">
            <div class="col-12">  
            <div id="message"></div>
                <script>
                let div = document.createElement("div");
                div.className = "alert alert-'.$type.' text-center";
                div.innerHTML = "'.$msg.'";        
                message.append(div);
                setTimeout(() => message.remove(), 2000);
                </script>
            </div>
        </div>
    '; 
    
    return $html;
}

/**
 * Affichage une boite de confirmation
 * 
 * @return string 
 */
function HTMLInsertConfirmationBox($msg)
{
    $html = '
    <div class="row">
        <div class="col-12 text-center">  
            <div class="alert alert-warning">'.$msg.'</div>
            <a href="index.php?page=home" class="btn btn-outline-success">Annuler</a>
            <a href="index.php?page=delete&file='.$_GET['file'].'" class="btn btn-outline-danger">Confirmer</a>
        </div>                     
    </div>
    '; 
    
    return $html;
}

/**
 * Affichage du menu de navigation
 * 
 * @return string 
 */
function HTMLInsertMenu(){
    $html = '<div class="row">
                <div class="col-12 text-center">      
                    <a href="index.php">Home</a> -
                    <a href="index.php?page=addnote">Ajouter</a>
                </div>
            </div>';            

    return $html;
}

/**
 * Affichage ddu Footer
 * 
 * @return string 
 */
function HTMLInsertFooter(){
    $html = '<footer class="appFooter">
                <div class="container">
                    <div class="row">
                        <div class="col-12 text-center">
                        <hr>
                            <p>ExtraNote - 2024 - v'.APP_VERSION.' - '.APP_DATE_UPDATE.'</p>
                        </div>
                    </div>
                </div>
            </footer>';

    return $html;
}

/**
 * Affichage de la bannièreµ
 * 
 * @return string 
 */
function HTMLInsertBanner(){
    $html = '<div class="row">
                <div class="col-12 text-center">      
                <h1><img src="assets/img/banner.png" class="img-fluid" alt="Logo Extra Note">'.APP_NAME.'</h1>
                </div>
            </div>';            

    return $html;
}

/**
 * Affichage de l'entête
 * 
 * @return string 
 */
function HTMLInsertHeader(){
    $html = '
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="assets/css/styles.css">
        <title>'.APP_TITLE.'</title>
    </head>';

    return $html;
}

/**
 * Affichage d'un favori
 * 
 * @param mixed $favori 
 * @return string 
 */
function HTMLViewNote($file)
{
    $note = json_decode(file_get_contents($file), true);
    $note = $note[0];
    //DEBUG//T_Printr($note, 'note');

    if(!$note)
        return '<div class="alert alert-danger text-center">Note introuvable</div>';

    $html = '<div class="row">
                <div class="col-4 appViewNote">                    
                    <h1 class="mb-3 appMainColor appPageTitle">'.$note['title'].'</h1>  
                    <hr>
                    <h6 class="mb-3 appMainColor"><span class=""><span class="badge">'.$note['type'].'</span></h6> 
                    <h6 class="mb-3 appMainColor"><span class="">'.$note['date'].'</span></h6>
                    <a href="index.php?page=confirm&file='.$note['filename'].'" class="btn btn-outline-danger btn-sm btn-note-delete" title="Supprimer"> X </a>
                </div>   
                <div class="col-1"></div> 
                <div class="col-7 appViewNote">                     
                    <div>
                        <p>'.$note['content'].'</p>
                    </div>
                </div>
            </div>';
    return $html;
}

/**
 * Affichage du formulaire de tri des notes
 * 
 * @param string $sorted_by 
 * @return string 
 */
function HTMLInsertFormSortNote($sorted_by = SORT_BY_DEFAULT, $sort_order = SORT_ORDER_DEFAULT){
    
    // Gestion du selected du select
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
    
    $html = '
    <form id="form_sort_note" method="post">       
        <label for="sort_note" class="label_sort_note">Trier par</label>
        <select name="sort_note" id="sort_note" class="select_sort_note">
            <option value="'.SORT_BY_DATE.'" '.$selected[SORT_BY_DATE].'>Date</option>
            <option value="'.SORT_BY_TITLE.'" '.$selected[SORT_BY_TITLE].'>Titre</option>
            <option value="'.SORT_BY_TYPE.'" '.$selected[SORT_BY_TYPE].'>Type</option>
            <option value="'.SORT_BY_FAVORIS.'" '.$selected[SORT_BY_FAVORIS].'>Favoris</option>
        </select> 
        <select name="sort_order" id="sort_order" class="select_sort_order">
            <option value="'.SORT_ORDER_ASC.'" '.$selected_order[SORT_ORDER_ASC].'>Asc</option>
            <option value="'.SORT_ORDER_DESC.'" '.$selected_order[SORT_ORDER_DESC].'>Desc</option>           
        </select>               
        <!--<button type="submit" class="btn btn-outline-success">Trier</button>-->
    </form>
    ';
    
    return $html;
}

/**
 * Récupération de la liste des notes
 * 
 * @return array|empty
 */
function GETArrayNotes(){
    $files = glob(NOTES_DIR.'/*.json');    
    $notes = [];

    if(file_exists(NOTES_DIR))
    {
        foreach($files as $file){
            $notes = array_merge($notes, json_decode(file_get_contents($file), true));
        }
    }

    return $notes;
}

/**
 * Système de tri des notes
 * 
 * @param string $term 
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
 * Affichage de la liste des notes
 * 
 * @param mixed $title 
 * @param mixed $content 
 * @return void 
 */
function ADDNewNoteToFile($title, $content, $type, $favoris){
    
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

    // Traitement du contenu en fonction du type
    switch($type){        
        case 'code':
            $note[0]['content'] = '<pre><code>'.$note[0]['content'].'</code></pre>';
            break;
        case 'lien':
            $note[0]['content'] = '<a href="'.$note[0]['content'].'" target="_blank">'.$note[0]['content'].'</a>';
            break;
    }   
    
    if(file_exists(NOTES_DIR))
        $result = file_put_contents($filename, json_encode($note));
    
    return $result;
}

/**
 * Suppression d'une note
 * 
 * @param mixed $file 
 * @return bool 
 */
function DELETENoteFile($file){
    return unlink($file);
}

