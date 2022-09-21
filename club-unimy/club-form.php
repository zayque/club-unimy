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
    <link rel="icon" type="image/ico" href="img/unimy.jpg" />
    <!-- Bootstrap core CSS-->
    <!-- <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"> -->
    <!-- Custom fonts for this template-->
    <!-- <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"> -->
    <!-- Page level plugin CSS-->
    <!-- <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet"> -->
    <!-- Custom styles for this template-->
    <!-- <link href="css/sb-admin.css" rel="stylesheet"> -->
    <link href="css/style-club.css" type="text/css" rel="stylesheet" />
    <link href="css/style-slider.css" type="text/css" rel="stylesheet" />

</head>

<body class="container-form">
    <!-- Slideshow container -->
    <div class="slideshow-container">

        <!-- Full-width images with number and caption text -->
        <div class="mySlides fade">
            <img src="img/UNIMY Clubs May21 Sem_page-0001.jpg" class="center-img">
        </div>

        <div class="mySlides fade">
            <img src="img/UNIMY Clubs May21 Sem_page-0002.jpg" class="center-img">
        </div>

        <div class="mySlides fade">
            <img src="img/UNIMY Clubs May21 Sem_page-0004.jpg" class="center-img">
        </div>

        <div class="mySlides fade">
            <img src="img/UNIMY Clubs May21 Sem_page-0005.jpg" class="center-img">
        </div>

        <div class="mySlides fade">
            <img src="img/UNIMY Clubs May21 Sem_page-0006.jpg" class="center-img">
        </div>

        <div class="mySlides fade">
            <img src="img/UNIMY Clubs May21 Sem_page-0007.jpg" class="center-img">
        </div>

        <div class="mySlides fade">
            <img src="img/UNIMY Clubs May21 Sem_page-0008.jpg" class="center-img">
        </div>

        <div class="mySlides fade">
            <img src="img/UNIMY Clubs May21 Sem_page-0009.jpg" class="center-img">
        </div>

        <!-- Next and previous buttons -->
        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>
    </div>
    <br>

    <div class="login-box">
        <h2>
            <img src="img/unimy.jpg" style="width:150px; border-radius:10px; margin-bottom:10px;">
            <br> Registration Club
        </h2>
        <?php        
				include_once 'config-mysqli.php';
				
		        $sql="SELECT COUNT(*) AS bilangan from user";
		        $stmt = $conn->prepare($sql);
		        $stmt->execute();
		        $res = $stmt->get_result();
				$user = $res->fetch_array(MYSQLI_ASSOC);
				
				$limit2 =  mysqli_query($conn,"select * from limitseminar ORDER BY id_limit2 ASC");
				$limit2 = mysqli_fetch_array($limit2);
				
				$a= $limit2['jumlah_limit2'];
				$b= $limit2['mesej_limit2'];

		        if ($user['bilangan'] < $a) {
					
				} else {
					echo'<script>alert("'.$b.'")</script>';	
				};
		    ?>


        <form role="form" action="index_db.php" method="post" enctype="multipart/form-data">
            <div class="user-box">
                <input type="hidden" name="iduser1" required="">
                <input type="text" name="name1" required="">
                <label>Full Name</label>
            </div>
            <div class="user-box">
                <input type="text" name="idstudent1" required="" maxlength="10">
                <label>Student ID</label>
            </div>
            <div class="user-box">
                <input type="text" name="email1" required="">
                <label>Student Email</label>
            </div>
            <div class="user-box">
                <input type="text" name="notel1" required="" maxlength="11">
                <label>Phone Number</label>
            </div>
            <div>
                Interested Club
                <br><br>
                <div class="check-box">
                    <input type="checkbox" id="myCheck" name="check[]" value="E-Sports">
                    <label for=""> E-Sports Club</label><br><br>
                    <input type="checkbox" id="myCheck" name="check[]" value="Cybersecurity">
                    <label for=""> Cybersecurity Club</label><br><br>
                    <input type="checkbox" id="myCheck" name="check[]" value="Photography">
                    <label for=""> Photography Crew</label><br><br>
                    <input type="checkbox" id="myCheck" name="check[]" value="Japananime">
                    <label for=""> Japananime Society</label><br><br>
                    <input type="checkbox" id="myCheck" name="check[]" value="Adventurous Recreational">
                    <label for=""> Adventurous Recreational Club</label><br><br>
                    <input type="checkbox" id="myCheck" name="check[]" value="Music">
                    <label for=""> Music Club</label><br><br>
                    <input type="checkbox" id="myCheck" name="check[]" value="BizTech">
                    <label for=""> BizTech Club</label>
                    <div class="label-chk">Compulsory for diploma and business students</div><br>
                    <input type="checkbox" id="myCheck" name="check[]" value="Ingenieurs">
                    <label for=""> Ingenieurs Club</label>
                    <div class="label-chk">Engineering students only</div>
                </div>
            </div>
            <center>
                <a>
                    <button name="submit" type="submit" style="border:0px;background-color:transparent;color:red;">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <b>Submit</b>
                    </button>
                </a>
            </center>
        </form>
    </div>

</body>

<script>
var slideIndex = 1;
showSlides(slideIndex);

// Next/previous controls
function plusSlides(n) {
    showSlides(slideIndex += n);
}

// Thumbnail image controls
function currentSlide(n) {
    showSlides(slideIndex = n);
}

function showSlides(n) {
    var i;
    var slides = document.getElementsByClassName("mySlides");
    var dots = document.getElementsByClassName("dot");
    if (n > slides.length) {
        slideIndex = 1
    }
    if (n < 1) {
        slideIndex = slides.length
    }
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[slideIndex - 1].style.display = "block";

}

function checkBox() {
    var x = document.getElementById("myCheck").required;
}

function duplicate(){
    alert('Student ID / Email already exist!');
}

</script>

<?php
    if(isset($_GET['msg'])){
        echo "<script> setTimeout(duplicate, 500); </script>";
    }
?>

</html>