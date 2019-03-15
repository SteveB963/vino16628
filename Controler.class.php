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
				default:
					$this->accueil();
					break;
			}
		}

        /**
         * Affiche la page d'acceil
         *
         * ////////DOIT ÊTRE MODIFIER POUR POINTER VERS LA PAGE D'ACCEIL////////
         */
		private function accueil()
		{            
			$bte = new Bouteille();
            $data = $bte->getListeBouteilleCellier();
			include("vues/entete.php");
			include("vues/accueil.php");
			include("vues/pied.php");
                  
		}
    
        /**
         * Affiche la liste complète de l'inventaire des bouteilles listées
         *
         */
        /////////////AJOUTÉ FUNCTION POUR AFFICHER TOUT LES BOUTEILLES ICI//////////////
    
    
    
    
    
    
		
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
            $cellier = $bte->getListeBouteilleCellier();
            
            echo json_encode($cellier);
                  
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
         * ?? traitement du formulaire à venir .....
         *
         *  ///////////////////////////////NON COMPLETÉ//////////////////////////////////
         */
        /*
        private function modifierBouteilleCellier()
		{	
			//$body = json_decode(file_get_contents('php://input'));
            
			$bte = new Bouteille();
			$resultat['bouteille'] = $bte->getBouteille($_GET['id']);
			$resultat['pays'] = $bte->getPays();
			$resultat['type'] = $bte->getType();
            
            //echo json_encode($resultat);
        
            include("vues/entete.php");
			include("vues/formBout.php");
			include("vues/pied.php");
            
		}
		*/
}
?>















