<?php
    
    require 'conf.php';
    require 'app/fcts-tools.php';
    require 'app/fcts-app.php';

    //DEBUG// T_Printr($_POST, 'POST');
    //DEBUG// T_Printr($_GET, 'GET');
    //DEBUG// T_Printr($GLOBALS, 'GLOBALS');
    

    // Initialisation des variables
    // *****************************
    $content = '';
    $message = '';
    $favoris = '';
        
    // Gestion de l'affichage des pages et de leur contenu
    // ***************************************************
    if(isset($_GET['page'])){
        $page = $_GET['page'];
    }else{  
        $page = 'home';
    }

    switch($page){
        case 'addnote':
            $content = HTMLFormAddNewNote();
            $favoris = null;
            break;
        case 'view':
            if(!empty($_GET['file'])){
                $file = $_GET['file'];                
                $content = HTMLDisplayNote($file);
                $favoris = null;
            }else{
                $GLOBALS['msg'] = 'Erreur lors de la récupération de la note';
                $GLOBALS['msgType'] = 'danger';
                $favoris = null;
                $content = null;
                header('Refresh:2; url=index.php?page=home');                
            }
            break;
        case 'logoff':
            session_destroy();
            header('Location: index.php?page=home');
            break;
        default:
            $content = HTMLListNotes();
            $favoris = HTMLListFavorites();
            break;
    }

    // Gestion des formulaires
    // ***********************
    if(isset($_POST['action']) && $_POST['action'] == 'addnote')
    {
        if(isset($_POST['title_note']) && isset($_POST['content_note']) && isset($_POST['type_note'])){
            $note_title = $_POST['title_note'];
            $note_content = $_POST['content_note'];
            $note_type = $_POST['type_note'];
            $note_favori = (isset($_POST['favori_note']))? $_POST['favori_note'] : 0;
            $status = ADDNewNoteToFile($note_title, $note_content, $note_type, $note_favori);
            
            if($status === false){
                $GLOBALS['msg'] = 'Erreur lors de l\'ajout de la note';                    
                $GLOBALS['msgType'] = 'danger';   
                header('Refresh:2; url=index.php?page=home');                             
            }else{
                $GLOBALS['msg'] = 'Note ajoutée avec succès';
                $GLOBALS['msgType'] = 'info';       
                header('Refresh:2; url=index.php?page=home');         
            }               
            
        }else{
            $GLOBALS['msg'] = 'Veuillez remplir tous les champs';
            $GLOBALS['msgType'] = 'danger';            
        }
    }

    // Gestion des messages
    // ********************
    if(isset($GLOBALS['msg']) && !empty($GLOBALS['msg']))
    {                
        $message = HTMLInsertMessage($GLOBALS['msg'], $GLOBALS['msgType']);                   
        $GLOBALS['msg'] = '';
        $GLOBALS['msgType'] = '';                                      
    }      
   
?>
<!DOCTYPE html>
<html lang="fr">
    <?php echo HTMLInsertHeader(); ?>
<body>
    <div class="container">        
        <!-- Banner -->
        <?php echo HTMLInsertBanner(); ?>
        
        <!-- Menu -->
        <?php echo HTMLInsertMenu(); ?>
    
        <hr>
        
        <!-- Affichage des messages -->       
        <?php echo $message; ?>

        <!-- Affichage du contenu -->
        <?php echo $content; ?>
        
        <!-- Affichage des favoris -->
        <?php echo $favoris ?>
        
    </div><!-- container -->     
    <!-- Footer -->
    <?php echo HTMLInsertFooter(); ?>    
    <script src="assets/js/app.js"></script>
</body>
</html>