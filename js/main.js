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
                 
                
                }).catch(error => {
                  console.error(error);
                });
      });
    }
    
    //button modifier dans la liste
    document.querySelectorAll(".modifDate").forEach(function(element){
        actionModifierDate(element);
    });
    
    /**
     * active la modification des dates sur une bouteille dans un cellier
     *
     * @param DOM Element element bouton boire
     */
    function actionModifierDate(element){
        element.addEventListener("click", function(evt){
            
            //annule opération modif sur les autre champs
            let champActif = document.querySelectorAll(".active");
            if(champActif){
                champActif.forEach(function(champ){
                    let date_ajout = champ.children[0].dataset.date;
                    let garde_jusqua = champ.children[1].dataset.date;
                    
                    champ.classList.remove("active");
                    champ.children[0].innerHTML = "<td>" + date_ajout + "</td>";
                    champ.children[1].innerHTML = "<td>" + garde_jusqua + "</td>";
                    champ.children[2].innerHTML = "<button class='modifDate'><i class='fas fa-pen'></i></button>";
                    actionModifierDate(champ.children[2].firstChild);
                
                    champ.nextElementSibling.children[0].innerHTML = "";
                });
            }
            
            let td = evt.currentTarget.parentNode;
            let tr = td.parentNode;
            let date_ajout = tr.children[0].dataset.date;
            let garde_jusqua = tr.children[1].dataset.date;
            
            td.parentNode.classList.add("active");
            td.innerHTML = "<button class='accpetModif'><i class='fas fa-check'></i></button>"+
                            "<button class='annuleModif'><img class='icone' src='./images/icones/times-solid.svg'></button>";
            tr.children[0].innerHTML = "<input type='date' name='date_ajout' value='" + date_ajout + "'>";
            tr.children[1].innerHTML = "<input type='date' name='garde_jusqua' value='" + garde_jusqua + "'>";
            
            traitementModifierDate(td.firstChild);
            annuleModifierDate(td.children[1]);
            
            
            
        });
    }
    
    function traitementModifierDate(element){
        element.addEventListener("click", function(evt){
            let tr = evt.currentTarget.parentNode.parentNode;
            let erreur = false;
  
            let param = {
                id: evt.currentTarget.parentNode.parentElement.dataset.id, 
                date_ajout: document.querySelector("[name='date_ajout']").value,
                garde_jusqua: document.querySelector("[name='garde_jusqua']").value
            }
            
            //vérifie si les champ sont bien remlpi
            let verif = {
                date : verifChamp(param.date_ajout,"date"),
                garde : verifChamp(param.garde_jusqua,"date")
            }

            Object.keys(verif).forEach(function(msg){
                if(verif[msg] != ""){
                    erreur = true;
                }
            });
            
            if(!erreur){
                tr.nextElementSibling.children[0].innerHTML = "";
                
                let date_ajout = new Date(param.date_ajout);
                let garde_jusqua = new Date(param.garde_jusqua);

                if(date_ajout < garde_jusqua){
                    let requete = new Request("index.php?requete=modifierContenuCellier", {method: 'POST', body: JSON.stringify(param)});
                    fetch(requete)
                    .then(response => {
                        if(response.status === 200) {
                            return response.json();
                        } else {
                            throw new Error('Erreur');
                        }
                    })
                    .then(data => {
                        if(data.succes){
                            tr.classList.remove("active");
                            tr.children[0].innerHTML = data.donnee.date_ajout;
                            tr.children[0].setAttribute("data-date", data.donnee.date_ajout);
                            tr.children[1].innerHTML = data.donnee.garde_jusqua;
                            tr.children[1].setAttribute("data-date", data.donnee.garde_jusqua);
                            tr.children[2].innerHTML = "<button class='modifDate'><i class='fas fa-pen'></i></button>";
                            actionModifierDate(tr.children[2].firstChild);
                        
                        }
                        else{
                            tr.nextElementSibling.children[0].innerHTML = "erreur de traitement";
                        }

                    })
                    .catch(error => {
                        console.error(error);
                    });
                }
                else{
                    tr.nextElementSibling.children[0].innerHTML = "Garder jusqu'à doit être plus grand";
                }
            }
            else{
                tr.nextElementSibling.children[0].innerHTML = "date invalide";
            }
        });
    }
    
    function annuleModifierDate(element){
        element.addEventListener("click", function(evt){
            let tr = evt.currentTarget.parentNode.parentNode;
            
            let date_ajout = tr.children[0].dataset.date;
            let garde_jusqua = tr.children[1].dataset.date;

            tr.classList.remove("active");
            tr.children[0].innerHTML = date_ajout;
            tr.children[1].innerHTML = garde_jusqua;
            tr.children[2].innerHTML = "<button class='modifDate'><i class='fas fa-pen'></i></button>";
            actionModifierDate(tr.children[2].firstChild);
            
            tr.nextElementSibling.children[0].innerHTML = "";
        });
    }

    
    //button Boire
    document.querySelectorAll(".btnBoire").forEach(function(element){
        actionBtnBoire(element);
    });
    
    /**
     * applique le traitement de l'action de boire une bouteille sur un bouton boire
     *
     * @param DOM Element element bouton boire
     */
    function actionBtnBoire(element){
        element.addEventListener("click", function(evt){
            //div principal de la bouteille
            let divBouteille = evt.currentTarget.closest(".divBouteille");
            //id du row dans cellier_contenu
            let id = evt.currentTarget.closest("tr").dataset.id;
            //nombre de ranger dans la liste de bouteille
            let nbRange = evt.currentTarget.closest("tbody").childElementCount;
            
            let requete = new Request("index.php?requete=boireBouteille", {method: 'POST', body: '{"id": '+id+'}'});
            fetch(requete)
            .then(response => {
                if(response.status === 200) {
                  return response.json();
                } else {
                  throw new Error('Erreur');
                }
              })
              .then(data => {
                    if(data == true){
                        //si c'est le dernier élément de la liste on supprime la bouteille
                        if(nbRange <= 2){
                            divBouteille.parentNode.removeChild(divBouteille);
                        }
                        //sinon on supprime la ligne et on modifie la quantité restante
                        else{
                            let bouteille = document.querySelector("[data-id='" + id + "']");
                            bouteille.parentNode.removeChild(bouteille);
                            
                            let btnBouteille = divBouteille.querySelector(".btnBouteille");
                            quantite = btnBouteille.textContent.match(/\d+/);
                            btnBouteille.innerHTML = "Bouteilles(" + (parseInt(quantite[0]) - 1) + ")";
                        }
                    }
              }).catch(error => {
                console.error(error);
              });
        });
    }

    //bouton ajouter, ajoute un bouteille dans le cellier
    document.querySelectorAll(".btnAjouter").forEach(function(element){
        element.addEventListener("click", function(evt){
            //id de la bouteille et du cellier
            let id_bouteille = evt.currentTarget.parentElement.dataset.bouteille;
            let id_cellier = document.querySelector(".cellier").dataset.cellier;   
            
            let param = {
                id_bouteille : id_bouteille,
                id_cellier : id_cellier
            };
            
            let requete = new Request("index.php?requete=ajouterBouteille", {method: 'POST', body: JSON.stringify(param)});
            fetch(requete)
            .then(response => {
                if (response.status === 200) {
                  return response.json();
                } else {
                  throw new Error('Erreur');
                }
            })
            .then(data => {
                //créer un nouvelle bouteille dans la liste de bouteille
                let table = document.getElementById("bouteille" + id_bouteille).getElementsByTagName("tbody")[0];
                let row = document.createElement("tr");
                table.appendChild(row);
                table.lastChild.setAttribute("data-id", data['ajout'].id);
                table.lastChild.innerHTML = "<td data-date='" + data['ajout'].date_ajout + "'>" + data['ajout'].date_ajout + "</td>"+
                                "<td data-date='" + data['ajout'].garde_jusqua + "'>" + data['ajout'].garde_jusqua + "</td>"+
                                "<td><button><i class='fas fa-pen'></i></button></td>"+
                                "<td><button class='btnBoire'><img class='icone' src='./images/icones/bouteille-moins.svg'></button></td>";
                
                //applique les actions sur les boutons
                actionBtnBoire(table.lastChild.children[3].firstChild);
                actionModifierDate(table.lastChild.children[2].firstChild);
                
                //modifie la quantité des bouteilles 
                let btnBouteille = document.getElementById("bouteille"+id_bouteille).querySelector(".btnBouteille");
                quantite = btnBouteille.textContent.match(/\d+/);
                btnBouteille.innerHTML = "Bouteilles(" + (parseInt(quantite[0]) + 1) + ")";
            }).catch(error => {
                console.error(error);
            });
              
        })

    });
    
    //affiche la liste des bouteilles
    document.querySelectorAll(".btnBouteille").forEach(function(element){
        element.addEventListener("click", function(evt){
            let id_bouteille = evt.target.parentElement.dataset.bouteille;  
            document.getElementById("bouteille" + id_bouteille).children[1].classList.toggle("hideBouteille");
        })

    });
   
    //bouton modifier bouteille dans un cellier
    document.querySelectorAll(".btnModifier").forEach(function(element){
        element.addEventListener("click", function(evt){
            let id_bouteille = evt.target.parentElement.dataset.bouteille;
            let id_cellier = document.querySelector(".cellier").dataset.cellier;
            window.location.href = BaseURL + "index.php?requete=modifierBouteilleCellier&id_bouteille=" + id_bouteille + "&id_cellier=" + id_cellier; 
    
        })

    });
    
    //bouton retour au contenu d'un cellier
    var retourCellier = document.querySelector("[name='retourCellier']");
    if(retourCellier){
        let id_cellier = document.querySelector("[name='id_cellier']").value;
        retourCellier.addEventListener("click", function(evt){
            window.location.href = BaseURL + "index.php?requete=afficheContenuCellier&id_cellier=" +   id_cellier; 
        });
    }
    
    //vérifie les champs et sauvegrade les modifications effectués sur une bouteille dans un cellier
    var modifier = document.querySelector("[name='modifier']");
    if(modifier){
        modifier.addEventListener("click", function(evt){
            let erreur = false;
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
                codesaq : verifChamp(bouteille.code_saq,"num",8),
                urlsaq : verifChamp(bouteille.url_saq,"text")
            };
            
            Object.keys(verif).forEach(function(msg){
                if(verif[msg] != ""){
                    erreur = true;
                }
                document.querySelector(".erreur"+msg).innerHTML = verif[msg];
            });
            
                                       
            if(!erreur){
                //envoie de la requete avec les informations du formulaire et les erreurs de champs
                let requete = new Request(BaseURL+"index.php?requete=modifierBouteilleCellier", {method: 'POST', body: JSON.stringify(bouteille)});
            
                fetch(requete)
                .then(response => response.json())
                .then(data =>{
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
                        else{
                            document.querySelector(".msg").classList.add("attention");
                            document.querySelector(".msg").innerHTML = "<i class='fas fa-exclamation-triangle'></i> Erreur lors de la modification";
                        }
                        
                        
                    }
                }).catch(error => {
                    console.error(error);
                });
            }
            else{
                document.querySelector(".msg").classList.add("attention");
                document.querySelector(".msg").innerHTML = "<i class='fas fa-exclamation-triangle'></i> Corriger les erreurs et réessayer";
            }
            
            
        
        });
    }
    
    //buttonn Trier par le selct box value
     let btnTrier = document.getElementById('trier');
    if(btnTrier){
        btnTrier.addEventListener("change", function(evt){
            var trier=document.getElementById('trier').value;
            var id_cellier = document.querySelector(".cellier").getAttribute("data-cellier");
            console.log(id_cellier);
            window.location.href = "index.php?requete=afficheContenuCellier&id_cellier=" + id_cellier + "&trierCellier=" + trier;
        });
    } 
    
    //bouton dirige vers le formulaire d'ajout d'un bouteille
    var btnNouvelleBouteille = document.querySelector("[name='nouvelleBouteille']");
    if(btnNouvelleBouteille){
        btnNouvelleBouteille.addEventListener("click", function(evt){
            var id_cellier = document.querySelector(".cellier").getAttribute("data-cellier");
            window.location.href = BaseURL + "index.php?requete=ajouterNouvelleBouteille&id_cellier=" + id_cellier; 
        });
    }

    
    //autocomplete dans formulaire d'ajout d'un nouvelle bouteille
    let inputNomBouteille = document.querySelector("[name='nom_bouteille']");
    let liste = document.querySelector('.listeAutoComplete');
    if(inputNomBouteille){
      inputNomBouteille.addEventListener("keyup", function(evt){
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
                  response.forEach(function(element){
                    liste.innerHTML += "<li data-id='"+element.id_bouteille +"'>"+element.nom+"</li>";
                  })
                }).catch(error => {
                  console.error(error);
                });
        }
        
        
      });

      //champ du formulaire d'ajout
      let bouteille = {
        nom : document.querySelector(".nom_bouteille"),
        date_ajout : document.querySelector("[name='date_ajout']"),
        garde_jusqua : document.querySelector("[name='garde_jusqua']"),
        id_cellier : document.querySelector("[name='cellier']")
      };

      //sélection d'un nom de bouteille dans le résultat de l'autocomplete
      liste.addEventListener("click", function(evt){
        if(evt.target.tagName == "LI"){
          bouteille.nom.dataset.id = evt.target.dataset.id;
          bouteille.nom.setAttribute("value", evt.target.innerHTML);
          
          liste.innerHTML = "";
          inputNomBouteille.value = "";

        }
      });

      //formulaire d'ajout, bouton ajouter et traitement du formulaire
      let btnAjouter = document.querySelector("[name='ajouterNouvelleBouteille']");
      if(btnAjouter){
            btnAjouter.addEventListener("click", function(evt){
                let erreur = false;
                
                //recupère donné formulaire
                let param = {
                    id_bouteille : bouteille.nom.dataset.id,
                    id_cellier : bouteille.id_cellier.value,
                    date_ajout : bouteille.date_ajout.value,
                    garde_jusqua : bouteille.garde_jusqua.value
                };
                
                //vérifie si les champ sont bien remlpi
                let verif = {
                    nom : verifChamp(bouteille.nom.value,"text"),
                    date : verifChamp(param.date_ajout,"date"),
                    garde : verifChamp(param.garde_jusqua,"date")
                }
                
                Object.keys(verif).forEach(function(msg){
                    if(verif[msg] != ""){
                        erreur = true;
                    }
                    if(msg == "nom" && verif[msg] != ""){
                        verif[msg] = "Utiliser la recherche pour sélectionner un nom";
                    }
                    document.querySelector(".erreur"+msg).innerHTML = verif[msg];
                });
                
                
                if(!erreur){
                    //vérifi si la date garde jusqua est plus grand que la date d'ajout
                    let date_ajout = new Date(param.date_ajout);
                    let garde_jusqua = new Date(param.garde_jusqua);
                    
                    if(date_ajout < garde_jusqua){
                        let requete = new Request("index.php?requete=ajouterNouvelleBouteille", {method: 'POST', body: JSON.stringify(param)});
                        fetch(requete)
                        .then(response => {
                            if (response.status === 200) {
                                return response.json();
                            } else {
                                throw new Error('Erreur');
                            }
                        })
                        .then(data => {
                            //si ajout redirection vers le cellier
                            window.location.href = BaseURL + "index.php?requete=afficheContenuCellier&id_cellier=" + param.id_cellier; 
                        }).catch(error => {
                           console.error(error);
                        });
                    }
                    else{
                        document.querySelector(".erreurgarde").innerHTML = "La date \"Garder jusqu'à\" doit être plus grande que la date d'ajout";
                    } 
                }

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
                        regex = new RegExp(/^\d{4}-\d{2}-\d{2}$/);
                        resultat = regex.test(champ);
                        if(!resultat){
                            resultat = "La date que vous avez entré est invalide";
                        }
                        else{
                            resultat = "";
                        }
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
                    //si le champ est un adresse courriel
                    case 'email' :
                        regex = new RegExp(/[^@]+@[^\.]+\..+/);
                        resultat = regex.test(champ);
                        if(!resultat){
                            resultat = "Entrez un adresse courriel valide";
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
    //Envoie des données du formulaire vers le controleur lors d'un clique 
    //sur le bouton d'inscription
    btnInscription.addEventListener("click", function(evt){
      var param = {
        "prenomInscri": compte.prenom.value,
        "nomInscri": compte.nom.value,
        "courrielInscri": compte.courriel.value,
        "motPasseInscri": compte.motDePasse.value,
      };

      var verif = {
        prenom : verifChamp(param.prenomInscri, "text"),
        nom : verifChamp(param.nomInscri, "text"),
        courriel : verifChamp(param.courrielInscri, "email"),
        motPasse : verifChamp(param.motPasseInscri, "text", 6)
      }

      document.querySelector(".erreurPrenomUsager").innerHTML = verif.prenom;
      document.querySelector(".erreurNomUsager").innerHTML = verif.nom;
      document.querySelector(".erreurCourrielUsager").innerHTML = verif.courriel;
      document.querySelector(".erreurMotPasse").innerHTML = verif.motPasse;

      if(verif.prenom == "" && verif.nom == "" && verif.courriel == "" && verif.motPasse == ""){
        //Envoie au controleur
        let requete = new Request("index.php?requete=creerCompteUsager", {method: 'POST', body: JSON.stringify(param)});

        fetch(requete)
          .then(response => {
            //Si la requete à fonctionné
            if (response.status === 200) {
              //Traitement de la réponse du controleur
              return response.json();
            } else {
              //Sinon, affiche une erreur
              throw new Error('Erreur');
            }
          })
          .then(data => {
            console.log(data);
            //Si la réponse émise par le controleur est égale à true
            if(data == true){
              //Redirection vers la page monCompte
              window.location.href ="index.php?requete=compte";
            }
            else if(data == "vide"){
              //Affichage d'un message d'erreur lorsque la 
              //connexion à échoué.
              document.querySelector("[name='msgErreur']").classList.add('errorBox');
              var messageErreur = "<p><i class='fas fa-exclamation-triangle'></i>Modification impossible. Veuillez vous assurez que tout les champs sont bien remplis.</p>";
              document.querySelector("[name='msgErreur']").innerHTML = messageErreur;
            }
            else{
              //Affichage d'un message d'erreur lorsque la 
              //connexion à échoué.
              document.querySelector("[name='msgErreur']").classList.add('errorBox');
              var messageErreur = "<p><i class='fas fa-exclamation-triangle'></i> Les informations entrées sont incorrectes.</p>";
              document.querySelector("[name='msgErreur']").innerHTML = messageErreur;
            }
          }).catch(error => {
            console.error(error);
          });
      }
      
    });
  }


  //Connexion - Gestion du formulaire de connexion
  let infoConnection = {
    courriel : document.querySelector("[name='courrielCo']"),
    motDePasse : document.querySelector("[name='motPasseCo']"),
  };

  let btnConnection = document.querySelector("[name='seConnecter']");
  if(btnConnection){
    //Envoie des données du formulaire vers le controleur lors d'un clique 
    //sur le bouton de connexion
    btnConnection.addEventListener("click", function(evt){
      var param = {
        "courrielCo": infoConnection.courriel.value,
        "motPasseCo": infoConnection.motDePasse.value,
      }
      //Envoie au controleur
      let requete = new Request("index.php?requete=login", {method: 'POST', body: JSON.stringify(param)});

      fetch(requete)
        .then(response =>{
          //Si la requete à fonctionné
          if (response.status === 200) {
            //Traitement de la réponse du controleur
            return response.json();
          }
          else{
            //Sinon, affiche une erreur
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
            var messageErreur = "<p><i class='fas fa-exclamation-triangle'></i> Les informations entrées sont incorrectes.</p>";
            document.querySelector("[name='msgErreur']").innerHTML = messageErreur;
          }
          
        }).catch(error => {
          console.error(error);
        });
    });
  }

  //btnModif - redirection vers le formulaire de modification du compte
  let btnModif = document.querySelector("[name='modifierCompte']");
  if(btnModif){
    btnModif.addEventListener("click", function(evt){
      window.location.href = "index.php?requete=modificationCompte";
    });
  }

  //btnSauvCompte - Envoie les informations entrées dans le formulaire
  //au controleur afin de permettre leur sauvegarde dans la bd
  let btnSauvCompte = document.querySelector("[name='sauvegardeModifCompte']");
  if(btnSauvCompte){
    //Envoie des données du formulaire vers le controleur lors d'un clique 
    //sur le bouton de sauvegarde des modifications
    btnSauvCompte.addEventListener("click", function(evt){
      var param = {
        prenomInscri : document.querySelector("[name='prenomInscri']").value,
        nomInscri : document.querySelector("[name='nomInscri']").value,
        courrielInscri : document.querySelector("[name='courrielInscri']").value,
        //id : document.querySelector("[name='idCompte']").value
      }

      var verif = {
        prenom : verifChamp(param.prenomInscri, "text"),
        nom : verifChamp(param.nomInscri, "text"),
        courriel : verifChamp(param.courrielInscri, "email")
      }

      document.querySelector(".erreurPrenomUsager").innerHTML = verif.prenom;
      document.querySelector(".erreurNomUsager").innerHTML = verif.nom;
      document.querySelector(".erreurCourrielUsager").innerHTML = verif.courriel;

      if(verif.prenom == "" && verif.nom == "" && verif.courriel == ""){
        let requete = new Request("index.php?requete=modificationCompte", {method: 'POST', body: JSON.stringify(param)});

        fetch(requete)
          .then(response =>{
            //Si la requete à fonctionné
            if (response.status === 200) {
              //Traitement de la réponse du controleur
              return response.json();
            }
            else{
              //Sinon, affiche une erreur
              throw new Error('Erreur');
            }
          })
          .then(data => {
            //Redirection vers la page monCompte lorsque la
            //modification à réussie.
            console.log(data);
            if(data == "fonctionnel"){
              window.location.href ="index.php?requete=compte&modif=true";
            }
            else if(data == "mail"){
                //Affichage d'un message d'erreur lorsque la 
                //modification à échoué.
                document.querySelector("[name='msgErreur']").classList.add('errorBox');
                var messageErreur = "<p><i class='fas fa-exclamation-triangle'></i> Le courriel entré est déjà utilisé par un autre utilisateur.</p>";
                document.querySelector("[name='msgErreur']").innerHTML = messageErreur;
            }
            else if(data == "sansModif"){
              //Affichage d'un message d'erreur lorsque la 
              //modification à échoué.
              document.querySelector("[name='msgErreur']").classList.add('errorBox');
              var messageErreur = "<p><i class='fas fa-exclamation-triangle'></i> Aucune modification n'as été éffectué.</p>";
              document.querySelector("[name='msgErreur']").innerHTML = messageErreur;
            }
            else{
                //Affichage d'un message d'erreur lorsque la 
                //modification à échoué.
                document.querySelector("[name='msgErreur']").classList.add('errorBox');
                var messageErreur = "<p><i class='fas fa-exclamation-triangle'></i> Modification impossible. Veuillez vous assurez que tout les champs sont bien remplis.</p>";
                document.querySelector("[name='msgErreur']").innerHTML = messageErreur;
            }  
          }).catch(error => {
            console.error(error);
          });
      }
      
    });
  }

});

