<div class="actionCellier">
    <button name="nouvelleBouteille">Ajouter une boueille</button>
    <!--<p class="trier" id="creerCellier"><a href="?requete=creerUnCellier">Creer votre cellier</a></p>-->
    <p class="trier">
        Trier le cellier par:
        <select id="trier">
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

<div class="cellier content" data-cellier="<?php echo $_GET['id_cellier']?>">
<?php
    if($data){
        foreach ($data['info'] as $cle => $infoBout) {
    ?>
    <div id="bouteille<?php echo $infoBout['id_bouteille'] ?>"><!--METTRE LA CLASSE BOUTEILLE DANS CE DIV !!!!-->
        <div class="bouteille">
            <div class="img">
                <img class="imgvin" src="<?php echo $infoBout['image'] ?>">
            </div>
            <div>
                <div class="information">
                    <p class="nom"><?php echo $infoBout['nom'] ?></p>
                    <div class="description">
                        <p class="type"><?php echo $infoBout['type'] ?>, <?php echo $infoBout['pays'] ?>, <?php echo $infoBout['format'] ?> ml, millesime : <?php echo $infoBout['millesime'] ?></p>
                        <p class="millesime"><?php echo $infoBout['prix'] ?> $, Code_SAQ: <?php echo $infoBout['code_saq'] ?>, <a href="<?php echo $infoBout['url_saq'] ?>">Page SAQ</a></p>
                        <p></p>
                    </div>
                </div>
                <div class="options" data-bouteille="<?php echo $infoBout['id_bouteille'] ?>">
                    <button class='btnModifier'>Modifier</button>
                    <button class='btnAjouter'><img class="icone" src="./images/icones/bouteille-plus.svg"></button>
                    <button class='btnBouteille'>Bouteille<?php
                        if($infoBout['quantite'] > 1){
                            echo "s";
                        }
                        echo "(" . $infoBout['quantite']; ?>)
                    </button>
                </div>
            </div>

        </div>
        <div class="listeBouteille hideBouteille">
            <table>
                <tr>
                    <th>Date d'ajout</th>
                    <th>Garder jusqu'à</th>
                    <th>Bouton boire</th>
                    <th>Bouton modifier</th>
                </tr>
                <?php
                    foreach($data['bouteille'] as $bouteille){
                        if($bouteille['id_bouteille'] == $infoBout['id_bouteille']){
                            ?>
                            <tr data-id="<?php echo $bouteille['id'] ?>">
                                <td><?php echo $bouteille['date_ajout'] ?></td>
                                <td><?php echo $bouteille['garde_jusqua'] ?></td>
                                <td><button class="btnBoire"><img class="icone" src="./images/icones/bouteille-moins.svg"></button></td>
                                <td><button>Modifier</button></td>
                            </tr>
                            <?php
                        }
                    }

                ?>    
            </table>
        </div>
    </div>
<?php
}

}

?>	
</div>


