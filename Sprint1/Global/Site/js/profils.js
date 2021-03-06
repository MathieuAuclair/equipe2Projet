//Envoie la requete au serveur et retourne la réponse.
function Requete(callback){
    $.ajax({
        type: "POST",
        url: Url(arguments) ,
        success: function(data){
            callback(data);
        }
    });
}

//Construit l'URL selon les derniers paramètre de la fonction Execute.
function Url(){
    var url = "";
    var parametre = arguments[0][1];
    
    for(var i = 1; i < parametre.length; i++){
        url += parametre[i];
    }
    
    return url;
}
 
//Affiche la page selon l'url demandé.
function AfficherPage(xhttp){
    var page = $.parseJSON(xhttp);
    $(".stagiaire").empty();
    $(".stagiaire").append(page);
}

//Éxecute une page PHP sans l'afficher.
function Execute(xhttp){
    $.parseJSON(xhttp);
}

//Selon le choix, éxecute la fonction demandé. C'est la fonction qui doit être appelée
//sur les OnClicks. Tous les paramètres qui se trouvent après "choix" sont utilisés pour
//construire l'url.
function Execute(choix){
    switch(choix){
        case 1: Requete(AfficherPage, arguments);
            break;
        case 2: Requete(Execute, arguments);
            break;
    }
}