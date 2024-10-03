
<?php
require 'vendor/autoload.php';

use Mpdf\Mpdf;

$mpdf = new Mpdf();

// $html = file_get_contents('sample/pdfx.php');

// $mpdf->WriteHTML($html);

$html = "
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Dynamic PDF</title>
    <style>
    
    </style>
</head>
<body>

</body>
</html>
";

$mpdf->WriteHTML($html);

$fnm = uniqid('Certi_', true);

$mpdf->Output($fnm.'.pdf', 'D'); // 'I' for inline, 'D' for download
?>