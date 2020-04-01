<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer extends Model
{
    public static function sendEmail($order = null, $email = null) {

        require 'vendor/autoload.php';// load Composer's autoloader

        $mail = new PHPMailer(true);                            // Passing `true` enables exceptions

        // Server settings
        $mail->SMTPDebug = 0;                                	// Enable verbose debug output
        $mail->isSMTP();                                     	// Set mailer to use SMTP
        $mail->Host = env('MAIL_HOST');						// Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                              	// Enable SMTP authentication
        $mail->Username = env('MAIL_USERNAME');             // SMTP username
        $mail->Password = env('MAIL_PASSWORD');              // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom(env('MAIL_USERNAME'), 'Mailer');
        $mail->addAddress($email, 'Optional name');	// Add a recipient, Name is optional
        $mail->addReplyTo(env('MAIL_USERNAME'), 'Mailer');
        // $mail->addCC('his-her-email@gmail.com');
        // $mail->addBCC('his-her-email@gmail.com');

        //Attachments (optional)
        // $mail->addAttachment('/var/tmp/file.tar.gz');			// Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');	// Optional name

        //Content
        $mail->isHTML(true); 																	// Set email format to HTML
        $mail->Subject = 'Tagihan Pembayaran';
        $mail->Body = "<html>
        <head>
        <title></title>
        </head>
        <body>                
        
        <h2 style='width:50%;height:40px; text-align:center;margin:0px;padding-left:390px;color:#000000;'>Tagihan Pembayaran</h2>
        <div style='width:50%;text-align:left;margin:0px;padding-left:390px;color:#000000;'> Booking ID:" . $order->orderCode ." </div>
        <h4 style='color:#ea6512;margin-top:-20px;'> Hello, " . $order->name ."
        </h4>
        <p style='color:#000000;'>Terimakasih telah berbelanja di Anterin Sayur mohon lakukan pembayaran sebesar </p>
        <hr/>
        <div style='height:210px;'>                                
        <table cellspacing='0' width='100%' style='padding-left:300px;'>
        <thead>                                                                       
        <tr>                                        
        <th style='color:#0A903B;text-align:right;padding-bottom:5px;width:70%'>Total Harga : </th>
        <th style='color:#000000;text-align:left;padding-bottom:5px;padding-left:10px;width:30%'>" .$order->totalPrice."</th>
        </tr>
        <tr>                                        
        <th style='color:#0A903B;text-align:right;padding-bottom:5px;'>Total Diskon : </th>
        <th style='color:#000000;text-align:left;padding-bottom:5px;padding-left:10px;'>" .$order->totalDiscount."</th>                                        
        </tr>
        <tr>                                        
        <th style='color:#0A903B;text-align:right;'>Total Pembarayan : </th>
        <th style='color:#000000;text-align:left;padding-bottom:5px;padding-left:10px;'>" .$order->totalPayment."</th>                                        
        </tr>
        </thead>   
        </table>             
          <p style='color:#000000;'>Jika telah melakuka pembayaran mohon konfirmasi dengan mengirim bukti bayar ke 
          <a href='https://api.whatsapp.com/send?phone=6281321678718&text=Saya20%ingin20%konfirmassi20%pembayaran20%untuk20%order20%".$order->orderCode."'>
          Konfirmasi Pembayaran
          </a>
          </p>
        </div> 
        </div>              
        </body>
        </html>";				// message

        if ($mail->Send()) {
            return 'Email Sended Successfully';
        } else {
            return 'Failed to Send Email';
        }   
    }
}
