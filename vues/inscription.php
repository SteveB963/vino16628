<div class="inscription mesFormulaires content">
	<h2>Inscription</h2>
	<p>Veuillez remplir le formulaire ci-dessous afin de vous inscrire.</p>
	<!-- <form class="formulaire" method="POST" action="index.php?requete=creerCompteUsager"> -->
		<form class="formulaire">
		<?php

			if(isset($msgErreur))
			{
				echo "<div class='divErreur'>
							<p>$msgErreur</p>
						</div>";
			}

			if(isset($msgConfirmation))
			{
				echo "<div class='divConf'>
							<p>$msgConfirmation</p>
						</div>";
			}

		?>
		<div name="msgErreur"></div>
		<div name="msgConfirmation"></div>
		<div>
			<input type="text" name="prenomInscri" placeholder="Prenom">
			<label for="prenomInscri" class="hide">Prenom:</label>
		</div>
		<div>
			<input type="text" name="nomInscri" placeholder="Nom">
			<label for="nomInscri" class="hide">Nom:</label>
		</div>
		<div>
			<input type="email" name="courrielInscri" placeholder="Courriel">
			<label for="courrielInscri" class="hide">Courriel:</label>
		</div>
		<div>
			<input type="password" name="motPasseInscri" placeholder="Mot de passe">
			<label for="motPasseInscri" class="hide">Mot de passe:</label>
		</div>
		<input type="button" name="ajouterNouveauCompte" value="S'inscrire!">
	</form>
</div>