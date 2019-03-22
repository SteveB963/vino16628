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
	 */
    public function getBouteille($id)
	{
        
		$rows = Array();
		$res = $this->_db->query('SELECT 
                                    b.id_bouteille,
                                    b.nom,
                                    b.image,
                                    b.prix,
                                    b.format,
                                    b.millesime,
                                    b.non_liste,
                                    b.code_saq,
                                    b.url_saq,
                                    t.type,
                                    p.pays 
                                    FROM '. self::TABLE . ' b 
                                    JOIN bouteille_type t ON t.id_type = b.type
                                    JOIN pays p ON p.id_pays = b.pays 
                                    WHERE b.id_bouteille = ' . $id);
		if($res->num_rows)
		{
            $row = $res->fetch_assoc();
		}
		
		return $row;
	}
    
    /**
	 * récupère tous les pays
	 *  
	 * @return Array $rows informations de tous les pays
	 */
    public function getPays()
	{
		$rows = Array();
		$res = $this->_db->query('SELECT * FROM pays');
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
	 * récupère tous les types de vins
	 *  
	 * @return Array $rows informations de tous les types
	 */
    public function getType()
	{
		$rows = Array();
		$res = $this->_db->query('SELECT * FROM bouteille_type');
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
	public function getListeBouteilleCellier($id_cellier,$trier='nom') 
	{
		
		$rows = Array();
		//choisir le type de  trier (type,prix,code, format etc..)
		//test
        $requete ="SELECT 
                        c.*,
                        b.id_bouteille AS id, 
                        b.prix, 
                        b.nom AS nom, 
                        b.image AS image, 
                        b.code_saq AS code_saq, 
                        b.url_saq, 
                        p.pays AS pays, 
                        b.millesime AS millesime ,
                        b.format,
                        t.type AS type 
                        FROM cellier_contenu c
                        JOIN bouteille b ON id = c.id_bouteille 
                        JOIN pays p ON p.id_pays = b.pays
                        JOIN bouteille_type t ON t.id_type = b.type
                        WHERE c.id_cellier = '. $id_cellier.'
                        ORDER BY '.$trier.' ASC";
                       
                       
      
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
		 
		$requete ='SELECT id_bouteille, nom FROM bouteille where LOWER(nom) like LOWER("%'. $nom .'%") LIMIT 0,'. $nb_resultat; 
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
			throw new Exception("Erreur de requête sur la base de données", 1);
			 
		}
		return $rows;
	}
	
	/**
	 * Cette méthode permet de retourner les résultats de recherche pour la fonction d'autocomplete de le valeur de recherche
	 * 
	 * @param string $cherche La chaine de caractère à rechercher
	 * @param integer $nb_resultat Le nombre de résultat maximal à retourner.
	 * 
	 * @throws Exception Erreur de requête sur la base de données 
	 * 
	 * @return array result de le valeur dans le base de donnees
     *  
	 */
       
	public function autocompleteCherche($cherche, $nb_resultat=10)
	{
		
		$rows = Array();
		$cherche = $this->_db->real_escape_string($cherche);
        //replace le space avec%
		$cherche = preg_replace("/\s/","%" , $cherche);
		
        $requete ='SELECT nom as resultat FROM bouteille where LOWER(nom) like LOWER("%'. $cherche .'%")
        UNION All
        SELECT distinct pays.pays as resultat FROM bouteille JOIN pays ON bouteille.pays=pays.id_pays where LOWER(pays.pays) like LOWER("%'. $cherche.'%")
        UNION All
        SELECT  prix as resultat FROM bouteille where LOWER(prix) like LOWER("%'. $cherche.'%")
        UNION All
        SELECT  type as resultat FROM bouteille_type where LOWER(type) like LOWER("%'. $cherche.'%")
        UNION All
        SELECT  format as resultat FROM bouteille where LOWER(format) like LOWER("%'. $cherche.'%")
        UNION All
        SELECT millesime as resultat FROM bouteille where LOWER(millesime) like LOWER("%'. $cherche.'%")
        UNION All
        SELECT code_saq as resultat FROM bouteille where LOWER(code_saq) like LOWER("%'.$cherche.'%")
        LIMIT 0,'. $nb_resultat;
        
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
			throw new Exception("Erreur de requête sur la base de données", 1);
			 
		}
		return $rows;
	}
    	/**
	 *
	/**
	 * Cette méthode ajoute une ou des payss au cellier
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
    // requette pour cherche le valeur en cellier
    public function ChercheEnCellier($cherche) 
	{
		
		$rows = Array();
        //filtre le data par value de champ recherche
        $requete ='SELECT
                        c.*,
                        b.id_bouteille AS id, 
                        b.prix, 
                        b.nom AS nom, 
                        b.image AS image, 
                        b.code_saq AS code_saq, 
                        b.url_saq, 
                        p.pays AS pays, 
                        b.millesime AS millesime ,
                        b.format,
                        t.type AS type 
                        FROM cellier_contenu c
                        JOIN bouteille b ON id = c.id_bouteille 
                        JOIN pays p ON p.id_pays = b.pays
                        JOIN bouteille_type t ON t.id_type = b.type
                        WHERE c.id_cellier = 1
                        AND (b.nom like LOWER("%'. $cherche .'%")
                        OR b.nom like LOWER("%'. $cherche .'%")
                        OR b.prix like LOWER("%'. $cherche .'%")
                        OR b.code_saq like LOWER("%'. $cherche .'%")
                        OR p.pays like LOWER("%'. $cherche .'%")
                        OR b.millesime like LOWER("%'. $cherche .'%")
                        OR b.format like LOWER("%'. $cherche .'%")
                        OR t.type like LOWER("%'. $cherche .'%")
                        OR c.quantite like LOWER("%'. $cherche .'%"))
                    '; 
        //var_dump($requete);
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

		return $rows;
	}
	
    
}




?>