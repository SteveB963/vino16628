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
            case 'supprimerBouteille':
                $this->supprimerBouteille();
                break;
            case 'modifierBouteilleCellier':
                $this->modifierBouteilleCellier();
                break;
            case 'boireBouteille':
                $this->boireBouteille();
                break;
            case 'modifierContenuCellier':
                $this->modifierContenuCellier();
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
            case 'modifierNomCellier':
                $this->modifierNomCellier();
                break;
            case 'supprimerCellier':
                $this->supprimerCellier();
                break;
            case 'autocompleteCherche':
                $this->autocompleteCherche();
                break;
            default:
                $this->accueil();
                break;
        }
    }

    /**
     * Affiche la page d'accueil si l'utilisateur n'est pas connecté. Sinon,
     *  l'accueil devient la page de la liste des celliers.
     *
     */
    private function accueil()
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
            include("vues/accueil.php");
            include("vues/pied.php");
        }
    }

    /**
     * Affiche la liste des bouteilles d'un cellier
     *
     */
    private function afficheContenuCellier()
    {
        if(isset($_SESSION["idUtilisateur"]) && $_SESSION["idUtilisateur"] != "")
        {
            if(isset($_GET['id_cellier'])){
               if(isset($_GET['inputCherche'])){
                    $cherche = $_GET['inputCherche'];
                }
                else{
                    $cherche='';
                }
               if(isset($_GET['trierCellier'])){
                    $trier = $_GET['trierCellier']; 
                }
                else{
                    $trier = "nom";
                }
                $bte = new Bouteille();
                $data['info'] = $bte->getInfoBouteilleCellier($_GET['id_cellier'], $trier,$cherche);
                
                //affichage le numero de resultat de recherche 
                if($cherche!=''){
                    $msgCount='<h4> Resultat-' .sizeof($data['info']).' Bouteille Trouvé</h4>';
                }
                else{
                    $msgCount='';
                }
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

    /**
     * Affiche la liste des celliers d'un usager
     *
     */
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
     * Affiche le recherche champ
     */
     private function autocompleteCherche()
    {
       
            $body = json_decode(file_get_contents('php://input'));
             //var_dump($_GET['id_cellier']);
            $bte = new Bouteille();
            $list = $bte->autocompleteCherche($body->chercheValue,$body->id_cellier);
            echo json_encode($list);
        
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
    
		
    /**
     * Créer un nouveau cellier d'un usager
     */
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
                $page = "creer";
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
        $resultat = $cellier -> boireBouteille($body -> id);
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
     * supprimer tous les bouteilles du même id dans un cellier
     *
     */
    private function supprimerBouteille(){
        $body = json_decode(file_get_contents('php://input'));
        $cellier = new Cellier();
        $resultat = $cellier -> supprimerBouteille($body);
        echo json_encode($resultat);
    }
    
    /**
     * Modifie la date d'ajout et la date garder jusqu'à d'un bouteille dans un cellier
     *
     */
    private function modifierContenuCellier(){
        $body = json_decode(file_get_contents('php://input'));
        $cellier = new Cellier();
        $resultat['succes'] = $cellier -> modifierBouteille($body);
        $resultat['donnee'] = $body;
        
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
            $resultat -> succes = false;
        
            //récupération des infos de la bouteille avant modif
            $bte = new Bouteille();
            $bteAvant = $bte -> getBouteille($body -> id_bouteille);
            //tableau contenant les modif.
            $bteNouvelle = (array) $body;

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
                if($body -> non_liste == 0){
                    //ajoute nouvelle bouteille non-liste
                    $resultat -> succes = $bte -> ajouterBouteilleNonListe($body);

                    //remplace la bouteille liste par la nouvelle bouteille non liste
                    if($resultat -> succes == true){
                        //recupération de l'id du dernier ajout
                        $dernId = $bte -> getDernBouteille();
                        $resultat -> idNouvelle = $dernId;
                        //remplace l'id_bouteille dans le cellier avec la nouvelle id
                        $resultat -> succes = $bte -> remplaceBouteilleCellier($body -> id_cellier, $body-> id_bouteille, $dernId);

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
                    $resultat -> succes = $bte -> modiferBouteilleNonListe($body);
                    if($resultat -> succes == false){
                        $resultat  -> echec = "erreur lors de la mise à jour";
                    }
                }
            }
            //si pas de modification
            else{
                $resultat -> succes = "dup";
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
            //Afficher message de confirmation au retour d'une modification
            if(isset($_GET["modif"])){
                $msgConfirmation = "Les modifications ont bien été effectués.";
            }
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
        
        //Si le formulaire à été rempli...
        if(!empty($body)){
            //et que les valeurs sont vides
            if($body->courrielCo == "" && $body->motPasseCo == ""){
                //retourne false
                echo json_encode(false);
            }
            //Sinon, les valeurs entrées ne sont pas vide
            else{
                //On vérifie si le courriel et le mot de passe sont correctes
                //grâce à la fonction d'authentification
                $log = new Login(); 
                $correcteInfos = $log->authentification($body);
                //retourne un boolean qui correspond à la réussite ou à
                //l'échec de l'authentification
                echo json_encode($correcteInfos);

                //Création de la variable session lorsque la connexion à réussie
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
            //Retourne false si le formulaire n'a pas été rempli
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
        //Réinitialisation de la variable $_SESSION
        $_SESSION = array();

        //Faire expirer le $_COOKIE
        if(isset($_COOKIE[session_name()]))
        {
            setcookie(session_name(), '', time() - 3600);
        }

        //Fermeture de la session en cours
        session_destroy();

        //Redirection vers la page de login
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
            //Aller vers la page monCompte.php
            include("vues/entete.php");
            include("vues/monCompte.php");
            include("vues/pied.php");
        }
        else
        {
            //Aller vers la page d'inscription
            $page = "inscription";
            include("vues/entete.php");
            include("vues/inscription.php");
            include("vues/pied.php");
        }
    }

    /**
     * Après que le formulaire ait été rempli correctement, les
     * informations relative au nouveau compte sont vérifier par le modèle
     * puis ajouté à la base de données
     *
     * @return bool     true si la création du compte à fonctionné
     *                  false si la création du compte à échoué
     *
     */
    private function creerCompteUsager()
    {
        $body = json_decode(file_get_contents('php://input'));
        //Si le formulaire à été rempli
        if(!empty($body)){
            //Création du compte
            $cpt = new Login();
            $ajoutFonctionel = $cpt->sauvegardeCompte($body);
            
            //Si la création du compte à fonctionné
            if($ajoutFonctionel == true){
                //Initialisation de la variable $_SESSION 
                $infosCompte = $cpt->getCompte($body->courrielInscri);
                $_SESSION["idUtilisateur"] = $infosCompte["id_usager"];
                $_SESSION["nomUtilisateur"] = $infosCompte["nom"];
                $_SESSION["prenomUtilisateur"] = $infosCompte["prenom"];
                $_SESSION["emailUtilisateur"] = $infosCompte["email"];
                //Retourne true
                echo json_encode($ajoutFonctionel);
            }
            else{
                //Si la création à échoué, retourne false
                echo json_encode(false);
            }
        }
        else
        {
            //Si le formulaire n'a pas été rempli, retourne false
            echo json_encode(false);   
        }
    }


    /**
     * affiche le formulaire de modification et affectue les 
     *  modifications.
     *
    */
    private function modificationCompte()
    {  
        $body = json_decode(file_get_contents('php://input'));
        if(!empty($body)){
            //et que les valeurs sont vides
            if($body->courrielInscri == "" || $body->nomInscri == "" || $body->prenomInscri == ""){
                //retourne "vide"
                $msgRetour = "vide";
                echo json_encode($msgRetour);
            }
            //Sinon, les valeurs entrées ne sont pas vide
            else{
                if($body->courrielInscri == $_SESSION["emailUtilisateur"] && $body->nomInscri == $_SESSION["nomUtilisateur"] && $body->prenomInscri == $_SESSION["prenomUtilisateur"]){
                    //Si la création à échoué, retourne false
                    $msgRetour = "sansModif";
                    echo json_encode($msgRetour);
                }
                else{
                    //Création du compte
                    $cpt = new Login();
                    $modifFonctionel = $cpt->sauvegardeCompte($body, $_SESSION["idUtilisateur"]);
                
                    //Si la création du compte à fonctionné
                    if($modifFonctionel == true){
                        //Initialisation de la variable $_SESSION 
                        $infosCompte = $cpt->getCompte($body->courrielInscri);
                        $_SESSION["nomUtilisateur"] = $infosCompte["nom"];
                        $_SESSION["prenomUtilisateur"] = $infosCompte["prenom"];
                        $_SESSION["emailUtilisateur"] = $infosCompte["email"];
                        //Retourne true
                        $msgRetour = "fonctionnel";
                        echo json_encode($msgRetour);
                    }
                    else{
                        //Si la création à échoué, retourne false
                        $msgRetour = "mail";
                        echo json_encode($msgRetour);
                    }
                }    
            }
        }
        else{
            //Aller vers la page de modification du compte
            $page = "modification";
            include("vues/entete.php");
            include("vues/inscription.php");
            include("vues/pied.php");
        }
    }



    private function modifierNomCellier()
    {  
        $body = json_decode(file_get_contents('php://input'));
        
        
        if(!empty($body)){ 
            
            $cel = new Cellier();
            $data["nomCellier"] = $body->nom;
            $data["id_cellier"] = $body->id_cellier;

                                
            $resultat = $cel->modifierNomCellier($data);				
            echo json_encode($resultat);
        }
        else{
            //Aller vers la page de modification du compte
            $cel = new Cellier();
            $donnee['cellier'] = $cel->getNomCellier($_GET['id_cellier']);
            
            include("vues/entete.php");
            include("vues/modifierNomCellier.php");
            include("vues/pied.php");
        }
    }

    private function supprimerCellier()
    {  
       
        
        $body = json_decode(file_get_contents('php://input'));
        
            $cel = new Cellier();
            $resultat = $cel->supprimerCellier($body -> id_cellier);
            echo json_encode($resultat);
           
    }
    

}

?>















