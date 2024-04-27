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
 * Affichage du content de la page d'accueil
 * 
 * @return string 
 */
function HTMLHomePage(){
    $notes = ARRAYListNotes();
    $listeNotes = '';
    
    $html = '<div class="row">
                <div class="col-12">                    
                    <h1 class="mb-3 appMainColor appPageTitle">Notes</h1>   
                </div>
            </div>
            <div class="row">
                <div class="col-12">                     
                    <div>';
                    foreach($notes as $note){
                        $html .= '<div class="row">
                                    <div class="col-12">                    
                                        <h2 class="mb-3 appMainColor">'.$note['title'].'</h2>   
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">  
                                        <p>'.$note['content'].'</p>                                        
                                    </div>
                                </div>';
                    }
                    $html .='</div>
                </div>
            </div>';

    return $html;
}   

function HTMLMessage($msg, $type = 'info')
{
    $html ='
        <div class="row">
            <div class="col-12">  
                <script>
                let div = document.createElement("div");
                div.className = "alert alert-'.$type.' text-center";
                div.innerHTML = "'.$msg.'";        
                document.body.append(div);
                setTimeout(() => div.remove(), 2000);
                </script>
            </div>
        </div>
    '; 

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
                            <p>ExtraNote - 2024 - v'.VERSION.'</p>
                        </div>
                    </div>
                </div>
            </footer>';

    return $html;
}

// Lister les notes du répertoires datas
function ARRAYListNotes(){
    $files = glob('datas/*.json');
    $notes = [];
    foreach($files as $file){
        $notes = array_merge($notes, json_decode(file_get_contents($file), true));
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
function ADDNote($title, $content){
    $file = 'datas/notes-'.date("d-m-Y").'-'.GENRandNumbe(5).'.json';
    $notes = json_decode(file_get_contents($file), true);
    $notes[] = ['title' => $title, 'content' => $content];
    file_put_contents($file, json_encode($notes));
}

/**
 * Génération de nombre aléatoire
 * 
 * @param int $e 
 * @return string 
 */
function GENRandNumbe($e = 4)
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
function print_rr($data, $tile = null){
    if($tile)
        echo '<h2>'.$tile.'</h2>';
    
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}