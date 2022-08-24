<!DOCTYPE html>
<?php
// Initialize the session
session_start(); 
 
// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../login.php");
    exit;
}else{
  include "../database.php";
}
 
// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate new password
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Please enter the new password.";     
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "Password must have atleast 6 characters.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm the password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
        
    // Check input errors before updating the database
    if(empty($new_password_err) && empty($confirm_password_err)){
        // Prepare an update statement
        $sql = "UPDATE users SET password = :password WHERE id = :id";
        
        if($stmt = $conn->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            $stmt->bindParam(":id", $param_id, PDO::PARAM_INT);
            
            // Set parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Password updated successfully. Destroy the session, and redirect to login page
                session_destroy();
                header("location: ../login.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }
    
    // Close connection
    unset($conn);
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
    .wrapper {
        width: 45%;
        padding: 5%;
        background-color: rgba(0, 0, 0, 0.6);
    }

    .wrapper h2,
    .wrapper p,
    .form-group label {
        color: #fff;
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
        <div class="container">
            <div class="row justify-content-center">
                <div class="wrapper">
                    <h2>Reset Password</h2>
                    <p>Please fill out this form to reset your password.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>New Password</label>
                            <input type="password" name="new_password"
                                class="form-control <?php echo (!empty($new_password_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $new_password; ?>">
                            <span class="invalid-feedback"><?php echo $new_password_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" name="confirm_password"
                                class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>">
                            <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Submit">
                            <a class="btn btn-link ml-2" href="successful.php">Cancel</a>
                        </div>
                    </form>
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
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>
