
function generateMCQ(userQuestion, a, b, c, d) {

    const questionContainer = document.createElement('div');
    questionContainer.classList.add('mcq-container');

    const question = document.createElement('label');
    question.textContent = userQuestion;

    questionContainer.appendChild(question);

    const options = [a, b, c, d];

    options.forEach((option, index) => {

        const label = document.createElement('label');
        

        const radioBtn = document.createElement('input');
        radioBtn.type = 'radio';

        radioBtn.value = option;

        label.textContent = option;
        label.appendChild(radioBtn);
        

        questionContainer.appendChild(label);

    });
    var deleteLink = document.createElement("a");
    // deleteLink.classList.add("delmf");
    // deleteLink.innerHTML = "Delete";
    // deleteLink.href = "del_q.php";
    // questionContainer.appendChild(deleteLink);

    document.getElementById("output1").appendChild(questionContainer);

}





// function createTextArea() {

//     var newdiv = document.createElement("div");
//     newdiv.classList.add("inpbx");

//     let lbll = document.getElementById("multiliner").value;

//     var label = document.createElement("label");
//     label.innerHTML = lbll + ": ";

//     var textArea = document.createElement("textarea");
//     textArea.rows = 20;

//     var deleteLink = document.createElement("a");
    // deleteLink.classList.add("delmf");
    // deleteLink.innerHTML = "Delete";
    // deleteLink.href = "del_q.php";
    // newdiv.appendChild(deleteLink);

//     newdiv.appendChild(label);
//     newdiv.appendChild(document.createElement("br"));
//     newdiv.appendChild(textArea);

//     document.getElementById("output1").appendChild(newdiv);
// }






// function createInput(type) {
//     var newDiv = document.createElement("div");
//     newDiv.classList.add("inpbx");
//     var newInput = document.createElement("input");

//     newInput.type = type;

//     let lbl = document.getElementById("oneliner").value;

//     var label = document.createElement("label");
//     label.innerHTML = lbl + ": ";

//     var deleteLink = document.createElement("a");
    // deleteLink.classList.add("delmf");
    // deleteLink.innerHTML = "Delete";
    // deleteLink.href = "del_q.php";
    // newDiv.appendChild(deleteLink);

//     newDiv.appendChild(label);
//     newDiv.appendChild(newInput);
//     document.getElementById("output1").appendChild(newDiv);
// }

// function createInput1(type) {
//     var newDiv = document.createElement("div");
//     newDiv.classList.add("inpbx");
//     var newInput = document.createElement("input");

//     newInput.type = type;

//     let lbl = document.getElementById("numberer").value;

//     var label = document.createElement("label");
//     label.innerHTML = lbl + ": ";

//     var deleteLink = document.createElement("a");
    // deleteLink.classList.add("delmf");
    // deleteLink.innerHTML = "Delete";
    // deleteLink.href = "del_q.php";
    // newDiv.appendChild(deleteLink);

//     newDiv.appendChild(label);
//     newDiv.appendChild(newInput);
//     document.getElementById("output1").appendChild(newDiv);
// }






// var htmlbtn = document.getElementById("htmlbtn");
// var bns = document.getElementById("xbtn");
// var htmled = document.getElementById("htmled");
// var back = document.getElementById("back");

// htmlbtn.addEventListener("click", (e) => {
//     e.preventDefault();
//     bns.style.display = "none";
//     htmled.style.display = "block";
// });
// back.addEventListener("click", (e) => {
//     e.preventDefault();
//     bns.style.display = "block";
//     htmled.style.display = "none";
// });

// var mcqbtn = document.getElementById("mcqbtn");
// var mcq = document.getElementById("mcq");
// var back3 = document.getElementById("back3");

// mcqbtn.addEventListener("click", (e) => {
//     e.preventDefault();
//     bns.style.display = "none";
//     mcq.style.display = "block";
// });
// back3.addEventListener("click", (e) => {
//     e.preventDefault();
//     bns.style.display = "block";
//     mcq.style.display = "none";
// });

// var onelinebtn = document.getElementById("onelinebtn");
// var oneline = document.getElementById("oneline");
// var back1 = document.getElementById("back1");

// onelinebtn.addEventListener("click", (e) => {
//     e.preventDefault();
//     bns.style.display = "none";
//     oneline.style.display = "block";
// });
// back1.addEventListener("click", (e) => {
//     e.preventDefault();
//     bns.style.display = "block";
//     oneline.style.display = "none";
// });

// var multilinebtn = document.getElementById("multilinebtn");
// var multiline = document.getElementById("multiline");
// var back2 = document.getElementById("back2");

// multilinebtn.addEventListener("click", (e) => {
//     e.preventDefault();
//     bns.style.display = "none";
//     multiline.style.display = "block";
// });
// back2.addEventListener("click", (e) => {
//     e.preventDefault();
//     bns.style.display = "block";
//     multiline.style.display = "none";
// });



