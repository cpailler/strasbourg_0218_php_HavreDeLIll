<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 11/03/18
 * Time: 16:07
 */

namespace Controller;

use Controller\Calendar\Month;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Controller\Calendar\Reservation;
use Model\ReservationManager;

/**
 * Class ReservationController
 * @package Controller
 */
class GestionMailController extends AbstractController
{


    public function envoiMail()
    {
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
            $mail->CharSet = 'UTF-8';
            $mail->SMTPDebug = 2;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'f.olivier.wilder@gmail.com';                 // SMTP username
            $mail->Password = 'olivierwild67 ';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom('f.olivier.wilder@gmail.com', 'Mailer');
            $mail->addAddress('f.olivier.wilder@gmail.com', 'Havre de l Ill');     // Add a recipient
            //$mail->addReplyTo($_POST['mail'], 'Information');

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Message de '.$_POST['nom'].' '.$_POST['prenom'];
            $mail->Body    = 'Message utilisateur '.$_POST['message'];
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            echo 'Message envoyer';
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }
    }

    public function envoiMailValidation($resa)
    {
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions

        //Server settings
        $mail->CharSet = 'UTF-8';
        $mail->SMTPDebug = 2;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'f.olivier.wilder@gmail.com';                 // SMTP username
        $mail->Password = 'olivierwild67 ';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom('f.olivier.wilder@gmail.com', 'Mailer');
        $mail->addAddress($resa['mailClient'], $resa['nomClient']);     // Add a recipient
        //$mail->addReplyTo($_POST['mail'], 'Information');

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Confirmation de votre réservation au Havre de l\'Ill';
        $mail->Body    = 'Votre réservation au Havre de l\'Ill du '.$resa['dateDebut'].' au '.$resa['dateFin'].' a été confirmée par le propriétaire';
        $mail->AltBody = 'Votre réservation au Havre de l\'Ill du '.$resa['dateDebut'].' au '.$resa['dateFin'].' a été confirmée par le propriétaire';

        return $mail->send(header('Location:/Administration/ReservationsEnAttente'));

    }

    public function envoiMailRefus($resa)
    {
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions

        //Server settings
        $mail->CharSet = 'UTF-8';
        $mail->SMTPDebug = 2;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'f.olivier.wilder@gmail.com';                 // SMTP username
        $mail->Password = 'olivierwild67 ';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom('f.olivier.wilder@gmail.com', 'Mailer');
        $mail->addAddress($resa['mailClient'], $resa['nomClient']);     // Add a recipient
        //$mail->addReplyTo($_POST['mail'], 'Information');

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Refus de votre réservation au Havre de l\'Ill';
        $mail->Body    = 'Votre réservation au Havre de l\'Ill du '.$resa['dateDebut'].' au '.$resa['dateFin'].' a été refusée par le propriétaire.';
        $mail->AltBody = 'Votre réservation au Havre de l\'Ill du '.$resa['dateDebut'].' au '.$resa['dateFin'].' a été refusée par le propriétaire.';

        return $mail->send(header('Location:/Administration/ReservationsEnAttente'));

    }

}
