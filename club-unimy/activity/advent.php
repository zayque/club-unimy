<?php
    include('../includes/core.php')

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Club Info</title>
    <meta charset="utf-8">
    <link rel="icon" type="image/ico" href="../img/unimy.jpg" />

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/index.css">

    <SCRIPT language=JavaScript>
    </script>
</head>

<style>
.form-input {
    width: 50%;
    margin-left: 10px;
    border-radius: 5px;
}

.panel-body-form {
    padding: 4em;
    font-size: 15px;
}

.email-box{
    width:80%;
    border:1px solid rgb(211,211,211);
    border-radius:5px;
    padding:1em 1.5em;
}
.dropbtn {
    /* background-color: rgba(255, 255, 128, .5); */
    color: black;
    padding: 10px;
    font-size: 15px;
    border: none;
    cursor: pointer;
}

.dropbtn:hover,
.dropbtn:focus {
    background-color: #66a3ff;
}

.dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f1f1f1;
    min-width: 160px;
    overflow: auto;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
    z-index: 1;
}

.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

.dropdown a:hover {
    background-color: #ddd;
}

.show {
    display: block;
}
</style>

<body>

    <div class="container" style="margin-top: 20px; border: 1px solid rgb(221,221,221); border-radius:4px; ">
        <center>
            <h2>Club Activity Info</h2>
        </center>

        <div class="col-lg-12">
        <div class="dropdown">
                <button onclick="myFunction()" class="dropbtn">List Club</button>
                <div id="myDropdown" class="dropdown-content">
                    <a href="esport.php">E-Sport Club</a>
                    <a href="cyber.php">Cybersecurity Club</a>
                    <a href="photo.php">Photography Club</a>
                    <a href="japan.php">Japananime Society</a>
                    <a href="advent.php">Adventurous Recreational Club</a>
                    <a href="music.php">Music Club</a>
                    <a href="biztech.php">Biztech Club</a>
                    <a href="inge.php">Ingenieurs Club</a>
                </div>
            </div>
            <div class="panel panel-default">

                <div class="panel-body-form">
                    <h3>Adventurous Recreational Club</h3>
                    <hr>
                    <?php
 
                require '../config-mysqli.php';

                $query = "SELECT * FROM club_activity WHERE club_type='advent' ORDER BY club_id ASC";
                $result = mysqli_query($conn,$query);

                ?>
                    <?php while($row = mysqli_fetch_array($result)){?>
                    <div class="form-group">
                        <label for="Name" class="control-label"><b>Image</b></label>
                        <div class="email-box">
                            <?php echo $row['club_image'];?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Name" class="control-label"><b>Club Content</b></label>
                        <div class="email-box">
                            <?php echo $row['club_content'];?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Name" class="control-label"><b> Club Activity </b></label>
                        <div class="email-box">
                            <?php echo $row['club_content_2'];?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Name" class="control-label"><b> Club Date </b></label>
                        <div class="email-box">
                            <?php echo $row['club_date'];?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Name" class="control-label"><b> Club Time </b></label>
                        <div class="email-box">
                            <?php echo $row['club_time'];?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Name" class="control-label"><b> Contact Number </b></label>
                        <div class="email-box">
                            <?php echo $row['club_contact'];?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Name" class="control-label"><b> Leader Club Name</b></label>
                        <div class="email-box">
                            <?php echo $row['club_name'];?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div style="float:right; padding-right: 20%;">
                            <a href="edit-advent.php?club_id=<?php echo $row['club_id'];?>"><button
                                    class="btn btn-success">Update</button></a>
                            <a href="../dashboard.php"><button class="btn btn-primary">Back</button></a>
                        </div>
                        
                    </div>


                    <?php } ?>



                </div>
            </div>
        </div>


    </div>
    <script>
    /* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

    // Close the dropdown if the user clicks outside of it
    window.onclick = function(event) {
        if (!event.target.matches('.dropbtn')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            var i;
            for (i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }
    </script>

</body>

</html>