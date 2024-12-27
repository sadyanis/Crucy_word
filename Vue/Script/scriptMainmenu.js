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

function addGridClickListeners() {
    document.querySelectorAll('#vertical_indice li').forEach((li) => {
        li.addEventListener('click', () => {
            const gridID = li.getAttribute('data-grid-id');
            console.log(gridID);
            // Envoyer une requête au serveur
            fetch('../controllers/get_grid_data.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: gridID })
            })
            .then(response => response.json())
            .then((data) => {
                console.log(data);
                if (data.success) {
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
}

document.addEventListener('DOMContentLoaded', () => {
    addGridClickListeners();
});


document.addEventListener('DOMContentLoaded', () => {
    
    const checkbox = document.getElementById('filter-my-grids');
    const gridList = document.getElementById('vertical_indice');
    fetchGrids()
    checkbox.addEventListener('change', () => {
        const showMyGrids = checkbox.checked;
        fetchGrids(showMyGrids);
    });
});

// Fonction pour récupérer les grilles
function fetchGrids(filterMyGrids = false) {
    const url = filterMyGrids ? '../controllers/get_user_grids.php' : '../controllers/get_all_grids.php';
    
    fetch(url)
        .then(response => response.json())
        .then(data => {
            updateGridList(data);
        })
        .catch(error => console.error('Erreur lors de la récupération des grilles:', error));
}

// Mettre à jour la liste des grilles
// Met à jour la liste des grilles dans le DOM
function updateGridList(grids) {
    const gridList = document.getElementById('vertical_indice');
    gridList.innerHTML = ''; // Vider la liste existante

    if (grids.length > 0) {
        grids.forEach(grid => {
            const listItem = createGridListItem(grid);
            gridList.appendChild(listItem);
        });
        addGridClickListeners();
    } else {
        gridList.innerHTML = '<li>Aucune grille trouvée.</li>';
    }
}

// Crée un élément <li> pour une grille
function createGridListItem(grid) {
    const listItem = document.createElement('li');
    listItem.setAttribute('data-grid-id', grid.gridID);
    listItem.textContent = grid.gridName;

    // Si l'utilisateur est le propriétaire, ajouter un bouton "Modify"
    if (grid.isOwner) {
        const modifyButton = createModifyButton(grid.gridID);
        listItem.appendChild(modifyButton);
    }

    return listItem;
}

// Crée un bouton "Modify"
function createModifyButton(gridID) {
    const btn = document.createElement('button');
    btn.textContent = 'modify';
    btn.addEventListener('click', (event) => {
        event.stopPropagation(); // Empêche le déclenchement d'autres événements sur le <li>
        console.log('Modifier la grille', gridID);
    });
    return btn;
}
