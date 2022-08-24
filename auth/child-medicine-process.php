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
        $med_id = $str['med_id'];
        try{
            $sql = "insert into child_medicine values($child_id,$med_id)";
            $stmt = $conn->query($sql);
            exit(json_encode("Medicine added successfully"));
        }catch(PDOException  $e){
            if($e->getCode() === '23000'){
                exit(json_encode("Medicine record exist"));
            }
        }	
    }
}

if (isset($_GET["remove"]) && $_GET["remove"] == "1")
{
    $str = json_decode(file_get_contents('php://input'),true);

	if(isset($str)){
        $child_id = $str['child_id'];
        $med_id = $str['med_id'];
        $query = "select count(*) from child_medicine where child_id =$child_id AND med_id = $med_id";        
        $checkedNum = rowCheck($query,$conn);
        if($checkedNum){
            try{
                $sql = "delete from child_medicine where child_id = $child_id AND med_id = $med_id";
                $stmt = $conn->query($sql);
                exit(json_encode("Medicine deleted successfully"));
            }catch(PDOException  $e){
                if($e->getCode() === '23000'){
                    exit(json_encode("Medicine record doen't exist"));
                }
            }
        }else{
            exit(json_encode("Medicine record doen't exist"));
        }
    }
}

// if (isset($_GET["update"]) && $_GET["update"] == "1")
// {
//     $str = json_decode(file_get_contents('php://input'),true);

// 	if(isset($str)){
//         $child_id = $str['child_id'];
//         $med_id = $str['med_id'];
//         // $query = "select count(*) from child_medicine where med_id = $med_id AND child_id = $child_id";        
//         // $checkedNum = rowCheck($query,$conn);
//         // if($checkedNum){
//             try{
//                 $sql = "update child_medicine set med_id =$med_id where med_id = (select med_id from child_medicine where child_id = $child_id order by med_id desc limit 1) and child_id = $child_id";
//                 $stmt = $conn->query($sql);
//                 exit(json_encode("Medicine updated successfully"));
//             }catch(PDOException  $e){
//                 if($e->getCode() === '23000'){
//                     exit(json_encode('Medicine record is exist'));
//                 }
//             }
//     //     }else{
//     //         exit(json_encode("Medicine record doen't exist"));
//     //     }
//     }
// }


if (isset($_GET["search"]) && $_GET["search"] == "1")
{
    $str = json_decode(file_get_contents('php://input'),true);

	if(isset($str)){
        $child_id = $str['child_id'];
        $med_id = $str['med_id'];         
        try{
            $sql = "select c.child_id ,concat(c.child_fname ,' ',c.child_lname) as child_name,m.med_id ,med_name from child as c join child_medicine as cm on c.child_id = cm.child_id join medicine as m on cm.med_id = m.med_id where c.child_id = $child_id;"; 
            $stmt = $conn->query($sql);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($data){
                foreach($data as $row){
                    array_push($myArray,$row);
                }
                exit(json_encode($myArray));
            }else{
                exit(json_encode("No medicine record found for this child"));
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

if (isset($_GET["viewAll"]) && $_GET["viewAll"] == "1")
{   
        try{
            $sql = "select c.child_id ,concat(c.child_fname ,' ',c.child_lname) as child_name,m.med_id ,med_name from child as c join child_medicine as cm on c.child_id = cm.child_id join medicine as m on cm.med_id = m.med_id order by child_id";
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
