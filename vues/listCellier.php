<!-- listCellier contenuPage -->
<div class="contenuCellier listCellier">

    <div class="listCellierDivGauche">
        <div class="monCompte">
            <div>
                <div>
                    <h2>Mon Compte</h2>
                </div>
            </div>

<?php
    if(isset($msgConfirmation))
    {
        echo "<div class='confirmBox'>
                   <p>$msgConfirmation</p>
                </div>";
    }
?>
            <div>
                <p><strong>Prenom: </strong><?php echo $_SESSION["prenomUtilisateur"] ?></p>
                <p><strong>Nom: </strong><?php echo $_SESSION["nomUtilisateur"] ?></p>
                <p><strong>Adresse Courriel: </strong><?php echo $_SESSION["emailUtilisateur"] ?></p>
            </div>
        </div>
        <button name="modifierCompte" class='xlargeBtn'>Modifier mon compte<i class="fas fa-user-edit"></i></button>
    </div>

    <div class="mesCelliers">
        <h2>Mes Celliers</h2>
        <button class='btnAjoutCellier'>Ajouter un cellier</button>
        <div class="divMesCelliers">
<?php
if($data){

    foreach ($data as $cle => $cellier) {
 
    ?>
        <div>
            <p class="nom"><a href="?requete=afficheContenuCellier&id_cellier=<?php echo $cellier['id_cellier'] ?>"><?php echo $cellier['nom'] ?></a></p>
            <div class="options"  data-id="<?php echo $cellier['id_cellier']  ?>">
                <button class='btnModifierNomCellier btnWeb'>Modifier <i class="fas fa-pen"></i></button>
                <button class='btnSupprimerCellier btnWeb'>Supprimer <i class="fas fa-trash-alt"></i></button>
                <button class='btnModifierNomCellier btnMobile'><i class="fas fa-pen"></i></button>
                <button class='btnSupprimerCellier btnMobile'><i class="fas fa-trash-alt"></i></button>
            </div>
           
        </div> 
<?php
    }
?>
        </div>
    </div>
<?php
}
else{

?>
    <div class="aucunCellier">
        <h2>Vous ne posséder aucun cellier pour le moment.</h2>
        <h4>Vous pouvez créer un cellier personnel en cliquant sur le bouton ci-dessus.</h4>
        <div class="aucunCellierInfos">
            <h4>À quoi sert le cellier?</h4>
            <p>Avoir un cellier vous permettra par la suite d'y ajouter vos bouteilles, de les modifier et de les supprimer lorsqu'elles auront été bu. Il vous sera donc possible de toujours savoir quelles bouteilles vous posséder au chalet ou à la maison!</p>
        </div>
    </div>
    
<?php    
}
?>

</div>
