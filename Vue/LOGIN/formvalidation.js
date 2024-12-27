let form = document.getElementById("form");
let passeword = document.getElementById("pwd");
let conf_pwd = document.getElementById("conf_pwd");
let error_msg = document.getElementById("error-message");

form.addEventListener("submit",(event)=>{
    if(passeword.value != conf_pwd.value ){
        error_msg.textContent = "Les mots de passe ne correspondent pas.";
        event.preventDefault();
    }else{
        error_msg.textContent ="";
    }
});