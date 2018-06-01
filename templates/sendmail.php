<?php
 // Send mail to everyone from the city with the problem
    // Import PHPMailer classes into the global namespace
    // These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    //Load Composer's autoloader
    require '../vendor/autoload.php';


    $db = mysqli_connect ("golar3.go.ro", "tw", "59885236", "CriC");
    
    if (!$db) {
        die ("Connection failed: " . mysqli_connect_error());
    }

    $query = "SELECT mail, oras FROM signup;";
    $result = mysqli_query ($db, $query);

    $nume = str_replace("+", " ", $argv[1]);
    $prenume = str_replace("+", " ", $argv[2]);
    $address = str_replace("+", " ", $argv[3]);
    $sesizari = str_replace("+", " ", $argv[4]);
    $descriere = str_replace("+", " ", $argv[5]);
    if (count($argv) == 7)
        $image .= str_replace("+", " ", $argv[6]);

    if (mysqli_num_rows ($result) > 0)  {
        //Server settings
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        //$mail->SMTPDebug = 2;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'crisis.containment@gmail.com';                 // SMTP username
        $mail->Password = 'crisis123';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom('crisis.containment@gmail.com', 'Crisis Containment Service');
        $mail->addAddress('newsletter@crisis.com');     // Add a recipient

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        

        //Attachments
        if (count($argv) == 7)
            $mail->addAttachment($image);         // Add attachments

        while ($row = mysqli_fetch_assoc ($result)){

            $oras = $row["oras"];
            $email = $row["mail"];
            $i = 0;

            if($oras !== NULL && $oras !== '' && strpos(strtolower($address), strtolower($oras)) !== false) {
                if ($i == 0) {
                    $mail->Subject = "Eveniment recent ce a avut loc in $oras";
                    $mail->Body    = "Un eveniment nou a avut loc in <b>$oras</b>.<br>Nume: <b>$nume</b><br>Prenume: <b>$prenume</b><br>Adresa: <b>$address</b><br>Sesizari: <b>$sesizari</b><br>Descriere: <b>$descriere</b>";
                    $mail->AltBody = "Un eveniment nou a avut loc in $oras.\nNume: $nume\nPrenume: $prenume\nAdresa: $address\nSesizari: $sesizari\nDescriere: $descriere";
                    $i = $i + 1;
                }
                try {
                    $mail->AddBCC($email);
                    //$mail->ClearAllRecipients();
                    //echo 'Message has been sent';
                } catch (Exception $e) {
                    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
                }
            }
        }

        $mail->send();
    }


?>