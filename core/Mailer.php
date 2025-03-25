<?php

namespace Core;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    protected $mail;

    /**
     * Initializes PHPMailer with SMTP settings from environment variables.
     */
    public function __construct()
    {
        $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();
        
        $this->mail = new PHPMailer(true);

        try {
            $this->mail->isSMTP();
            $this->mail->Host = $_ENV['MAIL_HOST'];
            $this->mail->SMTPAuth = true;
            $this->mail->Username = $_ENV['MAIL_USERNAME'];
            $this->mail->Password = $_ENV['MAIL_PASSWORD'];
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $this->mail->Port = $_ENV['MAIL_PORT'];
        } catch (Exception $e) {
            echo "Error configuring the mail server: {$this->mail->ErrorInfo}";
        }
    }

    /**
     * Creates an email body with custom name and message.
     *
     * @param string $name The recipient's name.
     * @param string $message The content of the email.
     * @return string The email body (HTML).
     */
    public function create($name, $message)
    {
        $supportEmail = $_ENV['SUPPORT_EMAIL'];
        $body = "
            <!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <style>
                   body {
                        width: 100%;
                        margin: 0;
                        padding: 0;
                        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                        background-color: #f4f7fa;
                        color: #333;
                        line-height: 1.6;
                    }

                    .container {
                        width: 90%;
                        margin: 30px auto;
                        padding: 25px;
                        max-width: 650px;
                        border: 1px solid #e0e0e0;
                        border-radius: 12px;
                        background-color: #ffffff;
                        font-size: 16px;
                        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                    }

                    .header {
                        font-size: 22px;
                        color: #444;
                        font-weight: bold;
                        text-align: center;
                        padding: 15px;
                        padding-bottom: 25px;
                        border-bottom: 2px solid #e0e0e0;
                        border-radius: 12px 12px 0 0;
                    }

                    .content {
                        padding: 20px;
                        line-height: 1.8;
                        border-bottom: 1px solid #e0e0e0;
                        font-size: 16px;
                        color: #555;
                    }

                    .content p {
                        font-size: 16px;
                        color: #555;
                        line-height: 1.8;
                        margin-bottom: 15px;
                        text-align: left;
                    }

                    .content a {
                        color: #0066cc;
                        text-decoration: none;
                        font-weight: 600;
                        transition: color 0.3s ease, text-decoration 0.3s ease;
                    }

                    .content a:hover {
                        text-decoration: underline;
                        color: #005bb5;
                    }

                    .footer {
                        text-align: center;
                        line-height: 1.2;
                        margin-top: 25px;
                        font-size: 14px;
                        color: #777;
                    }

                    .footer a {
                        color: #0066cc;
                        text-decoration: none;
                        font-weight: bold;
                    }

                    .footer a:hover {
                        text-decoration: underline;
                    }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>Hello, $name.<br></div>
                    <div class='content'>$message</div>
                    <div class='footer'>
                        <p>This is an automated email, no need to reply.</p>
                        <p>If you need support, email us at <a href='mailto:$supportEmail'>$supportEmail</a> 📧.</p>
                    </div>
                </div>
            </body>
            </html>
        ";

        return $body;
    }

    /**
     * Sends the email using PHPMailer.
     *
     * @param string $toEmail The recipient's email address.
     * @param string $toName The recipient's name.
     * @param string $subject The subject of the email.
     * @param string $body The HTML body of the email.
     * @return array An array containing the success status and message.
     */
    public function send($toEmail, $toName, $subject, $body)
    {
        try {
            $this->mail->setFrom($_ENV['MAIL_FROM_ADDRESS'], $_ENV['MAIL_FROM_NAME']);
            $this->mail->addAddress($toEmail, $toName);

            $this->mail->isHTML(true);
            $this->mail->Subject = $subject;
            $this->mail->Body    = $body;
            $this->mail->CharSet = 'UTF-8';

            if ($this->mail->send()) {
                return ['success' => true, 'message' => 'Email sent successfully!'];
            } else {
                return ['success' => false, 'message' => 'Failed to send email.'];
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => "Error sending the email: {$this->mail->ErrorInfo}"];
        }
    }
}
