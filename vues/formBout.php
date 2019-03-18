<?php
     $bteAvant = new Bouteille();
     $bteAvant = $bteAvant -> getBouteille(506);
        //$valeurs = Array();
    foreach($bteAvant as $champ => $valeur){
                    $valeurs[$champ] = $bteAvant[$champ];
                }

    var_dump($valeurs);
?>
<div class="mesFormulaires content">
    <h2>Modification d'une bouteille au cellier</h2>
    <div class="nouvelleBouteille" vertical layout>
        <form class="formulaire">
            <label id="labelNom">Nom : </label><input name="nom" value="<?php echo $donnee['bouteille']['nom'] ?>">
            <label class="hide">Image : </label><input name="image" value="<?php echo $donnee['bouteille']['image'] ?>">
            <label class="hide">Prix : </label><input name="prix" value="<?php echo $donnee['bouteille']['prix'] ?>">
            <label class="hide">Format : </label><input name="format" value="<?php echo $donnee['bouteille']['format'] ?>">
            <label>Type : </label><select name="type">
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
            <label>Pays : </label><select name="pays">
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
            <label class="hide">Millésime : </label><input name="millesime" value="<?php echo $donnee['bouteille']['millesime'] ?>">
            <label class="hide">Code SAQ : </label><input name="codesaq" value="<?php echo $donnee['bouteille']['code_saq'] ?>">
            <label class="hide">URL SAQ : </label><input name="urlsaq" value="<?php echo $donnee['bouteille']['url_saq'] ?>">
        </form>
        <input type="hidden" name="id" value="<?php echo $donnee['bouteille']['id_bouteille'] ?>">
        <input type="hidden" name="nonliste" value="<?php echo $donnee['bouteille']['non_liste'] ?>">
        <button name="sauver">Modifier la bouteille</button>
    </div>
</div>
