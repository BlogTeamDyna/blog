

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
    params.set("numPerPage", value)
    params.toString();
    window.location.href = url + "?" + params;
    console.log(url);
}

document.getElementById("tagFiltring").onchange = function() {onTagSubmit()};
function onTagSubmit() {
    let x = document.getElementById("home_save");
    let value = x.values;
    console.log(value);
    // params.set("selectedTag", value)
    // params.toString();
    // window.location.href = url + "?" + params;
    // console.log(url);
}