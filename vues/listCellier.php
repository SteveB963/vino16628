
<div class="listCellier content">

<?php
foreach ($data as $cle => $cellier) {
 
    ?>
     <!-- <div class="bouteille"> -->
    <div data-quantite="">
        <!-- <div class="img">
            
            <img src="https:<?php echo $cellier['image'] ?>">
        </div> -->
        <div class="description">
            <p class="nom"><a href="?requete=afficheCellier&id_cellier=<?php echo $cellier['id_cellier'] ?>"><?php echo $cellier['nom'] ?></a>
                <div class="options" data-id="<?php echo $cellier['id_cellier']  ?>">
                    <button class='btnModifierNomCellier'>Modifier</button>
                    <button class='btnSupprimerCellier'>Supprimer</button>
                </div>
            </p>
           
        </div>
        
    </div>
    <!-- </div> -->
   
<?php
}

?>
 <p class="trier" id="creerCellier"><a href="?requete=creerUnCellier">Créer votre cellier</a></p>	

</div>


