<?php
/**
 * Class MonSQL
 * Classe qui génère ma connection à MySQL à travers un singleton
 *
 *
 * @author Jonathan Martel
 * @version 1.0
 *
 *
 *
 */
class SAQ extends Modele {

	const DUPLICATION = 'duplication';
	const ERREURDB = 'erreurdb';

	private static $_webpage;
	private static $_status;
	private $stmt;

    //insert la requete d'ajout dans attribut stmt
	public function __construct() {
		parent::__construct();
		if (!($this -> stmt = $this -> _db -> prepare("INSERT INTO bouteille(nom, type, image, code_saq, pays, prix, url_saq, format, millesime) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"))) {
            
			echo "Echec de la préparation : (" . $mysqli -> errno . ") " . $mysqli -> error;
		}
	}

	/**
	 * récupère les informations sur les bouteilles de vin sur le site de la SAQ 
     * et les ajoutes à la bd
     *
	 * @param int $nombre
	 * @param int $debut
     *
     * @return int $i nombre de produit ajouté
	 */
	public function getProduits($nombre = 100, $debut = 0) {
        $s = curl_init();
        //visite la page de produit de la saq avec les filtres reçu en paramêtre
		curl_setopt($s, CURLOPT_URL, "https://www.saq.com/webapp/wcs/stores/servlet/SearchDisplay?categoryIdentifier=06&showOnly=product&langId=-2&beginIndex=" . $debut . "&pageSize=" . $nombre . "&catalogId=50000&searchTerm=*&categoryId=39919&storeId=20002");
		curl_setopt($s, CURLOPT_RETURNTRANSFER, 1);        
        
		self::$_webpage = curl_exec($s);
		self::$_status = curl_getinfo($s, CURLINFO_HTTP_CODE);

        //récupère tout le html de la page
		$doc = new DOMDocument();
		$doc -> recover = true;
		$doc -> strictErrorChecking = false;
		@$doc -> loadHTML(self::$_webpage);
        echo curl_error($s) . "<br>";
        curl_close($s);
		
        //sélectionne tout les divs
        $elements = $doc -> getElementsByTagName("div");
		$i = 0;
		foreach ($elements as $key => $noeud) {
            //si le div contient la class "resultat_product"
			if (strpos($noeud -> getAttribute('class'), "resultats_product") !== false) {
                
                //appel fonction recupereInfo
				$info = self::recupereInfo($noeud);
                //ajout le produit à la bd
				$retour = $this -> ajouteProduit($info);
                //si l'ajout à échouer affiche la raison puis les infos récupérer
				if ($retour -> succes == false) {
					echo "erreur : " . $retour -> raison . "<br>";
					echo "<pre>";
					//var_dump($info);
					echo "</pre>";
					echo "<br>";
				} else {
					$i++;
				}
                
			}
		}
		return $i;
	}
    
    //possiblement inutile ?? à retirer ??
	private function get_inner_html($node) {
		$innerHTML = '';
		$children = $node -> childNodes;
		foreach ($children as $child) {
			$innerHTML .= $child -> ownerDocument -> saveXML($child);
		}

		return $innerHTML;
	}

    /**
	 * extrait les informations sur une bouteille de vin sur le site de la SAQ 
     *
	 * @param obj DOMDocument $noeud div qui contient les informations à extraire
	 *
     * @return obj stdClass $info qui contient les informations de la bouteille
	 */
	private function recupereInfo($noeud) {
		$info = new stdClass();
        //lien img
        $info -> img = $noeud -> getElementsByTagName("img") -> item(0) -> getAttribute('src');
        //lien page produit
		$info -> url = $noeud -> getElementsByTagName("a") -> item(0) -> getAttribute('href');
        
		$p = $noeud -> getElementsByTagName("p");
		foreach ($p as $node) {
            
            //nom
			if ($node -> getAttribute('class') == 'nom') {
				$info -> nom = trim($node -> textContent);
                // prendre milessime de nom
                preg_match("/\d+/", $info -> nom ,$a);
                //convertion du millesime  en float
                if(!empty($a)){
                     $info -> millesime=floatval($a[0]);
                }
                else{
                     $info -> millesime=0;
                }
                //var_dump($info -> millesime);
            
                
                
			} else if ($node -> getAttribute('class') == 'desc') {
                //isole les données
				$res = preg_match_all("/\r\n\s*(.*)\r\n/", $node ->textContent, $aDesc);
                //code SAQ
				if (isset($aDesc[1][2])) {
					preg_match("/\d{8}/", $aDesc[1][2], $aRes);
					$info -> code_SAQ = floatval($aRes[0]);
				}
                //Pays
				if (isset($aDesc[1][1])) {
					preg_match("/(.*),(.*)/", $aDesc[1][1], $aRes);
					$info -> pays = utf8_decode(trim($aRes[1]));
                    //format
                    preg_match("/\d{1,3}/", $aRes[2], $k);
                    $info -> format =floatval($k[0]);
					//$info -> format = utf8_decode(trim($aRes[2]));
				}
               // var_dump($info -> format);
                //Type
				if (isset($aDesc[1][0])) {
					$info -> type = utf8_decode(trim($aDesc[1][0]));
				}
			}
		}
		$p = $noeud -> getElementsByTagName("td");
		foreach ($p as $node) {
            //prix
			if ($node -> getAttribute('class') == 'price') {
				$info -> prix = trim($node -> textContent);
				preg_match("/ \r\n(.*)$/", $info -> prix, $aRes);
				$info -> prix = utf8_decode(trim($aRes[1]));
                //convertion du prix en float
                $info -> prix = preg_replace('/,/', '.', $aRes[0]);
                $info -> prix = floatval($info -> prix);
                
			}
		}

		return $info;
	}

    
    /**
	 * Ajout une bouteille du site de la saq dans la bd
     *
	 * @param  obj stdClass $info qui contient les informations de la bouteille
	 *
     * @return obj stdClass $retour qui contient le resultat de l'operation
	 */
	private function ajouteProduit($bte) {
        //echo "dans ajoute produit";
		$retour = new stdClass();
		$retour -> succes = false;
		$retour -> raison = '';

		//var_dump($bte);
		// Récupère l'id du type du pays associer
		$type = $this -> _db -> query("select id_type from bouteille_type where type = '" . $bte -> type . "'");
		$pays = $this -> _db -> query("select id_pays from pays where pays = '" . $bte -> pays . "'");
		
		if ($type -> num_rows == 1 && $pays -> num_rows == 1) {
			$type = $type -> fetch_assoc();
            $pays = $pays -> fetch_assoc();
            //var_dump($type);
            //var_dump($pays);
            //vérifie si le code SAQ correspond à une bouteille déjà entré de la bd
			$rows = $this -> _db -> query("select id_bouteille from bouteille where code_saq = '" . $bte -> code_SAQ . "'");
			if ($rows -> num_rows < 1) {
                //insère les inforamtions dans la bd
                $this -> stmt -> bind_param("sisiidsii", $bte -> nom, $type['id_type'], $bte -> img, $bte -> code_SAQ, $pays['id_pays'], $bte -> prix, $bte -> url, $bte -> format, $bte -> millesime);
				$retour -> succes = $this -> stmt -> execute();
			} else {
				$retour -> succes = false;
				$retour -> raison = self::DUPLICATION;
			}
		} else {
			$retour -> succes = false;
			$retour -> raison = self::ERREURDB;

		}
		return $retour;

	}

}
?>