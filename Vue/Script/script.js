// Function to add double-click event to each case
function addDoubleClickEventToCases(cases) {
    for (let elt of cases) {
        elt.addEventListener("dblclick", () => {
            try {
                elt.textContent = ""; // Clear the content
                elt.blur(); // Remove focus
                elt.classList.toggle("black"); // Toggle the 'black' class
            } catch (error) {
                console.error('Error in double-click event:', error);
            }
        });
    }
}

// Function to add click, blur, input, and keydown events to each div
function addClickEventToDivs(divs) {
    divs.forEach((div) => {
        div.addEventListener("click", () => {
            try {
                if (!div.classList.contains("black")) {
                    div.setAttribute("contenteditable", "true"); // Make div editable
                    div.focus(); // Focus on the div
                }
            } catch (error) {
                console.error('Error in click event:', error);
            }
        });

        div.addEventListener("blur", () => {
            try {
                div.removeAttribute("contenteditable"); // Remove editable attribute
                div.style.border = "1px solid #ccc;"; // Reset border style
            } catch (error) {
                console.error('Error in blur event:', error);
            }
        });

        div.addEventListener("input", () => {
            try {
                if (!div.classList.contains("black")) {
                    const content = div.textContent.toUpperCase().replace(/[^A-Z]/g, ""); // Filter only letters
                    div.textContent = content.slice(0, 1); // Limit to 1 character
                }
            } catch (error) {
                console.error('Error in input event:', error);
            }
        });

        div.addEventListener("keydown", (e) => {
            try {
                if (e.key === "Enter") {
                    e.preventDefault(); // Prevent default Enter behavior
                    div.blur(); // Remove focus
                }
            } catch (error) {
                console.error('Error in keydown event:', error);
            }
        });
    });
}

// Function to save the grid data
function saveGrid() {
    try {
        const grid = document.getElementsByClassName('indices')[0];
        const gridDimension = parseInt(grid.getAttribute('data-dimension'));
        const gridName = grid.getAttribute('data-name');
        const gridLevel = grid.getAttribute('data-level');
        const hintsV = document.getElementById("vertical_indice").children.length;
        const hintsH = document.getElementById("horizontal_indice").children.length;
        const horizontalHints = [];
        const verticalHints = [];

        if (gridDimension - 1 != hintsV || gridDimension - 1 != hintsH) {
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

        document.querySelectorAll("#horizontal_indice li").forEach((li, index) => {
            const text = li.firstChild.nodeValue.trim(); // Get only the main text
            horizontalHints.push({ id: index + 1, contenu: text });
        });

        document.querySelectorAll("#vertical_indice li").forEach((li, index) => {
            const text = li.firstChild.nodeValue.trim();
            verticalHints.push({ id: index + 1, contenu: text });
        });

        fetch('../controllers/save_grid.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                gridName: gridName,
                gridDimension: gridDimension,
                gridLevel: gridLevel,
                cases: grille,
                horizontalHints: horizontalHints,
                verticalHints: verticalHints,
            })
        })
            .then(response => response.text())
            .then(text => {
                try {
                    console.log(text);
                    const data = JSON.parse(text);
                    alert(data.success ? 'Grille sauvegardée avec succès !' : 'ERREUR: ' + data.message);
                    window.location.href = '../Vue/mainmenu.php';
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

// Function to add a hint to the list
function addHint(inputId, listId) {
    try {
        const input = document.getElementById(inputId);
        const ol = document.getElementById(listId);

        const inputValue = input.value.trim();
        if (inputValue) {
            const newli = document.createElement("li");
            const btn = document.createElement("button");

            btn.addEventListener("click", () => {
                try {
                    newli.remove(); // Remove the list item
                } catch (error) {
                    console.error('Error in delete button click event:', error);
                }
            });

            newli.textContent = inputValue;
            btn.textContent = "delete";
            btn.classList.add("del_btn");
            newli.appendChild(btn);
            ol.appendChild(newli);
            input.value = ""; // Clear the input field
        } else {
            alert("Veuillez entrer un indice avant d'ajouter");
        }
    } catch (error) {
        console.error('Error in addHint function:', error);
    }
}

// Function to clear the list
function clearList(listId) {
    try {
        const ol = document.getElementById(listId);
        ol.textContent = ""; // Clear the list content
    } catch (error) {
        console.error('Error in clearList function:', error);
    }
}

// Function to initialize the grid
function initializeGrid() {
    try {
        const grid = document.getElementsByClassName('indices')[0];
        const gridDimension = grid.getAttribute('data-dimension');
        grid.style.gridTemplateColumns = `repeat(${gridDimension}, 30px)`; // Set grid columns
        grid.style.gridTemplateRows = `repeat(${gridDimension}, 30px)`; // Set grid rows
    } catch (error) {
        console.error('Error in initializeGrid function:', error);
    }
}

// Event listener for DOM content loaded
document.addEventListener('DOMContentLoaded', () => {
    try {
        const cases = document.getElementsByClassName("grille_item");
        const divs = document.querySelectorAll(".case");

        addDoubleClickEventToCases(cases);
        addClickEventToDivs(divs);

        document.getElementById("sauvegarder").addEventListener("click", saveGrid);
        document.getElementById("add_hor").addEventListener("click", () => addHint("hor_indice", "horizontal_indice"));
        document.getElementById("add_vert").addEventListener("click", () => addHint("ver_indice", "vertical_indice"));
        document.getElementById("delete_hor").addEventListener("click", () => clearList("horizontal_indice"));
        document.getElementById("delete_ver").addEventListener("click", () => clearList("vertical_indice"));

        initializeGrid();
    } catch (error) {
        console.error('Error in DOMContentLoaded event:', error);
    }
});






// Fetch the correct grid data
async function fetchCorrectGrid() {
    try {
        const response = await fetch('../controllers/get_correct_grid.php');
        const data = await response.json();
        correctGrid = data['data'];
    } catch (error) {
        console.error('Erreur lors de l\'envoi :', error);
    }
}


