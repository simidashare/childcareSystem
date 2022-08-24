<?php
// Include database file 
require_once "database.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = $registration_key ="";
$username_err = $password_err = $confirm_password_err = $registration_key_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = :username";
        
        if($stmt = $conn->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Validate staff registration key
    if(empty(trim($_POST["registration_key"]))){
      $registration_key_err = "Please enter a staff registration key.";
  } else{
      // Prepare a select statement
      $sql = "SELECT id FROM users WHERE registration_key = :registration_key";
      $sql2 = "SELECT staff_id FROM staff WHERE registration_key = :registration_key";

      if($stmt = $conn->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":registration_key", $param_registration_key, PDO::PARAM_STR);
        
        // Set parameters
        $param_registration_key = trim($_POST["registration_key"]);
        
        // Attempt to execute the prepared statement
        if($stmt->execute()){
          if($stmt->rowCount() == 1){
                $registration_key_err = "Registration key is used.";
            }
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
      }

      if($stmt = $conn->prepare($sql2)){
          // Bind variables to the prepared statement as parameters
          $stmt->bindParam(":registration_key", $param_registration_key, PDO::PARAM_STR);
          
          // Set parameters
          $param_registration_key = trim($_POST["registration_key"]);
          
          // Attempt to execute the prepared statement
          if($stmt->execute()){
             if($stmt->rowCount() == 0){
                  $registration_key_err = "Invalid registration key.";
              } else{
                  $registration_key = trim($_POST["registration_key"]);
              }
          } else{
              echo "Oops! Something went wrong. Please try again later.";
          }

          // Close statement
          unset($stmt);
      }
  }




    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($registration_key_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password,registration_key) VALUES (:username, :password,:registration_key)";
         
        if($stmt = $conn->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            $stmt->bindParam(":registration_key", $param_registration_key, PDO::PARAM_STR);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to logIn page
                header("location: logIn.php");
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
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>Pastow Childcare Centre</title>
   
    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Custom fonts for this template -->
    <link
      href="https://fonts.googleapis.com/css?family=Raleway:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i"
      rel="stylesheet"
    />
    <link
      href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i"
      rel="stylesheet"
    />

    <!-- Custom styles for this template -->
    <link href="./css/customStyle.css" rel="stylesheet" />
    <style>
        /* body{ font: 14px sans-serif; } */
        .wrapper{ width: 45%; 
                padding: 5%; 
                background-color:rgba(0,0,0,0.6);
        }
        .wrapper h2,
        .wrapper p,
        .form-group label{
            color:#fff;
        }
    </style>
  </head>

  <body>
    <h1 class="site-heading text-center text-white d-none d-lg-block">
      <span class="site-heading-upper text-primary mb-3"
        >Padstow Childcare Center</span
      >
      <span class="site-heading-lower">The Best Childcare In Sydney</span>
    </h1>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark py-lg-4" id="mainNav">
      <div class="container">
        <a
          class="navbar-brand text-uppercase text-expanded font-weight-bold d-lg-none"
          href="#"
          >Padstow Childcare Center</a
        >
        <button
          class="navbar-toggler"
          type="button"
          data-toggle="collapse"
          data-target="#navbarResponsive"
          aria-controls="navbarResponsive"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav mx-auto">
            <li class="nav-item active px-lg-4">
              <a class="nav-link text-uppercase text-expanded" href="./index.php"
                >Home
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item px-lg-4">
              <a class="nav-link text-uppercase text-expanded" href="./about.php"
                >About</a
              >
            </li>
            <li class="nav-item px-lg-4">
              <a
                class="nav-link text-uppercase text-expanded"
                href="./openingHours.php"
                >Opening Hours</a
              >
            </li>
            <li class="nav-item px-lg-4">
              <a class="nav-link text-uppercase text-expanded" href="./contact.php"
                >Contact Us</a
              >
            </li>
            <li class="nav-item px-lg-4">
              <a
                class="nav-link text-uppercase text-expanded"
                href="./logIn.php"
                >Staff Login</a
              >
            </li>
          </ul>
        </div>
      </div>
    </nav>
    
    <section class="page-section clearfix">
      <div class="container">
        <div class="row justify-content-center">
            <div class="wrapper">
                <h2>Sign Up</h2>
                <p>Please fill this form to create an account.</p>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                        <span class="invalid-feedback"><?php echo $username_err; ?></span>
                    </div>    
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                        <span class="invalid-feedback"><?php echo $password_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                        <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                    </div>
                    <div class="form-group">
                        <label>Staff Registration Key</label>
                        <input type="password" name="registration_key" class="form-control <?php echo (!empty($registration_key_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $registration_key; ?>">
                        <span class="invalid-feedback"><?php echo $registration_key_err; ?></span>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <input type="reset" class="btn btn-secondary ml-2" value="Reset">
                    </div>
                        <p>Already have an account? <a href="logIn.php">Login here</a>.</p>
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