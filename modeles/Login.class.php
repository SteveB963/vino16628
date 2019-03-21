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
    public function authentification($data)
	{
		$rows = Array();
		//À ajouter pour filtrer les variables: mysqli_real_escape_string
		$res = $this->_db->query('SELECT motpasse FROM ' . self::TABLE . ' WHERE email = "' . $data->courrielCo . '"');
		//SELECT motpasse FROM usager WHERE nom = 'Jean' AND prenom = 'Admin'

		if($res->num_rows)
		{

            while($row = $res->fetch_assoc())
            {
            	//Si le mot de passe est identique...
            	if(password_verify($data->motPasseCo, $row["motpasse"]) /*$motDePasse == $row["motpasse"]*/){
            		//Retourne vrai
            		return true;
            	}else{
            		//Sinon, retourne faux
            		return false;
            	}
            }
		}
	}

	/**
	 * Ajout - Création d'un nouveau compte usager
     *
     * @param string $prenomInscri Le prenom d'utilisateur entré dans le formulaire
     *		  string $nomInscri Le nom d'utilisateur entré dans le formulaire
     *		  string $courrielInscri Le courriel d'utilisateur entré dans le 
     *		  		 formulaire
     *		  string $motDePasse Le mot de passe entré dans le formulaire
     *
     * @return boolean true si la création du compte est possible
     *		   boolean false si la création du compte est impossible
	 *  
	 */
    public function nouveauCompte($data)
	{
		$rows = Array();
		$allMails = $this->_db->query('SELECT email FROM ' . self::TABLE);
		$mailExistant = false;

		//echo($data->prenomInscri);

		//Vérifier si le email entrer pour la création du nouveau
		//compte est déjà existant
		if($allMails->num_rows)
		{

            while($row = $allMails->fetch_assoc())
            {
            	if($data->courrielInscri == $row["email"]){
            		$mailExistant = true;
            		break;
            	}else{
            		$mailExistant = false;
            	}
            }
		}

		if($mailExistant == false)
		{
			$motPasseEncrypte = password_hash($data->motPasseInscri, PASSWORD_DEFAULT);
			//À ajouter pour filtrer les variables: mysqli_real_escape_string
			$res = $this->_db->query('INSERT INTO usager (nom, prenom, email, motpasse) VALUES ( "' . $data->nomInscri . '",' 
						. '"' . $data->prenomInscri . '",'
						. '"' . $data->courrielInscri . '",'
						. '"' . $motPasseEncrypte . '")');
			//INSERT INTO usager (nom, prenom, email, motpasse) VALUES ("test", "ajout", "test@gmail.com", "passetest")	

			return $res;
		}
		else
		{
			return false;
		}
		
	}

	/**
	 * Récupère les informations relatif au compte de l'utilisateur connecté
     *
     * @param string $courriel Le courriel de l'utilisateur connecté
     *
     * @return array tableau contenant les informations visibles du compte
     *				 de l'utilisateur
	 *  
	 */
    public function getCompte($courriel)
	{
		$rows = Array();
		//À ajouter pour filtrer les variables: mysqli_real_escape_string
		$res = $this->_db->query('SELECT nom, prenom, email FROM ' . self::TABLE . ' WHERE email = "' . $courriel . '"');

		if($res->num_rows)
		{
            $row = $res->fetch_assoc();
		}
		
		return $row;
	}
}




?>