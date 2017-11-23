/********************************************************************************************************************************************
*	Nom: Hans Darmstadt-Bélanger																											*
*	But: un controller qui récupère les données saisies par l'utilisateur et qui les envoie au PHP pour interragir avec la base de données	*
*	date: 06 novebre 2017																													*
********************************************************************************************************************************************/


function getValuesFromUser(callback)
{
    var values = $(".data");   
    var reponse = "";
    var tabValues = [];
    var form_data = new FormData();                   
    
    reponse={
                nom: "functionToExecute",
                value: "1"
            };
            tabValues.push(reponse);


    for(var i = 0; i < values.length; i++){
        reponse={
            nom: values[i].name,
            value: values[i].value
        };
        
        tabValues.push(reponse);
    }
    
    tabValues = JSON.stringify(tabValues);
    
    form_data.append('tabValues', tabValues); 
    
    $.ajax({ 
        url: Url(arguments),  
        dataType: 'text',   
        cache: false, 
        contentType: false, 
        processData: false, 
        data: form_data,                          
        type: 'post', 
        success: function(data){ 
            callback(data); 
        } 
    }); 
}

function readEmploye (callback, args)
{
 
    var reponse = "";
    var tabValues = [];
     var form_data = new FormData();
 
    reponse={
                nom: "functionToExecute",
                value: "2"
            };
    tabValues.push(reponse);
 
    reponse={
                nom: "idEmploye",
                value: args[2]
            };
    tabValues.push(reponse);
    args[2]="";

     tabValues = JSON.stringify(tabValues);

 form_data.append('tabValues', tabValues); 
   //alert(tabValues);
        
        $.ajax({ 
            url: Url(arguments),  
            dataType: 'text',   
            cache: false, 
            contentType: false, 
            processData: false, 
            data: form_data,                          
            type: 'post', 
            success: function(data){ 
                callback(data); 
                console.log(data);
                afficherInfos(data);
            } 
        }); 
 
 
}


function afficherInfos(data)
{  
    alert (data);
    var myObject = JSON.parse(data);
    console.log (myObject);
    var contenu ="<p>Nom du stagiaire:  ".concat(  myObject[7]  + "</p><br><p>Nom d'entreprise: " + myObject[5] + "</p><br><p>Nom de l'enseignant: " + myObject[9] +"</p><br><p>Nom du superviseur: " + myObject[6] + "</p><br><p>Nom du responsable: " + myObject[8] +  "</p> <br> <p>Horaire de travail: " + myObject[2] + "</p><br><p>Salaire horaire: " + myObject[3] + "</p><br><p>Nombre d'heures par semaine: " +  myObject[4] + "</p> <br><p>Compétences recherchées: " + myObject[1] +   "</p><br><p>Description du stage: " + myObject[0] + "</p><br>");
    console.log (contenu);
    document.getElementById('readStage').innerHTML = contenu;




}