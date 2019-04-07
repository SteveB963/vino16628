<!--
Project : vino
Page : cellier.php
Description : Affiche les cellier d'un usager et lui permet dans ajouter des nouveau
                ainsi que les modifiers
-->
    
    <div class="cellier content" name='cellier'  data-id="<?php echo $_GET['id_cellier']?>">
    <div class="search">
        <input id='searchValue' placeholder="Recherche"> 
        <button id='cherche'><i class="fa fa-search"></i></button> 
        <ul class="listeChercheAutoComplete">
            <ul class="listeNom">
            </ul>
            <ul class="listePrix">
            </ul>
            <ul class="listePays">
            </ul>
            <ul class="listeType">
            </ul>
            <ul class="listeFormat">
            </ul>
            <ul class="listeMillesime">
            </ul>
            <ul class="listeCode">
            </ul>
        </ul>
    </div>

    <div class="trier">
        Trier le cellier par:
        <select id="trier">
            <option value="nom" <?php echo $trier== 'nom' ? 'selected' : ''?>>Nom</option>
            <option value="prix" <?php echo $trier == 'prix' ? 'selected' : ''?>>Prix</option>
            <option value="pays" <?php echo $trier == 'pays' ? 'selected' : ''?>>Pays</option>
            <option value="type" <?php echo $trier == 'type' ? 'selected' : ''?>>Type</option>
            <option value="format" <?php echo $trier== 'format' ? 'selected' : ''?>>Format</option>
            <option value="millesime" <?php echo $trier == 'millesime' ? 'selected' : ''?>>Millesime</option>
            <option value="code_saq" <?php echo $trier == 'code_saq' ? 'selected' : ''?>>Code_SAQ</option>
        </select>
        
    </div>
    <?php
    if($data){
        ?>

        <div class="count">
            <h4> Resultat-<?php echo sizeof($data)?> Bouteilles</h4>
        </div>
        <?php
        foreach ($data as $cle => $bouteille) {
    ?>
    <div class="bouteille">
        <div class="img">
            <img class="imgvin" src="<?php echo $bouteille['image'] ?>">
        </div>
        <div>
            <div class="information">
                <p class="nom"><?php echo $bouteille['nom'] ?></p>
                <div class="description">
                    <p class="type"><?php echo $bouteille['type'] ?>, <?php echo $bouteille['pays'] ?>, <?php echo $bouteille['format'] ?> ml, millesime : <?php echo $bouteille['millesime'] ?></p>
                    <p class="millesime"><?php echo $bouteille['prix'] ?> $, Code_SAQ: <?php echo $bouteille['code_saq'] ?>,<p class="quantite" data-quantite="<?php echo $bouteille['id'] ?>"> Quantité : <?php echo $bouteille['quantite'] ?></p>,<p> <a href="<?php echo $bouteille['url_saq'] ?>">Page SAQ</a></p>
                </div>
            </div>
            <div class="options" data-id="<?php echo $bouteille['id_bouteille'] ?>">
                <button class='btnModifier'>Modifier</button>
                <button class='btnAjouter'>Ajouter</button>
                <button class='btnBouteille'>Bouteille</button>
            </div>
        </div>
    </div>
<?php
    }
    }
    else{
        ?>
        <div class="erreur">
            <h4>Recherche pour cet mot-clé Resultat-0</h4>
            <h4>Essayez avec un autre mot-clé.</h4>
       </div>
        <?php
    }

?>	
</div>


