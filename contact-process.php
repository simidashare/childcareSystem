<?php
session_start(); 
include "database.php";


// header("Content-Type: application/json; charset=UTF-8");
    $fname = $lname = $email = $message = "";
    $str = json_decode(file_get_contents('php://input'),true);
    if(isset($str)){
        $fname = $str[0];
        $lname = $str[1];
        $email = $str[2];
        $message = $str[3];
        try{
            $sql = "insert into contact_received values(cr_id,'$fname','$lname','$email','$message')"; 
            $conn->query($sql);
            $outp = "Thank you for contacting us";
            echo json_encode($outp);
            exit();
        }catch(PDOException $e){
            $outpErr =  $e->getMessage();
            echo json_encode($outpErr);  
            exit();             
          }  
        }
 
?>
