<?php
    
    require 'conf.php';
    require 'app/functions.php';

    //DEBUG// PRINTR($_POST, 'POST');
    //DEBUG// PRINTR($_GET, 'GET');
    //DEBUG// PRINTR($GLOBALS, 'GLOBALS');
    

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
            $content = HTMLAddForm();
            $favoris = null;
            break;
        case 'view':
            if(!empty($_GET['file'])){
                $file = $_GET['file'];                
                $content = HTMLViewNote($file);
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
        if(isset($_POST['title']) && isset($_POST['content']) && isset($_POST['type'])){
            $note_title = $_POST['title'];
            $note_content = $_POST['content'];
            $note_type = $_POST['type'];
            $note_favoris = (isset($_POST['favoris']))? $_POST['favoris'] : 0;
            $status = ADDNoteToFile($note_title, $note_content, $note_type, $note_favoris);
            
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
        $message = HTMLMessage($GLOBALS['msg'], $GLOBALS['msgType']);                   
        $GLOBALS['msg'] = '';
        $GLOBALS['msgType'] = '';                                      
    }      
   
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/styles.css">
    <title><?php echo APP_TITLE; ?></title>
</head>
<body>
    <div class="container">        
        <div class="row">
            <div class="col-12 text-center">      
                <h1><?php echo APP_NAME; ?></h1>
            </div>
        </div>
        
        <!-- Menu -->
        <?php echo HTMLMenu(); ?>
    
        <hr>
        
        <!-- Affichage des messages -->       
        <?php echo $message; ?>

        <!-- Affichage du contenu -->
        <?php echo $content; ?>

        <hr>

        <!-- Affichage des favoris -->
        <?php echo $favoris ?>
        
    </div><!-- container -->     
    <!-- Footer -->
    <?php echo HTMLFooter(); ?>    
</body>
</html>