
<div class="listCellier content contenuPage">

<?php
if($data){

    foreach ($data as $cle => $cellier) {
 
    ?>
     <!-- <div class="bouteille"> -->
    
        <!-- <div class="img">
            
            <img src="https:<?php echo $cellier['image'] ?>">
        </div> -->
        <div class="description">
            <p class="nom"><a href="?requete=afficheContenuCellier&id_cellier=<?php echo $cellier['id_cellier'] ?>"><?php echo $cellier['nom'] ?></a>
                <div class="options"  data-id="<?php echo $cellier['id_cellier']  ?>">
                    <button class='btnModifierNomCellier'>Modifier</button>
                    <button class='btnSupprimerCellier'>Supprimer</button>
                </div>
            </p>
           
        </div>
        
    
    <!-- </div> -->
   
<?php
    }

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

