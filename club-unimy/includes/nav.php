<style>
.responsive {
    width: 5%;
    height: auto;
    margin-left: 13%;
    border-radius: 10px;
}
</style>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <!-- <a class="navbar-brand" href="OM_Dashboard.php"> </a> -->
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
        data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
        <img src="img/unimy.jpg" class="responsive">


        
        <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
            <br><br>
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
                <a class="nav-link" href="dashboard.php">
                    <h5><i class="fa fa-home" aria-hidden="true"></i>
                        <span class="nav-link-text"> Home</span>
                    </h5>
                </a>
     
            <a class="nav-link" href="forminfo.php">
                <h5><i class="fa fa-list-alt" aria-hidden="true"></i>
                    <span class="nav-link-text"> Form</span>
                </h5>
            </a>
            <a class="nav-link" href="form/esport.php">
                <h5><i class="fa fa-desktop" aria-hidden="true"></i>
                    <span class="nav-link-text"> Club</span>
                </h5>
            </a>
            <a class="nav-link" href="activity/esport.php">
                <h5><i class="fa fa-desktop" aria-hidden="true"></i>
                    <span class="nav-link-text"> Activity Info</span>
                </h5>
            </a>  
            <a class="nav-link" href="maklumatemail.php">
                <h5><i class="fa fa-envelope-o" aria-hidden="true"></i>
                    <span class="nav-link-text"> E-mel</span>
                </h5>
            </a>
            </li>

        </ul>
        <ul class="navbar-nav sidenav-toggler">
            <li class="nav-item">
                <a class="nav-link text-center" id="sidenavToggler">
                    <i class="fa fa-fw fa-angle-left"></i>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="adminsignup.php">
                    <i class="fa fa-user-plus" aria-hidden="true"></i> Register</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
                    <i class="fa fa-fw fa-sign-out"></i>Logout</a>
            </li>
        </ul>
    </div>
</nav>