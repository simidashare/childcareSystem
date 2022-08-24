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
	$url = "select *  from doctor";
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
        $doc_id = $str['obj']['doc_id'];         
        try{
            $sql = "select * from doctor where doc_id = $doc_id;"; 
            $stmt = $conn->query($sql);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($data){
                foreach($data as $row){
                    array_push($myArray,$row);
                }
                exit(json_encode($myArray));
            }else{
                exit(json_encode("No record found for this doctor"));
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
        // $doc_id = $str['obj']['doc_id'];
        $doc_state = $str['obj']['doc_state'];
        $doc_postCode = $str['obj']['doc_postCode'];
        $doc_phone = $str['obj']['doc_phone'];
        $doc_suburb = $str['obj']['doc_suburb'];
        $doc_street = $str['obj']['doc_street'];
        $doc_lname = $str['obj']['doc_lname'];
        $doc_fname = $str['obj']['doc_fname'];
   
		$inputChecked = checkEmptyInput(true,$doc_fname, $doc_lname, $doc_street, $doc_suburb,$doc_state,$doc_postCode,$doc_phone);
		if($inputChecked){
			$sql = "insert into doctor values(doc_id,'$doc_fname','$doc_lname','$doc_street','$doc_suburb','$doc_state','$doc_postCode','$doc_phone')";;
			$result = dbProcess($sql,$conn,$myArray);
			exit(json_encode("Doctor added successfully"));
		}
		exit(json_encode("Please fills in all of the input field"));
	}
}

if (isset($_GET["update"]) && $_GET["update"] == "1")
{
    $str = json_decode(file_get_contents('php://input'),true);

	if(isset($str)){
       $doc_id = $str['obj']['doc_id'];
       $doc_state = $str['obj']['doc_state'];
       $doc_postCode = $str['obj']['doc_postCode'];
       $doc_phone = $str['obj']['doc_phone'];
       $doc_suburb = $str['obj']['doc_suburb'];
       $doc_street = $str['obj']['doc_street'];
       $doc_lname = $str['obj']['doc_lname'];
       $doc_fname = $str['obj']['doc_fname'];
        $query = "select count(*) from doctor where doc_id =$doc_id";        
        $checkedNum = rowCheck($query,$conn);
        if($checkedNum){
            try{
                $sql = "update doctor set doc_fname = '$doc_fname',doc_lname = '$doc_lname',doc_street ='$doc_street',doc_suburb ='$doc_suburb',doc_state = '$doc_state',doc_postCode = '$doc_postCode',doc_phone = '$doc_phone' where doc_id = $doc_id";
                $stmt = $conn->query($sql);
                exit(json_encode("Doctor updated successfully"));
            }catch(PDOException  $e){
                if($e->getCode() === '23000'){
                    exit(json_encode("23000"));
                }
            }
        }else{
            exit(json_encode("Doctor record doen't exist"));
        }
    }
}

if (isset($_GET["remove"]) && $_GET["remove"] == "1")
{
    $str = json_decode(file_get_contents('php://input'),true);

	if(isset($str)){
        $doc_id = $str['obj']['doc_id'];
        $query = "select count(*) from doctor where doc_id =$doc_id";        
        $checkedNum = rowCheck($query,$conn);
        if($checkedNum){
            try{
                $sql = "delete from doctor where doc_id = $doc_id";
                $stmt = $conn->query($sql);
                exit(json_encode("Doctor deleted successfully"));
            }catch(PDOException  $e){
                if($e->getCode() === '23000'){
                    exit(json_encode("23000"));
                }
            }
        }else{
            exit(json_encode("Doctor record doen't exist"));
        }
    }
}

function checkEmptyInput($did=true,$dfn=true,$dln=true,$dstr=true,$dsub=true,$dsta=true,$dpc=true,$dphone=true){
	if(!$did || !$dfn || !$dln || !$dstr || !$dsub || !$dsta ||!$dpc ||!$dphone ){
		return false;
	}
	return true;
}


?>
