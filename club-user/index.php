<?php 
    // Include database connection
    include('session.php');
    if(!isset($_SESSION['login_user'])){
        header("location: loginUser.php"); // Redirecting To Home Page
    }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>UNIMY CLUB</title>
    <link rel="icon" type="image/png" href="img/unimy.jpg" />

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600" />
    <!-- https://fonts.google.com/specimen/Open+Sans -->
    <link rel="stylesheet" href="css/all.min.css" />
    <!-- https://fontawesome.com/ -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <!-- https://getbootstrap.com/ -->
    <link rel="stylesheet" href="css/tooplate-style.css" />
    <!--
Tooplate 2111 Pro Line
http://www.tooplate.com/view/2111-pro-line
-->
    <?php
        if(isset($_SESSION['login_msg']) && $_SESSION['login_msg'] != ""){
            echo '<script> alert("' . $_SESSION['login_msg'] . '"); </script>';
        }
    ?>
</head>

<body>

    <!-- page header -->
    <div class="container" id="home">
        <div class="col-12 text-center">
            <div class="tm-page-header">
                <i class="fas fa-4x fa-desktop mr-4"></i>
                <h1 class="d-inline-block text-uppercase">Unimy Club</h1>
            </div>
        </div>
    </div>
    <!-- navbar -->
    <div class="tm-nav-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="navbar navbar-expand-md navbar-light">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#tmMainNav"
                            aria-controls="tmMainNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="tmMainNav">
                            <ul class="navbar-nav mx-auto tm-navbar-nav">
                                <li class="nav-item active">
                                    <a class="nav-link" href="#home">Home <span class="sr-only">(current)</span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#features">Information</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#activities">Activities</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#company">Club</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#contact">Contact</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link external" href="https://www.unimy.edu.my/">UniMy</a>
                                </li>
                                <li class="nav-item"><a class="nav-link external" href="logout.php"
                                        style="color:red; text-transform: uppercase;">Logout</a></li>

                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Video Banner -->
    <section class="tm-banner-section" id="tmVideoSection">
        <div class="container tm-banner-text-container">
            <div class="row">
                <div class="col-12">
                    <header>
                        <h2 class="tm-banner-title">University Malaysia of Computer Science & Engineering</h2>
                        <!-- <p class="mx-auto tm-banner-subtitle">
                            The video background has a parallax effect. This is fluid and
                            full-width.
                        </p> -->
                    </header>
                </div>
            </div>
        </div>

        <!-- Video -->
        <video id="hero-vid" autoplay="" loop="" muted>
            <source src="videos/city-night-blur-01.mp4" type="video/mp4" />
            Your browser does not support the video tag.
        </video>
    </section>
    <!-- Features -->
    <div class="container tm-features-section" id="features">
        <div class="row">
            <div class="col-12">
                <div class="tm-parallax">
                    <header class="tm-parallax-header">
                        <h2 class="">Student Information</h2>
                    </header>
                </div>
            </div>
        </div>
        <div class="row tm-features-row">
            <section class="col-md-6 col-sm-12 tm-feature-block">
                <header class="tm-feature-header">
                    <i class="fas fa-5x fa-anchor tm-feature-icon"></i>
                    <h3 class="tm-feature-h">Details Information</h3>
                </header>

                <table>
                    <tr>
                        <td style="border:1px solid black"><a style="color:Black; font-size:24px">&nbsp Name
                                &nbsp</a></td>
                        <td style="border:1px solid black"><a style="color:Blue; font-size:21px">&nbsp
                                <?php echo $username_session; ?> &nbsp</a></td>
                    </tr>
                    <tr>
                        <td style="border:1px solid black"><a style="color:Black; font-size:24px">&nbsp
                                Student Id &nbsp</a></td>
                        <td style="border:1px solid black"><a style="color:Blue; font-size:21px">&nbsp
                                <?php echo $studentid_session; ?> &nbsp</a></td>
                    </tr>
                    <tr>
                        <td style="border:1px solid black"><a style="color:Black; font-size:24px">&nbsp Student Email
                                &nbsp</a></td>
                        <td style="border:1px solid black"><a style="color:Blue; font-size:21px">&nbsp
                                <?php echo $email_session; ?>
                                &nbsp</a></td>
                    </tr>
                    <tr>
                        <td style="border:1px solid black"><a style="color:Black; font-size:24px">&nbsp
                                Phone No. &nbsp</a></td>
                        <td style="border:1px solid black"><a style="color:Blue; font-size:21px">&nbsp
                                <?php echo $contact_session; ?> &nbsp</a></td>
                    </tr>

                </table>
            </section>
            <section class="col-md-6 col-sm-12 tm-feature-block">
                <header class="tm-feature-header">
                    <i class="fas fa-5x fa-atom tm-feature-icon"></i>
                    <h3 class="tm-feature-h">Club Registered</h3>
                </header>
                <tr>
                    <td style="border:1px solid black"><a style="color:Black; font-size:24px">
                            List Club &nbsp</a></td>
                    <td style="border:1px solid black"><a style="color:Blue; font-size:21px">&nbsp
                            <li><?php echo $club_session; ?></li>
                        </a></td>
                </tr>
            </section>
        </div>
    </div>

    <hr>

    <!-- Activities -->


    <div class="container" id="activities">
        <div class="row">
            <div class="col-12">
                <div class="tm-parallax">
                    <header class="tm-parallax-header">
                        <h2 class="">Club Activities</h2>
                    </header>
                </div>
            </div>
        </div>

        <div class="row">
            <?php
            
            $query = "SELECT * FROM club_activity WHERE club_type='esport' ORDER BY club_id ASC ";
            $result = mysqli_query($conn,$query);

            ?>

            <?php while($row = mysqli_fetch_array($result)){?>
            <div class="col-lg-6">
                <div class="tm-activity-block">
                    <div class="tm-activity-img-container">
                        <img src="<?php echo $row['club_image'];?>" alt="Image" class="tm-activity-img" style="width:180px;height:180;" />
                    </div>
                    <div class="tm-activity-block-text">
                        <h3 class="tm-text-blue">E-Sports Club</h3>
                        <p class="text-content">
                            <?php echo $row['club_content'];?>
                        </p>
                        <h4 class="tm-text-blue"> Activities</h4>
                        <p class="text-content-2">
                            <?php echo $row['club_content_2'];?>
                        </p>
                        <h4 class="tm-text-blue"> Meeting</h4>
                        <p class="text-content-2">
                            Date: <?php echo $new_date = date('d-m-Y', strtotime($row['club_date']));?>
                            <br>
                            Time: <?php echo $row['club_time'];?>

                        </p>
                        <h4 class="tm-text-blue"> Contact</h4>
                        <p class="text-content-2">
                            <?php echo $row['club_name'];?>, <?php echo $row['club_contact'];?>
                        </p>
                    </div>
                </div>
            </div>
            <?php } ?>

            <?php
            
            $query = "SELECT * FROM club_activity WHERE club_type='cyber' ORDER BY club_id ASC ";
            $result = mysqli_query($conn,$query);

            ?>

            <?php while($row = mysqli_fetch_array($result)){?>
            <div class="col-lg-6">
                <div class="tm-activity-block">
                    <div class="tm-activity-img-container">
                        <img src="<?php echo $row['club_image'];?>" alt="Image" class="tm-activity-img" style="width:180px;height:180;" />
                    </div>
                    <div class="tm-activity-block-text">
                        <h3 class="tm-text-blue">Cybersecurity Club</h3>
                        <p class="text-content">
                            <?php echo $row['club_content'];?>
                        </p>
                        <h4 class="tm-text-blue"> Activities</h4>
                        <p class="text-content-2">
                            <?php echo $row['club_content_2'];?>
                        </p>
                        <h4 class="tm-text-blue"> Meeting</h4>
                        <p class="text-content-2">
                            Date: <?php echo $new_date = date('d-m-Y', strtotime($row['club_date']));?>
                            <br>
                            Time: <?php echo $row['club_time'];?>
                        </p>
                        <h4 class="tm-text-blue"> Contact</h4>
                        <p class="text-content-2">
                            <?php echo $row['club_name'];?>, <?php echo $row['club_contact'];?>
                        </p>
                    </div>
                </div>
            </div>
            <?php } ?>
            <?php
            
            $query = "SELECT * FROM club_activity WHERE club_type='photo' ORDER BY club_id ASC ";
            $result = mysqli_query($conn,$query) ;

            ?>

            <?php while($row = mysqli_fetch_array($result)){?>
            <div class="col-lg-6">
                <div class="tm-activity-block">
                    <div class="tm-activity-img-container">
                        <img src="<?php echo $row['club_image'];?>" alt="Image" class="tm-activity-img" style="width:180px;height:180;" />
                    </div>
                    <div class="tm-activity-block-text">
                        <h3 class="tm-text-blue">Photography Club</h3>
                        <p class="text-content">
                            <?php echo $row['club_content'];?>
                        </p>
                        <h4 class="tm-text-blue"> Activities</h4>
                        <p class="text-content-2">
                            <?php echo $row['club_content_2'];?>
                        </p>
                        <h4 class="tm-text-blue"> Meeting</h4>
                        <p class="text-content-2">
                            Date: <?php echo $new_date = date('d-m-Y', strtotime($row['club_date']));?>
                            <br>
                            Time: <?php echo $row['club_time'];?>
                        </p>
                        <h4 class="tm-text-blue"> Contact</h4>
                        <p class="text-content-2">
                            <?php echo $row['club_name'];?>, <?php echo $row['club_contact'];?>
                        </p>
                    </div>
                </div>
            </div>
            <?php } ?>
            <?php
            
            $query = "SELECT * FROM club_activity WHERE club_type='japan' ORDER BY club_id ASC ";
            $result = mysqli_query($conn,$query);

            ?>

            <?php while($row = mysqli_fetch_array($result)){?>
            <div class="col-lg-6">
                <div class="tm-activity-block">
                    <div class="tm-activity-img-container">
                        <img src="<?php echo $row['club_image'];?>" alt="Image" class="tm-activity-img" style="width:180px;height:180;" />
                    </div>
                    <div class="tm-activity-block-text">
                        <h3 class="tm-text-blue">Japananime Society</h3>
                        <p class="text-content">
                            <?php echo $row['club_content'];?>
                        </p>
                        <h4 class="tm-text-blue"> Activities</h4>
                        <p class="text-content-2">
                            <?php echo $row['club_content_2'];?>
                        </p>
                        <h4 class="tm-text-blue"> Meeting</h4>
                        <p class="text-content-2">
                            Date: <?php echo $new_date = date('d-m-Y', strtotime($row['club_date']));?>
                            <br>
                            Time: <?php echo $row['club_time'];?>
                        </p>
                        <h4 class="tm-text-blue"> Contact</h4>
                        <p class="text-content-2">
                            <?php echo $row['club_name'];?>, <?php echo $row['club_contact'];?>
                        </p>
                    </div>
                </div>
            </div>
            <?php } ?>
            <?php
            
            $query = "SELECT * FROM club_activity WHERE club_type='advent' ORDER BY club_id ASC ";
            $result = mysqli_query($conn,$query);

            ?>

            <?php while($row = mysqli_fetch_array($result)){?>
            <div class="col-lg-6">
                <div class="tm-activity-block">
                    <div class="tm-activity-img-container">
                        <img src="<?php echo $row['club_image'];?>" alt="Image" class="tm-activity-img" style="width:180px;height:180;" />
                    </div>
                    <div class="tm-activity-block-text">
                        <h3 class="tm-text-blue">Adventurous Recreational Club</h3>
                        <p class="text-content">
                            <?php echo $row['club_content'];?>
                        </p>
                        <h4 class="tm-text-blue"> Activities</h4>
                        <p class="text-content-2">
                            <?php echo $row['club_content_2'];?>
                        </p>
                        <h4 class="tm-text-blue"> Meeting</h4>
                        <p class="text-content-2">
                            Date: <?php echo $new_date = date('d-m-Y', strtotime($row['club_date']));?>
                            <br>
                            Time: <?php echo $row['club_time'];?>
                        </p>
                        <h4 class="tm-text-blue"> Contact</h4>
                        <p class="text-content-2">
                            <?php echo $row['club_name'];?>, <?php echo $row['club_contact'];?>
                        </p>
                    </div>
                </div>
            </div>
            <?php } ?>
            <?php
            
            $query = "SELECT * FROM club_activity WHERE club_type='music' ORDER BY club_id ASC ";
            $result = mysqli_query($conn,$query);

            ?>

            <?php while($row = mysqli_fetch_array($result)){?>
            <div class="col-lg-6">
                <div class="tm-activity-block">
                    <div class="tm-activity-img-container">
                        <img src="<?php echo $row['club_image'];?>" alt="Image" class="tm-activity-img" style="width:180px;height:180;" />
                    </div>
                    <div class="tm-activity-block-text">
                        <h3 class="tm-text-blue">Music Club</h3>
                        <p class="text-content">
                            <?php echo $row['club_content'];?>
                        </p>
                        <h4 class="tm-text-blue"> Activities</h4>
                        <p class="text-content-2">
                            <?php echo $row['club_content_2'];?>
                        </p>
                        <h4 class="tm-text-blue"> Meeting</h4>
                        <p class="text-content-2">
                            Date: <?php echo $new_date = date('d-m-Y', strtotime($row['club_date']));?>
                            <br>
                            Time: <?php echo $row['club_time'];?>
                        </p>
                        <h4 class="tm-text-blue"> Contact</h4>
                        <p class="text-content-2">
                            <?php echo $row['club_name'];?>, <?php echo $row['club_contact'];?>
                        </p>
                    </div>
                </div>
            </div>
            <?php } ?>
            <?php
            
            $query = "SELECT * FROM club_activity WHERE club_type='biztech' ORDER BY club_id ASC ";
            $result = mysqli_query($conn,$query);

            ?>

            <?php while($row = mysqli_fetch_array($result)){?>
            <div class="col-lg-6">
                <div class="tm-activity-block">
                    <div class="tm-activity-img-container">
                        <img src="<?php echo $row['club_image'];?>" alt="Image" class="tm-activity-img" style="width:180px;height:180;" />
                    </div>
                    <div class="tm-activity-block-text">
                        <h3 class="tm-text-blue">Biztech Club</h3>
                        <p class="text-content">
                            <?php echo $row['club_content'];?>
                        </p>
                        <h4 class="tm-text-blue"> Activities</h4>
                        <p class="text-content-2">
                            <?php echo $row['club_content_2'];?>
                        </p>
                        <h4 class="tm-text-blue"> Meeting</h4>
                        <p class="text-content-2">
                            Date: <?php echo $new_date = date('d-m-Y', strtotime($row['club_date']));?>
                            <br>
                            Time: <?php echo $row['club_time'];?>
                        </p>
                        <h4 class="tm-text-blue"> Contact</h4>
                        <p class="text-content-2">
                            <?php echo $row['club_name'];?>, <?php echo $row['club_contact'];?>
                        </p>
                    </div>
                </div>
            </div>
            <?php } ?>
            <?php
            
            $query = "SELECT * FROM club_activity WHERE club_type='inge' ORDER BY club_id ASC ";
            $result = mysqli_query($conn,$query);

            ?>

            <?php while($row = mysqli_fetch_array($result)){?>
            <div class="col-lg-6">
                <div class="tm-activity-block">
                    <div class="tm-activity-img-container">
                        <img src="<?php echo $row['club_image'];?>" alt="Image" class="tm-activity-img" style="width:180px;height:180;" />
                    </div>
                    <div class="tm-activity-block-text">
                        <h3 class="tm-text-blue">Ingenieurs Club</h3>
                        <p class="text-content">
                            <?php echo $row['club_content'];?>
                        </p>
                        <h4 class="tm-text-blue"> Activities</h4>
                        <p class="text-content-2">
                            <?php echo $row['club_content_2'];?>
                        </p>
                        <h4 class="tm-text-blue"> Meeting</h4>
                        <p class="text-content-2">
                            Date: <?php echo $new_date = date('d-m-Y', strtotime($row['club_date']));?>
                            <br>
                            Time: <?php echo $row['club_time'];?>
                        </p>
                        <h4 class="tm-text-blue"> Contact</h4>
                        <p class="text-content-2">
                            <?php echo $row['club_name'];?>, <?php echo $row['club_contact'];?>
                        </p>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>

    <hr>

    <section class="container tm-company-section" id="company">
        <div class="row">
            <div class="col-xl-9 col-lg-8 col-md-12 tm-company-left">
                <div class="tm-company-about">
                    <div class="tm-company-img-container">
                        <img src="img/img-05.jpg" alt="Image" />
                    </div>
                    <div class="tm-company-about-text">
                        <header>
                            <h2 class="tm-company-about-header">About Us</h2>
                        </header>
                        <p>
                            The UNIMY community is driven by a shared purpose: to create a better future through
                            technology, education, research and innovation. We are made of creative and inventive people
                            who know how to enjoy life yet find the improvements that need to occur, using our
                            imagination to create things to improve people’s lives overall.
                        </p>
                        <p class="mb-4">
                            Our motto is The Future Begins at UNIMY signifying the forward-looking nature of using
                            technology for advancing human kind.
                        </p>

                        <!-- <a href="#" class="btn tm-btn tm-float-right">Read More</a> -->
                    </div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-4 col-md-12 tm-company-right  ml-lg-auto mr-lg-0">
                <div class="tm-company-right-inner">
                    <ul class="nav nav-tabs" id="tmCompanyTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link tm-nav-link-border-right active" id="vision-tab" data-toggle="tab"
                                href="#vision" role="tab" aria-controls="vision" aria-selected="true">Vision</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link tm-no-border-right" id="mission-tab" data-toggle="tab" href="#mission"
                                role="tab" aria-controls="mission" aria-selected="false">Mission</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="tmTabContent">
                        <div class="tab-pane fade show active" id="vision" role="tabpanel" aria-labelledby="vision-tab">
                            <p>
                                To be a preeminent digital technology university.
                            </p>

                        </div>
                        <div class="tab-pane fade" id="mission" role="tabpanel" aria-labelledby="mission-tab">
                            <p>
                                To develop highly sought-after graduates in a vibrant digital-centric environment that
                                promotes innovation and breakthrough solutions using accelerating digital technologies.
                            </p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <br><br>
    <hr>
    <!-- Contact -->
    <section class="container tm-contact-section" id="contact">
        <div class="row">
            <div class="col-xl-5 col-lg-6 col-md-12 tm-contact-left">
                <div class="tm-contact-form-container ml-auto mr-0">
                    <header>
                        <h2 class="tm-contact-header">Contact Us</h2>
                    </header>
                    <!-- <form action="index.html" class="tm-contact-form" method="POST"> -->
                    <div class="form-group">
                        <a style="color:blue; font-size:20px;">Phone Number: </a> +6 017-6768937
                        <br><br>
                        <a style="color:blue;font-size:20px;"> Email:</a> enquiry@unimy.edu.my
                    </div>
                    <!-- <div class="form-group">
                        <a class="form-control"> Email: unimy@gmail.com</a>
                    </div> -->
                    <!-- <div class="form-group">
                            <textarea rows="5" id="contact_message" name="contact_message" class="form-control"
                                placeholder="Message" required></textarea>
                        </div>
                        <div class="tm-text-right">
                            <button type="submit" class="btn tm-btn tm-btn-big">
                                Send It
                            </button>
                        </div> -->
                    <!-- </form> -->
                </div>
            </div>
            <div class="col-xl-7 col-lg-6 col-md-12 tm-contact-right">
                <div class="tm-contact-figure-block">
                    <figure class="d-inline-block">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63756.410690434896!2d101.67307600494124!3d2.8809540353037932!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cdb701bb00b453%3A0xc4d06be31fdd1a5!2sUniversity%20Malaysia%20of%20Computer%20Science%20%26%20Engineering%20(UNIMY)!5e0!3m2!1sms!2smy!4v1624190620289!5m2!1sms!2smy"
                            width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                        <figcaption class="tm-contact-figcaption">
                            <b>University Malaysia of Computer Science & Engineering (UNIMY)</b><br>Block 12, Star
                            Central,
                            Lingkaran Cyber Point Timur, 63000 Cyberjaya, Selangor.
                        </figcaption>
                    </figure>
                </div>
            </div>
        </div>
    </section>
    <footer class="container tm-footer">
        <div class="row tm-footer-row">
            <p class="col-md-10 col-sm-12 mb-0">
                Copyright &copy; UNIMY
            </p>
            <div class="col-md-2 col-sm-12 scrolltop">
                <div class="scroll icon"><i class="fa fa-4x fa-angle-up"></i></div>
            </div>
        </div>
    </footer>

    <script src="js/jquery-1.9.1.min.js"></script>
    <!-- Single Page Nav plugin works with this version of jQuery -->
    <script src="js/jquery.singlePageNav.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
    /**
     * detect IE
     * returns version of IE or false, if browser is not Internet Explorer
     */
    function detectIE() {
        var ua = window.navigator.userAgent;

        var msie = ua.indexOf("MSIE ");
        if (msie > 0) {
            // IE 10 or older => return version number
            return parseInt(ua.substring(msie + 5, ua.indexOf(".", msie)), 10);
        }

        var trident = ua.indexOf("Trident/");
        if (trident > 0) {
            // IE 11 => return version number
            var rv = ua.indexOf("rv:");
            return parseInt(ua.substring(rv + 3, ua.indexOf(".", rv)), 10);
        }

        // var edge = ua.indexOf('Edge/');
        // if (edge > 0) {
        //     // Edge (IE 12+) => return version number
        //     return parseInt(ua.substring(edge + 5, ua.indexOf('.', edge)), 10);
        // }

        // other browser
        return false;
    }

    function setVideoHeight() {
        const videoRatio = 1920 / 1080;
        const minVideoWidth = 400 * videoRatio;
        let secWidth = 0,
            secHeight = 0;

        secWidth = videoSec.width();
        secHeight = videoSec.height();

        secHeight = secWidth / 2.13;

        if (secHeight > 600) {
            secHeight = 600;
        } else if (secHeight < 400) {
            secHeight = 400;
        }

        if (secWidth > minVideoWidth) {
            $("video").width(secWidth);
        } else {
            $("video").width(minVideoWidth);
        }

        videoSec.height(secHeight);
    }

    // Parallax function
    // https://codepen.io/roborich/pen/wpAsm
    var background_image_parallax = function($object, multiplier) {
        multiplier = typeof multiplier !== "undefined" ? multiplier : 0.5;
        multiplier = 1 - multiplier;
        var $doc = $(document);
        $object.css({
            "background-attatchment": "fixed"
        });
        $(window).scroll(function() {
            var from_top = $doc.scrollTop(),
                bg_css = "center " + multiplier * from_top + "px";
            $object.css({
                "background-position": bg_css
            });
        });
    };

    $(window).scroll(function() {
        if ($(this).scrollTop() > 50) {
            $(".scrolltop:hidden")
                .stop(true, true)
                .fadeIn();
        } else {
            $(".scrolltop")
                .stop(true, true)
                .fadeOut();
        }

        // Make sticky header
        if ($(this).scrollTop() > 158) {
            $(".tm-nav-section").addClass("sticky");
        } else {
            $(".tm-nav-section").removeClass("sticky");
        }
    });

    let videoSec;

    $(function() {

        if (detectIE()) {
            alert(
                "Please use the latest version of Edge, Chrome, or Firefox for best browsing experience."
            );
        }

        const mainNav = $("#tmMainNav");
        mainNav.singlePageNav({
            filter: ":not(.external)",
            offset: $(".tm-nav-section").outerHeight(),
            updateHash: true,
            beforeStart: function() {
                mainNav.removeClass("show");
            }
        });

        videoSec = $("#tmVideoSection");

        // Adjust height of video when window is resized
        $(window).resize(function() {
            setVideoHeight();
        });

        setVideoHeight();

        $(window).on("load scroll resize", function() {
            var scrolled = $(this).scrollTop();
            var vidHeight = $("#hero-vid").height();
            var offset = vidHeight * 0.6;
            var scrollSpeed = 0.25;
            var windowWidth = window.innerWidth;

            if (windowWidth < 768) {
                scrollSpeed = 0.1;
                offset = vidHeight * 0.5;
            }

            $("#hero-vid").css(
                "transform",
                "translate3d(-50%, " + -(offset + scrolled * scrollSpeed) + "px, 0)"
            ); // parallax (25% scroll rate)
            
        });

        // Parallax image background
        background_image_parallax($(".tm-parallax"), 0.4);

        // Back to top
        $(".scroll").click(function() {
            $("html,body").animate({
                    scrollTop: $("#home").offset().top
                },
                "1000"
            );
            return false;
        });
    });
    </script>
</body>

</html>