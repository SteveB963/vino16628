
<div class="listCellier content">

<?php
foreach ($data as $cle => $cellier) {
 
    ?>
    <div data-quantite="">
        <!-- <div class="img">
            
            <img src="https:<?php //echo $cellier['image'] ?>">
        </div> -->
        <div>
            <p><a href="?requete=afficheContenuCellier&id_cellier=<?php echo $cellier['id_cellier'] ?>"><?php echo $cellier['nom'] ?></a></p>
           
        </div>
        
    </div>
   
<?php


}

?><!--
 <p class="trier" id="creerCellier"><a href="?requete=creerUnCellier">Créer votre cellier</a></p>	
    -->
</div>


