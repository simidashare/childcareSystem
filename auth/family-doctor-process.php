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
        $family_id = $str['family_id'];
        $doc_id = $str['doc_id'];
        try{
            $sql = "insert into family_doctor values($family_id,$doc_id)";
            $stmt = $conn->query($sql);
            exit(json_encode("Doctor added successfully"));
        }catch(PDOException  $e){
            if($e->getCode() === '23000'){
                exit(json_encode("Doctor record exist"));
            }
        }	
    }
}

if (isset($_GET["remove"]) && $_GET["remove"] == "1")
{
    $str = json_decode(file_get_contents('php://input'),true);

	if(isset($str)){
        $family_id = $str['family_id'];
        $doc_id = $str['doc_id'];
        $query = "select count(*) from family_doctor where family_id =$family_id AND doc_id = $doc_id";        
        $checkedNum = rowCheck($query,$conn);
        if($checkedNum){
            try{
                $sql = "delete from family_doctor where family_id = $family_id AND doc_id = $doc_id";
                $stmt = $conn->query($sql);
                exit(json_encode("Doctor deleted successfully"));
            }catch(PDOException  $e){
                if($e->getCode() === '23000'){
                    exit(json_encode("Doctor record doen't exist"));
                }
            }
        }else{
            exit(json_encode("Doctor record doen't exist"));
        }
    }
}

// if (isset($_GET["update"]) && $_GET["update"] == "1")
// {
//     $str = json_decode(file_get_contents('php://input'),true);

// 	if(isset($str)){
//         $family_id = $str['family_id'];
//         $doc_id = $str['doc_id'];
//         // $query = "select count(*) from family_doctor where doc_id = $doc_id AND family_id = $family_id";        
//         // $checkedNum = rowCheck($query,$conn);
//         // if($checkedNum){
//             try{
//                 $sql = "update family_doctor set doc_id =$doc_id where doc_id = (select doc_id from family_doctor where family_id = $family_id order by doc_id desc limit 1) and family_id = $family_id";
//                 $stmt = $conn->query($sql);
//                 exit(json_encode("Doctor updated successfully"));
//             }catch(PDOException  $e){
//                 if($e->getCode() === '23000'){
//                     exit(json_encode('Doctor record is exist'));
//                 }
//             }
//     //     }else{
//     //         exit(json_encode("Doctor record doen't exist"));
//     //     }
//     }
// }


if (isset($_GET["search"]) && $_GET["search"] == "1")
{
    $str = json_decode(file_get_contents('php://input'),true);

	if(isset($str)){
        $family_id = $str['family_id'];
        $doc_id = $str['doc_id'];         
        try{
            $sql = "select f.family_id , f.family_name, d.doc_id ,concat(d.doc_fname,' ',d.doc_lname) as doc_name from family as f join family_doctor as fd on f.family_id= fd.family_id join doctor as d on fd.doc_id = d.doc_id where fd.family_id = $family_id;"; 
            $stmt = $conn->query($sql);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($data){
                foreach($data as $row){
                    array_push($myArray,$row);
                }
                exit(json_encode($myArray));
            }else{
                exit(json_encode("No doc record found for this family"));
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
            $sql = "select f.family_id , f.family_name, d.doc_id ,concat(d.doc_fname,' ',d.doc_lname) as doc_name from family as f join family_doctor as fd on f.family_id= fd.family_id join doctor as d on fd.doc_id = d.doc_id order by family_id";
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
