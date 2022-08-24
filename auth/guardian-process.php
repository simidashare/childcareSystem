<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
  header("location: ../login.php");
  exit;
}else{
  include "../database.php"; 
}

$myArray = array();

if (isset($_GET["viewall"]) && $_GET["viewall"] == "1")
{
	
  $sql = "select g.guardian_id, g.guardian_fname, g.guardian_lname, g.guardian_address, g.guardian_phone, f.family_id,f.family_name from guardian as g join family as f on g.family_id= f.family_id";
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
else	
if (isset($_GET["search"]) && $_GET["search"] == "1")
{
	$guardianid=$_GET["guardian_id"];
  $sql= "select g.guardian_id, g.guardian_fname, g.guardian_lname, g.guardian_address, g.guardian_phone, f.family_id, f.family_name  from guardian as g join family as f on g.family_id = f.family_id where g.guardian_id = $guardianid";

	$stmt = $conn->query($sql);
	$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach($data as $row)
	{
    array_push($myArray, $row);
	}
	exit(json_encode($myArray));	
}
else	
if (isset($_GET["add"]) && $_GET["add"] == "1")
{
	$guardian_fname=$_POST["guardian_fname"];
	$guardian_lname=$_POST["guardian_lname"];
	$guardian_address=$_POST["guardian_address"];
	$guardian_phone=$_POST["guardian_phone"];	
    $family_id=$_POST["family_id"];	
  try{
    $sql = "insert into guardian values (guardian_id, '$guardian_fname', '$guardian_lname', '$guardian_address','$guardian_phone',$family_id)";
    $stmt = $conn->query($sql);	
    if ($stmt)
    {	
      exit("Guardian added successfully");
    }
  }catch(PDOException  $e){
    if($e->getCode() === '23000');  {
      exit("Family does not exist");
    }

  }
}
else	
if (isset($_GET["remove"]) && $_GET["remove"] == "1")
{
	$guardianid=$_GET["guardian_id"];
	$found = Findguardian($guardianid, $conn);
	if ($found)
	{
		try
		{
			$sql = "delete from guardian where guardian_id = $guardianid";
			$stmt = $conn->query($sql);
			if ($stmt)
			{
				exit("Guardian deleted successfully");
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
		exit("This guardian does not exist");
	}
}

else	
if (isset($_GET["update"]) && $_GET["update"] == "1")
{
	$guardianid=$_POST["guardian_id"];
	$found = Findguardian($guardianid, $conn);
	if ($found)
	{
		$guardian_fname=$_POST["guardian_fname"];
		$guardian_lname=$_POST["guardian_lname"];
		$guardian_address=$_POST["guardian_address"];
		$guardian_phone=$_POST["guardian_phone"];	
    $family_id=$_POST["family_id"];		
    try{
      $sql = "update guardian set guardian_fname = '$guardian_fname',guardian_lname = '$guardian_lname' , guardian_address ='$guardian_address', guardian_phone = '$guardian_phone',family_id = $family_id where guardian_id =  $guardianid";
      $stmt = $conn->query($sql);
      if ($stmt)
      {
        exit("Guardian updated successfully");
      }
    }catch(PDOException $e){
      if($e->getCode() === "23000"){
        exit("Family does not exist");
      }
    }	
	}else{
		exit("This guardian does not exist");
	}
}
function Findguardian($gid, $conn)
{	
	$sql = "select * from guardian where guardian_id = $gid";
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
