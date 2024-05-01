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
                
                    <form action="index.php" method="post">
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
function HTMLListFavorites()
{

    $notes = GETArrayNotes();
    $listeNotes = '';
    $html = '';
    
    $html = '
    <hr>
    <div class="row">
        <div class="col-12">                    
            <h1 class="mb-3 appMainColor appPageTitle">Favoris ///</h1>   
        </div>
    </div>
    <div class="row">
        <div class="col-12">                     
            <div>';
        if(empty($notes)){
            $html .= '<div class="alert alert-success text-center">Aucun favoris pour le moment</div>';
        }else{                    
            foreach($notes as $note)
            {
                //DEBUG//T_Printr($note, 'note');
                if($note['favoris'] == 1)
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
        }
        $html .='</div></div></div>';
    return $html;
}

/**
 * Affichage de la liste des notes sur la page d'accueil
 * 
 * @return string 
 */
function HTMLListNotes(){

    $notes = GETArrayNotes();      
    $listeNotes = '';
    $html = '';
    //DEBUG// T_Printr($notes, 'HTMLListNotes');
   
    $html = '
    <div class="row">
        <div class="col-12">                    
            <h1 class="mb-3 appMainColor appPageTitle">Notes ///</h1>   
        </div>
    </div>
    <div class="row">
        <div class="col-12">                     
            <div>';
            if(empty($notes)){
                $html .= '<div class="alert alert-success text-center">Aucune note pour le moment</div>';
            }else{                    
                foreach($notes as $note){
                    $html .= ' 
                    <a href="index.php?page=view&file='.$note['filename'].'" class="appNoteBox">
                        <div class="row appNote">
                            
                                <div class="col-12">
                                    <span class="badge text-bg-secondary">'.$note['type'].'</span>                     
                                    <h2 class="mb-3 appMainColor">'.$note['title'].'</h2>                                                     
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
function HTMLDisplayNote($file)
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
                    <h6 class="mb-3 appMainColor"><span class="">Type</span>: <strong>'.$note['type'].'</strong></h6> 
                    <h6 class="mb-3 appMainColor"><span class="">Date</span>: <strong>'.$note['date'].'</strong></h6>
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
