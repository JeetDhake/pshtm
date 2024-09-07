
const pf = document.querySelector(".login input[type='password']"),
togglebtn = document.querySelector(".login .field i");

togglebtn.onclick = ()=>{
    if(pf.type == "password"){
        pf.type = "text";
        togglebtn.classList.add("active");
    }
    else{
        pf.type = "password";
        togglebtn.classList.remove("active");
    }
}


const form  = document.querySelector(".login form"),
conbtn = form.querySelector(".btn input"),
errtxt = form.querySelector(".error");

form.onsubmit = (e)=>{
    e.preventDefault();

}
conbtn.onclick = ()=>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "emp_login.php", true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                console.log(data);

                if(data == "success"){
                    location.href = "home_page.php";
                }
                else{
                    errtxt.classList.add("active");
                    
                    errtxt.style.display = "block";
                    errtxt.textContent = data;
                    
                }
            }
        }
    }
    let formData = new FormData(form);
    xhr.send(formData);
}
