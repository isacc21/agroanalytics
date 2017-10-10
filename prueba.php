<?php 

require 'resources/mail/mailer/PHPMailerAutoload.php';

$mail = new PHPMailer;
			$mail->isSMTP();                                      // Set mailer to use SMTP
			$mail->Host = 'mail.agroanalytics.mx';  // Specify main and backup SMTP servers$mail->SMTPAuth = true;                               
			$mail->SMTPAuth = true; // Enable SMTP authentication
			$mail->Username = 'infogop@agroanalytics.mx';                 // SMTP username
			$mail->Password = 'sistemasDOS*2017';                           // SMTP password
			$mail->SMTPSecure = 'starttls';                            // Enable TLS encryption, `ssl` also accepted
			$mail->Port = 587;                                    // TCP port to connect to

			$mail->setFrom('infogop@agroanalytics.mx', 'Agroanalytics');
			$mail->addAddress('isacc.loz.mon21@gmail.com', 'Destinatario');     // Add a recipient
			//$mail->addAddress('isacc.loz.mon21@gmail.com');               // Name is optional
			$mail->addReplyTo('isacc.loz.mon21@gmail.com', 'Information');
			//$mail->addCC('isacc.loz.mon21@outlook.es');
			$mail->addBCC('');
			$mail->addAttachment('');         // Add attachments
			$mail->addAttachment('');    // Optional name
			$mail->isHTML(true);                                  // Set email format to HTML
			$mail->Subject = utf8_decode('Nofiticación Agroanalytics');
			$mail->Body    = 'Prueba de cron exitosa';
			$mail->AltBody = '';

			if(!$mail->send()) {
				echo 'Message could not be sent.';
				echo 'Mailer Error: ' . $mail->ErrorInfo;
			} else {
				//echo 'Message has been sent';
			}
			?>