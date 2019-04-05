
<div class="contenuCellier">
    <div class="actionCellierMobile">
        <div>
            <button class="retour petitBtn rtrListeCellier"><i class="fas fa-arrow-left"></i></button>
        </div>
        <div>
            <div class="trier">
                Trier 
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
        </div>
        <div class="">
            <div class="divAutoComplete">
                <div class="recherche">
                    <input class="inputChercheMobile hideCherche" <?php if ($cherche!=''){?>value='<?php echo $cherche;}else?>' placeholder='Recherche'> 
                    <button class="chercheMobile"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </div>
        <div>
            <div>
                <button class="petitBtn nouvelleBouteille"><i class="fas fa-plus"></i></button>
            </div>
        </div>
    </div>
    <h2><?php echo $data["nom_cellier"]["nom"] ?></h2>
    <div class="count">
        <h4>
        <?php
        if($msgCount!=''){
            echo $msgCount;
            }
        ?>
        </h4>
    </div>
    <div class="actionCellier">
        <div>
            <button class="xlargeBtn nouvelleBouteille">Ajouter une Nouvelle bouteille</button>
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
        <div>
            <button class="retour rtrListeCellier">Retour</button>
        </div>
    </div>
    <div class="content cellier" data-cellier="<?php echo $_GET['id_cellier']?>">
    <?php
        
        if($data){
            foreach ($data['info'] as $cle => $infoBout) {
        ?>
        <div class="bouteille" id="<?php echo $infoBout['id_bouteille'] ?>">
            <div class="information">
                <div class="img">
                    <img class="imgvin" src="<?php echo $infoBout['image'] ?>">
                    <div class="description descMobile hide">
                        <div>
                            <p class="titre">Détails :</p>
                            <p><?php echo $infoBout['type'] ?>, <?php echo $infoBout['pays'] ?>, <?php echo $infoBout['format'] ?> ml<br>millesime : <?php echo $infoBout['millesime'] ?></p>
                        </div>
                        <div>
                            <p>Information SAQ:</p>
                            <p><?php echo $infoBout['prix'] ?> $, Code_SAQ: <?php echo $infoBout['code_saq'] ?><br><a href="<?php echo $infoBout['url_saq'] ?>">Visité la page SAQ</a></p>
                        </div>
                    </div>
                </div>
                <div>
                    <p><?php echo $infoBout['nom'] ?></p>
                    <div class="description">
                        <div>
                            <p class="titre">Détails :</p>
                            <p><?php echo $infoBout['type'] ?>, <?php echo $infoBout['pays'] ?>, <?php echo $infoBout['format'] ?> ml<br>millesime : <?php echo $infoBout['millesime'] ?></p>
                        </div>
                        <div>
                            <p>Information SAQ:</p>
                            <p><?php echo $infoBout['prix'] ?> $, Code_SAQ: <?php echo $infoBout['code_saq'] ?><br><a href="<?php echo $infoBout['url_saq'] ?>">Visité la page SAQ</a></p>
                        </div>
                    </div>
                    <button class='btnDetail'><i class="fas fa-info-circle"></i></button>
                    <button class='btnBouteille'>Liste des bouteilles(<?php
                        echo $infoBout['quantite']; ?>) <i class="fas fa-sort-down"></i>
                    </button>
                </div>
                <div class="actionBouteille">
                    <button class='btnModifier moyenBtn'><i class="fas fa-pen"></i></button>
                    <button class="btnAjouter moyenBtn" title="ajouter une bouteille"><img class="icone" src="./images/icones/bouteille-plus.svg"></button>
                    <button class='btnSupprimer moyenBtn'><i class="fas fa-trash-alt"></i></button>
                </div>
            </div>
            <div class="listeBouteille hide">
                <p><small>* format des dates: année/mois/jour, peut différer lors de la modification</small></p>
                <table>
                    <tr>
                        <th>Date d'ajout</th>
                        <th>Garder jusqu'à</th>
                        <th></th>
                        <th></th>
                    </tr>
                    <?php
                        foreach($data['bouteille'] as $bouteille){
                            if($bouteille['id_bouteille'] == $infoBout['id_bouteille']){
                                ?>
                                <tr data-id="<?php echo $bouteille['id'] ?>">
                                    <td data-date="<?php echo $bouteille['date_ajout'] ?>"><?php echo $bouteille['date_ajout'] ?></td>
                                    <td data-date="<?php echo $bouteille['garde_jusqua'] ?>"><?php echo $bouteille['garde_jusqua'] ?></td>
                                    <td><button class="petitBtn modifDate" title="modifier date"><i class="fas fa-pen"></i></button></td>
                                    <td><button class="petitBtn btnBoire" title="retirer bouteille" ><span><img class="icone" src="./images/icones/bouteille-moins.svg"></span></button></td>
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
        else{
            
        }

    ?>	
    </div>
</div>
<div id="msgContenuCellier" class='confirmBox'>
    <p><?php if(isset($msgConfirmation)){echo $msgConfirmation;} ?></p>
</div>


