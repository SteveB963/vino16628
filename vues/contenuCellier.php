<h2>nom du cellier sélectionné</h2>
<div class="content contenuCellier">
    <div class="actionCellier">
        <div>
            <button name="nouvelleBouteille">Ajouter une boueille</button>
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
        <div class="search divAutoComplete">
            <div class="recherche">
                 <input id='searchValue'  <?php if ($cherche!=''){?>value='<?php echo $cherche;}else?>' placeholder='Recherche'> 
                <button id='cherche'><i class="fa fa-search"></i></button>
            </div>
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
    <div class="cellier" data-cellier="<?php echo $_GET['id_cellier']?>">
    <?php
        if($data){
            ?>
            <div class="count">
                <h4> <?php echo $msgCount?></h4>
            </div>
            
           <?php
            foreach ($data['info'] as $cle => $infoBout) {
        ?>
        <div class="bouteille" id="bouteille<?php echo $infoBout['id_bouteille'] ?>"><!--METTRE LA CLASSE BOUTEILLE DANS CE DIV !!!!-->
            <div class="information">
                <div class="img">
                    <img class="imgvin" src="<?php echo $infoBout['image'] ?>">
                </div>
                <div>
                    <div>
                        <p><?php echo $infoBout['nom'] ?></p>
                        <div class="description">
                            <p class="type"><?php echo $infoBout['type'] ?>, <?php echo $infoBout['pays'] ?>, <?php echo $infoBout['format'] ?> ml, millesime : <?php echo $infoBout['millesime'] ?></p>
                            <p class="millesime"><?php echo $infoBout['prix'] ?> $, Code_SAQ: <?php echo $infoBout['code_saq'] ?>, <a href="<?php echo $infoBout['url_saq'] ?>">Page SAQ</a></p>
                            <p></p>
                        </div>
                        <button class='btnBouteille'>Bouteille<?php
                            if($infoBout['quantite'] > 1){
                                echo "s";
                            }
                            echo "(" . $infoBout['quantite']; ?>)
                        </button>
                    </div>
                    <div class="actionBouteille" data-bouteille="<?php echo $infoBout['id_bouteille'] ?>">
                        <button class='btnModifier'>Modifier</button>
                        <button title="ajouter une bouteille" class='btnAjouter'><img class="icone" src="./images/icones/bouteille-plus.svg"></button>
                        <button class='btnSupprimer'>Supprimer</button>
                    </div>
                </div>
            </div>
            <div class="listeBouteille hideListe">
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
                                    <td><button title="modifier date" class="modifDate"><i class="fas fa-pen"></i></button></td>
                                    <td><button title="retirer bouteille" class="btnBoire"><span><img class="icone" src="./images/icones/bouteille-moins.svg"></span></button></td>
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
</div>
    <div id="msgContenuCellier" class='confirmBox'>
        <p><?php if(isset($msgConfirmation)){echo $msgConfirmation;} ?></p>
    </div>


