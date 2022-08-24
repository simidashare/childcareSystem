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
        $guardian_id = $str['guardian_id'];
        try{
            $sql = "insert into child_guardian values($child_id,$guardian_id)";
            $stmt = $conn->query($sql);
            exit(json_encode("Guardian added successfully"));
        }catch(PDOException  $e){
            if($e->getCode() === '23000'){
                exit(json_encode("23000"));
            }
        }	
    }
}

if (isset($_GET["remove"]) && $_GET["remove"] == "1")
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

if (isset($_GET["update"]) && $_GET["update"] == "1")
{
    $str = json_decode(file_get_contents('php://input'),true);

	if(isset($str)){
        $child_id = $str['child_id'];
        $guardian_id = $str['guardian_id'];
        $guardian_id2 = $str['guardian_id2'];
       
        $query = "select count(*) from child_guardian where guardian_id = $guardian_id AND child_id = $child_id";        
        $checkedNum = rowCheck($query,$conn);
       
        if($checkedNum){
            try{
                $sql = "update child_guardian set guardian_id =$guardian_id2 where guardian_id = $guardian_id AND child_id = $child_id";
                $stmt = $conn->query($sql);
                exit(json_encode("Guardian updated successfully"));
            }catch(PDOException  $e){
                if($e->getCode() === '23000'){
                    exit(json_encode('Guardian record is exist'));
                }
            }
        }
      
        exit(json_encode("Guardian record doen't exist"));
    }
}


if (isset($_GET["search"]) && $_GET["search"] == "1")
{
    $str = json_decode(file_get_contents('php://input'),true);

	if(isset($str)){
        $child_id = $str['child_id'];
        $guardian_id = $str['guardian_id'];  
               
        try{
            $sql = "select c.child_id ,concat(c.child_fname ,' ',c.child_lname) as child_name,g.guardian_id ,concat(g.guardian_fname,' ',g.guardian_lname) as guardian_name from child as c join child_guardian as cg on c.child_id= cg.child_id join guardian as g on cg.guardian_id = g.guardian_id where c.child_id = $child_id;"; 
            $stmt = $conn->query($sql);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($data){
                foreach($data as $row){
                    array_push($myArray,$row);
                }
                exit(json_encode($myArray));
            }else{
                exit(json_encode("No guardian record found for this child"));
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
            $sql = "select c.child_id ,concat(c.child_fname ,' ',c.child_lname) as child_name,g.guardian_id ,concat(g.guardian_fname,' ',g.guardian_lname) as guardian_name from child as c join child_guardian as cg on c.child_id= cg.child_id join guardian as g on cg.guardian_id = g.guardian_id order by child_id;";
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
