<?php
// *******************************************************
// --                    CONTROLLER                     --
// *******************************************************
    require 'conf.php';
    require 'app/fcts-tools.php';
    require 'app/fcts-app.php';

    //DEBUG// T_Printr($_POST, 'POST');
    //DEBUG// T_Printr($_GET, 'GET');
    //DEBUG// T_Printr($GLOBALS, 'GLOBALS');
    

    // Initialisation des variables
    // *****************************
    $notes = '';
    $message = '';
    $favoris = '';
    $sort_note = SORT_BY_DEFAULT;
    $sort_order = SORT_ORDER_DEFAULT;

    // Tri des notes
    // *************
    if(isset($_POST['sort_note']) && !empty($_POST['sort_note'])){
        $sort_note = $_POST['sort_note'];
    }
    if(isset($_POST['sort_order']) && !empty($_POST['sort_order'])){
        $sort_order = $_POST['sort_order'];
    }
            
    // Gestion de l'affichage des pages et de leur contenu
    // ***************************************************
    if(isset($_GET['page'])){
        $page = $_GET['page'];
    }else{  
        $page = 'home';
    }

    switch($page){
        case 'addnote':
            $notes = HTMLFormAddNewNote();
            $favoris = null;
            break;
        case 'view':
            if(!empty($_GET['file'])){
                $file = $_GET['file'];                
                $notes = HTMLViewNote($file);
                $favoris = null;
            }else{
                $GLOBALS['msg'] = 'Erreur lors de la récupération de la note';
                $GLOBALS['msgType'] = 'danger';
                $favoris = null;
                $notes = null;
                header('Refresh:2; url=index.php?page=home');                
            }
            break;
        case 'confirm':
            $notes = HTMLInsertConfirmationBox("Souhaitez-vous vraiment supprimer cette note ?");
            break;
        case 'delete':
            if(!empty($_GET['file'])){
                
                $file = $_GET['file'];                
                $status = DELETENoteFile($file);                

                if($status === false){
                    $GLOBALS['msg'] = 'Erreur lors de la suppression de la note';
                    $GLOBALS['msgType'] = 'danger';
                    header('Refresh:2; url=index.php?page=home');                    
                }else{
                    $GLOBALS['msg'] = 'Note supprimée avec succès';
                    $GLOBALS['msgType'] = 'info';
                    header('Refresh:2; url=index.php?page=home');                    
                }

            }else{
                $GLOBALS['msg'] = 'Erreur lors de la récupération de la note';
                $GLOBALS['msgType'] = 'danger';
                header('Refresh:2; url=index.php?page=home');                
            }
            break;
        default:
            $notes = HTMLViewListNotes($sort_note, $sort_order);
            $favoris = HTMLViewListFavorites();
            break;
    }

    // Gestion des formulaires
    // ***********************
        // Ajout d'une note
        // ****************
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
// *******************************************************
// --                      VIEW                         --
// *******************************************************       
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

        <!-- Affichage des notes -->
        <?php echo $notes; ?>
        
        <!-- Affichage des favoris -->
        <?php echo $favoris ?>
        
    </div><!-- container -->     
    
    <!-- Footer -->
    <?php echo HTMLInsertFooter(); ?>    

    <!-- Scripts -->
    <script src="assets/js/app.js"></script>
</body>
</html>