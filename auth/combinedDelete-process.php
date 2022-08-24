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



if (isset($_GET["removeAllergy"]) && $_GET["removeAllergy"] == "1")
{
    $str = json_decode(file_get_contents('php://input'),true);

	if(isset($str)){
        $child_id = $str['child_id'];
        $alle_code = $str['alle_code'];
        $query = "select count(*) from child_allergy where child_id =$child_id AND alle_code = $alle_code";        
        $checkedNum = rowCheck($query,$conn);
        if($checkedNum){
            try{
                $sql = "delete from child_allergy where child_id = $child_id AND alle_code = $alle_code";
                $stmt = $conn->query($sql);
                exit(json_encode("Allergy deleted successfully"));
            }catch(PDOException  $e){
                if($e->getCode() === '23000'){
                    exit(json_encode("Allergy record doen't exist"));
                }
            }
        }else{
            exit(json_encode("Allergy record doen't exist"));
        }
    }
}

if (isset($_GET["removeGuardian"]) && $_GET["removeGuardian"] == "1")
{
    $str = json_decode(file_get_contents('php://input'),true);

	if(isset($str)){
        $child_id = $str['child_id'];
        $guardian_id = $str['guardian_id'];
        $query = "select count(*) from child_guardian where child_id =$child_id AND guardian_id = $guardian_id";        
        $checkedNum = rowCheck($query,$conn);
        if($checkedNum){
            try{
                $sql = "delete from child_guardian where child_id = $child_id AND guardian_id = $guardian_id";
                $stmt = $conn->query($sql);
                exit(json_encode("Guardian deleted successfully"));
            }catch(PDOException  $e){
                if($e->getCode() === '23000'){
                    exit(json_encode("Guardian record doen't exist"));
                }
            }
        }else{
            exit(json_encode("Guardian record doen't exist"));
        }
    }
}

if (isset($_GET["removeStaff"]) && $_GET["removeStaff"] == "1")
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
                exit(json_encode("Staff deleted successfully"));
            }catch(PDOException  $e){
                if($e->getCode() === '23000'){
                    exit(json_encode("Staff record doen't exist"));
                }
            }
        }else{
            exit(json_encode("Staff record doen't exist"));
        }
    }
}

?>
