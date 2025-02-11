document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('modal');
    const closeModal = document.getElementById('close_modal');
    const aside = document.getElementById("side_index");
});

function addGridClickListeners() {
    try {
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
    } catch (error) {
        console.error('Error adding grid click listeners:', error);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    try {
        addGridClickListeners();
    } catch (error) {
        console.error('Error initializing grid click listeners:', error);
    }
});

document.addEventListener('DOMContentLoaded', () => {
    try {
        const checkbox = document.getElementById('filter-my-grids');
        const gridList = document.getElementById('vertical_indice');
        
        checkbox.addEventListener('change', () => {
            const showordered = checkbox.checked;
            fetchGrids(showordered);
        });
    } catch (error) {
        console.error('Error initializing filter checkbox:', error);
    }
});

// Fonction pour récupérer les grilles
function fetchGrids(filterMyGrids = false) {
    fetch('../controllers/get_all_grids.php',{
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ filter: filterMyGrids })
    })
        .then(response => response.text())
        .then(data => {
            data = JSON.parse(data);
            try {
                updateGridList(data);
            } catch (error) {
                console.error('Error updating grid list:', error);
            }
        })
        .catch(error => console.error('Erreur lors de la récupération des grilles:', error));
}

// Mettre à jour la liste des grilles
// Met à jour la liste des grilles dans le DOM
function updateGridList(grids) {
    try {
        const gridList = document.getElementById('vertical_indice');
        gridList.innerHTML = ''; // Vider la liste existante
        

        if (grids.length > 0) {
            grids.forEach(grid => {
                const listItem = createGridListItem(grid);
                const dificulty = document.createElement('span');
                dificulty.textContent = grid.level;
                dificulty.classList.add('level');
                listItem.appendChild(dificulty);
                gridList.appendChild(listItem);
            });
            addGridClickListeners();
        } else {
            gridList.innerHTML = '<li>Aucune grille trouvée.</li>';
        }
    } catch (error) {
        console.error('Error updating grid list:', error);
    }
}

// Crée un élément <li> pour une grille
function createGridListItem(grid) {
    try {
        const listItem = document.createElement('li');
        listItem.setAttribute('data-grid-id', grid.gridID);
        listItem.textContent = grid.gridName;

        // Si l'utilisateur est le propriétaire, ajouter un bouton "Modify"
        if (grid.isOwner) {
            const modifyButton = createModifyButton(grid.gridID);
            listItem.appendChild(modifyButton);
        }

        return listItem;
    } catch (error) {
        console.error('Error creating grid list item:', error);
    }
}

// Crée un bouton "Modify"
function createModifyButton(gridID) {
    try {
        const btn = document.createElement('button');
        btn.textContent = 'delete';
        btn.addEventListener('click', (event) => {
            event.stopPropagation(); // Empêche le déclenchement d'autres événements sur le <li>
            const confirmation = confirm('Voulez-vous vraiment supprimer cette grille ?');
            if (!confirmation) return;
            // Envoyer une requête au serveur pour supprimer la grille
            fetch('../controllers/delete_grid.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: gridID })
            }).then(response => response.json())
                .then(data => {
                    if (data.success) {
                        btn.parentElement.remove(); // Supprimer l'élément <li> parent
                        console.log('Grille supprimée', gridID);
                    } else {
                        alert('Erreur lors de la suppression de la grille');
                    }
                })
                .catch(error => {
                    console.error('Erreur lors de l\'envoi :', error);
                });
          
        });
        return btn;
    } catch (error) {
        console.error('Error creating modify button:', error);
    }
}
