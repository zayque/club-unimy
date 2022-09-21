<?php
    include('includes/core.php')

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Form Info</title>
    <link rel="icon" type="image/ico" href="img/unimy.jpg" />
    <!-- Bootstrap core CSS-->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom fonts for this template-->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- Page level plugin CSS-->
    <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">
    <link href="style.css" type="text/css" rel="stylesheet" />

    <script type="text/javascript">
    window.history.forward();

    function noBack() {
        window.history.forward();
    }
    </script>

</head>
<style type="text/css">
.table {
    font-size: 14px;
    font-family: Arial;
}

.container-form {
    width: 90%;
    padding-left: 10%;
}

.search-form {
    padding-bottom: 15px;
}

.search {
    border-radius: 5px;
}

.pagination {
    list-style-type: none;
    padding: 10px 0;
    float: right;
    display: inline-flex;
    justify-content: space-between;
    box-sizing: border-box;
}

.pagination li {
    box-sizing: border-box;
    padding-right: 10px;
}

.pagination li a {
    box-sizing: border-box;
    background-color: #e2e6e6;
    padding: 8px;
    text-decoration: none;
    font-size: 12px;
    font-weight: bold;
    color: #616872;
    border-radius: 4px;
}

.pagination li a:hover {
    background-color: #d4dada;
}

.pagination .next a,
.pagination .prev a {
    text-transform: uppercase;
    font-size: 12px;
}

.pagination .currentpage a {
    background-color: #518acb;
    color: #fff;
}

.pagination .currentpage a:hover {
    background-color: #518acb;
}

.content-chart {

    padding-left: 6%;
}

.form-group {
    margin: 2em !important;
}

.btn-latihan {
    margin: 1em;

}
</style>

<body class="fixed-nav sticky-footer bg-dark" id="page-top" onload="noBack();"
    onpageshow="if (event.persisted) noBack();" onunload="">
    <!-- Navigation-->
    <?php include('includes/nav.php'); ?>
    <!-- End Navigation-->

    <div class="content-wrapper">
        <div class="container-fluid">
            <br>
            <marquee>
                <H4>WELCOME TO ADMIN PANEL CLUB</H4>
            </marquee>
            <!-- Breadcrumbs-->
            <div id="dashboard">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" style="color: black">
                        <h4>Form Info</h4>
                    </li>
                </ol>
            </div>

            <div id="Approve_Request">
                <div class="container-form">
                    <div class="card mb-4">
                        <div class="title">




                            <?php
 
                                  require 'config-mysqli.php';

                                  $query = "SELECT * FROM limitseminar ORDER BY id_limit2 ASC";
                                  $result = mysqli_query($conn,$query) or die(mysqli_error());

                                ?>
                            <?php while($row = mysqli_fetch_array($result)){?>

                            <!-- <div class="form-group">
                                    <label for="Name" class="col-lg-5 col-md-5 col-sm-5 col-xs-5 control-label"><b>
                                            Maklumat Latihan </b> : <?php //echo $row['maklumat_detail'];?></label>
                                    <br>
                                    <label for="Name" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label"><b> Zon
                                        </b> : <?php //echo $row['maklumat_zon'];?></label>
                                    <br>
                                    <label for="Name" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label"><b>
                                            Negeri </b> : <?php //echo $row['maklumat_negeri'];?></label>
                                    <br>
                                    <label for="Name" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label"><b>
                                            Tarikh </b> : <?php //echo $row['maklumat_tarikh'];?></label>
                                    <br>
                                    <label for="Name" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label"><b> Hari
                                        </b> : <?php //echo $row['maklumat_hari'];?></label>
                                    <br>
                                    <label for="Name" class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label"><b> Masa
                                        </b> : <?php //echo $row['maklumat_masa'];?></label>
                                    <br>
                                    <label for="Name" class="col-lg-2 col-md-2 col-sm-2 col-xs-2 control-label"><b>
                                            Tempat </b> : </label>
                                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                        <?php //echo $row['maklumat_tempat'];?>
                                        <?php //echo $row['maklumat_tempat4'];?>
                                        <?php //echo $row['maklumat_tempat3'];?>

                                    </div><br>
                                    <a href="editmaklumat.php?maklumat_id=<?php //echo $row['maklumat_id'];?>"><button
                                            class="btn btn-success">Kemaskini</button></a>
                                    <a href="boranglatihan.php"><button class="btn btn-success">Borang</button></a>
                                    <br><br>
                                    <label for="Name" class="col-lg-5 col-md-5 col-sm-5 col-xs-5 control-label"><b>
                                            Limit Latihan </b> : <?php //echo $row['jumlah_limit'];?></label>
                                    <br>
                                    <a href="editlimitlatihan.php?id_limit=<?php //echo $row['id_limit'];?>"><button
                                            class="btn btn-success">Kemaskini</button></a>

                                </div> -->



                            <!-- <div class="form-group">
                                <label for="Name" class="col-lg-7 col-md-12 col-sm-12 col-xs-12  control-label"><b>
                                        Maklumat Seminar </b> : <?php echo $row['maklumat_detail2'];?></label>
                                <br>
                                <label for="Name" class="col-lg-7 col-md-12 col-sm-12 col-xs-12  control-label"><b> Zon
                                    </b> : <?php echo $row['maklumat_zon2'];?></label>
                                <br>
                                <label for="Name" class="col-lg-7 col-md-12 col-sm-12 col-xs-12  control-label"><b>
                                        Negeri </b> : <?php echo $row['maklumat_negeri2'];?></label>
                                <br>
                                <label for="Name" class="col-lg-7 col-md-12 col-sm-12 col-xs-12  control-label"><b>
                                        Tarikh </b> : <?php echo $row['maklumat_tarikh2'];?></label>
                                <br>
                                <label for="Name" class="col-lg-7 col-md-12 col-sm-12 col-xs-12  control-label"><b> Hari
                                    </b> : <?php echo $row['maklumat_hari2'];?></label>
                                <br>
                                <label for="Name" class="col-lg-7 col-md-12 col-sm-12 col-xs-12  control-label"><b> Masa
                                    </b> : <?php echo $row['maklumat_masa2'];?></label>
                                <br>
                                <label for="Name" class="col-lg-7 col-md-12 col-sm-12 col-xs-12  control-label"><b>
                                        Tempat </b> : </label>
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                    <?php echo $row['maklumat_tempat22'];?>
                                    <?php echo $row['maklumat_tempat23'];?>
                                    <?php echo $row['maklumat_tempat24'];?> -->


                            <?php

                                            require 'config-mysqli.php';

                                            $sql="SELECT COUNT(*) AS form from user";
                                            $result=mysqli_query($conn,$sql);
                                            $form1=mysqli_fetch_assoc($result);
                                            $form1=$form1['form'];


                                            $sql = "SELECT * FROM limitseminar ORDER BY id_limit2 ASC";
                                            $result=mysqli_query($conn,$sql);
                                            $jumlahseminar1=mysqli_fetch_assoc($result);
                                            $jumlahseminar1=$jumlahseminar1['jumlah_limit2'];


                                    ?>

                        </div>
                        <div class="btn-latihan">

                            <center>
                                Please click button to generate the form! <br><br>
                                <a href="club-form.php"><button class="btn btn-success"
                                        <?php if($form1 > $jumlahseminar1) echo "disabled"; ?>>Form</button></a>

                                <br> <br>
                                <label for="Name" class="col-lg-5 col-md-5 col-sm-5 col-xs-5 control-label"><b>
                                        Limit Form</b> : <?php echo $row['jumlah_limit2'];?></label>
                                <br>
                                <a href="editlimitseminar.php?id_limit2=<?php echo $row['id_limit2'];?>"><br><button
                                        class="btn btn-primary">Update</button></a>
                            </center>
                        </div>

                        <br>

                        <?php } ?>

                        <center>


                            <hr>
                            <br>


                            <label for="Name" class="col-lg-3 col-md-3 col-sm-3 col-xs-3 control-label"><b>Total
                                    Registration </b> : <?php echo $form1;?>/<?php echo $jumlahseminar1;?>
                                <div id="piechart2"></div>
                            </label>

                            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

                            <script type="text/javascript">
                            // Load google charts
                            google.charts.load('current', {
                                'packages': ['corechart']
                            });
                            google.charts.setOnLoadCallback(drawChart);

                            // Draw the chart and set the chart values
                            function drawChart() {
                                var data = google.visualization.arrayToDataTable([
                                    ['Student', 'Total'],
                                    ['Student', <?php echo $form1;?>],
                                    ['Total', <?php echo $jumlahseminar1;?>]
                                ]);

                                // Optional; add a title and set the width and height of the chart
                                var options = {
                                    'title': '',
                                    'is3D': true,
                                    'width': 400,
                                    'height': 300
                                };

                                // Display the chart inside the <div> element with id="piechart"
                                var chart = new google.visualization.PieChart(document.getElementById('piechart2'));
                                chart.draw(data, options);
                            }
                            </script>




                    </div>


                </div>


            </div>

        </div>




        <br>


        <!-- <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div> -->
    </div>
    </div>
    </div>
    <!-- End DataTables Card-->
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <footer class="sticky-footer">
        <div class="container">
            <div class="text-center">
                <small>Copyright © UNIMY</small>
            </div>
        </div>
    </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fa fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-warning" href="process/logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>
    <!-- End Logout Modal-->
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Page level plugin JavaScript-->
    <script src="vendor/datatables/jquery.dataTables.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>
    <!-- Custom scripts for this page-->
    <!-- <script src="js/sb-admin-datatables.min.js"></script> -->

    <!-- Smooth Scroll -->
    <script>
    $(document).ready(function() {

        $('.table').DataTable({
            responsive: true,

        });

        $("#success-alert").fadeTo(5000, 100).slideUp(1000, function() {
            $("#success-alert").slideUp(500);
        });

        var $button = $("#deleteSelectedBtn").hide(),
            $cbs = $('input[name="no"]').click(function() {
                $button.toggle($cbs.is(":checked"));
            });

    });

    // Add smooth scrolling to all links
    $("a").on('click', function(event) {

        // Make sure this.hash has a value before overriding default behavior
        if (this.hash !== "") {
            // Prevent default anchor click behavior
            event.preventDefault();

            // Store hash
            var hash = this.hash;

            // Using jQuery's animate() method to add smooth page scroll
            // The optional number (1000) specifies the number of milliseconds it takes to scroll to the specified area
            $('html, body').animate({
                scrollTop: $(hash).offset().top
            }, 1000, function() {

                // Add hash (#) to URL when done scrolling (default click behavior)
                window.location.hash = hash;
            });
        } // End if
    });

    function handleChange(checkbox) {
        if (checkbox.checked == true) {
            // document.getElementById("submit").removeAttribute("disabled");
            checkDeleteArray.push(checkbox.value);
            console.log(checkDeleteArray);
        } else {
            // document.getElementById("submit").setAttribute("disabled", "disabled");
            var index = checkDeleteArray.indexOf(checkbox.value);
            if (index !== -1) {
                checkDeleteArray.splice(index, 1);
            }

            console.log(checkDeleteArray);
        }
    }

    $('#deleteSelectedBtn').click(function() {

        if (confirm("Are you sure you want to delete the selected data ?")) {
            console.log(checkDeleteArray);

            $.post('includes/api.php', {
                action: 'delete_selected',
                itemArray: JSON.stringify(checkDeleteArray)
            }, function(data) {
                var apiData = JSON.parse(data);

                if (apiData['message'] == "Successful") {
                    location.reload();
                }
            });
        }


    });
    </script>
    <!-- End Smooth Scroll -->

    </div>
</body>

</html>