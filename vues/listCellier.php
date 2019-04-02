
<div class="listCellier content contenuPage">

<?php
if($data){

    foreach ($data as $cle => $cellier) {
 
    ?>
    <div data-quantite="">
        <div>
            <p><a href="?requete=afficheContenuCellier&id_cellier=<?php echo $cellier['id_cellier'] ?>"><?php echo $cellier['nom'] ?></a></p>
        </div>
        
    </div>
   
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

