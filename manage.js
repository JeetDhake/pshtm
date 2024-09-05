var menui = document.querySelector(".fa-bars");
var sb = document.querySelector(".sidebar");
var container = document.querySelector(".container");

menui.onclick = function(){
    sb.classList.toggle("close-sb");
    container.classList.toggle("lg-container");
}

const activepage = window.location.pathname;
const link = document.querySelectorAll('.links a').
forEach(link => {
    if(link.href.includes(`${activepage}`)){
        link.classList.add('activelink');
    }
});