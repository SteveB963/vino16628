/**
 * @file Script contenant les fonctions de base
 * @author Jonathan Martel (jmartel@cmaisonneuve.qc.ca)
 * @version 0.1
 * @update 2019-01-21
 * @license Creative Commons BY-NC 3.0 (Licence Creative Commons Attribution - Pas d’utilisation commerciale 3.0 non transposé)
 * @license http://creativecommons.org/licenses/by-nc/3.0/deed.fr
 *
 */

window.addEventListener('load', function() {
    const BaseURL = document.baseURI;
    
    //buttonn Boire
    document.querySelectorAll(".btnBoire").forEach(function(element){
        element.addEventListener("click", function(evt){
            let id = evt.target.parentElement.dataset.id;
            let requete = new Request("index.php?requete=boireBouteilleCellier", {method: 'POST', body: '{"id": '+id+'}'});
            let quantite = document.querySelector("[data-quantite='" + id + "']")
            
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

    //bouton ajouter, ajoute un bouteille dans le cellier
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
   
    //bouton modifier bouteille dans un cellier
    document.querySelectorAll(".btnModifier").forEach(function(element){
        element.addEventListener("click", function(evt){
            let id = evt.target.parentElement.dataset.id;
            window.location.href = BaseURL + "index.php?requete=modifierBouteilleCellier&id=" + id; 
    
        })

    });
    
    //vérifie les champs et sauvegrade les modifications effectués
    var sauver = document.querySelector("[name='sauver']");
    if(sauver){
        sauver.addEventListener("click", function(evt){
            let id = evt.target.parentElement.dataset.id; 
            let bouteille = {
                id_bouteille : document.querySelector("[name='id']").value,
                nom : document.querySelector("[name='nom']").value,
                image : document.querySelector("[name='image']").value,
                prix : document.querySelector("[name='prix']").value.replace(/,/,'.'),
                format : document.querySelector("[name='format']").value,
                id_type : document.querySelector("[name='type']").value,
                id_pays : document.querySelector("[name='pays']").value,
                millesime : document.querySelector("[name='millesime']").value,
                code_saq : document.querySelector("[name='codesaq']").value,
                url_saq : document.querySelector("[name='urlsaq']").value,
                non_liste : document.querySelector("[name='nonliste']").value
            };
            
            let verif = {
                nom : verifChamp(bouteille.nom,"text"),
                image : verifChamp(bouteille.image,"text"),
                prix : verifChamp(bouteille.prix,"prix"),
                format : verifChamp(bouteille.format,"num"),
                millesime : verifChamp(bouteille.millesime,"num",4),
                code_saq : verifChamp(bouteille.code_saq,"num",8),
                url_saq : verifChamp(bouteille.url_saq,"text")
            };
            
            //document.querySelector(".erreurNom").innerHTML = "khdsgfhjs";
            let body = { 
                bte :  bouteille,
                verif : verif
            }
            
            bouteille = JSON.stringify(body);
            
            let requete = new Request(BaseURL+"index.php?requete=modifierBouteilleCellier", {method: 'POST', headers: {"Content-Type": "application/json"}, body: bouteille });

            fetch(requete)
            .then(response => response.json())
            .then(data =>{
                console.log(data);
                
                document.querySelector(".erreurNom").innerHTML = data.erreur.nom;
                document.querySelector(".erreurImage").innerHTML = data.erreur.image;
                document.querySelector(".erreurPrix").innerHTML = data.erreur.prix;
                document.querySelector(".erreurFormat").innerHTML = data.erreur.format;
                document.querySelector(".erreurMillesime").innerHTML = data.erreur.millesime;
                document.querySelector(".erreurCodesaq").innerHTML = data.erreur.code_saq;
                document.querySelector(".erreurUrlsaq").innerHTML = data.erreur.url_saq;
                
                if(data.echec){
                    document.querySelector(".msg").innerHTML = "<i class='fas fa-check-circle'></i>" + data.echec;
                }
                else{
                    if(data.succes == true){
                        document.querySelector(".msg").innerHTML = "<i class='fas fa-check-circle'></i> Modification sauvegarder";
                        document.querySelector(".msg").firstElementChild.classList.add("succes");
                        if(data.status == "remplaceBouteille"){
                            document.querySelector("[name='id']").setAttribute("value", data.idNouvelle);
                            document.querySelector("[name='nonliste']").setAttribute("value", 1);
                            history.pushState("modification", "Vino", BaseURL + "index.php?requete=modifierBouteilleCellier&id=" + data.idNouvelle);
                        }
                    }
                    else if(data.succes == "dup"){
                        document.querySelector(".msg").innerHTML = "Aucune modification effectuer";
                    }
                    else{
                        document.querySelector(".msg").classList.add("attention");
                        document.querySelector(".msg").innerHTML = "<i class='fas fa-exclamation-triangle'></i> Corriger les erreurs et réessayer";
                    }
                    /*
                    setTimeout(function(){ 
                        document.querySelector(".msg").innerHTML = "";
                    }, 2000);
                    */
                }
            }).catch(error => {
                console.error(error);
            });

        });
    }
    
    //buttonn Trier par le selct box value
     let btnTrier = document.getElementById('trier');
    if(btnTrier){
        btnTrier.addEventListener("change", function(evt){
          var trier=document.getElementById('trier').value;
            console.log(trier);
            window.location.href = "index.php?requete=uploadPage&trierCellier=" + trier;
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
                    liste.innerHTML += "<li data-id='"+element.id +"'>"+element.nom+"</li>";
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


      liste.addEventListener("click", function(evt){
        console.dir(evt.target)
        if(evt.target.tagName == "LI"){
          bouteille.nom.dataset.id = evt.target.dataset.id;
          bouteille.nom.innerHTML = evt.target.innerHTML;
          
          liste.innerHTML = "";
          inputNomBouteille.value = "";

        }
      });

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
    
    
    
    function verifChamp(champ,type,long = 0){  
        var resultat = "";
        let regex = "";
        if(champ.trim() != "" && champ.replace(/<(?:.|\n)*?>/gm, '') != ""){
            if(long != 0 && champ.length < long){
                resultat = "Entré trop courte, " + long + " caratères min."
            }
            else{
                switch(type){
                    case 'text' :
                        regex = new RegExp(/^.+$/);
                        resultat = regex.test(champ);
                        if(!resultat){
                            resultat = "Entré invalide";
                        }
                        else{
                            resultat = "";
                        }
                        break;
                    case 'prix' :
                        regex = new RegExp(/^\d{1,6}(.\d{1,2})?$/);
                        resultat = regex.test(champ);
                        if(!resultat){
                            resultat = "Le prix que vous avez entré est invalide";
                        }
                        else{
                            resultat = "";
                        }
                        break;
                    case 'date' :
                        break;
                    case 'num' :
                        regex = new RegExp(/^\d+$/);
                        resultat = regex.test(champ);
                        if(!resultat){
                            resultat = "Entrez un nombre valide";
                        }
                        else{
                            resultat = "";
                        }
                        break;
                }
            }
        }
        else{
            resultat = "veuillez remplir le champ";
        }
        
        return resultat;
    }
    
});

