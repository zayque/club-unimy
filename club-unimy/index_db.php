<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendorphpmailer/autoload.php';

$mail = new PHPMailer(true);
	
if (isset($_POST['submit'])) {
	
	include_once 'config-mysqli.php';


	$name1= mysqli_real_escape_string($conn, $_POST['name1']);
	$idstudent1= mysqli_real_escape_string($conn, $_POST['idstudent1']);
	$email1 = mysqli_real_escape_string($conn, $_POST['email1']);
	$notel1= mysqli_real_escape_string($conn, $_POST['notel1']);
	$iduser1= mysqli_real_escape_string($conn, $_POST['iduser1']);
	// $chk= mysqli_real_escape_string($conn, $_POST['chk']);

	// check user
	$verify_userid =  mysqli_query($conn,"SELECT count(*) AS 'Total' FROM user WHERE studentid_user = '".$idstudent1."' OR email_user = '".$email1."'");
	$f_verify_userid = mysqli_fetch_array($verify_userid);

	//echo "<script>alert('".$f_verify_userid['Total']."');</script>";

	if($f_verify_userid['Total'] > 0){
		echo "<script>window.location='club-form.php?msg=duplicate';</script>";
	}else{
		$checkbox1=$_POST['check'];  
		$chk="";  	
	
			foreach ($checkbox1 as $chk1){  
				$chk .= $chk1.",";  
			}  
	
			if ($resultCheck > 1) {
				header("Location: club-form.php?club-form=usertaken");
				exit();
			} 		
			else{
				$sql=mysqli_query($conn,"insert into user
					(name_user,studentid_user,email_user,phone_user,id_user,club_user) 
					values 
					('$name1','$idstudent1','$email1','$notel1','$iduser1','$chk')"); 

					$body1 =  mysqli_query($conn,"select * from email ORDER BY id_email ASC");
					$body1 = mysqli_fetch_array($body1);
					$subject1 =  mysqli_query($conn,"select * from email ORDER BY id_email ASC");
					$subject1 = mysqli_fetch_array($subject1);
					$altbody1 =  mysqli_query($conn,"select * from email ORDER BY id_email ASC");
					$altbody1 = mysqli_fetch_array($altbody1);


					echo "<script>window.location='display.php';</script>";
				

							$mail->SMTPDebug = 2;                                 // Enable verbose debug output
							$mail->isSMTP();                                      // Set mailer to use SMTP
							$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
							$mail->SMTPAuth = true;                               // Enable SMTP authentication
							$mail->Username = 'akmalhafizyakuza@gmail.com';                 // SMTP username
							$mail->Password = 'Akmalhafiz321';                           // SMTP password
							$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
							$mail->Port = 587;                                    // TCP port to connect to

							//Recipients
							$mail->setFrom('unimyclub@gmail.com', 'UNIMY CLUB');
							$mail->addAddress($email1);     // Add a recipient

							$a= $body1['body_email'];
							$b= $subject1['subject_email'];
							$c= $altbody1['altbody_email'];

							//Content
							$mail->isHTML(true);                                  // Set email format to HTML
							$mail->Subject = $b;
							$mail->Body    = $a;
							$mail->AltBody = $c;

							$mail->send();
							echo 'Message has been sent';
					
						exit;
							
			}
	}


	
				
			
}




?>