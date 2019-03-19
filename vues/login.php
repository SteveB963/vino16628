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

		?>
		<div>
			<input type="text" name="nom" placeholder="Nom">
			<label for="nom" class="hide">Nom:</label>
		</div>
		<div>
			<input type="text" name="prenom" placeholder="Prenom">
			<label for="prenom" class="hide">Prenom:</label>
		</div>
		<div>
			<input type="text" name="motPasse" placeholder="Mot de passe">
			<label for="motPasse" class="hide">Mot de passe:</label>
		</div>
		<button>Se connecter</button>
		<input type="hidden" name="requete" value="login">
	</form>
</div>