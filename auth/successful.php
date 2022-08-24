<!DOCTYPE html>
<?php
// Initialize the session
session_start(); 
 
// Check if the user is logged in, if not then redirect him to login page
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
    .label-color-aqua,
    label {
        color: aqua !important;
    }

    .label-color-gold {
        font-size: 1.5rem;
        font-weight: 500;
        color: gold !important;
    }

    .enrolment_status_n {
        margin-left: 10%;
    }

    .title-db {
        animation: rotation 10s infinite linear 0.5s both;
    }

    @keyframes rotation {
        from {
            transform: rotateY(0deg) translateZ(400px) scaleY(0.9);
        }

        to {
            transform: rotateY(359deg) translateZ(400px) scaleY(1);
        }
    }

    #db-1:hover,
    #db-2:hover,
    #db-3:hover,
    #db-4:hover {
        animation-timing-function: ease-out !important;
        transform-origin: bottom center !important;
        animation-name: highlight-login !important;
        animation-duration: 5s !important;
    }

    @keyframes highlight-login {
        1% {
            border-radius: none;
            box-shadow: 0px 0px 40px rgba(255, 255, 0, 0.6);


        }

        10% {
            box-shadow: 0px 0px 0px;
            /*border-radius: 50%;*/

        }

        20% {
            box-shadow: 0px 0px 120px rgba(255, 255, 0, 0.6);
            /*border-radius: 50%;*/


        }

        30% {
            box-shadow: 0px 0px 0px;
            /*border-radius: 50%;*/

        }

        40% {
            box-shadow: 0px 0px 120px rgba(255, 255, 0, 0.6);
            /*border-radius: 50%;*/

        }

        50% {
            box-shadow: 0px 0px 0px;
            /*border-radius: 50%;*/
        }

        60% {
            box-shadow: 0px 0px 20vh rgba(255, 255, 0, 1);
            /*border-radius: 50%;*/

        }

        70% {
            box-shadow: 0px 0px 0px;
            /*border-radius: 50%;*/

        }

        80% {
            box-shadow: 0px 0px 20vh rgba(255, 255, 0, 1);
            /*border-radius: 50%;*/

        }

        90% {
            box-shadow: 0px 0px 0px;
            /*border-radius: 50%;*/

        }

        99% {
            box-shadow: 0px 0px 20vh rgba(255, 255, 0, 1);
            /*border-radius: 50%;*/
        }
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
                                <a class="dropdown-item" href="./child.php">Child</a>
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
                                <a class="dropdown-item" href="./child-allergy.php">Child-Allergy</a>
                                <a class="dropdown-item" href="./child-guardian.php">Child-Guardian</a>
                                <a class="dropdown-item" href="./family-doctor.php">Family-Doctor</a>
                                <a class="dropdown-item" href="./child-medicine.php">Child-Medicine</a>
                                <a class="dropdown-item" href="./staff-child.php">Staff-Child</a>
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
        <!-- <div>Padstow Childcare Centre</div>    -->
        <div class="title-db">Good Day,&nbsp;&nbsp; <?php echo htmlspecialchars($_SESSION["username"]); ?></div>
        <div class="db ">
            <div id="db-1" class="db-item db-item--1">
                <form class="table-responsive rounded p-12" name="guardianform">
                    <div class="table-responsive">
                        <div class="font-weight-bold label-color-aqua" style="text-align:center">
                            <h3>Quick Menu</h3>
                        </div>
                        <div>
                            <table class="table table-hover table-bordered">
                                <tr scope="row">
                                    <td class="align-middle ">
                                        <label for="child_id">Child ID:</label>
                                    </td>
                                    <td class="align-middle">
                                        <select class="custom-input" type="text" name="child_id" id="child_id_load"
                                            value="0"></select>
                                    </td>
                                </tr>
                                <tr scope="row">
                                    <td class="align-middle">
                                        <label for="alle_code">Allergy Code:</label>
                                    </td>
                                    <td class="align-middle">
                                        <select class="custom-input" type="text" name="alle_code"
                                            id="alle_code_load"></select>
                                    </td>
                                    <td class="align-middle">
                                        <button class="btn btn-primary mb-2" id="addAllergy">Add</button>
                                        <button class="btn btn-primary mb-2" id="removeAllergy">Delete</button>
                                    </td>
                                </tr>
                                <tr scope="row">
                                    <td class="align-middle">
                                        <label for="guardian_id">Guardian ID:</label>
                                    </td>
                                    <td class="align-middle">
                                        <select class="custom-input" type="text" name="guardian_id[]"
                                            id="guardian_id_load" multiple></select>
                                    </td>
                                    <td class="align-middle">
                                        <button class="btn btn-primary mb-2" id="addGuardian">Add</button>
                                        <button class="btn btn-primary mb-2" id="removeGuardian">Delete</button>
                                    </td>
                                </tr>
                                <tr scope="row">
                                    <td class="">
                                        <label for="staff_id">Staff ID:</label>
                                    </td>

                                    <td class="">
                                        <select class="custom-input" type="text" name="staff_id"
                                            id="staff_id_load"></select>
                                    </td>
                                    <td class="align-middle">
                                        <button class="btn btn-primary mb-2" id="addStaff">Add</button>
                                        <button class="btn btn-primary mb-2" id="removeStaff">Delete</button>
                                    </td>
                                </tr>
                                <tr scope="row">
                                    <td class="">
                                        <label for="enrolment_id">Enrolment ID:</label>
                                        <div class="label-color-gold" id="enrolment_id_load" value=""></div>
                                    </td>
                                    <td class="">
                                        <div> <label for="enrolment_status">Enrolment Status:</label></div>
                                        <div>
                                            <input type="radio" name="enrolment_status" value="y"
                                                class="enrolment_status_y">
                                            <label for="M">Yes<br></label>
                                            <input type="radio" name="enrolment_status" value="n"
                                                class="enrolment_status_n">
                                            <label for="F">No<br></label>
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <button class="btn btn-primary mb-2" id="addEnrolment_status">Change</button>
                                    </td>
                                </tr>
                            </table>
                            <div>
                                <p style='font-size:1.8rem; text-align:center; color:gold' id="message"></p>
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
    <script src="../js/combinedAdd.js" type="module"></script>
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>
