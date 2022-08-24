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
	$url = "select * from enrolment";
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
        $enrolment_id = $str['obj']['enrolment_id'];         
        try{
            $sql = "select * from enrolment where enrolment_id = $enrolment_id;"; 
            $stmt = $conn->query($sql);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($data){
                foreach($data as $row){
                    array_push($myArray,$row);
                }
                exit(json_encode($myArray));
            }else{
                exit(json_encode("No record found for this enrolment"));
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
        $enrolment_startDate = $str['obj']['enrolment_startDate'];
        $enrolment_endDate = $str['obj']['enrolment_endDate'];
        $enrolment_numDays = $str['obj']['enrolment_numDays'];
        $enrolment_numHours = $str['obj']['enrolment_numHours'];
        $child_id = $str['obj']['child_id'];
        $enrolment_status = $str['obj']['enrolment_status'];       
   
		$inputChecked = checkEmptyInput(true, $enrolment_startDate,$enrolment_endDate, $enrolment_numDays, $enrolment_numHours, $child_id, $enrolment_status);
		if($inputChecked){
            try{
                $sql = "insert into enrolment values(enrolment_id,'$enrolment_startDate','$enrolment_endDate','$enrolment_numDays','$enrolment_numHours','$child_id','$enrolment_status')";
			     $stmt = $conn->query($sql);		
		    	exit(json_encode("Enrolment record added successfully"));
                }catch(PDOException $e){
                    $err = $e->getMessage();
                    exit(json_encode($e));
                }			
		}else{
            exit(json_encode("Please fills in all of the input field"));
        }		
	}
}

if (isset($_GET["update"]) && $_GET["update"] == "1")
{
    $str = json_decode(file_get_contents('php://input'),true);

	if(isset($str)){
       $enrolment_id = $str['obj']['enrolment_id'];
       $enrolment_startDate = $str['obj']['enrolment_startDate'];
       $enrolment_endDate = $str['obj']['enrolment_endDate'];
       $enrolment_numDays = $str['obj']['enrolment_numDays'];
       $enrolment_numHours = $str['obj']['enrolment_numHours'];
       $child_id = $str['obj']['child_id'];
       $enrolment_status = $str['obj']['enrolment_status'];
      
        $query = "select count(*) from enrolment where enrolment_id =$enrolment_id";        
        $checkedNum = rowCheck($query,$conn);
        if($checkedNum){
            try{
                $sql = "update enrolment set enrolment_startDate = '$enrolment_startDate', enrolment_endDate = '$enrolment_endDate', enrolment_numDays = '$enrolment_numDays',enrolment_numHours ='$enrolment_numHours', child_id ='$child_id', enrolment_status = '$enrolment_status' where enrolment_id = $enrolment_id";
                $stmt = $conn->query($sql);
                exit(json_encode("Enrolment updated successfully"));
            }catch(PDOException  $e){
                if($e->getCode() === '23000'){
                    exit(json_encode("23000"));
                }
            }
        }else{
            exit(json_encode("Enrolment record doen't exist"));
        }
    }
}

if (isset($_GET["remove"]) && $_GET["remove"] == "1")
{
    $str = json_decode(file_get_contents('php://input'),true);

	if(isset($str)){
        $enrolment_id = $str['obj']['enrolment_id'];
        $query = "select count(*) from enrolment where enrolment_id =$enrolment_id";        
        $checkedNum = rowCheck($query,$conn);
        if($checkedNum){
            try{
                $sql = "delete from enrolment where enrolment_id = $enrolment_id";
                $stmt = $conn->query($sql);
                exit(json_encode("Enrolment record deleted successfully"));
            }catch(PDOException  $e){
                if($e->getCode() === '23000'){
                    exit(json_encode("23000"));
                }
            }
        }else{
            exit(json_encode("Enrolment record doen't exist"));
        }
    }
}

function checkEmptyInput($eid=true,$esd=true,$eed=true,$end=true,$enh=true,$cid=true,$es=true){
	if(!$eid || !$esd || !$eed || !$end || !$enh || !$cid ||!$es  ){
		return false;
	}
	return true;
}


?>
