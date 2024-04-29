<?php

/**
 * Affichage du formulaire d'ajout de note
 * 
 * @return string 
 */
function HTMLAddForm(){
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
                            <label for="title" class="form-label appLabel">Titre</label>
                            <input type="text" class="form-control" name="title" placeholder="Title" required>
                        </div>
                        <div class="mb-3 form-group">
                            <label for="type" class="form-label appLabel">Type</label>
                            <select name="type" class="form-control" required>
                                <option value="note">Note</option>
                                <option value="code">Code</option>
                                <option value="lien">Lien</option>
                            </select>
                        </div>
                        <div class="mb-3 form-group">                                                   
                            <input class="form-check-input" type="checkbox" value="1" name="favoris">
                            <label class="form-check-label" for="favoris">Ajouter aux favoris</label>
                        </div>    
                        <div class="mb-3 form-group">
                            <label for="content" class="form-label appLabel">Contenu</label>
                            <textarea name="content" class="form-control" placeholder="Content" required></textarea>
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
    $notes = GETArrayListNotes();
    $listeNotes = '';
    $html = '';
    
    $html = '
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
                //DEBUG//PRINTR($note, 'note');
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

    $notes = GETArrayListNotes();      
    $listeNotes = '';
    $html = '';
    //DEBUG// PRINTR($notes, 'HTMLListNotes');
   
    $html = '<div class="row">
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
function HTMLMessage($msg, $type = 'info')
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
function HTMLMenu(){
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
function HTMLFooter(){
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
 * Affichage d'un favori
 * 
 * @param mixed $favori 
 * @return string 
 */
function HTMLViewNote($file)
{
    $note = json_decode(file_get_contents($file), true);
    $note = $note[0];
    //DEBUG//PRINTR($note, 'note');

    if(!$note)
        return '<div class="alert alert-danger text-center">Note introuvable</div>';

    $html = '<div class="row">
                <div class="col-12">                    
                    <h1 class="mb-3 appMainColor appPageTitle">'.$note['title'].'</h1>  
                    <h6 class="mb-3 appMainColor">Type: <strong>'.$note['type'].'</strong></h6> 
                </div>
            </div>
            <div class="row">
                <div class="col-12">                     
                    <div>
                        <p>'.$note['content'].'</p>
                    </div>
                </div>
            </div>';

    return $html;
}

function HTMLLogoff(){
    $html = '<div class="row">
                <div class="col-12 text-center">      
                    <a href="index.php?page=logoff">Déconnexion</a>  
                </div>
            </div>';            

    return $html;
}

/**
 * Récupération de la liste des notes
 * 
 * @return array 
 */
function GETArrayListNotes(){
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
function ADDNoteToFile($title, $content, $type, $favoris){
    
    $result = false;
    $filename = NOTES_DIR.'/notes-'.date("d-m-Y").'-'.GENRandNumber(5).'.json';

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
 * Génération de nombre aléatoire
 * 
 * @param int $e 
 * @return string 
 */
function GENRandNumber($e = 4)
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
function PRINTR($data, $tile = null){
    if($tile)
        echo '<h2>'.$tile.'</h2>';
    
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}