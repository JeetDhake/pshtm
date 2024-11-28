
<?php
require 'vendor/autoload.php';

use Mpdf\Mpdf;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = htmlspecialchars($_POST['name']);

    $trainer_name_str = $_POST['trainer_name'];
    $trainer_name = explode(',', $trainer_name_str);

    $trainer_sign_str = $_POST['trainer_sign'];
    $trainer_sign = explode(',', $trainer_sign_str);

    $count = count($trainer_sign);

    $mpdf = new Mpdf(['mode' => 'utf-8', 'format' => 'A4-L']);

    // $html = file_get_contents('sample/pdfx.php');

    // $mpdf->WriteHTML($html);
    for ($i = 0; $i < $count; $i++) {
        $valx .= '
            <td>
                <div>
                    <img src="db_img/'.htmlspecialchars($trainer_sign[$i]).'" alt="Signature" class="signature">
                    <p><strong>'.htmlspecialchars($trainer_name[$i]).'</strong></p>
                    <p>Chief Operating Officer, Parul Sevashram Hospital</p>
                </div>
            </td>
        ';
    }   
    $html = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Appreciation</title>
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
            padding: 50px;
            background-color: white;
            border: 5px solid #d6d6d6;
            position: relative;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .header {
            text-align: center;
        }
        .header img{
            width: 150px;
            margin-bottom: 5px;
        }
        .header h1 {
            font-size: 28px;
            color: #0056b3;
        }
        .header h2 {
            font-size: 18px;
            font-weight: normal;
            margin: 10px 0;
        }
        .header h3 {
            font-size: 36px;
            color: #003366;
            margin-bottom: 10px;
        }
        .content {
            text-align: center;
        }
        .content p {
            font-size: 20px;
            margin: 10px 0;
            line-height: 1.8;
        }
        .highlight {
            font-size: 26px;
            font-weight: bold;
            margin: 20px 0;
        }
        .footer {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .footer div {
            text-align: center;
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
            <img src="img/logo2.jpg" alt="Logo">
            <h2>Affiliated to Parul Institute of Medical Sciences & Research</h2>
            <h3>CERTIFICATE OF APPRECIATION</h3>
        </div>
        <div class="content">
            <p>This certificate is awarded to</p>
            <p class="highlight">' . $name . '</p>
            <p>with gratitude for his/her dedication towards the hospital. Your hard work, empathy, & expertise have played a pivotal role in providing exceptional healthcare services. Your contributions towards the betterment of patient care & the smooth functioning of the hospital are invaluable and greatly appreciated.</p>
        </div>
        <div class="footer">
            <table style="width: 100%;"> 
                <tr>
                '.$valx.'
                </tr>
            </table>
        </div>
    </div>
</body>
</html>

';

    $mpdf->WriteHTML($html);

    $fnm = uniqid('Certi_', true);

    $mpdf->Output($fnm . '.pdf', 'D'); // 'I' for inline, 'D' for download
} else {
    header('Location: user_login.php');
    exit;
}
?>