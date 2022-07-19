<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './phpmailer/src/Exception.php';
require './phpmailer/src/PHPMailer.php';
require './phpmailer/src/SMTP.php';

//CONFIG
$smtpUsername = "user@domain.com";
$smtpPassword = "password";

$user_message = "Complete";

$emailTo = "user@domain.com";
$emailToName = "Contactformulier";

$name = $_POST["name"];
$subject = $_POST['subject'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$message = $_POST['message'];

$expensions= array("jpeg","jpg","png","pdf");

$file1 = (isset($_FILES['file1']))? $_FILES['file1']: null;

if(isset($file1))
{
    $file1_size = $file1['size'];
    $file1_ext_tmp = explode('.',$file1['name']);
    $file1_ext=strtolower(end($file1_ext_tmp));

    if(in_array($file1_ext,$expensions)=== false){
        $user_message = "Error";
     }
     if($file1_size > 5242880) {
        $user_message = "Error";
     }
}
$file2 = (isset($_FILES['file2']))? $_FILES['file2']: null;

if(isset($file2))
{
    $file2_size = $file1['size'];
    $file2_ext_tmp = explode('.',$file2['name']);
    $file2_ext=strtolower(end($file2_ext_tmp));

    if(in_array($file2_ext,$expensions)=== false){
        $user_message = "Error";
     }
     if($file2_size > 5242880) {
        $user_message = "Error";
     }

}
$messageToSend = "<b>Naam:</b> $name <br>"
    ."<b>Email:</b> $email <br>"
    ."<b>Telefoonnummer:</b> $phone <br>"
    ."<b>Vraag of opmerking:</b> $message <br>";


$emailFrom = 'user@domain.com';
$emailFromName = $name;



$mail = new PHPMailer;
$mail->isSMTP(); 
$mail->SMTPDebug = 0; // 0 = off (for production use) - 1 = client messages - 2 = client and server messages
$mail->Host = "HOST ADRESS"; // use $mail->Host = gethostbyname('smtp.gmail.com');
$mail->Port = 587; // TLS only
$mail->SMTPSecure = 'tls'; // ssl is depracated
$mail->SMTPAuth = true;
$mail->Username = $smtpUsername;
$mail->Password = $smtpPassword;
$mail->setFrom($emailFrom, $emailFromName);
$mail->addAddress($emailTo, $emailToName);
$mail->Subject = $subject;
$mail->msgHTML($messageToSend); //$mail->msgHTML(file_get_contents('contents.html'), __DIR__); //Read an HTML message body from an external file, convert referenced images to embedded,
$mail->AltBody = 'HTML messaging not supported';
if(isset($file1) && $file1['error'] == UPLOAD_ERR_OK) $mail->addAttachment($file1['tmp_name'], $file1['name']); 
if(isset($file2) && $file2['error'] == UPLOAD_ERR_OK) $mail->addAttachment($file2['tmp_name'], $file2['name']); 


if(!$mail->send() && $user_message=="Complete"){
    $user_message = "Error";
    echo "Mailer Error: " . $mail->ErrorInfo;
}else{
    $user_message = "Complete";
}



print_r($user_message);