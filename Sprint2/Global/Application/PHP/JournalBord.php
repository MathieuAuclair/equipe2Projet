<?php

    include 'ConnexionBD.php';

    function DateDifference($date_1 , $date_2 , $differenceFormat = '%a' ){
        $datetime1 = date_create($date_1);
        $datetime2 = date_create($date_2);
        $interval = date_diff($datetime1, $datetime2);
        return $interval->format($differenceFormat);
    }

    function DerniereEntree($bdd, $idStagiaire){
        $derniereEntree = "";
        
        $query = $bdd->prepare("SELECT Dates AS DateComplete FROM vJournalDeBord WHERE IdStagiaire LIKE $idStagiaire ORDER BY datecomplete DESC LIMIT 1;");
        $query->execute(array());
        
        $results = $query->fetchall();
        
        foreach($results as $result){
            $dateComplete = $result["DateComplete"];
            $derniereEntree = DateDifference(date('Y-m-d h:i:s'), $dateComplete);
        }
        
        return $derniereEntree;
    }

    function LineBreak($texte){
        $split = explode("\\n", $texte);
        $texte = "";
        
        for($i = 0; $i < count($split); $i++){
            $texte = $texte.$split[$i] . "\n";
        }
        
        return $texte;
    }

    function SelectEntrees($bdd, $idStagiaire){
        $limit = "";
        $div = "";
        if(isset($_REQUEST['nbEntree']))
            $limit = "LIMIT ".$_REQUEST['nbEntree'];
        
        $query = $bdd->prepare("SELECT Id, Entree, Date_Format (Dates, '%d/%m/%Y') AS Dates, Dates AS DateComplete, Documents AS Fichier FROM vJournalDeBord WHERE IdStagiaire LIKE $idStagiaire ORDER BY datecomplete desc $limit;");
        $query->execute(array());
        
        $entrees = $query->fetchAll();
        
        foreach($entrees as $entree){
            $texte = $entree["Entree"];
            $dates = $entree["Dates"];
            $dateComplete = $entree["DateComplete"];
            $document = $entree['Fichier'];
            $id = $entree["Id"];

            $div = $div.'<div class="entree"><h2>'.$dates.'</h2><div class="crdJournal"><span class="crdJournalM" onclick="modificationJournal = true; Execute(1, \'../PHP/TBNavigation.php?idStagiaire='.$idStagiaire.'&nomMenu=Journal\', \'&nbEntree=\', 5, \'&ajoutModif=\', true, \'&idEntree=\', '.$id.');">Modifier</span><span>&nbsp;|&nbsp;</span><span class="crdJournalD" onclick="if(ConfirmDelete()){Execute(3, \'../PHP/TBNavigation.php?idStagiaire='.$idStagiaire.'&nomMenu=Journal\', \'&delete=\', true, \'&idEntree=\', '.$id.'); Execute(1, \'../PHP/TBNavigation.php?idStagiaire='.$idStagiaire.'&nomMenu=Journal\', \'&nbEntree=\', 5);}">Supprimer</span></div><p>' .LineBreak($texte). '</p><p>' . PieceJointe($document) . '</p></div>';
        }
        
        if(isset($_REQUEST['nbEntree']))
            $div = $div.'<input class="bouton" type="button" value="Voir toutes les entrées" onclick="Execute(1, \'../PHP/TBNavigation.php?idStagiaire='.$idStagiaire.'&nomMenu=Journal\')"/>';

        return $div;
    }

    function NouvelleEntree($bdd, $idStagiaire){
        $date = date('Y-m-d h:i:s', time());
        
        if(isset($_REQUEST['contenu'])){
            include 'UploadFile.php';
            $entree = array(htmlspecialchars($_REQUEST['contenu']));

            if ($entree[0] != "" && isset($_FILES['file']) && $_FILES['file']['name'] != "")
            {
                $query = $bdd->prepare("INSERT INTO tblJournalDeBord (Entree, idStagiaire, Dates, Documents) VALUES (:text, :id,'$date', :file);");
                $query->bindValue( 'text', $entree[0], PDO::PARAM_STR );
                $query->bindValue( 'id', $idStagiaire, PDO::PARAM_INT);
                $query->bindValue( 'file', $fichier, PDO::PARAM_STR);
                $query->execute();
            }
            else
            {
                if($entree[0] != "")
                {
                    $query = $bdd->prepare("INSERT INTO tblJournalDeBord (Entree, idStagiaire, Dates) VALUES (:text, :id,'$date');");
                    $query->bindValue( 'text', $entree[0], PDO::PARAM_STR );
                    $query->bindValue( 'id', $idStagiaire, PDO::PARAM_INT);
                    $query->execute();
                }
            }
        }
    }

    function PieceJointe($doc)
    {
        if($doc != null && $doc != "")
        {
            $ext = strtolower(pathinfo($doc)['extension']);
            $method = "AfficherImage('". $doc . "','" . $ext ."')";
            return '<a class="lienJointe"><span id="divBouton" style="cursor:pointer" onclick="' . $method . '">Pièce jointe ' . ' -  ' . $ext . '</span></a>'; //faire ici l'affichage en absolute
        }
        else
        {
            $vide = "";
            return $vide;
        }
    }

    function DeleteEntree($bdd, $idEntree)
    {
        $query = $bdd->prepare("DELETE FROM tblJournalDeBord WHERE Id = :id");
        $query->execute(array('id'=>$idEntree));
    }

    function UpdateEntree($bdd, $idEntree, $Entree)
    {
        $entree = array(htmlspecialchars($Entree));
        $query = $bdd->prepare("UPDATE tblJournalDeBord SET Entree = :text WHERE Id = :id");
        $query->bindValue( 'text', $entree[0], PDO::PARAM_STR );
        $query->bindValue( 'id', $idEntree, PDO::PARAM_INT);
        $query->execute();
    }

    function SelectEntreeModif($bdd, $idEntree)
    {
        $query = $bdd->prepare("SELECT Entree FROM vJournalDeBord WHERE Id = :id");
        $query->execute(array('id'=>$idEntree));
        $entrees = $query->fetchAll();

        foreach($entrees as $entree)
        {
            return $entree['Entree'];
        }
    }

    function addId()
    {
        if(isset($_REQUEST['idEntree']))
        {
            return ', \'&idEntree=\', ' . $_REQUEST['idEntree'];
        }
        else
        {
            return '';
        }
    }
    
    if(isset($_REQUEST['contenu']) && isset($_REQUEST['update']))
    {
        UpdateEntree($bdd, $_REQUEST['idEntree'], $_REQUEST['contenu']);
    }
    else
    {
        if(isset($_REQUEST['delete']))
        {
            DeleteEntree($bdd, $_REQUEST['idEntree']);
        }
        else
        {
            if(isset($_REQUEST['contenu']))
            {
                NouvelleEntree($bdd, $idStagiaire);
            }
            else
            {
                if(isset($_REQUEST['ajoutModif']))
                {
                    $_SESSION['textModif'] = SelectEntreeModif($bdd, $_REQUEST['idEntree']);
                }
                else
                {
                    $_SESSION['textModif'] = '';
                }
                
                $content=
                '<article class="stagiaire">
                    <div class="infoStagiaire">
                        <h2>Journal de bord</h2>
                        <h3>Dernière entrée il y a : '.DerniereEntree($bdd, $idStagiaire).' jour(s)</h3>
                    </div>
                    <div id="imageJointe"></div>

            <textarea id="contenu" rows="5" cols="100" maxlength="500" name="contenu" wrap="hard">'.$_SESSION['textModif'].'</textarea>
            <input type="hidden" name="maxFileSize" value="2000000">
            <input class="inputFile" id="file" type="file" value="Envoyer" name="fichier" onchange="AfficherNom(this)"/>

            <br/>                                                                             
            <input style="width: 120px;" class="bouton" type="button" value="Envoyer" onclick="if(modificationJournal){Execute(3, \'../PHP/TBNavigation.php?idStagiaire='.$idStagiaire.'&nomMenu=Journal\',\'&update=\', true, \'&contenu=\', contenu.value'.addId().'); Execute(1, \'../PHP/TBNavigation.php?idStagiaire='.$idStagiaire.'&nomMenu=Journal\', \'&nbEntree=\', 5); modificationJournal = false;}else{Execute(3, \'../PHP/TBNavigation.php?idStagiaire='.$idStagiaire.'&nomMenu=Journal\', \'&contenu=\', contenu.value); Execute(1, \'../PHP/TBNavigation.php?idStagiaire='.$idStagiaire.'&nomMenu=Journal\', \'&nbEntree=\', 5);}"/>
            <label class="bouton labelFile" for="file">Pièce Jointe</label>
            <p id="nomPieceJointe"></p>

                    <div class="separateur">
                        <h3>Toutes les entrées</h3>
                    </div>

                    '.SelectEntrees($bdd, $idStagiaire).'

                    <br/><br/>

                    <input class="bouton" type="button" value="   Retour   " onclick="Execute(1, \'../PHP/TBNavigation.php?idStagiaire='.$id.'&nomMenu=Main\')"/>
                </article>';

                return $content;
            }
        }
    }
?>