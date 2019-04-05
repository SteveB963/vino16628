<?php
	if($page == "inscription"){
        $titre = "Inscription";
        $message = "Veuillez remplir le formulaire ci-dessous afin de vous inscrire.";
    }
    else{
        $titre = "Modification de votre compte";
        $message = "Veuillez remplir le formulaire ci-dessous afin de modifier votre compte.";
    }
?>
<div class="actionCellierMobile">
    <div>
        <button class="retour petitBtn rtrAccueil"><i class="fas fa-arrow-left"></i></button>
    </div>
</div>
<div class="inscription mesFormulaires content">
    <h2><?php echo $titre ?></h2>
	<p><?php echo $message ?></p>
	<form class="formulaire">
		<div name="msgErreur"></div>
		<div>
			<input type="text" name="prenomInscri" placeholder="Prenom" value="<?php if(isset($_SESSION['prenomUtilisateur'])){echo $_SESSION['prenomUtilisateur'];}?>">
			<label for="prenomInscri" class="hide">Prenom:</label>
			<p class="erreurPrenomUsager"></p>
		</div>
		<div>
			<input type="text" name="nomInscri" placeholder="Nom" value="<?php if(isset($_SESSION['nomUtilisateur'])){echo $_SESSION['nomUtilisateur'];}?>">
			<label for="nomInscri" class="hide">Nom:</label>
			<p class="erreurNomUsager"></p>
		</div>
		<div>
			<input type="email" name="courrielInscri" placeholder="Courriel" value="<?php if(isset($_SESSION['emailUtilisateur'])){echo $_SESSION['emailUtilisateur'];}?>">
			<label for="courrielInscri" class="hide">Courriel:</label>
			<p class="erreurCourrielUsager"></p>
		</div>
<?php
	if($page == "inscription"){
?>
		<div>
			<input type="password" name="motPasseInscri" placeholder="Mot de passe">
			<label for="motPasseInscri" class="hide">Mot de passe:</label>
			<p class="erreurMotPasse"></p>
		</div>
<?php
	}
?>
		
	</form>
	<div class="boutonForm">
        <button class="retour btnWeb largeBtn rtrAccueil" name="retourCompte">Retour</button>
<?php
	if($page == "inscription"){
?>
		<button class="soumettre largeBtn" name="ajouterNouveauCompte">S'inscrire!</button>
<?php
	}
	else{
?>
		<button class="soumettre largeBtn" name="sauvegardeModifCompte">Sauvegarder les modifications</button>
<?php
	}
?>
    </div>
</div>