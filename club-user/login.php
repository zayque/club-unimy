<?php
        session_start(); // Starting Session
        $error = ''; // Variable To Store Error Message

        if (isset($_POST['submit'])) {

                if (empty($_POST['email_user']) || empty($_POST['studentid_user'])) {
                        $error = "Email or Password is invalid";
                }

                else{

                        // Define $username and $password
                        $email_user = $_POST['email_user'];
                        $studentid_user = $_POST['studentid_user'];
                        $student_name;

                        // mysqli_connect() function opens a new connection to the MySQL server.
                        $conn = mysqli_connect("localhost", "root", "", "clubunimy");

                        // SQL query to fetch information of registerd users and finds user match.
                        $query = "SELECT email_user, studentid_user, name_user from user where email_user=? AND studentid_user=? LIMIT 1";

                        // To protect MySQL injection for Security purpose
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param("ss", $email_user, $studentid_user);
                        $stmt->execute();
                        $stmt->bind_result($email_user, $studentid_user, $student_name);
                        $stmt->store_result();
                        
                        if($stmt->num_rows > 0){
                                $f_stmt = $stmt->fetch();
                                $_SESSION['login_user'] = $email_user; // Initializing Session

                                $_SESSION['login_msg'] = 'Welcome ' . $student_name . ' to UNIMY Club!';
                                echo '<script> windows.location="index.php";</script>';
                                // header("Location: index.php"); // Redirecting To Profile Page
                        }else{
                                $_SESSION['login_msg'] = "Email or Password is invalid!";
                                //echo "<scriptalert('".$_SESSION['login_msg']."');></script>";
                                echo '<script> windows.location="loginUser.php";</script>';
                                // header("Location: loginUser.php");
                        }
                }
                
        }
?>