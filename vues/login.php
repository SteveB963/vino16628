<div class="login mesFormulaires content">
	<h2>Connexion</h2>
		<form class="formulaire">
		<?php

			if(isset($msgConfirmation))
			{
				echo "<div class='confirmBox'>
							<p>$msgConfirmation</p>
						</div>";
			}

		?>
		<div name="msgErreur"></div>
		<div name="msgConfirmation"></div>
		<div>
			<input type="email" name="courrielCo" placeholder="Courriel">
			<label for="courrielCo" class="hide">Courriel:</label>
		</div>
		<div>
			<input type="password" name="motPasseCo" placeholder="Mot de passe">
			<label for="motPasseCo" class="hide">Mot de passe:</label>
		</div>
		<input type="button" name="seConnecter" value="Se connecter">
		<p>Je souhaite <a href="index.php?requete=inscription">m'inscrire</a>!</p>
	</form>
</div>