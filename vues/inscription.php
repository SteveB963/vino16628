<div class="inscription mesFormulaires content">
<?php
	if($page == "inscription"){
?>
	<h2>Inscription</h2>
	<p>Veuillez remplir le formulaire ci-dessous afin de vous inscrire.</p>
<?php
	}
	else{
?>
	<h2>Modification de votre compte</h2>
	<p>Veuillez remplir le formulaire ci-dessous afin de modifier votre compte.</p>
<?php
	}
?>
	<form class="formulaire">
		<div name="msgErreur"></div>
		<div>
			<input type="text" name="prenomInscri" placeholder="Prenom" value="<?php if(isset($_SESSION['prenomUtilisateur'])){echo $_SESSION['prenomUtilisateur'];}?>">
			<label for="prenomInscri" class="hide">Prenom:</label>
		</div>
		<div>
			<input type="text" name="nomInscri" placeholder="Nom" value="<?php if(isset($_SESSION['nomUtilisateur'])){echo $_SESSION['nomUtilisateur'];}?>">
			<label for="nomInscri" class="hide">Nom:</label>
		</div>
		<div>
			<input type="email" name="courrielInscri" placeholder="Courriel" value="<?php if(isset($_SESSION['emailUtilisateur'])){echo $_SESSION['emailUtilisateur'];}?>">
			<label for="courrielInscri" class="hide">Courriel:</label>
		</div>
<?php
	if($page == "inscription"){
?>
		<div>
			<input type="password" name="motPasseInscri" placeholder="Mot de passe">
			<label for="motPasseInscri" class="hide">Mot de passe:</label>
		</div>
		<input type="button" name="ajouterNouveauCompte" value="S'inscrire!">
<?php
	}
	else{
?>
		<!--<input type="hidden" name="idCompte" value="<?php// echo $_SESSION['idUtilisateur'] ?>">-->
		<input type="button" name="sauvegardeModifCompte" value="Sauvegarder les modifications">
	</form>
<?php
	}
?>
</div>