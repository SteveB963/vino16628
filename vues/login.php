<div class="login mesFormulaires content">
	<h2>Connexion</h2>
		<form class="formulaire">
		<?php

			if(isset($msgConfirmation))
			{
				echo "<div class='eraseBox msgBox'>
						<div class='confirmBox msgBox'>
							<p>$msgConfirmation</p>
						</div>
					  </div>";
			}

		?>
		<div name="msgErreur" ></div>
		<div name="msgConfirmation" class="msgBox"></div>
		<div>
			<input type="email" name="courrielCo" placeholder="Courriel">
			<label for="courrielCo" class="hide">Courriel:</label>
		</div>
		<div>
			<input type="password" name="motPasseCo" placeholder="Mot de passe">
			<label for="motPasseCo" class="hide">Mot de passe:</label>
		</div>
	</form>
		<button name="seConnecter" class='largeBtn'>Se connecter</button>
		<p>Je souhaite <a href="index.php?requete=inscription">m'inscrire</a>!</p>
</div>