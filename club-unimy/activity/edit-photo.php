<!DOCTYPE html>
<html lang="en">

<head>
    <title>Club Activity Edit Info</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/index.css">

    <SCRIPT language=JavaScript>
    </script>
</head>

<style>
.form-input {
    width: 70%;
    margin-left: 10px;
    border-radius: 5px;
}

.panel-body-form {
    padding: 15px;
    padding-left: 25%;
    font-size: 15px;

}

.b {
    padding-left: 30%;
    padding-top: 10%;
}

.no {
    padding-left: 80px;
}

.info {
    padding-left: 5%;
    font-size: 19px;
    font-family: arial;
}

#dt {
    text-indent: -500px;
    height: 25px;
    width: 200px;
}
</style>

<body>
    <?php

    include('../config-mysqli.php');

    $club_id = $_GET['club_id'];
    $sql = "SELECT * FROM club_activity WHERE club_type='photo' ORDER BY club_id ASC";
    $cari = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($cari);
?>

    <div class="container" style="margin-top: 20px">
        <div class="col-lg-12">
            <div class="panel panel-default">

                <div class="panel-body-form">

                    <form role="form" action="update-esport.php" method="post">
                        <br>
                        <h3>Photography Club</h3>
                        <br><br>
                        <div class="">

                            <div class="form-group">
                                <label for="Name"
                                    class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">Image</label>
                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                    <input type="text" value="<?php echo $row['club_image'];?>" name="clubimage"
                                        id="Applicant_name" class="form-control input" required>
                                </div>
                            </div>
                        </div>
                        <br><br>
                        <div class="">

                            <div class="form-group">
                                <label for="Name" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">Club Content</label>
                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                    <textarea rows="4" cols="50" type="text" value="<?php echo $row['club_content'];?>"
                                        name="clubcontent" id="Applicant_name" class="form-control input"
                                        required><?php echo $row['club_content'];?></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <br><br><br><br>
                        <div class="">

                            <div class="form-group">
                                <label for="Name" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">Club Activity</label>
                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                    <textarea rows="4" cols="50" type="text" value="<?php echo $row['club_content_2'];?>"
                                        name="clubcontent2" id="Applicant_name" class="form-control input"
                                        required><?php echo $row['club_content_2'];?></textarea>
                                </div>
                            </div>
                        </div>
                        <br><br><br><br><br>
                        <div class="">
                            <div class="form-group">
                                <label for="I/C" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">Club Date
                                    </label>
                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                    <input type="date" value="<?php echo $row['club_date'];?>" name="clubdate"
                                        class="form-control input" required>
                                </div>
                            </div>
                        </div>
                        <br><br><br>
                        <div class="form-group">
                                <label for="Name"
                                    class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">Club Time</label>
                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                    <input type="text" value="<?php echo $row['club_time'];?>" name="clubtime"
                                        id="Applicant_name" class="form-control input" required>
                                </div>
                            </div>
                            <br><br>
                        <div class="form-group">
                                <label for="Name"
                                    class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">Contact Number</label>
                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                    <input type="text" value="<?php echo $row['club_contact'];?>" name="clubcontact"
                                        id="Applicant_name" class="form-control input" required>
                                </div>
                            </div>
                            <br><br>
                        <div class="form-group">
                                <label for="Name"
                                    class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label">Leader Club Name</label>
                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                    <input type="text" value="<?php echo $row['club_name'];?>" name="clubname"
                                        id="Applicant_name" class="form-control input" required>
                                </div>
                            </div>

                        <div class="">

                            <div class="form-group">
                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                                    <input type="hidden" value="<?php echo $row['club_id'];?>" name="clubid1"
                                        id="company_name" class="form-control" >
                                   
                                </div>

                            </div>

                        </div>

                        <div class="panel-body">
                            <div class="row">
                                <div class="b">
                                    <button name="submit" type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</body>

</html>