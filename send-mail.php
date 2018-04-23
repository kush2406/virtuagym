<?php 
$to_email = trim($_POST['to']);
if($to_email == "")
    die("User Email not specified");
$subject = 'Your Workout Plan';
$message = $_POST['content'];
$headers = "From: kush2406@gmail.com \r\n";
$headers .= "Reply-To: plan-workout@virtuagym.com\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
$headers .= "X-Priority: 3\r\n";
$headers .= "X-Mailer: PHP". phpversion() ."\r\n" ;
mail($to_email,$subject,$message,$headers);
echo "Mail Sent!";
exit;
?>