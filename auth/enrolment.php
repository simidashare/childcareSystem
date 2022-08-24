<!DOCTYPE html>
<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
  header("location: ../login.php"); 
  exit;
}else{
include "../database.php";
}
?>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>Pastow Childcare Centre</title>

    <!-- Bootstrap core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Custom fonts for this template -->
    <link
        href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i" rel="stylesheet" />

    <!-- Custom styles for this template -->
    <link href="../css/customStyle.css" rel="stylesheet" />
    <style>
    /* body{ font: 14px sans-serif; } */

    .custom-input {
        width: 60%;

    }

    .dropdown-item {
        color: rgba(255, 255, 255, 0.7)
    }

    .dropdown-item:hover {
        background-color: #e6a756;
    }

    .dropdown-menu {
        background-color: rgba(47, 23, 15, 0.7);
    }

    </style>
</head>

<body>
    <h1 class="site-heading text-center text-white d-none d-lg-block">
        <span class="site-heading-upper text-primary mb-3">Padstow Childcare Center</span>
        <span class="site-heading-lower">The Best Childcare In Sydney</span>
    </h1>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark" id="mainNav">
        <div class="container">
            <a class="navbar-brand text-uppercase text-expanded font-weight-bold d-lg-none" href="#">Padstow Childcare
                Center</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item px-lg-4">
                        <div class="btn-group">
                            <a class="nav-link text-capitalize text-expanded dropdown-toggle"
                                data-toggle="dropdown">Main Tables
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="./enrolment.php">Child</a>
                                <a class="dropdown-item" href="guardian.php">Guardian</a>
                                <a class="dropdown-item" href="family.php">Family
                                </a>
                                <a class="dropdown-item" href="./staff.php">Staff</a>
                                <a class="dropdown-item" href="doctor.php">Doctor
                                </a>
                                <a class="dropdown-item" href="./allergy.php">Allergy</a>
                                <a class="dropdown-item" href="medicine.php">Medicine</a>
                                <a class="dropdown-item" href="./enrolment.php">Enrolment</a>
                                <a class="dropdown-item" href="./payment.php">Payment</a>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item px-lg-4">
                        <div class="btn-group">
                            <a class="nav-link text-capitalize text-expanded dropdown-toggle"
                                data-toggle="dropdown">Bridging Tables
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="./enrolment-allergy.php">Child-Allergy</a>
                                <a class="dropdown-item" href="./enrolment-guardian.php">Child-Guardian</a>
                                <a class="dropdown-item" href="./family-doctor.php">Family-Doctor</a>
                                <a class="dropdown-item" href="./child-medicine.php">Child-Medicine</a>
                                <a class="dropdown-item" href="./staff-enrolment.php">Staff-Child</a>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item px-lg-4">
                        <div class="btn-group">
                            <a class="nav-link text-capitalize text-expanded dropdown-toggle" data-toggle="dropdown">
                                Hi,&nbsp;&nbsp; <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>
                            </a>
                            <div class="dropdown-menu">
                                <a id="iCanFly" class="dropdown-item " href="./successful.php">Quick Menu</a>
                                <a class="dropdown-item" href="resetPassword.php">Reset Your Password</a>
                                <a class="dropdown-item" href="../logOut.php">Sign Out
                                </a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="page-section clearfix">
        <div class="container">
            <div class="about-heading-content">
                <div class="row">
                    <div class="col-xl-9 col-lg-10 mx-auto">
                        <form class="table-responsive bg-faded rounded p-5" name="enrolment" id="enrolmentform">
                            <div class="table-responsive">
                                <div class="font-weight-bold text-info" style="text-align:center">
                                    <h3>Enrolment</h3>
                                </div>
                                <div>
                                    <table class="table table-hover table-bordered">
                                        <tr scope="row">
                                            <td class="table-primary">
                                                <label for="enrolment_id">Enrolment Id:</label>
                                            </td>
                                            <td class="table-info">
                                                <input class="custom-input" type="text" name="enrolment_id"
                                                    id="enrolment_id">
                                            </td>
                                        </tr>
                                        <tr scope="row">
                                            <td class="table-primary">
                                                <label for="enrolment_startDate">Start Date</label>
                                            </td>
                                            <td class="table-info">
                                                <input class="custom-input" type="text" name="enrolment_startDate"
                                                    id="enrolment_startDate" placeholder="YYYY-MM-DD">
                                            </td>
                                        </tr>
                                        <tr scope="row">
                                            <td class="table-primary">
                                                <label for="enrolment_endDate">End Date</label>
                                            </td>
                                            <td class="table-info">
                                                <input class="custom-input" type="text" name="enrolment_endDate"
                                                    id="enrolment_endDate" placeholder="YYYY-MM-DD">
                                            </td>
                                        </tr>
                                        <tr scope="row">
                                            <td class="table-primary">
                                                <label for="enrolment_numDays">Numbers of Day Per Week</label>
                                            </td>
                                            <td class="table-info">
                                                <input class="custom-input" type="text" name="enrolment_numDays"
                                                    id="enrolment_numDays">
                                            </td>
                                        </tr>
                                        <tr scope="row">
                                            <td class="table-primary">
                                                <label for="enrolment_numHours">Numbers of Hour Per Day</label>
                                            </td>
                                            <td class="table-info">
                                                <input class="custom-input" type="text" name="enrolment_numHours"
                                                    id="enrolment_numHours">
                                            </td>
                                        </tr>
                                        <tr scope="row">
                                            <td class="table-primary">
                                                <label for="enrolment_status">Enrolment Status:</label>
                                            </td>
                                            <td class="table-info">
                                                <div>
                                                    <input type="radio" name="enrolment_status" value="Y"
                                                        id="enrolment_status_y">
                                                    <label for="enrolment_status"> Yes <br></label>
                                                </div>
                                                <div>
                                                    <input type="radio" name="enrolment_status" value="N"
                                                        id="enrolment_status_n">
                                                    <label for="enrolment_status"> No <br></label>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr scope="row">
                                            <td class="table-primary">
                                                <label for="child_id">Child Id:</label>
                                            </td>
                                            <td class="table-info">
                                                <select id="child_id" name="child_id" value="0"></select>
                                            </td>
                                        </tr>
                                    </table>
                                    <div class="
                        col-auto
                        ml-auto
                        btn-group
                        flex-wrap
                        btn-group-justified
                      " style="width: 100%">
                                        <td class="btn-group">
                                            <button class="btn btn-primary mb-2" id="add">
                                                Add
                                            </button>
                                        </td>
                                        <td class="btn-group">
                                            <button class="btn btn-primary mb-2" id="remove">
                                                Delete
                                            </button>
                                        </td>
                                        <td class="btn-group">
                                            <button class="btn btn-primary mb-2" id="update">
                                                Update
                                            </button>
                                        </td>
                                        <td class="btn-group">
                                            <button class="btn btn-primary mb-2" id="search">
                                                Search
                                            </button>
                                        </td>
                                        <td class="btn-group">
                                            <button class="btn btn-primary mb-2" id="viewAll">
                                                ViewAll
                                            </button>
                                        </td>
                                    </div>
                                    <div>
                                        <div>
                                            <p style='font-size:1.25rem; text-align:center; color:red' id="message"></p>
                                        </div>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer text-faded text-center py-5">
        <div class="container">
            <p class="m-0 small">Copyright &copy; Padstow Childcare Center 2021</p>
        </div>
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="../js/enrolment.js" type="module"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>
