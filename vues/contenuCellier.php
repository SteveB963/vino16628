<div class="actionCellier">
    <button name="nouvelleBouteille">Ajouter une boueille</button>
    <!--<p class="trier" id="creerCellier"><a href="?requete=creerUnCellier">Creer votre cellier</a></p>-->
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
</div>
<div class="cellier content" data-cellier="<?php echo $_GET['id_cellier']?>">
<?php
    if($data){
        ?>
        <div class="count">
            <h4> Resultat-<?php echo sizeof($data['info'])?> Bouteilles</h4>
        </div>
       <?php
        foreach ($data['info'] as $cle => $infoBout) {
    ?>
    <div class="divBouteille" id="bouteille<?php echo $infoBout['id_bouteille'] ?>"><!--METTRE LA CLASSE BOUTEILLE DANS CE DIV !!!!-->
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
                                <td data-date="<?php echo $bouteille['date_ajout'] ?>"><?php echo $bouteille['date_ajout'] ?></td>
                                <td data-date="<?php echo $bouteille['garde_jusqua'] ?>"><?php echo $bouteille['garde_jusqua'] ?></td>
                                <td><button class="modifDate"><i class="fas fa-pen"></i></button></td>
                                <td><button class="btnBoire"><span><img class="icone" src="./images/icones/bouteille-moins.svg"></span></button></td>
                            </tr>
                            <tr>
                                <td colspan="4" class="erreur"></td>
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
<div id="msgContenuCellier" class='confirmBox'>
    <p><?php if(isset($msgConfirmation)){echo $msgConfirmation;} ?></p>
</div>


