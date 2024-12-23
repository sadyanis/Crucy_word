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