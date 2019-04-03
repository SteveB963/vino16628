<div class="mesFormulaires content">
    <h2>Ajouter une bouteille au cellier</h2>

    <div class="nouvelleBouteille" vertical layout>
        <div class="divAutoComplete">
            <div class="recherche">
                <input type="text" name="nom_bouteille" placeholder="Rechercher"><label><i class="fas fa-search"></i></label>
            </div>
            
            <ul class="listeAutoComplete">

            </ul>
        </div>
            <form class="formulaire">
                <div>
                    <label id="labelNom">Nom : </label><input data-id="" class="nom_bouteille" disabled>
                    <p class="erreurnom"></p>
                </div>
                <div>
                    <label for="date_ajout">Date ajout : </label><input type="date" name="date_ajout">
                    <p class="erreurdate"></p>
                </div>
                <div>
                    <label for="garde_jusqua">Garder jusqu'à : </label><input type="date" name="garde_jusqua">
                    <p class="erreurgarde"></p>
                </div>
                <input type="button" name="ajouterNouvelleBouteille" value="Ajouter la bouteille">
                <input type="hidden" name="cellier" value="<?= $_GET['id_cellier'] ?>">
            </form>
            
        </div>
    </div>
</div>
