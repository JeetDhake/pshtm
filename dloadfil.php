<?php
    $file = $_GET['file'];
    header('Content-Disposition: attachment; filename="' . urlencode($file) . '"');
    $fb = fopen($file, "r");

    $chunk_size = 2 * 1024 * 1024;
    while(!feof($fb)){
        echo fread($fb, $chunk_size);
        flush();
    }
    fclose($fb);
?>