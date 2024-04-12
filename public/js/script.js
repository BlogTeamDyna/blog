
document.getElementById("pagination_tri").onchange = function()  {myOnChange()};

let currentUrl = new URL(window.location.href);
let params = new URLSearchParams(currentUrl.search);
let url = window.location.origin

function myOnChange()  {
    let x  = document.getElementById("pagination_tri");
    let value = x.value;
    params.set("numPerPage", value)
    params.toString();
    window.location.href = url + "?" + params;
}

 document.querySelectorAll('input[id^="home_tags_"]').forEach(item => {
     item.addEventListener('change', event => {
         onTagSubmit()
     })
 });

function onTagSubmit() {
    var array = []
    var checkboxes = document.querySelectorAll('input[id^="home_tags_"]:checked')

    for (var i = 0; i < checkboxes.length; i++) {
        array.push(checkboxes[i].value)
    }
    params.set("selectedTags", array.toString())
    params.toString();
    window.location.href = url + "?" + params;
}

// A la soumission du formulaire recuperer la valeur de la recherche (input) - js
// Envoyer les données au home controller (voir exemple ci-dessus) - js
// Recuperer les valeurs depuis la requete - php
// Setter les valeur au model Data SearchData - php
// Filtrer les articles depuis le Repo Article en passant l'objet model SearchData


document.getElementById("search_search").addEventListener("keyup",(e) => {
    if(e.keyCode == 13) {
        e.stopPropagation();
        myOnSearch();
    }
})
let input = document.querySelector('input[id^="search_search"]');

function myOnSearch() {
    let x = document.getElementById("search_search");
    let value = x.value;
    console.log(value)
    params.set("recherche", value)
    window.location.href = url + "?" + params;
}


// setTimeout(()=> {
//     let notif = document.getElementById("notify");
//     console.log(notif);
//     notif.style.display = 'none';
// }, 3000);
