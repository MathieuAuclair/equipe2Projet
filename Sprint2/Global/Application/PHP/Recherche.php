<?php //recherche de connexion dans la bd

    include 'Session.php';
    if (Login($username, $MDP, $bdd))
    {
        switch ($_SESSION['IdRole'])
        {
            case 1: //case 1 is an administrator
                GetPrenomNom($bdd->prepare("SELECT * FROM vEmploye WHERE IdUtilisateur = :id"));
                include 'ConsoleAdmin.php';
                break;

            case 2: //case 2 is a Responsible
                GetPrenomNom($bdd->prepare("SELECT * FROM vEmploye WHERE IdUtilisateur = :id"));
                include 'TBEntreprise.php';
                break;

            case 3: //case 3 is a Teacher
                GetPrenomNom($bdd->prepare("SELECT * FROM vEmploye WHERE IdUtilisateur = :id"));
                include "AVenir.php";
                break;

            case 4:
                GetPrenomNom($bdd->prepare("SELECT * FROM vEmploye WHERE IdUtilisateur = :id"));
                include "TBEntreprise.php";
                break;

            case 5: //case 5 is an intern
                GetPrenomNom($bdd->prepare("SELECT * FROM vStagiaire WHERE IdUtilisateur = :id"));
                include "TableauBordStagiaire.php";
                break;

            default: echo "error unknown IdRole";
        }
    }
    else
    {
        //echo "crash.exe";
    }

  	function GetPrenomNom($queryRecherche){
        $queryRecherche->execute(array('id'=>$_SESSION['idConnecte']));
        $connecte = $queryRecherche->fetchAll();

        foreach ($connecte as $user)
        {
            $_SESSION['PrenomConnecte'] = $user['Prenom'];
            $_SESSION['NomConnecte'] = $user['Nom'];
        }
    }
?>