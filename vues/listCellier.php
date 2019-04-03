<!-- listCellier contenuPage -->
<div class="content contenuCellier">

    <div class="monCompte">
        <div>
            <div>
                <h2>Mon Compte</h2>
                <p><a name="modifierCompte">Modifier<i class="fas fa-user-edit"></i></a></p>
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

    <div class="mesCelliers">
        <h2>Mes Celliers</h2>
        <!-- mesCellliers -->
        <div class="divMesCelliers">
<?php
if($data){

    foreach ($data as $cle => $cellier) {
 
    ?>
            <div>
                <p><a href="?requete=afficheContenuCellier&id_cellier=<?php echo $cellier['id_cellier'] ?>"><?php echo $cellier['nom'] ?></a></p>
                <div>
                    <button>test</button>
                    <button>test2</button>
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
    <div class="">
        <h2>Vous ne posséder aucun cellier pour le moment.</h2>
        <h4>Vous pouvez créer un cellier personnel <a href="?requete=creerUnCellier">ici</a>.</h4>
        <h4>À quoi sert le cellier?</h4>
        <p>Avoir un cellier vous permettra par la suite d'y ajouter vos bouteilles, de les modifier et de les supprimer lorsqu'elles auront été bu. Il vous sera donc possible de toujours savoir quelles bouteilles vous posséder au chalet ou à la maison!</p>
    </div>
    
<?php    
}
?>

</div>
