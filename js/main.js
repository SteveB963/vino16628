/**
 * @file Script contenant les fonctions de base
 * @author Jonathan Martel (jmartel@cmaisonneuve.qc.ca)
 * @version 0.1
 * @update 2019-01-21
 * @license Creative Commons BY-NC 3.0 (Licence Creative Commons Attribution - Pas d’utilisation commerciale 3.0 non transposé)
 * @license http://creativecommons.org/licenses/by-nc/3.0/deed.fr
 *
 */

// const BaseURL = "http://vino.jonathanmartel.info/";

window.addEventListener('load', function() {
    const BaseURL = document.baseURI;
    console.log(BaseURL);
    //console.log("load"); 
    //buttonn Boire
    document.querySelectorAll(".btnBoire").forEach(function(element){
        //console.log(element);
        element.addEventListener("click", function(evt){
            let id = evt.target.parentElement.dataset.id;
            let requete = new Request("index.php?requete=boireBouteilleCellier", {method: 'POST', body: '{"id": '+id+'}'});
            let quantite = document.querySelector("[data-quantite='" + id + "']")
            //console.log(quantite);
            
            fetch(requete)
            .then(response => {
                if(response.status === 200) {
                  return response.json();
                } else {
                  throw new Error('Erreur');
                }
              })
              .then(response => {
                console.debug(response);
                quantite.innerHTML = 'Quantité : '+ response.quantite;
              }).catch(error => {
                console.error(error);
              });
        })

    });
    
    //buttonn ajouter
    document.querySelectorAll(".btnAjouter").forEach(function(element){
        element.addEventListener("click", function(evt){
            //console.log("click ajouter");
            let id = evt.target.parentElement.dataset.id;
            let requete = new Request("index.php?requete=ajouterBouteilleCellier", {method: 'POST', body: '{"id": ' + id + '}'});
            //console.log(requete);
            let quantite = document.querySelector("[data-quantite='" + id + "']")
            //console.log(quantite);  
            fetch(requete)
            .then(response => {
                if (response.status === 200) {
                  return response.json();
                } else {
                  throw new Error('Erreur');
                }
              })
              .then(response => {
                console.debug(response);
                quantite.innerHTML = 'Quantité : '+ response.quantite;
              }).catch(error => {
                console.error(error);
              });
        })

    });
    
    //buttonn Trier par le selct box value
    let btnTrier = document.getElementById('trier');
    if(btnTrier){
        btnTrier.addEventListener("change", function(evt){
            var trier=document.getElementById('trier').value;
            console.log(trier);
            window.location.href = "index.php?requete=uploadPage&trierCellier=" + trier;
        });
    }  

    
    //autocomplete de rechercher champ
    let inputCherche = document.getElementById('searchValue');
    //console.log(inputNomBouteille);
    let listeCherche = document.querySelector('.listeChercheAutoComplete');
    if(inputCherche){
        inputCherche.addEventListener("keyup", function(evt){
        console.log(evt);
        let cherche= inputCherche.value;
        listeCherche.innerHTML = "";
        if(cherche){
            let requete = new Request("index.php?requete=autocompleteCherche", {method: 'POST', body: '{"cherche": "'+cherche+'"}'});
            fetch(requete)
              .then(response => {
                  if (response.status === 200) {
                    return response.json();
                  } else {
                    throw new Error('Erreur');
                  }
                })
                .then(response => {
                //affiche l'autocomlplete resultat en liste
                  response.forEach(function(element){
                    listeCherche.innerHTML += "<li class='listCherche' id='"+element.resultat +"'>"+element.resultat+"</a></li>";
                  })
                }).catch(error => {
                  console.error(error);
                });
            }
        });
    }
   
    //prendre le valeur du liste de recherche
    if( listeCherche){
        listeCherche.addEventListener("click", function(evt){
            console.dir(evt.target)
            if(evt.target.className == 'listCherche'){
                inputCherche.value = evt.target.id;
                console.log(evt.target.id);
                listeCherche.innerHTML = "";
            }
        });
    }
  
   
    //button chercher  dans mon cellier
    let btnChercher = document.getElementById('cherche');
    
    //quand on click en button chercher 
    if(btnChercher){
       btnChercher.addEventListener('click', function(){
            var inputCherche= document.getElementById('searchValue').value;
            console.log(inputCherche);
            //verifier le champ de chercher est vide ou pas
            if(inputCherche!=''){
                window.location.href = "index.php?requete=chercheValue&inputCherche=" + inputCherche;
             }
            else{
                alert('Vous devez entrer une valeur de champ rechercher');
                window.location.href = "index.php?requete=afficheCellier" ;
            }
        });
    }
    
   // vous pouvez clicker en button enter en clavier
   let inpChercher=document.getElementById('searchValue');
    if(inpChercher){
        inpChercher.addEventListener('keyup', function(){
           if (event.keyCode === 13) {
                //console.log("coucou");
                let inputCherche= document.getElementById('searchValue').value;
                console.log(inputCherche);
                //verifier le champ de chercher est vide ou pas
                if(inputCherche!=''){
                    window.location.href = "index.php?requete=chercheValue&inputCherche=" + inputCherche;
                 }
                else{
                    alert('Vous devez entrer une valeur de champ rechercher');
                    window.location.href = "index.php?requete=afficheCellier" ;
                }
           }
        });
    }

    //bouton modifier
    document.querySelectorAll(".btnModifier").forEach(function(element){
        element.addEventListener("click", function(evt){
            window.location.href ="index.php?requete=modifierBouteilleCellier&id=" + id;
            /*
            let id = evt.target.parentElement.dataset.id;
            let requete = new Request(BaseURL+"index.php?requete=modifierBouteilleCellier", {method: 'POST', body: '{"id": ' + id + '}'});

            fetch(requete)
            .then(response => {
                if (response.status === 200) {
                  return response.json();
                } else {
                  throw new Error('Erreur');
                }
              })
              .then(response => {
                console.log(response);
                window.location.href = BaseURL + "index.php?requete=modifierBouteilleCellier";
              }).catch(error => {
                console.error(error);
              });
              */
        })

    });
    
    //sauvegarde du formulaire
    var sauver = document.querySelector("[name='sauver']");
    if(sauver){
        sauver.addEventListener("click", function(evt){
            let id = evt.target.parentElement.dataset.id;
            let bouteille = {
                nom : document.querySelector("[name='nom']"),
                image : document.querySelector("[name='image']"),
                prix : document.querySelector("[name='prix']"),
                format : document.querySelector("[name='format']"),
                type : document.querySelector("[name='type']"),
                pays : document.querySelector("[name='pays']"),
                millesime : document.querySelector("[name='millesime']"),
                codesaq : document.querySelector("[name='codesaq']"),
                urlsaq : document.querySelector("[name='urlsaq']"),
            };
            /*
            //contien les valeurs du formulaire
            var param = {
                "id_bouteille":bouteille.nom.dataset.id,
                "date_achat":bouteille.date_achat.value,
                "garde_jusqua":bouteille.garde_jusqua.value,
                "notes":bouteille.date_achat.value,
                "prix":bouteille.prix.value,
                "quantite":bouteille.quantite.value,
                "millesime":bouteille.millesime.value,
              };
              */
            //let id = evt.target.parentElement.dataset.id;
            let requete = new Request("index.php?requete=modifierBouteilleCellier", {method: 'POST', body: '{"id": ' + id + '}'});
            fetch(requete)
            .then(response => {
                if (response.status === 200) {
                  return response.json();
                } else {
                  throw new Error('Erreur');
                }
              })
              .then(response => {
                console.log(response);
                window.location.href =BaseURL + "index.php?requete=modifierBouteilleCellier";
              }).catch(error => {
                console.error(error);
              });

        });
    }

    
    //autocomplete et ajout d'une bouteille
    let inputNomBouteille = document.querySelector("[name='nom_bouteille']");
    //console.log(inputNomBouteille);
    let liste = document.querySelector('.listeAutoComplete');
    if(inputNomBouteille){
      inputNomBouteille.addEventListener("keyup", function(evt){
        console.log(evt);
        let nom = inputNomBouteille.value;
        liste.innerHTML = "";
        if(nom){
          let requete = new Request("index.php?requete=autocompleteBouteille", {method: 'POST', body: '{"nom": "'+nom+'"}'});
          fetch(requete)
              .then(response => {
                  if (response.status === 200) {
                    return response.json();
                  } else {
                    throw new Error('Erreur');
                  }
                })
                .then(response => {
                  console.log(response);
                  
                 
                  response.forEach(function(element){
                    liste.innerHTML += "<li data-id='"+element.id_bouteille +"'>"+element.nom+"</li>";
                  })
                }).catch(error => {
                  console.error(error);
                });
        }
        
        
      });

      let bouteille = {
        nom : document.querySelector(".nom_bouteille"),
        millesime : document.querySelector("[name='millesime']"),
        quantite : document.querySelector("[name='quantite']"),
        date_achat : document.querySelector("[name='date_achat']"),
        prix : document.querySelector("[name='prix']"),
        garde_jusqua : document.querySelector("[name='garde_jusqua']"),
        notes : document.querySelector("[name='notes']"),
      };

    if(liste){
        liste.addEventListener("click", function(evt){
            console.dir(evt.target)
            if(evt.target.tagName == "LI"){
                bouteille.nom.dataset.id = evt.target.dataset.id;
                bouteille.nom.innerHTML = evt.target.innerHTML;
                liste.innerHTML = "";
                inputNomBouteille.value = "";

            }
        });
    }

      let btnAjouter = document.querySelector("[name='ajouterBouteilleCellier']");
      if(btnAjouter){
        btnAjouter.addEventListener("click", function(evt){
          var param = {
            "id_bouteille":bouteille.nom.dataset.id,
            "date_achat":bouteille.date_achat.value,
            "garde_jusqua":bouteille.garde_jusqua.value,
            "notes":bouteille.date_achat.value,
            "prix":bouteille.prix.value,
            "quantite":bouteille.quantite.value,
            "millesime":bouteille.millesime.value,
          };
          let requete = new Request("index.php?requete=ajouterNouvelleBouteilleCellier", {method: 'POST', body: JSON.stringify(param)});
            fetch(requete)
                .then(response => {
                    if (response.status === 200) {
                      return response.json();
                    } else {
                      throw new Error('Erreur');
                    }
                  })
                  .then(response => {
                    console.log(response);
                  
                  }).catch(error => {
                    console.error(error);
                  });
        
        });
      } 
  }
    

});

