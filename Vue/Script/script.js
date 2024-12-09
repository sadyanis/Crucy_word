let cases =  document.getElementsByClassName("grille_item"); //la grille 

for (let elt of cases){
    elt.addEventListener("dblclick",()=>{
        elt.textContent="";
        elt.blur();
        elt.classList.toggle("black");
       console.log(elt) ;
    });
}

document.querySelectorAll(".case").forEach((div)=>{
div.addEventListener("click",()=>{
    if(!div.classList.contains("black")){
    div.setAttribute("contenteditable", "true");
    div.focus();
    }

});
div.addEventListener("blur",()=>{
    div.removeAttribute("contenteditable");
    div.style.border = "1px solid #ccc;";
});
div.addEventListener("input", () => {
    if(!div.classList.contains("black")){
        const content = div.textContent.toUpperCase().replace(/[^A-Z]/g, ""); // Filtrer uniquement les lettres
        div.textContent = content.slice(0, 1); // Limiter à 1 caractère
        }
  
  });
  
  div.addEventListener("keydown",(e)=>{
    if(e.key === "Enter"){
        e.preventDefault();
        div.blur();
    }
}) ;
});


document.getElementById("sauvegarder").addEventListener("click",()=>{
    let grille =[]
    document.querySelectorAll(".grille_item").forEach(item=>{
        const x = item.dataset.x;
        const y = item.dataset.y;
        const contenu = item.textContent.trim();
        grille.push({ x, y, contenu: contenu || null });

    });

    fetch('../controllers/save_grid.php',{
        method: 'POST',
        headers: { 'Content-Type': 'application/json'},
        body: JSON.stringify({grille_id: 1, cases: grille})
    })
    .then(response => response.json()).then(data => {
        if(data.success){
            alert('Grille sauvegardé avec succes !');
        }else{
            alert('ERREUR: '+data.message);
        }
    })
    .catch(error =>{
        console.error('Erreur lors de sending :', error);
    });
    
});

//ajout d'indices 

document.getElementById("add_hor").addEventListener("click",() =>{
    const input = document.getElementById("hor_indice");
    const ol = document.getElementById("horizontal_indice");

    // recuperer la valeur de l'input

    const inputvalue = input.value.trim();
    if(inputvalue){
        const newli = document.createElement("li");
        const btn = document.createElement("button");

        newli.textContent = inputvalue;
        //newli.setAttribute("contenteditable","true");
        btn.textContent = "delete";
        btn.classList.add("del_btn");

        btn.addEventListener("click",()=>{
            newli.remove();

        });


        newli.appendChild(btn);
        ol.appendChild(newli);

        input.value ="";
    }else{
        alert("Veuillez entrer un indice avant d'ajouter");
    }

});

//Ajout d'indices Vertical

document.getElementById("add_vert").addEventListener("click",() =>{
    const input = document.getElementById("ver_indice");
    const ol = document.getElementById("vertical_indice");

    const inputValue = input.value.trim();
    if(inputValue){
        const newli = document.createElement("li");
        const btn = document.createElement("button");

        btn.addEventListener("click",()=>{
            newli.remove();

        });

        newli.textContent = inputValue;
        //newli.setAttribute("contenteditable","true");
        btn.textContent = "delete";
        btn.classList.add("del_btn");
        newli.appendChild(btn);
        ol.appendChild(newli);
        input.value = "";
    }else{
        alert("Veuillez entrer un indice avant d'ajouter");
    }
})

//effacer la liste horizontal

document.getElementById("delete_hor").addEventListener("click",() =>{
    const ol = document.getElementById("horizontal_indice");
    ol.textContent ="";
})

//effacer la liste vertical
document.getElementById("delete_ver").addEventListener("click",() =>{
    const ol = document.getElementById("vertical_indice");
    ol.textContent = "";
});


// document.getElementById("add_hor").addEventListener("click", () => {
//     const input = document.getElementById("hor_indice");
//     const ol = document.getElementById("horizontal_indice");
//     const inputValue = input.value.trim();

//     if (inputValue) {
//         const li = document.createElement("li");

//         // Ajouter le texte de l'indice dans un <span>
//         const textSpan = document.createElement("span");
//         textSpan.textContent = inputValue;
//         li.appendChild(textSpan);

//         // Créer un bouton de suppression
//         const deleteButton = document.createElement("button");
//         deleteButton.textContent = "Supprimer";
//         deleteButton.style.marginLeft = "10px"; // Espacement entre le texte et le bouton
//         deleteButton.addEventListener("click", () => {
//             li.remove(); // Supprimer l'élément <li>
//             updateIndexes(); // Mettre à jour les index après suppression
//         });

//         // Ajouter le bouton de suppression à l'élément <li>
//         li.appendChild(deleteButton);

//         // Ajouter l'élément <li> à la liste
//         ol.appendChild(li);

//         // Réinitialiser le champ de texte
//         input.value = "";

//         // Mettre à jour les index après l'ajout
//         updateIndexes();
//     } else {
//         alert("Veuillez entrer un indice avant d'ajouter.");
//     }
// });

// // Effacer toute la liste
// document.getElementById("delete_hor").addEventListener("click", () => {
//     const ol = document.getElementById("horizontal_indice");
//     ol.innerHTML = ""; // Effacer tous les éléments
// });

// // Fonction pour mettre à jour les index
// function updateIndexes() {
//     const ol = document.getElementById("horizontal_indice");
//     const listItems = ol.querySelectorAll("li");

//     listItems.forEach((li, index) => {
//         // Trouver uniquement le texte de l'indice (contenu dans <span>)
//         const textSpan = li.querySelector("span");
//         if (textSpan) {
//             // Appliquer le numéro à partir de zéro
//             textSpan.textContent = `${index + 1}. ${textSpan.textContent.replace(/^\d+\.\s*/, '')}`;
//         }
//     });
// }



