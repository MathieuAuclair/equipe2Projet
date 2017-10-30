<?php

    <!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width"/>
        <title>Tableau de bord - Entreprise</title>
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
        <link rel="stylesheet" href="CSS/StyleHeader.css">
        <link rel="stylesheet" href="CSS/StyleFooter.css">
        <link rel="stylesheet" href="CSS/Style.css">
    </head>
    <body onload="CacherDiv()">
        <script src="Script/jquery-3.2.1.js"></script>
        <script src="Script/Script.js"></script>
        
        
        
        <section>
            <article class="ressources">
                <div class="ressourceItem">
                    <a class="linkFill" href="TBEntreprise.html">
                        <div class="divImage imgPDF"></div>
                        <p>Cahier Entreprise</p>
                    </a>
                </div>
                
                <div class="ressourceItem">
                    <a class="linkFill" href="TBEntreprise.html">
                        <div class="divImage imgPDF"></div>
                        <p>Cahier Stagiaire</p>
                    </a>
                </div>
                
                <div class="ressourceItem">
                    <a class="linkFill" href="TBEntreprise.html">
                        <div class="divImage imgDOC"></div>
                        <p>Offre de stage</p>
                    </a>
                </div>
                
                <div class="ressourceItem">
                    <a class="linkFill" href="TBEntreprise.html">
                        <div class="divImage imgDOC"></div>
                        <p>Lettre d'entente</p>
                    </a>
                </div>          
            </article>
            
            <article class="stagiaire">
                <div class="infoStagiaire">
                    <h2>Prenom Nom</h2>
                    <input class="bouton" type="button" value="Afficher le profil"/>
                    <h3>Courriel@hotmail.com</h3>
                </div>
                
                <div class="blocInfo itemHover">
                    <a class="linkFill" href="TBEntreprise.html">
                        <div class="entete">
                            <h2>Enseignant</h2>
                        </div>

                        <div>
                            <p>Prenom Nom</p>
                            <p>(418) 490-1037</p>
                        </div>
                    </a>
                </div>
                
                <div class="blocInfo itemHover">
                    <a class="linkFill" href="TBEntreprise.html">
                        <div class="entete">
                            <h2>Superviseur</h2>
                        </div>

                        <div>
                            <p>Prenom Nom</p>
                            <p>(418) 490-1037</p>
                        </div>
                    </a>
                </div>
                
                <br/><br/><br/><br/>
                
                <table>
                    <thead>
                        <th>Évaluation</th>
                        <th>Statut</th>
                        <th>Date limite</th>
                        <th>Date complétée</th>
                    </thead>
                    
                    <tbody>
                        <tr class="itemHover" onclick="window.document.location='';">
                            <td>Évaluation mi-stage</td>
                            <td>Non complétée</td>
                            <td>2017-02-15</td>
                            <td></td>
                        </tr>
                        
                        <tr class="itemHover" onclick="window.document.location='';">
                            <td>Évaluation finale</td>
                            <td>Complétée</td>
                            <td>2017-03-30</td>
                            <td>2017-03-25</td>
                        </tr>
                    </tbody>
                </table>
                
                <br/><br/><br/>
                
                <input class="bouton" type="button" value="Écrire un commentaire"/>
                
                <div class="navigateur">
                    <div class="fleche flecheGauche" onclick="ChangerStagiaire(this)"></div>
                    <div class="fleche flecheDroite" onclick="ChangerStagiaire(this)"></div>
                </div>
            </article>
            
            <article class="stagiaire">
                <div class="infoStagiaire">
                    <h2>Anus</h2>
                    <input class="bouton" type="button" value="Afficher le profil"/>
                    <h3>Courriel@hotmail.com</h3>
                </div>
                
                <div class="blocInfo itemHover">
                    <a class="linkFill" href="TBEntreprise.html">
                        <div class="entete">
                            <h2>Enseignant</h2>
                        </div>

                        <div>
                            <p>Prenom Nom</p>
                            <p>(418) 490-1037</p>
                        </div>
                    </a>
                </div>
                
                <div class="blocInfo itemHover">
                    <a class="linkFill" href="TBEntreprise.html">
                        <div class="entete">
                            <h2>Superviseur</h2>
                        </div>

                        <div>
                            <p>Prenom Nom</p>
                            <p>(418) 490-1037</p>
                        </div>
                    </a>
                </div>
                
                <br/><br/><br/><br/>
                
                <table>
                    <thead>
                        <th>Évaluation</th>
                        <th>Statut</th>
                        <th>Date limite</th>
                        <th>Date complétée</th>
                    </thead>
                    
                    <tbody>
                        <tr class="itemHover" onclick="window.document.location='';">
                            <td>Évaluation mi-stage</td>
                            <td>Non complétée</td>
                            <td>2017-02-15</td>
                            <td></td>
                        </tr>
                        
                        <tr class="itemHover" onclick="window.document.location='';">
                            <td>Évaluation finale</td>
                            <td>Complétée</td>
                            <td>2017-03-30</td>
                            <td>2017-03-25</td>
                        </tr>
                    </tbody>
                </table>
                
                <br/><br/><br/>
                
                <input class="bouton" type="button" value="Écrire un commentaire"/>
                
                <div class="navigateur">
                    <div class="fleche flecheGauche" onclick="ChangerStagiaire(this)"></div>
                    <div class="fleche flecheDroite" onclick="ChangerStagiaire(this)"></div>
                </div>
            </article>
        </section>
        
        include 'Footer.php';
    </body>
</html>

?>