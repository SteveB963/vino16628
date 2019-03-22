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
            case 'listeBouteilleCellier':
                $this->listeBouteilleCellier();
                break;
            case 'autocompleteBouteille':
                $this->autocompleteBouteille();
                break;
            case 'ajouterNouvelleBouteilleCellier':
                $this->ajouterNouvelleBouteilleCellier();
                break;
            case 'ajouterBouteilleCellier':
                $this->ajouterBouteilleCellier();
                break;
            case 'modifierBouteilleCellier':
                $this->modifierBouteilleCellier();
                break;
            case 'boireBouteilleCellier':
                $this->boireBouteilleCellier();
                break;                
            case 'afficheCellier':
                $this->afficheCellier();
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
     * ///////////TEMPORAIRE/////////////
     */
    private function afficheCellier()
    {

        $bte = new Bouteille();
        $data = $bte->getListeBouteilleCellier($_GET['id_cellier']);
        include("vues/entete.php");
        include("vues/cellier.php");
        include("vues/pied.php");

    }
    private function afficheListCellier()
    {
        if ($_POST['id_usager']){
            $id=$_POST['id_usager'];
            }
        else 
            $id=2;
        include("vues/entete.php");
        $cel = new Cellier();
        $data = $cel->getListeCellier($id);
        include("vues/listCellier.php");
        include("vues/pied.php");
        // header("Refresh:0; url=" . BASEURL . "index.php?requete=afficheListCellier");

    }



     /**
     * 
     *
     * /////////DOIT ÊTRE DOCUMENTÉ ET TESTÉ////////
     */
    private function autocompleteBouteille()
    {
        $bte = new Bouteille();
        $body = json_decode(file_get_contents('php://input'));
        $listeBouteille = $bte->autocomplete($body->nom);

        echo json_encode($listeBouteille);

    }


    /**
     * Affiche le liste de bouteille dans un cellier
     *
     * @param int $id id du cellier à afficher
     *
     * /////////DOIT ÊTRE MODIFIER POUR RÉCUPÉRER UN ID DE CELLIER////////
     */
    private function listeBouteilleCellier()
    {
        $bte = new Bouteille();
        $data = $bte->getListeBouteilleCellier();

        include("vues/entete.php");
        include("vues/cellier.php");
        include("vues/pied.php");


    }

    /**
     * 
     *
     * /////////DOIT ÊTRE DOIT ÊTRE DOCUMENTÉ ET TESTÉ////////
     */
    private function ajouterNouvelleBouteilleCellier()
    {
        $body = json_decode(file_get_contents('php://input'));
        if(!empty($body)){
            $bte = new Bouteille();

            $resultat = $bte->ajouterBouteilleCellier($body);
            echo json_encode($resultat);
        }
        else{
            include("vues/entete.php");
            include("vues/ajouter.php");
            include("vues/pied.php");
        }


    }


    /**
     * Retirer une bouteille du cellier
     * ?? ajout d'une note dans historique pour les statistiques
     *
     */
    private function boireBouteilleCellier()
    {
        $body = json_decode(file_get_contents('php://input'));

        $bte = new Bouteille();
        //retire une bouteille du cellier et récupère la nouvelle quantité
        $resultat = $bte->modifierQuantiteBouteilleCellier($body->id, -1);
        $resultat = $bte->obtenirQuantiteBouteilleCellier($body->id);
        echo json_encode($resultat);
    }

    /**
     * Ajoute une bouteille du cellier
     * ?? ajout d'une note dans historique pour les statistiques
     *
     */
    private function ajouterBouteilleCellier()
    {
        $body = json_decode(file_get_contents('php://input'));

        $bte = new Bouteille();
        //ajoute une bouteille au cellier et récupère la nouvelle quantité
        $resultat = $bte->modifierQuantiteBouteilleCellier($body->id, 1);
        $resultat = $bte->obtenirQuantiteBouteilleCellier($body->id);
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
            $donnee['bouteille'] = $bte->getBouteille($_GET['id']);

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
                            $resultat -> succes = $bte -> remplaceBouteilleCellier($body-> bte -> id_bouteille, $dernId);////////BESOIN D'UN ID CELLIER PROCHIANNEMENT////////
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


    //affiche le page accueil apres choisir le trier(par select box)
    private function uploadPage()
    {
        $bte = new Bouteille();
        include("vues/entete.php");
        $data = $bte->getListeBouteilleCellier($_GET['trierCellier']); 
        include("vues/cellier.php");
        include("vues/pied.php");

    }


    /**
     * Affiche le liste de bouteille dans un cellier
     *
     * @param int $id id du cellier à afficher
     *
     * /////////DOIT ÊTRE MODIFIER POUR RÉCUPÉRER UN ID DE CELLIER////////
     */
    private function listeBouteilleCellier2()
    {
        $bte = new Bouteille();
        $cellier = $bte->getListeBouteilleCellier();

        echo json_encode($cellier);

    }


    private function creerUnCellier()
    {	

        $body = json_decode(file_get_contents('php://input'));
            if(!empty($body)){
                $cel = new Cellier();

                $resultat = $cel->creerUnNouveauCellier($body);				
                echo json_encode($resultat);
                header("Refresh:0; url=" . BASEURL . "index.php?requete=afficheListCellier");			
            }
            else{
                include("vues/entete.php");
                include("vues/creerCellier.php");
                include("vues/pied.php");
            }					

    }
}
?>















