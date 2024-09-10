
const drop = document.getElementById("drop");
const inputf = document.getElementById("img");
const imgview = document.getElementById("img-view");

inputf.addEventListener("change", uploadImage);

function uploadImage(){
    const x = inputf.files[0];
    let imgLink = URL.createObjectURL(inputf.files[0]);
    imgview.style.backgroundImage = `url(${imgLink})`;
    const fileName = x.name;
    imgview.innerHTML = `<i class='fa-regular fa-file fa-lg'></i> <br> ${fileName}`;
    
}

drop.addEventListener("dragover", function(e){
    e.preventDefault();
});
drop.addEventListener("drop", function(e){
    e.preventDefault();
    inputf.files = e.dataTransfer.files;
    uploadImage();
});
