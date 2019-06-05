<?php
include_once '../connect.php';

// При пост запросе с передачей параметра специальности номер и специльаности имя, я провереяю на существование такого номера
// специальности , и если такой не существует то добавляю

if(!empty($_POST)) 
{ 
	$sql="SELECT * FROM `lotr_specialty` WHERE `name`='{$_POST['specialty_name']}' AND `number`='{$_POST['specialty_number']}'";
	
	$result=$wpdb->dbh->query($sql); 
	if($result->num_rows===0) 
	{ 
		$sql="INSERT INTO `lotr_specialty`( `name`, `number`, `age`, `duration`,`count_place`) VALUES ('{$_POST['specialty_name']}','{$_POST['specialty_number']}','{$_POST['specialty_age']}','{$_POST['specialty_duration']}','{$_POST['specialty_count_place']}')"; 
		$wpdb->dbh->query($sql); 
		echo json_encode(true);
	} 
	else
	{
		echo json_encode(false);
	}
}
?> 