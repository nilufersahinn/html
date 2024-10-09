<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $secret = 'YOUR_SECRET_KEY';
    $response = $_POST['g-recaptcha-response'];
    $remoteip = $_SERVER['REMOTE_ADDR'];

    $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$remoteip";
    $responseKeys = json_decode(file_get_contents($url), true);

    if (intval($responseKeys["success"]) !== 1) {
        echo 'Please complete the reCAPTCHA verification.';
    } else {
        // Form verilerini işleyin
        $firstName = htmlspecialchars($_POST['first-name']);
        $lastName = htmlspecialchars($_POST['last-name']);
        $email = htmlspecialchars($_POST['email']);
        $message = htmlspecialchars($_POST['message']);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { //control email
            echo 'Invalid email format';
            exit;
        }
         // E-posta ayarları
         $to = "nilufer66sahin@gmail.com";  // Buraya kendi e-posta adresinizi girin
         $subject = "New Contact Form Submission from $firstName $lastName";
         $body = "Name: $firstName $lastName\n";
         $body .= "Email: $email\n";
         $body .= "Message:\n$message\n";
 
         $headers = "From: $email" . "\r\n" .
                    "Reply-To: $email" . "\r\n" .
                    "X-Mailer: PHP/" . phpversion();
 
         // E-posta gönderme ve kullanıcıya mesaj gösterme
         if (mail($to, $subject, $body, $headers)) {
             echo '<script>alert("Your message has been sent successfully!"); window.location.href = "contact.html";</script>';
         } else {
             echo 'Sorry, there was an error sending your message. Please try again later.';
         }
        }
    }

?>
