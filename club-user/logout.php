<?php
        session_start();
        if(session_destroy()) // Destroying All Sessions 
        {
        header("Location: loginUser.php"); // Redirecting To Home Page
        }
?>