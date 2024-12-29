let correctGrid = [];
// document.addEventListener('DOMContentLoaded', () => {
//     const modal = document.getElementById('modal');
//     const addGridBtn = document.getElementById('add_grid_btn');
//     const closeModal = document.getElementById('close_modal');
//     const aside = document.getElementById("side_index");

//     addGridBtn.addEventListener('click', () => {
//         try {
//             modal.classList.remove('hidden');
//             aside.classList.add('hidden');
//         } catch (error) {
//             console.error('Error handling addGridBtn click:', error);
//         }
//     });

//     closeModal.addEventListener('click', () => {
//         try {
//             modal.classList.add('hidden');
//             aside.classList.remove('hidden');
//         } catch (error) {
//             console.error('Error handling closeModal click:', error);
//         }
//     });
// });

// document.querySelectorAll('#vertical_indice li').forEach((li) => {
//     li.addEventListener('click', async () => {
//         try {
//             const gridID = li.getAttribute('data-grid-id');
//             console.log(gridID);
//             const response = await fetch('../controllers/get_grid_data.php', {
//                 method: 'POST',
//                 headers: {
//                     'Content-Type': 'application/json'
//                 },
//                 body: JSON.stringify({ id: gridID })
//             });
//             const data = await response.text();
//             console.log(data);
//             const parsedData = JSON.parse(data);
//             if (parsedData.success) {
//                 sessionStorage.setItem('gridData', JSON.stringify(parsedData));
//                 window.location.href = '../Vue/play.php';
//             } else {
//                 alert('Erreur lors de la récupération des données de la grille');
//             }
//         } catch (error) {
//             console.error('Erreur lors de l\'envoi :', error);
//         }
//     });
// });
// ça commence ici
document.addEventListener('DOMContentLoaded', () => {
    try {
        const grid = document.getElementsByClassName('indices')[0];
        const gridDimension = grid.getAttribute('data-dimension');
        grid.style.gridTemplateColumns = `repeat(${gridDimension}, 30px)`;
        grid.style.gridTemplateRows = `repeat(${gridDimension}, 30px)`;
    } catch (error) {
        console.error('Error setting grid dimensions:', error);
    }
});

document.addEventListener('DOMContentLoaded', async () => {
    try {
        await fetchCorrectGrid();
        for (let i = 0; i < correctGrid.length; i++) {
            for (let j = 0; j < correctGrid[i].length; j++) {
                if (correctGrid[i][j] === null) {
                    const cell = document.getElementById(`case_${i}_${j}`);
                    cell.classList.add('black');
                }
            }
        }
       await fetchSavedGame();

    } catch (error) {
        console.error('Error initializing correct grid:', error);
    }
});

async function fetchCorrectGrid() {
    try {
        const response = await fetch('../controllers/get_correct_grid.php');
        const data = await response.json();
        console.log(data);
        correctGrid = data['data'];
    } catch (error) {
        console.error('Erreur lors de l\'envoi :', error);
    }
}

async function fetchSavedGame(){
    try {
        const response = await fetch('../controllers/get_saved_game.php');
        const data = await response.json();
        console.log(data);
        if (data && data['data']) {
            // j'appele une fonction qui va afficher la grille
            console.log(data['data'][0]['cell_content']);
            updateGridContent(data['data']);
            //savedGrid = data['game'];
        } else {
            console.log('Aucune partie sauvegardée');
            return null;
        }
    } catch (error) {
        console.error('Erreur lors de l\'envoi :', error);
    }
    
}

document.querySelectorAll(".case").forEach((div) => {
    div.addEventListener("click", () => {
        try {
            if (!div.classList.contains("black")) {
                div.setAttribute("contenteditable", "true");
                div.focus();
            }
        } catch (error) {
            console.error('Error handling case click:', error);
        }
    });

    div.addEventListener("blur", () => {
        try {
            div.removeAttribute("contenteditable");
            div.style.border = "1px solid #ccc;";
        } catch (error) {
            console.error('Error handling case blur:', error);
        }
    });

    div.addEventListener("input", () => {
        try {
            if (!div.classList.contains("black")) {
                const content = div.textContent.toUpperCase().replace(/[^A-Z]/g, ""); // Filtrer uniquement les lettres
                div.textContent = content.slice(0, 1); // Limiter à 1 caractère
            }
        } catch (error) {
            console.error('Error handling case input:', error);
        }
    });

    div.addEventListener("keydown", (e) => {
        try {
            if (e.key === "Enter") {
                e.preventDefault();
                div.blur();
            }
        } catch (error) {
            console.error('Error handling case keydown:', error);
        }
    });
});

document.getElementById("submit").addEventListener("click", () => {
    try {
        const playerGrid = collectPlayerGrid();
        const result = verifyAnswers(playerGrid);
        if (result) {
            alert('Bravo ! Vous avez résolu la grille');
        } else {
            alert('Certaines réponses sont incorrectes');
        }
    } catch (error) {
        console.error('Error handling submit click:', error);
    }
});

document.getElementById("reset").addEventListener("click", saveGame);
function collectPlayerGrid() {
    try {
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
    } catch (error) {
        console.error('Error collecting player grid:', error);
    }
}

function verifyAnswers(playerGrid) {
    try {
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
    } catch (error) {
        console.error('Error verifying answers:', error);
    }
}

function updateGridContent(gridData) {
    gridData.forEach(cell => {
        const elementId = `case_${cell.cell_row}_${cell.cell_column}`;
        const element = document.getElementById(elementId);

        if (element) {
            element.textContent = cell.cell_content.toUpperCase();
        } else {
            console.warn(`Element with ID "${elementId}" not found.`);
        }
    });
}

function saveGame() {
    try {
        const grid = document.getElementsByClassName('indices')[0];
        console.log("bonjour");
        let grille = [];
        let valid = false;

        document.querySelectorAll(".grille_item").forEach(item => {
            const { x, y } = item.dataset;
            const contenu = item.textContent.trim();
            if (contenu !=="") {
                valid = true;
                grille.push({ x, y, contenu: contenu || null });
            }
            
        });

        if (valid===false) {
            alert('ERREUR: Au moin une case doit être remplie.');
            return;
        }

        fetch('../controllers/save_game.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                cases: grille,
            })
        })
            .then(response => response.text())
            .then(text => {
                try {
                    console.log(text);
                    const data = JSON.parse(text);
                    alert(data.success ? 'Grille sauvegardée avec succès !' : 'ERREUR: ' + data.message);
                } catch (error) {
                    console.error('Error parsing response:', error);
                }
            })
            .catch(error => {
                console.error('Erreur lors de l\'envoi :', error);
            });
    } catch (error) {
        console.error('Error in saveGrid function:', error);
    }
}
