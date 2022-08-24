<?PHP
session_start(); 
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
  $loginDisplay ='<a 
  class="iCanFly nav-link text-uppercase text-expanded "
  href="./logIn.php"
  >Staff Login</a>';
}else{
  $loginDisplay =  '<div class="btn-group">';
  $loginDisplay .= '<a class="nav-link text-capitalize text-expanded dropdown-toggle" data-toggle="dropdown">';
  $loginDisplay .= 'Hi,&nbsp;&nbsp; <b>';
  $loginDisplay .=  $_SESSION["username"];   
  $loginDisplay .= '</b></a>
  <div class="dropdown-menu">
    <a class="dropdown-item" href="./logIn.php">Staff Dashboard</a>
    <a class="dropdown-item" href="./auth/resetPassword.php">Reset Your Password</a>
    <a class="dropdown-item" href="./logOut.php">Log Out
    </a>
  </div>';}
?>
<!DOCTYPE html>
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
    .sh-lower {
        animation: comeIn 2s cubic-bezier(0.250, 0.460, 0.450, 0.940) both;
    }

    @keyframes comeIn {
        0% {
            letter-spacing: -0.5em;
            transform: translateZ(-800px);
            filter: blur(12px);
            opacity: 0;
        }

        100% {
            transform: translateZ(0);
            filter: blur(100);
            opacity: 1;
        }
    }


    .sh-upper {
        animation: fromleft 3s cubic-bezier(0.215, 0.610, 0.355, 1.000) both;
    }

    @keyframes fromleft {
        0% {
            letter-spacing: 1em;
            -webkit-transform: translateZ(400px) translateY(300px);
            transform: translateZ(400px) translateY(300px);
            opacity: 0;
        }

        40% {
            opacity: 0.6;
        }

        100% {
            -webkit-transform: translateZ(0) translateY(0);
            transform: translateZ(0) translateY(0);
            opacity: 1;
        }
    }

    .iCanFly:hover,
    .intro-button a:hover {
        animation-timing-function: ease-out !important;
        transform-origin: bottom center !important;
        animation-name: highlight-login !important;
        animation-duration: 7s !important;
        border: 3px solid rgb(255, 255, 0, 0.6) !important;
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

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }

    }

    .container {
        animation-timing-function: linear;
        transform-origin: bottom center;
        animation-name: fadeIn;
        animation-duration: 5s;
        animation-fill-mode: forwards;
        opacity: 0;
    }

    </style>

</head>

<body>
    <h1 class="site-heading text-center text-white d-none d-lg-block">
        <div class="sh-upper site-heading-upper text-primary mb-3 rotate-in-center">Padstow Childcare Center</div>
        <div class="sh-lower site-heading-lower">The Best Childcare In Sydney</div>
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
                        <?php echo $loginDisplay;?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="page-section clearfix">
        <div class="container">
            <div class="intro">
                <img class="intro-img img-fluid mb-3 mb-lg-0 rounded"
                    src="./img/jordan-rowland-lfEX-fEN3zY-unsplash-1536x1024.jpg" alt="" />
                <div class="intro-text left-0 text-center bg-faded p-5 rounded">
                    <h2 class="section-heading mb-4">
                        <span class="section-heading-upper">Home</span>
                        <span class="section-heading-lower">Away From Home</span>
                    </h2>
                    <p class="mb-3">
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                        the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley
                        of type and scrambled it to make a type specimen book.
                    </p>
                    <div class="intro-button mx-auto">
                        <a class="btn btn-primary btn-xl self-made__button" href="./contact.php">Enrol Today!</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="page-section cta">
        <div class="container">
            <div class="row">
                <div class="col-xl-9 mx-auto">
                    <div class="cta-inner text-center rounded">
                        <h2 class="section-heading mb-4">
                            <span class="section-heading-upper">Our Promise</span>
                            <span class="section-heading-lower">To You</span>
                        </h2>
                        <p class="mb-0">
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has
                            been the industry's standard dummy text ever since the 1500s, when an unknown printer took a
                            galley of type and scrambled it to make a type specimen book.
                        </p>
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
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>
