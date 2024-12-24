let correctGrid = [];
document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('modal');
    const addGridBtn = document.getElementById('add_grid_btn');
    const closeModal = document.getElementById('close_modal');
    const aside = document.getElementById("side_index");

    addGridBtn.addEventListener('click', () => {
        
        modal.classList.remove('hidden');
        aside.classList.add('hidden');
    });

    closeModal.addEventListener('click', () => {
        modal.classList.add('hidden');
        aside.classList.remove('hidden');
    });
});

document.querySelectorAll('#vertical_indice li').forEach((li) => {
    li.addEventListener('click',()=>{
        const gridID = li.getAttribute('data-grid-id');
        console.log(gridID);
        // Envoyer une requête au serveur
        fetch('../controllers/get_grid_data.php',{
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({id: gridID})
        })
        .then(response => response.text())
        .then((data)=>{
            console.log(data);
            data = JSON.parse(data);
            if(data.success){
            sessionStorage.setItem('gridData', JSON.stringify(data));
            window.location.href = '../Vue/play.php';       
        } else {
            alert('Erreur lors de la récupération des données de la grille');
        }

    })
    .catch(error => {
        console.error('Erreur lors de l\'envoi :', error);
    });
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const grid = document.getElementsByClassName('indices')[0];
    const gridDimension = grid.getAttribute('data-dimension');
    grid.style.gridTemplateColumns = `repeat(${gridDimension}, 30px)`;
    grid.style.gridTemplateRows = `repeat(${gridDimension}, 30px)`;
});


document.addEventListener('DOMContentLoaded', async () => {
   await fetchCorrectGrid();
    for(let i = 0; i < correctGrid.length; i++){
        for(let j = 0; j < correctGrid[i].length; j++){
            console.log(correctGrid[i][j]);
           if(correctGrid[i][j] === null){
               const cell = document.getElementById(`case_${i}_${j}`);
               cell.classList.add('black');
           }
        }
        
    }
});

function fetchCorrectGrid(){
    return fetch('../controllers/get_correct_grid.php')
    .then(response => response.json())
    .then(data => {
        correctGrid = data['data'];
    }).catch(error => {
        console.error('Erreur lors de l\'envoi :', error);
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

    document.getElementById("submit").addEventListener("click", () => {
        const playerGrid = collectPlayerGrid();
        const result = verifyAnswers(playerGrid);
        if(result){
            alert('Bravo ! Vous avez résolu la grille');
        } else {
            alert('Certaines réponses sont incorrectes');
        }
    });
    
    function collectPlayerGrid() {
        const gridDimension = correctGrid.length; // Dimension de la grille
        const playerGrid = [];
    
        for (let row = 0; row < gridDimension; row++) {
            const rowArray = [];
            for (let col = 0; col < gridDimension; col++) {
                // Identifier chaque case par son ID
                const cell = document.getElementById(`case_${row}_${col}`);
                rowArray.push(cell.textContent.trim() || ""); // Récupérer la valeur de la case
            }
            playerGrid.push(rowArray);
        }
    
        return playerGrid;
    }

    function verifyAnswers(playerGrid) {
        let isCorrect = true;
    
        for (let row = 0; row < correctGrid.length; row++) {
            for (let col = 0; col < correctGrid[row].length; col++) {
                if (playerGrid[row][col] !== (correctGrid[row][col] == null ? "" : correctGrid[row][col])) {
                    console.log(`Erreur à la case [${row}, ${col}]`);
                    console.log(`Attendu : ${correctGrid[row][col]}, Reçu : ${playerGrid[row][col]}`);
                    isCorrect = false;
                }
            }
        }
    
        if (isCorrect) {
            console.log("Toutes les réponses sont correctes !");
        } else {
            console.log("Certaines réponses sont incorrectes.");
        }
    
        return isCorrect;
    }
    