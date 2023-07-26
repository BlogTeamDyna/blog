// Récuperation de l'id de la selection du nombre d'articles par page
// Au changement de la valeur refresh le block des articles


// envoyer l'url courante avec tout les parametres
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
