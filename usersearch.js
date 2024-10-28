const sbar = document.querySelector(".searchbox input");
const allx = document.querySelector(".all");

sbar.onkeyup = () => {
    let searchTerm = sbar.value;

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "searchx.php", true);

    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.response;
                allx.innerHTML = data;
            }
        }
    }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("searchTerm=" + searchTerm);

}
