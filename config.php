<?php
/**
 * Fichier de configuration. Il est appelé par index.php
 * Il contient notamment l'autoloader
 *
 * @file config.php
 * @project vino
 * 
 */
	
	


	function mon_autoloader($class) 
	{
		$dossierClasse = array('modeles/', 'vues/', 'lib/', 'lib/mysql/', '' );	// Ajouter les dossiers au besoin
		
		foreach ($dossierClasse as $dossier) 
		{
			if(file_exists('./'.$dossier.$class.'.class.php'))
			{
				require_once('./'.$dossier.$class.'.class.php');
			}
		}
		
	  
	}
	
	spl_autoload_register('mon_autoloader');
	
	
	
	
?>
