<?php
// session_start();
// if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
//   header("location: ../login.php");
//   exit;
// }else{
//   include "../database.php"; 
// }

include "../database.php";

function dbProcess($query, $conn, $myArray){
	try{
		$sql = "$query";
		$stmt = $conn->query($sql);
		$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
		if($data){
			foreach($data as $row)
			{	
				array_push($myArray, $row);
			}
			return $myArray;
		}	
	}catch(PDOException $e){
		$errorCode = $e->getMessage();
			exit(json_encode($errorCode));
	}
}

?>
