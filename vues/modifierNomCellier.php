<div class="actionCellierMobile">
    <div>
        <button class="retour petitBtn rtrListeCellier"><i class="fas fa-arrow-left"></i></button>
    </div>
</div>
<div class="mesFormulaires content">
	<h2>Modification du nom de votre cellier</h2>
	<p>Veuillez modifier le nom ci-dessous.</p>


    <div>
        
            <form class="formulaire">
                <div name="msgErreur"></div>
                <div>
                <input type="hidden" name="id_cellier" value="<?php echo $donnee['cellier']['id_cellier'] ?>">
                    <input type="text" name="nom" placeholder="Nom du cellier"  value="<?php echo $donnee['cellier']['nom'] ?>">
                    <p class="erreurNomCellier"></p>
                </div> 
               
                 
            </form>
            <div class="boutonForm">
                <button class="retour largeBtn btnWeb rtrListeCellier">Retour</button> 
                <button name='sauverNomCellier' class="largeBtn">Sauvegarder la modification</button>
            </div>
        
    </div>
</div>
