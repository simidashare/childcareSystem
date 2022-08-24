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
	$url = "select * from medicine";
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
        $med_id = $str['obj']['med_id'];         
        try{
            $sql = "select * from medicine where med_id = $med_id;"; 
            $stmt = $conn->query($sql);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($data){
                foreach($data as $row){
                    array_push($myArray,$row);
                }
                exit(json_encode($myArray));
            }else{
                exit(json_encode("No record found for this medicine"));
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
        $med_name = $str['obj']['med_name'];
        $med_dosage = $str['obj']['med_dosage'];
        $med_description = $str['obj']['med_description'];       
		$inputChecked = checkEmptyInput(true, $med_name, $med_dosage, $med_description);
		if($inputChecked){
			$sql = "insert into medicine values(med_id ,'$med_name','$med_dosage','$med_description')";;
			$result = dbProcess($sql,$conn,$myArray);
			exit(json_encode("Medicine added successfully"));
		}
		exit(json_encode("Please fills in all of the input field"));
	}
}

if (isset($_GET["update"]) && $_GET["update"] == "1")
{
    $str = json_decode(file_get_contents('php://input'),true);

	if(isset($str)){
        $med_id = $str['obj']['med_id'];
        $med_name = $str['obj']['med_name'];
        $med_dosage = $str['obj']['med_dosage'];
        $med_description = $str['obj']['med_description']; 
        $query = "select count(*) from medicine where med_id =$med_id";        
        $checkedNum = rowCheck($query,$conn);
        if($checkedNum){
            try{
                $sql = "update medicine set med_name = '$med_name',med_dosage = '$med_dosage',med_description ='$med_description' where med_id = $med_id";
                $stmt = $conn->query($sql);
                exit(json_encode("Medicine updated successfully"));
            }catch(PDOException  $e){
                if($e->getCode() === '23000'){
                    exit(json_encode("23000"));
                }
            }
        }else{
            exit(json_encode("Medicine record doen't exist"));
        }
    }
}

if (isset($_GET["remove"]) && $_GET["remove"] == "1")
{
    $str = json_decode(file_get_contents('php://input'),true);

	if(isset($str)){
        $med_id = $str['obj']['med_id'];;
        $query = "select count(*) from medicine where med_id =$med_id";        
        $checkedNum = rowCheck($query,$conn);
        if($checkedNum){
            try{
                $sql = "delete from medicine where med_id = $med_id";
                $stmt = $conn->query($sql);
                exit(json_encode("Medicine deleted successfully"));
            }catch(PDOException  $e){
                if($e->getCode() === '23000'){
                    exit(json_encode("23000"));
                }
            }
        }else{
            exit(json_encode("Medicine record doen't exist"));
        }
    }
}

function checkEmptyInput($mid=true,$mn=true,$mdo=true,$mds=true){
	if(!$mid || !$mn || !$mdo || !$mds ){
		return false;
	}
	return true;
}


?>
