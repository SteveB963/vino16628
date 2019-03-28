<div class="monCompte mesFormulaires content">

	<div>
		<div>
			<h2>Mon Compte</h2>
			<p><a name="modifierCompte">Modifier<i class="fas fa-user-edit"></i></a></p>
		</div>
		<a href="index.php?requete=deconnexion">Déconnexion</a>
	</div>

<?php
	if(isset($msgConfirmation))
	{
		echo "<div class='confirmBox'>
					<p>$msgConfirmation</p>
				</div>";
	}
?>
	
	<div>
		<p><strong>ID: </strong><?php echo $_SESSION["idUtilisateur"] ?></p>
		<p><strong>Prenom: </strong><?php echo $_SESSION["prenomUtilisateur"] ?></p>
		<p><strong>Nom: </strong><?php echo $_SESSION["nomUtilisateur"] ?></p>
		<p><strong>Adresse Courriel: </strong><?php echo $_SESSION["emailUtilisateur"] ?></p>
	</div>

</div>