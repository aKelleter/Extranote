<?php
    // Initialisation de la session
    session_start();

    require 'conf.php';
    require 'app/functions.php';

    //DEBUG// PRINTR($_POST, 'POST');
    //DEBUG// PRINTR($_GET, 'GET');
    //DEBUG// PRINTR($_SESSION, 'SESSION');

    // Initialisation des variables
    // *****************************
    $content = '';
    
    // Gestion de l'affichage des pages
    // ********************************
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
            if(!empty($_GET['id'])){
                $id = $_GET['id'];
                $favori = GETFavoriteByID($id);
                $content = HTMLViewFavorite($favori);
                $favoris = null;
            }else{
                $_SESSION['msg'] = 'Erreur lors de la récupération de la note';
                $_SESSION['msgType'] = 'danger';
                header('Refresh:2; url=index.php?page=home');
                $favoris = null;
            }
            break;
        case 'logoff':
            session_destroy();
            header('Location: index.php?page=home');
            break;
        default:
            $content = HTMLListNotes();
            $favoris = HTMLListFavorites(FAVORIS);
            break;
    }

    // Gestion des formulaires
    // ***********************
    if(isset($_POST['action']) && $_POST['action'] == 'addnote'){
        if(isset($_POST['title']) && isset($_POST['content']) && isset($_POST['type'])){
            $title = $_POST['title'];
            $content = $_POST['content'];
            $type = $_POST['type'];
            $status = ADDNoteToFile($title, $content, $type);
            if($status === false){
                $_SESSION['msg'] = 'Erreur lors de l\'ajout de la note';                    
                $_SESSION['msgType'] = 'danger';
                $_SESSION['msgHasBeenDisplayed'] = false;
                
            }else{
                $_SESSION['msg'] = 'Note ajoutée avec succès';
                $_SESSION['msgType'] = 'info';
                $_SESSION['msgHasBeenDisplayed'] = false;
            }   
            
            header('Location: index.php?page=home');
        }else{
            $_SESSION['msg'] = 'Veuillez remplir tous les champs';
            $_SESSION['msgType'] = 'danger';
            $_SESSION['msgHasBeenDisplayed'] = false;
        }
    }

    
    //DEBUG// PRINTR($_SESSION, 'SESSION AFTER POST');

    // Gestion des messages
    // ********************
    /*
    if(isset($_SESSION['msgHasBeenDisplayed']) && $_SESSION['msgHasBeenDisplayed'] == true){
        // Vidage de la session
        $_SESSION['msg'] = '';
        $_SESSION['msgType'] = ''; 
        $_SESSION['msgHasBeenDisplayed'] = false;
    }
    */
    
    //DEBUG// PRINTR($_SESSION, 'SESSION AFTER MESSAGE');
    

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/styles.css">
    <title>Extra Note</title>
</head>
<body>
    <div class="container">        
        <div class="row">
            <div class="col-12 text-center">      
                <h1>Extranote</h1>
            </div>
        </div>
        
        <!-- Menu -->
        <?php echo HTMLMenu(); ?>
    
        <hr>
        
        <!-- Affichage des messages -->       
        <?php   
            if(isset($_SESSION['msg']) && !empty($_SESSION['msg']))
            {                
                echo HTMLMessage();                   
                $_SESSION['msg'] = '';
                $_SESSION['msgType'] = '';                                      
            }       
        ?>

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