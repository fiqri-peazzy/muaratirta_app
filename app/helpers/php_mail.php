<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// use Dotenv\Dotenv;



require ROOT_PATH . '/vendor/autoload.php';
// $dotenv = Dotenv::createImmutable(ROOT_PATH);
// $dotenv->load();

if (!function_exists('sendEmail')) {
    function sendEmail($mailConfig)
    {
        // require ROOT_PATH . '/vendor/phpmailer/PHPMailer/src/Exception.php';
        // require ROOT_PATH . '/vendor/phpmailer/PHPMailer/src/PHPMailer.php';
        // require ROOT_PATH . '/vendor/phpmailer/PHPMailer/src/SMTP.php';

        $mail = new PHPMailer(true);
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'] ?? 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['EMAIL_USERNAME'] ?? '';
        $mail->Password = $_ENV['EMAIL_PASSWORD'] ?? '';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 587;
        $mail->setFrom($mailConfig['mail_from_email'], $mailConfig['mail_from_name']);
        $mail->addAddress($mailConfig['mail_recipient_email'], $mailConfig['mail_recipient_name']);
        $mail->isHTML(true);
        $mail->Subject = $mailConfig['mail_subject'];
        $mail->Body = $mailConfig['mail_body'];
        if ($mail->send()) {
            return true;
        } else {
            return false;
        }
    }
}