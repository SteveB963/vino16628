
<div class="cellier content">

<?php
foreach ($data as $cle => $cellier) {
 
    ?>
    <div class="bouteille" data-quantite="">
        <div class="img">
            
            <img src="https:<?php echo $cellier['image'] ?>">
        </div>
        <div class="description">
            <p class="nom"><?php echo $cellier['nom'] ?></p>
           
        </div>
        
    </div>
    <div id="creerCellier"><p><a href="?requete=creerUnCellier">Créer votre cellier</a></p></div>
<?php


}

?>	
</div>


