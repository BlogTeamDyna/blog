

let a = 2
let b = 8

let c = a + b

console.log(c)

// Récuperation de l'id de la selection du nombre d'articles par page
// Au changement de la valeur refresh le block des articles

document.getElementById("pagination_tri").onchange = function()  {myOnChange()};

let url = new URL('http://blog.fr.lan/');
let params = new URLSearchParams(url.search);

function myOnChange()  {
    let x  = document.getElementById("pagination_tri");
    let value = x.value;
    console.log(value)
    params.set("numPerPage", value)
    params.toString();
    window.location.href = url + "?" + params;
    console.log(url);
}

// document.querySelectorAll("home_tags").onchange = function() {onTagSubmit()};

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
    console.log(url);
}