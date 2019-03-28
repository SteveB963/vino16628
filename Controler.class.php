<?php
/**
 * Class Controler
 * Gère les requêtes HTTP
 * 
 * @author Jonathan Martel
 * @version 1.0
 * @update 2019-01-21
 * @license Creative Commons BY-NC 3.0 (Licence Creative Commons Attribution - Pas d’utilisation commerciale 3.0 non transposé)
 * @license http://creativecommons.org/licenses/by-nc/3.0/deed.fr
 * 
 */

class Controler 
{

    /**
     * Traite la requête
     * @return void
     */
    public function gerer()
    {

        switch ($_GET['requete']) {
            case 'autocompleteBouteille':
                $this->autocompleteBouteille();
                break;
            case 'ajouterNouvelleBouteille':
                $this->ajouterNouvelleBouteille();
                break;
            case 'ajouterBouteille':
                $this->ajouterBouteille();
                break;
            case 'modifierBouteilleCellier':
                $this->modifierBouteilleCellier();
                break;
            case 'boireBouteille':
                $this->boireBouteille();
                break;                
            case 'afficheContenuCellier':
                $this->afficheContenuCellier();
				break;
			case 'creerUnCellier':
                $this->creerUnCellier();
                break;			
			case 'afficheListCellier':
                $this->afficheListCellier();
				break;
            case 'uploadPage':
                $this->uploadPage();
                break;
            case 'compte':
                $this->compte();
                break;
            case 'login':
                $this->login();
                break;
            case 'deconnexion':
                $this->deconnexion();
                break;
            case 'inscription':
                $this->inscription();
                break;
            case 'creerCompteUsager':
                $this->creerCompteUsager();
                break;
            case 'modificationCompte':
                $this->modificationCompte();
                break;
            default:
                $this->accueil();
                break;
        }
    }


    /**
     * Affiche la page d'acceil
     *
     */
    private function accueil()
    {
        include("vues/entete.php");
        include("vues/accueil.php");
        include("vues/pied.php");
    }


    /**
     * Affiche la liste des bouteilles d'un cellier
     *
     * 
     */
    private function afficheContenuCellier()
    {
        if(isset($_SESSION["idUtilisateur"]) && $_SESSION["idUtilisateur"] != "")
        {
            if(isset($_GET['id_cellier'])){
                if(isset($_GET['trierCellier'])){
                    $trier = $_GET['trierCellier'];
                }
                else{
                    $trier = "nom";
                }
                $bte = new Bouteille();
                $data['info'] = $bte->getInfoBouteilleCellier($_GET['id_cellier'], $trier);
                $cellier = new Cellier();
                $data['bouteille'] = $cellier->getContenuCellier($_GET['id_cellier']);
                include("vues/entete.php");
                include("vues/contenuCellier.php");
                include("vues/pied.php");
            }
            else{
                $this->afficheListCellier();
            }
        }
        else{
            include("vues/entete.php");
            include("vues/nonConnecte.php");
            include("vues/pied.php");
        }
        

    }
    

    private function afficheListCellier()
    {
        if(isset($_SESSION["idUtilisateur"]) && $_SESSION["idUtilisateur"] != "")
        {
            $cel = new Cellier();
            $data = $cel->getListeCellier($_SESSION["idUtilisateur"]);
            include("vues/entete.php");
            include("vues/listCellier.php");
            include("vues/pied.php");
        }
        else{
            include("vues/entete.php");
            include("vues/nonConnecte.php");
            include("vues/pied.php");
        }

    }



     /**
     * 
     *
     * /////////DOIT ÊTRE DOCUMENTÉ ET TESTÉ////////
     */
    private function autocompleteBouteille()
    {
        $body = json_decode(file_get_contents('php://input'));
        
        $bte = new Bouteille();
        $listeBouteille = $bte->autocomplete($body->nom);

        echo json_encode($listeBouteille);

    }

    /**
     * 
     *
     * /////////DOIT ÊTRE DOIT ÊTRE DOCUMENTÉ ET TESTÉ////////
     */
    private function ajouterNouvelleBouteille()
    {
        $body = json_decode(file_get_contents('php://input'));
        
        if(!empty($body)){
            $cellier = new Cellier();

            $resultat = $cellier->ajouterBouteille($body);
            echo json_encode($resultat);
        }
        else{
            include("vues/entete.php");
            include("vues/formAjoutBout.php");
            include("vues/pied.php");
        }


    }
		

	
	private function creerUnCellier()
	{	
		if(isset($_SESSION["idUtilisateur"]) && $_SESSION["idUtilisateur"] != "")
        {
    		$body = json_decode(file_get_contents('php://input'));
    		if(!empty($body)){
                $cel = new Cellier();
                $data["idUsager"] = $_SESSION["idUtilisateur"];
                $data["nomCellier"] = $body->nom;
                    				
    		    $resultat = $cel->creerUnNouveauCellier($data);				
                echo json_encode($resultat);			
    		}
    		else{
    			include("vues/entete.php");
    			include("vues/creerCellier.php");
    			include("vues/pied.php");
    		}					
		}
        else{
            include("vues/entete.php");
            include("vues/nonConnecte.php");
            include("vues/pied.php");
        }
	}


    /**
     * Retirer une bouteille du cellier
     * ?? ajout d'une note dans historique pour les statistiques
     *
     */
    private function boireBouteille()
    {
        $body = json_decode(file_get_contents('php://input'));

        $cellier = new Cellier();
        //retire une bouteille du cellier et récupère la nouvelle quantité
        $resultat = $cellier -> supprimerBouteille($body -> id);
        echo json_encode($resultat);
    }

    /**
     * Ajoute une bouteille du cellier
     * ?? ajout d'une note dans historique pour les statistiques
     *
     */
    private function ajouterBouteille()
    {
        $body = json_decode(file_get_contents('php://input'));
        
        $body -> date_ajout = date('Y-m-d');
        $garde_jusqua = new DateTime($body -> date_ajout);
        $garde_jusqua = $garde_jusqua -> add(new DateInterval('P1Y'));
        $body -> garde_jusqua = $garde_jusqua -> format('Y-m-d');
        
        $cellier = new Cellier();
        $resultat['succes'] = $cellier -> ajouterBouteille($body);
        $resultat['ajout'] = $cellier -> getDernAjout();
        
        echo json_encode($resultat);
    }

    /**
     * redirige vers le formulaire de modification d'une bouteille dans un cellier
     * et traite le formulaire
     *
     * @return obj $resultat resultat des requetes sql et retourne les erreurs.
     */
    private function modifierBouteilleCellier(){
        $body = json_decode(file_get_contents('php://input'));
        //si on ne reçoit pas de donnée on dirige vers le formulaire
        if(empty($body)){
            $bte = new Bouteille();
            $donnee['bouteille'] = $bte->getBouteille($_GET['id_bouteille']);
            
            $donnee['id_cellier'] = $_GET['id_cellier'];

            $pays = new Pays();
            $donnee['pays'] = $pays->getTousPays();

            $type = new Type();
            $donnee['type'] = $type->getTousTypes();

            include("vues/entete.php");
            include("vues/formBout.php");
            include("vues/pied.php");
        }
        else{
            $resultat = new stdClass();
            $resultat -> erreur = $body -> verif;
            $resultat -> succes = false;
            $erreur = false;

            //récupère les résultat des vérification
            $verif = (array) $body -> verif;
            foreach($verif as $err){
                if($err != ""){
                    $erreur = true;
                }
            }

            //traitement si pas d'érreur
            if(!$erreur){
                //récupération des infos de la bouteille avant modif
                $bte = new Bouteille();
                $bteAvant = $bte -> getBouteille($body -> bte -> id_bouteille);
                //tableau contenant les modif.
                $bteNouvelle = (array) $body -> bte;

                //vérifie si il y a eu des modifications
                $duplication = true;
                foreach($bteAvant as $champ => $valeur){
                    if($bteAvant[$champ] != $bteNouvelle[$champ]){
                        $duplication = false;
                    }
                }
                //si modification
                if(!$duplication){
                    //si bouteille est listé
                    if($body -> bte -> non_liste == 0){
                        //ajoute nouvelle bouteille non-liste
                        $resultat -> succes = $bte -> ajouterBouteilleNonListe($body -> bte);

                        //remplace la bouteille liste par la nouvelle bouteille non liste
                        if($resultat -> succes == true){
                            //recupération de l'id du dernier ajout
                            $dernId = $bte -> getDernBouteille();
                            $resultat -> idNouvelle = $dernId;
                            //remplace l'id_bouteille dans le cellier avec la nouvelle id
                            $resultat -> succes = $bte -> remplaceBouteilleCellier($body -> bte -> id_cellier, $body-> bte -> id_bouteille, $dernId);////////BESOIN D'UN ID CELLIER PROCHIANNEMENT////////
                            $resultat -> status = "remplaceBouteille";

                            if($resultat -> succes == false){
                                $resultat  -> echec = "erreur lors du remplacement";
                            }
                        }
                        else{
                            $resultat  -> echec = "erreur lors de l'insertion";
                        }
                    }
                    //si non listé
                    else{
                        //si deja non liste,update de la bouteille.
                        $resultat -> succes = $bte -> modiferBouteilleNonListe($body -> bte);
                        if($resultat -> succes == false){
                                $resultat  -> echec = "erreur lors de la mise à jour";
                            }
                    }
                }
                //si pas de modification
                else{
                    $resultat -> succes = "dup";
                }
            }

            echo trim(json_encode($resultat));
        }

    }

    /**
     * Affiche différentes pages concernant le login selon
     *  si l'utilisateur est connecté ou pas.
     *
     */
    private function compte()
    {
        //Si l'utilisateur est connecté
        if(isset($_SESSION["idUtilisateur"]) && $_SESSION["idUtilisateur"] != ""){
            //Afficher informations de l'utilisateur
            $monCpt = new Login();
            $donnees = $monCpt->getCompte($_SESSION["emailUtilisateur"]);
            include("vues/entete.php");
            include("vues/monCompte.php");
            include("vues/pied.php");
        }
        else{
            //Afficher la page de login
            include("vues/entete.php");
            include("vues/login.php");
            include("vues/pied.php");
        }
    }

    /**
     * Vérifie l'authentification de l'utilisateur puis le redirige vers
     *  la page "monCompte.php" si l'authentification est acceptée. Dans le
     *  cas inverse, l'utilisateur reste sur la page de login.
     *
     */
    private function login()
    {
        $body = json_decode(file_get_contents('php://input'));
        
        if(!empty($body)){
            if($body->courrielCo == "" && $body->motPasseCo == ""){
                echo json_encode(false);
            }
            else{
                $log = new Login();
                
                $correcteInfos = $log->authentification($body);
                echo json_encode($correcteInfos);

                //Création de la variable session lorsque la connexion réussie
                if($correcteInfos == true)
                {
                    $infosCompte = $log->getCompte($body->courrielCo);
                    $_SESSION["idUtilisateur"] = $infosCompte["id_usager"];
                    $_SESSION["nomUtilisateur"] = $infosCompte["nom"];
                    $_SESSION["prenomUtilisateur"] = $infosCompte["prenom"];
                    $_SESSION["emailUtilisateur"] = $infosCompte["email"];
                }
        
            } 
            
        }
        else
        {
            echo json_encode(false);
        }
        
    }

    /**
     * Ferme la session en cours afin de déconnecter l'utilisateur
     *  puis le redirige vers la page de connexion.
     *
     */
    private function deconnexion()
    {
        $_SESSION = array();

        if(isset($_COOKIE[session_name()]))
        {
            setcookie(session_name(), '', time() - 3600);
        }

        session_destroy();

        $msgConfirmation = "Votre session à bien été fermée.";
        include("vues/entete.php");
        include("vues/login.php");
        include("vues/pied.php");
    }

    /**
     * Redirige l'utilisateur vers la page d'inscription.
     *
     */
    private function inscription()
    {
        //Si l'utilisateur est connecté
        if(isset($_SESSION["idUtilisateur"]) && $_SESSION["idUtilisateur"] != "")
        {
            include("vues/entete.php");
            include("vues/monCompte.php");
            include("vues/pied.php");
        }
        else
        {
            include("vues/entete.php");
            include("vues/inscription.php");
            include("vues/pied.php");
        }
    }

    /**
     * Ferme la session en cours afin de déconnecter l'utilisateur
     *  puis le redirige vers la page de connexion.
     *
     */
    private function creerCompteUsager()
    {
        $body = json_decode(file_get_contents('php://input'));
        if(!empty($body)){
            $cpt = new Login();
            $ajoutFonctionel = $cpt->nouveauCompte($body);
            
            
            if($ajoutFonctionel == true){
                
                $infosCompte = $cpt->getCompte($body->courrielInscri);
                $_SESSION["idUtilisateur"] = $infosCompte["id_usager"];
                $_SESSION["nomUtilisateur"] = $infosCompte["nom"];
                $_SESSION["prenomUtilisateur"] = $infosCompte["prenom"];
                $_SESSION["emailUtilisateur"] = $infosCompte["email"];
                echo json_encode($ajoutFonctionel);
            }
            else{
                echo json_encode(false);
            }
        }
        else
        {
            echo json_encode(false);   
        }
    }

/*
    /**
     * affiche le formulaire de modification et affectues les 
     *  modifications.
     *
    *//*
    private function modificationCompte()
    {  
        $body = json_decode(file_get_contents('php://input'));
        if(!empty($body)){

        }
    }

*/
}
?>















