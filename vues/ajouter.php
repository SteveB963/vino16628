<div class="ajouter content">
    <h2>Ajouter une bouteille au cellier</h2>

    <div class="nouvelleBouteille" vertical layout>
        <input type="text" name="nom_bouteille" placeholder="Recherche"><label><i class="fas fa-search"></i></label>
        <ul class="listeAutoComplete">

        </ul>
            <form class="formAjout">
                <label id="labelNom">Nom : </label><span data-id="" class="nom_bouteille"></span>
                <label class="hide" for="millesime">Millesime : </label><input type="text" name="millesime" placeholder="Millesime">
                <label for="quantite">Quantite : </label><input type="number" name="quantite" value="1">
                <label for="date_achat">Date achat : </label><input type="date" name="date_achat">
                <label class="hide" for="prix">Prix : </label><input type="text" name="prix" placeholder="Prix">
                <label class="hide" for="garde_jusqua">Garde : </label><input name="garde_jusqua" placeholder="Garde">
                <label class="hide" for="notes">Notes </label><textarea name="notes" placeholder="Notes"></textarea>
                <button name="ajouterBouteilleCellier">Ajouter la bouteille</button>
            </form>
            
        </div>
    </div>
</div>
