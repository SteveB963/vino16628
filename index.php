<?php

/**
 * Fichier de lancement du MVC, Il appel le var.init et le gabarit HTML 
 * 
 * @file index.php
 * @project vino.php
 * 
 */


 
	 /***************************************************/
    /** Fichier de configuration, contient les define et l'autoloader **/
    /***************************************************/
    require_once('./dataconf.php');
	require_once("./config.php");
	
   /***************************************************/
    /** Initialisation des variables **/
    /***************************************************/
	require_once("./var.init.php");
   
   /***************************************************/
    /** Démarrage du controleur **/
    /***************************************************/
  session_start();
	$oCtl = new Controler();
	$oCtl->gerer();


?>
