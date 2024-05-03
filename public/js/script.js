
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
    let array = []
    let checkboxes = document.querySelectorAll('input[id^="home_tags_"]:checked')

    for (let i = 0; i < checkboxes.length; i++) {
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

document.getElementById("search_search").addEventListener("keyup",async (e) => {
    if(e.keyCode == 13) {
        e.stopPropagation();
        await myOnSearch();
    }
})
let input = document.querySelector('input[id^="search_search"]');

async function myOnSearch() {
    let x = document.getElementById("search_search");
    let value = x.value;
    console.log(value)

    await new Promise(resolve => setTimeout(resolve, 100)); // Attente de 100ms (exemple)

    params.set("recherche", value)
    window.location.href = url + "?" + params;
}

// document.getElementById("search_search").addEventListener("input", async (e) => {
//     let searchTerm = e.target.value.trim(); // Récupérer le terme de recherche (supprimer les espaces au début et à la fin)
//
//     if (searchTerm.length > 0) {
//         try {
//             // Effectuer une requête AJAX vers votre endpoint PHP avec le terme de recherche
//             let response = await fetch(`/endpoint.php?search=${encodeURIComponent(searchTerm)}`);
//
//             if (response.ok) {
//                 let data = await response.json();
//                 displaySearchResults(data.results);
//             } else {
//                 console.error("Erreur lors de la récupération des résultats de recherche.");
//                 clearSearchResults();
//             }
//         } catch (error) {
//             console.error("Erreur lors de la récupération des résultats de recherche:", error);
//             clearSearchResults();
//         }
//     } else {
//         // Effacer les résultats si le champ de recherche est vide
//         clearSearchResults();
//     }
// });
//
// function displaySearchResults(results) {
//     let searchResultsDiv = document.getElementById("searchResults");
//     searchResultsDiv.innerHTML = ""; // Effacer les résultats précédents
//
//     if (results.length > 0) {
//         // Construire la liste des résultats à afficher
//         let resultList = document.createElement("ul");
//         results.forEach(result => {
//             let listItem = document.createElement("li");
//             listItem.textContent = result.title; // Afficher le titre de l'article (à adapter selon votre entité Article)
//             resultList.appendChild(listItem);
//         });
//         searchResultsDiv.appendChild(resultList);
//     } else {
//         // Afficher un message si aucun résultat n'est trouvé
//         searchResultsDiv.textContent = "Aucun résultat trouvé.";
//     }
// }
//
// function clearSearchResults() {
//     document.getElementById("searchResults").innerHTML = ""; // Effacer les résultats
// }

