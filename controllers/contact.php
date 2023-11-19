
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


$servername="localhost";
$username="root";
$password="";
$dbname="appointment";


$conn=new mysqli($servername,$username,$password,$dbname);

if($conn->connect_error){
    echo "connection failed";
}

if(isset($_POST["submit"])){


$name=mysqli_real_escape_string($conn,$_POST["name"]);
$email=mysqli_real_escape_string($conn,$_POST["email"]);
$subject=mysqli_real_escape_string($conn,$_POST["subject"]);
$message=mysqli_real_escape_string($conn,$_POST["message"]);


//Load Composer's autoloader
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';


  $name=$_POST["name"];
  $email=$_POST["email"];
  $subject=$_POST["subject"];
  $message=$_POST["message"];




//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                        //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'muhammadnawaz110002@gmail.com';         //SMTP username
    $mail->Password   = 'nafycyjyukkrbvcu';                       //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS ;        //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('muhammadnawaz110002@gmail.com');
    $mail->addAddress($email, $name);     //Add a recipient


    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Appointment';
    $mail->Body    = 'Name : '.$name.'<br> email : '.$email.'<br>subject : '.$subject.'<br> Message : '.$message;
  

    $mail->send();
    ?><script>alert("Mail has been sent");
    document.location.href="index.php";</script>
    <?php
} catch (Exception $e) {
    console.log($e);
    ?><script>alert("Error In sending Message");
    document.location.href="../index.php";</script>
    <?php
}

    }else{
        ?><script>alert("Try later");
        document.location.href="../index.php";</script>
        <?php
    }

$conn->close();

?>