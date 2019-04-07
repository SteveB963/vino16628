<!--
Project : vino
Page : formBout.php
Description : formulaire de modification d'une bouteille dans un cellier
-->

<div class="actionCellierMobile">
    <div>
        <button class="retour petitBtn rtrContenuCellier"><i class="fas fa-arrow-left"></i></button>
    </div>
</div>
<div class="mesFormulaires content">
    <h2>Modification d'une bouteille au cellier</h2>
    <div >
        <form class="formulaire">
            <div>
                <input type="text" name="nom" value="<?php echo $donnee['bouteille']['nom'] ?>" placeholder="Nom :"><label for="nom">Nom : </label>
                <p class="erreurnom"><?php  ?></p>
            </div>
            <div>
                <input type="text" name="image" value="<?php echo $donnee['bouteille']['image'] ?>" placeholder="Image :"><label for="image">Image : </label>
                <p class="erreurimage"></p>
            </div>
            <div>
                <input type="text" name="prix" value="<?php echo $donnee['bouteille']['prix'] ?>" maxlength="9" placeholder="Prix :"><label for="prix">Prix : </label>
                <p class="erreurprix"></p>
            </div>
            <div>
                <input type="text" name="format" value="<?php echo $donnee['bouteille']['format'] ?>" maxlength="7" placeholder="Format : (ml)"><label for="format">Format : </label>
                <p class="erreurformat"></p>
            </div>
            <div>
                <label for="type">Type : </label>
                <select name="type">
                    <?php
                        foreach($donnee['type'] as $type){
                            if($donnee['bouteille']['id_type'] == $type['id_type']){
                            ?>
                                <option value="<?= $type['id_type'] ?>" selected><?= $type['type'] ?></option>
                            <?php
                            }
                            else{
                            ?>
                                <option value="<?= $type['id_type'] ?>"><?= $type['type'] ?></option>
                            <?php
                            }
                        }
                    ?>
                </select>
            </div>
            <div>
                <label for="pays">Pays : </label>
                <select name="pays">
                    <?php
                        foreach($donnee['pays'] as $pays){
                            if($donnee['bouteille']['id_pays'] == $pays['id_pays']){
                            ?>
                                <option value="<?= $pays['id_pays'] ?>" selected><?= $pays['pays'] ?></option>
                            <?php
                            }
                            else{
                            ?>
                                <option value="<?= $pays['pays'] ?>"><?= $pays['pays'] ?></option>
                            <?php
                            }
                        }
                    ?>
                </select>
            </div>
            <div>
                <input type="text" name="millesime" value="<?php echo $donnee['bouteille']['millesime'] ?>" maxlength="4" placeholder="Millésime :"><label for="millesime">Millésime : </label>
                <p class="erreurmillesime"></p>
            </div>
            <div>
                <input type="text" name="codesaq" value="<?php echo $donnee['bouteille']['code_saq'] ?>" maxlength="8" placeholder="Code SAQ :"><label for="codesaq">Code SAQ : </label>
                <p class="erreurcodesaq"></p>
            </div>
            <div>
                <input type="text" name="urlsaq" value="<?php echo $donnee['bouteille']['url_saq'] ?>" placeholder="URL SAQ :"><label for="urlsaq">URL SAQ : </label>
                <p class="erreururlsaq"></p>
            </div>
            <input type="submit">
        </form>
        <p class="msg"></p>
        <input type="hidden" name="id_bouteille" value="<?php echo $donnee['bouteille']['id_bouteille'] ?>">
        <input type="hidden" name="nonliste" value="<?php echo $donnee['bouteille']['non_liste'] ?>">
        <input type="hidden" name="id_cellier" value="<?php echo $donnee['id_cellier'] ?>">
        <div class="boutonForm">
            <button class="retour btnWeb largeBtn rtrContenuCellier">Retour</button>
            <button class="largeBtn" name="modifier">Modifier la bouteille</button>
        </div>
        
        
    </div>
</div>
