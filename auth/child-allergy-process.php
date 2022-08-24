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
        $alle_code = $str['alle_code'];
        try{
            $sql = "insert into child_allergy values($child_id,$alle_code)";
            $stmt = $conn->query($sql);
            exit(json_encode("Allergy added successfully"));
        }catch(PDOException  $e){
            // if($e->getCode() === '23000'){
            //     exit(json_encode("Allergy record exist"));
            // }
            if(strrpos($e->getMessage() ,'1452')){
                exit(json_encode("1452"));
              }else if(strrpos($e->getMessage() , '1062')){
                exit(json_encode("1062"));
            }
        }	
    }
}

if (isset($_GET["remove"]) && $_GET["remove"] == "1")
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
                // if(strrpos($e->getMessage() ,'1452')){
                //     exit(json_encode("1452"));
                //   }else if(strrpos($e->getMessage() , '1062')){
                //     exit(json_encode("1062"));
                // }
            }
        }else{
            exit(json_encode("Allergy record doen't exist"));
        }
    }
}

if (isset($_GET["update"]) && $_GET["update"] == "1")
{
    $str = json_decode(file_get_contents('php://input'),true);

	if(isset($str)){
        $child_id = $str['child_id'];
        $alle_code = $str['alle_code'];
        $alle_code2 = $str['alle_code2'];
        $query = "select count(*) from child_allergy where alle_code = $alle_code AND child_id = $child_id";        
        $checkedNum = rowCheck($query,$conn);
        if($checkedNum){    
            try{
                // $sql = "update child_allergy set alle_code =$alle_code where alle_code = (select alle_code from child_allergy where child_id = $child_id order by alle_code desc limit 1) and child_id = $child_id";

                $sql = "update child_allergy set alle_code =$alle_code2 where child_id = $child_id  && alle_code =$alle_code";
                $stmt = $conn->query($sql);
                exit(json_encode("Allergy updated successfully"));
            }catch(PDOException  $e){
                if($e->getCode() === '23000'){
                    exit(json_encode('Allergy record is exist'));
                }
            }
        }
        exit(json_encode("Allergy record doen't exist"));
     
    }
}


if (isset($_GET["search"]) && $_GET["search"] == "1")
{
    $str = json_decode(file_get_contents('php://input'),true);

	if(isset($str)){
        $child_id = $str['child_id'];
        $alle_code = $str['alle_code'];         
      
            
        if($alle_code != "" ){
            try{
                $sql = "select a.alle_code ,a.alle_description,c.child_id,concat(c.child_fname ,' ',c.child_lname) as child_name from child as c join child_allergy as ca on c.child_id= ca.child_id join allergy as a on ca.alle_code = a.alle_code where a.alle_code = $alle_code;"; 
                $stmt = $conn->query($sql);
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if ($data){
                    foreach($data as $row){
                        array_push($myArray,$row);
                    }
                    exit(json_encode($myArray));
                }else{
                    exit(json_encode("No allergy record found for this child"));
                }
            }catch(PDOException $e){
                    $err= $e->getMessage();
                    exit(json_encode($err));
            }
        }else{
            try{
                $sql = "select c.child_id ,concat(c.child_fname ,' ',c.child_lname) as child_name,c.child_gender ,a.alle_code ,a.alle_description from child as c join child_allergy as ca on c.child_id= ca.child_id join allergy as a on ca.alle_code = a.alle_code where c.child_id = $child_id;"; 
                $stmt = $conn->query($sql);
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if ($data){
                    foreach($data as $row){
                        array_push($myArray,$row);
                    }
                    exit(json_encode($myArray));
                }else{
                    exit(json_encode("No allergy record found for this child"));
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
}

if (isset($_GET["viewAll"]) && $_GET["viewAll"] == "1")
{   
        try{
            $sql = "select c.child_id ,concat(c.child_fname ,' ',c.child_lname) as child_name, a.alle_code ,a.alle_description from child as c join child_allergy as ca on c.child_id= ca.child_id join allergy as a on ca.alle_code = a.alle_code order by child_id";
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
