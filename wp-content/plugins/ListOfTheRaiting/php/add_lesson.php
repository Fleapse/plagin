<?php
include_once '../connect.php';

// print_r($wpdb->dbh); 
if(!empty($_POST['lesson_name'])) 
{ 
	$sql="SELECT * FROM `lotr_lesson_name` WHERE `lesson_name`='{$_POST['lesson_name']}'";
	
	$result=$wpdb->dbh->query($sql); 
	if($result->num_rows===0) 
	{ 
		$sql="INSERT INTO `lotr_lesson_name`(`lesson_name`) VALUES ('{$_POST['lesson_name']}')"; 
		$wpdb->dbh->query($sql); 
		echo json_encode(true);
	} 
	else
	{
		echo json_encode(false);
	}
}
?> 