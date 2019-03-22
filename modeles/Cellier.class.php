<?php
/**
 * Class Bouteille
 * Cette classe possède les fonctions de gestion des bouteilles dans le cellier et des bouteilles dans le catalogue complet.
 * 
 * @author Jonathan Martel
 * @version 1.0
 * @update 2019-01-21
 * @license Creative Commons BY-NC 3.0 (Licence Creative Commons Attribution - Pas d’utilisation commerciale 3.0 non transposé)
 * @license http://creativecommons.org/licenses/by-nc/3.0/deed.fr
 * 
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
		$requete = "INSERT INTO cellier(id_usager,nom) VALUES (".
		"'".$data->id_usager."',".
		"'".$data->nom."')";

        $res = $this->_db->query($requete);
        
		return $res;
	}   
	
	

 /**
	 * récupère tous les cellier d'un usager
	 * 
	 * @param int $id id d'usager !!!À VENIR
     * 
	 * @return Array $rows les informations de chaque cellier 
     * ///////////////////DOIT AJOUTER UN ID POUR SELECTIONNER LE CELLIER////////////////////
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








    
    
}




?>