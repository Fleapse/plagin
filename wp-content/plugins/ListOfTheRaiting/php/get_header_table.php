<?php

include_once '../connect.php';


//Получение данных уроков из базы, для шапки таблицы

$result = $wpdb->dbh->query("SELECT * FROM `lotr_lesson_name`");
if($result->num_rows > 0)
{
    $vivod=[];
    while ($po = $result->fetch_assoc())
    {
            array_push($vivod,$po['lesson_name']);
    }
}

echo json_encode($vivod,256|64);
?>