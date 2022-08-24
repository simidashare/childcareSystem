<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
  header("location: ../login.php"); 
  exit; 
}else{
  include "../database.php";
}

$myArray = array();
$addState = null;
$currentChildAi = null;

if (isset($_GET["viewAll"]) && $_GET["viewAll"] == "1")
{
	$url = "call viewAllChild()";
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
		$searchResult = 0;
		$child_id = $str['obj']['child_id'];
		$checkhedInput = checkEmptyInput($child_id);	
		if($checkhedInput){
			$searchResult = searchChild($child_id,$conn,$myArray);	
		}	
		if($searchResult != 0){
			$url="CALL searchChildAllergy($child_id)";
			$result = dbProcess($url,$conn,$myArray);
			exit(json_encode($result));
			}
			exit(json_encode("Child does no exist"));
	}
}

if (isset($_GET["remove"]) && $_GET["remove"] == "1")
{
	$str = json_decode(file_get_contents('php://input'),true);	
	if(isset($str)){
		$child_id = $str['obj']['child_id'];
		$alle_code = $str['obj']['alle_code'];
		$checkhedInput = checkEmptyInput($child_id);	
		$childChecked= chkChild($child_id,$conn,$myArray);
		if($childChecked == "1" && $checkhedInput == true){
			$alleDone = removeAllergy($child_id,$alle_code,$conn,$myArray);
			$url = "delete from child where child_id = $child_id";
			$result = dbProcess($url,$conn,$myArray);
			if($result == "23000"){
				exit(json_encode("Cannot Delete Parent with child table"));
			}else{
				exit(json_encode("Child delete successfully"));
			}
			
		}
	}
}

if (isset($_GET["add"]) && $_GET["add"] == "1")
{
	$str = json_decode(file_get_contents('php://input'),true);	
	if(isset($str)){
        $child_fname = $str['obj']['child_fname'];
        $child_lname = $str['obj']['child_lname'];
        $child_dob = $str['obj']['child_dob'];
		$child_gender = $str['obj']['child_gender'];
		$alle_code = $str['obj']['alle_code'];
		$checkhedInput = checkEmptyInput(true,$child_fname, $child_lname, $child_dob, $child_gender);
		$currentChildAi = checkAi($conn, $myArray);
		if($checkhedInput){
			$url = "insert into child values(child_id,'$child_fname','$child_lname','$child_dob','$child_gender')";;
			$result = dbProcess($url,$conn,$myArray);
			$alleDone = addAllergy($currentChildAi,$alle_code,$conn,$myArray);
			if($alleDone){
				exit(json_encode("Child and allergy added successfully"));
			}else{
				exit(json_encode("Child added successfully"));
			}			
		}
		exit(json_encode("Please enter First Name, Last Name, Date of Birth and Gender"));
	}
}


if (isset($_GET["update"]) && $_GET["update"] == "1")
{
	$str = json_decode(file_get_contents('php://input'),true);	
	if(isset($str)){
		$child_id = $str['obj']['child_id'];
        $child_fname = $str['obj']['child_fname'];
        $child_lname = $str['obj']['child_lname'];
        $child_dob = $str['obj']['child_dob'];
		$child_gender = $str['obj']['child_gender'];
		$alle_code = $str['obj']['alle_code'];
		$checkhedInput = checkEmptyInput($child_id,$child_fname, $child_lname, $child_dob, $child_gender);
		
	 	if($checkhedInput){
			$url = "update child set child_fname = '$child_fname',child_lname ='$child_lname',child_dob ='$child_dob',child_gender = '$child_gender' where child_id = $child_id";
			$result = dbProcess($url,$conn,$myArray);			
			$alleDone = updateAllergy($child_id,$alle_code,$conn,$myArray);
			exit(json_encode("Child update successfully"));
		}		
		exit(json_encode("Please enter Child ID, First Name, Last Name, Date of Birth and Gender"));
	}
}

function removeAllergy($child_id,$alle_code,$conn,$myArray){
	$url = "delete from child_allergy where child_id = $child_id ";
	$result = dbProcess($url,$conn,$myArray);
	return $result;
}

function updateAllergy($child_id,$alle_code,$conn,$myArray){
	  if($alle_code == -1){			
			$url = "delete from child_allergy where child_id = $child_id";
			$result = dbProcess($url,$conn,$myArray);
			$addState = null;
			$currentChildAi = null;
			// return true;
		}else{
			$alleChecked = checkAlleRecord($child_id, $alle_code, $conn);
			if($alleChecked){
				$url = "insert into child_allergy values($child_id,$alle_code);";
				$result = dbProcess($url,$conn,$myArray);
				$addState = null;
				$currentChildAi = null;
				// return true;
			}
		}
	
}


function addAllergy($child_id,$alle_code,$conn,$myArray){
	if($alle_code != -1){		
		$alleChecked = checkAlleRecord($child_id, $alle_code, $conn);
		if($alleChecked){
			$url = "insert into child_allergy values($child_id,$alle_code);";
			$result = dbProcess($url,$conn,$myArray);
			$addState = null;
			$currentChildAi = null;
			return true;
		}else{
			return false;
		}
	}
	return false;
}
	

if (isset($_GET["loadAllergy"]) && $_GET["loadAllergy"] == "1")
{
	$url = "select alle_code, alle_description from allergy";
	$result = dbProcess($url,$conn,$myArray);
	exit(json_encode($result));
}


function searchChild($child_id,$conn,$myArray){	
			$ctr=0;
			$sql = "call getChildNumberRows($child_id);";
			$stmt = $conn->query($sql);
			$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if($data){
				foreach($data as $row)
				{	
					$ctr++;
				}
				return $ctr;
			}else{
				return $ctr;
			}		
			return $ctr;	
}

function chkChild($child_id,$conn,$myArray){
	$url="select count(*) from child where child_id = $child_id";
	$result = dbProcess($url,$conn,$myArray);
    $countChild = $result[0]['count(*)'];
	return $countChild;
}


function checkEmptyInput($cid=true,$cfn=true,$cln=true,$cdob=true,$cgen=true){
	if(!$cid || !$cfn || !$cln || !$cdob || !$cgen ){
		return false;
	}
	return true;
}
function dbProcess($query, $conn, $myArray){
	try{
		$sql = "$query";
		$stmt = $conn->query($sql);
		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		if($data){
			foreach($data as $row)
			{	
				array_push($myArray, $row);
			}
			return $myArray;
		}			
	}catch(PDOException $e){
		$errorCode = $e->getCode();
			return $errorCode;
	}
}
function checkAlleRecord($childId, $alleCode, $conn){	
	$ctr=0;
	$sql = "select count(*) from child_allergy where child_id = $childId AND alle_code =$alleCode;";
	$stmt = $conn->query($sql);
	$data = $stmt->fetchAll(PDO::FETCH_ASSOC);	
	if($data){
		foreach($data as $row){
			$ctr = ($row["count(*)"]);
		}		
		if($ctr <1){			
			return true;
		}else{
			return false;
		}
	}
	return false;
}
function checkAi($conn, $myArray){
	$sql = "SELECT `AUTO_INCREMENT`
	FROM  INFORMATION_SCHEMA.TABLES
	WHERE TABLE_SCHEMA = 'childcare'
	AND   TABLE_NAME   = 'child'";
	$stmt = $conn->query($sql);
	$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
	if($data){
		foreach($data as $row)
		{	
			$ai = ($row['AUTO_INCREMENT']);	
		}
		return $ai;
	}			
}
?>
