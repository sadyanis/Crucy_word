let form = document.getElementById("form");
let passeword = document.getElementById("pwd");
let conf_pwd = document.getElementById("conf_pwd");
let eroor_msg = document.getElementById("error-message");

form.addEventListener("submit",(event)=>{
    if(passeword.value != conf_pwd.value ){
        eroor_msg.textContent = "Les mots de passe ne correspondent pas.";
        event.preventDefault();
    }else{
        eroor_msg.textContent ="";
    }
});