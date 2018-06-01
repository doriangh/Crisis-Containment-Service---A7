<?php
    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    //Load Composer's autoloader
    require '../vendor/autoload.php';

    $db = mysqli_connect ("golar3.go.ro", "tw", "59885236", "CriC");
    
    if (!$db) {
        die ("Connection failed: " . mysqli_connect_error());
    } 
//    else {
//        echo('Success');
//    }


    if (isset($_POST['sign-up'])) {

        $email = htmlspecialchars($_POST['email']);
        $oras = htmlspecialchars($_POST['oras']);
        
    
    }

    $sql = "INSERT INTO signup(mail, oras) VALUES ('$email', '$oras')";

    mysqli_query ($db, $sql);

    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    try {
        //Server settings
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'crisis.containment@gmail.com';                 // SMTP username
        $mail->Password = 'crisis123';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom('crisis.containment@gmail.com', 'Crisis Containment Service');
        $mail->addAddress($email);     // Add a recipient

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = "Abonare la newsletter";
        $mail->Body    = "V-ati abonat cu succes la newsletter-ul site-ului !<br>Orasul dumneavoastra este: <b>$oras</b>";
        $mail->AltBody = "V-ati abonat cu succes la newsletter-ul site-ului !\nOrasul dumneavoastra este: $oras";

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }

    header ('Location: ../index.php');


?>
