<div class="mesFormulaires content">
    <h2>Ajouter une bouteille au cellier</h2>

    <div class="nouvelleBouteille" vertical layout>
        <div class="recherche">
            <input type="text" name="nom_bouteille" placeholder="Rechercher"><label><i class="fas fa-search"></i></label>
        </div>
        
        <ul class="listeAutoComplete">

        </ul>
            <form class="formulaire">
                <label id="labelNom">Nom : </label><span data-id="" class="nom_bouteille"></span>
                <div>
                    <input type="text" name="millesime" placeholder="Millesime"><label class="hide" for="millesime">Millesime : </label>
                </div>
                <div class="formChiffre">
                    <div>
                        <label for="quantite">Quantite : </label><input type="number" name="quantite" value="1">
                    </div>
                    <div>
                        <label for="date_achat">Date achat : </label><input type="date" name="date_achat">
                    </div>
                </div>
                <div>
                    <input type="text" name="prix" placeholder="Prix"><label class="hide" for="prix">Prix : </label>
                </div>
                <div>
                    <input name="garde_jusqua" placeholder="Garde"><label class="hide" for="garde_jusqua">Garde : </label>
                </div>
                <label class="hide" for="notes">Notes </label><textarea name="notes" placeholder="Notes"></textarea>
                <button name="ajouterBouteilleCellier">Ajouter la bouteille</button>
            </form>
            
        </div>
    </div>
</div>
