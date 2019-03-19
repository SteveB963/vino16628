<div class="mesFormulaires content">
    <h2>Modification d'une bouteille au cellier</h2>
    <div >
        <form class="formulaire">
            <div>
                <input type="text" name="nom" value="<?php echo $donnee['bouteille']['nom'] ?>" placeholder="Nom :"><label for="nom">Nom : </label>
                <p class="erreur"></p>
            </div>
            <div>
                <input type="text" name="image" value="<?php echo $donnee['bouteille']['image'] ?>" placeholder="Image :"><label for="image">Image : </label>
                <p class="erreur"></p>
            </div>
            <div>
                <input type="text" name="prix" value="<?php echo $donnee['bouteille']['prix'] ?>" placeholder="Prix :"><label for="prix">Prix : </label>
                <p class="erreur"></p>
            </div>
            <div>
                <input type="text" name="format" value="<?php echo $donnee['bouteille']['format'] ?>" placeholder="Format : (ml)"><label for="format">Format : </label>
                <p class="erreur"></p>
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
                <input type="text" name="millesime" value="<?php echo $donnee['bouteille']['millesime'] ?>" placeholder="Millésime :"><label for="millesime">Millésime : </label>
                <p class="erreur"></p>
            </div>
            <div>
                <input type="text" name="codesaq" value="<?php echo $donnee['bouteille']['code_saq'] ?>" placeholder="Code SAQ :"><label for="codesaq">Code SAQ : </label>
                <p class="erreur"></p>
            </div>
            <div>
                <input type="text" name="urlsaq" value="<?php echo $donnee['bouteille']['url_saq'] ?>" placeholder="URL SAQ :"><label for="urlsaq">URL SAQ : </label>
                <p class="erreur"></p>
            </div>
        </form>
        <input type="hidden" name="id" value="<?php echo $donnee['bouteille']['id_bouteille'] ?>">
        <input type="hidden" name="nonliste" value="<?php echo $donnee['bouteille']['non_liste'] ?>">
        <button name="sauver">Modifier la bouteille</button>
    </div>
</div>
