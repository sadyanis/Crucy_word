let cases =  document.getElementsByClassName("grille_item");

for (let elt of cases){
    elt.addEventListener("dblclick",()=>{
        elt.classList.toggle("black");
       console.log(elt) ;
    });
}