<?php
/**
 * Class Pays
 * Cette classe possède les fonctions de gestion des pays.
 *
 * @Pays.class.php
 * @project vino
 * 
 */
class Pays extends Modele {
	const TABLE = 'pays';
    
    /**
     * récupère tous les pays et leur informaitons
     *
     * @return Array $rows tableau de tableau avec les informations de chaque pays
     */
    public function getTousPays()
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
     * récupère les info d'un pays grace à un nom de pays
     *
     * @return Array $row tableau avec les informations d'un pays
     */
    public function getIdPays($pays)
	{
		$rows = Array();
		$res = $this->_db->query('SELECT * FROM ' . self::TABLE . ' WHERE pays = ' . $pays);
		if($res->num_rows){
            $row = $res->fetch_assoc();
		}
		return $row;
	}
    
}

?>