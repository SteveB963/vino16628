<?php
/**
 * Class Type
 * Cette classe possède les fonctions de gestion des types.
 *
 * @Type.class.php
 * @project vino
 * 
 */
class Type extends Modele {
	const TABLE = 'bouteille_type';
    
    /**
     * récupère tous les types et leur informaitons
     *
     * @return Array $rows tableau de tableau avec les informations de chaque types
     */
    public function getTousTypes()
	{
		$rows = Array();
		$res = $this->_db->query('SELECT * FROM ' . self::TABLE);
		if($res->num_rows){
            while($row = $res->fetch_assoc())
			{
				$rows[] = $row;
			}
		}
		return $rows;
	}
    
    /**
     * récupère les info d'un type grace à un nom
     *
     * @return Array $row tableau avec les informations d'un type
     */
    public function getIdType($type)
	{
		$rows = Array();
		$res = $this->_db->query('SELECT * FROM ' . self::TABLE . ' WHERE type = ' . $type);
		if($res->num_rows){
            $row = $res->fetch_assoc();
		}
		return $row;
	}
    
}

?>