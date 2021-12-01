const limitacao = document.getElementById ('#password');

limitacao.addEventListener("keypress", function (e){
    checkChar(e);
})

function checkChar (e) {
    const char = String.fromCharCode(e.keycode);

    const pattern = '[a-zA-Z0-9]';

    if(char.match(pattern)) {
        return true;
    }
}