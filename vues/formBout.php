<div class="ajouter content">
    <h2>Modification d'une bouteille au cellier</h2>
    <div class="nouvelleBouteille" vertical layout>
        <form class="formAjout">
            <label id="labelNom">Nom : </label><input data-id="<?php echo $resultat['bouteille']['id_bouteille'] ?>" name="nom" value="<?php echo $resultat['bouteille']['nom'] ?>">
            <label class="hide">Image : </label><input name="image" value="<?php echo $resultat['bouteille']['image'] ?>">
            <label class="hide">Prix : </label><input name="prix" value="<?php echo $resultat['bouteille']['prix'] ?>">
            <label class="hide">Format : </label><input name="format" value="<?php echo $resultat['bouteille']['format'] ?>">
            <label>Type : </label><select name="type">
                <?php
                    foreach($resultat['type'] as $type){
                        if($resultat['bouteille']['type'] == $type['type']){
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
            <label>Pays : </label><select name="pays">
                <?php
                    foreach($resultat['pays'] as $pays){
                        if($resultat['bouteille']['pays'] == $pays['pays']){
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
            <label class="hide">Millésime : </label><input name="millesime" value="<?php echo $resultat['bouteille']['millesime'] ?>">
            <label class="hide">Code SAQ : </label><input name="codesaq" value="<?php echo $resultat['bouteille']['code_saq'] ?>">
            <label class="hide">URL SAQ : </label><input name="urlsaq" value="<?php echo $resultat['bouteille']['url_saq'] ?>">
        </form>
        <button name="modifierBouteilleCellier">Modifier la bouteille</button>
    </div>
</div>
