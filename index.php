<?php
// *******************************************************
// --                    CONTROLLER                     --
// *******************************************************
    require 'conf.php';
    require 'app/fcts-tools.php';
    require 'app/fcts-html.php';
    require 'app/fcts-app.php';

    //DEBUG// T_Printr($_POST, 'POST');
    //DEBUG// T_Printr($_GET, 'GET');
    //DEBUG// T_Printr($GLOBALS, 'GLOBALS');    

    // Initialisation des variables
    // *****************************
    $section_notes = '';
    $section_message = '';
    $section_favoris = '';
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
            $section_notes = HTMLFormAddNewNote();
            $section_favoris = null;
            break;
        case 'view':
            if(!empty($_GET['file'])){
                $file = $_GET['file'];
                $note = LOADNoteFromFile($file);                
                $section_notes = HTMLViewNote($note);
                $section_favoris = null;
            }else{
                $GLOBALS['msg'] = 'Erreur lors de la récupération de la note';
                $GLOBALS['msgType'] = 'danger';
                $section_favoris = null;
                $section_notes = null;
                header('Refresh:2; url=index.php?page=home');                
            }
            break;
        case 'confirm':
            $section_notes = HTMLInsertDeleteConfirmation("Souhaitez-vous vraiment supprimer cette note ? <br> ");
            break;
        case 'delete':
            if(!empty($_GET['file'])) {                
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
                $GLOBALS['msg'] = 'Erreur lors de la récupération de la note en vue de sa suppression';
                $GLOBALS['msgType'] = 'danger';
                header('Refresh:2; url=index.php?page=home');                
            }
            break;
            case 'editnote':
                if(!empty($_GET['file'])){
                    $file = $_GET['file'];  
                    $note = LOADNoteFromFile($file);              
                    $section_notes = HTMLFormEditNote($note);
                    $section_favoris = null;
                }else{
                    $GLOBALS['msg'] = 'Erreur lors de la récupération de la note en vue de son édition';
                    $GLOBALS['msgType'] = 'danger';
                    $section_favoris = null;
                    $section_notes = null;
                    header('Refresh:2; url=index.php?page=home');                
                }
                break;
            default:
                // Acquisition et tri des notes            
                $notes = GETListAllNotes();
                //DEBUG// T_Printr($notes, 'Notes non triées');
                $sortedNotes = GETNotesSortedBy($notes, $sort_note, $sort_order);

                // Affichages des notes et des favoris
                $section_notes = HTMLViewListNotes($sortedNotes, $sort_note, $sort_order);
                $section_favoris = HTMLViewListFavorites();               
                break;
    }

    // Gestion des formulaires
    // ***********************
        // Ajout d'une note
        // ****************
        if(isset($_POST['action']) && $_POST['action'] == 'addnote')
        {
            if(isset($_POST['title_note']) && isset($_POST['content_note']) && isset($_POST['type_note'])) {
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
        // Edition d'une note
        // ******************    
        }elseif(isset($_POST['action']) && $_POST['action'] == 'recordnote') {

            if( isset($_POST['title_note']) && isset($_POST['content_note']) && isset($_POST['type_note']) && 
                isset($_POST['file_note']) && isset($_POST['date_note'])) {
                $note_record = [];    
                $note_record['title'] = $_POST['title_note'];
                $note_record['content'] = $_POST['content_note'];
                $note_record['type'] = $_POST['type_note'];
                $note_record['favoris'] = (isset($_POST['favori_note']))? $_POST['favori_note'] : 0;
                $note_record['file'] = $_POST['file_note'];
                $note_record['date'] = $_POST['date_note'];
                $status = UPDATENoteFile($note_record);
                
                if($status === false){
                    $GLOBALS['msg'] = 'Erreur lors de l\'édition de la note';
                    $GLOBALS['msgType'] = 'danger';
                    header('Refresh:2; url=index.php?page=home');                                
                }else{
                    $GLOBALS['msg'] = 'Note mise à jour avec succès';
                    $GLOBALS['msgType'] = 'info';
                    header('Refresh:2; url=index.php?page=home');                                
                }
                
            }else{
                $GLOBALS['msg'] = 'Veuillez remplir tous les champs';
                $GLOBALS['msgType'] = 'danger';                            
            }
        // Rechercher une/des note(s)
        // **************************
        }elseif(isset($_POST['action']) && $_POST['action'] == 'search') {
            if(isset($_POST['search_term']) && !empty($_POST['search_term'])){
                $search = $_POST['search_term'];
                $notes = GETListAllNotes();                
                $searchedNotes = SEARCHInNotes($notes, $search);
                $section_notes = '<p class="text-center"><strong>Chaîne recherchée : <span class="termSearch">"'.$search.'"</span></strong></p>';
                $section_notes .= HTMLViewListNotes($searchedNotes, $sort_note, $sort_order);
                $section_notes .= '<p><a href="index.php" class="btn btn-outline-success btn-sm">RESET &#11119;</a></p>';
            }
        }
        
    // Gestion des messages
    // ********************
    if(isset($GLOBALS['msg']) && !empty($GLOBALS['msg']))
    {                
        $section_message = HTMLInsertMessage($GLOBALS['msg'], $GLOBALS['msgType']);                   
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
        <?php echo $section_message; ?>

        <!-- Affichage des notes -->
        <?php echo $section_notes; ?>

        <!-- Affichage des favoris -->
        <?php echo $section_favoris ?>
        
    </div><!-- container -->     
    
    <!-- Footer -->
    <?php echo HTMLInsertFooter(); ?>    

    <!-- Scripts -->
    <script src="assets/js/app.js"></script>
    <script src="assets/js/tooltip.js"></script>
</body>
</html>