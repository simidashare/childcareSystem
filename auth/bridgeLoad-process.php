<?php
session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
  header("location: ../login.php"); 
  exit;
}else{
  include "../database.php";
}

$myArray = array();

if (isset($_GET["loadChild"]) && $_GET["loadChild"] == "1")
{
	$sql = "select child_id , concat(' ', child_fname, ' ' ,child_lname, ' ') as child_name from child";
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

if (isset($_GET["loadStaff"]) && $_GET["loadStaff"] == "1")
{
	$sql = "select staff_id, concat(' ', staff_fname, ' ' ,staff_lname, ' ') as staff_name from staff";
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


if (isset($_GET["loadAllergy"]) && $_GET["loadAllergy"] == "1")
{
	$sql = "select alle_code, alle_description from allergy";
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

if (isset($_GET["loadGuardian"]) && $_GET["loadGuardian"] == "1")
{
	$sql = "select guardian_id, concat(guardian_fname,' ',guardian_lname) as guardian_name from guardian";
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


if (isset($_GET["loadFamily"]) && $_GET["loadFamily"] == "1")
{
	$sql = "select family_id, family_name from family";
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

if (isset($_GET["loadDoctor"]) && $_GET["loadDoctor"] == "1")
{
	$sql = "select doc_id, concat(doc_fname,' ',doc_lname) as doc_name from doctor";
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


if (isset($_GET["loadMedicine"]) && $_GET["loadMedicine"] == "1")
{
	$sql = "select med_id, med_name from medicine";
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


if (isset($_GET["loadEnrolment"]) && $_GET["loadEnrolment"] == "1")
{
	$sql = "select enrolment_id , child_id as cid from enrolment where enrolment_status = 'Y'";//only enroled can proceed to payment
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
// - Child ID(${e.child_id})
?>
