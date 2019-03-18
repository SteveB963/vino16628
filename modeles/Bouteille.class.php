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
class Bouteille extends Modele {
	const TABLE = 'bouteille';
    
    /**
	 * Récupère tous les informations sur une bouteille
     *
     * @param int $id id de la bouteille à récupèrer les informations
	 *  
	 * @return Array $rows informations de tous les pays
     * //////////////////////////////NOM PAYS ET TYPE POURAIS ÊTRE RETIRER DE LA REQUETE ???//////////////////////////////
	 */
    public function getBouteille($id)
	{
		$row = Array();
		/*$res = $this->_db->query('SELECT 
                                    b.*,
                                    t.type,
                                    p.pays 
                                    FROM '. self::TABLE . ' b 
                                    JOIN bouteille_type t ON t.id_type = b.id_type
                                    JOIN pays p ON p.id_pays = b.id_pays 
                                    WHERE b.id_bouteille = ' . $id);*/
        $res = $this->_db->query('SELECT 
                                    * 
                                    FROM '. self::TABLE . '
                                    WHERE id_bouteille = ' . $id);
		if($res->num_rows)
		{
            $row = $res->fetch_assoc();
		}
		
		return $row;
	}
    
    
     /**
	 * récupère tous les bouteilles listés 
	 *  
	 * @return Array $rows les informations de chaque bouteille de la bd
     * ///////////////////VÉRIFIER ET TESTER LA REQUETE SQL////////////////////
	 */
	public function getListeBouteille()
	{
		
		$rows = Array();
		$res = $this->_db->query('Select * from '. self::TABLE);
		if($res->num_rows)
		{
			while($row = $res->fetch_assoc())
			{
				$rows[] = $row;
			}
		}
		
		return $rows;
	}
	
    /**
	 * récupère tous les bouteilles d'un cellier
	 * 
	 * @param int $id id du cellier !!!À VENIR
     * 
	 * @return Array $rows les informations de chaque bouteille dans le cellier7
     * ///////////////////DOIT AJOUTER UN ID POUR SELECTIONNER LE CELLIER////////////////////
	 */
	public function getListeBouteilleCellier() 
	{
		$rows = Array();
		$requete ='SELECT 
                        c.*,
                        b.nom,
                        b.image,
                        b.code_saq,
                        b.prix,
                        b.url_saq,
                        b.format,
                        b.millesime,
                        b.non_liste,
                        p.pays,
                        t.type
                        FROM cellier_contenu c
                        JOIN bouteille b ON b.id_bouteille = c.id_bouteille 
                        JOIN pays p ON p.id_pays = b.id_pays
                        JOIN bouteille_type t ON t.id_type = b.id_type
                        WHERE c.id_cellier = 1
						'; ///REMPLACER 1 PAR L'ID DU CELLIER
        
		if(($res = $this->_db->query($requete)) ==	 true)
		{
			if($res->num_rows)
			{
				while($row = $res->fetch_assoc())
				{
					$row['nom'] = trim(utf8_encode($row['nom']));
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
	 * Cette méthode permet de retourner les résultats de recherche pour la fonction d'autocomplete de l'ajout des bouteilles dans le cellier
	 * 
	 * @param string $nom La chaine de caractère à rechercher
	 * @param integer $nb_resultat Le nombre de résultat maximal à retourner.
	 * 
	 * @throws Exception Erreur de requête sur la base de données 
	 * 
	 * @return array id et nom de la bouteille trouvée dans le catalogue
     *  ///////////////////PAS ÉTÉ TESTÉ ENCORE////////////////////////////
	 */
       
	public function autocomplete($nom, $nb_resultat=10)
	{
		
		$rows = Array();
		$nom = $this->_db->real_escape_string($nom);
		$nom = preg_replace("/\*/","%" , $nom);
		 
		$requete ='SELECT id, nom FROM vino__bouteille where LOWER(nom) like LOWER("%'. $nom .'%") LIMIT 0,'. $nb_resultat; 
		if(($res = $this->_db->query($requete)) ==	 true)
		{
			if($res->num_rows)
			{
				while($row = $res->fetch_assoc())
				{
					$row['nom'] = trim(utf8_encode($row['nom']));
					$rows[] = $row;
					
				}
			}
		}
		else 
		{
			throw new Exception("Erreur de requête sur la base de données", 1);
			 
		}
		return $rows;
	}
    
    /**
	 * ajoute une bouteille non liste
	 * 
	 * @param Array $data Tableau des données représentants la bouteille.
	 * 
	 * @return Boolean Succès ou échec de l'ajout.
	 */
	public function ajouterBouteilleNonListe($data)
	{
        $requete = "INSERT INTO bouteille(nom, image, prix, format, type, pays, millesime, code_saq, url_saq, non_liste) VALUES (" .
        "'" . $data->nom . "'," .
        "'" . $data->image . "'," .
        "'" . $data->prix . "'," .
        "'" . $data->format . "'," .
        "'" . $data->type . "'," .
        "'" . $data->pays . "'," .
        "'" . $data->millesime . "',)" .
        "'" . $data->code_saq . "',)" .
        "'" . $data->url_saq . "',)" .
        "'1')";

        $res = $this->_db->query($requete);
        
        return $res;
	}
    
    /**
	 * modifie une bouteille non liste
	 * 
	 * @param Array $data Tableau des données représentants la bouteille.
	 * 
	 * @return Boolean Succès ou échec de l'ajout.
	 */
	public function modifierBouteilleNonListe($data)
	{
		$requete = "INSERT INTO bouteille(nom, image, prix, format, type, pays, millesime, code_saq, url_saq, non_liste) VALUES (" .
		"'" . $data->nom . "'," .
		"'" . $data->image . "'," .
		"'" . $data->prix . "'," .
		"'" . $data->format . "'," .
		"'" . $data->type . "'," .
		"'" . $data->pays . "'," .
		"'" . $data->millesime . "',)" .
		"'" . $data->code_saq . "',)" .
		"'" . $data->url_saq . "',)" .
		"'1')";
        
        $res = $this->_db->query($requete);
        
		return $res;
	}
	
	
	/**
	 * Cette méthode ajoute une ou des bouteilles au cellier
	 * 
	 * @param Array $data Tableau des données représentants la bouteille.
	 * 
	 * @return Boolean Succès ou échec de l'ajout.
     *  ///////////////////PAS ÉTÉ TESTÉ ENCORE////////////////////////////
	 */
	public function ajouterBouteilleCellier($data)
	{
		$requete = "INSERT INTO vino__cellier(id_bouteille,date_achat,garde_jusqua,notes,prix,quantite,millesime) VALUES (".
		"'".$data->id_bouteille."',".
		"'".$data->date_achat."',".
		"'".$data->garde_jusqua."',".
		"'".$data->notes."',".
		"'".$data->prix."',".
		"'".$data->quantite."',".
		"'".$data->millesime."')";

        $res = $this->_db->query($requete);
        
		return $res;
	}
	
	
	/**
	 * Cette méthode change la quantité d'une bouteille en particulier dans le cellier
	 * 
	 * @param int $id id de la bouteille
	 * @param int $nombre Nombre de bouteille a ajouter ou retirer
	 * 
	 * @return Boolean Succès ou échec de l'ajout.
	 */
	public function modifierQuantiteBouteilleCellier($id, $nombre)
	{
		$requete = "UPDATE cellier_contenu SET quantite = GREATEST(quantite + ". $nombre. ", 0) WHERE id = ". $id;
        $res = $this->_db->query($requete);
        
		return $res;
	}
    
    public function obtenirQuantiteBouteilleCellier($id)
	{				
		$requete1 = "SELECT quantite from cellier_contenu WHERE id = ". $id;
		$res = $this->_db->query($requete1);
		$row = $res->fetch_assoc();
        
		return $row;
	}
    
    /**
	 * Remplace l'id d'une bouteille liste par une bouteille non liste
	 * 
	 * @param int $idAncien l'id de l'ancienne bouteille à remplacer
	 * @param int $idAncien l'id de la nouvelle bouteille à remplacer
	 * 
	 * @return Boolean Succès ou échec de l'update
     *
     * /////////////BESOIN D'UN ID DE CELLIER//////////////////
	 */
	public function remplaceBouteilleCellier($idAncienne, $idNouvelle)
	{
		$requete = "UPDATE cellier_contenu SET id_bouteille = " . $idNouvelle . " WHERE id_bouteille = " . $idAncienne;
        $res = $this->_db->query($requete);
        
		return $res;
	}
    
    /**
	 * Retourne l'id de la dernière bouteille entré
	 * 
	 * @param int $idAncien l'id de l'ancienne bouteille à remplacer
	 * @param int $idAncien l'id de la nouvelle bouteille à remplacer
	 * 
	 * @return Boolean Succès ou échec de l'update
	 */
    public function getDernBouteille(){
        $requete = "SELECT MAX(id_bouteille) FROM " . self::TABLE;
        $resultat = $this->_db->query($requete);
        
        return $resultat;
    }
    
    
}




?>