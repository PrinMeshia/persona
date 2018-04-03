<?php
namespace app\persona\email;

use app\persona\Persona;

class Email
{
    public static function sendEmail($type, $email, $userData, $data)
    {
        $config = Persona::getInstance()->config->mail;
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPAuth = $config->auth;
        $mail->SMTPSecure = $config->secure;
        $mail->Host = $config->host;
        $mail->Port = $config->port;
        $mail->Username = $config->login;
        $mail->Password = $config->password;
        $mail->SetFrom($config->from->mail, $config->from->name);
        $mail->AddReplyTo($config->reply_to);
        $mail->Body = self::getReportBugBody($userData, $data);
        $mail->Subject = "[" . ucfirst($data["label"]) . "] " . $config->type->EMAIL_REPORT_BUG_SUBJECT . " | " . $data["subject"];
        $mail->AddAddress($email);
        // If you don't have an email setup, you can instead save emails in log.txt file using Logger.
        // Logger::log("EMAIL", $mail->Body);
        if (!$mail->Send()) {
            throw new \Exception("Email couldn't be sent to " . $userData["id"] . " for type: " . $type);
        }
    }
    private static function getReportBugBody($userData, $data){
        $body  = "";
        $body .= "User: " . $userData["name"] . ", \n\n" . $data["message"];
        $body .= "\n\n\nFrom: " . $userData["id"] . " | " . $userData["name"];
        $body .= "\n\nThanks\nPersona community";
        return $body;
    }
}