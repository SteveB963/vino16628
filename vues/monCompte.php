<div class="mesFormulaires">

	<div class="monCompte">
		<div>
			<div>
				<h2>Mon Compte</h2>
			</div>
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
			<p><strong>Prenom: </strong><?php echo $_SESSION["prenomUtilisateur"] ?></p>
			<p><strong>Nom: </strong><?php echo $_SESSION["nomUtilisateur"] ?></p>
			<p><strong>Adresse Courriel: </strong><?php echo $_SESSION["emailUtilisateur"] ?></p>
		</div>
	</div>
	<button name="modifierCompte" class='xlargeBtn'>Modifier mon compte<i class="fas fa-user-edit"></i></button>
</div>