<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap core CSS-->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom fonts for this template-->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- Page level plugin CSS-->
    <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">
</head>
<style type="text/css">
.body-from {
    width: 98%;
    margin: 0px auto;
    font-size: 11px;
}



@media print {
    @page {
        /* size: auto;   auto is the initial value */
        size: A4 landscape;
        margin: 0;
        /* this affects the margin in the printer settings */
        border: 1px solid black;
        /* set a border for all printed pages */

    }

    table {
        page-break-after: auto
    }

    tr {
        page-break-inside: avoid;
        page-break-after: auto
    }

    td {
        page-break-inside: avoid;
        page-break-after: auto
    }

    thead {
        display: table-header-group
    }

    tfoot {
        display: table-footer-group
    }
}
</style>

<body class="body-from">

    <center>

        <br><br><br><br>
  
    </center>
    <br>
    <center>

        <b>
            <p>LIST STUDENTS INGENIEURS CLUB UNIMY</p>
        </b>



        <?php
                 require_once("perpage.php");  
                 require_once("dbcontroller.php");
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
                //  $sql = "SELECT * FROM user " . $queryCondition;
                 $sql = "SELECT * FROM user WHERE club_user LIKE '%Ingenieurs%' " . $queryCondition;
               

                 $href = 'dashboard.php';          
    
                 $perPage = 200; 
                 $page = 1;
                 if(isset($_POST['page'])){
                   $page = $_POST['page'];
                 }
                 $start = ($page-1)*$perPage;
                 if($start < 0) $start = 0;
                   
                 $query =  $sql . $orderby .  " limit " . $start . "," . $perPage; 
                 $result = $db_handle->runQuery($query);
                 
                 if(!empty($result)) {
                   $result["perpage"] = showperpage($sql, $perPage, $href);  }
        ?>


        <div class="table-responsive">
            <div id="toys-grid">
                <form name="frmSearch" method="post" action="dashboard.php">
                    <table cellpadding="3" cellspacing="1">

                        <thead>
                            <tr>
                                <th style="border: 1px solid black;"><strong>Bil.</strong></th>
                                <th style="border: 1px solid black;"><strong>Name</strong></th>
                                <th style="border: 1px solid black;"><strong>Student Id</strong></th>
                                <th style="border: 1px solid black;"><strong>Email</strong></th>
                                <th style="border: 1px solid black;"><strong>Phone Number</strong></th>
                                <!-- <th style="border: 1px solid black;"><strong>Club</strong></th> -->
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
                                <td style="border: 1px solid black;"><?php echo $count; ?></td>
                                <td style="border: 1px solid black;"><?php echo strtoupper($result[$k]["name_user"]);?></td>
                                <td style="border: 1px solid black;"><?php echo strtoupper($result[$k]["studentid_user"]);?></td>
                                <td style="border: 1px solid black;"><?php echo $result[$k]["email_user"]; ?></td>
                                <td style="border: 1px solid black;"><?php echo $result[$k]["phone_user"]; ?></td>
                                <!-- <td style="border: 1px solid black;"><?php echo $result[$k]["club_user"]; ?></td> -->
                                <!-- <td style="border: 1px solid black;"></td> -->
                            </tr>
                            <?php
              }
             }
                    }
          if(isset($result["perpage"])) {
          ?>
                            <!--  <tr>
          <td colspan="10" align=right> <?php echo $result["perpage"]; ?></td>
          </tr> -->
                            <?php } ?>
                        </tbody>

                    </table>
                </form>
            </div>
        </div>
    </center>

    <!--  <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a> -->
    <!-- Logout Modal-->
    <!--  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
   
        </div>
      </div>
    </div> -->
    <!-- End Logout Modal-->
    <br><br>


    <!-- Bootstrap core JavaScript-->
    <!--  <script src="vendor/jquery/jquery.min.js"></script>
    <script>
      $(document).ready(function() {
    $('.table').DataTable();
} );
    </script> -->

    <!-- Smooth Scroll -->

    <!-- <script>
    $(document).ready(function(){
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
          }, 1000, function(){
       
            // Add hash (#) to URL when done scrolling (default click behavior)
            window.location.hash = hash;
          });
        } // End if
      });
    });
    </script> -->

    <!--  <script>
      $("#success-alert").fadeTo(5000, 100).slideUp(1000, function(){
        $("#success-alert").slideUp(500);
      });
    </script> -->

    <!-- End Smooth Scroll -->


    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Page level plugin JavaScript-->
    <script src="vendor/datatables/jquery.dataTables.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>
    <!-- Custom scripts for this page-->
    <script src="js/sb-admin-datatables.min.js"></script>

    <script>
    window.print();
    </script>


    </div>
</body>

</html>