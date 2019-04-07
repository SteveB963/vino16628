<!--
Project : vino
Page : login.php
Description : formulaire de connection d'un usager, avec un lien vers l'inscription
-->
<div class="login mesFormulaires content">
	<h2>Connexion</h2>
		<form class="formulaire" id="test">
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
            <label for="courrielCo" class="hide">Courriel:</label>
			<input type="text" name="courrielCo" placeholder="Courriel">
		</div>
		<div>
            <label for="motPasseCo" class="hide">Mot de passe:</label>
			<input type="password" name="motPasseCo" placeholder="Mot de passe">
		</div>
        <input type=submit>
    </form>
    <button name="seConnecter" class='largeBtn'>Se connecter</button>
    <p>Je souhaite <a href="index.php?requete=inscription">m'inscrire</a>!</p>
</div>