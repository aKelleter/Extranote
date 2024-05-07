<?php
/**
 * ******************************************************************
 *  Fonctions d'affichages de l'application
 * ******************************************************************
 */

/**
 * Affichage du formulaire d'ajout de note
 * 
 * @return string 
 */
function HTMLFormAddNewNote() {
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
                            <textarea name="content_note" id="content_note" class="form-control" placeholder="Content" rows="10" required></textarea>
                        </div>
                        <input type="hidden" name="action" value="addnote">
                        <button type="submit" class="btn btn-outline-success">Ajouter</button>
                        <a href="index.php" class="btn btn-outline-danger">Annuler</a>
                    </form>
                    
                </div>
            </div>';

    return $html;
}

// Ajouter un fomulaire de modification de note
function HTMLFormEditNote($note) {  
    $html = '
            <div class="row">
                <div class="col-12">                    
                    <h1 class="mb-3 appMainColor appPageTitle">Modifier la note</h1>   
                </div>
            </div> 
            <div class="row">
                <div class="col-12">                    
                
                    <form id="form_edit_note" action="index.php" method="post">
                        <div class="mb-3 form-group">
                            <label for="title_note" class="form-label appLabel">Titre</label>
                            <input type="text" class="form-control" name="title_note" ide="title_note" value="'.$note['title'].'" required>
                        </div>
                        <div class="mb-3 form-group">
                            <label for="type_note" class="form-label appLabel">Type</label>';
                            $html .= '<select name="type_note" id="type_note" class="form-control" required>';

                            foreach(NOTE_TYPES as $key => $value){
                                if($note['type'] == $key)
                                    $html .= '<option value="'.$key.'" selected>'.$value.'</option>';
                                else
                                    $html .= '<option value="'.$key.'">'.$value.'</option>';
                            }
                            $html .= '</select>';
                       
                        $html .= '<div class="mb-3 form-group">';                                                   

                            if($note['favoris'] == 1)
                                $html .= '<input class="form-check-input" type="checkbox" value="1" id="favori_note" name="favori_note" checked>';
                            else
                                $html .= '<input class="form-check-input" type="checkbox" value="1" id="favori_note" name="favori_note">';                         
                            
                        $html .= '
                        <label class="form-check-label" for="favori_note">Ajouter aux favoris</label>
                        </div>
                        <div class="mb-3 form-group">
                            <label for="content" class="form-label appLabel" id="label_content_note">Contenu</label>
                            <textarea name="content_note" id="content_note" class="form-control" placeholder="Content" rows="10" required>'.$note['content'].'</textarea>
                        </div>
                        <input type="hidden" name="action" value="recordnote">
                        <input type="hidden" name="file_note" value="'.$note['filename'].'">
                        <input type="hidden" name="date_note" value="'.$note['date'].'">
                        <button type="submit" class="btn btn-outline-success">Modifier</button>
                        <a href="index.php?page=view&file='.$note['filename'].'" class="btn btn-outline-danger">Annuler</a>
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
function HTMLViewListFavorites() {
    // Intialisation des variables
    $notes = '';
    $sortedNotes = '';
    $html = '';

    // Acquisition et tri des notes
    $notes = GETListAllNotes();
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
                (NOTE_TITLE_LIMIT > 0)?$html .= '<span  data-tooltip ="'.$note['title'].'">':$html .= '';  
                $html .= '<a href="index.php?page=view&file='.$note['filename'].'" class="appNoteBox">
                        <div class="row tuileNote-mini" alt="Lire">                            
                                <div class="col-12">
                                    <span class="badge text-bg-secondary">'.$note['type'].'</span>                     
                                    <p class="mb-3 appMainColor">'.T_LimitString($note['title']).'</p>                                                    
                                </div>
                        </div>';                   
                $html .= '</a>';
                (NOTE_TITLE_LIMIT > 0)?$html .= '</span>':$html .= '';           
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
function HTMLViewListNotes($sortedNotes, $sort_note, $sort_order) {
    //DEBUG// T_Printr($sortedNotes, 'HTMLListNotes');
    $html = '
    <div class="row">
        <div class="col-12">                    
            <h1 class="mb-3 appMainColor appPageTitle">Notes <img src="assets/img/section.png"></h1>   
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">                    
        '.HTMLInsertFormSortNote($sort_note, $sort_order).'      
        </div>
        <div class="col-md-9">                    
        '.HTMLInsertFormSearch().'      
        </div>
    </div>
    <div class="row">
        <div class="col-12">                     
            <div>';
            if(empty($sortedNotes)){
                $html .= '<div class="alert alert-success text-center mt-3">Il n\'y a pas de note à afficher pour l\'instant</div>';
            }else{                    
                foreach($sortedNotes as $note)
            {                
                    (NOTE_TITLE_LIMIT > 0)?$html .= '<span  data-tooltip ="'.$note['title'].'">':$html .= '';  
                    $html .= '<a href="index.php?page=view&file='.$note['filename'].'" class="appNoteBox">
                            <div class="row tuileNote" alt="Lire">                            
                                    <div class="col-12">
                                        <span class="badge text-bg-secondary">'.$note['type'].'</span>                     
                                        <h2 class="mb-3 appMainColor">'.T_LimitString($note['title']).'</h2>
                                        <small>'.$note['date'].'</small>                                                    
                                    </div>
                            </div>';                   
                    $html .= '</a>';
                    (NOTE_TITLE_LIMIT > 0)?$html .= '</span>':$html .= '';                 
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
function HTMLInsertMessage($msg, $type = 'info') {
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
function HTMLInsertDeleteConfirmation($msg) {
    (LOADNoteFromFile($_GET['file']) != false)? $note = LOADNoteFromFile($_GET['file']) : $note = 'Erreur';
    
    if($note == 'Erreur')
        return '<div class="alert alert-danger text-center">Note introuvable <br><a href="index.php">Retour</a></div>';

    $html = '
    <div class="row">
        <div class="col-12 text-center">  
            <div class="alert alert-warning">
                '.$msg.'
                <strong>'.$note['title'].'</strong>
            </div>            
            <div>
                <a href="index.php?page=view&file='.$_GET['file'].'" class="btn btn-outline-success">Annuler</a>
                <a href="index.php?page=delete&file='.$_GET['file'].'" class="btn btn-outline-danger">Confirmer</a>
            </div>
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
function HTMLInsertMenu() {
    $html = '<div class="row">
                <div class="col-12 text-center">      
                x <a href="index.php">Home</a> X <a href="index.php?page=addnote">Ajouter</a> x
                </div>
            </div>';            

    return $html;
}

/**
 * Affichage ddu Footer
 * 
 * @return string 
 */
function HTMLInsertFooter() {
    $html = '<footer class="appFooter">
                <div class="container">
                    <div class="row">
                        <div class="col-12 text-center">
                        <hr>
                            <p class="infoFooter">ExtraNote - 2024 - v'.APP_VERSION.' - '.APP_DATE_UPDATE.'</small></p>
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
function HTMLInsertBanner() {
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
function HTMLInsertHeader() {
    $html = '
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="assets/css/styles.css">
        <link rel="stylesheet" href="assets/css/tooltip.css">
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
function HTMLViewNote($note) {
    //DEBUG//T_Printr($note, 'note');
    if(!$note)
        return '<div class="alert alert-danger text-center">Note introuvable</div>';

    $html = '<div class="row">               
                <div class="col-4 appViewNote">                    
                    <h1 class="mb-3 appMainColor appPageTitle">'.$note['title'].'</h1>  
                    <hr>
                    <h6 class="mb-3 appMainColor"><span class=""><span class="badge">'.$note['type'].'</span></h6> 
                    <h6 class="mb-3 appMainColor"><span class="">'.$note['date'].'</span></h6>
                    <a href="index.php?page=editnote&file='.$note['filename'].'" class="btn btn-outline-success btn-sm btn-note-delete" title="Modifier"> Modifier </a>
                    <a href="index.php?page=confirm&file='.$note['filename'].'" class="btn btn-outline-danger btn-sm btn-note-delete" title="Supprimer"> Supprimer </a>                    
                </div>   
                <div class="col-1"></div> 
                <div class="col-7 appViewNote">                     
                    <div>
                        '.HTMLFormatNote($note['type'], $note['content']).'
                    </div>
                </div>              
            </div>';
    return $html;
}

/**
 * Formatage de la note en fonction de son type
 * 
 * @param string $type 
 * @param string $note 
 * @return string 
 */
function HTMLFormatNote($type, $note) {
    $html = '';
    switch($type){
        case 'code':
            $html = '<pre><code>'.$note.'</code></pre>';
            break;
        case 'lien':
            $html = '<a href="'.$note.'" target="_blank">'.$note.'</a>';
            break;
        case 'note':
            $html = $note;
            break;
    }   

    return $html;
}

/**
 * Affichage du formulaire de tri des notes
 * 
 * @param string $sorted_by 
 * @return string 
 */
function HTMLInsertFormSortNote($sorted_by = SORT_BY_DEFAULT, $sort_order = SORT_ORDER_DEFAULT) {
    
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
 * Affichage du formulaire de recherches
 * 
 * @return string 
 */
function HTMLInsertFormSearch() {
    $html = '
    <div class="input_wrapper float-end">
        <form id="form_search_note" method="post">
            <input type="hidden" name="action" value="search">               
            <input type="text" name="search_term" id="search_term" class="input_search_note " placeholder="Rechercher une note">
            <button type="submit" class="btn_submit_search" title="Soumettre la recherche"><!--&#x1F50D;-->&rarr;</button>
        </form>
    </div>';
    
    return $html;
}
