<?php

  include "../database.php"; 


function rowCheck($query, $conn){
			$ctr = 0;
            $sql= $query;
			$stmt = $conn->query($sql);
			$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if ($data){
				foreach($data as $row)
					{
						$ctr = ($row["count(*)"]);
					}
                    return $ctr;
        			}
			return $ctr;
}

function checkStaffLimit($num){
	if($num<4){
		return true;
	}else{
		return false;
	}
}



?>
