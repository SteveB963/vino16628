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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

		<!-- font-family: 'Libre Baskerville', serif; -->
		<link href="https://fonts.googleapis.com/css?family=Libre+Baskerville" rel="stylesheet">

		<!-- font-family: 'Hind', sans-serif; -->
		<link href="https://fonts.googleapis.com/css?family=Hind:500" rel="stylesheet">
		
		<base href="<?php echo BASEURL; ?>">
		<script src="./js/main.js"></script>
		<script src="./js/stylemenu.js"></script>
	</head>
	<body>
		<header>
            <div>
                <!-- Premier menu avec logo du site -->
                <div id="entete1">
                    <div>
                        <a href="?requete=accueil"><img id="logo" src="./images/logo_blanc.png"></a>
                    </div>
                    <div id="titreEntete">
                        <h1>Vino</h1>
                    </div>
                    <!-- Menu Burger des options liés au compte -->
                    <div id="lienOptionsCompte">
                        <p><i class='fas fa-user-circle'></i></p><input type='checkbox' id='profile'>
                        <div id='optionsCompte'>
                            <ul>
<?php
    //Les options accessibles depuis le menu du compte diffèrent selon si l'usager 
    //est connecté ou pas.
    if(isset($_SESSION["idUtilisateur"]) && $_SESSION["idUtilisateur"] != ""){
        echo " <li>" . $_SESSION['prenomUtilisateur'] . " " . $_SESSION['nomUtilisateur'] . "</li>
                <li><a href='?requete=compte'>Voir mon profile</a></li>
                <li><a href='?requete=deconnexion'>Se déconnecter</a></li>
                ";
    }
    else{
        echo "<li>Visiteur</li>
            <li><a href='?requete=compte'>Se connecter</a></li>
            <li><a href='?requete=inscription'>S'inscrire</a></li>";
    }                          
?>
                            </ul>
                        </div>
                    </div>

                </div>

            </div>

            <!-- Menu Burger -->
			<input type="checkbox" id="burger">
			<i class="fas fa-bars"></i>
			<i class="fas fa-times"></i>

            <!-- Menu Principale -->
			<nav>
                <div id="mainNav">
                    <ul>
<?php                        
    //Les options suivante sont accesssible depuis le menu principale seulement
    //en format mobile
    if(isset($_SESSION["idUtilisateur"]) && $_SESSION["idUtilisateur"] != ""){
        echo "<li class='menuMobile'><a href='?requete=compte'>Mon profile <i class='fas fa-user-circle'></i></a></li>
                <li class='menuMobile'><a href='?requete=deconnexion'>Se déconnecter <i class='fas fa-sign-out-alt'></i></a></li>
                ";
    }
    else{
        echo "<li class='menuMobile'><a href='?requete=compte'>Se connecter <i class='fas fa-sign-in-alt'></i></a></li>
            <li class='menuMobile'><a href='?requete=inscription'>S'inscrire <i class='fas fa-user-plus'></i></a></li>";
    }                          
?>

                    </ul>
                </div>
			</nav>
		</header>
		
		<main>
			