<?php
/**
 * Class Cellier
 * Cette classe possède les fonctions de gestion des celliers.
 * 
 * @file Cellier.class.php
 * @project vino
 */
class Cellier extends Modele {
	const TABLE = 'cellier';
    
     /**
	 * Cette méthode crée un cellier
	 * 
	 * @param Array $data Tableau des données représentants le cellier.
	 * 
	 */
	public function creerUnNouveauCellier($data)
	{
		$rows = Array();
		$allCelliers = $this->_db->query('SELECT nom FROM ' . self::TABLE . ' WHERE id_usager = ' . $_SESSION["idUtilisateur"]);
		$nomExistant = false;
		//Vérifier si le nom entrer pour la création du nouveau
		//cellier est déjà existant
		if($allCelliers->num_rows)
		{

            while($row = $allCelliers->fetch_assoc())
            {
            	if(strtolower($data["nomCellier"]) == strtolower($row["nom"])){
            		$nomExistant = true;
            		break;
            	}else{
            		$nomExistant = false;
            	}
            }
		}

		if($nomExistant == false)
		{
			$requete = "INSERT INTO cellier(id_usager,nom) VALUES (".
			"'".$data["idUsager"]."',".
			"'".strtolower($data["nomCellier"])."')";
			$res = $this->_db->query($requete);			
			return $res;
		}
		else if($nomExistant == true){
			return false;

		}
	} 
	
	public function modifierNomCellier($data)
	{
		$rows = Array();
		$allCelliers = $this->_db->query('SELECT * FROM ' . self::TABLE . ' WHERE id_usager = ' . $_SESSION["idUtilisateur"]);
		$nomExistant = false;
		//Vérifier si le nom entrer pour la création du nouveau
		//cellier est déjà existant
		// $nom=getNomCellier($data["id_cellier"])['nom'];
		 if($allCelliers->num_rows)
		{

            while($row = $allCelliers->fetch_assoc())
            {
            	if(strtolower($data["nomCellier"]) == strtolower($row["nom"])){
					if($data["id_cellier"]==$row["id_cellier"]){
						$nomExistant = false;
					}
					else
            		$nomExistant = true;
            		break;
            	}else{
            		$nomExistant = false;
            	}
            }
		}

		if($nomExistant == false)
		{
			// var_dump($data["nomCellier"]);
			// die();
			

			$requete = "UPDATE cellier SET 
			nom = "."'".strtolower($data["nomCellier"])."' WHERE id_cellier = " . $data["id_cellier"];
			$res = $this->_db->query($requete);			
			return $res;
		}
		else if($nomExistant == true){
			return false;

		}
	}
	
	

    /**
	 * récupère tous les cellier d'un usager
	 * 
	 * @param int $id id d'usager
     * 
	 * @return Array $rows les informations de chaque cellier 
	 */
	public function getListeCellier($id) 
	{
		
		$rows = Array();
		$requete = 'SELECT * FROM cellier WHERE id_usager = ' . $id;		
		if(($res = $this->_db->query($requete)) ==	 true)
		{
			if($res->num_rows)
			{
				while($row = $res->fetch_assoc())
				{
					$rows[] = $row;
				}
			}
		}
		else 
			{
				throw new Exception("Erreur de requête sur la base de donnée", 1);
			}
		return $rows;
	}
    
    
    /**
	 * récupère le contenu d'un cellier
	 * 
	 * @param int $id_cellier id du cellier
     * 
	 * @return Array $rows 
	 */
	public function getContenuCellier($id_cellier) 
	{
		$rows = Array();
        $requete ='SELECT 
                        * 
                        FROM ' . self::TABLE . '_contenu 
                        WHERE id_cellier = ' . $id_cellier . ' 
                        ORDER BY date_ajout ASC';
      
		if(($res = $this->_db->query($requete)) == true)
		{
			if($res->num_rows)
			{
				while($row = $res->fetch_assoc())
				{
					$rows[] = $row;
				}
			}
		}
		else 
		{
			throw new Exception("Erreur de requête lors de la récuperation des bouteilles", 1);
		}
        
		return $rows;
        
        
	}
    
    /**
	 * récupère la derniere ajout dans la table cellier_contenu
     * 
	 * @return Array $rows donne du dernier ajout
	 */
	public function getDernAjout() 
	{
        $requete ='SELECT * FROM ' . self::TABLE . '_contenu WHERE id =(SELECT MAX(id) FROM ' . self::TABLE . '_contenu)';
    
      
		if(($res = $this->_db->query($requete)) == true)
		{
			if($res->num_rows)
			{
				$row = $res->fetch_assoc();
			}
		}
		else 
		{
			throw new Exception("Erreur de requête sur la base de donnée", 1);
		}
		return $row;
	}
    
    
    /**
	 * supprime une bouteille dans le cellier
	 * 
	 * @param int $id ranger dans le contenu cellier a supprimer
	 * 
	 * @return Boolean Succès ou échec de la suppression.
	 */
	public function boireBouteille($id)
	{
		$requete = 'DELETE FROM cellier_contenu WHERE id = ' . $id;
        $res = $this->_db->query($requete);
        
		return $res;
	}
    
    
    /**
	 * ajouter un bouteille dans le contenu du cellier
	 * 
	 * @param object $data date ajout et date garde jusqua
	 * 
	 * @return Boolean Succès ou échec de l'ajout.
	 */
	public function ajouterBouteille($data)
	{
		$requete = 'INSERT INTO cellier_contenu (id_cellier, id_bouteille, date_ajout, garde_jusqua) VALUE
            (' . $data -> id_cellier . ',
            ' . $data -> id_bouteille . ',
            "' . $data -> date_ajout . '",
            "' . $data -> garde_jusqua . '")';
        
        $res = $this->_db->query($requete);
        
		return $res;
	}
    
    /**
	 * modifie la date ajout et la date garde jusqua d'un bouteille dans le cellier
	 * 
	 * @param object $data les nouvelles dates
	 * 
	 * @return Boolean Succès ou échec de la modification
	 */
	public function modifierBouteille($data)
	{
		$requete = 'UPDATE cellier_contenu SET
            date_ajout = "' . $data -> date_ajout . '", 
            garde_jusqua = "' . $data -> garde_jusqua . '" 
            WHERE id = ' . $data -> id;
        
        $res = $this->_db->query($requete);
        
		return $res;
	}
    
    /**
	 * supprimer tout les bouteilles du même id dans un cellier
	 * 
	 * @param object $data id du cellier et id de bouteille
	 * 
	 * @return Boolean Succès ou échec de la suppression
	 */
	public function supprimerBouteille($data)
	{
		$requete = 'DELETE FROM cellier_contenu 
            WHERE id_bouteille = ' . $data -> id_bouteille . ' 
            AND id_cellier = ' . $data -> id_cellier;
        
        $res = $this->_db->query($requete);
        
		return $res;
	}

    
	public function getNomCellier($id)
	{
		$row = Array();
		
        $res = $this->_db->query('SELECT 
                                    * 
                                    FROM '. self::TABLE . '
                                    WHERE id_cellier = ' . $id);
		if($res->num_rows)
		{
            $row = $res->fetch_assoc();
		}
		
		return $row;
	}
    

	public function supprimerCellier($id)
	{
		$requete = 'DELETE FROM cellier WHERE id_cellier = ' . $id;
        $res = $this->_db->query($requete);
        
		return $res;
	}
    








    
    
}




?>