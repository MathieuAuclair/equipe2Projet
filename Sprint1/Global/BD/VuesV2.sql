 USE BDProjet_equipe2V2;
-- USE cegepjon_p2017_2_dev;
-- USE cegepjon_p2017_2_prod;
-- USE cegepjon_p2017_2_tests;

-- ------------------------------------------------
-- Sélectionne tous les enseignants.
-- ------------------------------------------------
DROP VIEW IF EXISTS vEnseignant;
CREATE VIEW vEnseignant AS 
SELECT Util.Id AS IdUtilisateur, Emp.Id AS IdEnseignant, Prenom, Nom, NumTel, CourrielPersonnel, IdEntreprise, NumTelEntreprise, Poste, CourrielEntreprise, CodePermanent
FROM vEmploye AS Emp
JOIN vUtilisateur AS Util
ON Util.Id = Emp.IdUtilisateur
JOIN vUtilisateurRole AS UR
ON UR.IdUtilisateur = Util.Id
JOIN vRole AS Role
ON Role.Id = UR.IdRole
WHERE Role.Titre = 'Enseignant';

-- ------------------------------------------------
-- Sélectionne tous les gestionnaires.
-- ------------------------------------------------
DROP VIEW IF EXISTS vGestionnaire;
CREATE VIEW vGestionnaire AS 
SELECT Util.Id AS IdUtilisateur, Emp.Id AS IdGestionnaire, Prenom, Nom, NumTel, CourrielPersonnel, IdEntreprise, NumTelEntreprise, Poste, CourrielEntreprise, CodePermanent
FROM vEmploye AS Emp
JOIN vUtilisateur AS Util
ON Util.Id = Emp.IdUtilisateur
JOIN vUtilisateurRole AS UR
ON UR.IdUtilisateur = Util.Id
JOIN vRole AS Role
ON UR.IdRole = Role.Id
WHERE Role.Titre = 'Gestionnaire';

-- ------------------------------------------------
-- Sélectionne tous les responsables.
-- ------------------------------------------------
DROP VIEW IF EXISTS vResponsable;
CREATE VIEW vResponsable AS 
SELECT Util.Id AS IdUtilisateur, Emp.Id AS IdResponsable, Prenom, Nom, NumTel, CourrielPersonnel, IdEntreprise, NumTelEntreprise, Poste, CourrielEntreprise
FROM vEmploye AS Emp
JOIN vUtilisateur AS Util
ON Util.Id = Emp.IdUtilisateur
JOIN vUtilisateurRole AS UR
ON UR.IdUtilisateur = Util.Id
JOIN vRole AS Role
ON UR.IdRole = Role.Id
WHERE Role.Titre = 'Responsable';

-- ------------------------------------------------
-- Sélectionne tous les superviseurs.
-- ------------------------------------------------
DROP VIEW IF EXISTS vSuperviseur;
CREATE VIEW vSuperviseur AS 
SELECT Util.Id AS IdUtilisateur, Emp.Id AS IdSuperviseur, Prenom, Nom, NumTel, CourrielPersonnel, IdEntreprise, NumTelEntreprise, Poste, CourrielEntreprise
FROM vEmploye AS Emp
JOIN vUtilisateur AS Util
ON Util.Id = Emp.IdUtilisateur
JOIN vUtilisateurRole AS UR
ON UR.IdUtilisateur = Util.Id
JOIN vRole AS Role
ON UR.IdRole = Role.Id
WHERE Role.Titre = 'Superviseur';

-- ------------------------------------------------
-- Sélectionne tous les enseignants, superviseur et stagiaire lié au même stage.
-- ------------------------------------------------
DROP VIEW IF EXISTS vTableauBord;
CREATE VIEW vTableauBord AS 
SELECT 	Stagiaire.Id, Stagiaire.Prenom, Stagiaire.Nom, Stagiaire.NumTel,
		Enseignant.IdUtilisateur AS 'IdEnseignant', Enseignant.Prenom AS 'PrenomEnseignant', Enseignant.Nom AS 'NomEnseignant', Enseignant.NumTel AS 'TelEnseignant',
        Sup.IdUtilisateur AS 'IdSuperviseur', Sup.Prenom AS 'PrenomSuperviseur', Sup.Nom AS 'NomSuperviseur', Sup.NumTel AS 'TelSuperviseur',
		res.IdUtilisateur AS 'IdResponsable'
FROM vStage AS Stage
JOIN vStagiaire AS Stagiaire
ON Stagiaire.IdUtilisateur = Stage.IdStagiaire
JOIN vEnseignant AS Enseignant
ON Enseignant.IdUtilisateur = Stage.IdEnseignant
JOIN vSuperviseur AS Sup
ON Sup.IdUtilisateur = Stage.IdSuperviseur
JOIN vResponsable AS res
ON res.IdUtilisateur = Stage.IdResponsable;


-- ------------------------------------------------
-- Sélectionne les informations globales sur les évaluations de chaque stagiaire
-- ------------------------------------------------

DROP VIEW IF EXISTS vInfoEvalGlobale;
CREATE VIEW vInfoEvalGlobale AS
SELECT 	St.Id as 'IdStage', Eva.Id as 'IdEvaluation',Eva.DateComplétée as 'DateComplétée',Eva.Statut as 'Statut',
		Eva.DateDébut as 'DateDébut',Eva.DateFin as 'DateFin',TE.Id as 'IdTypeEvaluation', TE.Titre as 'TitreTypeEvaluation',
        St.IdStagiaire
FROM vEvaluation as Eva
join vTypeEvaluation as TE
on TE.Id = Eva.IdTypeEvaluation
JOIN vEvaluationStage as ES
on Eva.Id = ES.IdEvaluation
join vStage as St
on St.Id = ES.IdStage;

-- ------------------------------------------------
-- Récupère toutes les évaluations des stagiaires selon leur ID et le type d'évaluation avec leurs réponses choisies.
-- ------------------------------------------------
DROP VIEW IF EXISTS vEvaluationCompletee;
CREATE VIEW vEvaluationCompletee AS 
SELECT Stagiaire.Id AS IdStagiaire, Stagiaire.Prenom, Stagiaire.Nom, Eval.Id AS IdEvaluation, 
TypeEval.Titre AS Evaluation, Question.Texte AS Question,Lettre,TitreCategorie,DescriptionCategorie, EQR.IdReponse, Reponse.Texte AS Reponse,
CONCAT(Enseignant.Prenom,' ',Enseignant.Nom) AS Enseignant,
-- CONCAT(Gestionnaire.Prenom,' ',Gestionnaire.Nom) AS Gestionnaire,
CONCAT(Responsable.Prenom,' ',Responsable.Nom) AS Responsable,
CONCAT(Superviseur.Prenom,' ',Superviseur.Nom) AS Superviseur,
Entreprise.Nom AS Entreprise,TypeEval.Id AS TypeEvaluation, Competence
FROM vStagiaire AS Stagiaire
JOIN vUtilisateur AS Util
ON Stagiaire.IdUtilisateur = Util.Id
JOIN vStage AS Stage
ON Stage.IdStagiaire = Util.Id
JOIN vEvaluationStage AS EV
ON EV.IdStage = Stage.Id
JOIN vEvaluation AS Eval
ON Eval.Id = EV.IdEvaluation
JOIN vTypeEvaluation AS TypeEval
ON TypeEval.Id = Eval.IdTypeEvaluation
JOIN vEvaluationQuestionReponse AS EQR
ON EQR.IdEvaluation = Eval.Id
JOIN vQuestion AS Question
ON Question.Id = EQR.IdQuestion
JOIN vCategorieQuestion AS CategorieQuestion
ON Question.IdCategorieQuestion = CategorieQuestion.Id
JOIN vReponse AS Reponse
ON Reponse.Id = EQR.IdReponse
JOIN vEnseignant AS Enseignant
ON Enseignant.IdUtilisateur = Stage.IdEnseignant
/*JOIN vGestionnaire AS Gestionnaire
ON Gestionnaire.IdUtilisateur = Stage.IdGestionnaire*/
JOIN vResponsable AS Responsable
ON Responsable.IdUtilisateur = Stage.IdResponsable
JOIN vSuperviseur AS Superviseur
ON Superviseur.IdUtilisateur = Stage.IdSuperviseur
JOIN vEntreprise AS Entreprise
ON Entreprise.Id = Superviseur.IdEntreprise;

-- ------------------------------------------------
-- Récupère toutes les évaluations des stagiaires selon leur ID et le type d'évaluation avec leurs réponses choisies.
-- ------------------------------------------------

DROP VIEW IF EXISTS vEvaluations;
CREATE VIEW vEvaluations AS
SELECT St.Id AS 'IdStage',St.IdResponsable AS 'IdResponsable',Eva.Id AS 'IdEvaluation',TE.Id AS 'IdTypeEvaluation',TE.Titre AS 'TypeEvaluation',Qu.Id AS 'IdQuestion',Qu.Texte AS 'DescriptionQuestion',CQ.DescriptionCategorie AS 'DescriptionCategorie',TQ.Description AS 'DescriptionTypeQuestion',Re.Id AS 'IdReponse',Re.Texte AS 'DescriptionReponse'
FROM tblStage AS St
JOIN tblEvaluationStage AS Es
ON Es.IdStage = St.Id
JOIN tblEvaluation AS Eva
ON Eva.Id = Es.IdEvaluation
JOIN tblEvaluationQuestionReponse AS EQR
ON EQR.IdEvaluation = Eva.Id
JOIN tblQuestion AS Qu
ON Qu.Id = EQR.IdQuestion
JOIN tblReponseQuestion AS RQ
ON RQ.IdQuestion = Qu.Id
JOIN tblReponse AS Re
ON RQ.IdReponse = Re.Id
JOIN tblCategorieQuestion AS CQ
ON CQ.Id = Qu.IdCategorieQuestion
JOIN tblTypeQuestion AS TQ
ON TQ.Id = Qu.IdTypeQuestion
JOIN tblTypeEvaluation AS TE
ON TE.Id = Eva.IdTypeEvaluation
LIMIT 20000;

-- ------------------------------------------------
-- Récupère les noms des différents noms des utilisateurs lié au stage
-- ------------------------------------------------
DROP VIEW IF EXISTS vIdentification;
CREATE VIEW vIdentification AS
SELECT	Sup.Prenom AS 'PrenomSup', Sup.Nom AS 'NomSup',
		Ens.Prenom AS 'PrenomEns', Ens.Nom AS 'NomEns',
        Resp.Prenom AS 'PrenomResp', Resp.Nom AS 'NomResp',
        Sta.Prenom AS 'PrenomSta', Sta.Nom AS 'NomSta',
        Ent.Nom AS 'NomEnt', Sta.IdUtilisateur AS 'IdStagiaire'
FROM vStage AS Stage
JOIN vSuperviseur AS Sup
ON Sup.IdUtilisateur = Stage.IdSuperviseur
JOIN vEnseignant AS Ens
ON Ens.IdUtilisateur = Stage.IdEnseignant
JOIN vResponsable AS Resp
ON Resp.IdUtilisateur = Stage.IdResponsable
JOIN vStagiaire AS Sta
ON Sta.IdUtilisateur = Stage.IdStagiaire
JOIN vEmploye AS Emp
ON Emp.IdUtilisateur = Sup.IdUtilisateur
JOIN vEntreprise AS Ent
ON Ent.Id = Emp.IdEntreprise;
