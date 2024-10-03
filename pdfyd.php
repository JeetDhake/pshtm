
<?php
require 'vendor/autoload.php';

use Mpdf\Mpdf;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = htmlspecialchars($_POST['name']);
    $from = $_POST['from'];
    $to = $_POST['to'];

$mpdf = new Mpdf(['mode' => 'utf-8', 'format' => 'A4-L']);

// $html = file_get_contents('sample/pdfx.php');

// $mpdf->WriteHTML($html);

$html = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate</title>
    <style>
        body {
            font-family: "Arial", sans-serif;
            margin: 0;
            padding: 0;
    
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f3f3f3;
        }
        .certificate {
            width: 100%;
            height: 100%;

            border: 5px solid #d6d6d6;
            padding: 25px;
            box-sizing: border-box;
            background-color: white;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #d6d6d6;
            padding-bottom: 4px;
        }
        .header img {
            width: 250px;
        }
        .header h1 {
            font-size: 36px;
            margin: 7px 0;
            color: #0056b3;
        }
        .header h2 {
            font-size: 28px;
            margin: 5px 0;
        }
        .header h3 {
            font-size: 24px;
            margin-top: 5px;
        }
        .content {
            text-align: center;
            margin: 20px 0;
        }
        .content h3 {
            font-size: 22px;
        }
        .content p {
            font-size: 18px;
            margin: 10px 0;
        }
        .content .highlight {
            font-weight: bold;
            font-size: 20px;
        }
        .footer {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .footer div {
            text-align: center;
            margin-top: 20px;
        }
        .footer p {
            font-size: 16px;
            margin: 5px 0;
        }
        .signature {
            height: 80px;
            width: 80px;
        }
    </style>
</head>
<body>
    <div class="certificate">
        <div class="header">
            <img src="img/logo.png" alt="Parul University Logo">
        
            <h2>BASIC COURSE IN MEDICAL EDUCATION (BCME)</h2>
            <h3>CERTIFICATE OF PARTICIPATION</h3>
        </div>
        <div class="content">
            <p>This is to certify that</p>
            <p class="highlight">Dr. '.$name.'</p>
            <p>has participated in the</p>
            <p class="highlight">Basic Course in Medical Education (BCME)</p>
            <p>organized by the Medical Education Unit, Parul Institute of Medical Sciences & Research, Vadodara from</p>
            <p class="highlight">'.$from.' to '.$to.'</p>
            <p>GUJARAT MEDICAL COUNCIL HAS AWARDED <span class="highlight">NINE</span> CREDIT HOURS FOR THE PARTICIPATION</p>
        </div>
        <div class="footer">
                        <table style="width: 100%;">
                <tr>
                    <td>
                        <div>
                            <img src="img/tempsign.png" alt="" class="signature">
                            <p><strong>Dr. Jagdish Gohil</strong></p>
                            <p>Dean PIMSR, Vadodara</p>
                        </div>
                    </td>
                    <td>
                        <div>
                            <img src="img/tempsign.png" alt="" class="signature">
                            <p><strong>Dr. V. P. Hathila</strong></p>
                            <p>Observer Gujarat Medical Council</p>
                        </div>
                    </td>
                    <td>
                        <div>
                            <img src="img/tempsign.png" alt="" class="signature">
                            <p><strong>Dr. Wasim A. Shaikh</strong></p>
                            <p>Coordinator, MEU, PIMSR, Vadodara</p>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>

';

$mpdf->WriteHTML($html);

$fnm = uniqid('Certi_', true);

$mpdf->Output($fnm.'.pdf', 'D'); // 'I' for inline, 'D' for download
}
else{
    header('Location: user_login.php');
    exit;
}
?>