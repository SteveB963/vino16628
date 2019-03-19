<?php
/**
 * Class Login
 * Cette classe permet de vérifier l'autentification de l'utilisateur
 * 
 * @author Alyson Métivier
 * @version 1.0
 * @update 2019-03-18
 * @license Creative Commons BY-NC 3.0 (Licence Creative Commons Attribution - Pas d’utilisation commerciale 3.0 non transposé)
 * @license http://creativecommons.org/licenses/by-nc/3.0/deed.fr
 * 
 */
class Login extends Modele{
	const TABLE = 'usager';

	/**
	 * Vérifie que les informations entrées son correcte
     *
     * @param string $nomUtilisateur Le nom d'utilisateur entré dans le formulaire
     *		  string $motDePasse Le mot de passe entré dans le formulaire
	 *  
	 * @return boolean	true Signifie que les informations sont correcte
	 *		   boolean	false Signifie que les informations sont fausses
	 */
    public function authentification($nom, $prenom, $motDePasse)
	{
		var_dump($nom . $prenom . $motDePasse);
		$rows = Array();
		//À ajouter pour filtrer les variables: mysqli_real_escape_string
		$res = $this->_db->query('SELECT motpasse FROM ' . self::TABLE . ' WHERE nom = "' . $nom . '" AND prenom = "' . $prenom . '"');
		//SELECT motpasse FROM usager WHERE nom = 'Jean' AND prenom = 'Admin'

		if($res->num_rows)
		{

            while($row = $res->fetch_assoc())
            {
            	var_dump($row["motpasse"]);
            	//Si le mot de passe est identique...
            	if(/*password_verify($motDePasse, $row)*/ $motDePasse == $row["motpasse"]){
            		//Retourne vrai
            		return true;
            	}else{
            		//Sinon, retourne faux
            		return false;
            	}
            }
		}
	}
}




?>