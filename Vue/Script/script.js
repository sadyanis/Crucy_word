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

// sauvegarder
document.getElementById("sauvegarder").addEventListener("click", () => {
    const grid = document.getElementsByClassName('indices')[0];
    const gridDimension = parseInt(grid.getAttribute('data-dimension'));
    const hintsV = document.getElementById("vertical_indice").children.length;
    const hintsH = document.getElementById("horizontal_indice").children.length;

    if (gridDimension !== hintsV || gridDimension !== hintsH) {
        alert("Veuillez entrer tous les indices avant de sauvegarder");
        return;
    }

    let grille = [];
    let valid = true;

    document.querySelectorAll(".grille_item").forEach(item => {
        const { x, y } = item.dataset;
        const contenu = item.textContent.trim();

        if (!contenu && !item.classList.contains("black")) {
            valid = false;
        }

        grille.push({ x, y, contenu: contenu || null });
    });

    if (!valid) {
        alert('ERREUR: Toutes les cases doivent être remplies ou noires.');
        return;
    }

    fetch('../controllers/save_grid.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ grille_id: 8, cases: grille })
    })
    .then(response => response.json())
    .then(data => {
        alert(data.success ? 'Grille sauvegardée avec succès !' : 'ERREUR: ' + data.message);
    })
    .catch(error => {
        console.error('Erreur lors de l\'envoi :', error);
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

document.addEventListener('DOMContentLoaded', () => {
    const grid = document.getElementsByClassName('indices')[0];
    const gridDimension = grid.getAttribute('data-dimension');
    grid.style.gridTemplateColumns = `repeat(${gridDimension}, 30px)`;
    grid.style.gridTemplateRows = `repeat(${gridDimension}, 30px)`;
});






