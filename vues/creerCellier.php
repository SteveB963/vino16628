<div class="mesFormulaires content">
<?php
	if($page == "creer"){
?>
	<h2>Créer votre nouveau cellier</h2>
	<p>Veuillez remplir le nom de votre nouveau cellier.</p>
<?php
	}
	else{
?>
	<h2>Modification du nom de votre cellier</h2>
	<p>Veuillez remplir le nom ci-dessous afin de modifier votre nom.</p>
<?php
	}
?>

    <div>
        
            <form >
                <div name="msgErreur"></div>
                <div>
                    <input type="text" name="nom" placeholder="Nom du cellier">
                    <p class="erreurNomCellier"></p>
                </div> 
               
                 
            </form>
            <button name="creerCellier">Créer votre cellier</button>
        
    </div>
</div>
