<!DOCTYPE html>
<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to successful page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location:./auth/successful.php");
    exit;
}
 
// Include database file
require_once "database.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = :username";
        
        if($stmt = $conn->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Check if username exists, if yes then verify password
                if($stmt->rowCount() == 1){
                    if($row = $stmt->fetch()){
                        $id = $row["id"];
                        $username = $row["username"];
                        $hashed_password = $row["password"];
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to successful page
                            header("location:./auth/successful.php");
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
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
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Custom fonts for this template -->
    <link
        href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i" rel="stylesheet" />

    <!-- Custom styles for this template -->
    <link href="./css/customStyle.css" rel="stylesheet" />
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

    .iCanFly:hover {
        animation-timing-function: ease-out !important;
        transform-origin: bottom center !important;
        animation-name: highlight-login !important;
        animation-duration: 5s !important;
    }

    @keyframes highlight-login {
        1% {
            border-radius: none;
            box-shadow: 0px 0px 40px rgba(255, 255, 0, 0.6);
            transform: scale(1);
        }

        10% {
            box-shadow: 0px 0px 0px;
            /*border-radius: 50%;*/
            transform: scale(1);
        }

        20% {
            box-shadow: 0px 0px 120px rgba(255, 255, 0, 0.6);
            /*border-radius: 50%;*/
            transform: scale(1);
        }

        30% {
            box-shadow: 0px 0px 0px;
            /*border-radius: 50%;*/
            transform: scale(1);
        }

        40% {
            box-shadow: 0px 0px 120px rgba(255, 255, 0, 0.6);
            /*border-radius: 50%;*/
            transform: scale(1);
        }

        50% {
            box-shadow: 0px 0px 0px;
            /*border-radius: 50%;*/
            transform: scale(1);
        }

        60% {
            box-shadow: 0px 0px 20vh rgba(255, 255, 0, 1);
            /*border-radius: 50%;*/
            transform: scale(1);
        }

        70% {
            box-shadow: 0px 0px 0px;
            /*border-radius: 50%;*/
            transform: scale(1);
        }

        80% {
            box-shadow: 0px 0px 20vh rgba(255, 255, 0, 1);
            /*border-radius: 50%;*/
            transform: scale(1);
        }

        90% {
            box-shadow: 0px 0px 0px;
            /*border-radius: 50%;*/
            transform: scale(1);
        }

        99% {
            box-shadow: 0px 0px 20vh rgba(255, 255, 0, 1);
            /*border-radius: 50%;*/
            transform: scale(1.1);
        }
    }

    @keyframes inMotion {
        0% {
            transform: translate3d(0, 500px, 0) rotateX(-60deg) scale(2);
        }

        49.9% {
            transform: translate3d(0, -1000px, 0) rotateX(60deg) scale(.19);
        }

        99.9% {
            transform: translate3d(0, 0, 0) rotateX(1deg) scale(1);
        }
    }

    #hero {
        animation-timing-function: ease-out;
        animation-name: inMotion;
        animation-duration: 3s;
    }

    </style>
</head>

<body>
    <h1 class="site-heading text-center text-white d-none d-lg-block">
        <span class="site-heading-upper text-primary mb-3">Padstow Childcare Center</span>
        <span class="site-heading-lower">The Best Childcare In Sydney</span>
    </h1>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark py-lg-4" id="mainNav">
        <div class="container">
            <a class="navbar-brand text-uppercase text-expanded font-weight-bold d-lg-none" href="#">Padstow Childcare
                Center</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item active px-lg-4">
                        <a class="nav-link text-uppercase text-expanded" href="./index.php">Home
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item px-lg-4">
                        <a class="nav-link text-uppercase text-expanded" href="./about.php">About</a>
                    </li>
                    <li class="nav-item px-lg-4">
                        <a class="nav-link text-uppercase text-expanded" href="./openingHours.php">Opening Hours</a>
                    </li>
                    <li class="nav-item px-lg-4">
                        <a class="nav-link text-uppercase text-expanded" href="./contact.php">Contact Us</a>
                    </li>
                    <li class="nav-item px-lg-4">
                        <a class="nav-link text-uppercase text-expanded iCanFly" href="./logIn.php">Staff Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section id="hero" class="page-section clearfix">
        <div class="container">
            <div class="row justify-content-center">
                <div class="wrapper">
                    <h2>Login</h2>
                    <p>Please fill in your credentials to login.</p>

                    <?php 
            if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
            }        
            ?>

                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username"
                                class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $username; ?>">
                            <span class="invalid-feedback"><?php echo $username_err; ?></span>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password"
                                class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                            <span class="invalid-feedback"><?php echo $password_err; ?></span>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary iCanFly" value="Login">
                        </div>
                        <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
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
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>
