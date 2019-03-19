<div class="login mesFormulaires content">
	<h2>Connexion</h2>
	<form class="formulaire" method="POST" action="index.php?requete=login">
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

			//var_dump($_SESSION["idUtilisateur"]);

		?>
		<div>
			<input type="email" name="courriel" placeholder="Courriel">
			<label for="courriel" class="hide">Courriel:</label>
		</div>
		<div>
			<input type="password" name="motPasse" placeholder="Mot de passe">
			<label for="motPasse" class="hide">Mot de passe:</label>
		</div>
		<button>Se connecter</button>
		<input type="hidden" name="requete" value="login">
		<p>Je souhaite <a href="index.php?requete=inscription">m'inscrire</a>!</p>
	</form>
</div>