<?php
session_start();
	require 'config-mysqli.php';
?>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>UNIMY</title>
    <link rel="icon" type="image/ico" href="img/logo2.png" />
    <!-- Bootstrap core CSS-->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom fonts for this template-->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- Page level plugin CSS-->
    <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">
    <link href="css/style-club.css" type="text/css" rel="stylesheet" />
    <link href="css/style-slider.css" type="text/css" rel="stylesheet" />

</head>

<style>
.login-display {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 500px;
    height: auto;
    padding: 40px;
    padding-bottom: 10px;
    padding-top: 20px;
    transform: translate(-50%, -50%);
    background: rgb(255, 255, 255);
    box-sizing: border-box;
    /* box-shadow: 0 15px 25px rgba(255, 255, 255, 0.6); */
    border-radius: 10px;
}
</style>


<body class="container-form">
    <br>


    <div class="login-display">
      <center>
        <h2> 
          <img src="img/unimy.jpg" style="width:150px; border-radius:10px; margin-bottom:10px;">
            <br> Club Registration System
        </h2>
        <br>
  
        <form role="form" action="" method="post" enctype="multipart/form-data">
            <div class="user-box">
                <b>Thank You for joining us!</b>
            </div>
        </center>
            <br>
            <!-- <div class="user-box">
                <label>
                    Name: <?php echo strtoupper ($row['name_user']);?>
                </label>
            </div>
            <br>
            <div class="user-box">
                <label>
                    Student Id: <?php echo strtoupper ($row['studentid_user']);?>
                </label>
            </div>
            <br>
            <div class="user-box">
                <label>
                    Email: <?php echo $row['email_user'];?>
                </label>
            </div>
            <br>
            <div class="user-box">
                <label>
                    Phone Number: <?php echo $row['phone_user'];?>
                </label>
            </div>
            <br>
            <div class="user-box">
                <label>
                    Club: <?php echo $row['club_user'];?>
                </label>
            </div> -->
            <br>
        </form>
    
    </div>



</body>

</html>