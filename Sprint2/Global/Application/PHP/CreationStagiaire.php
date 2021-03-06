 <!DOCTYPE html>

<!-- 
Nom: Hans Darmstadt-Bélanger
Date: 5 Novembre 2017
But: Un écran de CRUD qui permet de gérer des stagiaires
-->
<html>
	<head>

		<!--/!\SUPPRIMER CETTE LIGNE LORSQUE LA PAGE SERA LIÉE AU REST DU SITE/!\ -->
		<script src="../js/navigation.js"></script>
		<script src="../js/jquery.min.js"></script>
		<script src="../js/creationStagiaire.js"></script>

		<?php
		include 'connexionBD.php'; 
		include 'Session.php';
		?>

		<!-- Section création de stagiaire -->
			<meta charset="utf-8">
					<meta http-equiv="X-UA-Compatible" content="IE=edge">
					<title>Creation stage</title>
					<meta name="description" content="An interactive getting started guide for Brackets.">
					<link rel="stylesheet" href="../CSS/style.css">
					<link rel="shortcut icon" href="../Images/LogoDICJ2Petit.ico">
	</head>
	<body>
		  <div id="readStagiaire"></div>

		<h2>Créer un stagiaire</h2>
		<br>
		Prenom du stagiaire <input id="prenomStagiaire" class = "data" type="text" name="prenomStagiaire" value="prenom"><br>
		Nom du stagiaire <input id="nomStagiaire" class = "data" type="text" name="nomStagiaire" value="nom"><br>
		Courriel scholaire <input id="courrielStagiaire" class = "data" type="text" name="courrielStagiaire" value="nom.prenom@etu.cegepjonquiere.ca"><br>

    
    <!-- paramètre à passer (dans l'ordre): prenomStagiaire, nomStagiaire, courrielStagiaire-->
    <input type="button" id="Save" class="bouton" value="Sauvegarder" onclick="Execute(6, '../PHP/TBNavigation.php?nomMenu=CRUDStagiaire')" />
    <br>

	<BR>

<!-- Fin de section création de stagiaire -->


<!-- Section de modification du stagiaire -->

						
	<div id="modifStagiaire" >
		<br>
        <p class="label labelForInput">Prenom :</p>
        <input type="text" value="" class="value"/>

        <br>
        <p class="label labelForInput">Nom :</p>
        <input type="text" value="" class="value"/>

         <br>
        <p class="label labelForInput">Courriel :</p>
        <input type="text" value="" class="value"/>

        <br>
        <p class="label labelForInput">Numero de telephone entreprise :</p>
        <input type="text" value="" class="value"/>
    
    	<br>
        <p class="label labelForInput">Poste téléphonique :</p>
        <input type="text" value="" class="value"/>

        <br>
        <p class="label labelForInput">Courriel en entreprise :</p>
        <input type="text" value="" class="value"/>

        <br>
        <p class="label labelForInput">Code permanent :</p>
        <input type="text" value="" class="value"/>

        <br>
        <p class="label labelForInput">Courriel personnel :</p>
        <input type="text" value="" class="value"/>

        <br>
        <p class="label labelForInput">Numéro de téléphone personnel :</p>
        <input type="text" value="" class="value"/>

        <br>
        <input type="button" id="Save" class="bouton" value="Sauvegarder" />
	</div>


<!-- Fin de section de modification du stagiaire -->



<!-- section affichage de stagiaires -->
	<h2>Stagiaires actuellement dans le système</h2>
	<table>
		<tr>
			<th>Nom stagiaire</th>
			<th>Courriel scolaire</th>
		</tr>
		

	<?php
		showInternships($bdd);
		//récupère les stages dans la BD et les affiche dans le tableau
		function showInternships($bdd)
		{

      $query = $bdd->prepare("Select concat (Prenom, ' ' , Nom) as 'nomStagiaire', CourrielScolaire, IdUtilisateur from vStagiaire;");
      $i = 0;
      $query->execute(array());     
      $entrees = $query->fetchAll();
      
      foreach($entrees as $entree){
          $nomStagiaire = $entree["nomStagiaire"];
          $courrielScolaire = $entree["CourrielScolaire"];
          $idStagiaire = $entree["IdUtilisateur"];

          echo  '<tr>
                  <th  id="' . $idStagiaire .'" onClick="Execute(9,\'../PHP/TBNavigation.php?nomMenu=CRUDStagiaire\', this.id)">' . $nomStagiaire . '</th>
                  <th>' . $courrielScolaire . '</th>
                  <th id="' . $idStagiaire .'" onClick="Execute(11,\'../PHP/TBNavigation.php?nomMenu=CRUDStagiaire\', this.id)">Modifier le stagiaire</th>
                </tr>';

      }      
    }
  ?>
    </table>
<!-- fin de section affichege de stages -->

	</body>
</html> 