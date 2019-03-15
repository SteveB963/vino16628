<!DOCTYPE html>
<html lang="fr">
	<head>
		<title>Vino</title>
		<meta charset="utf-8">
		<meta http-equiv="cache-control" content="no-cache">
		<meta name="viewport" content="width=device-width, minimum-scale=0.5, initial-scale=1.0, user-scalable=yes">

		<meta name="description" content="Un petit verre de vino">
		<meta name="author" content="Jonathan Martel (jmartel@cmaisonneuve.qc.ca)">

		<link rel="stylesheet" href="./css/normalize.css" type="text/css" media="screen">
		<link rel="stylesheet" href="./css/base_h5bp.css" type="text/css" media="screen">
		<link rel="stylesheet" href="./css/main.css" type="text/css" media="screen">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

		<!-- font-family: 'Libre Baskerville', serif; -->
		<link href="https://fonts.googleapis.com/css?family=Libre+Baskerville" rel="stylesheet">

		<!-- font-family: 'Hind', sans-serif; -->
		<link href="https://fonts.googleapis.com/css?family=Hind:500" rel="stylesheet">
		
		<base href="<?php echo BASEURL; ?>">
		<!--<script src="./js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>-->
		<script src="./js/main.js"></script>
		<script src="./js/stylemenu.js"></script>
	</head>
	<body >
		<header>
			<div id="entete1">
				<a href="?requete=accueil"><img id="logo" src="./images/logo_blanc.png"></a>
				<h1>Vino</h1>
				<div id="liensSociaux">
					<a href="#"><i class="fab fa-instagram"></i></a>
					<a href="#"><i class="fab fa-facebook-square"></i></a>
					<a href="#"><i class="fab fa-twitter-square"></i></a>
					<a href="#"><i class="fab fa-pinterest-square"></i></a>
				</div>
			</div>
			<div id="imageEntete">
				
			</div>
			<nav id="mainNav">
				<ul>
				<!--
					<li><a href="?requete=accueil">Mon cellier</a></li>
				-->
					<li><a href="?requete=ajouterNouvelleBouteilleCellier">Ajouter une bouteille au cellier</a></li>
				
				<li><a href="?requete=accueil">Accueil</a></li>
				<li><a href="#">Vins</a></li>
				<li><a href="?requete=afficheCellier">Mes Celliers</a></li>
				<li><a href="#">Mon Compte</a></li>
				</ul>
			</nav>
		</header>
		
		<main>
			