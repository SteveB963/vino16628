<div class="mesFormulaires content">
    <h2>Créer votre nouveau cellier</h2>

    <div class="nouvelleBouteille" vertical layout>
        
            <form class="formAjout"method="POST" action="index.php?requete=afficheListCellier">
                
                <label for="id_usager">id_usager : </label><input type="number" name="id_usager">
                <label for="nom">Nom : </label><input type="text" name="nom">
                <!-- <input type="hidden"  name="listeCellier" value="1"> -->
               
                 <button name="creerCellier">Créer votre cellier</button>
            </form>
            
        
    </div>
</div>
