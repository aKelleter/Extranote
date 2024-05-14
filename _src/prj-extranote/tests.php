<?php
require_once 'conf.php';
require_once 'fcts-app.php';
require_once 'fcts-tools.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tests</title>
</head>
<body>
    <?php
    // Aller chercher toutes les notes
    $notes = GETListAllNotes();
    $notes = GETNotesSortedBy($notes);
    // Afficher les notes
    //DEBUG//T_Printr($notes, 'Liste des notes');
    foreach($notes as $note){
        echo '<h2>'.$note['title'].'</h2>';
        echo '<p>'.$note['content'].'</p>';
        echo '<p>'.$note['type'].'</p>';
        echo '<p>'.$note['favoris'].'</p>';
        echo '<p>'.$note['filename'].'</p>';
        echo '<p>'.$note['date'].'</p>';       
    }
    ?>
    
</body>
</html>