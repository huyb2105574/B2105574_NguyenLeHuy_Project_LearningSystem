<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailService
{
    public function sendEmail($to, $subject, $body)
    {
        $mail = new PHPMailer(true);
        try {
            // Cấu hình SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // SMTP của Gmail
            $mail->SMTPAuth = true;
            $mail->Username = 'nlhuy2003@gmail.com'; // Địa chỉ email của bạn
            $mail->Password = 'ukqi urol mxbv pibv'; // Mật khẩu ứng dụng email của bạn
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Người gửi
            $mail->setFrom('nlhuy2003@gmail.com', 'Learning System');

            // Người nhận
            $mail->addAddress($to);

            // Nội dung email
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;

            // Gửi email
            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Email không gửi được. Lỗi: {$mail->ErrorInfo}");
            return false;
        }
    }
}
