

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
    xhr.open("POST", "login.php", true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                console.log(data);

                if(data == "success"){
                    location.href = "dashboard.php";
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






const formx  = document.querySelector(".loginx form"),
conbtnx = formx.querySelector(".btn input"),
errtxtx = formx.querySelector(".error");

formx.onsubmit = (e)=>{
    e.preventDefault();

}
conbtnx.onclick = ()=>{
    let xhrx = new XMLHttpRequest();
    xhrx.open("POST", "loginx.php", true);
    xhrx.onload = ()=>{
        if(xhrx.readyState === XMLHttpRequest.DONE){
            if(xhrx.status === 200){
                let datax = xhrx.response;
                console.log(datax);

                if(datax == "success"){
                    location.href = "dashboard2.php";
                }
                else{
                    errtxtx.classList.add("active");
                    
                    errtxtx.style.display = "block";
                    errtxtx.textContent = datax;
                    
                }
            }
        }
    }
    let formDatax = new FormData(formx);
    xhrx.send(formDatax);
}




