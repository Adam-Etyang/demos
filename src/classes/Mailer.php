<?php

namespace App\classes;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    private $mailer;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);

        // SMTP configuration
        $this->mailer->isSMTP();
        $this->mailer->Host = "smtp.gmail.com";
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = "adam.etyang@strathmore.edu";
        $this->mailer->Password = "dknx eejx jkzq smcb";
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mailer->Port = 587;

        $this->mailer->setFrom("adam.etyang@stratmore.edu", "App");
    }

    public function sendVerificationEmail($email, $name, $token)
    {
        try {
            $this->mailer->addAddress($email, $name);

            $verificationUrl =
                "http://localhost/demos/public/verify.php?token=" . $token;

            $this->mailer->isHTML(true);
            $this->mailer->Subject = "Email Verification Required";
            $this->mailer->Body = "
                <h2>Welcome, {$name}!</h2>
                <p>Please click the link below to verify your email address:</p>
                <a href='{$verificationUrl}' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Verify Email</a>
                <p>Or copy this link: {$verificationUrl}</p>
            ";

            return $this->mailer->send();
        } catch (Exception $e) {
            error_log("Mailer Error: " . $this->mailer->ErrorInfo);
            return false;
        }
    }
}
