
/**
 * Fonction qui remplace le textarea du formulaire d'ajout par un input de type url
 */
function replaceTextareaByInput() {
    let textarea = document.getElementById('content_note');
    let input = document.createElement('input');
    input.className = "form-control";
    input.type = "url";
    input.name = "content_note";
    input.id = "content_note";
    input.placeholder = "Entrez un \"Lien\" ou \"URL\" valide qui commence par: http(s)://...";
    input.required = true;
    input.pattern = "https?://.+"; // Regex pour vérifier si l'url est valide
    textarea.after(input);
    textarea.remove();
}

/**
 * Fonction qui remplace l'input de type url du formulaire d'ajout par un textarea  
 */
function replaceInputByTextarea() {
    let input = document.getElementById('content_note');
    let textarea = document.createElement('textarea');
    textarea.className = "form-control";
    textarea.name = "content_note";
    textarea.id = "content_note";
    textarea.placeholder = "Le contenu de votre note...";
    input.after(textarea);
    input.remove();
}

// Vérifie si type_note est un 'lien' et remplace le textarea par un input au refresh de la page
if(document.getElementById('form_add_note') != undefined) {
    if(document.getElementById('type_note').options[document.getElementById('type_note').selectedIndex].value == 'lien') {
        //DEBUG// alert('You selected Link or Url.');
        replaceTextareaByInput();
    }else {
        //DEBUG// alert('You selected Text.');
        replaceInputByTextarea();
    }
}

// Vérifie si type_note est un 'lien' et remplace le textarea par un input au refresh de la page sur l'événement onchange du select
if(document.getElementById('type_note')){
    type_note.onchange = function() {
        if (this.value == 'lien') {
            //DEBUG// alert('You selected Link or Url.');
            replaceTextareaByInput();    
        }else {
            //DEBUG// alert('You selected Text.');
            replaceInputByTextarea();
        }
    }
}

// Trier les notes sur le select 'sort_note' et 'sort_order'
if(document.getElementById('sort_note') && document.getElementById('sort_order')) {
    let select = document.getElementById('sort_note');
    let select_order = document.getElementById('sort_order');    
    let form_sort_note = document.getElementById('form_sort_note');
 
    select.onchange = function() {
        // submit the form
        form_sort_note.submit();
    }
    select_order.onchange = function() {
        // submit the form
        form_sort_note.submit();
    }
}