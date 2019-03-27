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

    //bouton créer un cellier
    let btnCreer = document.querySelector("[name='creerCellier']");
    
    if(btnCreer){
      let cellier = { 
        nom : document.querySelector("[name='nom']") 
      };
      btnCreer.addEventListener("click", function(){              
        var param = {            
          "nom":cellier.nom.value
        };
      
        let requete = new Request("index.php?requete=creerUnCellier", {method: 'POST', body: JSON.stringify(param)});
        console.log(JSON.stringify(param));
        
        fetch(requete)
              .then(response => {
                    if (response.status === 200) {
                        return response.json();
                    } else {
                        throw new Error('Erreur');
                    }
                })
                .then(data => { 
                  console.log(data);
                      if(data == true){
                         window.location.href = "index.php?requete=afficheListCellier";
                      } 
                })
                .catch(error => {
                    console.error(error);
                });
      });
    }


    
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

    //buttonn Trier par le selct box value
    let btnTrier = document.getElementById('trier');
    if(btnTrier){
        btnTrier.addEventListener('change', function(evt){
            var trier=btnTrier.options[btnTrier.selectedIndex].value;
            //btnTrier.selectedIndex = 0;
            var id_cellier = document.querySelector("[name='cellier']").getAttribute("data-id");
            window.location.href = "index.php?requete=afficheCellier&id_cellier=" + id_cellier + "&trierCellier=" + trier;
        });
    } 
    
    //autocomplete de rechercher champ
    let inputCherche = document.getElementById('searchValue');
    //console.log(inputCherche);
    let listeCherche = document.querySelector('.listeChercheAutoComplete');
    let listeNom = document.querySelector('.listeNom');
    let listePrix = document.querySelector('.listePrix');
    let listePays = document.querySelector('.listePays');
    let listeType = document.querySelector('.listeType');
    let listeMillesime = document.querySelector('.listeMillesime');
    let listeFormat = document.querySelector('.listeFormat');
    let listeCode = document.querySelector('.listeCode');
    
    if(inputCherche){
        inputCherche.addEventListener("keyup", function(evt){
        let cherche= inputCherche.value;
        listeCherche.innerHTML = "";
        
        //separer le type de resultat de rechearche(nom,type, prix...etc) chaque resultat en liste separe
        listeNom.innerHTML ="<li>Nom:</li>";
        listeNom.style.visibility="hidden";
        listePrix.innerHTML ="<li>Prix:</li>";
        listePrix.style.visibility="hidden";
        listePays.innerHTML ="<li>Pays:</li>";
        listePays.style.visibility="hidden";
        listeType.innerHTML ="<li>Type:</li>";
        listeType.style.visibility="hidden";
        listeMillesime.innerHTML ="<li>Millesime:<li>";
        listeMillesime.style.visibility="hidden";
        listeFormat.innerHTML ="<li>Format:</li>";
        listeFormat.style.visibility="hidden";
        listeCode.innerHTML ="<li>Code:</li>";
        listeCode.style.visibility="hidden";
        //console.log(cherche);
        var id_cellier = document.querySelector("[name='cellier']").getAttribute("data-id");
        if(cherche){
            let requete = new Request("index.php?requete=autocompleteCherche", {method: 'POST', body: '{"cherche": "'+cherche+'"}'});
            console.log(requete);
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
                //verifier chaque resultat de recherche 
                  if(element.nom){
                       listeNom.style.visibility="visible";
                        listeNom.innerHTML += "<li class='listCherche' id='"+element.nom +"'>"+element.nom+"</li>";  
                    }
                     if(element.prix){
                        listePrix.style.visibility="visible";
                        listePrix.innerHTML += "<li class='listCherche' id='"+element.prix+"'>"+element.prix+"</li>";
                    }
                    if(element.pays){
                        listePays.style.visibility="visible";
                        listePays.innerHTML += "<li class='listCherche' id='"+element.pays+"'>"+element.pays+"</li>";
                    }
                    if(element.type){
                        listeType.style.visibility="visible";
                        listeType.innerHTML += "<li class='listCherche' id='"+element.type+"'>"+element.type+"</li>";
                    }
                    if(element.format){
                        listeFormat.style.visibility="visible";
                        listeFormat.innerHTML += "<li class='listCherche' id='"+element.format+"'>"+element.format+"</li>";
                    }
                    if(element.millesime){
                        listeMillesime.style.visibility="visible";
                        listeMillesime.innerHTML += "<li class='listCherche' id='"+element.millesime+"'>"+element.millesime+"</li>"; 
                    }
                    if(element.code){
                        listeCode.style.visibility="visible";
                        listeCode.innerHTML += "<li class='listCherche' id='"+element.code+"'>"+element.code+"</li>"; 
                    }
                })
                //verifier le length de chaque liste 
                if (listeNom.children.length > 1) { 
                    listeCherche.innerHTML +=listeNom.innerHTML; 
                }
                if (listePrix.children.length > 1) { 
                    listeCherche.innerHTML +=listePrix.innerHTML ;
                }
                if (listePays.children.length > 1) { 
                    listeCherche.innerHTML +=listePays.innerHTML ;
                }
                if (listeType.children.length > 1) { 
                    listeCherche.innerHTML +=listeType.innerHTML ;
                }
                if (listeFormat.children.length > 1) { 
                    listeCherche.innerHTML +=listeFormat.innerHTML ;
                }
                if (listeMillesime.children.length > 1) { 
                    listeCherche.innerHTML +=listeMillesime.innerHTML ;
                }
                if (listeCode.children.length > 1) { 
                    listeCherche.innerHTML +=listeCode.innerHTML ;
                }
                  
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
           var id_cellier = document.querySelector("[name='cellier']").getAttribute("data-id");
            if(inputCherche!=''){
                window.location.href = "index.php?requete=afficheCellier&id_cellier=" + id_cellier + "&inputCherche=" + inputCherche;
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
                var id_cellier = document.querySelector("[name='cellier']").getAttribute("data-id");
                //verifier le champ de chercher est vide ou pas
                if(inputCherche!=''){
                    window.location.href = "index.php?requete=afficheCellier&id_cellier=" + id_cellier + "&inputCherche=" + inputCherche;
                 }
                else{
                    alert('Vous devez entrer une valeur de champ rechercher') ;
                }
           }
        });
    }

    
    //bouton modifier bouteille dans un cellier
    document.querySelectorAll(".btnModifier").forEach(function(element){
        element.addEventListener("click", function(evt){
            let id_bouteille = evt.target.parentElement.dataset.id;
            let id_cellier = document.querySelector("[name='cellier']").getAttribute("data-id")
            window.location.href = BaseURL + "index.php?requete=modifierBouteilleCellier&id_bouteille=" + id_bouteille + "&id_cellier=" + id_cellier; 
    
        })

    });
    
    //bouton retour au contenu d'un cellier
    var retourCellier = document.querySelector("[name='retourCellier']");
    if(retourCellier){
        let id_cellier = document.querySelector("[name='id_cellier']").value;
        retourCellier.addEventListener("click", function(evt){
            window.location.href = BaseURL + "index.php?requete=afficheCellier&id_cellier=" +   id_cellier; 
        });
    }
    
    //vérifie les champs et sauvegrade les modifications effectués sur une bouteille dans un cellier
    var sauver = document.querySelector("[name='sauver']");
    if(sauver){
        sauver.addEventListener("click", function(evt){
            //récupère les informations de la bouteille dans les inputs
            let bouteille = {
                id_bouteille : document.querySelector("[name='id_bouteille']").value,
                id_cellier : document.querySelector("[name='id_cellier']").value,
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
            
            //vérifi si les champs sont remplis
            let verif = {
                nom : verifChamp(bouteille.nom,"text"),
                image : verifChamp(bouteille.image,"text"),
                prix : verifChamp(bouteille.prix,"prix"),
                format : verifChamp(bouteille.format,"num"),
                millesime : verifChamp(bouteille.millesime,"num",4),
                code_saq : verifChamp(bouteille.code_saq,"num",8),
                url_saq : verifChamp(bouteille.url_saq,"text")
            };
            
            
            let body = { 
                bte :  bouteille,
                verif : verif
            }
            
            body = JSON.stringify(body);
            
            //envoie de la requete avec les informations du formulaire et les erreurs de champs
            let requete = new Request(BaseURL+"index.php?requete=modifierBouteilleCellier", {method: 'POST', headers: {"Content-Type": "application/json"}, body: body });

            fetch(requete)
            .then(response => response.json())
            .then(data =>{
                //retourne les erreurs au champs approprié
                document.querySelector(".erreurNom").innerHTML = data.erreur.nom;
                document.querySelector(".erreurImage").innerHTML = data.erreur.image;
                document.querySelector(".erreurPrix").innerHTML = data.erreur.prix;
                document.querySelector(".erreurFormat").innerHTML = data.erreur.format;
                document.querySelector(".erreurMillesime").innerHTML = data.erreur.millesime;
                document.querySelector(".erreurCodesaq").innerHTML = data.erreur.code_saq;
                document.querySelector(".erreurUrlsaq").innerHTML = data.erreur.url_saq;
                
                //éhec sql affiche l'erreur sql
                if(data.echec){
                    document.querySelector(".msg").innerHTML = "<i class='fas fa-check-circle'></i>" + data.echec;
                }
                else{
                    //si l'operation est un succès
                    if(data.succes == true){
                        //affiche le message
                        document.querySelector(".msg").innerHTML = "<i class='fas fa-check-circle'></i> Modification sauvegarder";
                        document.querySelector(".msg").firstElementChild.classList.add("succes");
                        
                        //si ajout et remplacement d'id est effectuer, l'id dans le form est mit à jour ainsi que lui dans l'url
                        if(data.status == "remplaceBouteille"){
                            document.querySelector("[name='id_bouteille']").setAttribute("value", data.idNouvelle);
                            document.querySelector("[name='nonliste']").setAttribute("value", 1);
                            history.pushState("modification", "Vino", BaseURL + "index.php?requete=modifierBouteilleCellier&id_bouteille=" + data.idNouvelle + "&id_cellier=" + bouteille.id_cellier);
                        }
                        setTimeout(function(){ 
                            document.querySelector(".msg").innerHTML = "";
                        }, 2000);
                    }
                    //si pas eu de modification
                    else if(data.succes == "dup"){
                        document.querySelector(".msg").classList.remove("attention");
                        document.querySelector(".msg").innerHTML = "Aucune modification effectuer";
                        setTimeout(function(){ 
                            document.querySelector(".msg").innerHTML = "";
                        }, 2000);
                    }
                    //si erreur dans les champs
                    else{
                        document.querySelector(".msg").classList.add("attention");
                        document.querySelector(".msg").innerHTML = "<i class='fas fa-exclamation-triangle'></i> Corriger les erreurs et réessayer";
                    }  
                }
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

        //bouton formulaire d'ajout de bouteille
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
    
    
    /**
     * vérifie si un champ est remplis, de la bonne longeur et valide
     *
     * @pram str champ valeur d'un champ
     * @pram str type type de champ à vérifier
     * @pram int long optionnel longeur minimum requise pour le champ
     *
     * @return str resultat message d'erreur ou vide si le champ est valide
     */
    function verifChamp(champ,type,long = 0){  
        var resultat = "";
        let regex = "";
        //vérifie si le champ est rempli et retire les tags html
        if(champ.trim() != "" && champ.replace(/<(?:.|\n)*?>/gm, '') != ""){
            //vérifie la longueur d'un champ
            if(long != 0 && champ.length < long){
                resultat = "Entré trop courte, " + long + " caratères min."
            }
            else{
                switch(type){
                    //si le champ est du text
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
                    //si le champ est un prix
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
                    //si le champ est une date
                    case 'date' :
                        break;
                    //si le champ est numérique
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
    
    //si la source d'une image d'une bouteille de vin ne charge pas
    //l'image par défault sera affiché
    let images = document.querySelectorAll(".imgvin");
    images.forEach(function(element){
        if(element.width == 15){
            element.setAttribute("src", "./images/vindefault.jpg")
        }
    });
  
  //Inscription - Ajout d'un nouveau compte
  let compte = {
    prenom : document.querySelector("[name='prenomInscri']"),
    nom : document.querySelector("[name='nomInscri']"),
    courriel : document.querySelector("[name='courrielInscri']"),
    motDePasse : document.querySelector("[name='motPasseInscri']"),
  };

  let btnInscription = document.querySelector("[name='ajouterNouveauCompte']");
  if(btnInscription){
    btnInscription.addEventListener("click", function(evt){
      var param = {
        "prenomInscri": compte.prenom.value,
        "nomInscri": compte.nom.value,
        "courrielInscri": compte.courriel.value,
        "motPasseInscri": compte.motDePasse.value,
      };
      let requete = new Request("index.php?requete=creerCompteUsager", {method: 'POST', body: JSON.stringify(param)});
      fetch(requete)
        .then(response => {
          if (response.status === 200) {
            return response.json();
          } else {
            throw new Error('Erreur');
          }
        })
        .then(data => {
          console.log(data);
          if(data == true){
            window.location.href ="index.php?requete=compte";
          }
          else{
            //Affichage d'un message d'erreur lorsque la 
            //connexion à échoué.
            document.querySelector("[name='msgErreur']").classList.add('errorBox');
            var messageErreur = "Les informations entrées sont incorrectes.";
            document.querySelector("[name='msgErreur']").innerHTML = messageErreur;
          }
        }).catch(error => {
          console.error(error);
        });
    });
  }


  //Connexion - Gestion du formulaire de connexion
  let infoConnection = {
    courriel : document.querySelector("[name='courrielCo']"),
    motDePasse : document.querySelector("[name='motPasseCo']"),
  };

  let btnConnection = document.querySelector("[name='seConnecter']");
  if(btnConnection){
    btnConnection.addEventListener("click", function(evt){
      var param = {
        "courrielCo": infoConnection.courriel.value,
        "motPasseCo": infoConnection.motDePasse.value,
      }
      let requete = new Request("index.php?requete=login", {method: 'POST', body: JSON.stringify(param)});
      fetch(requete)
        .then(response =>{
          if (response.status === 200) {
            return response.json();
          }
          else{
            throw new Error('Erreur');
          }
        })
        .then(data => {
          //Redirection vers la page monCompte lorsque la
          //connection à réussie.
          console.log(data);
          if(data == true){
            window.location.href ="index.php?requete=compte";
          }
          else{
            //Affichage d'un message d'erreur lorsque la 
            //connexion à échoué.
            document.querySelector("[name='msgErreur']").classList.add('errorBox');
            var messageErreur = "Les informations entrées sont incorrectes.";
            document.querySelector("[name='msgErreur']").innerHTML = messageErreur;
          }
          
        }).catch(error => {
          console.error(error);
        });
    });
  }
/*
  let btnModif = document.querySelector("[name='modifierCompte']");
  if(btnModif){
    btnModif.addEventListener("click", function(evt){
      window.location.href = "index.php?requete=modificationCompte";
    });
  }
*/

}       );

