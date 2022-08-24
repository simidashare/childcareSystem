<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
  header("location: ../login.php"); 
  exit;
}else{
  include "../database.php";
}

$myArray = array();

if (isset($_GET["loadId"]) && $_GET["loadId"] == "1")
{	
  $sql = "select * from family";
	$stmt = $conn->query($sql);
	$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
	if ($data)
	{
    foreach($data as $row)
		{			
			array_push($myArray, $row);
		}	
		exit(json_encode($myArray));	
	}
}
	
if (isset($_GET["viewAll"]) && $_GET["viewAll"] == 1 ){
    $sql = "select family_id, family_name from family;";
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
}
if (isset($_GET["add"]) && $_GET["add"] == "1")
{
	$family_name=$_POST["family_name"];	
  try{
    $sql = "insert into family values (family_id, '$family_name')";
    $stmt = $conn->query($sql);	
    if ($stmt)
    {	
      exit("family added successfully");
    }
  }catch(PDOException  $e){
    // if($e->getCode() === '23000');  {
    //   exit("Family does not exist");
    // }
    exit("error");
  }
}

if (isset($_GET["remove"]) && $_GET["remove"] == "1")
{
	$family_id = $_POST["family_id"];
	$found = findFamily($family_id, $conn);
	if ($found)
	{
		try
		{
			$sql = "delete from family where family_id = $family_id";
			$stmt = $conn->query($sql);
			if ($stmt)
			{
				exit("Family deleted successfully");
			}
		}
		catch(PDOException $e)
		{
      
			if ($e->getCode() == "23000")
			{
				exit("Can't delete Parent");
			}
		}
	}
	else
	{
		exit("This family does not exist");
	}
}

if (isset($_GET["update"]) && $_GET["update"] == "1")
{
    $family_id=$_POST["family_id"];
    $family_name=$_POST["family_name"];
	$found = findfamily($family_id, $conn);
	if ($found)
	{
	 	try{
		$sql = "update family set family_name = '$family_name'where family_id =  $family_id";
		$stmt = $conn->query($sql);
		if ($stmt){
			exit("family updated successfully");
			}
		}catch(PDOException $e){
    		  if($e->getCode() === "23000"){
       			 exit("Family does not exist");
				}
    	}	
	}else{
		exit("Family does not exist");
	}
}

if (isset($_GET["search"]) && $_GET["search"] == "1")
{
    $family_id=$_POST["family_id"];
    $family_name=$_POST["family_name"];
	$found = findfamily($family_id, $conn);
	
	if ($found)
	{
	 	try{
			$sql = "call GetFamilyNumberRows($family_id)";
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
       			 exit("Family does not exist");
				}
    	}	
	}else{
		exit("Family does not exist");
	}
}

function findFamily($family_id , $conn){
  $sql = "Call GetFamilyNumberRows($family_id)";
	$stmt = $conn->query($sql);	
	if ($stmt->rowCount() > 0)
	{
		return true;
	}
	else
	{
		return false;
	}
}

?>
