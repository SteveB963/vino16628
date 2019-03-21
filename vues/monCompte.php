<div class="monCompte mesFormulaires content">
	<?php

	?>
	<div>
		<div>
			<h2>Mon Compte</h2>
			<p><a name="modifierCompte">Modifier<i class="fas fa-user-edit"></i></a></p>
		</div>
		<a href="index.php?requete=deconnexion">Déconnexion</a>
	</div>
	

	<?php

		if($donnees){
	?>

	<div>
		<p><strong>Prenom: </strong><?php echo $donnees["prenom"] ?></p>
		<p><strong>Nom: </strong><?php echo $donnees["nom"] ?></p>
		<p><strong>Adresse Courriel: </strong><?php echo $donnees["email"] ?></p>
	</div>

	<?php
		}

	?>
</div>