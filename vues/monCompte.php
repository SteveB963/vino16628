<!--
Project : vino
Page : monCompte.php
Description : Affiche les informations sur le compte de l'usager connecter
-->
<div class="actionCellierMobile">
    <div>
        <button class="retour petitBtn rtrListeCellier"><i class="fas fa-arrow-left"></i></button>
    </div>
</div>
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
            <p><strong>Prenom: </strong><?php echo $_SESSION["idUtilisateur"] ?></p>
			<p><strong>Prenom: </strong><?php echo $_SESSION["prenomUtilisateur"] ?></p>
			<p><strong>Nom: </strong><?php echo $_SESSION["nomUtilisateur"] ?></p>
			<p><strong>Adresse Courriel: </strong><?php echo $_SESSION["emailUtilisateur"] ?></p>
		</div>
        <div class="boutonForm">
            <button class="retour largeBtn btnWeb rtrListeCellier">Retour</button> 
	       <button name="modifierCompte" class='xlargeBtn compteModif'>Modifier mon compte<i class="fas fa-user-edit"></i></button>
        </div>
	</div>
</div>