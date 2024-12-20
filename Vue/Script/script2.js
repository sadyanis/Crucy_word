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