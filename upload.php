<?php
include('connect.php');

if (isset($_POST['submit'])) {

    $title = $_POST['title'];
    $author = $_POST['author'];

    $file = $_FILES['file'];
    $filename = $_FILES['file']['name'];
    $filetmp_name = $_FILES['file']['tmp_name'];
    $filesize = $_FILES['file']['size'];
    $fileerror = $_FILES['file']['error'];
    $filetype = $_FILES['file']['type'];

    $fileext = explode('.', $filename);
    $fileactext = strtolower(end($fileext));

    $allowed = array('txt', 'pdf', 'docx', 'doc', 'ppt', 'pptx');

    if (in_array($fileactext, $allowed)) {
        if ($fileerror === 0) {
            if ($filesize < 500000) {

                $filenewname = uniqid('', true) . "." . $fileactext;
                $filedestination = 'docs/' . $filenewname;

                move_uploaded_file($filetmp_name, $filedestination);

                $insert_file = "INSERT INTO files (title, author, name, type, extention, location, size) VALUES ('$title','$author','$filenewname','$filetype','$fileactext','$filedestination','$filesize')";

                $result_query = pg_query($conn, $insert_file);
                if ($result_query) {

                    echo "<script>
                        alert('File Uploaded successfully')
                      </script>";
                    header("Location: all_files.php");
                }
            } else {
                echo "<script>
                alert('File size exceeded 500mb')
              </script>";
                exit();
            }
        } else {
            echo "<script>
            alert('Error Uploading File')
          </script>";
            exit();
        }
    } else {

        echo "<script>
                alert('File type no supported')
              </script>";
        exit();
    }
}
