<?php
//if (!isset($_POST['RecipEmail'] or $_POST['AUTH'] != 'axelssecretpassword') {
//    exit();
//}
//
////Get e-mail Details
//    $RecipEmail = $_POST['RecipEmail'];
//    $RecipName = $_POST['RecipName'];
//    $Subject = $_POST['Subject'];
//    $Body = $_POST['Body']; //This is the HTML message body <b>in bold!</b>';
//    $AltBody = $_POST['AltBody']; //'This is the body in plain text for non-HTML mail clients';


require 'vendor/autoload.php';

    
function FlagMail($recipients, $Subject, $Body, $AltBody) { //
    
$mail = new PHPMailer;

//$mail->SMTPDebug = false;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.mandrillapp.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'axelhawker@gmail.com';                 // SMTP username
$mail->Password = 'eNPkUc_jJEOYjS3RIPzz5g';                           // SMTP password
$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465;                                    // TCP port to connect to


//Set up E-mail
$mail->From = 'flags@troop833.com';
$mail->FromName = 'Troop 833 Flag Service';
    
// Add recipients
 foreach($recipients as $email => $name)
{
   $mail->addAddress($email, $name);
}   
    
//$mail->addAddress('ellen@example.com');               // Name is optional
$mail->addReplyTo('flags@troop833.com', 'Troop 833 Flag Service');
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');

//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = $Subject;
$mail->Body    = $Body;
$mail->AltBody = $AltBody;

if(!$mail->send()) {
//    echo 'Message could not be sent.';
    Return('Mailer Error: ' . $mail->ErrorInfo);
} else {
    Return('Success');
}
}
    ?>