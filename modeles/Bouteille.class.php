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

	public function getListeBouteilleCellier($id_cellier, $trier ='nom',$cherche=0) 
	{
		$rows = Array();
		//choisir le type de  trier (type,prix,code, format etc..)
		//test
       
         $requete ='SELECT distinct
                        c.*,
                        b.id_bouteille, 
                        b.prix, 
                        b.nom, 
                        b.image, 
                        b.code_saq, 
                        b.url_saq, 
                        p.pays, 
                        b.millesime,
                        b.format,
                        t.type 
                        FROM cellier_contenu c
                        JOIN bouteille b ON b.id_bouteille = c.id_bouteille 
                        JOIN pays p ON p.id_pays = b.id_pays
                        JOIN bouteille_type t ON t.id_type = b.id_type';
        
        //ajouter le requette de recherche quand le valeur de recherche est pas vide 
        if(!empty($cherche)){
             $cherche = $this->_db->real_escape_string($cherche);
            //replace le space avec%
            $cherche = preg_replace("/\s/","%" , $cherche);
            $requete .=' WHERE (b.nom like LOWER("%'. $cherche .'%")
                        OR b.nom like LOWER("%'. $cherche .'%")
                        OR b.prix like LOWER("%'. $cherche .'%")
                        OR b.code_saq like LOWER("%'. $cherche .'%")
                        OR p.pays like LOWER("%'. $cherche .'%")
                        OR b.millesime like LOWER("%'. $cherche .'%")
                        OR b.format like LOWER("%'. $cherche .'%")
                        OR t.type like LOWER("%'. $cherche .'%")
                        OR c.quantite like LOWER("%'. $cherche .'%"))';
        }
        $requete .= ' AND c.id_cellier = ' . $id_cellier . '
                                ORDER BY '.$trier;
           //var_dump($requete)  ;          
      
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
	 * ajoute une bouteille non liste
	 * 
	 * @param Array $data Tableau des données représentants la bouteille.
	 * 
	 * @return Boolean Succès ou échec de l'ajout.
	 */
	public function ajouterBouteilleNonListe($data)
	{
        $requete = "INSERT INTO bouteille(nom, image, prix, format, id_type, id_pays, millesime, code_saq, url_saq, non_liste) VALUES (" .
        "'" . $data->nom . "'," .
        "'" . $data->image . "'," .
        "'" . floatval($data->prix) . "'," .
        "'" . intval($data->format) . "'," .
        "'" . intval($data->id_type) . "'," .
        "'" . intval($data->id_pays) . "'," .
        "'" . intval($data->millesime) . "'," .
        "'" . intval($data->code_saq) . "'," .
        "'" . $data->url_saq . "'," .
        "1)";

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
	public function modiferBouteilleNonListe($data)
	{
		$requete = "UPDATE bouteille SET 
            nom = '" . $data->nom . "'," .
            "image = '" . $data->image . "'," .
            "prix = '" . floatval($data->prix) . "'," .
            "format = '" . intval($data->format) . "'," .
            "id_type = '" . intval($data->id_type) . "'," .
            "id_pays = '" . intval($data->id_pays) . "'," .
            "millesime = '" . intval($data->millesime) . "'," .
            "code_saq = '" . intval($data->code_saq) . "'," .
            "url_saq = '" . $data->url_saq . "'," .
            "non_liste = 1 
            WHERE id_bouteille = " . $data -> id_bouteille;
        
        $res = $this->_db->query($requete);
        
		return $res;
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
       
	public function autocompleteCherche($cherche, $id_cellier=1)
	{
		
		$rows = Array();
		$cherche = $this->_db->real_escape_string($cherche);
        //replace le space avec%
		$cherche = preg_replace("/\s/","%" , $cherche);
		
        /*$requete ='SELECT distinct b.nom as resultat FROM cellier_contenu cc JOIN cellier c ON c.id_cellier=cc.id_cellier JOIN bouteille b ON cc.id_bouteille=b.id_bouteille where LOWER(b.nom) like LOWER("%'. $cherche .'%") AND c.id_cellier=1
        UNION
        SELECT distinct p.pays as resultat FROM bouteille b JOIN pays p ON b.id_pays=p.id_pays JOIN cellier_contenu cc ON cc.id_bouteille=b.id_bouteille where LOWER(p.pays) like LOWER("%'. $cherche.'%") AND cc.id_cellier=1
        UNION 
        SELECT distinct b.prix as resultat FROM cellier_contenu cc JOIN cellier c ON c.id_cellier=cc.id_cellier JOIN bouteille b ON cc.id_bouteille=b.id_bouteille where LOWER(b.prix) like LOWER("%'. $cherche .'%") AND c.id_cellier=1
        UNION
        SELECT distinct b.format as resultat FROM cellier_contenu cc JOIN cellier c ON c.id_cellier=cc.id_cellier JOIN bouteille b ON cc.id_bouteille=b.id_bouteille where LOWER(b.format) like LOWER("%'. $cherche .'%") AND c.id_cellier=1
        UNION
        SELECT distinct b.millesime as resultat FROM cellier_contenu cc JOIN cellier c ON c.id_cellier=cc.id_cellier JOIN bouteille b ON cc.id_bouteille=b.id_bouteille where LOWER(b.millesime) like LOWER("%'. $cherche .'%") AND c.id_cellier=1
        UNION
        SELECT distinct b.code_saq as resultat FROM cellier_contenu cc JOIN cellier c ON c.id_cellier=cc.id_cellier JOIN bouteille b ON cc.id_bouteille=b.id_bouteille where LOWER(b.code_saq) like LOWER("%'. $cherche .'%") AND c.id_cellier=1
        LIMIT 0,'. $nb_resultat;*/

        //cherche le valeur en nom
        $requete ='SELECT distinct b.nom as nom  FROM cellier_contenu cc JOIN cellier c ON c.id_cellier=cc.id_cellier JOIN bouteille b ON cc.id_bouteille=b.id_bouteille where LOWER(b.nom) like LOWER("%'. $cherche .'%") AND c.id_cellier='. $id_cellier;
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
        
        //cherche le valeur en pays
        $requete ='SELECT distinct p.pays as pays FROM bouteille b JOIN pays p ON b.id_pays=p.id_pays JOIN cellier_contenu cc ON cc.id_bouteille=b.id_bouteille where LOWER(p.pays) like LOWER("%'. $cherche.'%") AND cc.id_cellier='. $id_cellier;
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
        
        //cherche le valeur en prix
        $requete ='SELECT distinct b.prix as prix FROM cellier_contenu cc JOIN cellier c ON c.id_cellier=cc.id_cellier JOIN bouteille b ON cc.id_bouteille=b.id_bouteille where LOWER(b.prix) like LOWER("%'. $cherche .'%") AND c.id_cellier='. $id_cellier;
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
        
        //cherche le valeur en Type
        $requete ='SELECT distinct t.type as type FROM bouteille b JOIN bouteille_type t ON b.id_type=t.id_type JOIN cellier_contenu cc ON cc.id_bouteille=b.id_bouteille where LOWER(t.type) like LOWER("%'. $cherche.'%") AND cc.id_cellier='. $id_cellier;
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
        //cherche le valeur en format
        $requete ='SELECT distinct b.format as format FROM cellier_contenu cc JOIN cellier c ON c.id_cellier=cc.id_cellier JOIN bouteille b ON cc.id_bouteille=b.id_bouteille where LOWER(b.format) like LOWER("%'. $cherche .'%") AND c.id_cellier='. $id_cellier;
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
        
        //cherche le valeur en millesime
        $requete ='SELECT distinct b.millesime as millesime FROM cellier_contenu cc JOIN cellier c ON c.id_cellier=cc.id_cellier JOIN bouteille b ON cc.id_bouteille=b.id_bouteille where LOWER(b.millesime) like LOWER("%'. $cherche .'%") AND c.id_cellier='. $id_cellier;
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
        
        //cherche le valeur en code_saq
        $requete ='SELECT distinct b.code_saq as code FROM cellier_contenu cc JOIN cellier c ON c.id_cellier=cc.id_cellier JOIN bouteille b ON cc.id_bouteille=b.id_bouteille where LOWER(b.code_saq) like LOWER("%'. $cherche .'%") AND c.id_cellier='. $id_cellier;
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
    public function ChercheEnCellier($id_cellier,$cherche) 
	{
		
		$rows = Array();
        //filtre le data par value de champ recherche
        $requete ='SELECT 
                        c.*,
                        b.id_bouteille, 
                        b.prix, 
                        b.nom, 
                        b.image, 
                        b.code_saq, 
                        b.url_saq, 
                        p.pays, 
                        b.millesime,
                        b.format,
                        t.type 
                        FROM cellier_contenu c
                        JOIN bouteille b ON b.id_bouteille = c.id_bouteille 
                        JOIN pays p ON p.id_pays = b.id_pays
                        JOIN bouteille_type t ON t.id_type = b.id_type
                        AND (b.nom like LOWER("%'. $cherche .'%")
                        OR b.nom like LOWER("%'. $cherche .'%")
                        OR b.prix like LOWER("%'. $cherche .'%")
                        OR b.code_saq like LOWER("%'. $cherche .'%")
                        OR p.pays like LOWER("%'. $cherche .'%")
                        OR b.millesime like LOWER("%'. $cherche .'%")
                        OR b.format like LOWER("%'. $cherche .'%")
                        OR t.type like LOWER("%'. $cherche .'%")
                        OR c.quantite like LOWER("%'. $cherche .'%"))
                        WHERE c.id_cellier = ' . $id_cellier 
                    ; 
        var_dump($requete);
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
	public function remplaceBouteilleCellier($idCellier, $idAncienne, $idNouvelle)
	{
		$requete = "UPDATE cellier_contenu SET id_bouteille = " . $idNouvelle . " WHERE id_cellier = " . $idCellier . " AND id_bouteille = " . $idAncienne;
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
        $requete = "SELECT MAX(id_bouteille) as max FROM " . self::TABLE;
        $res = $this->_db->query($requete);
        
        $row = $res->fetch_assoc();
        
        return $row['max'];
    }
    

    
}




?>