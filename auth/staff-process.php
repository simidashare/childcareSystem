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
	$url = "select *  from staff";
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
        $staff_id = $str['obj']['staff_id'];           
        $query = "select count(*) from days where staff_id =$staff_id";
        $chkDuty= rowCheck($query,$conn);
        if($chkDuty){
            try{
                $sql = "select s.staff_id, s.staff_fname,s.staff_lname,s.staff_gender, s.staff_homePhone,s.staff_workPhone,s.staff_mobile,s.registration_key, d.monday,d.tuesday,d.wednesday,d.thursday,d.friday,d.saturday from staff as s join days as d on d.staff_id = s.staff_id where d.staff_id = $staff_id"; 
                $stmt = $conn->query($sql);
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if ($data){
                    foreach($data as $row){
                        array_push($myArray,$row);
                    }
                    exit(json_encode($myArray));
                }else{
                    exit(json_encode("No record found for this staff"));
                }
            }catch(PDOException $e){
                    $err= $e->getMessage();
                    exit(json_encode($err));
            }
        }else{
            try{
                $sql = "select * from staff where staff_id = $staff_id"; 
                $stmt = $conn->query($sql);
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if ($data){
                    foreach($data as $row){
                        array_push($myArray,$row);
                    }
                    exit(json_encode($myArray));
                }else{
                    exit(json_encode("No record found for this staff"));
                }
            }catch(PDOException $e){
                    $err= $e->getMessage();
                    exit(json_encode($err));
            }
        }
    }
}



if (isset($_GET["add"]) && $_GET["add"] == "1")
{
	$str = json_decode(file_get_contents('php://input'),true);	
	if(isset($str)){
        
        $staff_workPhone = $str['obj']['staff_workPhone'];
        $staff_mobile = $str['obj']['staff_mobile'];
        $registration_key = $str['obj']['registration_key'];
        $staff_homePhone = $str['obj']['staff_homePhone'];
        $staff_gender = $str['obj']['staff_gender'];
        $staff_lname = $str['obj']['staff_lname'];
        $staff_fname = $str['obj']['staff_fname'];
        $on_duty_arr = $str['obj']['on_duty'];
        $currentStaffAi = checkAi($conn, $myArray);
		$inputChecked = checkEmptyInput(true,$staff_fname, $staff_lname, $staff_gender, $staff_homePhone,$staff_workPhone,$staff_mobile,$registration_key);
		if($inputChecked){         
			// $sql = "insert into staff values(staff_id,'$staff_fname','$staff_lname','$staff_gender','$staff_homePhone','$staff_workPhone','$staff_mobile','$registration_key')";;
			// $result = dbProcess($sql,$conn,$myArray);
          
            $sql = "insert into staff values(staff_id,'$staff_fname','$staff_lname','$staff_gender','$staff_homePhone','$staff_workPhone','$staff_mobile','$registration_key')";;
            $stmt = $conn->query($sql);

            $staffDaysDone = addStaffDays($currentStaffAi,$on_duty_arr,$conn);
            exit(json_encode("Staff added successfully"));		
		}else{
            exit(json_encode("Staff first name, last name, gender, home phone, work phone, mobile, registration key are required"));
        }
	}
}

if (isset($_GET["update"]) && $_GET["update"] == "1")
{
    $str = json_decode(file_get_contents('php://input'),true);

	if(isset($str)){
       $staff_id = $str['obj']['staff_id'];
       $staff_fname = $str['obj']['staff_fname'];
       $staff_lname = $str['obj']['staff_lname'];
       $staff_gender = $str['obj']['staff_gender'];
       $staff_homePhone = $str['obj']['staff_homePhone'];
       $staff_workPhone = $str['obj']['staff_workPhone'];
       $staff_mobile = $str['obj']['staff_mobile'];
       $registration_key = $str['obj']['registration_key'];
       $on_duty_arr = $str['obj']['on_duty'];
        $query = "select count(*) from staff where staff_id =$staff_id";        
        $checkedNum = rowCheck($query,$conn);
        if($checkedNum){
            try{
                $sql = "update staff set registration_key = '$registration_key',staff_mobile = '$staff_mobile',staff_workPhone ='$staff_workPhone',staff_homePhone ='$staff_homePhone',staff_fname = '$staff_fname',staff_lname = '$staff_lname',staff_gender = '$staff_gender' where staff_id = $staff_id";
                // $result = dbProcess($sql,$conn,$myArray);	
                $stmt = $conn->query($sql);
                
                $staffDaysDone = addStaffDays($staff_id,$on_duty_arr,$conn);
                exit(json_encode("Staff updated successfully"));
            }catch(PDOException  $e){
                if($e->getCode() === '23000'){
                    exit(json_encode("Cannot update parent record"));
                }
            }
        }else{
            exit(json_encode("Staff record doen't exist"));
        }
    }
}

if (isset($_GET["remove"]) && $_GET["remove"] == "1")
{
    $str = json_decode(file_get_contents('php://input'),true);

	if(isset($str)){
        $staff_id = $str['obj']['staff_id'];
        $query = "select count(*) from staff where staff_id =$staff_id";        
        $checkedNum = rowCheck($query,$conn);
        if($checkedNum){
            $on_duty_arr = [];
            $staffDaysDone = addStaffDays($staff_id,$on_duty_arr,$conn);
            try{
                $sql = "delete from staff where staff_id = $staff_id";
                $stmt = $conn->query($sql);
                exit(json_encode("Staff deleted successfully"));
            }catch(PDOException  $e){
                if($e->getCode() === '23000'){
                    exit(json_encode("Cannot delete a parent record"));
                }
            }
        }else{
            exit(json_encode("Staff record doen't exist"));
        }
    }
}

function checkEmptyInput($sid=true,$sfn=true,$sln=true,$sgen=true,$shp=true,$swp=true,$sm=true,$rk=true){
	if(!$sid || !$sfn || !$sln || !$sgen || !$shp || !$swp ||!$sm ||!$rk ){
		return false;
	}
	return true;
}
function checkAi($conn, $myArray){
	$sql = "SELECT `AUTO_INCREMENT`
	FROM  INFORMATION_SCHEMA.TABLES
	WHERE TABLE_SCHEMA = 'childcare'
	AND   TABLE_NAME   = 'staff'";
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

function addStaffDays($staff_id, $on_duty_arr, $conn){
    if(count($on_duty_arr) > 0 ){
        $initialedDays = insertDays($staff_id, $conn);
        foreach($on_duty_arr as $on_duty ){
            switch($on_duty){
                case '1':
                    try{
                        $sql = "update days set monday = 1 where staff_id = $staff_id";
                        $stmt = $conn->query($sql);
                    }catch(PDOException  $e){
                        $errorMessage = $e->getCode();
                        exit($errorMessage);
                    }
                    break;
                case '2':
                    try{
                        $sql = "update days set tuesday = 1 where staff_id = $staff_id";
                        $stmt = $conn->query($sql);
                    }catch(PDOException  $e){
                        $errorMessage = $e->getCode();
                        exit($errorMessage);
                    }
                    break; 
                case '3':
                    try{
                        $sql = "update days set wednesday = 1 where staff_id = $staff_id";
                        $stmt = $conn->query($sql);
                    }catch(PDOException  $e){
                        $errorMessage = $e->getCode();
                        exit($errorMessage);
                    }
                    break; 
                case '4':
                    try{
                        $sql = "update days set thursday = 1 where staff_id = $staff_id";
                        $stmt = $conn->query($sql);
                    }catch(PDOException  $e){
                        $errorMessage = $e->getCode();
                        exit($errorMessage);
                    }
                    break; 
                case '5':
                    try{
                        $sql = "update days set friday = 1 where staff_id = $staff_id";
                        $stmt = $conn->query($sql);
                    }catch(PDOException  $e){
                        $errorMessage = $e->getCode();
                        exit($errorMessage);
                    }
                    break; 
                case '6':
                    try{
                        $sql = "update days set saturday = 1 where staff_id = $staff_id";
                        $stmt = $conn->query($sql);
                    }catch(PDOException  $e){
                        $errorMessage = $e->getCode();
                        exit($errorMessage);
                    }
                    break; 
            }
        }
    }else{
        $query = "select count(*) from days where staff_id =$staff_id";
        $chkDuty= rowCheck($query,$conn);
        if($chkDuty){
            try{
                $sql = "delete from days where staff_id = $staff_id";
                $stmt = $conn->query($sql);
            }catch(PDOException  $e){
                $errorMessage = $e->getCode();
                exit($errorMessage);
            }
        }
    }
    return false;
}




function insertDays($staff_id, $conn){
    try{
        $sql = "insert into days values(days_id,0,0,0,0,0,0,$staff_id)";
        $stmt = $conn->query($sql);
    }catch(PDOException  $e){
        $errorMessage = $e->getCode();
        exit($errorMessage);
    }
    
}


?>
