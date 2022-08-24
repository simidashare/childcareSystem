<!DOCTYPE html>
<?php
session_start();
include "database.php";
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
                        <a class="nav-link text-uppercase text-expanded" href="./logIn.php">Staff Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="page-section clearfix">
        <div class="container contact" id="content-wrapper">
            <div class="row justify-content-center">
                <div class="col-md-3" style="
              margin-right:-1%;      
              background: #ff9b00;
              padding: 4% 4% 0 4%;
              border-top-left-radius: 0.5rem;
              border-bottom-left-radius: 0.5rem;              
            ">
                    <div class="contact-info" style="margin-top: 10%">
                        <img style="margin-bottom: 15%" src="https://image.ibb.co/kUASdV/contact-image.png"
                            alt="image" />
                        <h2 style="margin-bottom: 10%">Contact Us</h2>
                        <p style="font-size:1.1rem">
                            123 Church Street Padstow, NSW Call Anytime
                        </p>
                        <p style="font-size:1.05rem">(04) 12-345-678</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <form id="myForm" name="contact-form" class="contact-form" method="post"
                        style="background-color:rgba(0,0,0,0.6); margin-bottom:-3%">
                        <div class="form-group">
                            <label class="control-label col-sm-5"
                                style="margin-top:5%; color: #fff; font-weight: 400; font-size: 1.2rem"
                                for="fname">First Name:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="fname" placeholder="Enter First Name"
                                    name="fname" /><span class="error-hint hide">First name is invalid</span>
                                <br><br>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-5"
                                style="color: #fff; font-weight: 400; font-size: 1.2rem" for="lname">Last Name:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="lname" placeholder="Enter Last Name"
                                    name="lname" /><span class="error-hint hide">Last name is invalid</span>
                                <br><br>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-5"
                                style="color: #fff; font-weight: 400; font-size: 1.2rem" for="email">Email:</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" id="email" placeholder="Enter Email"
                                    name="email" />
                                <span class="error-hint hide">Email is invalid</span></span>
                                <br><br>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-5"
                                style="color: #fff; font-weight: 400; font-size: 1.2rem" for="message">Message:</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" rows="5" id="message" name="message"
                                    placeholder="Enter Message"></textarea>
                                <span class="error-hint hide">Message is invalid</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-auto text-center">
                                <div style="padding:5%; flex: 0 0 auto; width: auto; max-width: 80%">
                                    <button type="submit" class="btn btn-primary contact-btn" style="font-size: 1.3rem"
                                        name="submit">
                                        Submit
                                    </button>
                                    <div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
        <div class="thank-you hide">
            <p id="result" class="thank-you__title"></p>
            <p class="thank-you__content">We will redirect you to the main page in 3 sec.
                <a class="text-warning" onclick="stopRedicrection()" style=" text-transform:capitalize">Click here</a>
                to cancel the redirection
            </p>
        </div>

    </section>
    <footer class="footer text-faded text-center py-5">
        <div class="container">
            <p class="m-0 small">Copyright &copy; Padstow Childcare Center 2021</p>
        </div>
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="./js/contactFormValidation.js"></script>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>
