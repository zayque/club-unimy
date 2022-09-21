<?php
    include('../includes/core.php')

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Club</title>
    <link rel="icon" type="image/ico" href="../img/unimy.jpg" />
    <!-- Bootstrap core CSS-->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom fonts for this template-->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- Page level plugin CSS-->
    <link href="../vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="../css/sb-admin.css" rel="stylesheet">
    <link href="../style.css" type="text/css" rel="stylesheet" />

    <script type="text/javascript">
    window.history.forward();

    function noBack() {
        window.history.forward();
    }

    var checkDeleteArray = [];
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
                <H4>WELCOME TO ADMIN CLUB SYSTEM</H4>
            </marquee>
            <!-- Breadcrumbs-->
            <div id="dashboard">


                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" style="color: black">
                        <h4>E-Sports Club</h4>
                    </li>
                </ol>

                <div id="Approve_Request">
                    <div class="container-form">
                        <div class="card mb-4">
                            <div class="title">
                                <li class="nav-item dropdown" style="list-style:none">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Club
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="esport.php">E-Sports Club</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="cyber.php">Cybersecurity Club</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="photo.php">Photography Crew</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="japan.php">Japananime Society</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="advent.php">Adventurous Recreational Club</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="music.php">Music Club</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="biztech.php">BizTech Club</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="inge.php">Ingenieurs Club</a>
                                        
                                    </div>
                                </li>
                    <?php
                          require_once("../perpage.php");  
                          require_once("../dbcontroller.php");
                          $db_handle = new DBController();
                          
                          $name_user = "";
                          $studentid_user = "";
                          $email_user = "";
                          $phone_user = "";
                          $club_user = "";

                 
                 

                          $queryCondition = "";
                          if(!empty($_POST["search"])) {
                            foreach($_POST["search"] as $k=>$v){
                              if(!empty($v)) {

                                $queryCases = array("name_user","studentid_user","email_user","phone_user","club_user");
                                if(in_array($k,$queryCases)) {
                                  if(!empty($queryCondition)) {
                                    $queryCondition .= " AND ";
                                  } else {
                                    $queryCondition .= " WHERE ";
                                  }
                                }
                                switch($k) {
                                    case "name_user":
                                    $name_user = $v;                                                                  
                                    $queryCondition .= "name_user LIKE '" . $v . "%'";
                                    break;
                                    case "studentid_user":
                                    $studentid_user = $v;
                                    $queryCondition .= "studentid_user LIKE '" . $v . "%'";
                                    break;
                                    case "email_user":
                                    $email_user = $v;
                                    $queryCondition .= "email_user LIKE '" . $v . "%'";
                                    break;
                                    case "phone_user":
                                    $phone_user = $v;
                                    $queryCondition .= "phone_user LIKE '" . $v . "%'";
                                    break;
                                    case "club_user":
                                    $club_user = $v;
                                    $queryCondition .= "club_user LIKE '" . $v . "%'";
                                    break;
                                }
                              }
                            }
                          }
                          $orderby = " ORDER BY name_user DESC"; 
                        //   $sql = "SELECT * FROM user " . $queryCondition;
                          $sql = "SELECT * FROM user WHERE club_user LIKE '%E-Sports%' " . $queryCondition;
                        

                          $href = 'dashboard.php';          
             
                          $query =  $sql ; 
                          $result = $db_handle->runQuery($query);                     
                        ?>
                                <center>
                                    <b>
                                        <p>LIST STUDENTS E-Sports Club</p>
                                    </b>
                                </center>
                                <div class="card-header">
                                    <div class="card-body">
                                        <button type="button" id="deleteSelectedBtn"
                                            class="btn btn-danger text-white">Delete
                                            Selected</button>

                                        <div class="float-right mb-4 mr-3">
                                            <a href="print/printesport.php"><button type="button"
                                                    class="btn btn-secondary text-white">Print</button></a>
                                            <a href="csv/csvesport.php"><button type="button"
                                                    class="btn btn-secondary text-white">Download</button></a>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-hover" cellpadding="10" cellspacing="1">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th><strong>Bil.</strong></th>
                                                        <th><strong>Name</strong></th>
                                                        <th><strong>Student Id</strong></th>
                                                        <th><strong>Email</strong></th>
                                                        <th><strong>Phone Number</strong></th>
                                                        <th><strong>Club</strong></th>
                                                        <!-- <th><strong>Masa</strong></th> -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                      $count=0;
                                      if(!empty($result)) {
                                        foreach($result as $k=>$v) {
                                          if(is_numeric($k)) { $count++;
                                      ?>
                                                    <tr>
                                                        <td><input type="checkbox" name="no"
                                                                onchange="handleChange(this); "
                                                                value=" <?=$result[$k]["studentid_user"];?>" /></td>
                                                        <td><?php echo $count; ?></td>
                                                        <td><?php echo strtoupper($result[$k]["name_user"]);?></td>
                                                        <td><?php echo strtoupper($result[$k]["studentid_user"]);?></td>
                                                        <td><?php echo $result[$k]["email_user"]; ?></td>
                                                        <td><?php echo $result[$k]["phone_user"]; ?></td>
                                                        <td><?php echo $result[$k]["club_user"]; ?></td>
                                                        <!-- <td><?php //echo $result[$k]["masa"]; ?></td> -->
                                                    </tr>
                                                    <?php
                                          }
                                        }
                                                }
                                      //if(isset($result["perpage"])) {
                                      ?>
                                                    <!-- <tr>
                                          <td colspan="12" style="border:1px white" align="right">
                                              <?php //echo $result["perpage"]; ?></td>
                                      </tr> -->
                                                    <?php //} ?>
                                                <tbody>
                                            </table>
                                        </div>

                                    </div>

                                </div>




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
            <small>Copyright © UNIMY </small>
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
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Page level plugin JavaScript-->
    <script src="../vendor/datatables/jquery.dataTables.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin.min.js"></script>
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