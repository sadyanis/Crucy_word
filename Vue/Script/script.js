let cases =  document.getElementsByClassName("grille_item"); //la grille 

for (let elt of cases){
    elt.addEventListener("dblclick",()=>{
        elt.classList.toggle("black");
       console.log(elt) ;
    });
}

document.querySelectorAll(".case").forEach((div)=>{
div.addEventListener("click",()=>{
    div.setAttribute("contenteditable", "true");
    div.focus();
});
div.addEventListener("blur",()=>{
    div.removeAttribute("contenteditable");
});
div.addEventListener("input", () => {
    const content = div.textContent.toUpperCase().replace(/[^A-Z]/g, ""); // Filtrer uniquement les lettres
    div.textContent = content.slice(0, 1); // Limiter à 1 caractère
  });
  
  div.addEventListener("keydown",(e)=>{
    if(e.key === "Enter"){
        e.preventDefault();
        div.blur();
    }
}) ;
});