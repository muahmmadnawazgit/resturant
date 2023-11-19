<?php
session_start();


//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;



$servername="localhost";
$username="root";
$password="";
$dbname="resturant";


$conn=new mysqli($servername,$username,$password,$dbname);

if($conn->connect_error){
    echo "connection failed";
}

if(isset($_POST["submit"])){

    $name=mysqli_real_escape_string($conn,$_POST["name"]);
    $email=mysqli_real_escape_string($conn,$_POST["email"]);
    $date=mysqli_real_escape_string($conn,$_POST["date"]);
    $people=mysqli_real_escape_string($conn,$_POST["people"]);
    $message=mysqli_real_escape_string($conn,$_POST["message"]);
    

    $emailquery="SELECT * FROM reservation WHERE email='$email'";
    $emailcount=mysqli_query($conn,$emailquery);

    $count=mysqli_num_rows($emailcount);

if($count > 0){
    ?><script>alert("Reserved Already");
    document.location.href="index.php";</script>
    <?php

}else{




    $db="INSERT INTO reservation(name,email,date,people,message)
    VALUES('$name','$email','$date','$people','$message')";

    if($conn->query($db)===TRUE){
       




require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';



// //Load Composer's autoloader
// require 'vendor/autoload.php';


//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
//Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'muhammadnawaz110002@gmail.com';         //SMTP username
    $mail->Password   = 'nafycyjyukkrbvcu';                                //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('muhammadnawaz110002@gmail.com');
    $mail->addAddress($email, $name);     //Add a recipient



    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'For Reservation';
    $mail->Body    = 'Name : '.$name.'<br> email : '.$email.'<br>phone : '.$date.'<br> people : '.$people.'<br> Message : '.$message;
  

    $mail->send();
    ?><script>
    alert('Reservation SuccessFull We will contact you Soon');
    document.location.href="../index.php";
    </script>
    <?php

} catch (Exception $e) {
    ?><script>alert("Error In sending Message");
    document.location.href="../index.php";</script>
    <?php
}
    }
}
}

$conn->close();

?>
