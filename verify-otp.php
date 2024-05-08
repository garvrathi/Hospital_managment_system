<!DOCTYPE html> 
<html lang="en"> 
<?php
session_start();
require 'C:\xampp_2\htdocs\phpmailer\PHPMailer\src\Exception.php';
require 'C:\xampp_2\htdocs\phpmailer\PHPMailer\src\PHPMailer.php';
require 'C:\xampp_2\htdocs\phpmailer\PHPMailer\src\SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(isset($_POST['patsub1'])) {
    $otp1 = $_POST['otp']; // OTP entered by the user
    $otp2 = $_SESSION["OTP"]; // OTP stored in the session
    
    if ($otp1 == $otp2) {
        // OTP matched, proceed with form submission and database insertion
        
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $gender = $_POST['gender'];
        $email = $_POST['email'];
        $contact = $_POST['contact'];
        // $password = $_POST['password'];
        // $cpassword = $_POST['cpassword'];
        
        // Insert the data into the database
        
            $query = "INSERT INTO patreg (fname, lname, gender, email, contact, password, cpassword) VALUES ('$fname', '$lname', '$gender', '$email', '$contact', '$password', '$cpassword')";
            $result = mysqli_query($con, $query);
            
            if ($result) {
                // Store user data in session
                $_SESSION['username'] = $fname . " " . $lname;
                $_SESSION['fname'] = $fname;
                $_SESSION['lname'] = $lname;
                $_SESSION['gender'] = $gender;
                $_SESSION['contact'] = $contact;
                $_SESSION['email'] = $email;
                
                // Redirect to admin panel or any other page
                header("Location: admin-panel.php");
                exit;
            } else {
                // Failed to insert data into the database
                header("Location: error.php");
                exit;
            }
        }
    } else {
        // OTP does not match
        header("Location: error2.php");
        exit;
    }

?>

	<?php 
		session_start(); 
	    require 'C:\xampp_2\htdocs\phpmailer\PHPMailer\src\Exception.php';
require 'C:\xampp_2\htdocs\phpmailer\PHPMailer\src\PHPMailer.php';
require 'C:\xampp_2\htdocs\phpmailer\PHPMailer\src\SMTP.php';
            



if($_SERVER["REQUEST_METHOD"]=="POST"){
    $otp=$_SESSION["OTP"]; 
    $con = mysqli_connect("localhost", "root", "", "myhmsdb");
    if(!$con) 
            echo ("failed to connect to database"); 
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
          
    // Generate OTP
    $otp = generateOTP();
    $mailSent = sendOTP($email, $otp, $fname, $lname);

  if ($mailSent) {
      // Store the OTP in the session for verification later
      $_SESSION['otp'] = $otp;
      $_SESSION['fname'] = $fname;
      $_SESSION['lname'] = $lname;
      $_SESSION['gender'] = $gender;
      $_SESSION['contact'] = $contact;
      $_SESSION['email'] = $email;

      // Enable the OTP field and the "verify otp" button
      echo json_encode(array('success' => true));
      header("Location:verify-otp.php");
  } else {
      // Failed to send email
      echo json_encode(array('success' => false));
  }
            
}
function generateOTP() {
    return mt_rand(100000, 999999);
}


function sendOTP($to, $otp, $fname, $lname) {
  $mail = new PHPMailer(true);

  try {
      //Server settings
      $mail->isSMTP();
      $mail->Host       = 'smtp.gmail.com';
      $mail->SMTPAuth   = true;
      $mail->Username   = 'ananyasarkarlks@gmail.com'; // Your Gmail address
      $mail->Password   = 'kdsvmepiitgyxkaj';   // Your Gmail password
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
      $mail->Port       = 587;

      //Recipients
      $mail->setFrom('your-email@gmail.com', 'ananya');
      $mail->addAddress($to, $fname . ' ' . $lname);

      // Content
      $mail->isHTML(true);
      $mail->Subject = 'Your OTP for Registration';
      $mail->Body    = '
          <p>Dear ' . $fname . ' ' . $lname . ',</p>
          <p>Thanks for signing up. Your verification ID and token are given below:</p>
          <p>' . $otp . '</p>
          <p><strong>This is an automatically generated email. Please do not reply.</strong></p>
          <p>Regards,</p>
      ';

      $mail->send();
      return true; // Email sent successfully
  } catch (Exception $e) {
      return false; // Failed to send email
  }
} 
	?> 

<head> 
	<meta charset="UTF-8"> 
	<meta http-equiv="X-UA-Compatible" content="IE=edge"> 
	<meta name="viewport" content= 
		"width=device-width, initial-scale=1.0"> 
	<title>verification</title> 
	<link rel="stylesheet" type="text/css"
		href="css/style.css" media="screen" /> 

	
	
	</script> 
	
	
	
	
	<div class="nav-bar"> 
		<div class="title"> 
			<h3>welcome , please enter your otp below:</h3> 
		</div> 
	</div> 
</head> 

<body> 
	<form class="form-login" method="POST" > 
		<div class="form-group"> 
			<input type="text" class="form-control"
				name="otp" id="OTP"
				aria-describedby="emailHelp"
				placeholder="Enter OTP" required> 
		</div> 

		<button type="button"
			class="btn btn-primary btn-lg"
			
			id="inputbtn" name="patsub" > 
			verify otp 
		</button> 
		<button type="submit"
			class="btn btn-primary btn-lg"
			id="resend-otp"
			name="sendOTP"> 
			resend otp 
		</button> 
	</form> 

	<script> 
		// $("#resend-otp").click(function () { 
		// 	window.location.replace("resend-otp.php"); 
		// }); 
		$("#inputbtn").click(function () { 

			// window.location.replace("index.php"); 
			var otp1 = document.getElementById("OTP").value; 
			console.log(otp1);
			// alert(otp1); 
			
			var otp2 = ("<?php session_start(); $otp=$_SESSION["OTP"]; echo($otp)?>"); 
			
			// alert(otp2); 
			if (otp1 == otp2) { 
				// 
				//window.location.replace("admin-panel.php"); 
				console.log("otp matched")

			} 
			else { 
				alert("otp not matches") 
			} 
		}); 
	</script> 
    
</body> 

</html>
