document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('modale');
    const addGridBtn = document.getElementById('add_grid_btnn');
    const closeModal = document.getElementById('close_modale');
    const aside = document.getElementById("sideIndex");
    const aside2 =  document.getElementById("sideIndex2");

    addGridBtn.addEventListener('click', () => {
        try {
            modal.classList.remove('hidden');
            aside.classList.add('hidden');
            aside2.classList.add('hidden');
        } catch (error) {
            console.error('Error showing modal:', error);
        }
    });

    closeModal.addEventListener('click', () => {
        try {
            modal.classList.add('hidden');
            aside.classList.remove('hidden');
            aside2.classList.remove('hidden');
        } catch (error) {
            console.error('Error hiding modal:', error);
        }
    });
});

async function addGridClickListeners() {
    try {
        document.querySelectorAll('#vertical_indices li').forEach((li) => {
            li.addEventListener('click', async () => {
                console.log("bonjour")
                const gridID = li.getAttribute('data-grid-id');
                console.log(gridID);
                // Envoyer une requête au serveur
                await fetch('../controllers/get_grid_data.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Cache-Control': 'no-cache'
                    },
                    body: JSON.stringify({ id: gridID })
                })
                .then(response => response.text() )
                .then((data) => {
                    console.log(data+"azule");
                    data = JSON.parse(data);
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

document.addEventListener('DOMContentLoaded',  () => {
    try {
        addGridClickListeners();
        
    } catch (error) {
        console.error('Error initializing grid click listeners:', error);
    }
});

document.addEventListener('DOMContentLoaded', () => {
    try {
        const checkbox = document.getElementById('filter-my-grids');
        const gridList = document.getElementById('vertical_indices');
        fetchGames();
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
    console.log(filterMyGrids);
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
        const gridList = document.getElementById('vertical_indices');
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

// Fonction pour récupérer les parties

function fetchGames() {
    fetch('../controllers/get_all_games.php',{
        method: 'GET',
        headers: { 'Content-Type': 'application/json' }
    })
        .then(response => response.text())
        .then(data => {
            data = JSON.parse(data);
            try {
                updateGameList(data);
            } catch (error) {
                console.error('Error updating grid list:', error);
            }
        })
        .catch(error => console.error('Erreur lors de la récupération des grilles:', error));
}

function updateGameList(grids) {
    try {
        const gridList = document.getElementById('liste_games');
        gridList.innerHTML = ''; // Vider la liste existante
        

        if (grids.length > 0) {
            grids.forEach(grid => {
                const listItem = createGameListItem(grid);
                const dificulty = document.createElement('span');
                dificulty.textContent = grid.level;
                dificulty.classList.add('level');
                listItem.appendChild(dificulty);
                gridList.appendChild(listItem);
                addGridClickListeners();
            });
            
        } else {
            gridList.innerHTML = '<li>Aucune grille trouvée.</li>';
        }
    } catch (error) {
        console.error('Error updating grid list:', error);
    }
}

function createGameListItem(grid) {
    try {
        const listItem = document.createElement('li');
        listItem.setAttribute('data-grid-id', grid.gridID);
        listItem.textContent = grid.gridName;
        attachClickListenerToLi(listItem);
    
        // Si l'utilisateur est le propriétaire, ajouter un bouton "Modify"
        return listItem;
    } catch (error) {
        console.error('Error creating grid list item:', error);
    }
}

// Fonction pour attacher un écouteur d'événements à un élément <li>

function attachClickListenerToLi(li) {
    try {
        li.addEventListener('click', () => {
            console.log('click');
            const gridID = li.getAttribute('data-grid-id');
            
            // Vérifier que l'attribut data-grid-id existe
            if (!gridID) {
                console.error('Aucun gridID trouvé pour cet élément:', li);
                return;
            }

            // Envoyer une requête au serveur
            fetch('../controllers/get_grid_data.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: gridID, game: true })
            })
            .then(response => response.text())
            .then((data) => {
                console.log(data);
                data = JSON.parse(data);
                if (data.success) {
                    window.location.href = '../Vue/play.php';
                } else {
                    alert('Erreur lors de la récupération des données de la grille');
                }
            })
            .catch(error => {
                console.error('Erreur lors de l\'envoi :', error);
            });
        });
    } catch (error) {
        console.error('Error attaching click listener to li:', error);
    }
}
