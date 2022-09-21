<?php
        // mysqli_connect() function opens a new connection to the MySQL server.
        $conn = mysqli_connect("localhost", "root", "", "clubunimy");

        session_start();// Starting Session

        // Storing Session
        $user_check = $_SESSION['login_user'];

        // SQL Query To Fetch Complete Information Of User
        $query = "SELECT * from user where email_user = '$user_check'";
        $ses_sql = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($ses_sql);
        $studentid_session = $row['studentid_user'];
        $username_session = $row['name_user'];
        $email_session = $row['email_user'];
        $contact_session = $row['phone_user'];
        $club_session = $row['club_user'];



?>