<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
  header("location: ../login.php"); 
  exit;
}else{
  include "../database.php";
  include "./generalFunction.php";
  include "./checkingUnits.php";
}
$myArray = array();

if (isset($_GET["viewAll"]) && $_GET["viewAll"] == "1")
{
	$url = "select * from payment";
	$result = dbProcess($url,$conn,$myArray);
    if(!$result){
        exit(json_encode("No record found"));
    }
	exit(json_encode($result));
}


if (isset($_GET["search"]) && $_GET["search"] == "1")
{
    $str = json_decode(file_get_contents('php://input'),true);

	if(isset($str)){       
        $payment_id = $str['obj']['payment_id'];         
        try{
            $sql = "select * from payment where payment_id = $payment_id;"; 
            $stmt = $conn->query($sql);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($data){
                foreach($data as $row){
                    array_push($myArray,$row);
                }
                exit(json_encode($myArray));
            }else{
                exit(json_encode("No record found for this payment"));
            }
        }catch(PDOException $e){
                $err= $e->getMessage();
                exit(json_encode($err));
                // if($e->getCode() === "23000"){
                //     exit(json_encode("Record does not exist"));
                // }
        }	
    }
}

if (isset($_GET["add"]) && $_GET["add"] == "1")
{
	$str = json_decode(file_get_contents('php://input'),true);	
	if(isset($str)){
        // $payment_id = $str['obj']['payment_id'];
        $payment_from = $str['obj']['payment_from'];
        $payment_to = $str['obj']['payment_to'];
        $payment_amountPaid = $str['obj']['payment_amountPaid'];
        $payment_outstandingAmount = $str['obj']['payment_outstandingAmount'];
        $enrolment_id = $str['obj']['enrolment_id'];    
   
		$inputChecked = checkEmptyInput($payment_from, $payment_to, $payment_amountPaid, $payment_outstandingAmount, $enrolment_id);
		if($inputChecked){
            try{
                $sql = "insert into payment values(payment_id,'$payment_from','$payment_to', $payment_amountPaid, $payment_outstandingAmount,$enrolment_id)";
                $stmt = $conn->query($sql);
                exit(json_encode("Payment added successfully"));
            }catch(PDOException  $e){
                if($e->getCode() === '23000'){
                    exit(json_encode("23000"));
                }
            } exit(json_encode("Payment added successfully"));
		}
		 exit(json_encode("Add fails"));
	}
}

if (isset($_GET["update"]) && $_GET["update"] == "1")
{
    $str = json_decode(file_get_contents('php://input'),true);

	if(isset($str)){
       $payment_id = $str['obj']['payment_id'];
       $payment_from = $str['obj']['payment_from'];
       $payment_to = $str['obj']['payment_to'];
       $payment_amountPaid = $str['obj']['payment_amountPaid'];
       $payment_outstandingAmount = $str['obj']['payment_outstandingAmount'];
       $enrolment_id = $str['obj']['enrolment_id'];
      
        $query = "select count(*) from payment where payment_id =$payment_id";        
        $checkedNum = rowCheck($query,$conn);
        if($checkedNum){
            try{
                $sql = "update payment set payment_from = '$payment_from', payment_to = '$payment_to', payment_amountPaid = $payment_amountPaid, payment_outstandingAmount = $payment_outstandingAmount, enrolment_id =$enrolment_id where payment_id = $payment_id";
                $stmt = $conn->query($sql);
                exit(json_encode("Payment updated successfully"));
            }catch(PDOException  $e){
                if($e->getCode() === '23000'){
                    exit(json_encode("23000"));
                }
            }
        }else{
            exit(json_encode("Payment record doen't exist"));
        }
    }
}

if (isset($_GET["remove"]) && $_GET["remove"] == "1")
{
    $str = json_decode(file_get_contents('php://input'),true);

	if(isset($str)){
        $payment_id = $str['obj']['payment_id'];
        $query = "select count(*) from payment where payment_id =$payment_id";        
        $checkedNum = rowCheck($query,$conn);
        if($checkedNum){
            try{
                $sql = "delete from payment where payment_id = $payment_id";
                $stmt = $conn->query($sql);
                exit(json_encode("Payment record deleted successfully"));
            }catch(PDOException  $e){
                if($e->getCode() === '23000'){
                    exit(json_encode("23000"));
                }
            }
        }else{
            exit(json_encode("Payment record doen't exist"));
        }
    }
}


// if (isset($_GET["weekEndProcessing"]) && $_GET["weekEndProcessing"] == "1")
// {
  
//         $query = "select enrolment_id, enrolment_numDays,enrolment_numHours from enrolment where enrolment_status ='Y'";
//         $result = dbProcess($query,$conn, $myArray);
//         $current = date("T-m-d");
    
       
//             foreach($result as $row){
//                 try{
//                     $enrolmentRate= countFees( $row['enrolment_numDays'],$row['enrolment_numHours'],50);
//                     //incomplete part
//                     $sql = "insert into payment values(payment_id,'$current', DATEADD(Day, 7, '$current'),$enrolmentRate )";
//             }catch(PDOException  $e){
//                 if($e->getCode() === '23000'){
//                     exit(json_encode("23000"));
//                 }
//             }
//         exit(json_encode("Done"));
      
//     }
      
// }

function countFees($days,$hours,$rate){
    $totalAmt = $days * $hours *  $rate;
    return $totalAmt;
}



function checkEmptyInput($pi=true,$pf=true,$pt=true,$ap=true,$oa=true,$eid=true){
	if(!$pi || !$pf || !$pt || !$ap || !$oa || !$eid){
		return false;
	}
	return true;
}


?>
