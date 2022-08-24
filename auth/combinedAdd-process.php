<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
  header("location: ../login.php");
  exit; 
}else{
  include "../database.php";
}

$myArray = array();

if (isset($_GET["addAllergy"]) && $_GET["addAllergy"] == "1")
{
	$str = json_decode(file_get_contents('php://input'),true);

	if(isset($str)){
        $child_id = $str['child_id'];
        $alle_code = $str['alle_code'];
        $guardian_id = $str['guardian_id'];
        $staff_id = $str['staff_id'];

		if($child_id != "" && $alle_code != "" ){
			try{
				$sql = "insert into child_allergy values( $child_id,$alle_code)";
				$stmt = $conn->query($sql);
				exit("Allergy added successfully");
			}catch(PDOException  $e){
				$errorMessage = $e->getCode();
				exit("Allergy record exist");
				}
		}else{
			exit("Please select the child ID and allergy Code");
		}
	}
}

if (isset($_GET["addGuardian"]) && $_GET["addGuardian"] == "1")
{
	$str = json_decode(file_get_contents('php://input'),true);

	if(isset($str)){
        $child_id = $str['child_id'];
        $guardian_id_arr = $str['guardian_id'];
		if(count($guardian_id_arr) == 0 || $child_id == ""){
			exit("Please select the child ID and guardian ID");
		}else
		foreach($guardian_id_arr as $guardian_id ){
			{
				try{
					$sql = "insert into child_guardian values($child_id,$guardian_id)";
					$stmt = $conn->query($sql);
				}catch(PDOException  $e){
					$errorMessage = $e->getCode();
					exit("Guardian record exist");
					}
			}
		}
		exit("Guardian added successfully");
	}
}


if (isset($_GET["addStaff"]) && $_GET["addStaff"] == "1")
{
	$str = json_decode(file_get_contents('php://input'),true);

	if(isset($str)){
        $child_id = $str['child_id'];
        $staff_id = $str['staff_id'];

		if($child_id != "" && $staff_id != "" ){
			$checkedChildNum = 	staffRowCheck($staff_id,$conn);
			if($checkedChildNum){
				try{
					$sql = "insert into staff_child values($staff_id,$child_id)";
					$stmt = $conn->query($sql);
					exit("Staff assigned to this child successfully");
				}catch(PDOException  $e){
					if($e->getCode() === '23000'){
						exit("Staff assignment Record exist");
					}
				}
			}else{
				exit("One staff can only takecare of four children");
			}
		}else{
			exit("Please select the Staff ID and Child ID");
		}
	}
}

if (isset($_GET["addEnrolment_status"]) && $_GET["addEnrolment_status"] == "1")
{
	$str = json_decode(file_get_contents('php://input'),true);
	if(isset($str)){
		$enrolment_id = $str['enrolment_id'];
        $enrolment_status = $str['enrolment_status'];
		if($enrolment_id != "" && $enrolment_status != "" ){
			try{
				$sql = "update enrolment set enrolment_status = '$enrolment_status'
				where enrolment_id = $enrolment_id";
				$stmt = $conn->query($sql);
				exit("Enrolment status changed successfully");
			}catch(PDOException  $e){
				// if($e->getCode() === '23000'){
				// 	exit("Staff assignment Record exist");
				// }
				$errorMessage = $e->getMessage();
				exit($errorMessage);
			}
		}else{
			exit("Please select the Child ID and the Enrolment Status");
		}
		exit("Child must enroled before changing the status");
	}
}





if (isset($_GET["loadChild"]) && $_GET["loadChild"] == "1")
{
	$sql = "select child_id , concat(' ', child_fname, ' ' ,child_lname, ' ') as child_name from child";
	$stmt = $conn->query($sql);
	$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
	if ($data)
	{
    foreach($data as $row)
		{
			array_push($myArray, $row);
		}
		exit(json_encode($myArray));
	}
}

if (isset($_GET["loadAllergy"]) && $_GET["loadAllergy"] == "1")
{
	$sql = "select alle_code, alle_description from allergy";
	$stmt = $conn->query($sql);
	$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
	if ($data)
	{
    foreach($data as $row)
		{
			array_push($myArray, $row);
		}
		exit(json_encode($myArray));
	}
}
if (isset($_GET["loadGuardian"]) && $_GET["loadGuardian"] == "1")
{
	$sql = "select guardian_id, concat(' ', guardian_fname, ' ' ,guardian_lname, ' ') as guardian_name from guardian";
	$stmt = $conn->query($sql);
	$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
	if ($data)
	{
    foreach($data as $row)
		{
			array_push($myArray, $row);
		}
		exit(json_encode($myArray));
	}
}
if (isset($_GET["loadStaff"]) && $_GET["loadStaff"] == "1")
{
	$sql = "select staff_id, concat(' ', staff_fname, ' ' ,staff_lname, ' ') as staff_name from staff";
	$stmt = $conn->query($sql);
	$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
	if ($data)
	{
    foreach($data as $row)
		{
			array_push($myArray, $row);
		}
		exit(json_encode($myArray));
	}
}
if (isset($_GET["loadEnrolmentID"]) && $_GET["loadEnrolmentID"] == "1")
{
	$str = json_decode(file_get_contents('php://input'),true);
	
	if(isset($str)){
		$child_id = $str['child_id'];
	    $found = childEnrolmentCheck($child_id,$conn);
		if($found){
			try{
				$sql = "select enrolment_id from enrolment where child_id = $child_id order by enrolment_id desc limit 1";
				$stmt = $conn->query($sql);
				$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
				
				if ($data){
				foreach($data as $row)
					{
						array_push($myArray, $row);
					}
					 exit(json_encode($myArray));				
				}else{
					$newAsso = array();
					array_push($myArray, $newAsso);//must push obj into array
					exit(json_encode($myArray));
				}
			}catch(PDOException $e){
				$errorMessage = $e->getCode();
				exit($errorMessage);
			}
		}else{
			$newAsso = array();
			array_push($myArray, $newAsso);//must push obj into array
			exit(json_encode($myArray));
		}
			
		
	}
}

function staffRowCheck($sid, $conn){
			$sql = "call GetStaffAssignNum($sid)";
			$stmt = $conn->query($sql);
			$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if ($data){
				foreach($data as $row)
					{
						$StaffCount = ($row["count(*)"]);
					}

				if($StaffCount<4){
					return true;
				}else{
					return false;
				}
			}
			return true;
}
function childEnrolmentCheck($cid, $conn){
	$sql = "call GetChildEnrolmentRows($cid);";
	$stmt = $conn->query($sql);
	$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
	if ($data){
		foreach($data as $row)
			{
				$enrolCount = ($row["count(*)"]);
			}
		if($enrolCount >= 1 ){
			return true;
		}else{
			return false;
		}
	}
	return false;
}

?>
