<?php
    require 'conf.php';
    require 'app/functions.php';

    //DEBUG// print_rr($_POST, 'POST');
    //DEBUG// print_rr($_GET, 'GET');

    // Initialisation des variables
    // *****************************
    $content = '';
    $msg = '';
    
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
            break;
        default:
            $content = HTMLHomePage();
            break;
    }

    // Gestion des formulaires
    // ***********************
    if(isset($_POST['action']) && $_POST['action'] == 'addnote'){
        if(isset($_POST['title']) && isset($_POST['content'])){
            $title = $_POST['title'];
            $content = $_POST['content'];
            AddNote($title, $content);
            header('Location: index.php?page=home&msg=Note ajoutée avec succès');
        }else{
            $msg = 'Erreur lors de l\'ajout de la note';
        }
    }

     // Gestion des messages
    // *********************
    if(isset($_GET['msg'])){
        $msg = $_GET['msg'];
    }
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
        <div class="row">
            <div class="col-12 text-center">      
                <a href="index.php">Home</a> -
                <a href="index.php?page=addnote">Ajouter</a>  
            </div>
        </div>
        <hr>

        <!-- Affichage des messages -->
        <?php if(!empty($msg)) echo HTMLMessage($msg); ?>    

        <!-- Affichage du contenu -->
        <?php echo $content; ?>
        
          

    </div><!-- container -->     
    <!-- Footer -->
    <?php echo HTMLFooter(); ?>      
</body>
</html>