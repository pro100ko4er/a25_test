<?php



use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;



require '../../vendor/autoload.php';





function mailer($from, $to, $subject, $body, ) {

    $mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      
    $mail->isSMTP();                                            
    $mail->Host       = 'smtp.example.com';                    
    $mail->SMTPAuth   = true;                                   
    $mail->Username   = '';                    
    $mail->Password   = '';                                
    // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;             
    $mail->Port       = 587;                                    

    //Recipients
    $mail->setFrom($from);
    $mail->addAddress($to);     

    //Content
    $mail->isHTML(true);                                 
    $mail->Subject = $subject;
    $mail->Body    = $body;

    $mail->send();
    return true;
} catch (Exception $e) {
    return "Ошибка отправки заявки! Ошибка: {$mail->ErrorInfo}";
}

}

