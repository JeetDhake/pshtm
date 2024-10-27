<?php

include('connect.php');
session_start();

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

    $allowed = array('txt', 'pdf', 'docx', 'doc', 'ppt', 'pptx', 'mp4');

    if (in_array($fileactext, $allowed)) {
        if ($fileerror === 0) {
            if ($filesize < 100000000) {

                $filenewname = uniqid('', true) . "." . $fileactext;
                $filedestination = 'docs/' . $filenewname;

                move_uploaded_file($filetmp_name, $filedestination);

                $insert_file = "INSERT INTO files (title, author, name, type, extention, location, size) VALUES ('$title','$author','$filenewname','$filetype','$fileactext','$filedestination','$filesize')";

                $result_query = pg_query($conn, $insert_file);
                if ($result_query) {

                    $_SESSION['message'] = "File Uploaded successfully";
                    header("Location: upload_file.php");
                }
            } else {
                $_SESSION['message'] = "File size exceeded 100mb";
                header("Location: upload_file.php");
                exit();
            }
        } else {
            $_SESSION['message'] = "Error Uploading File";
            header("Location: upload_file.php");
            exit();
        }
    } else {

        $_SESSION['message'] = "File type no supported";
        header("Location: upload_file.php");
        exit();
    }
}
