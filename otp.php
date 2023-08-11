<html>
    <body>
        <?php
            $receiver= $_POST['email'];
            $rad=(rand(1111,9999));
            $sender="avaghamkar@gmail.com";
           // $receiver="thecovenant01@gmail.com";

            use PHPMailer\PHPMailer\PHPMailer;
            use PHPMailer\PHPMailer\SMTP;
            use PHPMailer\PHPMailer\Exception;
            
            require_once __DIR__ . '\phpmailer\src\Exception.php';
            require_once __DIR__ . '\phpmailer\src\PHPMailer.php';
            require_once __DIR__ . '\phpmailer\src\SMTP.php';
            
            // passing true in constructor enables exceptions in PHPMailer
            $mail = new PHPMailer(true);
            
            try {
                // Server settings
                //$mail->SMTPDebug = SMTP::DEBUG_SERVER; // for detailed debug output
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = "ssl";
                $mail->Port = 465;
            


                $mail->Username = 'avaghamkar@gmail.com'; // YOUR gmail email
                $mail->Password = 'ftiowvyizralhdad'; // YOUR gmail password

                // Sender and recipient settings


                $mail->setFrom("{$sender}", 'OTP Generator');
                $mail->addAddress("{$receiver}", '');
                //$mail->addReplyTo('avaghamkar@gmail.com', 'OTP from AJz'); // to set the reply to
            
                // Setting the email content
                $mail->IsHTML(true);
                $mail->Subject = "OTP";
                $mail->Body = "OTP is {$rad} ";
                //$mail->AltBody = 'Plain text message body for non-HTML email client. Gmail SMTP email body.';
            
                $mail->send();
                echo "Email message sent.";
            } catch (Exception $e) {
                //echo "Error in sending email. Mailer Error: {$mail->ErrorInfo}";
            }


            $conn = mysqli_connect("localhost", "root", "root", "test");
            // Check the connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            echo "Connected successfully\n";

            $sql1 = "DELETE FROM otp;";

            if (mysqli_query($conn, $sql1)) {
                echo "\n New record created successfully";
            } else {
                echo "Error: " . $sql1 . "<br>" . mysqli_error($conn);
            }

            mysqli_close($conn);

            $tz = 'Asia/Kolkata';
            $timestamp = time();
            $dt = new DateTime("now", new DateTimeZone($tz)); //first argument "must" be a string
            $dt->setTimestamp($timestamp); //adjust the object to correct timestamp
            $dt=$dt->format('Y-m_d H:i:s');


            $conn = mysqli_connect("localhost", "root", "root", "test");
            // Check the connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            echo "Connected successfully\n";

            $sql2 = "INSERT INTO otp (email, otp, timestp) VALUES('$receiver','$rad','$dt');";
            if (mysqli_query($conn, $sql2)) {
                echo "\n New record created successfully";
            } else {
                echo "Error: " . $sql2 . "<br>" . mysqli_error($conn);
            }

           mysqli_close($conn);


            //Redirect to html
            header("Location: /login.html");
            exit();
        ?>
    </body>
</html>