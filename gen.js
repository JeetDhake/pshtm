// function generateMCQ_old(mq, op1, op2, op3, op4) {

//             const questionContainer = document.createElement('div');
//             questionContainer.classList.add('mcq-container');

//             const userQuestion = mq;

//             const question = document.createElement('label');
//             question.textContent = userQuestion;

//             questionContainer.appendChild(question);

//             const a = op1;
//             const b = op2;
//             const c = op3;
//             const d = op4;

//             const options = [a, b, c, d];

//             options.forEach((option) => {

//                 const label = document.createElement('label');


//                 const radioBtn = document.createElement('input');
//                 radioBtn.type = 'radio';

//                 radioBtn.value = option;
//                 var mx = "answer[]";
//                 radioBtn.name = mx;
//                 label.textContent = option;
//                 label.appendChild(radioBtn);

//                 questionContainer.appendChild(label);

//             });

//             document.getElementById("output1").appendChild(questionContainer);
//         }

        function generateMCQ(mq, op1, op2, op3, op4, qid) {
            const questionContainer = document.createElement('div');
            questionContainer.classList.add('mcq-container');

            const questionLabel = document.createElement('label');
            questionLabel.textContent = mq;
            questionContainer.appendChild(questionLabel);

            const options = [op1, op2, op3, op4];
            const val = ['a', 'b', 'c', 'd'];
            let i = 0;
            options.forEach((option, index) => {
                const radioBtn = document.createElement('input');
                radioBtn.type = 'radio';
                radioBtn.id = qid;

                radioBtn.name = qid;
                radioBtn.value = val[i];
                i++;
                const label = document.createElement('label');
                label.htmlFor = radioBtn.id;
                label.textContent = option;

                const optionContainer = document.createElement('div');
                optionContainer.classList.add('option-container');
                optionContainer.appendChild(radioBtn);
                optionContainer.appendChild(label);

                questionContainer.appendChild(optionContainer);
            });

            // Append the question container to the output element
            document.getElementById('output1').appendChild(questionContainer);
        }


        // function createTextArea(lbltax) {

        //     var newdiv = document.createElement("div");
        //     newdiv.classList.add("inpbx");

        //     let lbll = lbltax;

        //     var label = document.createElement("label");
        //     label.innerHTML = lbll + ": ";

        //     var textArea = document.createElement("textarea");
        //     textArea.rows = 20;

        //     var tax = "answer[]";

        //     textArea.name = tax;

        //     newdiv.appendChild(label);
        //     newdiv.appendChild(document.createElement("br"));
        //     newdiv.appendChild(textArea);

        //     document.getElementById("output1").appendChild(newdiv);
        // }

        // function createInputtxt(type, lbltx) {
        //     var newDiv = document.createElement("div");
        //     newDiv.classList.add("inpbx");
        //     var newInput = document.createElement("input");
        //     var tx = "answer[]";
        //     newInput.type = type;

        //     newInput.name = tx;

        //     let lbl = lbltx;

        //     var label = document.createElement("label");
        //     label.innerHTML = lbl + ": ";

        //     newDiv.appendChild(label);
        //     newDiv.appendChild(newInput);
        //     document.getElementById("output1").appendChild(newDiv);
        // }


        // function createInputnum(type, lblnm) {
        //     var newDiv = document.createElement("div");
        //     newDiv.classList.add("inpbx");
        //     var newInput = document.createElement("input");
        //     var nx = "answer[]";

        //     newInput.name = nx;
        //     newInput.type = type;

        //     let lbl = lblnm;

        //     var label = document.createElement("label");
        //     label.innerHTML = lbl + ": ";

        //     newDiv.appendChild(label);
        //     newDiv.appendChild(newInput);
        //     document.getElementById("output1").appendChild(newDiv);
        // }