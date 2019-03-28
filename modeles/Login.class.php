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
	 * Modification - Modification d'un compte déjà existant
     *
     * @param array $data Tableau regroupant tout les informations
     *						entrées dans le formulaire d'inscription.
     *
     * @return boolean true si la création/modification du compte est possible
     *		   boolean false si la création/modification du compte est impossible
	 *  
	 */
    public function sauvegardeCompte($data, $id = "")
	{
		$rows = Array();
		$allMails = $this->_db->query('SELECT email FROM ' . self::TABLE);
		$mailExistant = false;

		//Vérifier si le email entrer pour la création du nouveau
		//compte est déjà existant
		if($allMails->num_rows)
		{

            while($row = $allMails->fetch_assoc())
            {
            	if(strtolower($data->courrielInscri) == $row["email"]){
            		$mailExistant = true;
            		break;
            	}else{
            		$mailExistant = false;
            	}
            }
		}

		if($mailExistant == false)
		{
			//Si l'id est inexistant, créer un nouveau compte
			if($id == ""){
				$motPasseEncrypte = password_hash($data->motPasseInscri, PASSWORD_DEFAULT);
				//À ajouter pour filtrer les variables: mysqli_real_escape_string
				$res = $this->_db->query('INSERT INTO usager (nom, prenom, email, motpasse) VALUES ( "' . strtolower($data->nomInscri) . '",' 
							. '"' . strtolower($data->prenomInscri) . '",'
							. '"' . strtolower($data->courrielInscri) . '",'
							. '"' . $motPasseEncrypte . '")');
				return $res;
			}
			//Si l'id est existant, modifier les informations du compte
			else{
				$res = $this->_db->query('UPDATE ' . self::TABLE . ' SET nom = "' . strtolower($data->nomInscri) . '", prenom = "' . strtolower($data->prenomInscri) . '", email = "' . strtolower($data->courrielInscri) . '" WHERE id_usager = ' . $id);
				return $res;
			}
			
		}
		//Si l'email existe déja
		else
		{
			//et si l'id est existant
			if($id != ""){
				$mailPrecedant = $this->_db->query('SELECT email FROM ' . self::TABLE . ' WHERE id_usager = ' . $id);

				if($mailPrecedant->num_rows)
				{
		            $mailPrec = $mailPrecedant->fetch_assoc();
				}

				//Vérifier si le email existant est celui de l'utilisateur cherchant à modifier son compte
				//Si oui, permettre la modification
				if($mailPrec["email"] == strtolower($data->courrielInscri)){
					$res = $this->_db->query('UPDATE ' . self::TABLE . ' SET nom = "' . strtolower($data->nomInscri) . '", prenom = "' . strtolower($data->prenomInscri) . '" WHERE id_usager = ' . $id);
					return $res;
				}
				else{
					return false;
				}	
			}
			else{
				return false;
			}
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
		$row = Array();
		//À ajouter pour filtrer les variables: mysqli_real_escape_string
		$res = $this->_db->query('SELECT id_usager, nom, prenom, email FROM ' . self::TABLE . ' WHERE email = "' . strtolower($courriel) . '"');

		if($res->num_rows)
		{
            $row = $res->fetch_assoc();
		}
		
		return $row;
	}

/*
	protected function verificationCourriel($courriel){
		$allMails = $this->_db->query('SELECT email FROM ' . self::TABLE);

		//Vérifier si le email entrer pour la création du nouveau
		//compte est déjà existant
		if($allMails->num_rows)
		{

            while($row = $allMails->fetch_assoc())
            {
            	if($data->courrielInscri == $row["email"]){
            		return true;
            	}
            }

            return false;
		}

		return false;
	}
*/
}




?>