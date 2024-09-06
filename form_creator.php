<?php
include('connect.php');
session_start();
if (!isset($_SESSION['admin_id']) && !isset($_SESSION['trainer_id'])) {
    header("location: admin_login.php");
}
$id = $_GET['training_program_id'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/b9323f08fd.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style/form.css">
    <title>Questionaries</title>
</head>

<body>
    <?php require_once("navbar.html") ?>

    <div class="bxp container">
        <div class="editor">

            <div class="xbtn" id="xbtn">
                <!-- <button id="mcqbtn"><i class="fa-solid fa-heading"></i><br>MCQs</button> -->
                <!-- <button id="onelinebtn"><i class="fa-solid fa-paragraph"></i><br>One Liners</button>
                <button id="multilinebtn"><i class="fa-solid fa-paragraph"></i><br>Multi Liners</button>
                <button id="htmlbtn"><i class="fa-solid fa-code"></i><br>Numeric</button> -->
            </div>
            <div class="sv">

                <button type="">
                    <?php
                    $training_program_id = $_GET['training_program_id'];
                    ?>
                    <a href="view_form.php?training_program_id=<?php echo $training_program_id ?>">
                        <i class="fa-regular fa-floppy-disk"></i>View Form
                    </a>
                </button>
            </div>


            <!-- <div class="htmle inputfld" id="htmled">
                <form action="" method="POST" enctype="multipart/form-data">
                    <label for="">Number</label>
                    <textarea id="numberer" name="numberer" cols="30" rows="10" class="textarea" placeholder="Enter Numeric Question"></textarea>

                    <input type="text" name="input_type" id="input_type" value="number" hidden>

                    <button type="button" onclick="createInput1('number'); submitForm1()"><i class="fa-regular fa-share-from-square"></i>Save</button>

                    <button id="back"><i class="fa-regular fa-share-from-square"></i>Back</button>
                </form>
            </div>

            <script>
                function submitForm1() {
                    var numberer = document.getElementById("numberer").value;
                    var input_type = document.getElementById("input_type").value;
                    var training_program_id = <?php //echo $id ?>;

                    var Datax = new FormData();
                    Datax.append("numberer", numberer);
                    Datax.append("input_type", input_type);
                    Datax.append("training_program_id", training_program_id);

                    const xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = () => {
                        if (xhttp.readyState == 4) {
                            if (xhttp.status == 200) {
                                console.log("success");
                            }
                        }
                    }
                    xhttp.open("POST", "num_data.php", true);
                    xhttp.send(Datax);


                }
            </script>

            <div class="htmle inputfld" id="oneline">
                <form action="" method="POST" enctype="multipart/form-data">
                    <label for="">One Liners</label>
                    <textarea id="oneliner" name="oneliner" cols="30" rows="10" class="textarea" placeholder="Enter Question"></textarea>

                    <input type="text" name="input_type" id="input_type2" value="text" hidden>

                    <button type="button" onclick="createInput('text'); submitForm2()"><i class="fa-regular fa-share-from-square"></i>Save</button>

                    <button id="back1"><i class="fa-regular fa-share-from-square"></i>Back</button>
                </form>
            </div>
            <script>
                function submitForm2() {
                    var oneliner = document.getElementById("oneliner").value;
                    var input_type = document.getElementById("input_type2").value;
                    var training_program_id = <?php //echo $id ?>;

                    var Datax = new FormData();
                    Datax.append("oneliner", oneliner);
                    Datax.append("input_type", input_type);
                    Datax.append("training_program_id", training_program_id);

                    const xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = () => {
                        if (xhttp.readyState == 4) {
                            if (xhttp.status == 200) {
                                console.log("success");
                            }
                        }
                    }
                    xhttp.open("POST", "oneline_data.php", true);
                    xhttp.send(Datax);


                }
            </script>

            <div class="htmle inputfld" id="multiline">
                <form action="" method="POST" enctype="multipart/form-data">
                    <label for="">Multi Liners</label>
                    <textarea id="multiliner" name="multiliner" cols="30" rows="10" class="textarea" placeholder="Enter Question"></textarea>

                    <input type="text" name="input_type" id="input_type3" value="textarea" hidden>

                    <button type="button" onclick="createTextArea(); submitForm3()">
                        <i class="fa-regular fa-share-from-square"></i>Save</button>

                    <button id="back2"><i class="fa-regular fa-share-from-square"></i>Back</button>
                </form>
            </div>

            <script>
                function submitForm3() {
                    var multiliner = document.getElementById("multiliner").value;
                    var input_type = document.getElementById("input_type3").value;
                    var training_program_id = <?php //echo $id ?>;

                    var Datax = new FormData();
                    Datax.append("multiliner", multiliner);
                    Datax.append("input_type", input_type);
                    Datax.append("training_program_id", training_program_id);

                    const xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = () => {
                        if (xhttp.readyState == 4) {
                            if (xhttp.status == 200) {
                                console.log("success");
                            }
                        }
                    }
                    xhttp.open("POST", "multiline_data.php", true);
                    xhttp.send(Datax);


                }
            </script> -->


            <div class="htmle inputfld" id="mcq">
                <form action="" method="POST" enctype="multipart/form-data">
                    <label for="">MCQ</label>
                    <textarea id="mcqer" name="mcqer" cols="30" rows="10" class="textarea" placeholder="Enter Question"></textarea>

                    <label for="opt1">Option 1</label>
                    <input type="text" name="opt1" id="opt1" placeholder="Enter Value" class="inptx">
                    <label for="opt2">Option 2</label>
                    <input type="text" name="opt2" id="opt2" placeholder="Enter Value" class="inptx">
                    <label for="opt3">Option 3</label>
                    <input type="text" name="opt3" id="opt3" placeholder="Enter Value" class="inptx">
                    <label for="opt4">Option 4</label>
                    <input type="text" name="opt4" id="opt4" placeholder="Enter Value" class="inptx">

                    <label for="">Correct Answer</label>
                    <select name="ans" id="ans">
                    <option value="a">a</option>
                    <option value="b">b</option>
                    <option value="c">c</option>
                    <option value="d">d</option>
                    </select>

                    <input type="text" name="input_type" id="input_type4" value="mcq" hidden>

                    <button type="button" id="" onclick="submitForm4()"><i class="fa-regular fa-share-from-square"></i>Save</button>

                    <!-- <button id="back3"><i class="fa-regular fa-share-from-square"></i>Back</button> -->
                </form>
            </div>
            <script>
                function submitForm4() {
                    var mcqer = document.getElementById("mcqer").value;
                    var input_type = document.getElementById("input_type4").value;

                    var opt1 = document.getElementById("opt1").value;
                    var opt2 = document.getElementById("opt2").value;
                    var opt3 = document.getElementById("opt3").value;
                    var opt4 = document.getElementById("opt4").value;
                    var ans = document.getElementById("ans").value;
                    var training_program_id = <?php echo $id ?>;

                    var Datax = new FormData();
                    Datax.append("mcqer", mcqer);
                    Datax.append("input_type", input_type);

                    Datax.append("opt1", opt1);
                    Datax.append("opt2", opt2);
                    Datax.append("opt3", opt3);
                    Datax.append("opt4", opt4);
                    Datax.append("ans", ans)
                    Datax.append("training_program_id", training_program_id);
                   
                    const xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = () => {
                        if (xhttp.readyState == 4) {
                            if (xhttp.status == 200) {
                                console.log("success");
                                
                            }
                        }
                    }
                    xhttp.open("POST", "mcq_data.php", true);
                    xhttp.send(Datax);

                    generateMCQ(mcqer, opt1, opt2, opt3, opt4);

                    document.getElementById("mcqer").value = "";
                    document.getElementById("opt1").value = "";
                    document.getElementById("opt2").value = "";
                    document.getElementById("opt3").value = "";
                    document.getElementById("opt4").value = "";
                }
            </script>


        </div>
        <div class="console">
            <div class="outin">
                <div id="output1" class="outp1">

                </div>

            </div>

        </div>
    </div>




    <script src="form.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

</body>

</html>