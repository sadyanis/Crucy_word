document.addEventListener('DOMContentLoaded', () => {
    try {
        
        const checkbox = document.getElementById('filter-grids');
        const btnCreate = document.getElementById('createUser');
        fetchGrids();
        fetchUsers();
        checkbox.addEventListener('change', () => {
            const showordered = checkbox.checked;
            fetchGrids(showordered);
        });
        btnCreate.addEventListener('click',()=>{
            // changer de location
            window.location.href = '../Vue/LOGIN/signup.php';
        })
    } catch (error) {
        console.error('Error initializing filter checkbox:', error);
    }
});


//
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
        const gridList = document.getElementById('liste_grille');
        gridList.innerHTML = ''; // Vider la liste existante
        

        if (grids.length > 0) {
            grids.forEach(grid => {
                const listItem = createGridListItem(grid);
                
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
        const div = document.createElement('div');
        div.classList.add('options');

        listItem.setAttribute('data-grid-id', grid.gridID);
        listItem.textContent = grid.gridName;


        // Si l'utilisateur est le propriétaire, ajouter un bouton "Modify"

            const modifyButton = createModifyButton(grid.gridID);
            const dificulty = document.createElement('span');
                dificulty.textContent = grid.level;
                dificulty.classList.add('level');
            div.appendChild(dificulty);    
            div.appendChild(modifyButton);
            listItem.appendChild(div);
        

        return listItem;
    } catch (error) {
        console.error('Error creating grid list item:', error);
    }
}

function createModifyButton(gridID) {
    try {
        const btn = document.createElement('button');
        btn.textContent = 'delete';
        btn.addEventListener('click', (event) => {
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
                        btn.parentElement.parentElement.remove(); // Supprimer l'élément <li> parent
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

function fetchUsers(){
    fetch('../controllers/get_all_users.php',{
        method: 'GET',
        headers: { 'Content-Type': 'application/json' },
    })
        .then(response => response.text())
        .then(data => {
            data = JSON.parse(data);
            try {
                updateUserList(data);
            } catch (error) {
                console.error('Error updating grid list:', error);
            }
        })
        .catch(error => console.error('Erreur lors de la récupération des grilles:', error));
}

function updateUserList(grids) {
    try {
        const gridList = document.getElementById('liste_user');
        gridList.innerHTML = ''; // Vider la liste existante
        

        if (grids.length > 0) {
            grids.forEach(grid => {
                const listItem = createUserListItem(grid);
                
                gridList.appendChild(listItem);
            });
        } else {
            gridList.innerHTML = '<li>Aucune Utilisateur trouvée.</li>';
        }
    } catch (error) {
        console.error('Error updating user list:', error);
    }
}

function createUserListItem(grid){

    try {
        const listItem = document.createElement('li');
        

        listItem.setAttribute('data-user-id', grid.UserID);
        listItem.textContent = grid.UserID;


        // Si l'utilisateur est le propriétaire, ajouter un bouton "Modify"

            const modifyButton = createDeleteButton(grid.UserID);
               
            
            listItem.appendChild(modifyButton);
        

        return listItem;
    } catch (error) {
        console.error('Error creating grid list item:', error);
    }
}

function createDeleteButton(gridID) {
    try {
        const btn = document.createElement('button');
        btn.textContent = 'delete';
        btn.addEventListener('click', (event) => {
            const confirmation = confirm('Voulez-vous vraiment supprimer cet Utilisateur ?');
            if (!confirmation) return;
            // Envoyer une requête au serveur pour supprimer la grille
            fetch('../controllers/deleteUser.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: gridID })
            }).then(response => response.json())
                .then(data => {
                    if (data.success) {
                        btn.parentElement.remove(); // Supprimer l'élément <li> parent
                        console.log(' Utilisateur supprimé', gridID);
                    } else {
                        alert('Erreur lors de la suppression de l\'utilisateur');
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