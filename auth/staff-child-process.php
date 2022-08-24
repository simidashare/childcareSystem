<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
  header("location: ../login.php"); 
  exit;
}else{
  include "../database.php";
  include "./checkingUnits.php";
}

$myArray = array();

if (isset($_GET["add"]) && $_GET["add"] == "1")
{
	$str = json_decode(file_get_contents('php://input'),true);

	if(isset($str)){
        $child_id = $str['child_id'];
        $staff_id = $str['staff_id'];
        $query = "call GetStaffAssignNum($staff_id)";//take note here
		$childPerStaff = rowCheck($query,$conn);
        $checkChildNumForStaff = checkStaffLimit($childPerStaff);
			if($checkChildNumForStaff){
				try{
					$sql = "insert into staff_child values($staff_id,$child_id)";
					$stmt = $conn->query($sql);
					exit(json_encode("Staff assigned to this child successfully"));
				}catch(PDOException  $e){
					if($e->getCode() === '23000'){
						exit(json_encode("Staff assignment record exist"));
					}
				}
			}else{
				exit(json_encode("One staff can only takecare of four children"));
			}
		}else{
			exit(json_encode("Please select the Staff ID and Child ID"));
		}
	
}

if (isset($_GET["remove"]) && $_GET["remove"] == "1")
{
    $str = json_decode(file_get_contents('php://input'),true);

	if(isset($str)){
        $child_id = $str['child_id'];
        $staff_id = $str['staff_id'];
        $query = "select count(*) from staff_child where child_id =$child_id AND staff_id = $staff_id";        
        $checkedNum = rowCheck($query,$conn);
        if($checkedNum){
            try{
                $sql = "delete from staff_child where child_id = $child_id AND staff_id = $staff_id";
                $stmt = $conn->query($sql);
                exit(json_encode("Staff assignment deleted successfully"));
            }catch(PDOException  $e){
                if($e->getCode() === '23000'){
                    exit(json_encode("Assignment record doen't exist"));
                }
            }
        }else{
            exit(json_encode("Assignment record doen't exist"));
        }
    }
}

if (isset($_GET["update"]) && $_GET["update"] == "1")
{
    $str = json_decode(file_get_contents('php://input'),true);

	if(isset($str)){
        $child_id = $str['child_id'];
        $staff_id = $str['staff_id'];
        $query = "select count(*) from staff_child where staff_id = $staff_id";        
        $checkedNum = rowCheck($query,$conn);
        if($checkedNum){
            try{
                $sql = "update staff_child set child_id =$child_id where  
                child_id = (select child_id from staff_child where staff_id = $staff_id order by child_id desc limit 1) 
                and staff_id = $staff_id";
                $stmt = $conn->query($sql);
                exit(json_encode("Staff assignment updated successfully"));
            }catch(PDOException  $e){
                if($e->getCode() === '23000'){
                    exit(json_encode('Staff assignment record is exist'));
                }
            }
        }else{
            exit(json_encode("Assignment record doen't exist"));
        }
    }
}


if (isset($_GET["search"]) && $_GET["search"] == "1")
{
    $str = json_decode(file_get_contents('php://input'),true);

	if(isset($str)){
        $child_id = $str['child_id'];
        $staff_id = $str['staff_id'];         
        try{
            $sql = "call searchStaffChild($staff_id);";  ;
            $stmt = $conn->query($sql);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($data){
                foreach($data as $row){
                    array_push($myArray,$row);
                }
                exit(json_encode($myArray));
            }
        }catch(PDOException $e){
                if($e->getCode() === "23000"){
                    exit(json_encode("Record does not exist"));
                }
        }	
    }
}

if (isset($_GET["viewAll"]) && $_GET["viewAll"] == "1")
{   
        try{
            $sql = "Call viewAllStaffChild();";
            $stmt = $conn->query($sql);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($data)
            {
              foreach($data as $row)
              {		
                array_push($myArray, $row);
              }	      
              exit(json_encode($myArray));	
            }else{
                    exit(json_encode("No record found"));
            }
        }catch(PDOException  $e){
            if($e->getCode() === '23000'){
                exit(json_encode("23000"));
            }
        }
    
}


?>
