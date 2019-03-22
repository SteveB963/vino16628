<div class="actionCellier">
    <button>Ajouter une boueille</button>
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
</div>

<div class="cellier content" name='cellier'>
<?php
    if($data){
        foreach ($data as $cle => $bouteille) {
    ?>
    <div class="bouteille" data-quantite="">
        <div class="img">
            <img class="imgvin" src="<?php echo $bouteille['image'] ?>">
        </div>
        <div>
            <div class="information">
                <p class="nom"><?php echo $bouteille['nom'] ?></p>
                <div class="description">
                    <p class="type"><?php echo $bouteille['type'] ?>, <?php echo $bouteille['pays'] ?>, <?php echo $bouteille['format'] ?> ml, millesime : <?php echo $bouteille['millesime'] ?></p>
                    <p class="millesime"><?php echo $bouteille['prix'] ?> $, Code_SAQ: <?php echo $bouteille['code_saq'] ?>, <a href="<?php echo $bouteille['url_saq'] ?>">Page SAQ</a></p>
                    <p></p>
                </div>
            </div>
            <div class="options" data-id="<?php echo $bouteille['id'] ?>">
                <button class='btnModifier'>Modifier</button>
                <button class='btnAjouter'>Ajouter</button>
                <button class='btnBouteille'>Bouteille</button>
            </div>
        </div>
    </div>
<?php
}

}

?>	
</div>


