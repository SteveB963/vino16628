/**
 * @file Script contenant les fonctions relatives au style
 * @author Alyson Métivier
 * @version 0.1
 * @update 2019-03-12
 * @license Creative Commons BY-NC 3.0 (Licence Creative Commons Attribution - Pas *  d’utilisation commerciale 3.0 non transposé)
 * @license http://creativecommons.org/licenses/by-nc/3.0/deed.fr
 *
 */
window.addEventListener("load", function(){
    window.onscroll = function(){ addClass()};

    var menu = document.getElementById("mainNav");

    var sticky = menu.offsetTop;

    function addClass(){
        if(window.pageYOffset > sticky){
          menu.classList.add("sticky");
        }
        else{
          menu.classList.remove("sticky");
        }
    }
    
    //Permet d'afficher ou cacher le label d'un input selon si il est vide ou rempli
    let input = document.querySelector(".formulaire");
    if(input){
        input.querySelectorAll("[type='text']").forEach(function(element){
            element.addEventListener('focusout', function(){
                if(element.value != ""){
                    let label = document.querySelector("[for=" + element.getAttribute("name") + "]");
                    label.classList.remove('hide');
                }
                else{
                    let label = document.querySelector("[for=" + element.getAttribute("name") + "]");
                    label.classList.add('hide');
                }
            });
        });
    }

});