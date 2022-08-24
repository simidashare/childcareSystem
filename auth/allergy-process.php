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
	$url = "select alle_code , alle_description , alle_symptoms , alle_dth  from allergy";
	$result = dbProcess($url,$conn,$myArray);
    if(!$result){
        exit(json_encode("No record found"));
    }
	exit(json_encode($result));
}

if (isset($_GET["add"]) && $_GET["add"] == "1")
{
	$str = json_decode(file_get_contents('php://input'),true);	
	if(isset($str)){
        $alle_description = $str['obj']['alle_description'];
        $alle_symptoms = $str['obj']['alle_symptoms'];
		$alle_dth = $str['obj']['alle_dth'];
		$inputChecked = checkEmptyInput(true,$alle_description, $alle_symptoms, $alle_dth);
		if($inputChecked){
			$sql = "insert into allergy values(alle_code,'$alle_description','$alle_symptoms','$alle_dth')";;
			$result = dbProcess($sql,$conn,$myArray);
			exit(json_encode("Allergy added successfully"));
		}
		exit(json_encode("Please enter the description symptoms and select if the allergy cause death"));
	}
}

if (isset($_GET["update"]) && $_GET["update"] == "1")
{
    $str = json_decode(file_get_contents('php://input'),true);

	if(isset($str)){
        $alle_code = $str['obj']['alle_code'];
		$alle_description = $str['obj']['alle_description'];
        $alle_symptoms = $str['obj']['alle_symptoms'];
		$alle_dth = $str['obj']['alle_dth'];
        $query = "select count(*) from allergy where alle_code =$alle_code";        
        $checkedNum = rowCheck($query,$conn);
        if($checkedNum){
            try{
                $sql = "update allergy set alle_description = '$alle_description', alle_symptoms = '$alle_symptoms', alle_dth ='$alle_dth' where alle_code = $alle_code";
                $stmt = $conn->query($sql);
                exit(json_encode("Allergy updated successfully"));
            }catch(PDOException  $e){
                if($e->getCode() === '23000'){
                    exit(json_encode("23000"));
                }
            }
        }else{
            exit(json_encode("Allergy record doen't exist"));
        }
    }
}

if (isset($_GET["remove"]) && $_GET["remove"] == "1")
{
    $str = json_decode(file_get_contents('php://input'),true);

	if(isset($str)){
        $alle_code = $str['obj']['alle_code'];
        $query = "select count(*) from allergy where alle_code =$alle_code";        
        $checkedNum = rowCheck($query,$conn);
        if($checkedNum){
            try{
                $sql = "delete from allergy where alle_code = $alle_code";
                $stmt = $conn->query($sql);
                exit(json_encode("Allergy deleted successfully"));
            }catch(PDOException  $e){
                if($e->getCode() === '23000'){
                    exit(json_encode("23000"));
                }
            }
        }else{
            exit(json_encode("Allergy record doen't exist"));
        }
    }
}


if (isset($_GET["search"]) && $_GET["search"] == "1")
{
    $str = json_decode(file_get_contents('php://input'),true);

	if(isset($str)){       
        $alle_code = $str['obj']['alle_code'];         
        try{
            $sql = "select * from allergy where alle_code = $alle_code;"; 
            $stmt = $conn->query($sql);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($data){
                foreach($data as $row){
                    array_push($myArray,$row);
                }
                exit(json_encode($myArray));
            }else{
                exit(json_encode("No record found"));
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


function checkEmptyInput($alc=true,$ald=true,$als=true,$aldth=true){
	if(!$alc || !$ald || !$als || !$aldth ){
		return false;
	}
	return true;
}


?>
