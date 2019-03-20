
<div class="cellier content">
<p class="trier" id="creerCellier"><a href="?requete=creerUnCellier">Creer votre cellier</a></p>
<p class="trier">
    Trier le cellier par:
    <select id="trier">
      <option value="">Select</option>
      <option value="nom">Nom</option>
      <option value="pays">Pays</option>
      <option value="format">Format</option>
      <option value="type">Type</option>
      <option value="prix">Prix</option>
      <option value="millesime">Millesime</option>
      <option value="code_saq">Code_SAQ</option>
    </select>
</p>

<?php
    if($data){
        foreach ($data as $cle => $bouteille) {
    ?>
    <div class="bouteille" data-quantite="">
        <div class="img">
            
            <img src="https:<?php echo $bouteille['image'] ?>">
        </div>
        <div class="description">
            <p class="nom"><?php echo $bouteille['nom'] ?></p>
            <p class="quantite" data-quantite="<?php echo $bouteille['id'] ?>"> Quantité : <?php echo $bouteille['quantite'] ?></p>
            <p class="pays">Pays : <?php echo $bouteille['pays'] ?></p>
            <p class="millesime">millesime : <?php echo $bouteille['millesime'] ?></p>
            <p class="type">Type : <?php echo $bouteille['type'] ?></p>
            <p class="prix">Prix: <?php echo $bouteille['prix'] ?> $</p>
            <p class="format">Format: <?php echo $bouteille['format'] ?> ml</p>
            <p class="code_SAQ">Code_SAQ: <?php echo $bouteille['code_saq'] ?></p>
            <p><a href="<?php echo $bouteille['url_saq'] ?>">Voir SAQ</a></p>
        
        </div>
        <div class="options" data-id="<?php echo $bouteille['id'] ?>">
            <button class='btnModifier'>Modifier</button>
            <button class='btnAjouter'>Ajouter</button>
            <button class='btnBoire'>Boire</button>
            
        </div>
    </div>
<?php
}

}

?>	
</div>


