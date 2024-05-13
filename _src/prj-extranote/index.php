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

    // Initialisation des variables
    // *****************************
   

    // Tri des notes
    // *************
   
            
    // Gestion de l'affichage des pages et de leur contenu
    // ***************************************************
   

    // Gestion des formulaires
    // ***********************
        // Ajout d'une note
        // ****************
       
        // Edition d'une note
        // ******************    
       
        // Rechercher une/des note(s)
        // **************************
        
        
    // Gestion des messages
    // ********************
    
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
</body>
</html>