<?php



use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;



require 'vendor/autoload.php';





function mailer($from, $to, $subject, $body, ) {

    $mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      
    $mail->isSMTP();                                            
    $mail->Host       = 'smtp.google.com';                    
    $mail->SMTPAuth   = true;                                   
    $mail->Username   = 'ai329390@gmail.com';                    
    $mail->Password   = 'f o l h q o i i d i d w s l k r';                                
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;             
    $mail->Port       = 587;                                    

    //Recipients
    $mail->setFrom($from);
    $mail->addAddress($to);     

    //Content
    $mail->isHTML(true);                                 
    $mail->Subject = $subject;
    $mail->Body    = $body;

    $mail->send();
    return 'Заявка успешно отправлена!';
} catch (Exception $e) {
    echo "Ошибка отправки заявки! Ошибка: {$mail->ErrorInfo}";
}

}

